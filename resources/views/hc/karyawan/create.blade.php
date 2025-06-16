@extends('adminlte::page')

@section('title', 'Tambah Karyawan')

@section('content_header')
    <h1>Tambah Akun Karyawan</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('hc.karyawan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="direksi" {{ old('role') == 'direksi' ? 'selected' : '' }}>Direksi</option>
                        <option value="manajer" {{ old('role') == 'manajer' ? 'selected' : '' }}>Manajer</option>
                        <option value="staf_bisnis" {{ old('role') == 'staf_bisnis' ? 'selected' : '' }}>Staf Bisnis</option>
                        <option value="staf_support" {{ old('role') == 'staf_support' ? 'selected' : '' }}>Staf Support</option>
                    </select>
                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('hc.karyawan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Tambahan CSS jika perlu --}}
@stop

@section('js')
    {{-- Tambahan JS jika perlu --}}
@stop
