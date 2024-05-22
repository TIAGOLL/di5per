<?php

namespace App\Console\Commands;

use App\Enum\CotacaoTipo;
use App\Models\Cotacao;
use App\Models\Moeda;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

use function Laravel\Prompts\error;
use function Laravel\Prompts\warning;

class MoedaHistorico extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moeda:historico {days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extrai historico da moeda';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dias = $this->argument("days");

        $dataInicial = Carbon::now()->subDays($dias)->format("m-d-Y");
        $dataFinal = Carbon::now()->subDay()->format("m-d-Y");
        $moedas = Moeda::All();

        if (is_null($moedas)) {
            error("Banco sem dados");
            return;
        }
        foreach ($moedas as $moeda) {
            $moedaD = $moeda->sigla;
            $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda='" . $moedaD . "'&@dataInicial='" . $dataInicial . "'&@dataFinalCotacao='" . $dataFinal . "'" . '&$select=cotacaoCompra,dataHoraCotacao,tipoBoletim';
            $response = Http::withOptions(['verify' => false])->get($url);

            if (!$response->successful()) {
                error('Erro ao acessar a URL');
                return;
            }

            $data = $response->json();
            if (!isset($data['value'])) {
                warning('Nenhum dado encontrado');
                return;
            }

            foreach ($data['value'] as $value) {
                info($value['cotacaoCompra']);
                try {
                    $tipoBoletim = $this->mapTipoBoletim($value['tipoBoletim']);

                    $date = Carbon::parse($value["dataHoraCotacao"])->format("Y-m-d H:i:s");

                    $cotacao = Cotacao::where("dataHora", $date)
                        ->where("descricao", $tipoBoletim)
                        ->where("moeda_id", $moeda->id)
                        ->first();

                    if (!is_null($cotacao)) {
                        $cotacao->update([
                            "valor" => $value["cotacaoCompra"]
                        ]);

                        continue;
                    }

                    Cotacao::create([
                        'valor' => $value['cotacaoCompra'],
                        'dataHora' => $date,
                        'descricao' => $tipoBoletim,
                        'moeda_id' => $moeda->id
                    ]);
                } catch (\Exception $err) {
                    error('Não salvo no banco :( ' .  $err->getMessage());
                    return;
                }
            }
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
