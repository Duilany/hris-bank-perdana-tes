@extends('adminlte::page')
@section('active_menu', 'pengumuman')

@section('title', 'Detail Pengumuman')

@section('content_header')
    <h1>Detail Pengumuman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $pengumuman->judul }} ({{ ucfirst($pengumuman->tipe) }})
        </div>
        <div class="card-body">
            {!! nl2br(e($pengumuman->isi)) !!}
        </div>
    </div>
    <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@stop
