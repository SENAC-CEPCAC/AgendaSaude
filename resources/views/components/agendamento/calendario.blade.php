@php
    $diasDisponiveis = range(13, 30);
    $diaSelecionado = 15;
    $diasAltaDisponibilidade = [14, 16];
@endphp

<!-- Calendar Component -->
<section class="bg-surface-container-lowest rounded-lg shadow-[0_12px_12px_rgba(0,62,126,0.04)] border border-outline-variant/30 overflow-hidden flex flex-col" data-calendario>
    <div class="flex justify-between items-center p-md border-b border-outline-variant/30">
        <button class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-surface-container text-on-surface-variant transition-colors" type="button" aria-label="Mês anterior">
            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </button>
        <div class="font-h3 text-h3 text-primary-container">Novembro 2023</div>
        <button class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-surface-container text-on-surface-variant transition-colors" type="button" aria-label="Próximo mês">
            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </button>
    </div>

    <div class="p-md">
        <div class="grid grid-cols-7 gap-1 mb-sm text-center">
            @foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $diaSemana)
                <div class="font-label-md text-label-md text-on-surface-variant py-sm">{{ $diaSemana }}</div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1 text-center">
            @foreach ([29, 30, 31] as $dia)
                <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">{{ $dia }}</div>
            @endforeach

            @foreach (range(1, 12) as $dia)
                <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50" aria-disabled="true">{{ $dia }}</div>
            @endforeach

            @foreach ($diasDisponiveis as $dia)
                @php
                    $selecionado = $dia === $diaSelecionado;
                    $altaDisponibilidade = in_array($dia, $diasAltaDisponibilidade, true);
                @endphp
                <button
                    type="button"
                    data-calendar-day
                    data-available="true"
                    data-date="2023-11-{{ str_pad($dia, 2, '0', STR_PAD_LEFT) }}"
                    aria-label="{{ $dia }} de novembro de 2023"
                    aria-pressed="{{ $selecionado ? 'true' : 'false' }}"
                    @class([
                        'font-body-sm text-body-sm p-2 rounded-full relative flex items-center justify-center w-10 h-10 mx-auto transition-colors',
                        'bg-primary-container text-on-primary shadow-md font-medium' => $selecionado,
                        'text-on-surface hover:bg-surface-container' => ! $selecionado,
                    ])
                >
                    {{ $dia }}
                    @if ($altaDisponibilidade)
                        <span class="absolute bottom-1 w-1 h-1 bg-secondary-container rounded-full" aria-hidden="true"></span>
                    @endif
                </button>
            @endforeach

            @foreach ([1, 2] as $dia)
                <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">{{ $dia }}</div>
            @endforeach
        </div>
    </div>

    <div class="bg-surface-container-low px-md py-sm border-t border-outline-variant/30 flex items-center gap-2">
        <span class="w-2 h-2 bg-secondary-container rounded-full inline-block"></span>
        <span class="font-label-md text-label-md text-on-surface-variant">Dias com alta disponibilidade</span>
    </div>
</section>
