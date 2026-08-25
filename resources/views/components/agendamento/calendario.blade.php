@php
    $diasDisponiveis = range(13, 30);
    $diaSelecionado = 15;
    $diasAltaDisponibilidade = [14, 16];
    $diasEsgotados = [17, 20, 25, 28]; // Dias sem vagas regulares (acionam a Lista de Espera Inteligente)
@endphp

<!-- Calendar Component -->
<section class="bg-surface-container-lowest rounded-lg shadow-[0_12px_12px_rgba(0,62,126,0.04)] border border-outline-variant/30 overflow-hidden flex flex-col" data-calendario>
    <div class="flex justify-between items-center p-md border-b border-outline-variant/30">
        <button class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-surface-container text-on-surface-variant transition-colors" type="button" aria-label="Mês anterior">
            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </button>
        <div class="font-h3 text-h3 text-primary-container font-semibold">Novembro 2026</div>
        <button class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-surface-container text-on-surface-variant transition-colors" type="button" aria-label="Próximo mês">
            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </button>
    </div>

    <div class="p-md">
        <div class="grid grid-cols-7 gap-1 mb-sm text-center">
            @foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $diaSemana)
                <div class="font-label-md text-label-md text-on-surface-variant py-sm font-medium">{{ $diaSemana }}</div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1 text-center">
            @foreach ([29, 30, 31] as $dia)
                <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">{{ $dia }}</div>
            @endforeach

            @foreach (range(1, 12) as $dia)
                <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-40 select-none" aria-disabled="true">{{ $dia }}</div>
            @endforeach

            @foreach ($diasDisponiveis as $dia)
                @php
                    $selecionado = ($dia === $diaSelecionado);
                    $altaDisponibilidade = in_array($dia, $diasAltaDisponibilidade, true);
                    $esgotado = in_array($dia, $diasEsgotados, true);
                    $vagas = $esgotado ? 0 : ($altaDisponibilidade ? 12 : 6);
                @endphp
                <button
                    type="button"
                    data-calendar-day
                    data-available="true"
                    data-vagas-disponiveis="{{ $vagas }}"
                    data-date="2026-11-{{ str_pad($dia, 2, '0', STR_PAD_LEFT) }}"
                    data-dia-formatado="{{ $dia }} de Novembro de 2026"
                    aria-label="{{ $dia }} de novembro de 2026 {{ $esgotado ? '(Vagas Esgotadas)' : '' }}"
                    aria-pressed="{{ $selecionado ? 'true' : 'false' }}"
                    @class([
                        'font-body-sm text-body-sm p-2 rounded-full relative flex items-center justify-center w-10 h-10 mx-auto transition-colors cursor-pointer',
                        'bg-primary-container text-on-primary shadow-md font-medium' => $selecionado && ! $esgotado,
                        'bg-amber-500 text-white shadow-md font-medium' => $selecionado && $esgotado,
                        'text-amber-700 bg-amber-50/70 hover:bg-amber-100 border border-amber-300/50' => $esgotado && ! $selecionado,
                        'text-on-surface hover:bg-surface-container' => ! $selecionado && ! $esgotado,
                    ])
                >
                    {{ $dia }}
                    @if ($altaDisponibilidade)
                        <span class="absolute bottom-1 w-1 h-1 bg-secondary-container rounded-full" aria-hidden="true"></span>
                    @elseif ($esgotado)
                        <span class="absolute bottom-1 w-1.5 h-1.5 bg-amber-500 rounded-full" aria-hidden="true" title="Vagas Esgotadas"></span>
                    @endif
                </button>
            @endforeach

            @foreach ([1, 2] as $dia)
                <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">{{ $dia }}</div>
            @endforeach
        </div>
    </div>

    <div class="bg-surface-container-low px-md py-sm border-t border-outline-variant/30 flex flex-wrap items-center justify-between gap-2 text-xs">
        <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 bg-secondary-container rounded-full inline-block"></span>
            <span class="font-label-md text-label-md text-on-surface-variant">Alta disponibilidade</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 bg-amber-500 rounded-full inline-block"></span>
            <span class="font-label-md text-label-md text-amber-800 font-medium">Vagas esgotadas</span>
        </div>
    </div>
</section>
