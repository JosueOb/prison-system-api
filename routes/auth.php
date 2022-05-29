<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication routes
 */
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/forgot-password', [PasswordController::class, 'resendLink'])
    ->name('password.resend-link');

Route::post('/reset-password', [PasswordController::class, 'reset'])
    ->name('password.reset');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
