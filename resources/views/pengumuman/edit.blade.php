@extends('adminlte::page')
@section('active_menu', 'pengumuman')

@section('title', 'Edit Pengumuman')

@section('content_header')
    <h1>Edit Pengumuman</h1>
@stop

@section('content')
    @php
        $polling = $pengumuman->polling;
        $isPolling = $pengumuman->tipe === 'polling';
        $isExpired = $isPolling && $polling && $polling->batas_waktu && now()->gt($polling->batas_waktu);
        $hasVotes = $isPolling && $polling && $polling->options->sum(fn($opt) => $opt->votes->count()) > 0;
        $disablePollingEdit = $isExpired || $hasVotes;
    @endphp

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="tipe">Tipe</label>
            <select name="tipe" id="tipe" class="form-control" required disabled>
                <option value="teks" {{ $pengumuman->tipe == 'teks' ? 'selected' : '' }}>Teks</option>
                <option value="polling" {{ $pengumuman->tipe == 'polling' ? 'selected' : '' }}>Polling</option>
            </select>
            <input type="hidden" name="tipe" value="{{ $pengumuman->tipe }}"> {{-- biar tetap dikirim --}}
        </div>
        
        <div class="form-group mt-3">
  <label for="label">Label Pengumuman</label>
  <select name="label" id="label" class="form-control">
    <option value="" {{ $pengumuman->label===null ? 'selected' : '' }}>Umum</option>
    <option value="HR" {{ $pengumuman->label==='HR'? 'selected':'' }}>HR</option>
    <option value="IT" {{ $pengumuman->label==='IT'? 'selected':'' }}>IT</option>
    <option value="Marketing" {{ $pengumuman->label==='Marketing'? 'selected':'' }}>Marketing</option>
  </select>
</div>

        <div class="form-group mt-3">
            <label for="isi">Isi</label>
            <textarea name="isi" id="isi" class="form-control" rows="5" required>{{ old('isi', $pengumuman->isi) }}</textarea>
        </div>

        @if ($isPolling)
            <div class="form-group mt-3">
                <label for="batas_waktu">Batas Waktu Polling</label>
                <input type="datetime-local" name="batas_waktu" id="batas_waktu" class="form-control"
                    value="{{ old('batas_waktu', optional($polling->batas_waktu)->format('Y-m-d\TH:i')) }}"
                    {{ $disablePollingEdit ? 'disabled' : '' }}>
                @if ($disablePollingEdit)
                    <small class="text-danger">Batas waktu tidak bisa diubah karena polling sudah kadaluarsa atau memiliki suara.</small>
                @endif
            </div>

            <div class="form-group mt-3">
                <label>Opsi Polling</label>

                {{-- Opsi lama --}}
                @foreach ($polling->options as $option)
                    <div class="input-group mb-2">
                        <input type="text" name="existing_options[{{ $option->id }}]" value="{{ $option->option_text }}"
                            class="form-control" {{ $disablePollingEdit ? 'readonly' : '' }}>
                        @if (!$disablePollingEdit)
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <input type="checkbox" name="delete_options[]" value="{{ $option->id }}">
                                    <span class="ms-1">Hapus</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Tambah opsi baru --}}
                @if (!$disablePollingEdit)
                    <div id="polling-options">
                        <input type="text" name="options[]" class="form-control mb-2" placeholder="Tambah opsi baru">
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary mb-2" onclick="addOption()">+ Tambah Opsi</button>
                @endif

                @if ($disablePollingEdit)
                    <small class="text-muted">Opsi tidak dapat diubah karena polling sudah berakhir atau memiliki suara.</small>
                @endif
            </div>
        @endif

        <div class="form-group mt-3">
            <label for="attachment">Ubah Lampiran (PDF/Gambar)</label>
            <input type="file" name="attachment" class="form-control" accept=".pdf,image/*">
            @if ($pengumuman->attachment)
                <p class="mt-2">Lampiran saat ini: <a href="{{ asset('storage/pengumuman/' . $pengumuman->attachment) }}" target="_blank">Lihat File</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary mt-4">Batal</a>
    </form>

    <script>
        function addOption() {
            const container = document.getElementById('polling-options');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'options[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Tambah opsi baru';
            container.appendChild(input);
        }
    </script>
@stop
