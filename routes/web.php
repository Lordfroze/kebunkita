<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/settingkolam', [DashboardController::class, 'settingkolam'])->name('settingkolam');
Route::get('/settingkebun', [DashboardController::class, 'settingkebun'])->name('settingkebun');
Route::get('/settingbarang', [DashboardController::class, 'settingbarang'])->name('settingbarang');
Route::get('/dashboard/login', [DashboardController::class, 'login'])->name('login');


// test laravel
Route::get('/laravel', function (){
    return view('welcome');
});



// Cara membuat controller 
// php artisan make:controller AdminController