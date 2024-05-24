@extends('master')

@section('content')

<?php
$moedas = [
    (object) [
        'id' => 1,
        'descricao' => 'Dólar',
        'simbolo' => 'US$'
    ],
    (object) [
        'id' => 2,
        'descricao' => 'Euro',
        'simbolo' => '€'
    ],
    (object) [
        'id' => 3,
        'descricao' => 'Libra Esterlina',
        'simbolo' => '£'
    ],
    (object) [
        'id' => 4,
        'descricao' => 'Iene',
        'simbolo' => '¥'
    ]
];

?>

<body class="h-screen w-screen bg-[#DDDBDA] flex flex-row">
    <div class="w-[22rem] h-full bg-[#56BE7C] flex flex-col p-10">
        <div class="w-full flex flex-col justify-center items-center">
            {imagem do usuario ou:}<img src="{{ asset('img/noUser.png') }}" alt="Logo Money Track" class="rounded-full w-32 h-32">
        </div>
        <div class="justify-center items-center flex flex-col">
            <h1 class="font-bold text-zinc-700 text-2xl p-0 m-2">Tiago Pitanga 10</h1>
            <h2 class="font-semibold text-zinc-600 text-md p-0">tiagoepitanga10@gmail.com</h2>
        </div>
        <div class="flex justify-center items-start ml-8 flex-col gap-10 mt-10">
            @if (isset($moedas))
            @foreach ($moedas as $moeda)
            <button value="{{ $moeda->id }}" class="bg-none">
                <span class="font-bold text-3xl text-zinc-800">{{$moeda->simbolo}}</span>
                <span class="font-bold text-2xl text-zinc-700">{{ $moeda->descricao }}</span>
            </button>
            @endforeach
            @endif
        </div>
        <div class="flex h-full justify-end flex-col items-center">
            <button class="font-bold text-xl text-zinc-800 bg-red-400 rounded-lg px-6 py-2 flex flex-row !justify-between items-center w-[14rem] hover:bg-red-500">
                Desconectar
                <img src="{{ asset('img/exit.png') }}" alt="Logo Money Track" class="w-6 h-6">
            </button>
            <h3 class="font-semibold text-zinc-700 mt-4">BOBBY JONES SOLUTIONS®</h3>
        </div>
    </div>
    <div class="w-[calc(100vw-25rem)] flex items-start flex-col gap-20">
        <div class="flex flex-row justify-between items-center w-full">
            <img src="{{ asset('img/logoSemFundo.png') }}" alt="Logo Money Track" class="rounded-lg w-32 h-32 mt-2 ml-6">
            <h1 class="font-semibold text-zinc-700">DASHBOARD</h1>
            <button>
                <img src="{{ asset('img/configIcon.png') }}" alt="Logo Money Track" class="rounded-lg w-10 h-10 mr-6 hover:animate-spin">
            </button>
        </div>
        <div class="w-full flex flex-wrap mx-10 gap-5 justify-center">
            <div class="flex flex-col bg-[#56BE7C] w-[18rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                <h2 class="font-semibold text-zinc-700 text-lg">Saldo atual:</h2>
                <h3 class="font-bold text-zinc-700 text-2xl">R$ 10.589,00</h3>
            </div>
            <div class="flex flex-col bg-white w-[18rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                <h2 class="font-semibold text-zinc-700 text-lg">Convertidos em {moeda selecionada}:</h2>
                <h3 class="font-bold text-zinc-700 text-2xl">$ 2.058,27</h3>
            </div>
            <div class="flex flex-col bg-white w-[18rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                <h2 class="font-semibold text-zinc-700 text-lg">Adicionar saldo:</h2>
                <h3 class="font-bold text-zinc-700 text-2xl">R$ 0,00</h3>
                <div class="w-full justify-between items-center flex pb-10">
                    <button class="bg-[#FF443A] text-white font-semibold rounded-md p-2 hover:bg-red-600 h-8">Cancelar</button>
                    <button class="bg-[#38A263] text-white font-semibold rounded-md p-2 hover:bg-green-700 h-8">Confirmar</button>
                </div>
            </div>
            <div class="flex flex-col bg-white w-[18rem] h-[10rem] p-4 gap-5 rounded-md shadow-md border-2 border-white">
                <h2 class="font-semibold text-zinc-700 text-lg">Retirar saldo:</h2>
                <h3 class="font-bold text-zinc-700 text-2xl">R$ 0,00</h3>
                <div class="w-full justify-between items-center flex pb-10">
                    <button class="bg-[#FF443A] text-white font-semibold rounded-md p-2 hover:bg-red-600 h-8">Cancelar</button>
                    <button class="bg-[#38A263] text-white font-semibold rounded-md p-2 hover:bg-green-700 h-8">Confirmar</button>
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
    $("#get_cotacao").click(async function() {
        const moeda_id = $("#moeda_id").find(":selected").val();

        let cotacoes = await getCotacoes(moeda_id);
        cotacoes = cotacoes.data;
        console.log(cotacoes);

        const $tbl = $("#tbl_cotacoes tbody");

        $tbl.html("");

        let data = cotacoes.map((item) => {
            return `<tr><td>${item.datahora}</td><td>${item.valor}</td><tr>`;
        });

        $tbl.append(data);
    });


    async function getCotacoes(moeda_id) {
        try {
            const response = await fetch(root + `/api/getCotacoes?moeda_id=${moeda_id}`);
            const data = await response.json();

            return data;
        } catch (err) {
            console.error(err);

        }
    }

    // graficos
    const ctx = document.getElementById('myChart');

    const dollar = await getCotacoes(2);
    const euro = await getCotacoes(1);
    const iene = await getCotacoes(3);
    const libraEsterlina = await getCotacoes(4);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dollar.data.map((item) => item.datahora),
            datasets: [{
                    label: 'Dollar',
                    data: dollar.data.map((item) => item.valor),
                    borderWidth: 3
                },
                {
                    label: 'Euro',
                    data: euro.data.map((item) => item.valor),
                    borderWidth: 3
                },
                {
                    label: 'Libra Esterlina',
                    data: libraEsterlina.data.map((item) => item.valor),
                    borderWidth: 3
                },
                {
                    label: 'Iene',
                    data: iene.data.map((item) => item.valor),
                    borderWidth: 3
                },
            ]
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
