@extends('adminlte::page')

@section('title', 'Edit Karyawan')

@section('content_header')
    <h1>Edit Akun Karyawan</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('hc.karyawan.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="password">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="direksi" {{ $user->role == 'direksi' ? 'selected' : '' }}>Direksi</option>
                        <option value="manajer" {{ $user->role == 'manajer' ? 'selected' : '' }}>Manajer</option>
                        <option value="staf_bisnis" {{ $user->role == 'staf_bisnis' ? 'selected' : '' }}>Staf Bisnis</option>
                        <option value="staf_support" {{ $user->role == 'staf_support' ? 'selected' : '' }}>Staf Support</option>
                    </select>
                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
