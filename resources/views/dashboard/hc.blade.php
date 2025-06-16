@extends('adminlte::page')
@section('title', 'Dashboard HC')

@section('content_header')
    <h1>Dashboard HC</h1>
@endsection

@section('content')
    <p>Selamat datang, Superadmin HC.</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Statistik Jenis Kelamin Karyawan</h4>
            <canvas id="genderChart"></canvas>
        </div>
        <div class="col-md-6">
            <h4>Statistik Divisi Karyawan</h4>
            <canvas id="divisionChart"></canvas>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const genderChart = new Chart(document.getElementById('genderChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($genderStats->keys()) !!},
                datasets: [{
                    data: {!! json_encode($genderStats->values()) !!},
                    backgroundColor: ['#36A2EB', '#FF6384'],
                }]
            }
        });

        const divisionChart = new Chart(document.getElementById('divisionChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($divisionStats->keys()) !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! json_encode($divisionStats->values()) !!},
                    backgroundColor: '#4BC0C0',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection
