@php
    $rotasProximas = [
        'agendamento.etapa1' => 'agendamento.etapa2',
        'agendamento.etapa2' => 'agendamento.etapa3',
        'agendamento.etapa3' => 'agendamento.etapa3',
    ];

    $rotaAtual = request()->route()?->getName();
    $rotaContinuar = $rotasProximas[$rotaAtual] ?? 'agendamento.etapa1';
@endphp

@if (!in_array($rotaAtual, ['agendamento.etapa1', 'agendamento.etapa2', 'agendamento.etapa3'], true))
    <!-- Bottom Action Area -->
    <footer class="bottom-0 left-0 w-full p-margin flex justify-center z-40 footer__flx_agendamento">
        <div class="w-full max-w-md">
            <a
                id="btn-continuar"
                href="{{ route($rotaContinuar) }}"
                class="w-full h-12 bg-primary text-on-primary font-label-bold text-label-bold rounded-full flex items-center justify-center hover:bg-primary/90 active:scale-[0.98] transition-all uppercase tracking-wider"
            >
                    Continuar
            </a>
        </div>
    </footer>
@endif
