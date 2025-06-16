@extends('adminlte::page')
@section('active_menu', 'pengumuman')

@section('title', 'Edit Pengumuman')

@section('content_header')
    <h1>Edit Pengumuman</h1>
@stop

@section('content')
    <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="tipe">Tipe</label>
            <select name="tipe" id="tipe" class="form-control" required>
                <option value="teks" {{ $pengumuman->tipe == 'teks' ? 'selected' : '' }}>Teks</option>
                <option value="polling" {{ $pengumuman->tipe == 'polling' ? 'selected' : '' }}>Polling</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="isi">Isi</label>
            <textarea name="isi" id="isi" class="form-control" rows="5" required>{{ old('isi', $pengumuman->isi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary mt-4">Batal</a>
    </form>
@stop
