<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\HC\UserManagementController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', fn () => redirect()->route('login'));

Auth::routes();

Route::middleware('auth')->group(function () {

    // === Dashboard per Role ===
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard/hc', [DashboardController::class, 'hc'])->name('dashboard.hc');
    Route::get('/dashboard/direksi', [DashboardController::class, 'direksi'])->name('dashboard.direksi');
    Route::get('/dashboard/manajer', [DashboardController::class, 'manajer'])->name('dashboard.manajer');
    Route::get('/dashboard/staf/support', [DashboardController::class, 'stafSupport'])->name('dashboard.staf.support');
    Route::get('/dashboard/staf/bisnis', [DashboardController::class, 'stafBisnis'])->name('dashboard.staf.bisnis');

    // === Pengumuman ===
    Route::resource('pengumuman', PengumumanController::class);

    // =======================
    // === HC Area (Admin HR)
    // =======================
    Route::prefix('hc')->middleware(['auth', RoleMiddleware::class.':hc'])->group(function () {
        Route::get('/karyawan', [UserManagementController::class, 'index'])->name('hc.karyawan.index');
        Route::delete('/hc/karyawan/{id}', [UserManagementController::class, 'destroy'])->name('hc.karyawan.destroy');
        Route::get('/karyawan/create', [UserManagementController::class, 'create'])->name('hc.karyawan.create');
        Route::post('/karyawan', [UserManagementController::class, 'store'])->name('hc.karyawan.store');
        Route::get('/karyawan/{id}/edit-akun', [UserManagementController::class, 'edit'])->name('hc.karyawan.edit');
        Route::get('{id}', [UserManagementController::class, 'show'])->name('hc.karyawan.show');
        Route::get('{id}/edit-detail', [UserManagementController::class, 'editDetail'])->name('hc.karyawan.edit_detail');
        Route::put('{id}/update-detail', [UserManagementController::class, 'updateDetail'])->name('hc.karyawan.update_detail');
        Route::put('/karyawan/{id}/update-akun', [UserManagementController::class, 'update'])->name('hc.karyawan.update');
    });    
});
