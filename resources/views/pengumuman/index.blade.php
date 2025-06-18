@extends('adminlte::page')

@section('title', 'Daftar Pengumuman')

@section('content_header')
    <h1>Daftar Pengumuman</h1>
@stop

@section('content')
    <a href="{{ route('pengumuman.create') }}" class="btn btn-primary mb-3">Tambah Pengumuman</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tipe</th>
                <th>label</th>
                <th>Lampiran</th> <!-- Tambahkan kolom baru -->
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengumuman as $item)
            <tr>
                <td>{{ $item->judul }}</td>
                <td>{{ ucfirst($item->tipe) }}</td>
                <td>
  @if($item->label)
    <span class="badge bg-info text-white">{{ $item->label }}</span>
  @else
    <span class="text-muted">Umum</span>
  @endif
</td>

                <td>
                    @if ($item->attachment)
                        @php
                            $ext = pathinfo($item->attachment, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset('storage/pengumuman/' . $item->attachment) }}" alt="gambar" width="60">
                        @elseif (strtolower($ext) === 'pdf')
                            <a href="{{ asset('storage/pengumuman/' . $item->attachment) }}" target="_blank">Lihat PDF</a>
                        @else
                            <a href="{{ asset('storage/pengumuman/' . $item->attachment) }}" target="_blank">Unduh File</a>
                        @endif
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('pengumuman.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop
