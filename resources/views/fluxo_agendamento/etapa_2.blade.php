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

        <!-- Botão de Ação para Avançar -->
        <div class="mt-8 pt-4">
            <button
                type="submit"
                class="w-full h-12 bg-primary text-on-primary font-bold rounded-full flex items-center justify-center hover:bg-primary/90 active:scale-[0.98] transition-all uppercase tracking-wider shadow-md"
            >
                Continuar para Envio de Documentos
            </button>
        </div>
    </form>

</x-layouts.agendamento>