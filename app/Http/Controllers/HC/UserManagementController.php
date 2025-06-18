<?php

namespace App\Http\Controllers\HC;

use App\Http\Controllers\Controller;
use App\Models\divisions;
use App\Models\User;
use App\Models\Employee;
use App\Models\positions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Disarankan untuk logging error

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan (user selain HC).
     */
    public function index()
    {
        $users = User::where('role', '!=', 'hc')->with('employee')->latest()->get();
        return view('hc.karyawan.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat akun karyawan baru.
     * Diperbaiki untuk mengirim data divisions dan positions.
     */
    public function create()
    {
        // Mengambil data untuk dropdown di form
        $divisions = divisions::all();
        $positions = positions::all();
        
        return view('hc.karyawan.create', compact('divisions', 'positions'));
    }

    /**
     * Menyimpan data karyawan dan akun user baru.
     * Disesuaikan sepenuhnya dengan model Employee dan menangani file upload.
     */
    public function store(Request $request)
    {
        // Validasi lengkap untuk semua kolom dari model Employee
        $request->validate([
            // --- Data User ---
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6',
            'role'          => 'required|in:direksi,manajer,staf_bisnis,staf_support',

            // --- Data Employee ---
            'full_name'       => 'required|string|max:100',
            'nik'             => 'required|string|max:20|unique:employees,nik',
            'npwp'            => 'nullable|string|max:25|unique:employees,npwp',
            'email_employee'  => 'required|email|max:100|unique:employees,email',
            'phone_number'    => 'required|string|max:20',
            'gender'          => 'required|in:L,P',
            'birth_place'     => 'nullable|string|max:50',
            'birth_date'      => 'nullable|date',
            'age'             => 'nullable|integer',
            'marital_status'  => 'required|in:TK,K0,K1,K2,K3',
            'ktp_address'     => 'nullable|string',
            'current_address' => 'nullable|string',
            'city'            => 'nullable|string|max:50',
            'province'        => 'nullable|string|max:50',
            'status'          => 'required|in:Aktif,Tidak Aktif',
            'hire_date'       => 'required|date',
            'cv_file'         => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi file
            'division_id'     => 'nullable|integer|exists:divisions,id',
            'position_id'     => 'nullable|integer|exists:positions,id',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat data User
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            // 2. Siapkan data Employee dari request
            $employeeData = $request->except(['_token', '_method', 'name', 'password', 'role', 'cv_file', 'email_employee']);
            $employeeData['email'] = $request->email_employee; // Mapping email karyawan

            // 3. Handle file upload CV jika ada
            if ($request->hasFile('cv_file')) {
                $path = $request->file('cv_file')->store('cv_files', 'public');
                $employeeData['cv_file'] = $path;
            }

            // 4. Buat data Employee yang terhubung dengan User
            $user->employee()->create($employeeData);
            
            DB::commit();

            return redirect()->route('hc.karyawan.index')->with('success', 'Akun dan data karyawan berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat karyawan baru: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat data. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Menampilkan detail lengkap seorang karyawan.
     */
    public function show($id)
    {
        $user = User::with(['employee.division', 'employee.position'])->findOrFail($id);
        return view('hc.karyawan.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit akun user (login).
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('hc.karyawan.edit', compact('user'));
    }

    /**
     * Memperbarui data akun user (login).
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name'     => 'required|string|max:255',
            'role'     => 'required|in:direksi,manajer,staf_bisnis,staf_support',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
        ]);
        $user->update($request->only(['name', 'role', 'email']));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        return redirect()->route('hc.karyawan.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Menampilkan form untuk mengedit data detail karyawan.
     * Sekarang mengirimkan data divisions dan positions ke view.
     */
    public function editDetail($id)
    {
        $user = User::with('employee')->findOrFail($id);
        
        // Mengambil data untuk dropdown
        $divisions = divisions::all();
        $positions = positions::all();

        return view('hc.karyawan.edit_detail', compact('user', 'divisions', 'positions'));
    }

    /**
     * Memperbarui data detail karyawan.
     * Disesuaikan dengan semua field dan logika upload file.
     */
    public function updateDetail(Request $request, $id)
    {
        $user = User::with('employee')->findOrFail($id);
        $employee = $user->employee;
        $employeeId = $employee->id ?? null;

        // Validasi disesuaikan dengan semua field di model Employee
        $request->validate([
            'full_name'       => 'required|string|max:100',
            'nik'             => ['required', 'string', 'max:20', Rule::unique('employees')->ignore($employeeId)],
            'npwp'            => ['nullable', 'string', 'max:25', Rule::unique('employees')->ignore($employeeId)],
            'gender'          => 'required|in:L,P',
            'birth_place'     => 'nullable|string|max:50',
            'birth_date'      => 'nullable|date',
            'age'             => 'nullable|integer',
            'marital_status'  => 'required|in:TK,K0,K1,K2,K3',
            'ktp_address'     => 'nullable|string',
            'current_address' => 'nullable|string',
            'city'            => 'nullable|string|max:50',
            'province'        => 'nullable|string|max:50',
            'phone_number'    => 'nullable|string|max:20',
            'email'           => ['required', 'email', 'max:100', Rule::unique('employees', 'email')->ignore($employeeId)],
            'status'          => 'required|in:Aktif,Tidak Aktif',
            'hire_date'       => 'nullable|date',
            'separation_date' => 'nullable|date|after_or_equal:hire_date',
            'cv_file'         => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file upload (maks 2MB)
            'division_id'     => 'nullable|integer|exists:divisions,id',
            'position_id'     => 'nullable|integer|exists:positions,id',
        ]);
        
        // Menyiapkan data untuk update/create
        $data = $request->except('cv_file'); // Ambil semua input kecuali file

        // Logika untuk menangani file upload CV
        if ($request->hasFile('cv_file')) {
            // Hapus file CV lama jika ada
            if ($employee && $employee->cv_file) {
                Storage::disk('public')->delete($employee->cv_file);
            }
            
            // Simpan file baru dan dapatkan path-nya
            $path = $request->file('cv_file')->store('cv_files', 'public');
            $data['cv_file'] = $path;
        }

        // Menggunakan updateOrCreate untuk memperbarui data Employee
        $user->employee()->updateOrCreate(['user_id' => $user->id], $data);

        return redirect()->route('hc.karyawan.show', $user->id)->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus akun user beserta data karyawan terkait.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Dengan onDelete('cascade'), data employee terkait akan ikut terhapus.
        return redirect()->route('hc.karyawan.index')->with('success', 'Akun dan data karyawan berhasil dihapus.');
    }
}
