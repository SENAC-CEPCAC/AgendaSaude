<!-- =========================================================================
     MODAL DE VAGAS ESGOTADAS & LISTA DE ESPERA INTELIGENTE
     Arquivo: resources/views/fluxo_agendamento/modal_fila_espera.blade.php
     Pertence ao: Fluxo de Agendamento (Etapa 2 -> Etapa 3)
     ========================================================================= -->

<div
    id="modal-fila-espera"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 ease-out"
    role="dialog"
    aria-modal="true"
    aria-labelledby="titulo-modal-espera"
>
    <!-- Card do Modal -->
    <div
        id="card-modal-espera"
        class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transform scale-95 transition-all duration-300 ease-out"
    >
        <!-- Faixa de Destaque Superior / Status -->
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-3.5 flex items-center justify-between text-white">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px]">hourglass_top</span>
                <span class="text-xs font-bold uppercase tracking-wider">Vagas Diretas Esgotadas</span>
            </div>
            <button
                type="button"
                onclick="fecharModalFilaEspera()"
                class="text-white/80 hover:text-white rounded-full p-1 transition-colors focus:outline-none"
                aria-label="Fechar modal"
            >
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Conteúdo do Modal -->
        <div class="p-6 sm:p-8 flex flex-col gap-5">
            
            <!-- Título e Introdução -->
            <div class="flex flex-col gap-1.5 text-center sm:text-left">
                <h3 id="titulo-modal-espera" class="text-xl font-bold text-slate-800">
                    Deseja entrar na Lista de Espera Inteligente?
                </h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Todas as vagas regulares para a data e unidade selecionadas já foram preenchidas. Você pode garantir sua posição prioritária na fila de espera.
                </p>
            </div>

            <!-- Card Informativo / Regra das 24 Horas -->
            <div class="bg-amber-50/70 border border-amber-200/80 rounded-xl p-4 flex flex-col gap-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                        <span class="material-symbols-outlined text-[20px]">notifications_active</span>
                    </div>
                    <div class="text-xs text-slate-700 leading-snug">
                        <span class="font-bold text-amber-900 block mb-0.5">Como funciona a notificação com 24h de antecedência:</span>
                        Se algum paciente cancelar ou remarcar, nosso sistema liberará a vaga automaticamente e avisará você <strong class="text-amber-950 font-semibold">até 24 horas antes do horário</strong> para confirmação.
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-t border-amber-200/60 text-[11px] text-amber-800 font-medium">
                    <span class="material-symbols-outlined text-[16px] text-amber-600">verified</span>
                    <span>Prioridade organizada por ordem cronológica de inscrição.</span>
                </div>
            </div>

            <!-- Resumo da Seleção -->
            <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-3.5 flex flex-col gap-1 text-xs text-slate-600">
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Data desejada:</span>
                    <span id="resumo-data-espera" class="font-semibold text-slate-800">Data selecionada</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Turno estimado:</span>
                    <span id="resumo-turno-espera" class="font-semibold text-slate-800">Manhã / Tarde</span>
                </div>
            </div>

            <!-- Ações do Modal -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <!-- Botão Primário: Aceitar Fila de Espera -->
                <button
                    type="button"
                    id="btn-aceitar-fila-espera"
                    onclick="confirmarFilaEspera()"
                    class="w-full sm:flex-1 h-12 bg-amber-500 hover:bg-amber-600 active:scale-[0.98] text-white font-bold rounded-xl flex items-center justify-center gap-2 text-sm shadow-md shadow-amber-500/20 transition-all uppercase tracking-wider"
                >
                    <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                    <span>Entrar na Fila</span>
                </button>

                <!-- Botão Secundário: Escolher Outra Data -->
                <button
                    type="button"
                    onclick="fecharModalFilaEspera()"
                    class="w-full sm:w-auto px-5 h-12 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl flex items-center justify-center text-sm transition-colors"
                >
                    Escolher Outra Data
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Scripts de Interatividade do Modal -->
<script>
    function abrirModalFilaEspera(dataTexto, turnoTexto) {
        const modal = document.getElementById('modal-fila-espera');
        const card = document.getElementById('card-modal-espera');
        
        if (dataTexto) {
            const dataElem = document.getElementById('resumo-data-espera');
            if (dataElem) dataElem.textContent = dataTexto;
        }
        if (turnoTexto) {
            const turnoElem = document.getElementById('resumo-turno-espera');
            if (turnoElem) turnoElem.textContent = turnoTexto;
        }

        if (modal && card) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
            document.body.style.overflow = 'hidden';
        }
    }

    function fecharModalFilaEspera() {
        const modal = document.getElementById('modal-fila-espera');
        const card = document.getElementById('card-modal-espera');

        if (modal && card) {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            document.body.style.overflow = '';
        }
    }

    function confirmarFilaEspera() {
        // Marca o agendamento como fila de espera
        const form = document.getElementById('form-agendamento-etapa-2');
        
        if (form) {
            // Adiciona ou atualiza input oculto de tipo de agendamento
            let inputEspera = document.getElementById('input-tipo-agendamento');
            if (!inputEspera) {
                inputEspera = document.createElement('input');
                inputEspera.type = 'hidden';
                inputEspera.name = 'tipo_agendamento';
                inputEspera.id = 'input-tipo-agendamento';
                form.appendChild(inputEspera);
            }
            inputEspera.value = 'fila_espera';

            fecharModalFilaEspera();
            form.submit();
        }
    }

    // Fechar modal ao clicar fora do card
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modal-fila-espera');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    fecharModalFilaEspera();
                }
            });
        }

        // Fechar ao pressionar a tecla ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                fecharModalFilaEspera();
            }
        });
    });
</script>
