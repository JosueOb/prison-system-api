<?php

use App\Http\Controllers\Auth\{AuthController, PasswordController};
use Illuminate\Support\Facades\Route;

/**
 * Authentication routes
 */
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')
        ->name('logout');
});

Route::controller(PasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'redirectReset')->name('password.reset');
    Route::post('/forgot-password', 'resendLink')->name('password.resend-link');
    Route::post('/reset-password', 'restore')->name('password.restore');
    Route::post('/update-password', 'update')->middleware('auth:sanctum')
        ->name('password.update');
});
