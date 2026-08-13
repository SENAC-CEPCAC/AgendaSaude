@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>
          <!--Ínicio anamnese-->
          
        <div class="mx-auto max-w-5xl px-8 py-8">
          <header class="mb-6">
            <h1 class="text-lg font-semibold text-slate-800">
              Anamnese · Coleta de preventivo
            </h1>
            <p class="mt-1 text-sm text-slate-400">
              Maria Aparecida Souza · Unidade Móvel Centro · 
              <span id="data-atual"></span>
               </p>
          
          </header>

          <div class="flex flex-col gap-5">
            <!-- ---------- SEÇÃO 1: Dados da coleta ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
              <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Dados da coleta
              </p>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Data da coleta</span>
                  <input type="date" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Motivo do exame</span>
                  <select class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" defaultValue="">
                    <option value="" disabled selected>Selecione o motivo</option>
                    <option>Rotina</option>
                    <option>Rastreamento</option>
                    <option>Sintomas</option>
                    <option>Repetição de exame alterado</option>
                  </select>
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Última menstruação</span>
                  <input type="date" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
              </div>
            </div>
            

            <!-- ---------- SEÇÃO 2: Histórico (checkboxes) ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
              <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Histórico
              </p>
              <div class="flex flex-wrap gap-2.5">
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Fez preventivo antes?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Está grávida?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Usa DIU?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Usa pílula?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Usa hormônio menopausa?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Já fez radioterapia?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Sangramento após relação?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Sangramento após menopausa?
                </label>
              </div>

              <div class="mt-4 max-w-xs">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Ano do último preventivo</span>
                  <input type="number" placeholder="2023" min="2000" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
              </div>
            </div>

            <!-- ---------- SEÇÃO 3: Exame do colo ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
              <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Exame do colo
              </p>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Inspeção do colo</span>
                  <select class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" defaultValue="">
                    <option value="" disabled selected>Selecione</option>
                    <option>Normal</option>
                    <option>Ectopia</option>
                    <option>Lesão visível</option>
                    <option>Sangramento ao toque</option>
                    <option>Não visualizado</option>
                  </select>
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Sinais de DST observados</span>
                  <input type="text" placeholder="Descreva se houver" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
              </div>
            </div>

            <!-- ---------- Rodapé: botão de finalizar ---------- -->
            <div class="flex items-center justify-end gap-3 pb-4">
              <span id="saved-msg" class="hidden text-sm text-emerald-600">
                Anamnese salva ✓
              </span>
              <button
                type="button"
                id="finalizar-btn"
                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
              >
                Finalizar anamnese
              </button>
            </div>
          </div>
        </div>
      </main>
    
    
      
      </div>
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