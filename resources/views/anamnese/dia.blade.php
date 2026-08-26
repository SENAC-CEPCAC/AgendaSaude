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


  <div class="mx-auto max-w-6xl px-8 py-8">

    <header class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold text-slate-800">
          Exames do dia
        </h1>
        <p class="mt-1 text-sm text-slate-400">
          Anamneses de preventivo (colo) e mamografia (mama) registradas no período selecionado.
        </p>
      </div>
    </header>

    @if (session('sucesso'))
    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
      {{ session('sucesso') }}
    </div>
    @endif

    {{-- Filtro de intervalo de datas + botão de relatório --}}
    <form method="GET" action="{{ route('anamnese-dia.index') }}" class="mb-4 flex items-end justify-between gap-3">
      <div class="flex items-end gap-3">
        <label class="flex flex-col gap-1.5">
          <span class="text-xs font-medium uppercase tracking-wide text-slate-400">De</span>
          <input
            type="date"
            name="data_inicio"
            value="{{ $dataInicio }}"
            class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
        </label>
        <label class="flex flex-col gap-1.5">
          <span class="text-xs font-medium uppercase tracking-wide text-slate-400">Até</span>
          <input
            type="date"
            name="data_fim"
            value="{{ $dataFim }}"
            class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
        </label>
        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
          Filtrar
        </button>
        <a href="{{ route('anamnese-dia.index') }}" class="px-2 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-700">
          Hoje
        </a>
      </div>

      {{-- Abre o relatório em PDF com todos os exames do intervalo filtrado --}}
      <a href="{{ route('anamnese-dia.pdf', ['data_inicio' => $dataInicio, 'data_fim' => $dataFim]) }}"
        target="_blank"
        class="flex items-center gap-1.5 rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 hover:border-slate-300">
        🖨 Gerar relatório
      </a>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
      @if ($anamneses->isEmpty())
      <div class="p-8 text-center text-sm text-slate-400">
        @if ($dataInicio === $dataFim)
        Nenhum exame registrado em {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}.
        @else
        Nenhum exame registrado entre {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}
        e {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}.
        @endif
      </div>
      @else
      <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-400">
          <tr>
            <th class="px-6 py-3">Paciente</th>
            <th class="px-6 py-3">CPF</th>
            <th class="px-6 py-3">Tipo</th>
            <th class="px-6 py-3">Data</th>
            <th class="px-6 py-3 text-right">Ações</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach ($anamneses as $anamnese)
          @php
          $paciente = $anamnese->prontuario?->paciente;
          $ehColo = $anamnese->tipo_anamnese === 'siscolo';
          $ehMama = $anamnese->tipo_anamnese === 'sismama';
          @endphp
          <tr class="hover:bg-slate-50">
            <td class="px-6 py-3 text-slate-700">{{ $paciente?->nome_completo ?? '—' }}</td>
            <td class="px-6 py-3 text-slate-700">{{ $paciente?->cpf ?? '—' }}</td>
            <td class="px-6 py-3">
              @if ($ehColo)
              <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                Preventivo (Colo)
              </span>
              @elseif ($ehMama)
              <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">
                Mamografia
              </span>
              @else
              <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                {{ $anamnese->tipo_anamnese }}
              </span>
              @endif
            </td>
            <td class="px-6 py-3 text-slate-700">
              {{ optional($anamnese->data_realizacao)->format('d/m/Y') ?? '—' }}
            </td>
            <td class="px-6 py-3">
              <div class="flex items-center justify-end gap-3">
                @if ($ehColo && $anamnese->anamneseColo)
                <a href="{{ route('anamnese-colo.show', $anamnese->anamneseColo->id_siscolo) }}"
                  class="text-sm font-medium text-blue-600 hover:text-blue-700">
                  Ver
                </a>
                <a href="{{ route('anamnese-colo.pdf', $anamnese->anamneseColo->id_siscolo) }}"
                  class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                  PDF
                </a>
                <form method="POST"
                  action="{{ route('anamnese-colo.destroy', $anamnese->anamneseColo->id_siscolo) }}"
                  onsubmit="return confirm('Tem certeza que deseja excluir esta anamnese?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">
                    Excluir
                  </button>
                </form>
                @elseif ($ehMama && $anamnese->anamneseMama)
                <a href="{{ route('anamnese-mama.show', $anamnese->anamneseMama->id_sismama) }}"
                  class="text-sm font-medium text-blue-600 hover:text-blue-700">
                  Ver
                </a>
                <a href="{{ route('anamnese-mama.pdf', $anamnese->anamneseMama->id_sismama) }}"
                  class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                  PDF
                </a>
                <form method="POST"
                  action="{{ route('anamnese-mama.destroy', $anamnese->anamneseMama->id_sismama) }}"
                  onsubmit="return confirm('Tem certeza que deseja excluir esta anamnese?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">
                    Excluir
                  </button>
                </form>
                @else
                <span class="text-xs text-slate-300">—</span>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>

  </div>

  <!-- Lucide Icon Library & Initialization -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    // Initialize Lucide icons on load
    lucide.createIcons();

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