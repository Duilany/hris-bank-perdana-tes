@extends('adminlte::page')
@section('active_menu', 'pengumuman')

@section('title', 'Tambah Pengumuman')

@section('content_header')
    <h1>Tambah Pengumuman</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('pengumuman.store') }}">
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

        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
@stop
