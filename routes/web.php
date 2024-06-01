<?php

use App\Http\Controllers\CotacaoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckIfLoggedIn;
use Illuminate\Support\Facades\Auth;

/*Route::get('/', function () {
    return view('auth.login');
});*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('auth');


Route::middleware([CheckIfLoggedIn::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dahboard');
    Route::post('/adicionar', [DashboardController::class, 'adicionar'])->name('adicionarSaldo');
    Route::post('/retirar', [DashboardController::class, 'retirar'])->name('retirarSaldo');
});



Route::prefix("api")->group(function () {

    Route::prefix("cotacao")->group(function () {

        Route::get("getByMoeda", [CotacaoController::class, "get"])->name('cotacao.getByMoeda');

        Route::get("getAll", [CotacaoController::class, "getAll"])->name('cotacao.getall');
    });
});



/*Route::prefix("cotacao")->group(function() {

//    Route::get("get", [ContacaoController::class, "get"]);
});*/
