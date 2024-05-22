<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

/*Route::get('/', function () {
    return view('auth.login');
});*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('auth');

if (Auth::check()) {
    Route::get('/dahboard', [DashboardController::class, 'index'])->name('dahboard');
}
