<?php

// ==================================================
// BAGIAN 1: IMPORT DAN DEPENDENSI
// ==================================================

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;

// ==================================================
// BAGIAN 2: HALAMAN AWAL
// ==================================================

Route::get('/', function () {
    return redirect()->route('login');
});

// ==================================================
// BAGIAN 3: ROUTE UNTUK PENGUNJUNG
// ==================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

});

// ==================================================
// BAGIAN 4: ROUTE YANG MEMERLUKAN LOGIN
// ==================================================

Route::middleware(['auth', PreventBackHistory::class])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

// ==================================================
// BAGIAN 5: ROUTE DATA PEGAWAI
// ==================================================

Route::get('/pegawai', [PegawaiController::class, 'index'])
    ->name('pegawai.index');

// ==================================================
// BAGIAN 6: LOGOUT
// ==================================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// ==================================================
// BAGIAN 7: ROUTE TAMBAH PEGAWAI
// ==================================================

Route::get('/pegawai/tambah', [PegawaiController::class, 'create'])
    ->name('pegawai.create');

Route::post('/pegawai', [PegawaiController::class, 'store'])
    ->name('pegawai.store');    

// ==================================================
// ROUTE EDIT DAN UPDATE PEGAWAI
// ==================================================

Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])
    ->name('pegawai.edit');

Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])
    ->name('pegawai.update');

// ==================================================
// ROUTE HAPUS PEGAWAI
// ==================================================

Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])
    ->name('pegawai.destroy');
    
    });
