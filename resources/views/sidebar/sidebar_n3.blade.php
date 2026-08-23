<x-sidebar>
    <aside id="sidebar" class="fixed top-0 left-0 bottom-0 w-64 bg-[#bfbfc1] border-r border-slate-800 flex flex-col justify-between text-slate-300 z-50 transition-transform duration-300 transform -translate-x-full">
        <div>
            <!-- Logo / Brand Header -->
            <div id="brand-header" class="p-6 border-b border-slate-800/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div id="logo-icon" class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-sky-500/20">
                        G
                    </div>
                    <div>
                        <h1 id="brand-name" class="font-bold text-black tracking-wide text-sm leading-tight">Portal Gestão</h1>

                    </div>
                </div>
                <!-- Close menu button (Removido lg:hidden) -->
                <button id="mobile-menu-close" class="p-1 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" aria-hidden="true" class="lucide lucide-x w-5 h-5">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Nav Links -->
            <nav id="nav-menu" class="p-4 space-y-1">
                <div class="px-3 mb-2">
                    <span id="nav-category" class="text-[10px] font-bold text-slate-900 uppercase tracking-widest">Navegação</span>
                </div>

                <a id="nav-dashboard" href="#dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="layout-dashboard" aria-hidden="true" class="lucide lucide-layout-dashboard w-4.5 h-4.5 text-slate-500"></svg>
                    <span>Prontuario</span>
                </a>

                <a id="nav-appointments" href="#appointments" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="calendar-days" aria-hidden="true" class="lucide lucide-calendar-days w-4.5 h-4.5 text-slate-500"></svg>
                    <span>Serviço Colo</span>
                </a>

                <!-- ACTIVE TAB: Lista de Espera -->
                <a id="nav-mobile-units" href="#mobile-units" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="clock" aria-hidden="true" class="lucide lucide-truck w-4.5 h-4.5 text-slate-500"></svg>
                    <span>Serviço Mama</span>
                </a>

            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div id="sidebar-footer" class="p-4 border-t border-slate-800/80 space-y-1">
            <a id="nav-logout" href="#logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:text-rose-900 hover:bg-rose-500/10 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="log-out" aria-hidden="true" class="lucide lucide-log-out w-4.5 h-4.5 text-rose-400/80">
                  
                </svg>
                <span>Sair do Portal</span>
            </a>
        </div>
    </aside>
</x-sidebar>