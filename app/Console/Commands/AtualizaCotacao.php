<?php

namespace App\Console\Commands;

use App\Enum\CotacaoTipo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Moeda;
use App\Models\Cotacao;
use InvalidArgumentException;

use function Laravel\Prompts\error;
use function Laravel\Prompts\warning;

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
        $dataInicial = date("m-d-Y", strtotime("-7 days"));
        $dataFinal = date("m-d-Y");
        $moedas = Moeda::All();

        if (isset($moedas)) {
            foreach ($moedas as $moeda) {
                $moedaD = $moeda->sigla;
                $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda='" . $moedaD . "'&@dataInicial='" . $dataInicial . "'&@dataFinalCotacao='" . $dataFinal . "'" . '&$select=cotacaoCompra,dataHoraCotacao,tipoBoletim';
                $response = Http::withOptions(['verify' => false])->get($url);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['value'])) {
                        foreach ($data['value'] as $value) {
                            info($value['cotacaoCompra']);
                            try {
                                $tipoBoletim = $this->mapTipoBoletim($value['tipoBoletim']);

                                Cotacao::create([
                                    'valor' => $value['cotacaoCompra'],
                                    'dataHora' => $value['dataHoraCotacao'],
                                    'descricao' => $tipoBoletim,
                                    'moeda_id' => $moeda->id
                                ]);
                            } catch (\Throwable $th) {
                                error('Não salvo no banco :( ');
                            }
                        }
                    } else {
                        warning('Nenhum dado encontrado');
                    }
                } else {
                    error('Erro ao acessar a URL');
                }
            }
        } else {
            error("Banco sem dados");
        }
    }
    /**
     * Map API tipoBoletim value to CotacaoTipo enum
     *
     * @param string $tipoBoletim
     * @return CotacaoTipo
     * @throws InvalidArgumentException
     */
    private function mapTipoBoletim(string $tipoBoletim): CotacaoTipo
    {
        return match ($tipoBoletim) {
            'Abertura' => CotacaoTipo::Abertura,
            'Intermediário' => CotacaoTipo::Intermediario,
            'Fechamento' => CotacaoTipo::Fechamento,
            default => throw new InvalidArgumentException("Unknown tipoBoletim value: " . $tipoBoletim),
        };
    }
}
