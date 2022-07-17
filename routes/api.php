<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Spaces\{JailController, WardController};
use App\Http\Controllers\Users\{DirectorController, GuardController, PrisonerController};
use App\Http\Controllers\Account\{AvatarController, ProfileController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    require __DIR__ . '/auth.php';

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::prefix('profile')->group(function () {
            Route::controller(ProfileController::class)->group(function () {
                Route::get('/', 'show')->name('profile');
                Route::post('/', 'store')->name('profile.store');
            });
            Route::post('/avatar', [AvatarController::class, 'store'])->name('profile.avatar');
        });
        Route::prefix(RoleEnum::DIRECTOR->value)->group(function () {
            Route::controller(DirectorController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{user}', 'show');
                Route::post('/{user}/update', 'update');
                Route::get('/{user}/destroy', 'destroy');
            });
        });
        Route::prefix(RoleEnum::GUARD->value)->group(function () {
            Route::controller(GuardController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{user}', 'show');
                Route::post('/{user}/update', 'update');
                Route::get('/{user}/destroy', 'destroy');
            });
        });
        Route::prefix(RoleEnum::PRISONER->value)->group(function () {
            Route::controller(PrisonerController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{user}', 'show');
                Route::post('/{user}/update', 'update');
                Route::get('/{user}/destroy', 'destroy');
            });
        });
        Route::prefix('ward')->group(function () {
            Route::controller(WardController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{ward}', 'show');
                Route::post('/{ward}/update', 'update');
                Route::get('/{ward}/destroy', 'destroy');
            });
        });
        Route::prefix('jail')->group(function () {
            Route::controller(JailController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{jail}', 'show');
                Route::post('/{jail}/update', 'update');
                Route::get('/{jail}/destroy', 'destroy');
            });
        });
    });
});
