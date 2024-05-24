<?php

namespace App\Console\Commands;

use App\Enum\CotacaoTipo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Moeda;
use App\Models\Cotacao;
use Carbon\Carbon;
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
        $dataInicial = date("m-d-Y");
        $dataFinal = date("m-d-Y");
        $moedas = Moeda::All();

        info($moedas);
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
                info($value['dataHoraCotacao']);
                try {
                    $tipoBoletim = $this->mapTipoBoletim($value['tipoBoletim']);

                    $date = Carbon::parse($value["dataHoraCotacao"], "America/Sao_Paulo")->format("Y-m-d H:i:s ");

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
