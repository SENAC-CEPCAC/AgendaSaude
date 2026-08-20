<x-layouts.agendamento title="Agendamento - Etapa 3">

    <x-agendamento.barra-progresso />

    <form id="form-agendamento-etapa-3" method="POST" action="{{ route('agendamento.store') }}" enctype="multipart/form-data" class="flex flex-col">
        @csrf

        <!-- Resumo do Agendamento Escolhido -->
        @if ($unidade_selecionada || $tipo_exame_selecionado || $cronograma_selecionado)
            <div class="mb-5 p-4 bg-primary-fixed/20 border border-primary-fixed-dim rounded-xl flex flex-col gap-2">
                <div class="flex items-center gap-2 text-primary font-bold text-xs uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[18px]">event_available</span>
                    Resumo do Agendamento
                </div>
                <div class="text-xs text-on-surface flex flex-col gap-1">
                    <p><strong>Exame:</strong> {{ $tipo_exame_selecionado ? $tipo_exame_selecionado->tipo_exame : 'Preventivo / Mamografia' }}</p>
                    <p><strong>Unidade:</strong> {{ $unidade_selecionada ? $unidade_selecionada->nome_unidade : 'Unidade Móvel Centro' }}</p>
                    <p><strong>Data & Horário:</strong> 
                        {{ !empty($dados_etapa_2['data_selecionada']) ? \Carbon\Carbon::parse($dados_etapa_2['data_selecionada'])->format('d/m/Y') : now()->format('d/m/Y') }} 
                        às {{ $dados_etapa_2['horario_selecionado'] ?? '09:30' }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Alertas de Erros de Validação -->
        @if ($errors->any())
            <div class="mb-5 p-4 bg-error-container text-error rounded-xl text-sm font-medium border border-error/20">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <span class="material-symbols-outlined text-[20px]">error</span>
                    Atenção aos documentos enviados:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-agendamento.titulo_descricao />

        <!-- Campo Opcional de CPF do Paciente para Triagem e Vinculação -->
        <div class="mb-5 flex flex-col gap-1">
            <label for="cpf_paciente" class="font-label-bold text-label-bold text-on-background font-semibold text-xs">
                CPF do(a) Paciente (Opcional se já autenticado)
            </label>
            <input
                type="text"
                id="cpf_paciente"
                name="cpf_paciente"
                placeholder="000.000.000-00"
                value="{{ old('cpf_paciente') }}"
                class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-3 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"
            >
        </div>

        <!-- Upload Zone 1: RG/CPF -->
        <section class="flex flex-col gap-sm mb-5">

            <div class="flex items-center justify-between mb-2">
                <label class="font-label-bold text-label-bold text-on-background font-semibold">Documento de Identificação (RG ou CPF)</label>
                <span class="font-label-md text-label-md text-error bg-error-container px-2 py-0.5 rounded-sm font-medium">Obrigatório</span>
            </div>

            <div class="relative w-full">
                <label
                    for="input-rg-cpf"
                    id="label-rg-cpf"
                    class="cursor-pointer relative w-full flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-outline-variant bg-surface hover:bg-surface-container-low active:bg-surface-container transition-all group overflow-hidden"
                >
                    <!-- Placeholder Inicial -->
                    <div id="placeholder-rg-cpf" class="flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-primary text-[32px]">add_a_photo</span>
                        </div>
                        <span class="font-h3 text-h3 text-primary mb-1 font-semibold">Tirar foto ou enviar</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">Tamanho máximo: 5MB</span>
                    </div>

                    <!-- Container do Preview (Inicialmente Oculto) -->
                    <div id="preview-container-rg-cpf" class="hidden w-full flex flex-col items-center gap-3">
                        <div class="relative w-full overflow-hidden rounded-lg border border-outline-variant bg-surface-container-lowest max-h-64 flex items-center justify-center">
                            <img id="preview-img-rg-cpf" src="" alt="Pré-visualização do RG/CPF" class="w-full h-auto max-h-60 object-contain rounded-lg">
                            
                            <!-- Fallback para PDF ou outros arquivos -->
                            <div id="file-info-rg-cpf" class="hidden flex flex-col items-center justify-center p-6 text-center">
                                <span class="material-symbols-outlined text-primary text-[48px] mb-2">picture_as_pdf</span>
                                <span id="file-name-rg-cpf" class="font-semibold text-on-background text-sm break-all"></span>
                                <span id="file-size-rg-cpf" class="text-xs text-on-surface-variant mt-1"></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full justify-between pt-1">
                            <span class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                Arquivo selecionado
                            </span>

                            <button
                                type="button"
                                id="btn-remover-rg-cpf"
                                class="text-xs text-error hover:text-error/80 font-semibold px-2.5 py-1 rounded-md hover:bg-error-container/40 transition-colors flex items-center gap-1"
                            >
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                Remover
                            </button>
                        </div>
                    </div>

                    <input id="input-rg-cpf" name="documento_rg_cpf" type="file" accept="image/*,application/pdf" class="hidden" />
                </label>
            </div>
        </section>

        <!-- Upload Zone 2: Requisição Médica -->
        <section class="flex flex-col gap-sm mb-5">

            <div class="flex items-center justify-between mb-2">
                <label class="font-label-bold text-label-bold text-on-background font-semibold">Requisição Médica</label>
                <span class="font-label-md text-label-md text-on-surface-variant bg-surface-variant px-2 py-0.5 rounded-sm font-medium">Se possuir</span>
            </div>

            <div class="relative w-full">
                <label
                    for="input-requisicao"
                    id="label-requisicao"
                    class="cursor-pointer relative w-full flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-outline-variant bg-surface hover:bg-surface-container-low active:bg-surface-container transition-all group overflow-hidden"
                >
                    <!-- Placeholder Inicial -->
                    <div id="placeholder-requisicao" class="flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 rounded-full bg-surface-container-highest flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-outline text-[32px]">upload_file</span>
                        </div>
                        <span class="font-h3 text-h3 text-on-surface mb-1 font-semibold">Adicionar arquivo</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">Toque para selecionar do dispositivo</span>
                    </div>

                    <!-- Container do Preview (Inicialmente Oculto) -->
                    <div id="preview-container-requisicao" class="hidden w-full flex flex-col items-center gap-3">
                        <div class="relative w-full overflow-hidden rounded-lg border border-outline-variant bg-surface-container-lowest max-h-64 flex items-center justify-center">
                            <img id="preview-img-requisicao" src="" alt="Pré-visualização da Requisição" class="w-full h-auto max-h-60 object-contain rounded-lg">
                            
                            <!-- Fallback para PDF ou outros arquivos -->
                            <div id="file-info-requisicao" class="hidden flex flex-col items-center justify-center p-6 text-center">
                                <span class="material-symbols-outlined text-primary text-[48px] mb-2">picture_as_pdf</span>
                                <span id="file-name-requisicao" class="font-semibold text-on-background text-sm break-all"></span>
                                <span id="file-size-requisicao" class="text-xs text-on-surface-variant mt-1"></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full justify-between pt-1">
                            <span class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                Arquivo selecionado
                            </span>

                            <button
                                type="button"
                                id="btn-remover-requisicao"
                                class="text-xs text-error hover:text-error/80 font-semibold px-2.5 py-1 rounded-md hover:bg-error-container/40 transition-colors flex items-center gap-1"
                            >
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                Remover
                            </button>
                        </div>
                    </div>

                    <input id="input-requisicao" name="documento_requisicao" type="file" accept="image/*,application/pdf" class="hidden" />
                </label>
            </div>
        </section>

        <!-- Banner Informativo -->
        <div class="flex items-center gap-sm p-4 bg-primary-fixed-dim/20 rounded-lg border border-primary-fixed-dim mb-6">
            <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">info</span>
            <p class="font-label-md text-label-md text-on-background text-xs">
                Formatos aceitos: PDF, JPG, PNG (máx. 5MB por arquivo).
            </p>
        </div>

        <!-- Botão de Confirmação Final -->
        <div class="pt-2 pb-6">
            <button
                type="submit"
                id="btn-confirmar-agendamento"
                class="w-full h-12 bg-primary text-on-primary font-bold rounded-full flex items-center justify-center hover:bg-primary/90 active:scale-[0.98] transition-all uppercase tracking-wider shadow-md"
            >
                Finalizar e Confirmar Agendamento
            </button>
        </div>
    </form>

</x-layouts.agendamento>