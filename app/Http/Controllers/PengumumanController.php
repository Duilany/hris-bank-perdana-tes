<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\Polling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->get();
        return view('pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tipe' => 'required|in:teks,polling',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'batas_waktu' => 'nullable|date|after:now',
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('pengumuman', $attachmentPath, 'public');
        }

        $pengumuman = Pengumuman::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tipe' => $request->tipe,
            'attachment' => $attachmentPath,
            'label'      => $request->label,
        ]);

        if ($request->tipe === 'polling' && $request->has('options')) {
            $polling = $pengumuman->polling()->create([
                'batas_waktu' => $request->batas_waktu,
            ]);

            foreach ($request->options as $option) {
                if (trim($option) !== '') {
                    $polling->options()->create(['option_text' => $option]);
                }
            }
        }

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dibuat');
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::with('polling.options')->findOrFail($id);
    
        $now = now();
        $batasWaktu = optional($pengumuman->polling)->batas_waktu;
        $isExpired = $batasWaktu && $now->greaterThan($batasWaktu);
    
        return view('pengumuman.show', compact('pengumuman', 'isExpired'));
    }    

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
        'tipe' => 'required|in:teks,polling',
        'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'batas_waktu' => 'nullable|date|after:now',
        'label' => 'nullable|string|max:50',
    ]);

    $pengumuman = Pengumuman::findOrFail($id);

    // Upload lampiran baru jika ada
    if ($request->hasFile('attachment')) {
        if ($pengumuman->attachment && Storage::exists('public/pengumuman/' . $pengumuman->attachment)) {
            Storage::delete('public/pengumuman/' . $pengumuman->attachment);
        }

        $file = $request->file('attachment');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('pengumuman', $filename, 'public');
        $pengumuman->attachment = $filename;
    }

    // Update data utama
    $pengumuman->judul = $request->judul;
    $pengumuman->isi = $request->isi;
    $pengumuman->tipe = $request->tipe;
    $pengumuman->label = $request->label; // Tambahkan label jika ada
    $pengumuman->save();

    if ($pengumuman->tipe === 'polling' && $pengumuman->polling) {
        $polling = $pengumuman->polling;
        $isExpired = $polling->batas_waktu && now()->gt($polling->batas_waktu);
        $hasVotes = $polling->options()->withCount('votes')->get()->sum('votes_count') > 0;
    
        // Jika polling sudah kadaluarsa atau ada suara, tolak perubahan polling
        if ($isExpired || $hasVotes) {
            return redirect()->route('pengumuman.index')
                ->with('error', 'Polling tidak dapat diubah karena sudah ada suara atau melewati batas waktu.');
        }
    
        // Jika belum kadaluarsa dan belum ada suara, lanjutkan edit polling
        $polling->batas_waktu = $request->batas_waktu;
        $polling->save();
    
        // Update opsi polling yang sudah ada
        if ($request->has('existing_options')) {
            foreach ($request->existing_options as $optionId => $optionText) {
                $option = $polling->options()->find($optionId);
                if ($option) {
                    $option->option_text = $optionText;
                    $option->save();
                }
            }
        }
    
        // Hapus opsi polling yang dicentang
        if ($request->has('delete_options')) {
            foreach ($request->delete_options as $deleteId) {
                $optionToDelete = $polling->options()->find($deleteId);
                if ($optionToDelete) {
                    $optionToDelete->votes()->delete(); // Hapus suara jika perlu
                    $optionToDelete->delete();
                }
            }
        }
    
        // Tambah opsi polling baru
        if ($request->has('options')) {
            foreach ($request->options as $newOptionText) {
                if (trim($newOptionText) !== '') {
                    $polling->options()->create([
                        'option_text' => $newOptionText
                    ]);
                }
            }
        }
    }    

    return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
}

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }
}
