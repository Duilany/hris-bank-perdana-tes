@extends('adminlte::page')
@section('title', 'Edit Data Pegawai')
@section('content_header')
    <h1>Edit Data Pegawai</h1>
@endsection

@section('content')
<form action="{{ route('hc.karyawan.update_detail', $user->id) }}" method="POST">
    @csrf @method('PUT')

    <h4>Data Pegawai</h4>
    <div class="form-group">
        <label>NIP</label>
        <input type="text" name="nip" value="{{ old('nip', $user->employee->nip ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Divisi</label>
        <input type="text" name="divisi" value="{{ old('divisi', $user->employee->divisi ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Jabatan</label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $user->employee->jabatan ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Aktif" {{ old('status', $user->employee->status ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Tidak Aktif" {{ old('status', $user->employee->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
    <div class="form-group">
        <label>Tanggal Masuk</label>
        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $user->employee->tanggal_masuk ?? '') }}" class="form-control">
    </div>

    <hr><h4>Data Pribadi</h4>
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->employee->detail->nama_lengkap ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>NIK</label>
        <input type="text" name="nik" value="{{ old('nik', $user->employee->detail->nik ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->employee->detail->tempat_lahir ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->employee->detail->tanggal_lahir ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control">{{ old('alamat', $user->employee->detail->alamat ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label>No HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $user->employee->detail->no_hp ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-control">
            <option value="">- Pilih -</option>
            <option value="Laki-laki" {{ old('jenis_kelamin', $user->employee->detail->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin', $user->employee->detail->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div class="form-group">
        <label>Agama</label>
        <input type="text" name="agama" value="{{ old('agama', $user->employee->detail->agama ?? '') }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Status Perkawinan</label>
        <input type="text" name="status_perkawinan" value="{{ old('status_perkawinan', $user->employee->detail->status_perkawinan ?? '') }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('hc.karyawan.show', $user->id) }}" class="btn btn-secondary">Kembali Tanpa Menyimpan</a>
</form>
@endsection
