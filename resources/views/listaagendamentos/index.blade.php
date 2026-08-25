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
    <div id="app-root" class="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased">
      
      <!-- Top Bar / Header -->
      <header id="top-bar" class="h-16 bg-white border-b border-slate-100 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 shadow-xs">
        <div class="flex items-center gap-3">
          <div id="breadcrumb" class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <span>Portal Gestão</span>
            <span>/</span>
            <span class="text-slate-600 font-semibold">Lista de Agendamentos</span>
          </div>
        </div>

        <div id="top-bar-actions" class="flex items-center gap-4">
          <button id="notification-button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-lg relative transition-colors cursor-pointer">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
          </button>

          <div id="user-profile" class="flex items-center gap-3 pl-4 border-l border-slate-100">
            <div id="user-avatar" class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-600 text-xs shadow-inner">
              AD
            </div>
            <div id="user-info" class="hidden sm:block text-left">
              <p id="user-name" class="text-xs font-bold text-slate-700">Dr. Marcos Gabriel</p>
              <p id="user-role" class="text-[10px] text-slate-400 font-semibold leading-none mt-0.5">Gestor Geral / Operador</p>
            </div>
          </div>
        </div>
      </header>

      <!-- Conteúdo Principal -->
      <main id="main-content" class="max-w-7xl w-full mx-auto p-6 md:p-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Lista de Agendamentos</h1>
            <p class="text-xs text-slate-500 mt-1">Gestão da fila inteligente, validação de documentos e controle de comparecimento.</p>
          </div>
        </div>

        <!-- Filtros e Busca -->
        <form id="filterForm" method="GET" action="{{ url()->current() }}" class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xs">
          <div class="relative w-full md:w-96 flex items-center">
            <i data-lucide="search" class="absolute left-4 text-slate-400 w-5 h-5 pointer-events-none"></i>
            <input 
              type="text" 
              name="search" 
              id="searchInput" 
              value="{{ request('search') }}" 
              class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-12 pr-4 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition-all" 
              placeholder="Buscar por paciente, CPF ou Nº..."
            >
          </div>

          <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
            <!-- Filtro Status Comparecimento / Agendamento -->
            <select 
              name="status" 
              onchange="this.form.submit()" 
              class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer"
            >
              <option value="">Todos os Status</option>
              <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
              <option value="presente" {{ request('status') == 'presente' ? 'selected' : '' }}>Presente</option>
              <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
              <option value="nao_compareceu" {{ request('status') == 'nao_compareceu' ? 'selected' : '' }}>Não Compareceu</option>
              <option value="aguardando_confirmacao" {{ request('status') == 'aguardando_confirmacao' ? 'selected' : '' }}>Aguardando 24h</option>
              <option value="em_espera" {{ request('status') == 'em_espera' ? 'selected' : '' }}>Em Espera (Fila)</option>
              <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>

            <!-- Filtro Status Documentos -->
            <select 
              name="status_documentos" 
              onchange="this.form.submit()" 
              class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer"
            >
              <option value="">Todos os Status Documentos</option>
              <option value="aprovado" {{ request('status_documentos') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
              <option value="pendente" {{ request('status_documentos') == 'pendente' ? 'selected' : '' }}>Pendente</option>
              <option value="validar_no_ato" {{ request('status_documentos') == 'validar_no_ato' ? 'selected' : '' }}>Validar no Ato</option>
              <option value="rejeitado" {{ request('status_documentos') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
            </select>
          </div>
        </form>

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
                    onclick="abrirModalAgendamento({{ $agendamento->numero_agendamento ?? $agendamento->id ?? $agendamento->numero_sequencial }})" 
                    class="hover:bg-slate-50 transition-colors cursor-pointer"
                  >
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
                    <td class="py-4 px-6 text-xs">
                      @if(!empty($agendamento->horario_agendamento) || !empty($agendamento->data_atendimento))
                        {{ \Carbon\Carbon::parse($agendamento->horario_agendamento ?? $agendamento->data_atendimento)->format('d/m/Y - H:i') }}
                      @else
                        <span class="text-slate-400 italic">Fila de Espera</span>
                      @endif
                    </td>

                    <!-- Status Documentos -->
                    <td class="py-4 px-4 text-center">
                      @php
                        $statusDoc = strtolower($agendamento->status_documentos ?? 'pendente');
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

                    <!-- Status Comparecimento -->
                    <td class="py-4 px-4 text-center">
                      @php
                        $statusAgend = strtolower($agendamento->status_comparecimento ?? $agendamento->status ?? 'agendado');
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
                      @elseif($statusAgend === 'confirmado')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">
                          Confirmado
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

    <!-- Modal com Visualizador de Documentos Embutido, Validação e Comparecimento -->
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

              <!-- Abas para alternar os documentos em tela cheia do modal -->
              <div class="flex items-center gap-1.5">
                <button type="button" id="btnAbaRg" onclick="alternarAbaDoc('rg')" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-sky-600 text-white transition-all cursor-pointer">
                  1. RG / CPF
                </button>
                <button type="button" id="btnAbaReq" onclick="alternarAbaDoc('req')" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all cursor-pointer">
                  2. Requisição Médica
                </button>
              </div>
            </div>

            <!-- Painel do Visualizador 1: RG / CPF -->
            <div id="painelDocRg" class="bg-slate-50 p-3 rounded-xl border border-slate-200">
              <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-200">
                <span class="font-semibold text-slate-700 text-xs">Documento de Identificação (RG/CPF)</span>
                <span class="text-[10px] text-slate-400">Visualização direta</span>
              </div>
              <div id="containerDocRgCpf" class="min-h-[220px] flex items-center justify-center">
                <span class="text-slate-400 italic">Carregando visualizador...</span>
              </div>
            </div>

            <!-- Painel do Visualizador 2: Requisição Médica -->
            <div id="painelDocReq" class="hidden bg-slate-50 p-3 rounded-xl border border-slate-200">
              <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-200">
                <span class="font-semibold text-slate-700 text-xs">Requisição Médica / Encaminhamento</span>
                <span class="text-[10px] text-slate-400">Visualização direta</span>
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

    <!-- Script dos Ícones Lucide e Funções do Modal -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      lucide.createIcons();

      let agendamentoSelecionadoId = null;

      function alternarAbaDoc(tipo) {
        const painelRg = document.getElementById('painelDocRg');
        const painelReq = document.getElementById('painelDocReq');
        const btnRg = document.getElementById('btnAbaRg');
        const btnReq = document.getElementById('btnAbaReq');

        if (tipo === 'rg') {
          painelRg.classList.remove('hidden');
          painelReq.classList.add('hidden');
          btnRg.className = 'px-3 py-1.5 rounded-lg text-xs font-bold bg-sky-600 text-white transition-all cursor-pointer';
          btnReq.className = 'px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all cursor-pointer';
        } else {
          painelReq.classList.remove('hidden');
          painelRg.classList.add('hidden');
          btnReq.className = 'px-3 py-1.5 rounded-lg text-xs font-bold bg-sky-600 text-white transition-all cursor-pointer';
          btnRg.className = 'px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all cursor-pointer';
        }
      }

      function renderizarDocumentoEmbutido(url, containerId, nomePadrao) {
        const container = document.getElementById(containerId);
        if (!url) {
          container.innerHTML = `
            <div class="text-center py-8 text-slate-400">
              <i data-lucide="file-x" class="w-8 h-8 mx-auto text-slate-300 mb-1"></i>
              <p class="italic text-xs">Nenhum documento anexado para este item.</p>
            </div>
          `;
          return;
        }

        const isPdf = url.toLowerCase().includes('.pdf');

        if (isPdf) {
          // Renderiza o PDF embutido diretamente no iframe (sem download)
          container.innerHTML = `
            <div class="w-full">
              <iframe src="${url}#toolbar=0" class="w-full h-80 rounded-lg border border-slate-200 bg-white" title="${nomePadrao}"></iframe>
            </div>
          `;
        } else {
          // Renderiza a imagem embutida com zoom ajustado e fundo neutro
          container.innerHTML = `
            <div class="w-full flex flex-col items-center justify-center p-2 bg-slate-900/5 rounded-lg border border-slate-200 overflow-hidden">
              <img src="${url}" alt="${nomePadrao}" class="max-h-80 w-auto object-contain rounded shadow-sm">
            </div>
          `;
        }
        lucide.createIcons();
      }

      function abrirModalAgendamento(id) {
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
              document.getElementById('modalNome').innerText = a.nome_paciente || a.nome_completo || 'Paciente';
              document.getElementById('modalCpf').innerText = a.cpf_paciente || a.cpf || '-';
              document.getElementById('modalSus').innerText = a.cartao_sus || 'Não informado';
              document.getElementById('modalExame').innerText = a.nome_vaga || a.tipo_exame || 'Consulta Médica';
              document.getElementById('modalHorario').innerText = a.horario_agendamento || a.data_atendimento || 'Fila de Espera';
              document.getElementById('modalStatusDoc').innerText = (a.status_documentos || a.status_documento || 'Pendente').toUpperCase();
              
              let comp = (a.status_comparecimento || a.status || 'Agendado').toUpperCase();
              if (comp === 'NAO_COMPARECEU') comp = 'NÃO COMPARECEU';
              document.getElementById('modalStatusComp').innerText = comp;

              // Renderiza os documentos embutidos no modal
              renderizarDocumentoEmbutido(a.url_documento_rg_cpf, 'containerDocRgCpf', 'Documento RG/CPF');
              renderizarDocumentoEmbutido(a.url_documento_requisicao, 'containerDocRequisicao', 'Requisição Médica');
            }
          })
          .catch(() => {
            document.getElementById('modalNome').innerText = 'Agendamento #' + id;
          });
      }

      function fecharModal() {
        document.getElementById('agendamentoModal').classList.add('hidden');
        document.getElementById('agendamentoModal').classList.remove('flex');
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
  </body>
</html>