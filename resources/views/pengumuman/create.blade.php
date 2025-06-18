@extends('adminlte::page')
@section('active_menu', 'pengumuman')

@section('title', 'Tambah Pengumuman')

@section('content_header')
    <h1>Tambah Pengumuman</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('pengumuman.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label>Isi</label>
            <textarea name="isi" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group mt-3">
            <label>Tipe</label>
            <select name="tipe" class="form-control" required>
                <option value="teks">Teks</option>
                <option value="polling">Polling</option>
            </select>
        </div>

        <div class="form-group mt-3">
  <label>Label Pengumuman</label>
  <select name="label" class="form-control">
    <option value="" selected>Umum</option>
    <option value="HR">HR</option>
    <option value="IT">IT</option>
    <option value="Marketing">Marketing</option>
    <!-- Tambah opsi sesuai kebutuhan -->
  </select>
</div>

        <div class="form-group mt-3">
            <label>File Lampiran (PDF/Gambar)</label>
            <input type="file" name="attachment" class="form-control" accept=".pdf,image/*">
        </div>

        {{-- Bagian untuk polling --}}
        <div id="polling-options" style="display: none;" class="mt-3">
            <div class="form-group">
                <label>Opsi Polling</label>
                <div id="options-container">
                    <input type="text" name="options[]" class="form-control mb-2" placeholder="Opsi 1">
                </div>
                <button type="button" class="btn btn-sm btn-primary mb-2" id="add-option">Tambah Opsi</button>
            </div>

            <div class="form-group">
                <label>Batas Waktu Pengisian Polling</label>
                <input type="datetime-local" name="batas_waktu" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>

    {{-- Script --}}
    <script>
        document.querySelector('[name="tipe"]').addEventListener('change', function () {
            const pollingOptions = document.getElementById('polling-options');
            pollingOptions.style.display = this.value === 'polling' ? 'block' : 'none';
        });

        document.getElementById('add-option').addEventListener('click', function () {
            const container = document.getElementById('options-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'options[]';
            input.classList.add('form-control', 'mb-2');
            input.placeholder = 'Opsi tambahan';
            container.appendChild(input);
        });
    </script>
@stop
