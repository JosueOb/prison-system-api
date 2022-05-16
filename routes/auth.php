<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication routes
 */
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/forgot-password', [PasswordController::class, 'resetLink'])
    ->name('password.email');

Route::post('/reset-password', [PasswordController::class, 'update'])
    ->name('password.update');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
