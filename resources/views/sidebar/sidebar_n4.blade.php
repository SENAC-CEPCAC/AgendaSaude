@php
    $usuario = auth()->user();
    if (! $usuario && session('colaborador_id')) {
        $usuario = \App\Models\UserColaborador::find(session('colaborador_id'));
    }
    $usuarioNome = $usuario?->nome ?? $usuario?->name ?? 'Usuário';
@endphp

<aside id="sidebar" class="fixed top-0 left-0 bottom-0 w-64 bg-[#c1c2c4] border-r border-slate-500 flex flex-col justify-between text-slate-900 z-50 transition-transform duration-300 -translate-x-full">
    <div>
        <!-- Logo / Brand Header -->
        <div id="brand-header" class="p-6 border-b border-slate-500 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div id="logo-icon" class="flex h-10 w-10 items-center justify-center rounded-xl border border-blue-400 bg-blue-600 text-xl font-extrabold text-white shadow-lg shadow-blue-500/30">
                    G
                </div>
                <div>
                    <h1 id="brand-name" class="font-bold text-black tracking-wide text-sm leading-tight">Portal Gestão</h1>

                </div>
            </div>
            <button id="mobile-menu-close" type="button" class="absolute right-4 top-6 p-1 text-[#42556f] hover:text-[#003E7E] hover:bg-slate-300 rounded-lg transition-colors cursor-pointer" aria-controls="sidebar" aria-expanded="true" aria-label="Fechar menu">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Nav Links -->
        <nav class="flex flex-col fixed left-0 top-0 h-screen py-6 bg-white dark:bg-slate-900 h-full w-64 border-r border-r border-slate-200 dark:border-slate-800 z-40">
            <div class="px-6 mb-8 flex flex-col items-center">
                <div class="w-16 h-16 rounded-full bg-surface-variant overflow-hidden mb-4">
                    <img alt="Gestor" class="w-full h-full object-cover" data-alt="A professional headshot of a medical administrator in a modern, well-lit office environment. The lighting is soft and natural, creating an approachable yet authoritative presence. The overall color palette features clean whites and subtle blues to align with a healthcare aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRpqwtwilo7T_SJJWex6nRD4sXjP8Y4qHZ7cRnv0pFTK8ZBO3ijubTW2O059buMEVpapnHj0bXCRE4B5YBAouPqCdyIKjwuokhv1jbUlOgSjaNKgQqNGQrWyIFtke8mTZUY7GUvE6UI7JLFpmKgk7HYL_qSFQ4WlsvSny8RRnZ0YuUnYyqhxGVJ7xnRZ8JkHXvITJ_Kk454mHoj2w6-ed08ziXGKDQBLQv1GIgnd1Mz22W0_ei3JAMffEiBuY_aXI_vh5vkkmatOw" />
                </div>
                <div class="text-xl font-black text-[#003E7E] dark:text-blue-400 font-h2 mb-1">{{ $usuarioNome }}</div>
                
            </div>
            <ul class="flex-1 flex flex-col gap-2 px-3">
                <li>
                    <a href="{{ route('painel_adm.dashboard') }}" class="flex items-center gap-3 px-14 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform">
                        <span class="material-symbols-outlined"></span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('agendamentos.index') }}" class="flex items-center gap-3 px-11 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform">
                        <span class="material-symbols-outlined"></span>
                        Agendamentos
                    </a>
                </li>
                <li>
                    <a href="{{ route('triagem.index') }}" class="flex items-center gap-3 px-14 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform">
                        <span class="material-symbols-outlined"></span>
                        Prontuario
                    </a>
                </li>
                <!-- <li>
                    <a href="{{ url('/unidadesmoveis') }}" class="flex items-center gap-3 px-10 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform">
                        <span class="material-symbols-outlined"></span>
                        Unidades Móveis
                    </a>
                </li> -->
                <li>
                    <a href="{{ route('cronograma.index') }}" class="flex items-center gap-3 px-12 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform">
                        <span class="material-symbols-outlined"></span>
                        Cronograma
                    </a>
                </li>
                <!-- <li>
                    <a class="flex items-center gap-3 px-14 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform">
                        <span class="material-symbols-outlined"></span>
                        Relatórios
                    </a>
                </li> -->
                <li>
                    <a href="{{ route('adm.adm') }}" class="flex items-center gap-3 px-7 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform">
                        <span class="material-symbols-outlined"></span>
                        Permissão de Acesso
                    </a>
                </li>
            </ul>
            <div method="POST" action="{{ route('logout') }}" class="mt-auto px-3 border-t border-slate-200 dark:border-slate-800 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button id="nav-logout" type="submit" class="flex w-full items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:text-rose-900 hover:bg-rose-500/10 transition-all font-medium text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="log-out" aria-hidden="true" class="lucide lucide-log-out w-4.5 h-4.5 text-rose-400/80">

                        </svg>
                        <span>Sair do Portal</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div id="sidebar-footer" class="p-4 border-t border-slate-500 space-y-1">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button id="nav-logout" type="submit" class="flex w-full items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:text-rose-900 hover:bg-rose-500/10 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="log-out" aria-hidden="true" class="lucide lucide-log-out w-5 h-5 text-rose-400/80"></svg>
                <span>Sair do Portal</span>
            </button>
        </form>
    </div>
</aside>