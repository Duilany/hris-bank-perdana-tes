<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'hc') {
            return redirect()->route('dashboard.hc');
        } elseif ($user->role === 'direksi') {
            return redirect()->route('dashboard.direksi');
        } elseif ($user->role === 'manajer') {
            return redirect()->route('dashboard.manajer');
        } elseif ($user->role === 'staf_support') {
            return redirect()->route('dashboard.staf.support');
        } elseif ($user->role === 'staf_bisnis') {
            return redirect()->route('dashboard.staf.bisnis');
        }
    
        return abort(403);
    }
}
