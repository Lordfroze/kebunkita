<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/perikanan', [DashboardController::class, 'perikanan'])->name('perikanan');
Route::get('/dashboard/perdagangan', [DashboardController::class, 'perdagangan'])->name('perdagangan');
Route::get('/dashboard/perkebunan', [DashboardController::class, 'perkebunan'])->name('perkebunan');


// test laravel
Route::get('/laravel', function (){
    return view('welcome');
});



// Cara membuat controller 
// php artisan make:controller AdminController