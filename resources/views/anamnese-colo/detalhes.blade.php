<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lista de Agendamentos - Agenda Saúde</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
          }
        }
      }
    }
  </script>
</head>

<body class="bg-[#f8fafc]">

  @php
    $usuario = auth()->user();
    if (! $usuario && session('colaborador_id')) {
      $usuario = \App\Models\UserColaborador::find(session('colaborador_id'));
    }
    $usuarioNome = $usuario?->nome ?? $usuario?->name ?? 'Usuário';
    $nivelUsuario = (int) ($usuario?->nivel ?? $usuario?->permissao ?? 0);
  @endphp

  <!-- Botão Menu Mobile -->
  <button id="mobile-menu-toggle" type="button" class="fixed left-3 top-3 z-[60] flex items-center justify-center rounded-lg bg-blue-600 p-2 text-white shadow-sm transition hover:bg-blue-800 sm:left-5 sm:top-5" aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menu">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="menu" aria-hidden="true" class="lucide lucide-menu h-4 w-4">
      <path d="M4 5h16"></path>
      <path d="M4 12h16"></path>
      <path d="M4 19h16"></path>
    </svg>
  </button>

  <!-- Inclusão Condicional da Sidebar conforme o Nível -->
  @if ((int) $nivelUsuario === 4)
    @include('sidebar.sidebar_n4')
  @elseif ((int) $nivelUsuario === 1 || (int) $nivelUsuario === 2)
    @include('sidebar.sidebar_n1_n2')
  @endif
    @php
      $paciente = $anamneseColo->fatoAnamnese?->prontuario?->paciente;
    @endphp
  <div class="mx-auto max-w-6xl px-8 py-8">
    <div class="flex flex-col gap-5">
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Paciente
        </p>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Nome completo</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $paciente?->nome_completo ?? '—' }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">CPF</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $paciente?->cpf ?? '—' }}</dd>
          </div>
        </dl>
      </div>

      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Dados da coleta
        </p>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Data da coleta</dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ optional($anamneseColo->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}
            </dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Motivo do exame</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->motivo_exame }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Última menstruação</dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ optional($anamneseColo->data_ultima_menstruacao)->format('d/m/Y') ?? '—' }}
            </dd>
          </div>
        </dl>
      </div>

      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Histórico
        </p>
        <div class="flex flex-wrap gap-2.5">
          @php
            $historico = [
              'Fez preventivo antes?' => $anamneseColo->fez_preventivo_anterior,
              'Está grávida?' => $anamneseColo->esta_gravida,
              'Usa DIU?' => $anamneseColo->usa_diu,
              'Usa pílula?' => $anamneseColo->usa_pilula,
              'Usa hormônio menopausa?' => $anamneseColo->usa_hormonio_menopausa,
              'Já fez radioterapia?' => $anamneseColo->ja_fez_radioterapia,
              'Sangramento após relação?' => $anamneseColo->sangramento_apos_relacao,
              'Sangramento após menopausa?' => $anamneseColo->sangramento_apos_menopausa,
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
          <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Ano do último preventivo</dt>
          <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->ano_ultimo_preventivo ?? '—' }}</dd>
        </div>
      </div>

      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Exame do colo
        </p>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Inspeção do colo</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->inspecao_colo }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Sinais de DST observados</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->sinais_dst ?? 'Nenhum' }}</dd>
          </div>
        </dl>
      </div>

      <div class="flex items-center justify-end gap-3 pb-4">
        <a href="{{ route('anamnese-colo.pdf', $anamneseColo->id_siscolo) }}"
           class="rounded-lg border border-emerald-200 px-5 py-2.5 text-sm font-medium text-emerald-600 transition hover:bg-emerald-50">
          Baixar PDF
        </a>
        @if ((int) $nivelUsuario === 3)
        <a href="{{ route('anamnese-colo.edit', $anamneseColo->id_siscolo) }}"
           class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
          Editar
        </a>
        @endif
      </div>
    </div>
  </div>
  <!-- Lucide Icon Library & Initialization -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
     <!-- Script da Sidebar Mobile -->

  const sidebar = document.getElementById('sidebar');
  const menuToggle = document.getElementById('mobile-menu-toggle');
  const menuClose = document.getElementById('mobile-menu-close');
  const sidebarOverlay = document.getElementById('sidebar-overlay');

  function setSidebarExpanded(expanded) {
    if (!sidebar) return;

    // Abre/fecha a sidebar
    sidebar.classList.toggle('-translate-x-full', !expanded);

    // Mostra/esconde o overlay
    if (sidebarOverlay) {
      sidebarOverlay.classList.toggle('hidden', !expanded);
      sidebarOverlay.setAttribute('aria-hidden', String(!expanded));
    }

    // Esconde o hambúrguer quando o menu estiver aberto
    if (menuToggle) {
      menuToggle.classList.toggle('hidden', expanded);
      menuToggle.setAttribute('aria-expanded', String(expanded));
      menuToggle.setAttribute(
        'aria-label',
        expanded ? 'Fechar menu' : 'Abrir menu'
      );
    }

    // Atualiza botão de fechar, se existir
    if (menuClose) {
      menuClose.setAttribute('aria-expanded', String(expanded));
    }

    // Evita scroll da página enquanto o menu está aberto
    document.body.classList.toggle('overflow-hidden', expanded);
  }

  // Abrir menu
  if (menuToggle) {
    menuToggle.addEventListener('click', function (event) {
      event.stopPropagation();
      setSidebarExpanded(true);
    });
  }

  // Botão X dentro da sidebar
  if (menuClose) {
    menuClose.addEventListener('click', function (event) {
      event.stopPropagation();
      setSidebarExpanded(false);
    });
  }

  // Clicar no overlay fecha o menu
  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', function () {
      setSidebarExpanded(false);
    });
  }

  // Clicar fora da sidebar fecha o menu
  document.addEventListener('click', function (event) {
    if (!sidebar || sidebar.classList.contains('-translate-x-full')) {
      return;
    }

    const clicouDentroDaSidebar = sidebar.contains(event.target);
    const clicouNoBotaoMenu = menuToggle && menuToggle.contains(event.target);

    if (!clicouDentroDaSidebar && !clicouNoBotaoMenu) {
      setSidebarExpanded(false);
    }
  });

  // ESC também fecha o menu
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      setSidebarExpanded(false);
    }
  });

  // Estado inicial
  setSidebarExpanded(false);
    </script>
