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

        <div class="border border-slate-50 bg-white w-80 h-90 p-13 rounded-xl shadow-md ">
        <h2 class="text-3xl  ">Nova Senha</h2>
        
        <div>
            <h4 class="email pt-5 text-sm ml-1">Digite uma nova senha:</h4>
            <input class="input border-1 border-gray-300 rounded-md pl-10" type="password" name="password" id="password"
                placeholder="Insira a nova senha">            
            <br>
             <h4 class="text-sm mt-4 ml-1">Digite novamente:</h4>
            <input class="input  border-1 border-gray-300 rounded-md pl-10" type="password"  name="password" id="password"
                placeholder="Insira novamente">
            <br><br>
            <button class="butao font-bold cursor-pointer hover:bg-blue-700 bg-clip-border px-19 py-1 bg-blue-500 text-white rounded-lg mt-2" type="submit">Confirmar</a></button>
            </div>
        </div>
</body>
</html>