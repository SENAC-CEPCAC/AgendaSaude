<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agendamentos - Agenda Saúde</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

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

  <div id="app-root" class="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased">

    <!-- Top Bar / Header -->
    <header id="top-bar" class="h-16 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-xs">
      <div class="flex items-center gap-3 pl-12 sm:pl-14">
        @if ($nivelUsuario === 1)
          <span class="text-xs font-semibold uppercase tracking-wider text-blue-900 bg-blue-50 px-2.5 py-1 rounded-md">
            Portal do Paciente
          </span>
        @else
          <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 bg-slate-100 px-2.5 py-1 rounded-md">
            Gestão de Agendamentos
          </span>
        @endif
      </div>

    </header>

    <!-- Conteúdo Principal -->
    <main id="main-content" class="max-w-7xl w-full mx-auto p-6 md:p-8 space-y-6">

      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Agendamentos</h1>
          <p class="text-xs text-slate-500 mt-1">Gestão da fila inteligente, validação de documentos e controle de comparecimento.</p>
        </div>
        @if ($nivelUsuario !== 3)
        <div>
          <a href="{{ route('agendamento.etapa1') }}" target="_blank" class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-all">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            Novo Agendamento
          </a>
        </div>
        @endif
      </div>

      <!-- Filtros e Busca -->
      <form id="filterForm" method="GET" action="{{ url()->current() }}" class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xs">
        @if($nivelUsuario !== 1)
        <div class="relative w-full md:w-96 flex items-center">
          <i data-lucide="search" class="absolute left-4 text-slate-400 w-5 h-5 pointer-events-none"></i>
          <input
            type="text"
            name="search"
            id="searchInput"
            value="{{ request('search') }}"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-12 pr-4 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition-all"
            placeholder="Buscar por paciente, CPF ou Nº...">
        </div>
        @endif

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
          <!-- Filtro Status Comparecimento / Agendamento -->
          <select
            name="status"
            onchange="this.form.submit()"
            class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer">
            <option value="">Todos os Status Agendamento</option>
            <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
            <option value="presente" {{ request('status') == 'presente' ? 'selected' : '' }}>Presente</option>
            <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
            <option value="nao_compareceu" {{ request('status') == 'nao_compareceu' ? 'selected' : '' }}>Não Compareceu</option>
            <option value="aguardando_confirmacao" {{ request('status') == 'aguardando_confirmacao' ? 'selected' : '' }}>Aguardando 24h</option>
            <option value="em_espera" {{ request('status') == 'em_espera' || request('status') == 'espera' ? 'selected' : '' }}>Lista de Espera</option>
            <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
          </select>

          <!-- Filtro Status Documentos -->
          <select
            name="status_documentos"
            onchange="this.form.submit()"
            class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer">
            <option value="">Todos os Status Documentos</option>
            <option value="aprovado" {{ request('status_documentos') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
            <option value="pendente" {{ request('status_documentos') == 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="validar_no_ato" {{ request('status_documentos') == 'validar_no_ato' ? 'selected' : '' }}>Validar no Ato</option>
            <option value="rejeitado" {{ request('status_documentos') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
          </select>
        </div>

      <!-- Tabela Principal -->
      <div class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                <th class="py-4 px-6 w-[12%]">Nº Agendamento</th>
                <th class="py-4 px-6 w-[16%]">CPF</th>
                <th class="py-4 px-6 w-[28%]">Paciente</th>
                <th class="py-4 px-6 w-[16%]">Horário</th>
                <th class="py-4 px-4 w-[14%] text-center">Status Documentos</th>
                <th class="py-4 px-4 w-[14%] text-center">Status Comparecimento</th>
              </tr>
            </thead>
            <tbody id="agendamentosTable" class="divide-y divide-slate-100 text-sm text-slate-600">

              @forelse($showAgendamentos as $agendamento)
              <tr
                @if((int) $nivelUsuario !== 1)
                onclick="abrirModalAgendamento({{ $agendamento->numero_agendamento ?? $agendamento->id ?? $agendamento->numero_sequencial }})"
                class="hover:bg-slate-50 transition-colors cursor-pointer"
                @endif>
                
                <!-- Nº Agendamento -->
                <td class="py-4 px-6 font-medium text-slate-700">
                  <div class="flex items-center gap-1.5">
                    <span class="font-mono">#{{ $agendamento->numero_agendamento ?? $agendamento->numero_sequencial ?? $agendamento->id }}</span>
                    @if(!empty($agendamento->promovido_da_fila))
                    <span class="text-[9px] px-1.5 py-0.5 rounded-full font-bold bg-purple-100 text-purple-700">
                      Auto
                    </span>
                    @endif
                  </div>
                </td>
                <!-- CPF -->
                <td class="py-4 px-6 font-mono text-xs">{{ $agendamento->cpf_paciente ?? $agendamento->cpf ?? '-' }}</td>

                <!-- Paciente -->
                <td class="py-4 px-6 font-semibold text-slate-700">
                  {{ $agendamento->nome_paciente ?? $agendamento->nome_completo ?? 'Paciente' }}
                </td>

                <!-- Horário -->
                <td class="py-4 px-6 text-xs font-medium">
                  @if(!empty($agendamento->horario_agendamento) || !empty($agendamento->data_atendimento))
                    {{ \Carbon\Carbon::parse($agendamento->horario_agendamento ?? $agendamento->data_atendimento)->format('d/m/Y - H:i') }}
                  @else
                    <span class="text-slate-400 italic">Lista de Espera</span>
                  @endif
                </td>

                <!-- Status Documentos -->
                <td class="py-4 px-4 text-center">
                  @php
                    $statusDoc = strtolower($agendamento->status_documentos ?? $agendamento->status_documento ?? 'pendente');
                  @endphp

                  @if($statusDoc === 'aprovado')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                    Aprovado
                  </span>
                  @elseif($statusDoc === 'validar_no_ato')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700">
                    No Ato
                  </span>
                  @elseif($statusDoc === 'rejeitado')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">
                    Rejeitado
                  </span>
                  @else
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">
                    Pendente
                  </span>
                  @endif
                </td>

                <!-- Status Comparecimento / Agendamento -->
                <td class="py-4 px-4 text-center">
                  @php
                    $statusAgend = strtolower($agendamento->status_comparecimento ?? $agendamento->status_agendamento ?? $agendamento->status ?? 'agendado');
                  @endphp

                  @if($statusAgend === 'presente')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                    Presente
                  </span>
                  @elseif($statusAgend === 'atrasado')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-100 text-orange-800 border border-orange-200">
                    Atrasado
                  </span>
                  @elseif($statusAgend === 'nao_compareceu' || $statusAgend === 'faltou')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                    Não Compareceu
                  </span>
                  @elseif($statusAgend === 'confirmado' || $statusAgend === 'agendado')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">
                    Confirmado
                  </span>
                  @elseif($statusAgend === 'espera' || $statusAgend === 'em_espera')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                    Lista de Espera
                  </span>
                  @elseif($statusAgend === 'aguardando_confirmacao')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">
                    Aguardando 24h
                  </span>
                  @elseif(str_contains($statusAgend, 'cancelado'))
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">
                    Cancelado
                  </span>
                  @else
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                    {{ ucfirst(str_replace('_', ' ', $statusAgend)) }}
                  </span>
                  @endif
                </td>

              </tr>
              @empty
              <tr>
                <td colspan="6" class="py-8 text-center text-slate-500 font-medium">
                  Nenhum agendamento encontrado com os filtros selecionados.
                </td>
              </tr>
              @endforelse

            </tbody>
          </table>
        </div>
      </div>

      <!-- Paginação -->
      @if(isset($showAgendamentos) && method_exists($showAgendamentos, 'links'))
      <div class="pt-2">
        {{ $showAgendamentos->links() }}
      </div>
      @endif

    </main>
  </div>

  <!-- Modal com Visualizador de Documentos Embutido, Comparecimento e Validação -->
  <div id="agendamentoModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[90vh]">
      
      <!-- Topo do Modal -->
      <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between shrink-0">
        <div class="flex items-center gap-2">
          <span id="modalNumero" class="font-mono font-bold text-sky-400">#00</span>
          <h3 id="modalNome" class="font-bold text-white text-base">Paciente</h3>
        </div>
        <button onclick="fecharModal()" class="text-slate-400 hover:text-white p-1 cursor-pointer">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <!-- Corpo do Modal com Scroll -->
      <div class="p-6 space-y-5 text-xs text-slate-600 overflow-y-auto grow">
        
        <!-- Dados Básicos em Grid -->
        <div class="p-4 bg-slate-50 rounded-xl grid grid-cols-2 sm:grid-cols-3 gap-3 border border-slate-100">
          <div>
            <span class="text-slate-400 block text-[10px] uppercase font-bold">CPF</span>
            <strong id="modalCpf" class="text-slate-800">-</strong>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase font-bold">Cartão SUS</span>
            <strong id="modalSus" class="text-slate-800">-</strong>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase font-bold">Procedimento</span>
            <strong id="modalExame" class="text-slate-800">-</strong>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase font-bold">Horário</span>
            <strong id="modalHorario" class="text-slate-800">-</strong>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase font-bold">Status Documentos</span>
            <strong id="modalStatusDoc" class="text-slate-800 font-bold">-</strong>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase font-bold">Status Comparecimento</span>
            <strong id="modalStatusComp" class="text-slate-800 font-bold">-</strong>
          </div>
        </div>

        <!-- VISUALIZADOR DE DOCUMENTOS EMBUTIDO (SEM DOWNLOAD) -->
        <div class="border-t border-slate-100 pt-4 space-y-3">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <label class="font-bold text-slate-700 block text-xs uppercase tracking-wider">
              Documentos Enviados na Etapa 3 (Visualização Direta):
            </label>

            <!-- Abas para alternar os documentos no modal -->
            <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl">
              <button type="button" id="btnAbaRg" onclick="alternarAbaDoc('rg')" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-sky-600 text-white shadow-xs transition-all cursor-pointer">
                1. RG / CPF
              </button>
              <button type="button" id="btnAbaReq" onclick="alternarAbaDoc('req')" class="px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
                2. Requisição Médica
              </button>
            </div>
          </div>

          <!-- Painel do Visualizador 1: RG / CPF (Aba 1) -->
          <div id="painelDocRg" class="bg-slate-50 p-3 rounded-xl border border-slate-200" style="display: block;">
            <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-200">
              <span class="font-semibold text-slate-700 text-xs">Documento de Identificação (RG/CPF)</span>
              <span class="text-[10px] text-slate-400">Visualização da Aba 1</span>
            </div>
            <div id="containerDocRgCpf" class="min-h-[220px] flex items-center justify-center">
              <span class="text-slate-400 italic">Carregando visualizador...</span>
            </div>
          </div>

          <!-- Painel do Visualizador 2: Requisição Médica (Aba 2) -->
          <div id="painelDocReq" class="bg-slate-50 p-3 rounded-xl border border-slate-200" style="display: none;">
            <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-200">
              <span class="font-semibold text-slate-700 text-xs">Requisição Médica / Encaminhamento</span>
              <span class="text-[10px] text-slate-400">Visualização da Aba 2</span>
            </div>
            <div id="containerDocRequisicao" class="min-h-[220px] flex items-center justify-center">
              <span class="text-slate-400 italic">Carregando visualizador...</span>
            </div>
          </div>
        </div>

        <!-- Controle de Comparecimento na Recepção -->
        <div class="border-t border-slate-100 pt-4 space-y-2">
          <label class="font-bold text-slate-700 block">Registrar Comparecimento na Recepção:</label>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
            <button onclick="atualizarComparecimento('presente')" class="py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs transition-all">
              Presente
            </button>
            <button onclick="atualizarComparecimento('atrasado')" class="py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs transition-all">
              Atrasado
            </button>
            <button onclick="atualizarComparecimento('nao_compareceu')" class="py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs transition-all">
              Não Compareceu
            </button>
          </div>
        </div>

        <!-- Validação dos Documentos pelo Operador -->
        <div class="border-t border-slate-100 pt-4 space-y-2">
          <label class="font-bold text-slate-700 block">Validação dos Documentos pelo Operador:</label>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
            <button onclick="validarDoc('aprovado')" class="py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs">
              Aprovar Imediato
            </button>
            <button onclick="validarDoc('validar_no_ato')" class="py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs">
              Validar no Ato
            </button>
            <button onclick="validarDoc('rejeitado')" class="py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs">
              Rejeitar Documento
            </button>
          </div>
          <p class="text-[11px] text-slate-400">
            * Ao aprovar, o paciente é liberado para confirmar a presença no portal dele.
          </p>
        </div>

      </div>

      <!-- Rodapé do Modal -->
      <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="fecharModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs cursor-pointer">
          Fechar
        </button>
      </div>

    </div>
  </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    // Controle da Sidebar Mobile
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const menuClose = document.getElementById('mobile-menu-close');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function setSidebarExpanded(expanded) {
      if (!sidebar) return;
      sidebar.classList.toggle('-translate-x-full', !expanded);
      if (sidebarOverlay) sidebarOverlay.classList.toggle('hidden', !expanded);
      if (menuToggle) menuToggle.setAttribute('aria-expanded', String(expanded));
      if (menuClose) menuClose.setAttribute('aria-expanded', String(expanded));
      if (sidebarOverlay) sidebarOverlay.setAttribute('aria-hidden', String(!expanded));
    }

    if (menuToggle) menuToggle.addEventListener('click', () => setSidebarExpanded(true));
    if (menuClose) menuClose.addEventListener('click', () => setSidebarExpanded(false));
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', () => setSidebarExpanded(false));

    // Funções do Modal de Gestão (Operador / Recepção)
    let agendamentoSelecionadoId = null;

    function alternarAbaDoc(tipo) {
      const painelRg = document.getElementById('painelDocRg');
      const painelReq = document.getElementById('painelDocReq');
      const btnRg = document.getElementById('btnAbaRg');
      const btnReq = document.getElementById('btnAbaReq');

      if (tipo === 'rg') {
        painelRg.style.display = 'block';
        painelReq.style.display = 'none';

        btnRg.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold bg-sky-600 text-white shadow-xs transition-all cursor-pointer';
        btnReq.className = 'px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 transition-all cursor-pointer';
      } else {
        painelRg.style.display = 'none';
        painelReq.style.display = 'block';

        btnReq.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold bg-sky-600 text-white shadow-xs transition-all cursor-pointer';
        btnRg.className = 'px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 transition-all cursor-pointer';
      }
      lucide.createIcons();
    }

    function gerarUrlsTentativas(caminho, tipoDoc, idAgendamento) {
      const urls = [];

      if (!caminho || typeof caminho !== 'string' || caminho.trim() === '') {
        if (idAgendamento) {
          urls.push('/agendamentos/' + idAgendamento + '/documento/' + tipoDoc);
        }
        return urls;
      }

      caminho = caminho.trim();

      // Se já for URL externa ou base64
      if (caminho.startsWith('http://') || caminho.startsWith('https://') || caminho.startsWith('data:')) {
        urls.push(caminho);
        return urls;
      }

      // Extrai apenas o nome do arquivo (ex: foto.jpg)
      const partes = caminho.split('/');
      const nomeArquivo = partes[partes.length - 1];

      // 1. URL pública direta no storage/documentos_agendamentos/
      urls.push('/storage/documentos_agendamentos/' + nomeArquivo);

      // 2. Rota de streaming do controller (lê direto do disco local/public)
      if (idAgendamento) {
        urls.push('/agendamentos/' + idAgendamento + '/documento/' + tipoDoc);
      }

      // 3. Variação com o caminho completo limpo
      let caminhoLimpo = caminho.replace(/^storage\/app\/public\//, '').replace(/^public\//, '').replace(/^storage\//, '').replace(/^\//, '');
      urls.push('/storage/' + caminhoLimpo);

      return [...new Set(urls)];
    }

    function renderizarDocumentoEmbutido(urlBruta, containerId, nomePadrao, tipoDoc, idAgendamento) {
      const container = document.getElementById(containerId);
      const tentativas = gerarUrlsTentativas(urlBruta, tipoDoc, idAgendamento);

      if (!urlBruta || urlBruta.trim() === '' || tentativas.length === 0) {
        container.innerHTML = `
          <div class="text-center py-8 text-slate-400">
            <i data-lucide="file-x" class="w-8 h-8 mx-auto text-slate-300 mb-1"></i>
            <p class="italic text-xs">Nenhum documento anexado para este item.</p>
          </div>
        `;
        lucide.createIcons();
        return;
      }

      const urlInicial = tentativas[0];
      const isPdf = (urlBruta && urlBruta.toLowerCase().includes('.pdf')) || urlInicial.toLowerCase().includes('.pdf');

      if (isPdf) {
        container.innerHTML = `
          <div class="w-full space-y-2">
            <iframe src="${urlInicial}#toolbar=0" class="w-full h-80 rounded-lg border border-slate-200 bg-white" title="${nomePadrao}"></iframe>
            <div class="text-right">
              <a href="${urlInicial}" target="_blank" class="text-[11px] text-sky-600 hover:underline font-semibold">
                Abrir PDF em nova aba &nearr;
              </a>
            </div>
          </div>
        `;
      } else {
        const listaFallbackJson = JSON.stringify(tentativas);

        container.innerHTML = `
          <div class="w-full flex flex-col items-center justify-center p-3 bg-slate-900/5 rounded-xl border border-slate-200 overflow-hidden space-y-2">
            <img 
              id="img_${containerId}"
              src="${urlInicial}" 
              alt="${nomePadrao}" 
              data-tentativas='${listaFallbackJson}'
              data-index="0"
              class="max-h-80 w-auto object-contain rounded-lg shadow-sm bg-white"
              onerror="tentarProximaUrl(this, '${containerId}')"
            />
            <div class="w-full flex justify-between items-center text-[11px] text-slate-500 px-1 pt-1">
              <span class="font-medium text-slate-600">${nomePadrao}</span>
              <a id="link_${containerId}" href="${urlInicial}" target="_blank" class="text-sky-600 hover:text-sky-800 hover:underline font-semibold flex items-center gap-1">
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                Abrir imagem em tela cheia
              </a>
            </div>
          </div>
        `;
      }
      lucide.createIcons();
    }

    // Fallback limpo sem exibir o caminho no texto
    function tentarProximaUrl(imgEl, containerId) {
      try {
        const tentativas = JSON.parse(imgEl.getAttribute('data-tentativas') || '[]');
        let indexAtual = parseInt(imgEl.getAttribute('data-index') || '0', 10);
        
        indexAtual++;
        if (indexAtual < tentativas.length) {
          imgEl.setAttribute('data-index', indexAtual);
          imgEl.src = tentativas[indexAtual];
          
          const linkEl = document.getElementById('link_' + containerId);
          if (linkEl) linkEl.href = tentativas[indexAtual];
        } else {
          // Layout limpo sem mensagem de caminho de arquivo
          imgEl.parentElement.innerHTML = `
            <div class="text-center py-8 text-slate-400">
              <i data-lucide="image-off" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
              <p class="text-xs text-slate-500 font-medium">Documento indisponível no momento.</p>
            </div>
          `;
          lucide.createIcons();
        }
      } catch (e) {
        console.error(e);
      }
    }

    function abrirModalAgendamento(id) {
      const modal = document.getElementById('agendamentoModal');
      if (!modal) return;

      agendamentoSelecionadoId = id;
      document.getElementById('modalNumero').innerText = '#' + id;
      document.getElementById('containerDocRgCpf').innerHTML = '<span class="text-slate-400 italic">Carregando visualizador...</span>';
      document.getElementById('containerDocRequisicao').innerHTML = '<span class="text-slate-400 italic">Carregando visualizador...</span>';
      
      alternarAbaDoc('rg');

      document.getElementById('agendamentoModal').classList.remove('hidden');
      document.getElementById('agendamentoModal').classList.add('flex');

      fetch('/agendamentos/' + id)
        .then(res => res.json())
        .then(data => {
          if (data && data.agendamento) {
            const a = data.agendamento;
            const agendamentoIdReal = a.id_prontuario || a.numero_sequencial || a.id || id;

            document.getElementById('modalNome').innerText = a.nome_paciente || a.nome_completo || 'Paciente';
            document.getElementById('modalCpf').innerText = a.cpf_paciente || a.cpf || '-';
            document.getElementById('modalSus').innerText = a.cartao_sus || 'Não informado';
            document.getElementById('modalExame').innerText = a.nome_vaga || a.tipo_exame || 'Consulta Médica';
            document.getElementById('modalHorario').innerText = a.horario_agendamento || a.data_atendimento || 'Fila de Espera';
            document.getElementById('modalStatusDoc').innerText = (a.status_documentos || a.status_documento || 'Pendente').toUpperCase();
            
            let comp = (a.status_comparecimento || a.status_agendamento || a.status || 'Agendado').toUpperCase();
            if (comp === 'NAO_COMPARECEU') comp = 'NÃO COMPARECEU';
            document.getElementById('modalStatusComp').innerText = comp;

            const docRg = a.url_documento_rg_cpf || a.documento_rg_cpf || a.caminho_documento_rg || a.rg_cpf || a.url_rg || a.foto_rg;
            const docReq = a.url_documento_requisicao || a.documento_requisicao || a.caminho_documento_requisicao || a.requisicao || a.url_requisicao || a.foto_requisicao;

            renderizarDocumentoEmbutido(docRg, 'containerDocRgCpf', 'Documento RG/CPF', 'rg', agendamentoIdReal);
            renderizarDocumentoEmbutido(docReq, 'containerDocRequisicao', 'Requisição Médica', 'requisicao', agendamentoIdReal);
          }
        })
        .catch(() => {
          document.getElementById('modalNome').innerText = 'Agendamento #' + id;
        });
    }

    function fecharModal() {
      const modal = document.getElementById('agendamentoModal');
      if (!modal) return;
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    function atualizarComparecimento(status) {
      if (!agendamentoSelecionadoId) return;

      fetch('/agendamentos/' + agendamentoSelecionadoId + '/status-comparecimento', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status_comparecimento: status })
      })
      .then(res => res.json())
      .then(() => {
        location.reload();
      })
      .catch(err => {
        console.error(err);
        location.reload();
      });
    }

    function validarDoc(status) {
      if (!agendamentoSelecionadoId) return;

      fetch('/agendamentos/' + agendamentoSelecionadoId + '/validar-documento', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status_documentos: status })
      })
      .then(res => res.json())
      .then(() => {
        location.reload();
      })
      .catch(err => {
        console.error(err);
        location.reload();
      });
    }
  </script>

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

  

</body>

</html>