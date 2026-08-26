@php
$usuario = auth()->user();

if (! $usuario && session('colaborador_id')) {
$usuario = \App\Models\UserColaborador::find(
session('colaborador_id')
);
}

$usuarioNome = $usuario?->nome
?? $usuario?->name
?? 'Usuário';
@endphp

<aside
    id="sidebar"
    class="fixed top-0 left-0 bottom-0 w-64
           bg-white
           dark:bg-slate-900
           border-r border-slate-500
           flex flex-col
           text-slate-900
           z-50
           transition-transform duration-300
           transform -translate-x-full">

    <!-- CABEÇALHO -->
    <div
        id="brand-header"
        class="p-6 border-b border-slate-500
               flex items-center justify-between">

        <div class="flex items-center gap-3">

            <!-- Logo -->
            <div
                id="logo-icon"
                class="flex h-10 w-10
                       items-center justify-center
                       rounded-xl
                       border border-blue-800
                       bg-blue-900
                       text-xl font-extrabold
                       text-white
                       shadow-md shadow-blue-950/20">
                G
            </div>

            <!-- Nome -->
            <div>
                <h1
                    id="brand-name"
                    class="font-bold text-black
                           tracking-wide text-sm
                           leading-tight">

                    @if ((int) $nivelUsuario === 1)

                    Portal do Paciente

                    @elseif ((int) $nivelUsuario === 2)

                    Portal do Colaborador

                    @endif

                </h1>

                <p class="text-xs text-slate-700 mt-1">
                    {{ $usuarioNome }}
                </p>
            </div>

        </div>

        <!-- BOTÃO FECHAR -->
        <button
            id="mobile-menu-close"
            type="button"
            class="p-1
                   text-slate-700
                   hover:text-slate-900
                   hover:bg-slate-300
                   rounded-lg
                   transition-colors
                   cursor-pointer"
            aria-label="Fechar menu">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="w-5 h-5">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>

    </div>


    <!-- MENU -->
    <nav class="flex-1 p-4 overflow-y-auto space-y-1.5">

        <!-- Agendamentos -->
        <a
            href="{{ (int) $nivelUsuario === 1 ? route('agendamento.agendamentos') : route('agendamentos.index') }}"
            class="flex items-center gap-3
                   px-3 py-2.5
                   rounded-lg
                   {{ request()->routeIs('agendamento.agendamentos', 'agendamentos.*') ? 'bg-blue-900 text-white font-semibold shadow-xs' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium' }}
                   transition-all
                   text-sm">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="w-5 h-5">
                <rect
                    width="18"
                    height="18"
                    x="3"
                    y="4"
                    rx="2"
                    ry="2"></rect>

                <line
                    x1="16"
                    x2="16"
                    y1="2"
                    y2="6"></line>

                <line
                    x1="8"
                    x2="8"
                    y1="2"
                    y2="6"></line>

                <line
                    x1="3"
                    x2="21"
                    y1="10"
                    y2="10"></line>
            </svg>

            <span>
                Agendamentos
            </span>

        </a>

        <!-- Meu Perfil -->
        <a
            href="{{ route('paciente.perfil') }}"
            class="flex items-center gap-3
                   px-3 py-2.5
                   rounded-lg
                   {{ request()->routeIs('paciente.perfil*') ? 'bg-blue-900 text-white font-semibold shadow-xs' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium' }}
                   transition-all
                   text-sm">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="w-5 h-5">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>

            <span>
                Meu Perfil
            </span>

        </a>

        @if ((int) $nivelUsuario === 1)
        <!-- Novo Agendamento -->
        <a
            href="{{ route('agendamento.etapa1') }}"
            target="_blank"
            class="flex items-center gap-3
                   px-3 py-2.5
                   rounded-lg
                   text-slate-700
                   hover:bg-blue-50
                   hover:text-blue-900
                   font-medium
                   transition-all
                   text-sm">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="w-5 h-5">
                <path d="M12 5v14M5 12h14"></path>
            </svg>

            <span>
                Novo Agendamento
            </span>

        </a>
        @endif

    </nav>


    <!-- RODAPÉ -->
    <div
        id="sidebar-footer"
        class="p-4
               border-t border-slate-500">

        <form
            method="POST"
            action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full
                       items-center gap-3
                       px-3 py-2.5
                       rounded-lg
                       text-rose-600
                       hover:text-rose-900
                       hover:bg-rose-500/10
                       transition-all
                       font-medium
                       text-sm">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-5 h-5">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" x2="9" y1="12" y2="12"></line>
                </svg>

                <span>
                    Sair do Portal
                </span>

            </button>

        </form>

    </div>

</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function openSidebar() {

            // Abre a sidebar
            sidebar.classList.remove('-translate-x-full');

            // Esconde o botão hambúrguer
            mobileMenuToggle.classList.add('hidden');

            // Mostra o overlay
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('hidden');

                setTimeout(() => {
                    sidebarOverlay.classList.add('opacity-100');
                }, 10);
            }

            mobileMenuToggle.setAttribute('aria-expanded', 'true');
        }

        function closeSidebar() {

            // Fecha a sidebar
            sidebar.classList.add('-translate-x-full');

            // Mostra novamente o botão hambúrguer
            mobileMenuToggle.classList.remove('hidden');

            // Esconde o overlay
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('opacity-100');

                setTimeout(() => {
                    sidebarOverlay.classList.add('hidden');
                }, 300);
            }

            mobileMenuToggle.setAttribute('aria-expanded', 'false');
        }

        // Abrir
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', openSidebar);
        }

        // Fechar pelo X
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', closeSidebar);
        }

        // Fechar clicando fora da sidebar
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }

    });
</script>