<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function hc()
{
    // Statistik jenis kelamin (Laki-laki/Perempuan)
    $genderStats = Employee::select('gender', DB::raw('count(*) as total'))
        ->groupBy('gender')
        ->pluck('total', 'gender');

    // Statistik divisi (Bisnis/Support/Direksi/dll)
    $divisionStats = Employee::select('division_id', DB::raw('count(*) as total'))
        ->groupBy('division_id')
        ->pluck('total', 'division_id');

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

