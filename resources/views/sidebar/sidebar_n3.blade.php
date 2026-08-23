<aside id="sidebar" class="fixed top-0 left-0 bottom-0 w-64 bg-[#c1c2c4] border-r border-slate-500 flex flex-col justify-between text-slate-900 z-50 transition-transform duration-300 transform -translate-x-full">
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
                <!-- Close menu button (Removido lg:hidden) -->
                <button id="mobile-menu-close" type="button" class="p-1 text-[#8ca0b9] hover:text-slate-700 hover:bg-slate-300 rounded-lg transition-colors cursor-pointer" aria-label="Fechar menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" aria-hidden="true" class="lucide lucide-x w-5 h-5"></svg>
                </button>
            </div>

            <!-- Nav Links -->
            <nav id="nav-menu" class="p-4 space-y-1">
                <div class="px-3 mb-2">
                    <span id="nav-category" class="text-[10px] font-bold text-slate-900 uppercase tracking-widest">Navegação</span>
                </div>

                <a id="nav-dashboard" href="#dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="clock" aria-hidden="true" class="lucide lucide-clock w-5 h-5 text-[#6983a5]"></svg>
                    <span>Prontuario</span>
                </a>
                <a id="nav-appointments" href="#appointments" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="clock" aria-hidden="true" class="lucide lucide-clock w-5 h-5 text-[#6983a5]"></svg>
                    <span>Serviço Colo</span>
                </a>                
                <a id="nav-mobile-units" href="#mobile-units" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="clock" aria-hidden="true" class="lucide lucide-clock w-5 h-5 text-[#6983a5]"></svg>
                    <span>Serviço Mama</span>
                </a>
                 <a id="nav-dashboard" href="#dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="clock" aria-hidden="true" class="lucide lucide-clock w-5 h-5 text-[#6983a5]"></svg>
                    <span>Dashboard</span>
                </a>

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