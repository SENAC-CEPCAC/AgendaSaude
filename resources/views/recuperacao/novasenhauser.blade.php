<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova senha</title>
    
    <link rel="stylesheet" href="/css/perfilPaciente.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#f8fafc]">

    <div class="main flex justify-center items-center h-screen">

        <div class="border border-slate-50 bg-white w-80 h-100 p-12 rounded-xl shadow-md ">
        <h2 class="text-3xl  ">Nova Senha</h2>

        <form method="POST" action="{{ route('recuperacao.senha.atualizar') }}">
            @csrf
            <label class="email pt-5 text-sm ml-1 block">E-mail do usuário</label>
            <input class="input border-1 border-gray-300 rounded-md pl-10" type="email" name="email" id="email"
                placeholder="Digite seu e-mail" value="{{ old('email') }}" required>
            <h4 class="email pt-5 text-sm ml-1">Digite uma nova senha:</h4>
            <input class="input border-1 border-gray-300 rounded-md pl-10" type="password" name="password" id="password"
                placeholder="Insira a nova senha" required minlength="8">
            <br>
             <h4 class="text-sm mt-4 ml-1">Digite novamente:</h4>
            <input class="input  border-1 border-gray-300 rounded-md pl-10" type="password" name="password_confirmation" id="password_confirmation"
                placeholder="Insira novamente" required minlength="8">
            <br><br>
            <button class="butao font-bold cursor-pointer hover:bg-blue-700 bg-clip-border px-19 py-1 bg-blue-500 text-white rounded-lg mt-2" type="submit">Confirmar</button>

            <a href="{{ route('acesso.index') }}" class="mt-5 block text-center text-sm text-blue-800 hover:underline">Voltar</a>
        </form>
        @if ($errors->any())
            <p class="mt-3 text-xs text-red-600">{{ $errors->first() }}</p>
        @endif
        @if (session('status'))
            <p class="mt-3 text-xs text-green-600">{{ session('status') }}</p>
        @endif
        </div>
</body>
</html>