@extends('master')

@section('content')

    @if (isset($moedas))
        <select name="moeda_id" id="moeda_id">
            @foreach ($moedas as $moeda)
                <option value="{{ $moeda->id }}">{{ $moeda->descricao }}</option>
            @endforeach
        </select>
    @endif

    <button id="get_cotacao">Buscar</button>

    <div>
        <table id="tbl_cotacoes">

            <head>
                <tr>
                    <th>Data Hora</th>
                    <th>Valor</th>
                </tr>
            </head>

            <body>
            </body>
        </table>
    </div>
    <script>
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
    </script>
@endsection
