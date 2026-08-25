@php
    $diasNoMes = $ultimoDiaMes ? $ultimoDiaMes->day : 31;
    $mesAnterior = $dataBase->copy()->subMonth()->format('Y-m');
    $mesProximo = $dataBase->copy()->addMonth()->format('Y-m');
@endphp

<!-- Calendário Interativo Integrado ao Banco de Dados -->
<section class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/50 overflow-hidden flex flex-col my-4" data-calendario>
    
    <!-- Cabeçalho do Mês e Navegação -->
    <div class="flex justify-between items-center px-4 py-3 border-b border-outline-variant/30 bg-slate-50/50">
        <a 
            href="{{ route('agendamento.etapa2', ['mes_ano' => $mesAnterior]) }}" 
            class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-200 text-slate-700 transition-colors" 
            aria-label="Mês anterior"
        >
            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </a>

        <div class="text-sm font-bold text-primary capitalize">
            {{ $nomeMesAno }}
        </div>

        <a 
            href="{{ route('agendamento.etapa2', ['mes_ano' => $mesProximo]) }}" 
            class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-200 text-slate-700 transition-colors" 
            aria-label="Próximo mês"
        >
            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </a>
    </div>

    <div class="p-4">
        <!-- Dias da Semana -->
        <div class="grid grid-cols-7 gap-1 mb-2 text-center">
            @foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $diaSemana)
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider py-1">{{ $diaSemana }}</div>
            @endforeach
        </div>

        <!-- Grade de Dias do Mês -->
        <div class="grid grid-cols-7 gap-1 text-center">
            
            <!-- Espaçamento dos dias antes do dia 1 -->
            @for ($i = 0; $i < $diaSemanaInicio; $i++)
                <div class="w-9 h-9 mx-auto"></div>
            @endfor

            <!-- Dias Reais do Mês -->
            @for ($dia = 1; $dia <= $diasNoMes; $dia++)
                @php
                    $dataString = $dataBase->copy()->day($dia)->format('Y-m-d');
                    $possuiCronograma = isset($mapaCronogramas[$dataString]);
                    $infoCrono = $possuiCronograma ? $mapaCronogramas[$dataString] : null;
                    $esgotado = $possuiCronograma && $infoCrono['esgotado'];
                    $vagasRestantes = $possuiCronograma ? $infoCrono['vagas_restantes'] : 0;
                    $selecionado = ($dataString === $dataSelecionada);
                @endphp

                @if ($possuiCronograma)
                    <!-- DIA CADASTRADO PELO GESTOR (DISPONÍVEL PARA CLIQUE) -->
                    <button
                        type="button"
                        data-calendar-day
                        data-available="true"
                        data-id-agenda="{{ $infoCrono['id_agenda'] }}"
                        data-vagas-disponiveis="{{ $vagasRestantes }}"
                        data-date="{{ $dataString }}"
                        data-dia-formatado="{{ $infoCrono['data_formatada'] }}"
                        data-esgotado="{{ $esgotado ? 'true' : 'false' }}"
                        data-turno="{{ $infoCrono['turno_nome'] }}"
                        class="btn-dia-calendario font-body-sm text-xs p-1 rounded-full relative flex items-center justify-center w-9 h-9 mx-auto transition-all cursor-pointer font-bold
                            {{ $selecionado && !$esgotado ? 'bg-primary text-white shadow-md scale-105 ring-2 ring-blue-900/30' : '' }}
                            {{ $selecionado && $esgotado ? 'bg-amber-500 text-white shadow-md' : '' }}
                            {{ !$selecionado && $esgotado ? 'text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-300' : '' }}
                            {{ !$selecionado && !$esgotado ? 'text-blue-900 bg-blue-50/80 hover:bg-blue-100 border border-blue-200' : '' }}"
                    >
                        {{ $dia }}
                        @if ($esgotado)
                            <span class="absolute bottom-0.5 w-1.5 h-1.5 bg-amber-500 rounded-full" title="Vagas Esgotadas"></span>
                        @elseif ($vagasRestantes > 5)
                            <span class="absolute bottom-0.5 w-1.5 h-1.5 bg-emerald-500 rounded-full" title="Vagas Disponíveis"></span>
                        @endif
                    </button>
                @else
                    <!-- DIA SEM CRONOGRAMA CADASTRADO (BLOQUEADO / INDISPONÍVEL) -->
                    <div 
                        class="font-body-sm text-xs p-1 rounded-full flex items-center justify-center w-9 h-9 mx-auto text-slate-300 line-through opacity-40 select-none cursor-not-allowed" 
                        title="Sem atendimento cadastrado nesta data"
                        aria-disabled="true"
                    >
                        {{ $dia }}
                    </div>
                @endif
            @endfor

        </div>
    </div>

    <!-- Legenda Inferior -->
    <div class="bg-slate-50 px-4 py-2.5 border-t border-outline-variant/30 flex flex-wrap items-center justify-between gap-2 text-[11px]">
        <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 bg-blue-600 rounded-full inline-block"></span>
            <span class="text-slate-600 font-medium">Dias com Atendimento</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 bg-amber-500 rounded-full inline-block"></span>
            <span class="text-amber-800 font-medium">Vagas Esgotadas (Espera)</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="text-slate-400 line-through text-xs font-semibold">12</span>
            <span class="text-slate-400 font-medium">Sem Atendimento</span>
        </div>
    </div>
</section>
