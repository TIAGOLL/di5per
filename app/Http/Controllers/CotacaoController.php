<?php

namespace App\Http\Controllers;

use App\Enum\CotacaoTipo;
use App\Models\Cotacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class CotacaoController extends Controller
{

    public function get(Request $request)
    {
        $moeda_id = $request->get("moeda_id");

        $cotacoes = Cotacao::where("moeda_id", $moeda_id)
            ->select("datahora", "valor")
            ->orderBy("datahora", "DESC")
            ->first();

        return $this->jsonSuccess($cotacoes);
    }

    public function getAll()
    {
        $inicio = Carbon::now()->subDays(7)->startOf("day");
        $fim = Carbon::now()->endOf("day");

        $cotacoes = Cotacao::from("cotacaos as cot")
            ->join("moedas as mo", "cot.moeda_id", "mo.id")
            ->whereBetween("cot.datahora", [$inicio, $fim])
            ->where("cot.descricao", CotacaoTipo::Fechamento)
            ->select("cot.datahora", "cot.valor", "cot.moeda_id", "mo.sigla")
            ->orderBy("cot.datahora", "DESC")
            ->get();

        $datas = [];
        $moedas = [];
        foreach ($cotacoes as $cotacao) {
            $cotacao->data = Carbon::parse($cotacao->datahora)->format("d/m/Y");

            if (!in_array($cotacao->data, $datas)) {
                array_push($datas, $cotacao->data);
            }

            if (!isset($moedas[$cotacao->sigla])) {
                $moedas[$cotacao->sigla] = [];
            }

            array_push($moedas[$cotacao->sigla], $cotacao->valor);
        }

        $payload = new stdClass();
        $payload->datas = $datas;
        $payload->moedas = $moedas;

        return $this->jsonSuccess($payload);
    }
}
