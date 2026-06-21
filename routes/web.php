<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\MataPelajaranController;

// Redirect home to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Resource Routes
    Route::resource('siswa', SiswaController::class)->except(['create', 'show', 'edit']);
    Route::resource('guru', GuruController::class)->except(['create', 'show', 'edit']);
    Route::resource('kelas', KelasController::class)->except(['create', 'show', 'edit']);
    Route::resource('jadwal', JadwalController::class)->except(['create', 'show', 'edit']);
    Route::resource('pembayaran', PembayaranController::class)->except(['create', 'show', 'edit']);
    Route::resource('mapel', MataPelajaranController::class)->except(['create', 'show', 'edit']);

    // Nilai Routes (Composite key workaround)
    Route::get('nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::post('nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::delete('nilai', [NilaiController::class, 'destroy'])->name('nilai.destroy');
});
