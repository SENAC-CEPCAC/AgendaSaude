<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso restrito</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex min-h-screen items-center justify-center bg-slate-100 px-4 text-slate-800">
    <main class="w-full max-w-sm rounded-xl bg-white p-6 shadow-lg sm:p-8">
        <h1 class="text-2xl font-bold text-slate-800">Acesso restrito</h1>
        <p class="mt-2 text-sm text-slate-500">Entre com os dados do colaborador.</p>

        @if ($errors->any())
        <div class="mt-5 rounded-lg border border-rose-100 bg-rose-50 px-3 py-2 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.colaborador.attempt') }}" class="mt-6 space-y-4">
            @csrf
            <label class="block text-sm font-semibold text-slate-600">E-mail
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 outline-none focus:border-blue-600 focus:bg-white">
            </label>
            <label class="block text-sm font-semibold text-slate-600">Senha
                <input type="password" name="password" required class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 outline-none focus:border-blue-600 focus:bg-white">
            </label>
            <label class="ml-37 text-xs esqueci justify-end flex text-right ">
                <a href="{{ route('recuperacao.novasenha') }}">Esqueci a senha</a>
            </label>
            <button type="submit" class="w-full rounded-lg bg-blue-800 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-900">Entrar</button>
        </form>

        <a href="{{ route('acesso.index') }}" class="mt-5 block text-center text-sm text-blue-800 hover:underline">Voltar</a>
    </main>
</body>

</html>