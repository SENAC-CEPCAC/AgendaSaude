function inicializarEtapa2() {
    const dias_disponiveis = document.querySelectorAll('[data-calendar-day]');
    const horarios = document.querySelector('[data-horarios]');
    const input_data_selecionada = document.querySelector('#input-data-selecionada');
    const input_horario_selecionado = document.querySelector('#input-horario-selecionado');
    const banner_espera = document.querySelector('#banner-fila-espera');
    const grade_horarios = document.querySelector('#grade-horarios-disponiveis');
    const aviso_esgotado = document.querySelector('#aviso-dia-esgotado');
    const btn_continuar_form = document.querySelector('#btn-continuar-etapa-2');
    const titulo_horarios = document.querySelector('#titulo-data-horarios');

    if (!dias_disponiveis.length && !horarios) return;

    /**
     * Atualiza a visibilidade da grade de horários vs banner de lista de espera
     * com base nas vagas do dia selecionado.
     */
    function atualizarDisponibilidadeDia(diaElemento) {
        if (!diaElemento) return;

        const vagas = parseInt(diaElemento.dataset.vagasDisponiveis ?? '6', 10);
        const dataTexto = diaElemento.dataset.diaFormatado || diaElemento.dataset.date || 'Data Selecionada';

        // Atualiza o título da seção de horários
        if (titulo_horarios) {
            titulo_horarios.textContent = `Horários para ${dataTexto}`;
        }

        if (vagas === 0) {
            // ========================================================
            // DIA COM VAGAS ESGOTADAS (0 vagas disponíveis):
            // 1. Mostra o banner da Fila de Espera com o botão de modal
            // 2. Oculta a grade de horários e exibe o aviso de esgotado
            // ========================================================
            if (banner_espera) banner_espera.classList.remove('hidden');
            if (grade_horarios) grade_horarios.classList.add('hidden');
            if (aviso_esgotado) aviso_esgotado.classList.remove('hidden');

            if (input_horario_selecionado) {
                input_horario_selecionado.value = 'Fila de Espera';
            }

            if (btn_continuar_form) {
                btn_continuar_form.textContent = 'Entrar na Lista de Espera';
                btn_continuar_form.onclick = (e) => {
                    e.preventDefault();
                    if (typeof window.abrirModalFilaEspera === 'function') {
                        window.abrirModalFilaEspera(dataTexto, 'Manhã / Tarde');
                    }
                };
            }
        } else {
            // ========================================================
            // DIA COM VAGAS DISPONÍVEIS (> 0 vagas):
            // 1. OCULTA O BANNER DA FILA DE ESPERA
            // 2. Exibe a grade regular de horários e oculta o aviso
            // ========================================================
            if (banner_espera) banner_espera.classList.add('hidden');
            if (grade_horarios) grade_horarios.classList.remove('hidden');
            if (aviso_esgotado) aviso_esgotado.classList.add('hidden');

            if (btn_continuar_form) {
                btn_continuar_form.textContent = 'Continuar para Envio de Documentos';
                btn_continuar_form.onclick = null;
            }
        }
    }

    // Seleção de Dias no Calendário
    dias_disponiveis.forEach((dia) => {
        dia.addEventListener('click', (e) => {
            e.preventDefault();

            dias_disponiveis.forEach((dia_disp) => {
                const esgotado = (dia_disp.dataset.vagasDisponiveis === '0');
                dia_disp.classList.remove(
                    'bg-primary-container', 'bg-amber-500', 
                    'text-on-primary', 'text-white', 
                    'shadow-md', 'font-medium'
                );
                
                if (esgotado) {
                    dia_disp.classList.add('text-amber-700', 'bg-amber-50/70');
                } else {
                    dia_disp.classList.add('text-on-surface', 'hover:bg-surface-container');
                }
                dia_disp.setAttribute('aria-pressed', 'false');
            });

            const diaEsgotado = (dia.dataset.vagasDisponiveis === '0');
            dia.classList.remove('text-on-surface', 'hover:bg-surface-container', 'text-amber-700', 'bg-amber-50/70');
            
            if (diaEsgotado) {
                dia.classList.add('bg-amber-500', 'text-white', 'shadow-md', 'font-medium');
            } else {
                dia.classList.add('bg-primary-container', 'text-on-primary', 'shadow-md', 'font-medium');
            }
            dia.setAttribute('aria-pressed', 'true');

            if (input_data_selecionada && dia.dataset.date) {
                input_data_selecionada.value = dia.dataset.date;
            }

            atualizarDisponibilidadeDia(dia);

            const calendario = dia.closest('[data-calendario]');
            if (calendario) {
                calendario.dataset.selectedDate = dia.dataset.date;
                calendario.dispatchEvent(new CustomEvent('data-selecionada', {
                    bubbles: true,
                    detail: { 
                        data: dia.dataset.date,
                        formatado: dia.dataset.diaFormatado,
                        vagas: parseInt(dia.dataset.vagasDisponiveis ?? '6', 10)
                    },
                }));
            }
        });
    });

    // Seleção de Horários na Grade
    const botoes_horarios = document.querySelectorAll('.btn-horario');

    const selecionar_horario = (horario_alvo) => {
        botoes_horarios.forEach((h) => {
            const selecionado = (h === horario_alvo);

            h.classList.toggle('border-2', selecionado);
            h.classList.toggle('border-primary-container', selecionado);
            h.classList.toggle('bg-primary-fixed/30', selecionado);
            h.classList.toggle('text-primary-container', selecionado);
            h.classList.toggle('font-medium', selecionado);
            h.classList.toggle('shadow-sm', selecionado);
            h.classList.toggle('border', !selecionado);
            h.classList.toggle('border-outline-variant', !selecionado);
            h.classList.toggle('text-on-surface', !selecionado);
            h.setAttribute('aria-pressed', String(selecionado));
        });

        const texto_horario = horario_alvo.textContent.trim();
        if (input_horario_selecionado) {
            input_horario_selecionado.value = texto_horario;
        }
    };

    botoes_horarios.forEach((h) => {
        h.type = 'button';
        h.setAttribute('aria-pressed', h.classList.contains('border-2') ? 'true' : 'false');
        h.addEventListener('click', (e) => {
            e.preventDefault();
            selecionar_horario(h);
        });
    });

    // Executa a checagem inicial para o dia padrão carregado
    const diaInicial = document.querySelector('[data-calendar-day][aria-pressed="true"]') || dias_disponiveis[0];
    if (diaInicial) {
        atualizarDisponibilidadeDia(diaInicial);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inicializarEtapa2);
} else {
    inicializarEtapa2();
}
