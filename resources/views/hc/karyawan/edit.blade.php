@extends('adminlte::page')

@section('title', 'Edit Akun Karyawan')

@section('content_header')
    <h1>Edit Akun Login: {{ $user->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('hc.karyawan.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-header">
            <h3 class="card-title">Formulir Akun Login</h3>
        </div>
        <div class="card-body">
            {{-- Menampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Login <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Login <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="" disabled>-- Pilih Role --</option>
                            {{-- Menggunakan old() helper untuk menjaga nilai pilihan saat validasi gagal --}}
                            <option value="direksi" {{ old('role', $user->role) == 'direksi' ? 'selected' : '' }}>Direksi</option>
                            <option value="manajer" {{ old('role', $user->role) == 'manajer' ? 'selected' : '' }}>Manajer</option>
                            <option value="staf_bisnis" {{ old('role', $user->role) == 'staf_bisnis' ? 'selected' : '' }}>Staf Bisnis</option>
                            <option value="staf_support" {{ old('role', $user->role) == 'staf_support' ? 'selected' : '' }}>Staf Support</option>
                        </select>
                        @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                        <small class="form-text text-muted">Isi hanya jika Anda ingin mengubah password.</small>
                        @error('password') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('hc.karyawan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@stop

@section('css')
    {{-- Tambahan CSS jika perlu --}}
@stop

@section('js')
    {{-- Tambahan JS jika perlu --}}
@stop
