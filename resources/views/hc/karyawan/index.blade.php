@extends('adminlte::page')
@section('title', 'Manajemen Karyawan')
@section('content_header')
    <h1>Manajemen Karyawan</h1>
@endsection

@section('content')
    <a href="{{ route('hc.karyawan.create') }}" class="btn btn-primary mb-3">Tambah Karyawan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item->role)) }}</td>
                    <td>
                        <a href="{{ route('hc.karyawan.show', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a>
                        <a href="{{ route('hc.karyawan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('hc.karyawan.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
