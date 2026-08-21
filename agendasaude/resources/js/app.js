import './bootstrap';

const botao = document.querySelector('#btn-especialidade');
const lista = document.querySelector('#lista-especialidades');
const texto = document.querySelector('#texto-especialidade');
const icone = document.querySelector('#icone-especialidade');

botao?.addEventListener('click', () => {
    const aberto = botao.getAttribute('aria-expanded') === 'true';

    botao.setAttribute('aria-expanded', String(!aberto));
    lista.classList.toggle('opacity-0', aberto);
    lista.classList.toggle('scale-95', aberto);
    lista.classList.toggle('pointer-events-none', aberto);
    icone.classList.toggle('rotate-180', !aberto);
});

document.querySelectorAll('.opcao-especialidade').forEach((opcao) => {
    opcao.addEventListener('click', () => {
        texto.textContent = opcao.dataset.especialidade;

        botao.setAttribute('aria-expanded', 'false');
        lista.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
        icone.classList.remove('rotate-180');

        botao.classList.add('border-primary', 'bg-primary-fixed');
        setTimeout(() => botao.classList.remove('bg-primary-fixed'), 250);
    });
});

const diasDisponiveis = document.querySelectorAll('[data-calendar-day][data-available="true"]');

diasDisponiveis.forEach((dia) => {
    dia.addEventListener('click', () => {
        diasDisponiveis.forEach((diaDisponivel) => {
            diaDisponivel.classList.remove('bg-primary-container', 'text-on-primary', 'shadow-md', 'font-medium');
            diaDisponivel.classList.add('text-on-surface', 'hover:bg-surface-container');
            diaDisponivel.setAttribute('aria-pressed', 'false');
        });

        dia.classList.remove('text-on-surface', 'hover:bg-surface-container');
        dia.classList.add('bg-primary-container', 'text-on-primary', 'shadow-md', 'font-medium');
        dia.setAttribute('aria-pressed', 'true');

        const calendario = dia.closest('[data-calendario]');
        calendario.dataset.selectedDate = dia.dataset.date;
        calendario.dispatchEvent(new CustomEvent('data-selecionada', {
            bubbles: true,
            detail: { data: dia.dataset.date },
        }));
    });
});

const horarios = document.querySelector('[data-horarios]');
const horariosDisponiveis = horarios
    ? [...horarios.querySelectorAll('button')].filter((horario) => !horario.classList.contains('cursor-not-allowed'))
    : [];
const tituloHorarios = horarios?.querySelector('h3');

const selecionarHorario = (horarioSelecionado) => {
    horariosDisponiveis.forEach((horario) => {
        const selecionado = horario === horarioSelecionado;

        horario.classList.toggle('border-2', selecionado);
        horario.classList.toggle('border-primary-container', selecionado);
        horario.classList.toggle('bg-primary-fixed/30', selecionado);
        horario.classList.toggle('text-primary-container', selecionado);
        horario.classList.toggle('font-medium', selecionado);
        horario.classList.toggle('shadow-sm', selecionado);
        horario.classList.toggle('border', !selecionado);
        horario.classList.toggle('border-outline-variant', !selecionado);
        horario.classList.toggle('text-on-surface', !selecionado);
        horario.setAttribute('aria-pressed', String(selecionado));
    });

    horarios.dataset.selectedTime = horarioSelecionado.textContent.trim();
    horarios.dispatchEvent(new CustomEvent('horario-selecionado', {
        bubbles: true,
        detail: {
            data: document.querySelector('[data-calendario]')?.dataset.selectedDate,
            horario: horarios.dataset.selectedTime,
        },
    }));
};

horariosDisponiveis.forEach((horario) => {
    horario.type = 'button';
    horario.setAttribute('aria-pressed', horario.classList.contains('border-2') ? 'true' : 'false');
    horario.addEventListener('click', () => selecionarHorario(horario));
});

horarios?.querySelectorAll('.cursor-not-allowed').forEach((horario) => {
    horario.type = 'button';
    horario.disabled = true;
    horario.setAttribute('aria-disabled', 'true');
});

document.addEventListener('data-selecionada', ({ detail }) => {
    if (!horarios || !tituloHorarios || !detail.data) return;

    const data = new Date(`${detail.data}T00:00:00`);
    const dataFormatada = new Intl.DateTimeFormat('pt-BR', {
        day: 'numeric',
        month: 'long',
    }).format(data);
    tituloHorarios.lastChild.textContent = ` Horários para ${dataFormatada}`;

    delete horarios.dataset.selectedTime;
    horariosDisponiveis.forEach((horario) => {
        horario.classList.remove('border-2', 'border-primary-container', 'bg-primary-fixed/30', 'text-primary-container', 'font-medium', 'shadow-sm');
        horario.classList.add('border', 'border-outline-variant', 'text-on-surface');
        horario.setAttribute('aria-pressed', 'false');
    });
});
