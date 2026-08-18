<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CanceladoController extends Controller
{
    {{--
    Componente: Modal de Cancelamento
    Uso: <x-modal-cancelado />

    Para abrir o modal, dispare o evento Alpine:
    <button x-data @click="$dispatch('open-modal-cancelado')">Cancelar agendamento</button>

    Requer Alpine.js (já incluso por padrão em muitos starter kits do Laravel).
    Se não tiver, adicione no layout:
    <script src="//unpkg.com/alpinejs" defer></script>
--}}

<div
    x-data="{ show: false }"
    x-show="show"
    x-on:open-modal-cancelado.window="show = true"
    x-on:keydown.escape.window="show = false"
    x-cloak
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
>
    {{-- Fecha ao clicar fora do modal --}}
    <div class="absolute inset-0" @click="show = false"></div>

    {{-- Caixa do modal --}}
    <div class="relative w-full max-w-md bg-[#f7f7fb] rounded-lg shadow-xl p-6">

        <button
            type="button"
            @click="show = false"
            class="absolute top-4 right-5 text-black text-xl font-medium hover:opacity-70"
        >
            &times;
        </button>

        <hr class="border-t border-gray-300 mt-8 mb-8">

        <div class="flex items-center justify-center gap-3">
            <span class="text-2xl font-bold text-[#ff4d4d] leading-none">&times;</span>
            <span class="text-xl font-bold tracking-wide text-[#ff4d4d]">CANCELADO</span>
        </div>

        <hr class="border-t border-gray-300 mt-8">

    </div>
</div>
}
