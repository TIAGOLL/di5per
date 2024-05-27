<?php

namespace App\Http\Controllers;

use App\Enum\CotacaoTipo;
use Illuminate\Http\Request;
use App\Models\Cotacao;
use App\Models\Moeda;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $moedas = Moeda::orderBy("descricao")->get();

        return view("dashboard", compact("moedas"));
    }
}
