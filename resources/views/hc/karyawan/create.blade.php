@extends('adminlte::page')

@section('title', 'Tambah Karyawan')

@section('content_header')
    <h1>Tambah Akun & Data Karyawan</h1>
@stop

@section('content')
<div class="card">
    {{-- PENTING: enctype ditambahkan untuk handle file upload --}}
    <form action="{{ route('hc.karyawan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Formulir Karyawan Baru</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- BAGIAN 1: DATA AKUN LOGIN --}}
            <h5 class="mt-2">Data Akun Login</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Login <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Login <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Role --</option>
                            <option value="direksi" {{ old('role') == 'direksi' ? 'selected' : '' }}>Direksi</option>
                            <option value="manajer" {{ old('role') == 'manajer' ? 'selected' : '' }}>Manajer</option>
                            <option value="staf_bisnis" {{ old('role') == 'staf_bisnis' ? 'selected' : '' }}>Staf Bisnis</option>
                            <option value="staf_support" {{ old('role') == 'staf_support' ? 'selected' : '' }}>Staf Support</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: DATA DETAIL KARYAWAN --}}
            <h5 class="mt-4">Data Detail Karyawan</h5>
            <hr>
            <div class="row">
                <div class="col-md-6"><div class="form-group"><label for="full_name">Nama Lengkap <span class="text-danger">*</span></label><input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="form-control" required></div></div>
                <div class="col-md-6"><div class="form-group"><label for="email_employee">Email Karyawan <span class="text-danger">*</span></label><input type="email" name="email_employee" id="email_employee" value="{{ old('email_employee') }}" class="form-control" required></div></div>
                <div class="col-md-6"><div class="form-group"><label for="nik">NIK <span class="text-danger">*</span></label><input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="form-control" required></div></div>
                <div class="col-md-6"><div class="form-group"><label for="npwp">NPWP</label><input type="text" name="npwp" id="npwp" value="{{ old('npwp') }}" class="form-control"></div></div>
                <div class="col-md-6"><div class="form-group"><label for="phone_number">Nomor Telepon <span class="text-danger">*</span></label><input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-control" required></div></div>
                <div class="col-md-6"><div class="form-group"><label for="gender">Jenis Kelamin <span class="text-danger">*</span></label><select name="gender" id="gender" class="form-control" required><option value="" disabled selected>-- Pilih --</option><option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option><option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option></select></div></div>
                <div class="col-md-6"><div class="form-group"><label for="birth_place">Tempat Lahir</label><input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place') }}" class="form-control"></div></div>
                <div class="col-md-6"><div class="form-group"><label for="birth_date">Tanggal Lahir</label><input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" class="form-control"></div></div>
                <div class="col-md-6"><div class="form-group"><label for="age">Umur</label><input type="number" name="age" id="age" value="{{ old('age') }}" class="form-control"></div></div>
                <div class="col-md-6"><div class="form-group"><label for="marital_status">Status Perkawinan <span class="text-danger">*</span></label><select name="marital_status" id="marital_status" class="form-control" required><option value="" disabled selected>-- Pilih --</option><option value="TK" {{ old('marital_status') == 'TK' ? 'selected' : '' }}>Tidak Kawin</option><option value="K0" {{ old('marital_status') == 'K0' ? 'selected' : '' }}>Kawin (Tanpa Tanggungan)</option><option value="K1" {{ old('marital_status') == 'K1' ? 'selected' : '' }}>Kawin (1 Tanggungan)</option><option value="K2" {{ old('marital_status') == 'K2' ? 'selected' : '' }}>Kawin (2 Tanggungan)</option><option value="K3" {{ old('marital_status') == 'K3' ? 'selected' : '' }}>Kawin (3 Tanggungan)</option></select></div></div>
                <div class="col-md-6"><div class="form-group"><label for="ktp_address">Alamat KTP</label><textarea name="ktp_address" id="ktp_address" class="form-control" rows="2">{{ old('ktp_address') }}</textarea></div></div>
                <div class="col-md-6"><div class="form-group"><label for="current_address">Alamat Domisili</label><textarea name="current_address" id="current_address" class="form-control" rows="2">{{ old('current_address') }}</textarea></div></div>
                <div class="col-md-6"><div class="form-group"><label for="city">Kota Domisili</label><input type="text" name="city" id="city" value="{{ old('city') }}" class="form-control"></div></div>
                <div class="col-md-6"><div class="form-group"><label for="province">Provinsi Domisili</label><input type="text" name="province" id="province" value="{{ old('province') }}" class="form-control"></div></div>
                <div class="col-md-6"><div class="form-group"><label for="status">Status Karyawan <span class="text-danger">*</span></label><select name="status" id="status" class="form-control" required><option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option><option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option></select></div></div>
                <div class="col-md-6"><div class="form-group"><label for="hire_date">Tanggal Masuk <span class="text-danger">*</span></label><input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date') }}" class="form-control" required></div></div>
                <div class="col-md-6"><div class="form-group"><label for="division_id">Divisi</label><select name="division_id" id="division_id" class="form-control"><option value="">-- Pilih Divisi --</option>@foreach($divisions as $division)<option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>@endforeach</select></div></div>
                <div class="col-md-6"><div class="form-group"><label for="position_id">Posisi/Jabatan</label><select name="position_id" id="position_id" class="form-control"><option value="">-- Pilih Posisi --</option>@foreach($positions as $position)<option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>@endforeach</select></div></div>
                <div class="col-md-6"><div class="form-group"><label for="cv_file">File CV</label><input type="file" name="cv_file" id="cv_file" class="form-control-file"><small class="form-text text-muted">(Tipe: PDF, DOC, DOCX. Maks: 2MB)</small></div></div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('hc.karyawan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@stop