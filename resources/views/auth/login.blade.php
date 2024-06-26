<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Track - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-full w-full">
    <div class="bg-[#56be7c] rounded-lg shadow-lg flex w-[50rem] h-screen justify-center items-start pt-20">
        <div class="justify-start flex flex-col items-center w-full">
            <img src="{{ asset('img/LogoDefinitiva.png') }}" alt="Logo Money Track" class="rounded-lg w-72 h-72">
            <form method="POST" action="{{ route('auth') }}" class="w-[20rem] h-[1rem]">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm text-gray-700 font-semibold">E-mail</label>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('img/usuarioicon.png') }}" alt="" class="mr-2 w-6 h-6">
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full h-8 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-2 shadow-md"
                            required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm text-gray-700 font-semibold">Senha</label>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('img/cadeadoicon.png') }}" alt="" class="mr-2 w-6 h-6">
                        <input type="password" name="password" id="password"
                            class="h-8 mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm "
                            required>
                    </div>
                </div>
                <div class="w-full items-center justify-center flex">
                    <button type="submit" id="login"
                        class="w-[13rem] py-2 px-4 border border-transparent rounded-3xl shadow-md text-sm font-medium text-white bg-[#3E3A4E] hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 justify-center items-center">Entrar</button>
                </div>
                <div class="flex justify-between">
                    <div class="mt-4 text-sm">
                        <a href="#" class="text-[#3E3A4E] hover:text-indigo-500">Esqueci minha senha</a>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="#" class="text-[#3E3A4E] hover:text-indigo-500">Criar uma conta</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="w-full h-screen">
        <img src="{{ asset('img/pesoaSorrindo.jpg') }}" alt="Imagem Principal" class="h-full">
    </div>
</body>

</html>
