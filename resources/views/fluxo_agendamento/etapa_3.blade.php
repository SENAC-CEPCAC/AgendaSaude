<x-layouts.agendamento title="Agendamento - Etapa 3">

    <x-agendamento.barra-progresso />

    <form id="form-agendamento-etapa-3" method="POST" action="{{ route('agendamento.store') }}" enctype="multipart/form-data" class="flex flex-col">
        @csrf

        <!-- Dados Ocultos para o Modal de Resumo -->
        <input type="hidden" id="resumo-exame" value="{{ $tipo_exame_selecionado ? $tipo_exame_selecionado->tipo_exame : 'Preventivo / Mamografia' }}">
        <input type="hidden" id="resumo-unidade" value="{{ $unidade_selecionada ? $unidade_selecionada->nome_unidade : 'Unidade Móvel de Atendimento' }}">
        <input type="hidden" id="resumo-data-hora" value="{{ !empty($dados_etapa_2['data_selecionada']) ? \Carbon\Carbon::parse($dados_etapa_2['data_selecionada'])->format('d/m/Y') : now()->format('d/m/Y') }} às {{ $dados_etapa_2['horario_selecionado'] ?? '09:30' }}">

        <!-- Alertas de Erros de Validação -->
        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-50 text-red-700 rounded-xl text-sm font-medium border border-red-200">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <span class="material-symbols-outlined text-[20px]">error</span>
                    Atenção:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-agendamento.titulo_descricao />

        <!-- Campo de CPF do Paciente -->
        <div class="mb-5 flex flex-col gap-1">
            <label for="cpf_paciente" class="font-label-bold text-label-bold text-on-background font-semibold text-xs flex items-center justify-between">
                <span>CPF do(a) Paciente</span>
            </label>
            <input
                type="text"
                id="cpf_paciente"
                name="cpf_paciente"
                placeholder="000.000.000-00"
                maxlength="14"
                value="{{ old('cpf_paciente', $pacienteLogado?->cpf_paciente ?? $usuarioLogado?->cpf_paciente ?? $usuarioLogado?->cpf ?? '') }}"
                required
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

                    <!-- Container do Preview -->
                    <div id="preview-container-rg-cpf" class="hidden w-full flex flex-col items-center gap-3">
                        <div class="relative w-full overflow-hidden rounded-lg border border-outline-variant bg-surface-container-lowest max-h-64 flex items-center justify-center">
                            <img id="preview-img-rg-cpf" src="" alt="Pré-visualização" class="w-full h-auto max-h-60 object-contain rounded-lg">
                            <div id="file-info-rg-cpf" class="hidden flex flex-col items-center justify-center p-6 text-center">
                                <span class="material-symbols-outlined text-primary text-[48px] mb-2">picture_as_pdf</span>
                                <span id="file-name-rg-cpf" class="font-semibold text-on-background text-sm break-all"></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full justify-between pt-1">
                            <span class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                Arquivo selecionado
                            </span>

                            <button type="button" id="btn-remover-rg-cpf" class="text-xs text-error hover:text-error/80 font-semibold px-2.5 py-1 rounded-md hover:bg-error-container/40 transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">delete</span> Remover
                            </button>
                        </div>
                    </div>

                    <input id="input-rg-cpf" name="documento_rg_cpf" type="file" accept="image/*,application/pdf" class="hidden" required />
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
                    <div id="placeholder-requisicao" class="flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 rounded-full bg-surface-container-highest flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-outline text-[32px]">upload_file</span>
                        </div>
                        <span class="font-h3 text-h3 text-on-surface mb-1 font-semibold">Adicionar arquivo</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">Toque para selecionar do dispositivo</span>
                    </div>

                    <div id="preview-container-requisicao" class="hidden w-full flex flex-col items-center gap-3">
                        <div class="relative w-full overflow-hidden rounded-lg border border-outline-variant bg-surface-container-lowest max-h-64 flex items-center justify-center">
                            <img id="preview-img-requisicao" src="" alt="Pré-visualização" class="w-full h-auto max-h-60 object-contain rounded-lg">
                            <div id="file-info-requisicao" class="hidden flex flex-col items-center justify-center p-6 text-center">
                                <span class="material-symbols-outlined text-primary text-[48px] mb-2">picture_as_pdf</span>
                                <span id="file-name-requisicao" class="font-semibold text-on-background text-sm break-all"></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full justify-between pt-1">
                            <span class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                Arquivo selecionado
                            </span>

                            <button type="button" id="btn-remover-requisicao" class="text-xs text-error hover:text-error/80 font-semibold px-2.5 py-1 rounded-md hover:bg-error-container/40 transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">delete</span> Remover
                            </button>
                        </div>
                    </div>

                    <input id="input-requisicao" name="documento_requisicao" type="file" accept="image/*,application/pdf" class="hidden" />
                </label>
            </div>
        </section>

        <!-- Botões de Ação -->
        <div class="pt-2 pb-6 flex gap-3">
            <a
                href="{{ route('agendamento.etapa2') }}"
                class="w-1/3 h-12 border border-gray-300 bg-white text-gray-700 font-medium rounded-full flex items-center justify-center hover:bg-gray-50 active:scale-[0.98] transition-all text-xs uppercase tracking-wider"
            >
                Voltar
            </a>

            <button
                type="button"
                id="btn-abrir-resumo-modal"
                class="w-2/3 h-12 bg-primary text-on-primary font-bold rounded-full flex items-center justify-center hover:bg-primary/90 active:scale-[0.98] transition-all uppercase tracking-wider text-xs shadow-md cursor-pointer"
            >
                Avançar para Confirmação
            </button>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL DE CONFIRMAÇÃO (Design Padrão do Projeto) -->
        <!-- ========================================================================= -->
        <div id="modal-confirmacao-resumo" class="fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50 hidden">
            <div class="bg-[#f5f6fb] w-full max-w-sm rounded-xl shadow-2xl relative px-6 py-6">

                <!-- Botão fechar -->
                <button type="button" id="btn-fechar-modal-x" class="absolute top-4 right-5 text-black text-xl font-medium hover:text-gray-600 cursor-pointer">
                    &times;
                </button>

                <!-- Título -->
                <h2 class="text-center text-2xl font-bold text-gray-900 mb-2">
                    Confirmação
                </h2>

                <hr class="border-gray-300 mb-4">

                <!-- Resumo dos Dados -->
                <div class="space-y-2 text-xs text-gray-700 mb-4">
                    <p><strong>CPF:</strong> <span id="modal-paciente-cpf">--</span></p>
                    <p><strong>Exame:</strong> <span id="modal-exame">--</span></p>
                    <p><strong>Unidade:</strong> <span id="modal-unidade">--</span></p>
                    <p><strong>Data/Hora:</strong> <span id="modal-data-hora">--</span></p>
                    <p><strong>Documento:</strong> <span class="text-green-700 font-bold">Anexado ✓</span></p>
                </div>

                <hr class="border-gray-300 mb-4">

                <p class="text-gray-800 text-sm mb-6 text-center">
                    Deseja <span class="font-bold">CONFIRMAR</span> o Agendamento?
                </p>

                <!-- Botões -->
                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        id="btn-modal-voltar"
                        class="border border-gray-300 bg-white text-gray-700 font-medium px-4 py-2 rounded-lg hover:bg-gray-50 text-xs cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        id="btn-modal-confirmar"
                        class="bg-green-600 text-white font-medium px-5 py-2 rounded-lg hover:bg-green-700 shadow text-xs cursor-pointer"
                    >
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputRgCpf = document.getElementById('input-rg-cpf');
            const placeholderRgCpf = document.getElementById('placeholder-rg-cpf');
            const previewContainerRgCpf = document.getElementById('preview-container-rg-cpf');
            const previewImgRgCpf = document.getElementById('preview-img-rg-cpf');
            const fileInfoRgCpf = document.getElementById('file-info-rg-cpf');
            const fileNameRgCpf = document.getElementById('file-name-rg-cpf');
            const btnRemoverRgCpf = document.getElementById('btn-remover-rg-cpf');

            const inputReq = document.getElementById('input-requisicao');
            const placeholderReq = document.getElementById('placeholder-requisicao');
            const previewContainerReq = document.getElementById('preview-container-requisicao');
            const previewImgReq = document.getElementById('preview-img-requisicao');
            const fileInfoReq = document.getElementById('file-info-requisicao');
            const fileNameReq = document.getElementById('file-name-requisicao');
            const btnRemoverReq = document.getElementById('btn-remover-requisicao');

            const modal = document.getElementById('modal-confirmacao-resumo');
            const btnAbrirModal = document.getElementById('btn-abrir-resumo-modal');
            const btnFecharModalX = document.getElementById('btn-fechar-modal-x');
            const btnModalVoltar = document.getElementById('btn-modal-voltar');

            inputRgCpf.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        previewImgRgCpf.src = event.target.result;
                        previewImgRgCpf.classList.remove('hidden');
                        fileInfoRgCpf.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImgRgCpf.classList.add('hidden');
                    fileInfoRgCpf.classList.remove('hidden');
                    fileNameRgCpf.textContent = file.name;
                }

                placeholderRgCpf.classList.add('hidden');
                previewContainerRgCpf.classList.remove('hidden');
            });

            btnRemoverRgCpf.addEventListener('click', function (e) {
                e.preventDefault();
                inputRgCpf.value = '';
                previewImgRgCpf.src = '';
                placeholderRgCpf.classList.remove('hidden');
                previewContainerRgCpf.classList.add('hidden');
            });

            inputReq.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        previewImgReq.src = event.target.result;
                        previewImgReq.classList.remove('hidden');
                        fileInfoReq.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImgReq.classList.add('hidden');
                    fileInfoReq.classList.remove('hidden');
                    fileNameReq.textContent = file.name;
                }

                placeholderReq.classList.add('hidden');
                previewContainerReq.classList.remove('hidden');
            });

            btnRemoverReq.addEventListener('click', function (e) {
                e.preventDefault();
                inputReq.value = '';
                previewImgReq.src = '';
                placeholderReq.classList.remove('hidden');
                previewContainerReq.classList.add('hidden');
            });

            btnAbrirModal.addEventListener('click', function () {
                const cpfInput = document.getElementById('cpf_paciente');
                if (!cpfInput.value.trim()) {
                    alert('Por favor, informe o CPF do paciente.');
                    cpfInput.focus();
                    return;
                }

                if (!inputRgCpf.files || inputRgCpf.files.length === 0) {
                    alert('Por favor, anexe a foto ou PDF do documento de identificação (RG/CPF) antes de continuar.');
                    inputRgCpf.click();
                    return;
                }

                document.getElementById('modal-paciente-cpf').textContent = cpfInput.value;
                document.getElementById('modal-exame').textContent = document.getElementById('resumo-exame').value;
                document.getElementById('modal-unidade').textContent = document.getElementById('resumo-unidade').value;
                document.getElementById('modal-data-hora').textContent = document.getElementById('resumo-data-hora').value;

                modal.classList.remove('hidden');
            });

            function fecharModal() {
                modal.classList.add('hidden');
            }

            btnFecharModalX.addEventListener('click', fecharModal);
            btnModalVoltar.addEventListener('click', fecharModal);
        });
    </script>

</x-layouts.agendamento>