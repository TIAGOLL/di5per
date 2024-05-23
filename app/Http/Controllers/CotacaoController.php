<?php

namespace App\Http\Controllers;

use App\Enum\CotacaoTipo;
use App\Models\Cotacao;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CotacaoController extends Controller
{

    public function get(Request $request)
    {
        $moeda_id = $request->get("moeda_id");
        $inicio = Carbon::now()->subDays(7)->startOf("day");
        $fim = Carbon::now()->endOf("day");

        $cotacoes = Cotacao::where("moeda_id", $moeda_id)
            ->whereBetween("datahora", [$inicio, $fim])
            ->where("descricao", CotacaoTipo::Fechamento)
            ->select("datahora", "valor")
            ->get();

        return $this->jsonSuccess($cotacoes);
    }
}
