<?php

use App\Http\Controllers\Account\ProfileController;
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
        });
    });
});
