@extends('adminlte::page')
@section('title', 'Detail Karyawan')
@section('content_header')
    <h1>Detail Karyawan</h1>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<h4>Data Akun</h4>
<ul>
    <li><strong>Nama:</strong> {{ $user->name }}</li>
    <li><strong>Email:</strong> {{ $user->email }}</li>
    <li><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', $user->role)) }}</li>
</ul>

<hr>
<h4>Data Pegawai</h4>
<ul>
    <li><strong>NIP:</strong> {{ $user->employee->nip ?? '-' }}</li>
    <li><strong>Divisi:</strong> {{ $user->employee->divisi ?? '-' }}</li>
    <li><strong>Jabatan:</strong> {{ $user->employee->jabatan ?? '-' }}</li>
    <li><strong>Status:</strong> {{ $user->employee->status ?? '-' }}</li>
    <li><strong>Tanggal Masuk:</strong> {{ $user->employee->tanggal_masuk }}</li>
</ul>

<hr>
<h4>Data Pribadi</h4>
<ul>
    <li><strong>Nama Lengkap:</strong> {{ $user->employee->detail->nama_lengkap ?? '-' }}</li>
    <li><strong>NIK:</strong> {{ $user->employee->detail->nik ?? '-' }}</li>
    <li><strong>Tempat, Tanggal Lahir:</strong> {{ $user->employee->detail->tempat_lahir ?? '-' }},
        {{ $user->employee->detail->tanggal_lahir ?? '-' }}</li>
    <li><strong>Alamat:</strong> {{ $user->employee->detail->alamat ?? '-' }}</li>
    <li><strong>No HP:</strong> {{ $user->employee->detail->no_hp ?? '-' }}</li>
    <li><strong>Jenis Kelamin:</strong> {{ $user->employee->detail->jenis_kelamin ?? '-' }}</li>
    <li><strong>Agama:</strong> {{ $user->employee->detail->agama ?? '-' }}</li>
    <li><strong>Status Perkawinan:</strong> {{ $user->employee->detail->status_perkawinan ?? '-' }}</li>
</ul>

<a href="{{ route('hc.karyawan.edit_detail', $user->id) }}" class="btn btn-primary">Edit Data Pegawai</a>
<a href="{{ route('hc.karyawan.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
