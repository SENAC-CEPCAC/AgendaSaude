<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Anamnese - Pacientes do Dia</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

@php
$usuario = auth()->user();
if (! $usuario && session('colaborador_id')) {
$usuario = \App\Models\UserColaborador::find(session('colaborador_id'));
}
$nivelUsuario = (int) ($usuario?->nivel ?? $usuario?->permissao ?? 0);
@endphp

<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen" data-sidebar-enabled="{{ $nivelUsuario === 3 || $nivelUsuario === 4 ? 'true' : 'false' }}">
  <div id="app-root" class="min-h-screen flex flex-col">

    @if ($nivelUsuario === 3)
    @include('sidebar.sidebar_n3')
    @elseif ($nivelUsuario === 4)
    @include('sidebar.sidebar_n4')
    @endif
    @if ($nivelUsuario === 3 || $nivelUsuario === 4)
    <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-900/40 opacity-0 transition-opacity duration-300"></div>
    <button id="mobile-menu-toggle" type="button" class="fixed left-3 top-3 z-[60] flex items-center justify-center rounded-lg bg-blue-600 p-2 text-white shadow-sm transition hover:bg-blue-800 sm:left-5 sm:top-5" aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menu">
      <i data-lucide="menu" class="h-4 w-4"></i>
    </button>
    @endif

    <main id="main-content" class="min-h-screen flex-1 flex flex-col p-4 md:p-8 md:ml-64">
      <!-- Top Bar -->
      <header id="top-bar" class="h-16 bg-white border border-slate-200/80 px-4 md:px-6 flex items-center justify-between sticky top-4 z-20 shadow-sm rounded-xl mb-6">
        <div class="flex items-center gap-3">
          <div id="breadcrumb" class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <span>Portal Gestão</span>
            <span>/</span>
            <span class="text-slate-700 font-semibold">Anamnese · Pacientes do Dia</span>
          </div>
        </div>
      </header>

      <div class="max-w-7xl w-full mx-auto space-y-6">

        <!-- Cabeçalho e Título -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold text-slate-900">Anamnese · Pacientes do Dia</h1>
            <p class="text-sm text-slate-500 mt-0.5">Selecione um paciente para preencher a anamnese do exame (Colo ou Mama).</p>
          </div>
        </div>

        <!-- Mensagens Flash de Sucesso ou Erro -->
        @if (session('sucesso'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium flex items-center justify-between shadow-sm">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-600 text-[20px]">check_circle</span>
            <span>{{ session('sucesso') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
        </div>
        @endif

        @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-medium shadow-sm">
          <div class="flex items-center gap-2 font-bold mb-1">
            <span class="material-symbols-outlined text-rose-600 text-[20px]">error</span>
            Ocorreram erros na operação:
          </div>
          <ul class="list-disc list-inside text-xs space-y-1">
            @foreach ($errors->all() as $erro)
            <li>{{ $erro }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Barra de Pesquisa e Filtros -->
        <form method="GET" action="{{ route('anamnese.paciente') }}" class="bg-white rounded-xl border border-slate-200/80 p-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
          <div class="relative w-full md:w-96 flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-slate-400 text-[20px] pointer-events-none">search</span>
            <input
              type="text"
              name="busca"
              value="{{ $termo_busca }}"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:bg-white transition-all"
              placeholder="Buscar por paciente, CPF ou Nº...">
          </div>

          <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
            <!-- Filtro de Comparecimento -->
            <select
              name="status"
              onchange="this.form.submit()"
              class="bg-white border border-slate-200 text-slate-700 rounded-xl px-3 py-2 text-xs font-medium focus:outline-none focus:border-blue-900 transition-all cursor-pointer">
              <option value="">Status Atendimento (Todos)</option>
              <option value="agendado" {{ $filtro_status === 'agendado' ? 'selected' : '' }}>Agendado</option>
              <option value="confirmado" {{ $filtro_status === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
              <option value="espera" {{ $filtro_status === 'espera' ? 'selected' : '' }}>Lista de Espera</option>
              <option value="presente" {{ $filtro_status === 'presente' ? 'selected' : '' }}>Presente na Unidade</option>
              <option value="faltou" {{ $filtro_status === 'faltou' ? 'selected' : '' }}>Faltou</option>
              <option value="cancelado" {{ $filtro_status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>

            <!-- Filtro de Data de Atendimento -->
            <input
              type="date"
              name="data_atendimento"
              value="{{ $filtro_data ?? '' }}"
              onchange="this.form.submit()"
              class="bg-white border border-slate-200 text-slate-700 rounded-xl px-3 py-2 text-xs font-medium focus:outline-none focus:border-blue-900 transition-all cursor-pointer">

            @if($termo_busca || $filtro_status)
            <a href="{{ route('anamnese.paciente') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Limpar</a>
            @endif
          </div>
        </form>

        <!-- Tabela de Pacientes -->
        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                <th class="py-4 px-5">Nº</th>
                <th class="py-4 px-5">Paciente & CPF</th>
                <th class="py-4 px-5">Exame / Unidade</th>
                <th class="py-4 px-5">Data / Turno</th>
                <th class="py-4 px-5 text-center">Anamnese</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">

              @forelse($lista_agendamentos as $agendamento)
              <tr class="hover:bg-slate-50/60 transition-colors">
                <td class="py-4 px-5 font-semibold text-slate-800">
                  #{{ $agendamento->id_prontuario }}
                </td>

                <!-- Paciente -->
                <td class="py-4 px-5">
                  <div class="font-bold text-slate-800">
                    {{ $agendamento->paciente ? $agendamento->paciente->nome_completo : 'Paciente CPF ' . $agendamento->cpf_paciente }}
                  </div>
                  <div class="text-xs text-slate-400 font-mono mt-0.5">
                    CPF: {{ $agendamento->paciente ? $agendamento->paciente->cpf_paciente : ($agendamento->cpf_paciente ?? 'Não informado') }}
                  </div>
                </td>

                <!-- Exame & Unidade -->
                <td class="py-4 px-5">
                  <span class="font-medium text-slate-700 block">
                    {{ $agendamento->cronograma?->vaga?->tipo_exame ?? 'Exame Preventivo' }}
                  </span>
                  <span class="text-xs text-slate-400">
                    {{ $agendamento->cronograma?->unidade?->nome_unidade ?? 'Unidade Móvel 01' }}
                  </span>
                </td>

                <!-- Data e Turno -->
                <td class="py-4 px-5">
                  <span class="font-medium text-slate-700 block">
                    {{ $agendamento->cronograma ? \Carbon\Carbon::parse($agendamento->cronograma->data_atendimento)->format('d/m/Y') : now()->format('d/m/Y') }}
                  </span>
                  <span class="text-xs text-slate-400">
                    Turno: {{ $agendamento->cronograma?->turno?->turno ?? 'Manhã' }}
                  </span>
                </td>

                <!-- Ação: Preencher Anamnese -->
                <td class="py-4 px-5 text-center">
                  @php
                    $tipoExame = strtolower($agendamento->cronograma?->vaga?->tipo_exame ?? '');
                    $ehMamografia = str_contains($tipoExame, 'mamo');
                  @endphp

                  <a
                    href="{{ route($ehMamografia ? 'anamnese-mama.create' : 'anamnese-colo.create', $agendamento->id_prontuario) }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg transition-colors text-xs font-semibold"
                    title="Preencher Anamnese ({{ $ehMamografia ? 'Mama' : 'Colo' }})">
                    <span class="material-symbols-outlined text-[18px]">clinical_notes</span>
                    Preencher Anamnese
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                  <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">inbox</span>
                  Nenhum paciente encontrado para os filtros selecionados.
                </td>
              </tr>
              @endforelse

            </tbody>
          </table>
        </div>

        <!-- Paginação -->
        <div class="pt-2">
          {{ $lista_agendamentos->links() }}
        </div>
      </div>
    </main>
  </div>

  <script>
    if (window.lucide) {
      lucide.createIcons();
    }

    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const sidebarEnabled = document.body.dataset.sidebarEnabled === 'true';

    if (sidebarEnabled && sidebar && sidebarOverlay && mobileMenuToggle) {
      const setSidebarOpen = (open) => {
        sidebar.classList.toggle('-translate-x-full', !open);
        sidebar.classList.toggle('translate-x-0', open);
        sidebarOverlay.classList.toggle('hidden', !open);
        sidebarOverlay.classList.toggle('opacity-100', open);
        mobileMenuToggle.classList.toggle('hidden', open);
        mobileMenuToggle.setAttribute('aria-expanded', String(open));
        mobileMenuToggle.setAttribute('aria-label', open ? 'Recolher menu' : 'Abrir menu');
      };

      mobileMenuToggle.addEventListener('click', () => setSidebarOpen(!sidebar.classList.contains('translate-x-0')));
      if (mobileMenuClose) mobileMenuClose.addEventListener('click', () => setSidebarOpen(false));
      sidebarOverlay.addEventListener('click', () => setSidebarOpen(false));
    }
  </script>
</body>

</html>