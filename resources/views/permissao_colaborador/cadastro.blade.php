<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

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

        <div class="border border-slate-50 rounded-xl shadow-md bg-white w-80 h-170  p-13 ">
            <h2 class="text-3xl ">Crie sua conta</h2>
            <div>
                <h4 class="nome text-xs mt-6">Nome</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="nome" id="name"
                    placeholder="Seu nome">
                <h4 class="text-xs pt-2 mt-2">Sobrenome</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm"type="text" name="sobrenome" id="sobrenome "
                       
                    placeholder="Seu sobrenome">
                    <h4 class="text-xs pt-2 mt-2">CPF</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="cpf" id="cpf"
                    placeholder="000.000.000-00">
                      <h4 class="text-xs pt-2 mt-2">RG</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="rg" id="rg"
                    placeholder="000.000.000-0">
                    <h4 class="nome text-xs pt-2 mt-2">E-mail</h4>
                <input class="input border-1 pt-1 border-gray-300  rounded-md pl-9 placeholder:text-sm" type="email" name="email" id="email"
                    placeholder="seu@email.com">
               <h4 class="nome text-xs pt-2 mt-2">Telefone (WhatsApp)</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="nome" id="name"
                    placeholder="(00) 00000-0000">
                   
            </div>
            <div class="flex  mt-3">
                <input type="checkbox" class="mr-2 mt-4">
                <p class="lembrar ml- text-sm mt-4">Aceito os termos de uso e a política de privacidade da plataforma</p>
            </div>
            <button class="butao cursor-pointer hover:bg-blue-700 font-bold bg-clip-border px-22 py-1 bg-blue-500 text-white rounded-lg mt-6"
                type="submit">Entrar</button>

        </div>
    </div>
</body>

</html>