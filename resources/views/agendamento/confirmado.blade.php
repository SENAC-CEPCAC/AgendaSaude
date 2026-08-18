<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmado</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 min-h-screen">

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/50"></div>

    {{-- Modal / Tela de confirmação --}}
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-md bg-[#f7f8fc] rounded-xl shadow-2xl px-6 py-5">
        {{-- Botão fechar --}}
        <div class="flex justify-end">
            <a
                href="{{ route('agendamentos.index') }}"
                class="text-gray-800 hover:text-gray-600 text-lg leading-none"
                aria-label="Fechar"
            >
                &times;
            </a>
        </div>

        <hr class="border-gray-300 mt-3">

        {{-- Conteúdo confirmado --}}
        <div class="flex items-center justify-center gap-2 py-6">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-green-600 font-semibold tracking-wide text-sm">
                {{ session('mensagem_confirmacao', 'CONFIRMADO') }}
            </span>
        </div>

        <hr class="border-gray-300">
    </div>

</body>
</html>