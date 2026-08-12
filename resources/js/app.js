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