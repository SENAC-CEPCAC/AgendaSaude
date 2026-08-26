@php
    $ehEspera = session('eh_espera', false);
@endphp

<!-- Inicio Confirmado -->

<!-- Overlay -->
<div class="fixed inset-0 bg-black/50 z-40"></div>

<!-- Modal -->
<div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
            w-[90%] max-w-md bg-[#f7f8fc] rounded-xl shadow-2xl px-6 py-5 z-50">

    <!-- Botão fechar -->
    <div class="flex justify-end">
        <button onclick="fechar()" class="text-gray-800 hover:text-gray-600 text-lg leading-none cursor-pointer">
            &times;
        </button>
    </div>

    <hr class="border-gray-300 mt-3">

    <!-- Conteúdo confirmado -->
    <div class="flex flex-col items-center justify-center py-6">

        @if($ehEspera)
            <!-- Ícone e Badge de Lista de Espera -->
            <div class="flex items-center justify-center gap-2">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="text-amber-700 font-bold tracking-wide text-sm uppercase">
                    LISTA DE ESPERA INTELIGENTE
                </span>
            </div>

            <!-- Mensagem de Espera -->
            <p class="mt-4 text-gray-800 text-sm font-semibold text-center leading-relaxed">
                Inscrição confirmada na Lista de Espera!
            </p>

            <p class="mt-2 text-gray-600 text-xs text-center leading-normal px-2">
                Fique atento(a) ao seu telefone/WhatsApp cadastrado: entraremos em contato com antecedência assim que surgir uma vaga para este dia.
            </p>
        @else
            <!-- Ícone e Badge de Agendamento Confirmado -->
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                    stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>

                <span class="text-green-600 font-semibold tracking-wide text-sm uppercase">
                    CONFIRMADO
                </span>
            </div>

            <!-- Mensagem -->
            <p class="mt-4 text-gray-700 text-sm font-medium text-center">
                Agendamento realizado com sucesso!
            </p>
        @endif

        <p class="mt-4 text-gray-500 text-xs text-center">
            Você será redirecionado para seus agendamentos em
            <span id="contador" class="font-bold text-blue-900">4</span>
            segundos.
        </p>

        <a href="{{ route('agendamento.agendamentos') }}" class="mt-4 inline-flex items-center justify-center px-5 py-2.5 bg-blue-900 hover:bg-blue-800 text-white text-xs font-semibold rounded-lg shadow-sm transition-all">
            Ver Meus Agendamentos
        </a>

    </div>

    <hr class="border-gray-300">

</div>

<!-- Final Confirmado -->

<script>
    let segundos = 4;
    const contador = document.getElementById('contador');

    const intervalo = setInterval(function () {
        segundos--;
        if (contador) {
            contador.textContent = segundos;
        }

        if (segundos <= 0) {
            clearInterval(intervalo);
            window.location.href = "{{ route('agendamento.agendamentos') }}";
        }
    }, 1000);

    function fechar() {
        window.location.href = "{{ route('agendamento.agendamentos') }}";
    }
</script>