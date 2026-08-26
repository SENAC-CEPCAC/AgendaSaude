@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout sidebar="n3">
  <div class="mx-auto max-w-3xl px-8 py-8">
    <header class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold text-slate-800">
          Anamnese · Detalhes
        </h1>
        <p class="mt-1 text-sm text-slate-400">
          Prontuário #{{ $anamneseMama->fatoAnamnese?->id_prontuario ?? '—' }} ·
          {{ optional($anamneseMama->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}
        </p>
      </div>

      <a
        href="{{ route('anamnese-mama.index') }}"
        class="text-sm font-medium text-blue-600 hover:text-blue-700"
      >
        ← Voltar à lista
      </a>
    </header>

    @php
      $paciente = $anamneseMama->fatoAnamnese?->prontuario?->paciente;
    @endphp

    <div class="flex flex-col gap-5">

      <!-- PACIENTE -->
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Paciente
        </p>

        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Nome completo
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ $paciente?->nome_completo ?? '—' }}
            </dd>
          </div>

          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              CPF
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ $paciente?->cpf ?? '—' }}
            </dd>
          </div>
        </dl>
      </div>

      <!-- DADOS DA SOLICITAÇÃO -->
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Dados da solicitação
        </p>

        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Data da solicitação
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ optional($anamneseMama->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}
            </dd>
          </div>

          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Tipo de mamografia
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ $anamneseMama->tipo_mamografia ?? '—' }}
            </dd>
          </div>
        </dl>
      </div>

      <!-- HISTÓRICO -->
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Histórico
        </p>

        <div class="flex flex-wrap gap-2.5">
          @php
            $historico = [
              'Nódulo mama direita?' => $anamneseMama->nodulo_mama_direita,
              'Nódulo mama esquerda?' => $anamneseMama->nodulo_mama_esquerda,
              'Risco elevado câncer?' => $anamneseMama->risco_elevado_cancer,
              'Mamas já examinadas?' => $anamneseMama->mamas_examinadas_anteriormente,
              'Fez mamografia antes?' => $anamneseMama->fez_mamografia_anterior,
              'Já fez radioterapia?' => $anamneseMama->fez_radioterapia_mama,
              'Já fez cirurgia na mama?' => $anamneseMama->fez_cirurgia_mama,
            ];
          @endphp

          @foreach ($historico as $label => $valor)
            <span class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600">
              <span class="{{ $valor ? 'text-emerald-600' : 'text-slate-300' }}">
                {{ $valor ? '✓' : '—' }}
              </span>
              {{ $label }}
            </span>
          @endforeach
        </div>

        <div class="mt-4 max-w-xs">
          <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
            Ano da última mamografia
          </dt>
          <dd class="mt-1 text-sm text-slate-700">
            {{ $anamneseMama->ano_ultima_mamografia ?? '—' }}
          </dd>
        </div>
      </div>

      <!-- ACHADOS CLÍNICOS -->
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Achados clínicos
        </p>

        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">

          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Descarga papilar direita
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ $anamneseMama->achado_descarga_papilar_dir ?? '—' }}
            </dd>
          </div>

          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Descarga papilar esquerda
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ $anamneseMama->achado_descarga_papilar_esq ?? '—' }}
            </dd>
          </div>

          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Linfonodo palpável
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              Dir: {{ $anamneseMama->achado_linfonodo_palpavel_dir ?? '—' }}
              <br>
              Esq: {{ $anamneseMama->achado_linfonodo_palpavel_esq ?? '—' }}
            </dd>
          </div>

          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Nódulo · localização direita
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ $anamneseMama->achado_nodulo_localizacao_dir ?? '—' }}
            </dd>
          </div>

          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
              Nódulo · localização esquerda
            </dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ $anamneseMama->achado_nodulo_localizacao_esq ?? '—' }}
            </dd>
          </div>

        </dl>
      </div>

      <!-- BOTÕES -->
      <div class="flex items-center justify-end gap-3 pb-4">

        <a
          href="{{ route('anamnese-mama.pdf', $anamneseMama->id_sismama) }}"
          class="rounded-lg border border-emerald-200 px-5 py-2.5 text-sm font-medium text-emerald-600 transition hover:bg-emerald-50"
        >
          Baixar PDF
        </a>

        <a
          href="{{ route('anamnese-mama.edit', $anamneseMama->id_sismama) }}"
          class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50"
        >
          Editar
        </a>

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