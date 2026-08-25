<!-- Componente de Horários e Vagas Disponíveis -->
<section class="flex flex-col gap-2 my-4" data-horarios id="secao-horarios">
    
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wide flex items-center gap-1.5">
            <span class="material-symbols-outlined text-primary text-[18px]">schedule</span>
            <span id="titulo-data-horarios">
                {{ $cronogramaSelecionado ? 'Horários para ' . $cronogramaSelecionado['data_formatada'] : 'Selecione uma data acima' }}
            </span>
        </h3>

        @if($cronogramaSelecionado && !$cronogramaSelecionado['esgotado'])
            <span class="text-[11px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full font-bold">
                {{ $cronogramaSelecionado['vagas_restantes'] }} vaga(s) disponível(is)
            </span>
        @endif
    </div>

    @if(!$cronogramaSelecionado)
        <!-- Mensagem caso nenhuma data esteja disponível -->
        <div class="p-6 bg-slate-50 border border-dashed border-slate-300 rounded-xl text-center flex flex-col items-center justify-center gap-2">
            <span class="material-symbols-outlined text-slate-400 text-[32px]">event_busy</span>
            <p class="text-xs font-bold text-slate-700">Nenhum atendimento disponível no momento</p>
            <p class="text-[11px] text-slate-500">Aguarde a liberação de novas vagas pelo gestor ou escolha outra unidade móvel.</p>
        </div>
    @elseif($cronogramaSelecionado['esgotado'])
        <!-- Mensagem de Vagas Esgotadas para o dia -->
        <div id="aviso-dia-esgotado" class="p-5 rounded-xl border border-dashed border-amber-300 bg-amber-50/70 text-center flex flex-col items-center justify-center gap-2">
            <span class="material-symbols-outlined text-amber-600 text-[28px]">notifications_active</span>
            <p class="text-xs font-bold text-amber-950">Vagas Regulares Esgotadas para esta Data</p>
            <p class="text-[11px] text-amber-800 max-w-sm">
                Todos os horários regulares deste dia foram preenchidos. Você pode entrar na <strong>Lista de Espera Inteligente</strong> abaixo.
            </p>
        </div>
    @else
        <!-- Grade de Horários com Bloqueio Real de Horários Ocupados -->
        <div id="grade-horarios-disponiveis" class="grid grid-cols-3 sm:grid-cols-4 gap-2 mt-1">
            @php
                $primeiroLivreEncontrado = false;
            @endphp

            @foreach($cronogramaSelecionado['horarios'] as $item)
                @php
                    $isOcupado = $item['ocupado'];
                    $isSelecionado = false;

                    if (!$isOcupado && !$primeiroLivreEncontrado) {
                        $isSelecionado = true;
                        $primeiroLivreEncontrado = true;
                    }
                @endphp

                @if($isOcupado)
                    <!-- HORÁRIO JÁ AGENDADO (BLOQUEADO) -->
                    <div 
                        class="h-11 rounded-lg border border-slate-200 bg-slate-100/90 text-slate-400 opacity-60 flex items-center justify-between px-2.5 font-medium text-xs select-none cursor-not-allowed"
                        title="Horário já reservado por outro paciente"
                    >
                        <span class="line-through">{{ $item['horario'] }}</span>
                        <span class="text-[9px] bg-slate-200 text-slate-600 px-1 py-0.5 rounded font-bold uppercase">Ocupado</span>
                    </div>
                @else
                    <!-- HORÁRIO DISPONÍVEL PARA AGENDAMENTO -->
                    <button
                        type="button"
                        data-hora="{{ $item['horario'] }}"
                        class="btn-horario h-11 rounded-lg border transition-all flex items-center justify-center font-bold text-xs cursor-pointer shadow-2xs
                            {{ $isSelecionado ? 'border-2 border-primary bg-primary-fixed/40 text-primary scale-[1.02] shadow-xs' : 'border-slate-300 bg-white text-slate-700 hover:border-primary hover:bg-slate-50' }}"
                    >
                        {{ $item['horario'] }}
                    </button>
                @endif
            @endforeach
        </div>
    @endif

</section>
