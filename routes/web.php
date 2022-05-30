<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/* TODO: Move to api route and PasswordController is responsible for doing this action.*/
Route::get('/reset-password/{token}', function (Request $request) {
    $url = env('APP_FRONTEND_URL') .
        "/?token={$request->route('token')}&email=$request->email";
    return response()->json(['url' => $url]);
    /*TODO: Uncomment when the frontend is running*/
//    return redirect()->away($url);
})->name('password.reset');
