@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>

             <!--Ínicio anamnese-->
         

        <div class="mx-auto max-w-5xl px-8 py-8">
          <header class="mb-6">
            <h1 class="text-lg font-semibold text-slate-800">
              Anamnese · Solicitação de mamografia
            </h1>
            <p class="mt-1 text-sm text-slate-400">
              Maria Aparecida Souza · Unidade Móvel Centro · 
               <span id="data-atual"></span>
            </p>
          </header>
 
          <div class="flex flex-col gap-5">
            <!-- ---------- SEÇÃO 1: Dados da solicitação ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
              <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Dados da solicitação
              </p>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Data da solicitação</span>
                  <input type="date" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Tipo de mamografia</span>
                  <select class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" defaultValue="">
                    <option value="" disabled selected>Selecione</option>
                    <option>Rastreamento</option>
                    <option>Diagnóstica</option>
                    <option>Controle</option>
                  </select>
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
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Nódulo mama direita?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Nódulo mama esquerda?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Risco elevado câncer?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Mamas já examinadas?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Fez mamografia antes?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Já fez radioterapia?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Já fez cirurgia na mama?
                </label>
              </div>
 
              <div class="mt-4 max-w-xs">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Ano da última mamografia</span>
                  <input type="number" placeholder="2023" min="2000" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
              </div>
            </div>
 
            <!-- ---------- SEÇÃO 3: Achados clínicos ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
              <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Achados clínicos
              </p>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-slate-100 p-4">
                  <p class="mb-3 text-sm font-medium text-slate-700">Descarga papilar</p>
                  <div class="grid grid-cols-2 gap-3">
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Dir</span>
                      <input type="text" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Esq</span>
                      <input type="text" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                  </div>
                </div>
                <div class="rounded-xl border border-slate-100 p-4">
                  <p class="mb-3 text-sm font-medium text-slate-700">Nódulo · localização</p>
                  <div class="grid grid-cols-2 gap-3">
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Dir</span>
                      <input type="text" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Esq</span>
                      <input type="text" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                  </div>
                </div>
                <div class="rounded-xl border border-slate-100 p-4">
                  <p class="mb-3 text-sm font-medium text-slate-700">Linfonodo palpável</p>
                  <div class="grid grid-cols-2 gap-3">
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Dir</span>
                      <input type="text" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Esq</span>
                      <input type="text" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                  </div>
                </div>
              </div>
            </div>
 
            <!-- ---------- Rodapé: botão de finalizar ---------- -->
            <div class="flex items-center justify-end gap-3 pb-4">
              <button
                type="button"
                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
              >
                Finalizar anamnese
              </button>
            </div>
          </div>
        </div>
  
      
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