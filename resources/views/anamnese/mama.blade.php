<x-layout>

             <!--Ínicio anamnese-->


        <div class="mx-auto max-w-5xl px-8 py-8">
          <header class="mb-6">
            <h1 class="text-lg font-semibold text-slate-800">
              Anamnese · Solicitação de mamografia
            </h1>
            <p class="mt-1 text-sm text-slate-400">
              {{ $paciente->nome_completo }} · CPF {{ $paciente->cpf }} ·
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

          @if (session('sucesso'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
              {{ session('sucesso') }}
            </div>
          @endif

          <form method="POST" action="{{ route('anamnese-mama.store') }}" class="flex flex-col gap-5">
            @csrf
            <input type="hidden" name="id_prontuario" value="{{ $id_prontuario }}">

            <!-- ---------- SEÇÃO 1: Dados da solicitação ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
              <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Dados da solicitação
              </p>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Data da solicitação</span>
                  <input type="date" name="data_realizacao" required value="{{ old('data_realizacao') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                </label>
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Tipo de mamografia</span>
                  <select name="tipo_mamografia" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    <option value="" disabled {{ old('tipo_mamografia') ? '' : 'selected' }}>Selecione</option>
                    <option value="Rastreamento" @selected(old('tipo_mamografia')=='Rastreamento')>Rastreamento</option>
                    <option value="Diagnóstica" @selected(old('tipo_mamografia')=='Diagnóstica')>Diagnóstica</option>
                    <option value="Controle" @selected(old('tipo_mamografia')=='Controle')>Controle</option>
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
                  <input type="hidden" name="nodulo_mama_direita" value="0">
                  <input type="checkbox" name="nodulo_mama_direita" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Nódulo mama direita?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="nodulo_mama_esquerda" value="0">
                  <input type="checkbox" name="nodulo_mama_esquerda" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Nódulo mama esquerda?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="risco_elevado_cancer" value="0">
                  <input type="checkbox" name="risco_elevado_cancer" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Risco elevado câncer?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="mamas_examinadas_anteriormente" value="0">
                  <input type="checkbox" name="mamas_examinadas_anteriormente" value="1" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Mamas já examinadas?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="fez_mamografia_anterior" value="0">
                  <input type="checkbox" name="fez_mamografia_anterior" value="1" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Fez mamografia antes?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="fez_radioterapia_mama" value="0">
                  <input type="checkbox" name="fez_radioterapia_mama" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Já fez radioterapia?
                </label>
                <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">
                  <input type="hidden" name="fez_cirurgia_mama" value="0">
                  <input type="checkbox" name="fez_cirurgia_mama" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100" />
                  Já fez cirurgia na mama?
                </label>
              </div>

              <div class="mt-4 max-w-xs">
                <label class="flex flex-col gap-1.5">
                  <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Ano da última mamografia</span>
                  <input type="number" name="ano_ultima_mamografia" placeholder="2023" min="2000" max="2099" value="{{ old('ano_ultima_mamografia') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
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
                      <input type="text" name="achado_descarga_papilar_dir" maxlength="30" value="{{ old('achado_descarga_papilar_dir') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Esq</span>
                      <input type="text" name="achado_descarga_papilar_esq" maxlength="30" value="{{ old('achado_descarga_papilar_esq') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                  </div>
                </div>
                <div class="rounded-xl border border-slate-100 p-4">
                  <p class="mb-3 text-sm font-medium text-slate-700">Nódulo · localização</p>
                  <div class="grid grid-cols-2 gap-3">
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Dir</span>
                      <input type="text" name="achado_nodulo_localizacao_dir" maxlength="30" value="{{ old('achado_nodulo_localizacao_dir') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Esq</span>
                      <input type="text" name="achado_nodulo_localizacao_esq" maxlength="30" value="{{ old('achado_nodulo_localizacao_esq') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                  </div>
                </div>
                <div class="rounded-xl border border-slate-100 p-4">
                  <p class="mb-3 text-sm font-medium text-slate-700">Linfonodo palpável</p>
                  <div class="grid grid-cols-2 gap-3">
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Dir</span>
                      <input type="text" name="achado_linfonodo_palpavel_dir" maxlength="30" value="{{ old('achado_linfonodo_palpavel_dir') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                    <label class="flex flex-col gap-1.5">
                      <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Esq</span>
                      <input type="text" name="achado_linfonodo_palpavel_esq" maxlength="30" value="{{ old('achado_linfonodo_palpavel_esq') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <!-- ---------- Rodapé: botão de finalizar ---------- -->
            <div class="flex items-center justify-end gap-3 pb-4">
              <button
                type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
              >
                Finalizar anamnese
              </button>
            </div>
          </form>
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