<x-layouts.agendamento title="Agendamento - Etapa 1">

    <x-agendamento.barra-progresso />

    <form id="form-agendamento-etapa-1" method="POST" action="{{ route('agendamento.salvar_etapa_1') }}" class="flex flex-col">
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

        <!-- Seleção de Especialidade / Tipo de Exame -->
        <section class="flex flex-col gap-2">
            <x-agendamento.titulo_descricao />

            <div class="relative" id="especialidade">
                <!-- Input Oculto que guarda o ID da Vaga / Exame -->
                <input type="hidden" name="id_vagas" id="input-id-vagas" value="{{ old('id_vagas', $dados_etapa_1['id_vagas'] ?? 1) }}">

                <button
                    id="btn-especialidade"
                    type="button"
                    aria-expanded="false"
                    class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-4
                           flex items-center justify-between text-left shadow-sm
                           transition-all duration-200
                           hover:border-primary hover:shadow-md
                           focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-fixed"
                >
                    @php
                        $exame_atual = $tipos_exames->firstWhere('id_vagas', old('id_vagas', $dados_etapa_1['id_vagas'] ?? 1));
                    @endphp
                    <span id="texto-especialidade" class="text-body-md text-on-surface font-medium">
                        {{ $exame_atual ? $exame_atual->tipo_exame : 'Selecione a especialidade...' }}
                    </span>

                    <span
                        id="icone-especialidade"
                        class="material-symbols-outlined text-outline transition-transform duration-200"
                    >
                        keyboard_arrow_down
                    </span>
                </button>

                <div
                    id="lista-especialidades"
                    class="absolute z-20 mt-2 w-full overflow-hidden rounded-lg border border-outline-variant
                           bg-surface-container-lowest shadow-lg origin-top
                           opacity-0 scale-95 pointer-events-none
                           transition-all duration-200"
                >
                    @forelse($tipos_exames as $exame)
                        <button
                            type="button"
                            data-especialidade="{{ $exame->tipo_exame }}"
                            data-id="{{ $exame->id_vagas }}"
                            class="opcao-especialidade w-full px-4 py-3 text-left text-on-surface transition-colors hover:bg-primary-fixed flex items-center justify-between"
                        >
                            <span>{{ $exame->tipo_exame }}</span>
                            @if($exame->id_vagas == 1)
                                <span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-semibold">Preventivo</span>
                            @else
                                <span class="text-xs bg-pink-100 text-pink-800 px-2 py-0.5 rounded-full font-semibold">Mamografia</span>
                            @endif
                        </button>
                    @empty
                        <button type="button" data-especialidade="Preventivo (Siscolo)" data-id="1" class="opcao-especialidade w-full px-4 py-3 text-left text-on-surface hover:bg-primary-fixed">
                            Preventivo (Siscolo)
                        </button>
                        <button type="button" data-especialidade="Mamografia (Sismama)" data-id="2" class="opcao-especialidade w-full px-4 py-3 text-left text-on-surface hover:bg-primary-fixed">
                            Mamografia (Sismama)
                        </button>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Seleção de Unidade Móvel -->
        <section class="mt-8 flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h2 class="text-h2 font-semibold text-on-background">
                    Unidades Móveis Disponíveis
                </h2>

                <button
                    type="button"
                    aria-label="Usar minha localização"
                    class="p-2 text-primary rounded-full transition-colors hover:bg-primary-fixed"
                >
                    <span class="material-symbols-outlined">my_location</span>
                </button>
            </div>

            @php
                $unidade_selecionada_id = old('id_cnes_unidade', $dados_etapa_1['id_cnes_unidade'] ?? 1);
            @endphp

            @forelse($unidades_moveis as $index => $unidade)
                <label class="cursor-pointer">
                    <input
                        type="radio"
                        name="id_cnes_unidade"
                        value="{{ $unidade->id_cnes_unidade }}"
                        class="peer sr-only"
                        {{ $unidade_selecionada_id == $unidade->id_cnes_unidade ? 'checked' : '' }}
                    >

                    <div
                        class="bg-surface-container-lowest border-2 border-outline-variant rounded-lg p-4
                               flex flex-col gap-4 shadow-sm cursor-pointer
                               transition-all duration-200 ease-out
                               hover:-translate-y-1 hover:border-primary hover:shadow-md
                               peer-checked:border-primary peer-checked:bg-primary-fixed/20 peer-checked:shadow-md
                               peer-checked:[&_.indicador]:border-primary
                               peer-checked:[&_.ponto]:scale-100"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-h3 font-semibold text-on-background">
                                    {{ $unidade->nome_unidade }}
                                </h3>

                                <p class="text-body-sm text-on-surface-variant mt-1">
                                    CNES: {{ $unidade->codigo_cnes }} • Itinerante
                                </p>
                            </div>

                            <span class="bg-primary text-on-primary px-2.5 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                                {{ $index === 0 ? '1,2 km' : '3,5 km' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-body-sm text-emerald-600 font-medium">Aberta para agendamento</span>
                            </div>

                            <div class="indicador w-6 h-6 rounded-full border-2 border-outline-variant flex items-center justify-center transition-colors">
                                <div class="ponto w-3 h-3 rounded-full bg-primary scale-0 transition-transform duration-200"></div>
                            </div>
                        </div>
                    </div>
                </label>
            @empty
                <!-- Fallback caso não haja unidades no banco -->
                <label class="cursor-pointer">
                    <input type="radio" name="id_cnes_unidade" value="1" class="peer sr-only" checked>
                    <div class="bg-surface-container-lowest border-2 border-outline-variant rounded-lg p-4 flex flex-col gap-4 peer-checked:border-primary peer-checked:bg-primary-fixed/20">
                        <div class="flex items-start justify-between">
                            <h3 class="font-semibold text-on-background">Unidade Móvel 01 - Centro</h3>
                            <span class="bg-primary text-on-primary px-2 py-1 rounded-full text-xs font-bold">1,2 km</span>
                        </div>
                    </div>
                </label>
            @endforelse
        </section>

        <!-- Botão de Ação para Avançar -->
        <div class="mt-8 pt-4">
            <button
                type="submit"
                class="w-full h-12 bg-primary text-on-primary font-bold rounded-full flex items-center justify-center hover:bg-primary/90 active:scale-[0.98] transition-all uppercase tracking-wider shadow-md"
            >
                Continuar para Data e Horário
            </button>
        </div>
    </form>

</x-layouts.agendamento>