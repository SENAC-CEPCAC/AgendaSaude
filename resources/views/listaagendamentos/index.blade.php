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

  @if ($nivelUsuario === 4)
  @include('sidebar.sidebar_n4')
<button id="mobile-menu-toggle" type="button" class="fixed left-3 top-3 z-[60] flex items-center justify-center rounded-lg bg-blue-600 p-2 text-white shadow-sm transition hover:bg-blue-800 sm:left-5 sm:top-5" aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menu">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="menu" aria-hidden="true" class="lucide lucide-menu h-4 w-4"><path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path></svg>
    </button>
  @endif

  <div id="app-root" class="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased">

    <!-- Top Bar / Header -->
    <header id="top-bar" class="h-16 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 shadow-xs">
      <div class="flex items-center gap-3"></div>

    </header>

    <!-- Conteúdo Principal -->
    <main id="main-content" class="max-w-7xl w-full mx-auto p-6 md:p-8 space-y-6">

      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Agendamentos</h1>
          <p class="text-xs text-slate-500 mt-1">Gestão da fila inteligente, validação de documentos e controle de 24h.</p>
        </div>
        @if ($nivelUsuario !==3)
        <div>
          <a href="{{ route('agendamento.etapa1') }}" target="_blank" class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-all">
            Novo Agendamento
          </a>
        </div>
        @endif
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
            placeholder="Buscar por paciente, CPF ou Nº...">
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">

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

          <!-- Filtro Status Agendamento -->
          <select
            name="status"
            onchange="this.form.submit()"
            class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer">
            <option value="">Todos os Status Agendamento</option>
            <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
            <option value="aguardando_confirmacao" {{ request('status') == 'aguardando_confirmacao' ? 'selected' : '' }}>Aguardando 24h</option>
            <option value="presente" {{ request('status') == 'presente' ? 'selected' : '' }}>Presente</option>
            <option value="em_espera" {{ request('status') == 'espera' ? 'selected' : '' }}>Espera</option>
            <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
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
                @if($nivelUsuario !==1)
                <th class="py-4 px-4 w-[14%] text-center">Status Documentos</th>
                <th class="py-4 px-4 w-[14%] text-center">Status Agendamento</th>
                @endif
              </tr>
            </thead>
            <tbody id="agendamentosTable" class="divide-y divide-slate-100 text-sm text-slate-600">

              @forelse($showAgendamentos as $agendamento)
              <tr
                onclick="abrirModalAgendamento({{ $agendamento->numero_agendamento ?? $agendamento->id ?? $agendamento->numero_sequencial }})"
                class="hover:bg-slate-50 transition-colors cursor-pointer">
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
                @if($nivelUsuario !==1)

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

                <!-- Status Agendamento -->
                <td class="py-4 px-4 text-center">
                  @php
                  $statusAgend = strtolower($agendamento->status_agendamento ?? $agendamento->status ?? 'em_espera');
                  @endphp

                  @if($statusAgend === 'confirmado')
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
                @endif
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

  <!-- Modal com Validação dos Documentos pelo Operador -->
  <div id="agendamentoModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
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
          <p><strong>Procedimento/Vaga:</strong> <span id="modalExame">-</span></p>
          <p><strong>Horário de Atendimento:</strong> <span id="modalHorario">-</span></p>
          <p><strong>Status Documentos Atual:</strong> <span id="modalStatusDoc" class="font-bold text-slate-800">-</span></p>
        </div>

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

      <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex justify-end">
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

    function abrirModalAgendamento(id) {
      agendamentoSelecionadoId = id;
      document.getElementById('modalNumero').innerText = '#' + id;
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
            document.getElementById('modalStatusDoc').innerText = (a.status_documentos || 'Pendente').toUpperCase();
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

    function validarDoc(status) {
      if (!agendamentoSelecionadoId) return;

      fetch('/agendamentos/' + agendamentoSelecionadoId + '/validar-documento', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            status_documentos: status
          })
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

  @if ($nivelUsuario === 4)
  <script>
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const menuClose = document.getElementById('mobile-menu-close');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function setSidebarExpanded(expanded) {
      sidebar.classList.toggle('-translate-x-full', !expanded);
      sidebarOverlay.classList.toggle('hidden', !expanded);
      menuToggle.setAttribute('aria-expanded', String(expanded));
      menuClose.setAttribute('aria-expanded', String(expanded));
      sidebarOverlay.setAttribute('aria-hidden', String(!expanded));
    }

    menuToggle.addEventListener('click', () => setSidebarExpanded(true));
    menuClose.addEventListener('click', () => setSidebarExpanded(false));
    sidebarOverlay.addEventListener('click', () => setSidebarExpanded(false));
  </script>
  @endif

</body>

</html>