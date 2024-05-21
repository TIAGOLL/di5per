<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class API extends Model
{
    public static function Atualizar($moedaD)
    {
        $dataInicial = date("m-d-Y", strtotime("-7 days"));
        $dataFinal = date("m-d-Y");
        $moedas = Moeda::All();
        //foreach ($moedas as $moeda) {
            //$moedaD = $moeda->sigla;
            $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda='".$moedaD."'&@dataInicial='".$dataInicial."'&@dataFinalCotacao='".$dataFinal."'".'&$select=cotacaoCompra,dataHoraCotacao,tipoBoletim';
            $response = Http::withOptions(['verify' => false])->get($url);
          
            foreach ($response['value'] as $value) {
                //info('moeda: '. $moedaD . '   ' . $value['cotacaoCompra']);
                if ($value['tipoBoletim'] == 'Fechamento') {
                    return $value['cotacaoCompra'];
                }
            }
           
        //}
    }
}
