<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\KeuanganApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('api.login');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('api.logout');

    Route::middleware('abilities:keuangan:read')->group(function () {
        Route::get('/keuangan', [KeuanganApiController::class, 'index'])->name('api.keuangan.index');
        Route::get('/keuangan/chart', [KeuanganApiController::class, 'chart'])->name('api.keuangan.chart');
        Route::get('/keuangan/{id}', [KeuanganApiController::class, 'show'])->name('api.keuangan.show');
    });
});
