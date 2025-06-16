@extends('adminlte::page')
@section('title', 'Profil Saya')
@section('content_header')
    <h1>Profil Saya</h1>
@endsection

@section('content')
    <a href="{{ route('karyawan.profile.edit') }}" class="btn btn-primary mb-3">Edit Data Diri</a>
    <ul class="list-group">
        <li class="list-group-item">NIK: {{ $employee->detail->nik ?? '-' }}</li>
        <li class="list-group-item">Alamat: {{ $employee->detail->alamat ?? '-' }}</li>
        <li class="list-group-item">Tanggal Lahir: {{ $employee->detail->tanggal_lahir ?? '-' }}</li>
        <li class="list-group-item">Status Verifikasi: {{ ucfirst($employee->detail->status_verifikasi ?? 'Belum Diisi') }}</li>
    </ul>
@endsection
