<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('karyawan.profile.index');
    }

    public function edit()
    {
        return view('karyawan.profile.edit');
    }

    public function update(Request $request)
    {
        // logika update data
    }
}
