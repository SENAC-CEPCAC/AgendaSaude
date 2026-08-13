@php
    $rotasAnteriores = [
        'agendamento.etapa1' => 'agendamento.etapa1',
        'agendamento.etapa2' => 'agendamento.etapa1',
        'agendamento.etapa3' => 'agendamento.etapa2',
    ];

    $rotaAtual = request()->route()?->getName();
    $rotaVoltar = $rotasAnteriores[$rotaAtual] ?? 'agendamento.etapa1';
@endphp

<header class="sticky top-0 z-50 w-full bg-surface-container-lowest/90 backdrop-blur-md border-b border-surface-variant px-margin h-16 flex items-center justify-between">

    <a
        href="{{ route($rotaVoltar) }}"
        aria-label="Voltar"
        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-low transition-colors active:scale-95 text-on-surface"
    >
        <span class="material-symbols-outlined text-[24px]">arrow_back</span>
    </a>

    <h1 class="font-h3 text-h3 text-primary truncate max-w-[200px]">Novo Agendamento</h1>

    <div class="w-10 h-10"></div> <!-- Spacer for centering -->

</header>
