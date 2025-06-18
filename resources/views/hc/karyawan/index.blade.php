@extends('adminlte::page')

{{-- Mengaktifkan plugin DataTables --}}
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('title', 'Manajemen Karyawan')

@section('content_header')
    <h1>Manajemen Karyawan</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Karyawan</h3>
        <div class="card-tools">
            <a href="{{ route('hc.karyawan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Karyawan
            </a>
        </div>
    </div>
    <div class="card-body">
        {{-- Setup data untuk tabel --}}
        @php
        $heads = [
            ['label' => 'No', 'width' => 5],
            'Nama Lengkap',
            'Kontak',
            ['label' => 'Jabatan', 'width' => 15],
            ['label' => 'Status', 'width' => 10],
            ['label' => 'Aksi', 'no-export' => true, 'width' => 15],
        ];

        $config = [
            'data' => [],
            'order' => [[1, 'asc']],
            'columns' => [
                ['data' => 'no'],
                ['data' => 'nama'],
                ['data' => 'kontak'],
                ['data' => 'jabatan'],
                ['data' => 'status'],
                ['data' => 'aksi', 'orderable' => false, 'searchable' => false],
            ],
            'responsive' => true,
            'autoWidth' => false,
        ];

        foreach ($users as $index => $user) {
            $employee = $user->employee;
            $nama = $employee->full_name ?? '<i class="text-muted">Data belum lengkap</i>';
            $kontak = $user->email . '<br><small>' . ($employee->phone_number ?? '') . '</small>';
            
            // Mengambil nama posisi, jika ada relasinya
            $jabatan = $employee?->position?->name ?? '<i class="text-muted">N/A</i>';
            $role = ucfirst(str_replace('_', ' ', $user->role));
            $jabatanFull = "$jabatan<br><small class='text-muted'>($role)</small>";

            $statusBadge = $employee?->status === 'Aktif'
                ? '<span class="badge badge-success">Aktif</span>'
                : '<span class="badge badge-danger">Tidak Aktif</span>';

            $btnDetail = '<a href="'.route('hc.karyawan.show', $user->id).'" class="btn btn-xs btn-default text-teal mx-1" title="Detail"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $btnEditAkun = '<a href="'.route('hc.karyawan.edit', $user->id).'" class="btn btn-xs btn-default text-primary mx-1" title="Edit Akun Login"><i class="fa fa-lg fa-fw fa-user-edit"></i></a>';
            $btnEditData = '<a href="'.route('hc.karyawan.edit_detail', $user->id).'" class="btn btn-xs btn-default text-warning mx-1" title="Edit Data Karyawan"><i class="fa fa-lg fa-fw fa-id-card"></i></a>';
            
            $formId = "delete-form-{$user->id}";
            $btnDelete = '
                <form id="'.$formId.'" action="'.route('hc.karyawan.destroy', $user->id).'" method="POST" style="display:inline;">
                    '.csrf_field().method_field("DELETE").'
                    <button type="button" class="btn btn-xs btn-default text-danger mx-1" title="Hapus" onclick="confirmDelete(\''.$formId.'\')">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </button>
                </form>';
            
            $config['data'][] = [
                'no' => $index + 1,
                'nama' => $nama,
                'kontak' => $kontak,
                'jabatan' => $jabatanFull,
                'status' => $statusBadge,
                'aksi' => '<nobr>'.$btnDetail.$btnEditAkun.$btnEditData.$btnDelete.'</nobr>',
            ];
        }
        @endphp

        {{-- Tampilkan tabel dengan DataTables --}}
        <x-adminlte-datatable id="table_karyawan" :heads="$heads" :config="$config" striped hoverable bordered with-buttons/>
    </div>
</div>
@stop

@section('js')
    {{-- SweetAlert untuk konfirmasi hapus yang lebih baik --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data karyawan beserta akun login akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
@stop
