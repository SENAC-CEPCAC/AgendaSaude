@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>

          <!-- Cabeçalho da página + botão de nova unidade -->
          <header class="mb-6 flex items-start justify-between gap-4">
            <div>
              <h1 class="text-lg font-semibold text-slate-800">Unidades Móveis</h1>
              <p class="mt-1 max-w-2xl text-sm text-slate-400">
                Gerencie a frota de unidades móveis de atendimento, acompanhe status e localização em tempo real.
              </p>
            </div>
            <button class="flex flex-none items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
              <span>+</span> Nova Unidade
            </button>
          </header>
 
          <!-- Barra de busca e filtros -->
          <div class="mb-5 flex flex-col gap-3 sm:flex-row">
            <input
              type="text"
              placeholder="Buscar por ID, especialidade ou localização..."
              class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:flex-1"
            />
            <select class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
              <option>Todos os Status</option>
              <option>Ativa</option>
              <option>Em Manutenção</option>
              <option>Inativa</option>
            </select>
            <button class="flex-none rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-slate-500 hover:bg-slate-50">
              ⚙️
            </button>
          </div>
 
          <!-- ---------- Grade de cards das unidades ---------- -->
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-1 justify-items-center">
 
            <!-- UM-01 -->
            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm w-full max-w-sm">
              <div class="relative flex h-36 items-center justify-center bg-gradient-to-br from-slate-700 to-slate-500">
                <span class="text-4xl">🚐</span>
                <span class="absolute right-3 top-3 rounded-full bg-emerald-500 px-2.5 py-1 text-xs font-medium text-white">
                  ● Ativa
                </span>
              </div>
              <div class="p-4">
                <div class="mb-1 flex items-center justify-between">
                  <p class="text-sm font-semibold text-slate-800">UM-01</p>
                  <button class="text-slate-400 hover:text-slate-600">⋮</button>
                </div>
                <p class="mb-3 text-xs text-slate-500"> Saúde Mulher</p>
 
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Localização atual</p>
                <p class="mb-3 text-sm text-slate-600">📍 Praça da Sé, Centro</p>
 
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Capacidade / Uso</p>
                <div class="mb-1 mt-1 h-1.5 w-full rounded-full bg-slate-100">
                  <div class="h-1.5 rounded-full bg-blue-600" style="width: 85%"></div>
                </div>
                <p class="mb-4 text-right text-xs text-slate-400">85%</p>
 
                <div class="flex gap-2">
                  <button class="flex-1 rounded-lg border border-slate-200 py-2 text-xs font-medium text-slate-700 hover:border-slate-300">
                    DETALHES
                  </button>
                  <button class="flex-1 rounded-lg bg-amber-400 py-2 text-xs font-medium text-slate-900 hover:bg-amber-500">
                    AGENDA
                  </button>
                </div>
              </div>
            </div>
 
        </div>
      </main>
    </div>
  <!-- Lucide Icon Library & Initialization -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      // Initialize Lucide icons on load
      lucide.createIcons();

      // Mobile Sidebar Toggle Logic
      const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
      const mobileMenuClose = document.getElementById('mobile-menu-close');
      const sidebar = document.getElementById('sidebar');
      const sidebarOverlay = document.getElementById('sidebar-overlay');

      function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
        setTimeout(() => {
          sidebarOverlay.classList.add('opacity-100');
        }, 10);
      }

      function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.remove('opacity-100');
        setTimeout(() => {
          sidebarOverlay.classList.add('hidden');
        }, 300);
      }

      if (mobileMenuToggle && mobileMenuClose && sidebar && sidebarOverlay) {
        mobileMenuToggle.addEventListener('click', openSidebar);
        mobileMenuClose.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
      }

       const hoje = new Date();
       const formatoData = hoje.toLocaleDateString('pt-BR')
       document.getElementById('data-atual').textContent = formatoData;
    </script>
 
  </x-layout>