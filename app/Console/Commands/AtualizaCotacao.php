<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Moeda;

class AtualizaCotacao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moeda:atualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {  
        date_default_timezone_set('America/Sao_Paulo');
        $dataInicial = date("m-d-Y", strtotime("-7 days"));
        $dataFinal = date("m-d-Y");
        $moedas = Moeda::All();
        //dd($moedas);
        foreach ($moedas as $moeda) {
            $moedaD = $moeda->sigla;

            $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda='".$moedaD."'&@dataInicial='".$dataInicial."'&@dataFinalCotacao='".$dataFinal."'".'&$select=cotacaoCompra,dataHoraCotacao,tipoBoletim';
            $response = Http::withOptions(['verify' => false])->get($url);
          
            dd($response['value']);
        }
    }
}
