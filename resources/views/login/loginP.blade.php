<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Login</title>
</head>

<body>

    <div class="login-paciente">

        <h2 class="text-3xl font-bold">Login</h2>

        <div>
            <h4 class="block mb-2.5 text-sm font-medium text-heading">E-mail</h4>

            <input
                class="border border-gray-300 rounded-md pl-3"
                type="email"
                name="email"
                placeholder="Digite seu e-mail">

            <h4 class="text-xs">Senha</h4>

            <input
                class="border border-gray-300 rounded-md pl-3"
                type="password"
                name="senha"
                placeholder="Digite sua senha">

            <h2 class="ml-30 text-xs esqueci">
                <a href="/recuperacaoP">Esqueci a senha</a>
            </h2>
        </div>

        <div class="flex mr-20 mt-3">
            <input type="checkbox" class="mr-2">
            <p class="text-sm">Lembrar senha</p>
        </div>

        <button
            class="bg-blue-900 text-white rounded-lg px-22 py-1"
            type="submit">
            Entrar
        </button>

    </div>



</body>

</html>