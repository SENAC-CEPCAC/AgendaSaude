function inicializarEtapa1() {
    const botao = document.querySelector('#btn-especialidade');
    const lista = document.querySelector('#lista-especialidades');
    const texto = document.querySelector('#texto-especialidade');
    const icone = document.querySelector('#icone-especialidade');
    const input_id_vagas = document.querySelector('#input-id-vagas');

    if (!botao || !lista) return;

    botao.addEventListener('click', (e) => {
        e.preventDefault();
        const aberto = botao.getAttribute('aria-expanded') === 'true';

        botao.setAttribute('aria-expanded', String(!aberto));
        lista.classList.toggle('opacity-0', aberto);
        lista.classList.toggle('scale-95', aberto);
        lista.classList.toggle('pointer-events-none', aberto);
        icone?.classList.toggle('rotate-180', !aberto);
    });

    document.querySelectorAll('.opcao-especialidade').forEach((opcao) => {
        opcao.addEventListener('click', (e) => {
            e.preventDefault();
            if (texto) texto.textContent = opcao.dataset.especialidade;
            if (input_id_vagas && opcao.dataset.id) {
                input_id_vagas.value = opcao.dataset.id;
            }

            botao.setAttribute('aria-expanded', 'false');
            lista.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            icone?.classList.remove('rotate-180');

            botao.classList.add('border-primary', 'bg-primary-fixed/20');
            setTimeout(() => botao.classList.remove('bg-primary-fixed/20'), 250);
        });
    });

    // Fecha o dropdown caso o usuário clique fora
    document.addEventListener('click', (e) => {
        if (!botao.contains(e.target) && !lista.contains(e.target)) {
            botao.setAttribute('aria-expanded', 'false');
            lista.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            icone?.classList.remove('rotate-180');
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inicializarEtapa1);
} else {
    inicializarEtapa1();
}
