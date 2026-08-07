<aside id="sidebar" class="fixed top-0 left-0 bottom-0 w-64 bg-[#F1F3F5] border-r border-slate-800 flex flex-col justify-between text-slate-300 z-50 transition-transform duration-300 transform -translate-x-full">
          <div>
            <!-- Logo / Brand Header -->
            <div id="brand-header" class="p-6 border-b border-slate-800/80 flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div id="logo-icon" class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-sky-500/20">
                  G
                </div>
                <div>
                  <h1 id="brand-name" class="font-bold text-slate-400 tracking-wide text-sm leading-tight">Portal Gestão</h1>
                  
                </div>
              </div>
              <!-- Close menu button (Removido lg:hidden) -->
              <button id="mobile-menu-close" class="p-1 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" aria-hidden="true" class="lucide lucide-x w-5 h-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
              </button>
            </div>

            <!-- Nav Links -->
            <nav id="nav-menu" class="p-4 space-y-1">
              
              <a id="nav-dashboard" href="#dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="layout-dashboard" aria-hidden="true" class="lucide lucide-layout-dashboard w-4.5 h-4.5 text-slate-500"><rect width="7" height="9" x="3" y="3" rx="1"></rect><rect width="7" height="5" x="14" y="3" rx="1"></rect><rect width="7" height="9" x="14" y="12" rx="1"></rect><rect width="7" height="5" x="3" y="16" rx="1"></rect></svg>
                <span>Dashboard</span>
              </a>

              <a id="nav-appointments" href="#appointments" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="calendar-days" aria-hidden="true" class="lucide lucide-calendar-days w-4.5 h-4.5 text-slate-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 14h.01"></path><path d="M12 14h.01"></path><path d="M16 14h.01"></path><path d="M8 18h.01"></path><path d="M12 18h.01"></path><path d="M16 18h.01"></path></svg>
                <span>Agendamentos</span>
              </a>

              <!-- ACTIVE TAB: Lista de Espera -->
                            
              <a id="nav-mobile-units" href="#mobile-units" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="clock" aria-hidden="true" class="lucide lucide-truck w-4.5 h-4.5 text-slate-500"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M15 18H9"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle></svg>
                <span>Lista de Espera</span>
              </a>

              <a id="nav-mobile-units" href="#mobile-units" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="truck" aria-hidden="true" class="lucide lucide-truck w-4.5 h-4.5 text-slate-500"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M15 18H9"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle></svg>
                <span>Unidades Móveis</span>
              </a>

              <a id="nav-patients" href="#patients" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users-round" aria-hidden="true" class="lucide lucide-users-round w-4.5 h-4.5 text-slate-500"><path d="M18 21a8 8 0 0 0-16 0"></path><circle cx="10" cy="8" r="5"></circle><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path></svg>
                <span>Colaborador</span>
              </a>

              <a href="paciente.html" id="nav-patients" href="#patients" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users-round" aria-hidden="true" class="lucide lucide-users-round w-4.5 h-4.5 text-slate-500"><path d="M18 21a8 8 0 0 0-16 0"></path><circle cx="10" cy="8" r="5"></circle><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path></svg>
                <span>Pacientes</span>
              </a>

              <a id="nav-reports" href="#reports" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="bar-chart-3" aria-hidden="true" class="lucide lucide-bar-chart-3 w-4.5 h-4.5 text-slate-500"><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg>
                <span>Relatórios</span>
              </a>
            </nav>
          </div>

          <!-- Sidebar Footer -->
          <div id="sidebar-footer" class="p-4 border-t border-slate-800/80 space-y-1">
            
            <a id="nav-logout" href="#logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-all font-medium text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="log-out" aria-hidden="true" class="lucide lucide-log-out w-4.5 h-4.5 text-rose-400/80"><path d="m16 17 5-5-5-5"></path><path d="M21 12H9"></path><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path></svg>
              <button onclick="logout()">Sair</button>
            </a>
          </div>
        </aside>

        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 z-40 hidden opacity-0 transition-opacity duration-300"></div>

        

        <script>
          document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
              if (sidebar) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
              }
              if (sidebarOverlay) {
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => {
                  sidebarOverlay.classList.add('opacity-100');
                }, 10);
              }
            }

            function closeSidebar() {
              if (sidebar) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
              }
              if (sidebarOverlay) {
                sidebarOverlay.classList.remove('opacity-100');
                setTimeout(() => {
                  sidebarOverlay.classList.add('hidden');
                }, 300);
              }
            }

            if (mobileMenuToggle && mobileMenuClose && sidebar && sidebarOverlay) {
              mobileMenuToggle.addEventListener('click', openSidebar);
              mobileMenuClose.addEventListener('click', closeSidebar);
              sidebarOverlay.addEventListener('click', closeSidebar);
            }

            if (window.lucide) {
              lucide.createIcons();
            }
          });
        </script>