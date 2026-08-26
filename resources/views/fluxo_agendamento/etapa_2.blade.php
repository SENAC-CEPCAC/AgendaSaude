<x-layouts.agendamento title="Agendamento - Etapa 2">

    <x-agendamento.barra-progresso />

    <form id="form-agendamento-etapa-2" method="POST" action="{{ route('agendamento.salvar_etapa_2') }}" class="flex flex-col">
        @csrf

        <!-- Mensagens de Erro de Validação -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold shadow-xs">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <span class="material-symbols-outlined text-rose-600 text-[18px]">warning</span>
                    Atenção:
                </div>
                <ul class="list-disc list-inside space-y-0.5">
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
            value="{{ old('data_selecionada', $dataSelecionada) }}"
        >
        <input
            type="hidden"
            name="horario_selecionado"
            id="input-horario-selecionado"
            value="{{ old('horario_selecionado', $horarioInicial ?? '08:00') }}"
        >
        <input
            type="hidden"
            name="id_agenda"
            id="input-id-agenda"
            value="{{ old('id_agenda', $cronogramaSelecionado['id_agenda'] ?? '') }}"
        >

        <!-- Calendário Interativo Integrado ao Banco -->
        <x-agendamento.calendario 
            :mapaCronogramas="$mapaCronogramas"
            :nomeMesAno="$nomeMesAno"
            :mesAtual="$mesAtual"
            :dataBase="$dataBase"
            :primeiroDiaMes="$primeiroDiaMes"
            :ultimoDiaMes="$ultimoDiaMes"
            :diaSemanaInicio="$diaSemanaInicio"
            :dataSelecionada="$dataSelecionada"
        />

        <!-- ========================================================================= -->
        <!-- SEÇÃO DINÂMICA: HORÁRIOS DISPONÍVEIS OU AVISO DE LISTA DE ESPERA -->
        <!-- ========================================================================= -->
        <div id="secao-dinamica-horarios-ou-espera" class="my-3">
            
            <!-- 1. GRADE DE HORÁRIOS (Visível quando há vagas regulares livres) -->
            <div id="container-grade-horarios" class="{{ $cronogramaSelecionado && $cronogramaSelecionado['esgotado'] ? 'hidden' : '' }} flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wide flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-[18px]">schedule</span>
                        <span id="titulo-data-horarios">
                            {{ $cronogramaSelecionado ? 'Horários para ' . $cronogramaSelecionado['data_formatada'] : 'Selecione uma data acima' }}
                        </span>
                    </h3>

                    <span id="badge-vagas-restantes" class="text-[11px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full font-bold">
                        {{ $cronogramaSelecionado ? $cronogramaSelecionado['vagas_restantes'] : 0 }} vaga(s) disponível(is)
                    </span>
                </div>

                <div id="grade-horarios-disponiveis" class="grid grid-cols-3 sm:grid-cols-4 gap-2.5 mt-1">
                    @if($cronogramaSelecionado && !$cronogramaSelecionado['esgotado'])
                        @php
                            $horarioAtual = old('horario_selecionado', $horarioInicial ?? '08:00');
                        @endphp
                        @foreach($cronogramaSelecionado['horarios'] as $item)
                            @php
                                $isOcupado = $item['ocupado'];
                                $isSelecionado = (!$isOcupado && $item['horario'] === $horarioAtual);
                            @endphp

                            @if($isOcupado)
                                <div class="h-11 rounded-lg border border-slate-200 bg-slate-100/90 text-slate-400 opacity-60 flex items-center justify-between px-2.5 font-medium text-xs select-none cursor-not-allowed" title="Horário já reservado por outro paciente">
                                    <span class="line-through">{{ $item['horario'] }}</span>
                                    <span class="text-[9px] bg-slate-200 text-slate-600 px-1 py-0.5 rounded font-bold uppercase">Ocupado</span>
                                </div>
                            @else
                                <button
                                    type="button"
                                    data-hora="{{ $item['horario'] }}"
                                    class="btn-horario h-11 rounded-lg border transition-all flex items-center justify-center font-bold text-xs cursor-pointer shadow-xs
                                        {{ $isSelecionado ? 'border-2 border-primary bg-primary text-white scale-[1.03] ring-2 ring-primary/30 shadow-md' : 'border-slate-300 bg-white text-slate-700 hover:border-primary hover:bg-slate-50' }}"
                                >
                                    {{ $item['horario'] }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- 2. CARD INFORMATIVO DE LISTA DE ESPERA (Visível quando as vagas estão ESGOTADAS) -->
            <div id="container-aviso-espera" class="{{ $cronogramaSelecionado && $cronogramaSelecionado['esgotado'] ? '' : 'hidden' }} p-5 rounded-2xl border-2 border-dashed border-amber-300 bg-amber-50/80 flex flex-col gap-3 shadow-xs animate-in fade-in duration-200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">notifications_active</span>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-xs font-bold text-amber-950 uppercase tracking-wide">
                            Vagas Regulares Esgotadas para esta Data
                        </h4>
                        <p class="text-xs text-amber-900 leading-relaxed">
                            Não há mais horários regulares para este dia. No entanto, você pode concluir seu cadastro para entrar na <strong>Lista de Espera Inteligente</strong>.
                        </p>
                    </div>
                </div>

                <div class="p-3 bg-white/80 rounded-xl border border-amber-200 text-[11px] text-amber-800 space-y-1.5">
                    <div class="flex items-center gap-1.5 font-bold text-amber-900">
                        <span class="material-symbols-outlined text-[16px] text-amber-600">smartphone</span>
                        <span>Aviso por Telefone / WhatsApp</span>
                    </div>
                    <p>
                        Caso ocorram desistências ou sejam abertas vagas adicionais, <strong>nossa equipe entrará em contato com você pelo número de telefone cadastrado com até 24h de antecedência</strong>.
                    </p>
                    <div class="pt-1 text-[10px] text-amber-700 font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">info</span>
                        <span>Regra: Cada paciente pode participar de no máximo 1 dia de lista de espera simultaneamente.</span>
                    </div>
                </div>

                @if($pacienteJaTemEspera)
                    <div class="p-2.5 bg-rose-50 border border-rose-200 rounded-lg text-[11px] text-rose-700 font-semibold flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-rose-600">block</span>
                        <span>Você já possui 1 vaga na Lista de Espera em outra data.</span>
                    </div>
                @endif
            </div>

        </div>

        <!-- Botão de Ação para Avançar -->
        <div class="mt-4 pt-2 pb-6">
            <button
                type="submit"
                id="btn-continuar-etapa-2"
                {{ $cronogramaSelecionado && $cronogramaSelecionado['esgotado'] && $pacienteJaTemEspera ? 'disabled' : '' }}
                class="w-full h-12 bg-primary text-on-primary font-bold rounded-full flex items-center justify-center hover:bg-primary/90 active:scale-[0.98] transition-all uppercase tracking-wider shadow-md text-xs cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ $cronogramaSelecionado && $cronogramaSelecionado['esgotado'] ? 'Entrar na Lista de Espera e Continuar →' : 'Continuar para Envio de Documentos →' }}
            </button>
        </div>
    </form>

    <!-- Script de Sincronização Dinâmica do Calendário e Horários -->
    <script>
        const mapaCronogramas = @json($mapaCronogramas);
        const pacienteJaTemEspera = @json($pacienteJaTemEspera);

        document.addEventListener('DOMContentLoaded', function () {
            const botoesDias = document.querySelectorAll('[data-calendar-day]');
            const inputData = document.getElementById('input-data-selecionada');
            const inputHorario = document.getElementById('input-horario-selecionado');
            const inputIdAgenda = document.getElementById('input-id-agenda');
            const containerGrade = document.getElementById('container-grade-horarios');
            const containerEspera = document.getElementById('container-aviso-espera');
            const tituloHorarios = document.getElementById('titulo-data-horarios');
            const badgeVagas = document.getElementById('badge-vagas-restantes');
            const gradeHorarios = document.getElementById('grade-horarios-disponiveis');
            const btnContinuar = document.getElementById('btn-continuar-etapa-2');

            function selecionarBotaoHorario(botao) {
                if (!botao || botao.disabled) return;
                const hora = botao.getAttribute('data-hora');
                if (!hora) return;

                document.querySelectorAll('.btn-horario').forEach(b => {
                    b.className = 'btn-horario h-11 rounded-lg border border-slate-300 bg-white text-slate-700 hover:border-primary hover:bg-slate-50 transition-all flex items-center justify-center font-bold text-xs cursor-pointer shadow-xs';
                });

                botao.className = 'btn-horario h-11 rounded-lg border-2 border-primary bg-primary text-white scale-[1.03] ring-2 ring-primary/30 shadow-md transition-all flex items-center justify-center font-bold text-xs cursor-pointer';
                if (inputHorario) {
                    inputHorario.value = hora;
                }
            }

            // Delegação de evento de clique para os botões de horário
            document.addEventListener('click', function (e) {
                const btnHora = e.target.closest('.btn-horario');
                if (btnHora) {
                    e.preventDefault();
                    selecionarBotaoHorario(btnHora);
                }
            });

            function atualizarDiaSelecionado(dataStr) {
                const info = mapaCronogramas[dataStr];
                if (!info) return;

                if (inputData) inputData.value = dataStr;
                if (inputIdAgenda) inputIdAgenda.value = info.id_agenda;

                if (info.esgotado) {
                    // DIA ESGOTADO: Oculta grade de horários e exibe o card de espera
                    if (containerGrade) containerGrade.classList.add('hidden');
                    if (containerEspera) containerEspera.classList.remove('hidden');

                    if (inputHorario) inputHorario.value = 'Lista de Espera';
                    if (btnContinuar) {
                        btnContinuar.textContent = 'Entrar na Lista de Espera e Continuar →';
                        btnContinuar.disabled = pacienteJaTemEspera;
                    }
                } else {
                    // DIA COM VAGAS: Exibe grade de horários e oculta aviso de espera
                    if (containerGrade) containerGrade.classList.remove('hidden');
                    if (containerEspera) containerEspera.classList.add('hidden');
                    if (btnContinuar) {
                        btnContinuar.disabled = false;
                        btnContinuar.textContent = 'Continuar para Envio de Documentos →';
                    }

                    if (tituloHorarios) {
                        tituloHorarios.textContent = `Horários para ${info.data_formatada}`;
                    }
                    if (badgeVagas) {
                        badgeVagas.textContent = `${info.vagas_restantes} vaga(s) disponível(is)`;
                    }

                    if (gradeHorarios) {
                        gradeHorarios.innerHTML = '';
                        let primeiroLivre = null;

                        info.horarios.forEach((item) => {
                            if (item.ocupado) {
                                const divOcupado = document.createElement('div');
                                divOcupado.className = 'h-11 rounded-lg border border-slate-200 bg-slate-100/90 text-slate-400 opacity-60 flex items-center justify-between px-2.5 font-medium text-xs select-none cursor-not-allowed';
                                divOcupado.title = 'Horário já reservado por outro paciente';
                                divOcupado.innerHTML = `
                                    <span class="line-through">${item.horario}</span>
                                    <span class="text-[9px] bg-slate-200 text-slate-600 px-1 py-0.5 rounded font-bold uppercase">Ocupado</span>
                                `;
                                gradeHorarios.appendChild(divOcupado);
                            } else {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.setAttribute('data-hora', item.horario);
                                btn.className = 'btn-horario h-11 rounded-lg border border-slate-300 bg-white text-slate-700 hover:border-primary hover:bg-slate-50 transition-all flex items-center justify-center font-bold text-xs cursor-pointer shadow-xs';
                                btn.textContent = item.horario;

                                gradeHorarios.appendChild(btn);

                                if (!primeiroLivre) {
                                    primeiroLivre = btn;
                                }
                            }
                        });

                        if (primeiroLivre) {
                            selecionarBotaoHorario(primeiroLivre);
                        }
                    }
                }
            }

            botoesDias.forEach(btnDia => {
                btnDia.addEventListener('click', function (e) {
                    e.preventDefault();
                    const dataStr = this.getAttribute('data-date');
                    if (!dataStr || !mapaCronogramas[dataStr]) return;

                    botoesDias.forEach(b => {
                        const isEsg = b.getAttribute('data-esgotado') === 'true';
                        b.className = `btn-dia-calendario font-body-sm text-xs p-1 rounded-full relative flex items-center justify-center w-9 h-9 mx-auto transition-all cursor-pointer font-bold ${
                            isEsg 
                                ? 'text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-300' 
                                : 'text-blue-900 bg-blue-50/80 hover:bg-blue-100 border border-blue-200'
                        }`;
                    });

                    const isEsgotado = this.getAttribute('data-esgotado') === 'true';
                    this.className = `btn-dia-calendario font-body-sm text-xs p-1 rounded-full relative flex items-center justify-center w-9 h-9 mx-auto transition-all cursor-pointer font-bold ${
                        isEsgotado 
                            ? 'bg-amber-500 text-white shadow-md scale-105' 
                            : 'bg-primary text-white shadow-md scale-105 ring-2 ring-primary/30'
                    }`;

                    atualizarDiaSelecionado(dataStr);
                });
            });

            // Se já houver um horário ativo no primeiro render, assegura que está selecionado
            const btnAtivo = document.querySelector('.btn-horario');
            if (btnAtivo && containerGrade && !containerGrade.classList.contains('hidden')) {
                selecionarBotaoHorario(btnAtivo);
            }
        });
    </script>

</x-layouts.agendamento>