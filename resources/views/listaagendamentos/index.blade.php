<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lista de Agendamentos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="./js/auth.js"></script>
    <script>validarAcesso(3);</script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
              mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
            },
            spacing: {
              '4.5': '1.125rem',
            }
          }
        }
      }
    </script>
  </head>
  <body class="bg-[#f8fafc]">
  <div id="app-root" class="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased">
      @include('components.sidebar')

      <main id="main-content" class="min-h-screen flex flex-col p-6 md:p-8">
        <header id="top-bar" class="h-16 bg-white border-b border-slate-100 px-4 md:px-6 flex items-center justify-between sticky top-0 z-20 shadow-sm rounded-xl mb-6">
          <div class="flex items-center gap-3">
            <button id="mobile-menu-toggle" class="p-2 -ml-2 text-slate-500 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-colors cursor-pointer">
              <i data-lucide="menu" class="w-5 h-5"></i>
            </button>

            <div id="breadcrumb" class="flex items-center gap-2 text-xs text-slate-400 font-medium">
              <span>Portal Gestão</span>
              <span>/</span>
              <span class="text-slate-600 font-semibold">Lista de Agendamentos</span>
            </div>
          </div>

          <div id="top-bar-actions" class="flex items-center gap-4">
            <button id="notification-button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-lg relative transition-colors cursor-pointer">
              <i data-lucide="bell" class="w-5 h-5"></i>
              <span id="notification-indicator" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
            </button>

            <div id="user-profile" class="flex items-center gap-3 pl-4 border-l border-slate-100">
              <div id="user-avatar" class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-600 text-xs shadow-inner">
                AD
              </div>
              <div id="user-info" class="hidden sm:block text-left">
                <p id="user-name" class="text-xs font-bold text-slate-700">Dr. Marcos G.</p>
                <p id="user-role" class="text-[10px] text-slate-400 font-semibold leading-none mt-0.5">Gestor Geral</p>
              </div>
            </div>
          </div>
        </header>

        <div class="max-w-7xl w-full mx-auto space-y-6">
          <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Agendamentos</h1>

          <!-- Barra de Pesquisa e Filtros Integrados -->
          <form id="filterForm" method="GET" action="{{ route('agendamentos.index') }}" class="bg-white rounded-xl border border-slate-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
            <div class="relative w-full md:w-96 flex items-center">
              <i data-lucide="search" class="absolute left-4 text-slate-400 w-5 h-5 pointer-events-none"></i>
              <input 
                type="text" 
                name="search" 
                id="searchInput" 
                value="{{ request('search') }}" 
                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-12 pr-4 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition-all" 
                placeholder="Buscar por paciente, CPF ou Nº..."
                onkeyup="if(event.key === 'Enter') this.form.submit()"
              >
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
              <!-- Select de Status de Agendamento -->
              <select 
                name="status" 
                onchange="this.form.submit()" 
                class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer"
              >
                <option value="">Todos os Status</option>
                <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="aguardando_confirmacao" {{ request('status') == 'aguardando_confirmacao' ? 'selected' : '' }}>Aguardando 24h</option>
                <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
              </select>

              <!-- Select de Status de Validação dos Documentos -->
              <select 
                name="status_documentos" 
                onchange="this.form.submit()" 
                class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer"
              >
                <option value="">Status dos Documentos</option>
                <option value="pendente" {{ request('status_documentos') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="aprovado" {{ request('status_documentos') == 'aprovado' ? 'selected' : '' }}>Aprovado Operador</option>
                <option value="validar_no_ato" {{ request('status_documentos') == 'validar_no_ato' ? 'selected' : '' }}>Validar no Ato</option>
                <option value="rejeitado" {{ request('status_documentos') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
              </select>
            </div>
          </form>

          <!-- Tabela de Agendamentos (Renderizada via Blade) -->
          <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                  <th class="py-4 px-6 w-[15%]">Nº Agendamento</th>
                  <th class="py-4 px-6 w-[20%]">CPF</th>
                  <th class="py-4 px-6 w-[35%]">Paciente</th>
                  <th class="py-4 px-6 w-[15%]">Horário</th>
                  <th class="py-4 px-6 w-[15%] text-center">Status</th>
                </tr>
              </thead>
              <tbody id="agendamentosTable" class="divide-y divide-slate-100 text-sm text-slate-600">
                
                @forelse($showAgendamentos as $agendamento)
                  <tr 
                    onclick="abrirModalAgendamento({{ $agendamento->numero_agendamento ?? $agendamento->id }})" 
                    class="hover:bg-slate-50 transition-colors cursor-pointer"
                  >
                    <td class="py-4 px-6 font-medium text-slate-700">#{{ $agendamento->numero_agendamento }}</td>
                    <td class="py-4 px-6">{{ $agendamento->cpf_paciente }}</td>
                    <td class="py-4 px-6 font-semibold text-slate-700">{{ $agendamento->nome_paciente }}</td>
                    <td class="py-4 px-6">
                      {{ \Carbon\Carbon::parse($agendamento->horario_agendamento)->format('d/m/Y - H:i') }}
                    </td>
                    <td class="py-4 px-6 text-center">
                      @if(strtolower($agendamento->status) === 'confirmado')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">Confirmado</span>
                      @elseif(strtolower($agendamento->status) === 'pendente' || strtolower($agendamento->status) === 'aguardando_confirmacao' || strtolower($agendamento->status) === 'aguardando_validacao')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">Pendente</span>
                      @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Cancelado</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="py-8 text-center text-slate-500 font-medium">Nenhum agendamento encontrado.</td>
                  </tr>
                @endforelse

              </tbody>
            </table>
          </div>

          <!-- Paginação -->
          <div class="flex items-center justify-between text-sm text-slate-500 pt-2">
            <div id="paginationInfo">
              @if(method_exists($showAgendamentos, 'total'))
                Mostrando {{ $showAgendamentos->firstItem() ?? 0 }} a {{ $showAgendamentos->lastItem() ?? 0 }} de {{ $showAgendamentos->total() }} agendamentos
              @else
                Mostrando todos os agendamentos
              @endif
            </div>
            <div class="flex items-center gap-2">
              @if(method_exists($showAgendamentos, 'previousPageUrl'))
                <a href="{{ $showAgendamentos->previousPageUrl() }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-600 transition-all cursor-pointer {{ $showAgendamentos->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">
                  <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
                <a href="{{ $showAgendamentos->nextPageUrl() }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-600 transition-all cursor-pointer {{ !$showAgendamentos->hasMorePages() ? 'opacity-40 pointer-events-none' : '' }}">
                  <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
              @else
                <button class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-600 transition-all cursor-pointer" onclick="mudarPagina('prev')">
                  <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-600 transition-all cursor-pointer" onclick="mudarPagina('next')">
                  <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
              @endif
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Modal com Validação dos Documentos pelo Operador -->
    <div id="agendamentoModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4">
      <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span id="modalNumero" class="font-mono font-bold text-sky-400">#00</span>
            <h3 id="modalNome" class="font-bold text-white text-base">Paciente</h3>
          </div>
          <button onclick="fecharModal()" class="text-slate-400 hover:text-white p-1 cursor-pointer">
            <i data-lucide="x" class="w-5 h-5"></i>
          </button>
        </div>

        <div class="p-6 space-y-4 text-xs text-slate-600 max-h-[75vh] overflow-y-auto">
          <div class="p-4 bg-slate-50 rounded-xl space-y-2 border border-slate-100">
            <p><strong>CPF:</strong> <span id="modalCpf">-</span></p>
            <p><strong>Cartão SUS:</strong> <span id="modalSus">-</span></p>
            <p><strong>Procedimento:</strong> <span id="modalExame">-</span></p>
            <p><strong>Data/Horário:</strong> <span id="modalHorario">-</span></p>
            <p><strong>Status Documentos:</strong> <span id="modalStatusDoc" class="font-bold text-slate-800">-</span></p>
          </div>

          <div class="border-t border-slate-100 pt-4 space-y-2">
            <label class="font-bold text-slate-700 block">Validação dos Documentos pelo Operador:</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
              <button onclick="validarDoc('aprovado')" class="py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-xs cursor-pointer">
                Aprovar Imediato
              </button>
              <button onclick="validarDoc('validar_no_ato')" class="py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs cursor-pointer">
                Validar no Ato
              </button>
              <button onclick="validarDoc('rejeitado')" class="py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs cursor-pointer">
                Rejeitar Documento
              </button>
            </div>
            <p class="text-[11px] text-slate-400">
              * Ao validar, o paciente recebe a liberação na tela dele para confirmar a presença.
            </p>
          </div>
        </div>

        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex justify-end">
          <button onclick="fecharModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs cursor-pointer">
            Fechar
          </button>
        </div>
      </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      lucide.createIcons();

      let agendamentoSelecionadoId = null;

      function abrirModalAgendamento(id) {
        agendamentoSelecionadoId = id;
        document.getElementById('modalNumero').innerText = '#' + id;
        document.getElementById('agendamentoModal').classList.remove('hidden');
        document.getElementById('agendamentoModal').classList.add('flex');

        fetch('/agendamentos/' + id)
          .then(res => res.json())
          .then(data => {
            if(data.agendamento) {
              document.getElementById('modalNome').innerText = data.agendamento.nome_paciente || data.agendamento.nome_completo;
              document.getElementById('modalCpf').innerText = data.agendamento.cpf_paciente || data.agendamento.cpf;
              document.getElementById('modalSus').innerText = data.agendamento.cartao_sus || 'Não informado';
              document.getElementById('modalExame').innerText = data.agendamento.tipo_exame || 'Consulta/Exame';
              document.getElementById('modalHorario').innerText = data.agendamento.horario_agendamento;
              document.getElementById('modalStatusDoc').innerText = (data.agendamento.status_documentos || 'Pendente').toUpperCase();
            }
          });
      }

      function fecharModal() {
        document.getElementById('agendamentoModal').classList.add('hidden');
        document.getElementById('agendamentoModal').classList.remove('flex');
      }

      function validarDoc(status) {
        if(!agendamentoSelecionadoId) return;

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
        });
      }
    </script>
  </body>
</html>