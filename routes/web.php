<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

Route::get('/laravel', function (){
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index']);
