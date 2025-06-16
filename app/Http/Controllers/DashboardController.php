<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeDetail;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function hc()
{
    // Statistik jenis kelamin (Laki-laki/Perempuan)
    $genderStats = EmployeeDetail::select('jenis_kelamin', DB::raw('count(*) as total'))
        ->groupBy('jenis_kelamin')
        ->pluck('total', 'jenis_kelamin');

    // Statistik divisi (Bisnis/Support/Direksi/dll)
    $divisionStats = Employee::select('divisi', DB::raw('count(*) as total'))
        ->groupBy('divisi')
        ->pluck('total', 'divisi');

    return view('dashboard.hc', compact('genderStats', 'divisionStats'));
}

    public function direksi() {
        return view('dashboard.direksi');
    }

    public function manajer() {
        return view('dashboard.manajer');
    }

    public function stafSupport() {
        return view('dashboard.staf_support');
    }

    public function stafBisnis() {
        return view('dashboard.staf_bisnis');
    }
}

