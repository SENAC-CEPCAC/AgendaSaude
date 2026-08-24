@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout sidebar="n3">
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

          @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
              <p class="font-semibold mb-1">Corrija os campos abaixo:</p>
              <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('anamnese-colo.store') }}" class="flex flex-col gap-5">
            @csrf
            <input type="hidden" name="id_prontuario" value="{{ $id_prontuario }}">

            <!-- ---------- SEÇÃO 1: Dados da coleta ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
              <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Dados da coleta
              </p>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Data da coleta</span>
                  <input type="date" name="data_realizacao" required value="{{ old('data_realizacao') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Motivo do exame</span>
                  <select name="motivo_exame" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    <option value="" disabled {{ old('motivo_exame') ? '' : 'selected' }}>Selecione o motivo</option>
                    <option value="Rotina" @selected(old('motivo_exame')=='Rotina')>Rotina</option>
                    <option value="Rastreamento" @selected(old('motivo_exame')=='Rastreamento')>Rastreamento</option>
                    <option value="Sintomas" @selected(old('motivo_exame')=='Sintomas')>Sintomas</option>
                    <option value="Repetição de exame alterado" @selected(old('motivo_exame')=='Repetição de exame alterado')>Repetição de exame alterado</option>
                  </select>
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Última menstruação</span>
                  <input type="date" name="data_ultima_menstruacao" value="{{ old('data_ultima_menstruacao') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
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
                  <input type="hidden" name="fez_preventivo_anterior" value="0">
                  <input type="checkbox" name="fez_preventivo_anterior" value="1" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Fez preventivo antes?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="esta_gravida" value="0">
                  <input type="checkbox" name="esta_gravida" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Está grávida?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="usa_diu" value="0">
                  <input type="checkbox" name="usa_diu" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Usa DIU?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="usa_pilula" value="0">
                  <input type="checkbox" name="usa_pilula" value="1" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Usa pílula?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="usa_hormonio_menopausa" value="0">
                  <input type="checkbox" name="usa_hormonio_menopausa" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Usa hormônio menopausa?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="ja_fez_radioterapia" value="0">
                  <input type="checkbox" name="ja_fez_radioterapia" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Já fez radioterapia?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="sangramento_apos_relacao" value="0">
                  <input type="checkbox" name="sangramento_apos_relacao" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Sangramento após relação?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="sangramento_apos_menopausa" value="0">
                  <input type="checkbox" name="sangramento_apos_menopausa" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Sangramento após menopausa?
                </label>
              </div>

              <div class="mt-4 max-w-xs">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Ano do último preventivo</span>
                  <input type="number" name="ano_ultimo_preventivo" placeholder="2023" min="2000" max="2099" value="{{ old('ano_ultimo_preventivo') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
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
                  <select name="inspecao_colo" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    <option value="" disabled {{ old('inspecao_colo') ? '' : 'selected' }}>Selecione</option>
                    <option value="Normal" @selected(old('inspecao_colo')=='Normal')>Normal</option>
                    <option value="Ectopia" @selected(old('inspecao_colo')=='Ectopia')>Ectopia</option>
                    <option value="Lesão visível" @selected(old('inspecao_colo')=='Lesão visível')>Lesão visível</option>
                    <option value="Sangramento ao toque" @selected(old('inspecao_colo')=='Sangramento ao toque')>Sangramento ao toque</option>
                    <option value="Não visualizado" @selected(old('inspecao_colo')=='Não visualizado')>Não visualizado</option>
                  </select>
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Sinais de DST observados</span>
                  <input type="text" name="sinais_dst" placeholder="Descreva se houver" maxlength="30" value="{{ old('sinais_dst') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
              </div>
            </div>

            <!-- ---------- Rodapé: botão de finalizar ---------- -->
            <div class="flex items-center justify-end gap-3 pb-4">
              <button
                type="submit"
                id="finalizar-btn"
                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
              >
                Finalizar anamnese
              </button>
            </div>
          </form>
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