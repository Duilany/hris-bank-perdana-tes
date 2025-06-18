@extends('adminlte::page')

@section('title', 'Detail Karyawan')

@section('content_header')
    {{-- Menggunakan data user untuk menampilkan nama di judul --}}
    <h1>Detail Karyawan: {{ $user->employee->full_name ?? $user->name }}</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    {{-- Kolom Kiri: Data Pekerjaan dan Akun --}}
    <div class="col-md-6">
        <!-- Card Data Pekerjaan -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-briefcase"></i> Data Pekerjaan</h3>
            </div>
            <div class="card-body">
                @if($user->employee)
                    <dl class="row">
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if($user->employee->status == 'Aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Divisi</dt>
                        <dd class="col-sm-8">{{ $user->employee->division->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Jabatan/Posisi</dt>
                        <dd class="col-sm-8">{{ $user->employee->position->name ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Tanggal Masuk</dt>
                        <dd class="col-sm-8">{{ optional($user->employee->hire_date)->format('d F Y') ?? '-' }}</dd>
                        
                        <dt class="col-sm-4">Tanggal Keluar</dt>
                        <dd class="col-sm-8">{{ optional($user->employee->separation_date)->format('d F Y') ?? '-' }}</dd>
                    </dl>
                @else
                    <p class="text-muted">Data pekerjaan tidak ditemukan.</p>
                @endif
            </div>
        </div>

        <!-- Card Data Akun -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-lock"></i> Data Akun Login</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Nama Login</dt>
                    <dd class="col-sm-8">{{ $user->name }}</dd>

                    <dt class="col-sm-4">Email Login</dt>
                    <dd class="col-sm-8">{{ $user->email }}</dd>

                    <dt class="col-sm-4">Role</dt>
                    <dd class="col-sm-8">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Data Pribadi --}}
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-id-card"></i> Data Pribadi</h3>
            </div>
            <div class="card-body">
                 @if($user->employee)
                    <dl class="row">
                        <dt class="col-sm-4">Nama Lengkap</dt>
                        <dd class="col-sm-8">{{ $user->employee->full_name ?? '-' }}</dd>

                        <dt class="col-sm-4">NIK</dt>
                        <dd class="col-sm-8">{{ $user->employee->nik ?? '-' }}</dd>

                        <dt class="col-sm-4">NPWP</dt>
                        <dd class="col-sm-8">{{ $user->employee->npwp ?? '-' }}</dd>

                        <dt class="col-sm-4">Jenis Kelamin</dt>
                        <dd class="col-sm-8">
                            @if($user->employee->gender == 'L') Laki-laki @elseif($user->employee->gender == 'P') Perempuan @else - @endif
                        </dd>

                        <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                        <dd class="col-sm-8">{{ $user->employee->birth_place ?? '-' }}, {{ optional($user->employee->birth_date)->format('d F Y') ?? '-' }}</dd>

                        <dt class="col-sm-4">Status Perkawinan</dt>
                        <dd class="col-sm-8">{{ $user->employee->marital_status ?? '-' }}</dd>

                        <dt class="col-sm-4">Alamat KTP</dt>
                        <dd class="col-sm-8">{{ $user->employee->ktp_address ?? '-' }}</dd>

                        <dt class="col-sm-4">Alamat Domisili</dt>
                        <dd class="col-sm-8">{{ $user->employee->current_address ?? '-' }}</dd>

                        <dt class="col-sm-4">No. Telepon</dt>
                        <dd class="col-sm-8">{{ $user->employee->phone_number ?? '-' }}</dd>

                        <dt class="col-sm-4">Email Karyawan</dt>
                        <dd class="col-sm-8">{{ $user->employee->email ?? '-' }}</dd>
                    </dl>
                 @else
                    <p class="text-muted">Data pribadi tidak ditemukan.</p>
                 @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-2">
    <a href="{{ route('hc.karyawan.edit_detail', $user->id) }}" class="btn btn-warning"><i class="fas fa-id-card"></i> Edit Data Karyawan</a>
    <a href="{{ route('hc.karyawan.edit', $user->id) }}" class="btn btn-primary"><i class="fas fa-user-edit"></i> Edit Akun Login</a>
    <a href="{{ route('hc.karyawan.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
</div>

@stop

@section('css')
    <style>
        .dl-row dt {
            font-weight: 600; /* Medium weight */
        }
        .dl-row dd {
            margin-bottom: .5rem;
        }
    </style>
@stop
