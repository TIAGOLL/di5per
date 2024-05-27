@extends('master')

@section('content')

    @php
        $user = new \stdClass();
        $user->name = 'Macaco';
        $user->email = 'macaco@test.com';
        $user->total_conta = 42069.69;
    @endphp

    <body class="h-auto w-auto bg-[#DDDBDA] flex flex-row">
        <div class="w-[22rem] h-auto bg-[#56BE7C] flex flex-col p-10">
            <div class="w-full flex flex-col justify-center items-center">
                <img src="{{ asset('img/noUser.png') }}" alt="Logo Money Track" class="rounded-full w-32 h-32">
            </div>
            <div class="justify-center items-center flex flex-col">
                <h1 class="font-bold text-zinc-700 text-2xl p-0 m-2">{{ $user->name }} </h1>
                <h2 class="font-semibold text-zinc-600 text-md p-0">{{ $user->email }}</h2>
            </div>
            <div class="flex justify-center items-start ml-8 flex-col gap-10 mt-10">
                @if (isset($moedas))
                    @foreach ($moedas as $moeda)
                        <button value="{{ $moeda->id }}" class="bg-none moedas">
                            <span class="font-bold text-3xl text-zinc-800">{{ $moeda->simbolo }}</span>
                            <span class="font-bold text-2xl text-zinc-700">{{ $moeda->descricao }}</span>
                        </button>
                    @endforeach
                @endif
            </div>
            <div class="flex h-full justify-end flex-col items-center">
                <button
                    class="font-bold text-xl text-zinc-800 bg-red-400 rounded-lg px-6 py-2 flex flex-row !justify-between items-center w-[14rem] hover:bg-red-500">
                    Desconectar
                    <img src="{{ asset('img/exit.png') }}" alt="Logo Money Track" class="w-6 h-6">
                </button>
                <h3 class="font-semibold text-zinc-700 mt-4">BOBBY JONES SOLUTIONS®</h3>
            </div>
        </div>
        <div class="w-[calc(100vw-25rem)] flex items-start flex-col gap-20">
            <div class="flex flex-row justify-between items-center w-full">
                <img src="{{ asset('img/logoSemFundo.png') }}" alt="Logo Money Track"
                    class="rounded-lg w-32 h-32 mt-2 ml-6">
                <h1 class="font-semibold text-zinc-700">DASHBOARD</h1>
                <button>
                    <img src="{{ asset('img/configIcon.png') }}" alt="Logo Money Track"
                        class="rounded-lg w-10 h-10 mr-6 hover:animate-spin">
                </button>
            </div>
            <div class="w-full flex flex-wrap mx-10 gap-5 justify-center">
                <div
                    class="flex flex-col bg-[#56BE7C] w-[13rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                    <h2 class="font-semibold text-zinc-700 text-lg">Saldo atual:</h2>
                    <h3 class="font-bold text-zinc-700 text-2xl">R$ {{ number_format($user->total_conta, 2, ',', '.') }}
                    </h3>
                </div>
                <div
                    class="flex flex-col bg-white w-[13rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                    <h2 class="font-semibold text-zinc-700 text-lg">Convertidos:</h2>
                    <h3 id="convertido" class="font-bold text-zinc-700 text-2xl"></h3>
                </div>
                <div
                    class="flex flex-col bg-white w-[13rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                    <h2 class="font-semibold text-zinc-700 text-lg">Adicionar saldo:</h2>
                    <h3 class="font-bold text-zinc-700 text-2xl">R$ 0,00</h3>
                    <div class="w-full justify-between items-center flex pb-10">
                        <button
                            class="bg-[#FF443A] text-white font-semibold rounded-md px-1 hover:bg-red-600 h-8">Cancelar</button>
                        <button
                            class="bg-[#38A263] text-white font-semibold rounded-md px-1 hover:bg-green-700 h-8">Confirmar</button>
                    </div>
                </div>
                <div
                    class="flex flex-col bg-white w-[13rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                    <h2 class="font-semibold text-zinc-700 text-lg">Retirar saldo:</h2>
                    <h3 class="font-bold text-zinc-700 text-2xl">R$ 0,00</h3>
                    <div class="w-full justify-between items-center flex pb-10">
                        <button
                            class="bg-[#FF443A] text-white font-semibold rounded-md px-1 hover:bg-red-600 h-8">Cancelar</button>
                        <button
                            class="bg-[#38A263] text-white font-semibold rounded-md px-1 hover:bg-green-700 h-8">Confirmar</button>
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-row mx-10 gap-5 justify-center">
                <div style="width: 800px;">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </body>

    <script type="module">
        const moedas = @json($moedas);
        const usuario = @json($user);



        $(document).ready(function() {

        });
        /*
            TUDO NO BACK:
            - Aperta na moeda
            - Vai requisição pro back-end
            No back:
                - Busca a ultima cotacao da moeda
                - Realiza calc de conversão
                - Retorna valor atualizado
            
            No client:
                - Renderiza o valor
        */

        $(".moedas").on("click", async function() {
            let $convertido = $("#convertido");
            let moeda_id = $(this).val();
            let moedaSelecionada = moedas.find(moeda => moeda.id == moeda_id);
            let cotacao = await getCotacaoByMoeda(moeda_id);


            let calc = usuario.total_conta / cotacao.data.valor;

            let calcFormatado = calc.toFixed(2);

            let simbolo = moedaSelecionada.simbolo;
            // Deixa o valor legivel para humano

            $convertido.html(simbolo + ' ' + calcFormatado);
        });

        async function getCotacaoByMoeda(moeda_id) {
            try {
                let url = "{{ route('cotacao.getByMoeda') }}";

                const response = await fetch(`${url}?moeda_id=${moeda_id}`);
                const data = await response.json();

                return data;
            } catch (err) {
                console.error(err)
            }
        }

        async function getCotacoes() {
            try {
                const response = await fetch("{{ route('cotacao.getall') }}");
                const data = await response.json();

                return data;
            } catch (err) {
                console.error(err);
            }
        }

        function getDatasets(cotacoes) {
            let datasets = [];

            const cots = cotacoes.data.moedas
            for (const moeda of moedas) {
                if (!(moeda.sigla in cots)) continue;

                let obj = {
                    label: moeda.descricao,
                    data: cots[moeda.sigla],
                    borderWidth: 3
                };

                datasets.push(obj);
            }

            return datasets;
        }

        // graficos
        const ctx = document.getElementById('myChart');

        const cotacoes = await getCotacoes();
        const datasets = getDatasets(cotacoes);

        // TODO Buscar uma maneira de dividir as moedas automaticamente!!!
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: cotacoes.data.datas,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
