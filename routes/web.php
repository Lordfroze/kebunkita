<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerdaganganController;
use App\Http\Controllers\PerikananController;
use App\Http\Controllers\PerkebunanController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\DataExportController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\UserController;

// Login Logout
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('throttle:5,1')->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Register
Route::get('/register', [AuthController::class, 'register_form'])->name('register_form');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register');

// Auth Dashboard
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Controller Perikanan
    Route::prefix('dashboard/perikanan')->group(function () {
        Route::get('/', [PerikananController::class, 'index'])->name('perikanan');
        Route::get('/kolam_timur', [PerikananController::class, 'kolam_timur']);
        Route::get('/kolam_barat', [PerikananController::class, 'kolam_barat']);
        Route::get('/jumlah_ikan', [PerikananController::class, 'jumlah_ikan']);
        Route::get('/create', [PerikananController::class, 'create']);
        Route::post('/', [PerikananController::class, 'store']);
        Route::get('/{id}', [PerikananController::class, 'show']);
        Route::get('/{id}/edit', [PerikananController::class, 'edit']);
        Route::patch('/{id}', [PerikananController::class, 'update']);
        Route::delete('/{id}', [PerikananController::class, 'destroy']);
        Route::get('/panen/{season}', [PerikananController::class, 'musim_panen']);
        Route::delete('/kolam-timur/delete-all', [PerikananController::class, 'deleteAllKolamTimur'])->name('perikanan.kolam_timur.deleteAll');
        Route::delete('/kolam-barat/delete-all', [PerikananController::class, 'deleteAllKolamBarat'])->name('perikanan.kolam_barat.deleteAll');
    });

    // Controller Perdagangan
    Route::prefix('dashboard/perdagangan')->group(function () {
        Route::get('/', [PerdaganganController::class, 'index'])->name('perdagangan');
        Route::get('/kalkulator', [PerdaganganController::class, 'kalkulator']);
        Route::post('/calculate', [PerdaganganController::class, 'calculate'])->name('perdagangan.calculate');
        Route::get('/create', [PerdaganganController::class, 'create']);
        Route::post('/', [PerdaganganController::class, 'store']);
        Route::get('/{id}', [PerdaganganController::class, 'show']);
        Route::get('/{id}/edit', [PerdaganganController::class, 'edit']);
        Route::patch('/{id}', [PerdaganganController::class, 'update']);
        Route::delete('/{id}', [PerdaganganController::class, 'destroy']);
    });

    Route::get('/kalkulator/download', [PerdaganganController::class, 'downloadPdf'])->name('kalkulator.download');

    // Controller Keuangan
    Route::prefix('dashboard/keuangan')->group(function () {
        Route::get('/', [KeuanganController::class, 'index'])->name('keuangan');
        Route::get('/create', [KeuanganController::class, 'create']);
        Route::post('/', [KeuanganController::class, 'store']);
        Route::get('/chart-data', [KeuanganController::class, 'chartData']);
        Route::get('/export', [KeuanganController::class, 'exportExcel']);
        Route::get('/{id}', [KeuanganController::class, 'show']);
        Route::get('/{id}/edit', [KeuanganController::class, 'edit']);
        Route::patch('/{id}', [KeuanganController::class, 'update']);
        Route::delete('/{id}', [KeuanganController::class, 'destroy']);
    });

    // Controller Perkebunan
    Route::get('/dashboard/perkebunan', [PerkebunanController::class, 'index'])->name('perkebunan');

    // Download & Export
    Route::get('/download', [DashboardController::class, 'download'])->name('download');
    Route::get('/download-excel', [DataExportController::class, 'exportExcel'])->name('data.exportExcel');

    // Tambah Data
    Route::get('/tambah-data/settingkolam', [DashboardController::class, 'settingkolam'])->name('settingkolam');
    Route::get('/tambah-data/settingkebun', [DashboardController::class, 'settingkebun'])->name('settingkebun');
    Route::get('/tambah-data/settingbarang', [DashboardController::class, 'settingbarang'])->name('settingbarang');

    // Admin User Management
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

// Weather (public)
Route::get('/weather', [WeatherController::class, 'getWeather']);

// Test
Route::get('/laravel', function () {
    return view('welcome');
});
