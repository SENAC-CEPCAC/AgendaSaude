@php
    $etapas = [
        'agendamento.etapa1' => ['numero' => 1, 'titulo' => 'Seleção'],
        'agendamento.etapa2' => ['numero' => 2, 'titulo' => 'Data e horário'],
        'agendamento.etapa3' => ['numero' => 3, 'titulo' => 'Confirmação'],
    ];

    $etapaAtual = $etapas[request()->route()?->getName()] ?? $etapas['agendamento.etapa1'];
    $progresso = ($etapaAtual['numero'] / count($etapas)) * 100;
@endphp

<!-- Progress Stepper -->
<div class="flex-none pt-sm pb-md border-surface-variant z-10">
    <div class="flex justify-between items-center mb-xs">
        <span class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">
            Passo {{ $etapaAtual['numero'] }} de {{ count($etapas) }}
        </span>
        <span class="font-label-bold text-label-bold text-primary">
            {{ $etapaAtual['numero'] }}. {{ $etapaAtual['titulo'] }}
        </span>
    </div>

    <div class="w-full h-[4px] bg-surface-variant rounded-full overflow-hidden">
        <div
            class="h-full bg-secondary-container rounded-full relative transition-all duration-300"
            style="width: {{ $progresso }}%"
            role="progressbar"
            aria-valuenow="{{ $etapaAtual['numero'] }}"
            aria-valuemin="1"
            aria-valuemax="{{ count($etapas) }}"
            aria-label="Passo {{ $etapaAtual['numero'] }} de {{ count($etapas) }}: {{ $etapaAtual['titulo'] }}"
        >
            <div class="absolute inset-0 bg-white/30 w-1/3 blur-[2px] animate-pulse"></div>
        </div>
    </div>
</div>
