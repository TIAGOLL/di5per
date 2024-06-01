<?php

namespace App\Http\Controllers;

use App\Enum\CotacaoTipo;
use Illuminate\Http\Request;
use App\Models\Cotacao;
use App\Models\Moeda;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $moedas = Moeda::orderBy("descricao")->get();

        return view("dashboard", compact("moedas"));
    }

    public function adicionar(Request $request)
    {
        $id = Auth::user();
        $totalConta = User::where('id', $id['id'])->value('total_conta');
        $quantidade = $request->quantidade;
        info($totalConta);
        info($quantidade);
        $total = $totalConta + $quantidade;
        info($total);
        User::where('id', $id['id'])->update([
            'total_conta' => $total
        ]);

        return redirect()->back();
    }

    public function retirar(Request $request)
    {
        $id = Auth::user();
        $totalConta = User::where('id', $id['id'])->value('total_conta');
        $quantidade = $request->quantidade;
        info($totalConta);
        info($quantidade);
        $total = $totalConta - $quantidade;
        info($total);
        User::where('id', $id['id'])->update([
            'total_conta' => $total
        ]);

        return redirect()->back();
    }
}
