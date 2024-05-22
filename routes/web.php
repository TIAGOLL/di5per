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

Route::group(["middleware" => "web"], function () {

    // TOdas as rotas aqui precisam de autenticação

});

if (Auth::check()) {
    Route::get('/dahboard', [DashboardController::class, 'index'])->name('dahboard');
}

Route::prefix("cotacao")->group(function() {

//    Route::get("get", [ContacaoController::class, "get"]);
});

// localhost/di/cotacao/get?moeda_id=1&inicio=...&fim=...

/*

select("datahora", "valor")

{
    "valor": 12,
    "datahora": "..."
}
*/
