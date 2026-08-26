<<<<<<< HEAD
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

  
  <!-- @$paciente = $anamneseColo->fatoAnamnese?->prontuario?->paciente; -->
  


=======
<x-layout sidebar="n3">
>>>>>>> 9b6173c (feat: sincronizacao de vagas e horarios, correcoes de performance e datas)
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
        class="text-sm font-medium text-blue-600 hover:text-blue-700">
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
          class="rounded-lg border border-emerald-200 px-5 py-2.5 text-sm font-medium text-emerald-600 transition hover:bg-emerald-50">
          Baixar PDF
        </a>

        <a
          href="{{ route('anamnese-mama.edit', $anamneseMama->id_sismama) }}"
          class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
          Editar
        </a>

      </div>

    </div>
  </div>
  <!-- Script da Sidebar Mobile -->
  <script>
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
      menuToggle.addEventListener('click', function(event) {
        event.stopPropagation();
        setSidebarExpanded(true);
      });
    }

    // Botão X dentro da sidebar
    if (menuClose) {
      menuClose.addEventListener('click', function(event) {
        event.stopPropagation();
        setSidebarExpanded(false);
      });
    }

    // Clicar no overlay fecha o menu
    if (sidebarOverlay) {
      sidebarOverlay.addEventListener('click', function() {
        setSidebarExpanded(false);
      });
    }

    // Clicar fora da sidebar fecha o menu
    document.addEventListener('click', function(event) {
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
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        setSidebarExpanded(false);
      }
    });

    // Estado inicial
    setSidebarExpanded(false);
  </script>