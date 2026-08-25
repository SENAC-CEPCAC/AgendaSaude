function inicializarEtapa2() {
    const dias_disponiveis = document.querySelectorAll('[data-calendar-day][data-available="true"]');
    const horarios = document.querySelector('[data-horarios]');
    const input_data_selecionada = document.querySelector('#input-data-selecionada');
    const input_horario_selecionado = document.querySelector('#input-horario-selecionado');

    if (!dias_disponiveis.length && !horarios) return;

    // Seleção de Dias no Calendário
    dias_disponiveis.forEach((dia) => {
        dia.addEventListener('click', (e) => {
            e.preventDefault();

            dias_disponiveis.forEach((dia_disp) => {
                dia_disp.classList.remove('bg-primary-container', 'text-on-primary', 'shadow-md', 'font-medium');
                dia_disp.classList.add('text-on-surface', 'hover:bg-surface-container');
                dia_disp.setAttribute('aria-pressed', 'false');
            });

            dia.classList.remove('text-on-surface', 'hover:bg-surface-container');
            dia.classList.add('bg-primary-container', 'text-on-primary', 'shadow-md', 'font-medium');
            dia.setAttribute('aria-pressed', 'true');

            if (input_data_selecionada && dia.dataset.date) {
                input_data_selecionada.value = dia.dataset.date;
            }

            const calendario = dia.closest('[data-calendario]');
            if (calendario) {
                calendario.dataset.selectedDate = dia.dataset.date;
                calendario.dispatchEvent(new CustomEvent('data-selecionada', {
                    bubbles: true,
                    detail: { data: dia.dataset.date },
                }));
            }
        });
    });

    // Seleção de Horários
    const horarios_disponiveis = horarios
        ? [...horarios.querySelectorAll('button')].filter((h) => !h.classList.contains('cursor-not-allowed'))
        : [];
    const titulo_horarios = horarios?.querySelector('h3');

    const selecionar_horario = (horario_alvo) => {
        horarios_disponiveis.forEach((h) => {
            const selecionado = h === horario_alvo;

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

        if (horarios) {
            horarios.dataset.selectedTime = texto_horario;
            horarios.dispatchEvent(new CustomEvent('horario-selecionado', {
                bubbles: true,
                detail: {
                    data: document.querySelector('[data-calendario]')?.dataset.selectedDate,
                    horario: texto_horario,
                },
            }));
        }
    };

    horarios_disponiveis.forEach((h) => {
        h.type = 'button';
        h.setAttribute('aria-pressed', h.classList.contains('border-2') ? 'true' : 'false');
        h.addEventListener('click', (e) => {
            e.preventDefault();
            selecionar_horario(h);
        });
    });

    horarios?.querySelectorAll('.cursor-not-allowed').forEach((h) => {
        h.type = 'button';
        h.disabled = true;
        h.setAttribute('aria-disabled', 'true');
    });

    document.addEventListener('data-selecionada', ({ detail }) => {
        if (!horarios || !titulo_horarios || !detail.data) return;

        const data = new Date(`${detail.data}T00:00:00`);
        const data_formatada = new Intl.DateTimeFormat('pt-BR', {
            day: 'numeric',
            month: 'long',
        }).format(data);
        titulo_horarios.lastChild.textContent = ` Horários para ${data_formatada}`;

        delete horarios.dataset.selectedTime;
        horarios_disponiveis.forEach((h) => {
            h.classList.remove('border-2', 'border-primary-container', 'bg-primary-fixed/30', 'text-primary-container', 'font-medium', 'shadow-sm');
            h.classList.add('border', 'border-outline-variant', 'text-on-surface');
            h.setAttribute('aria-pressed', 'false');
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inicializarEtapa2);
} else {
    inicializarEtapa2();
}
