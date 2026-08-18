{{--
    resources/views/agendamentos/partials/confirmacao-modal.blade.php

    Modal de confirmação de agendamento.
    Requer Alpine.js carregado no layout (já vem com o Laravel/Breeze/Jetstream,
    ou inclua via CDN: <script src="https://unpkg.com/alpinejs" defer></script>)

    Uso no index.blade.php:

        <button
            @click="modalAberto = true; agendamentoSelecionado = {{ $agendamento->id }}"
            class="..."
        >
            Confirmar
        </button>

        @include('agendamentos.partials.confirmacao-modal')

    O componente pai deve ter x-data="{ modalAberto: false, agendamentoSelecionado: null }"
--}}

<div
    x-show="modalAberto"
    x-cloak
    class="fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50"
    style="display: none;"
>
    <div
        x-show="modalAberto"
        @click.outside="modalAberto = false"
        x-transition
        class="bg-[#f5f6fb] w-full max-w-sm rounded-xl shadow-2xl relative px-6 py-6"
    >
        {{-- Botão fechar --}}
        <button
            type="button"
            @click="modalAberto = false"
            class="absolute top-4 right-5 text-black text-xl font-medium hover:text-gray-600"
        >
            X
        </button>

        {{-- Título --}}
        <h2 class="text-center text-2xl font-bold text-gray-900 mb-4">
            Confirmação
        </h2>

        <hr class="border-gray-300 mb-6">

        {{-- Mensagem --}}
        <p class="text-gray-800 text-lg mb-6">
            Deseja <span class="font-bold">CONFIRMAR</span> o Agendamento?
        </p>

        <hr class="border-gray-300 mb-6">

        {{-- Formulário de confirmação --}}
        <form
            :action="agendamentoSelecionado ? `/agendamentos/${agendamentoSelecionado}/confirmar` : '#'"
            method="POST"
        >
            @csrf
            @method('PATCH')

            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    @click="modalAberto = false"
                    class="border border-gray-300 bg-white text-gray-500 font-medium px-6 py-2 rounded-lg hover:bg-gray-50"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="bg-green-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-green-700 shadow"
                >
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>