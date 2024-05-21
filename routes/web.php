<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::get('/dahboard',[DashboardController::class,'index']);