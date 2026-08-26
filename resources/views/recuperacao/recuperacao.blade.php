<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação</title>
    
    <link rel="stylesheet" href="/css/perfilPaciente.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#f8fafc]">

    <div class="main flex justify-center items-center h-screen ">

        <div class="border border-slate-50 rounded-xl shadow-md bg-white w-80 h-100 shadow-sm p-15 ">
        <h2 class="text-3xl ">Recuperação</h2>
        
        <form method="GET" action="{{ route('recuperacao.novasenha') }}">
            <h4 class="email text-xs pt-10 ml-1">Digite seu E-mail</h4>
            <input class="input pt-2 border-1 border-gray-300 rounded-md pl-4" type="email" name="email" id="email"
                placeholder="Digite seu e-mail" value="{{ old('email') }}" required>
            <button id="recuperar-button" class="butao cursor-pointer hover:bg-blue-700 font-bold bg-clip-border px-15.5 py-1 bg-blue-500 text-white rounded-lg mt-2" type="submit">Recuperar</button>

            <a href="{{ route('acesso.index') }}" class="mt-5 block text-center text-sm text-blue-800 hover:underline">Voltar</a>
        </form>
        </div>
       
        

    </div>

</body>
</html>