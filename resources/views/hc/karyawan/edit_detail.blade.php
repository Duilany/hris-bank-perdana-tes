@extends('adminlte::page')

@section('title', 'Edit Data Karyawan')

@section('content_header')
    {{-- Menggunakan operator nullsafe (?->) untuk mencegah error jika $user->employee null --}}
    <h1>Edit Data Karyawan: {{ $user->employee?->full_name ?? $user->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('hc.karyawan.update_detail', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p class="font-weight-bold">Terdapat kesalahan pada input Anda:</p>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                {{-- BAGIAN 1: DATA PRIBADI --}}
                <div class="col-12">
                    <h5 class="mt-2">Data Pribadi</h5>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
                        {{-- Menerapkan ?-> di semua value --}}
                        <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $user->employee?->full_name ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nik">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $user->employee?->nik ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" name="npwp" id="npwp" class="form-control" value="{{ old('npwp', $user->employee?->npwp ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Karyawan <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->employee?->email ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $user->employee?->phone_number ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="L" {{ old('gender', $user->employee?->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $user->employee?->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_place">Tempat Lahir</label>
                        <input type="text" name="birth_place" id="birth_place" class="form-control" value="{{ old('birth_place', $user->employee?->birth_place ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_date">Tanggal Lahir</label>
                        {{-- Mengamankan pemanggilan format() dengan ?-> juga --}}
                        <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $user->employee?->birth_date?->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="age">Umur</label>
                        <input type="number" name="age" id="age" class="form-control" value="{{ old('age', $user->employee?->age ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="marital_status">Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="marital_status" id="marital_status" class="form-control" required>
                            <option value="TK" {{ old('marital_status', $user->employee?->marital_status ?? '') == 'TK' ? 'selected' : '' }}>Tidak Kawin</option>
                            <option value="K0" {{ old('marital_status', $user->employee?->marital_status ?? '') == 'K0' ? 'selected' : '' }}>Kawin (Tanpa Tanggungan)</option>
                            <option value="K1" {{ old('marital_status', $user->employee?->marital_status ?? '') == 'K1' ? 'selected' : '' }}>Kawin (1 Tanggungan)</option>
                            <option value="K2" {{ old('marital_status', $user->employee?->marital_status ?? '') == 'K2' ? 'selected' : '' }}>Kawin (2 Tanggungan)</option>
                            <option value="K3" {{ old('marital_status', $user->employee?->marital_status ?? '') == 'K3' ? 'selected' : '' }}>Kawin (3 Tanggungan)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ktp_address">Alamat KTP</label>
                        <textarea name="ktp_address" id="ktp_address" class="form-control" rows="2">{{ old('ktp_address', $user->employee?->ktp_address ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="current_address">Alamat Domisili</label>
                        <textarea name="current_address" id="current_address" class="form-control" rows="2">{{ old('current_address', $user->employee?->current_address ?? '') }}</textarea>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="city">Kota Domisili</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->employee?->city ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="province">Provinsi Domisili</label>
                        <input type="text" name="province" id="province" class="form-control" value="{{ old('province', $user->employee?->province ?? '') }}">
                    </div>
                </div>

                {{-- BAGIAN 2: DATA PEKERJAAN --}}
                <div class="col-12">
                    <h5 class="mt-4">Data Pekerjaan</h5>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status Karyawan <span class="text-danger">*</span></label>
                         <select name="status" id="status" class="form-control" required>
                            <option value="Aktif" {{ old('status', $user->employee?->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $user->employee?->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hire_date">Tanggal Masuk</label>
                        <input type="date" name="hire_date" id="hire_date" class="form-control" value="{{ old('hire_date', $user->employee?->hire_date?->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="separation_date">Tanggal Keluar</label>
                        <input type="date" name="separation_date" id="separation_date" class="form-control" value="{{ old('separation_date', $user->employee?->separation_date?->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                        <label for="division_id">Divisi</label>
                        <select name="division_id" id="division_id" class="form-control">
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id', $user->employee?->division_id ?? '') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="position_id">Posisi/Jabatan</label>
                        <select name="position_id" id="position_id" class="form-control">
                            <option value="">-- Pilih Posisi --</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id', $user->employee?->position_id ?? '') == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cv_file">Ubah File CV</label>
                        <input type="file" name="cv_file" id="cv_file" class="form-control-file">
                        @if($user->employee?->cv_file)
                        <p class="mt-2 text-sm">
                            <i class="fas fa-file-alt"></i> File saat ini: 
                            <a href="{{ asset('storage/' . $user->employee->cv_file) }}" target="_blank">Lihat CV</a>
                        </p>
                        @endif
                        <small class="form-text text-muted">Hanya unggah jika ingin mengubah file CV. (Tipe: PDF, DOC, DOCX. Maks: 2MB)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('hc.karyawan.show', $user->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@stop
