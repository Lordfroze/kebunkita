<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerdaganganController;
use App\Http\Controllers\PerikananController;
use App\Http\Controllers\PerkebunanController;

// Login Logout
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [AuthController::class, 'register_form'])->name('register_form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route Controller Dashboard
Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/perikanan', [PerikananController::class, 'index'])->name('perikanan');
Route::get('/dashboard/perdagangan', [PerdaganganController::class, 'index'])->name('perdagangan');
Route::get('/dashboard/perkebunan', [PerkebunanController::class, 'index'])->name('perkebunan');

// Route Controller Perikanan
Route::get('/dashboard/perikanan/kolam_timur', [PerikananController::class, 'kolam_timur']);
Route::get('/dashboard/perikanan/create', [PerikananController::class, 'create']);
Route::post('/dashboard/perikanan', [PerikananController::class, 'store']);
Route::get('/dashboard/perikanan/{id}', [PerikananController::class, 'show']);
Route::get('/dashboard/perikanan/{id}/edit', [PerikananController::class, 'edit']);
Route::patch('/dashboard/perikanan/{id}', [PerikananController::class, 'update']);
Route::delete('/dashboard/perikanan/{id}', [PerikananController::class, 'destroy']);

// Route delete data kolam timur
Route::delete('/dashboard/perikanan/kolam-timur/delete-all', [PerikananController::class, 'deleteAllKolamTimur'])->name('perikanan.kolam_timur.deleteAll');

























// test laravel
Route::get('/laravel', function () {
    return view('welcome');
});

Route::get('/tambah-data/settingkolam', [DashboardController::class, 'settingkolam'])->name('settingkolam');
Route::get('/tambah-data/settingkebun', [DashboardController::class, 'settingkebun'])->name('settingkebun');
Route::get('tambah-data/settingbarang', [DashboardController::class, 'settingbarang'])->name('settingbarang');

// Cara membuat controller 
// php artisan make:controller AdminController