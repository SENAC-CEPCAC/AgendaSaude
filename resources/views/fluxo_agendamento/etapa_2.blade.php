<x-layouts.agendamento title="Agendamento - Etapa 2">

    <x-agendamento.barra-progresso />

    <form id="form-agendamento-etapa-2" method="POST" action="{{ route('agendamento.salvar_etapa_2') }}" class="flex flex-col">
        @csrf

        <!-- Mensagens de Erro de Validação -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-error-container text-error rounded-xl text-sm font-medium border border-error/20">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-agendamento.titulo_descricao />

        <!-- Campos Ocultos para envio do Agendamento -->
        <input
            type="hidden"
            name="data_selecionada"
            id="input-data-selecionada"
            value="{{ old('data_selecionada', $dados_etapa_2['data_selecionada'] ?? now()->format('Y-m-d')) }}"
        >
        <input
            type="hidden"
            name="horario_selecionado"
            id="input-horario-selecionado"
            value="{{ old('horario_selecionado', $dados_etapa_2['horario_selecionado'] ?? '09:30') }}"
        >
        <input
            type="hidden"
            name="id_agenda"
            id="input-id-agenda"
            value="{{ old('id_agenda', $dados_etapa_2['id_agenda'] ?? ($cronogramas_disponiveis->first()?->id_agenda ?? 1)) }}"
        >

        <!-- Calendário Interativo -->
        <x-agendamento.calendario class="my-5" />

        <!-- Seleção de Horários Disponíveis -->
        <x-agendamento.cx_horario class="my-5" />

        <!-- Banner de Fila de Espera Inteligente (Oculto por padrão; só aparece se o dia selecionado tiver vagas esgotadas) -->
        <div
            id="banner-fila-espera"
            class="hidden mt-2 mb-4 p-4 rounded-xl border border-amber-300 bg-amber-50/90 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-sm transition-all duration-300"
        >
            <div class="flex items-start gap-3 text-xs text-amber-900">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                    <span class="material-symbols-outlined text-[22px]">notifications_active</span>
                </div>
                <div>
                    <strong class="block text-amber-950 font-bold text-sm mb-0.5">Vagas Esgotadas para esta Data</strong>
                    <span class="text-amber-800 leading-snug">
                        Todas as vagas regulares já foram preenchidas. Entre na <strong>Lista de Espera Inteligente</strong> e receba aviso com até 24h de antecedência caso surjam vagas.
                    </span>
                </div>
            </div>
            <button 
                type="button" 
                id="btn-abrir-espera-banner"
                onclick="abrirModalFilaEspera(document.getElementById('input-data-selecionada')?.value || 'Data Selecionada', 'Manhã / Tarde')"
                class="w-full sm:w-auto px-4 py-2.5 bg-amber-500 hover:bg-amber-600 active:scale-[0.98] text-white rounded-lg text-xs font-bold whitespace-nowrap shadow-sm transition-all cursor-pointer flex items-center justify-center gap-1.5 shrink-0"
            >
                <span class="material-symbols-outlined text-[16px]">how_to_reg</span>
                <span>Entrar na Lista de Espera</span>
            </button>
        </div>

        <!-- Botão de Ação para Avançar -->
        <div class="mt-4 pt-4">
            <button
                type="submit"
                id="btn-continuar-etapa-2"
                class="w-full h-12 bg-primary text-on-primary font-bold rounded-full flex items-center justify-center hover:bg-primary/90 active:scale-[0.98] transition-all uppercase tracking-wider shadow-md cursor-pointer"
            >
                Continuar para Envio de Documentos
            </button>
        </div>
    </form>

    <!-- Modal de Vagas Esgotadas & Lista de Espera Inteligente -->
    @include('fluxo_agendamento.modal_fila_espera')

</x-layouts.agendamento>