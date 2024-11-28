<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

Route::get('/laravel', function (){
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/tabel_ikan', [DashboardController::class, 'tabel_ikan'])->name('tabel_ikan');