<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestão de Cronograma de Vagas - Agenda Saúde</title>

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
            <span class="text-slate-600 font-semibold">Cronograma de Vagas</span>
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
        
        <!-- Título e Ação de Cadastro -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Cronograma de Vagas</h1>
            <p class="text-xs text-slate-500 mt-1">Planejamento e distribuição de datas por município, unidade móvel e turno.</p>
          </div>

          <button onclick="abrirModalCadastro()" class="px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 transition-all shadow-xs cursor-pointer">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            Criar Vagas no Cronograma
          </button>
        </div>

        <!-- Alertas Flash -->
        @if(session('sucesso'))
          <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
            {{ session('sucesso') }}
          </div>
        @endif

        @if(session('erro'))
          <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs font-semibold flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
            {{ session('erro') }}
          </div>
        @endif

        <!-- Filtros e Busca -->
        <form id="filterForm" method="GET" action="{{ route('cronograma.index') }}" class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 flex flex-col lg:flex-row items-center justify-between gap-4 shadow-xs">
          
          <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <!-- Filtro Mês/Ano -->
            <div class="flex items-center gap-2">
              <label class="text-xs font-bold text-slate-500 uppercase">Mês:</label>
              <input 
                type="month" 
                name="mes_ano" 
                value="{{ $mes_ano }}" 
                onchange="this.form.submit()"
                class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 font-semibold focus:outline-none focus:border-sky-500 transition-all cursor-pointer"
              >
            </div>

            <!-- Filtro Unidade -->
            <select 
              name="id_cnes_unidade" 
              onchange="this.form.submit()" 
              class="bg-white border border-slate-200 text-slate-600 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-sky-500 transition-all cursor-pointer font-medium"
            >
              <option value="">Todas as Unidades</option>
              @foreach($unidades as $u)
                <option value="{{ $u->id_cnes_unidade }}" {{ request('id_cnes_unidade') == $u->id_cnes_unidade ? 'selected' : '' }}>
                  {{ $u->nome_unidade }}
                </option>
              @endforeach
            </select>

            <!-- Filtro Tipo de Exame -->
            <select 
              name="id_vagas" 
              onchange="this.form.submit()" 
              class="bg-white border border-slate-200 text-slate-600 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-sky-500 transition-all cursor-pointer font-medium"
            >
              <option value="">Todos os Procedimentos</option>
              @foreach($vagas_tipos as $v)
                <option value="{{ $v->id_vagas }}" {{ request('id_vagas') == $v->id_vagas ? 'selected' : '' }}>
                  {{ $v->tipo_exame }}
                </option>
              @endforeach
            </select>

            <!-- Filtro Turno -->
            <select 
              name="id_turno" 
              onchange="this.form.submit()" 
              class="bg-white border border-slate-200 text-slate-600 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-sky-500 transition-all cursor-pointer font-medium"
            >
              <option value="">Todos os Turnos</option>
              @foreach($turnos as $t)
                <option value="{{ $t->id_turno }}" {{ request('id_turno') == $t->id_turno ? 'selected' : '' }}>
                  {{ $t->turno }}
                </option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition-all cursor-pointer">
            Aplicar Filtros
          </button>
        </form>

        <!-- Tabela Principal de Cronogramas -->
        <div class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                  <th class="py-4 px-6 w-[10%]">ID Agenda</th>
                  <th class="py-4 px-6 w-[15%]">Data</th>
                  <th class="py-4 px-6 w-[20%]">Município</th>
                  <th class="py-4 px-6 w-[22%]">Unidade CNES</th>
                  <th class="py-4 px-6 w-[15%]">Procedimento / Turno</th>
                  <th class="py-4 px-4 w-[18%] text-center">Ocupação das Vagas</th>
                  <th class="py-4 px-4 w-[10%] text-center">Ações</th>
                </tr>
              </thead>
              <tbody id="cronogramasTable" class="divide-y divide-slate-100 text-sm text-slate-600">
                
                @forelse($cronogramas as $c)
                  @php
                    $ofertadas = $c->qnt_oferecidas_vagas;
                    $preenchidas = $c->prenchida_vagas;
                    $percentual = $ofertadas > 0 ? min(100, round(($preenchidas / $ofertadas) * 100)) : 0;
                    $livres = max(0, $ofertadas - $preenchidas);
                  @endphp
                  <tr class="hover:bg-slate-50 transition-colors">
                    
                    <!-- ID Agenda -->
                    <td class="py-4 px-6 font-medium text-slate-700">
                      <span class="font-mono">#{{ $c->id_agenda }}</span>
                    </td>

                    <!-- Data Atendimento -->
                    <td class="py-4 px-6 text-xs text-slate-700 font-semibold">
                      {{ \Carbon\Carbon::parse($c->data_atendimento)->format('d/m/Y') }}
                    </td>

                    <!-- Município -->
                    <td class="py-4 px-6 font-semibold text-slate-800">
                      {{ $c->municipio_atendimento }}
                    </td>

                    <!-- Unidade CNES -->
                    <td class="py-4 px-6">
                      <div class="font-semibold text-slate-700 text-xs">{{ $c->unidade->nome_unidade ?? 'Unidade' }}</div>
                      <div class="text-[11px] text-slate-400 font-mono">CNES: {{ $c->unidade->codigo_cnes ?? 'N/I' }}</div>
                    </td>

                    <!-- Procedimento & Turno -->
                    <td class="py-4 px-6 text-xs">
                      <div class="font-bold text-slate-800">{{ $c->vaga->tipo_exame ?? 'Exame' }}</div>
                      <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                        {{ strtoupper($c->turno->turno ?? 'Integral') }}
                      </span>
                    </td>

                    <!-- Barra de Ocupação -->
                    <td class="py-4 px-4">
                      <div class="space-y-1">
                        <div class="flex justify-between text-[11px] font-semibold">
                          <span class="text-slate-700">{{ $preenchidas }} / {{ $ofertadas }} vagas</span>
                          <span class="{{ $percentual >= 100 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $percentual }}%</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                          <div 
                            class="h-full {{ $percentual >= 100 ? 'bg-rose-500' : ($percentual > 75 ? 'bg-amber-500' : 'bg-emerald-500') }} transition-all" 
                            style="width: {{ $percentual }}%;"
                          ></div>
                        </div>
                        <div class="text-[10px] text-slate-400 text-right">
                          {{ $livres }} {{ $livres == 1 ? 'vaga restante' : 'vagas restantes' }}
                        </div>
                      </div>
                    </td>

                    <!-- Ações -->
                    <td class="py-4 px-4 text-center">
                      <div class="flex items-center justify-center gap-1.5">
                        <button 
                          onclick="abrirModalEdicao({{ json_encode($c) }})" 
                          title="Editar"
                          class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors cursor-pointer"
                        >
                          <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>

                        <form 
                          action="{{ route('cronograma.destroy', $c->id_agenda) }}" 
                          method="POST" 
                          onsubmit="return confirm('Deseja realmente excluir este cronograma?');"
                          class="inline"
                        >
                          @csrf
                          @method('DELETE')
                          <button 
                            type="submit" 
                            title="Excluir"
                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                          >
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="py-8 text-center text-slate-500 font-medium">
                      Nenhum cronograma encontrado para o período selecionado.
                    </td>
                  </tr>
                @endforelse

              </tbody>
            </table>
          </div>
        </div>

      </main>
    </div>

    <!-- Modal de Cadastro / Edição -->
    <div id="cronogramaModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4">
      <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
        
        <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
          <div class="flex items-center gap-2">
            <i data-lucide="calendar" class="w-5 h-5 text-sky-400"></i>
            <h3 id="modalTitulo" class="font-bold text-white text-base">Novo Cronograma</h3>
          </div>
          <button onclick="fecharModal()" class="text-slate-400 hover:text-white p-1 cursor-pointer">
            <i data-lucide="x" class="w-5 h-5"></i>
          </button>
        </div>

        <form id="cronogramaForm" method="POST" action="{{ route('cronograma.store') }}">
          @csrf
          <input type="hidden" name="_method" id="formMethod" value="POST">

          <div class="p-6 space-y-4 text-xs text-slate-600 max-h-[75vh] overflow-y-auto">
            
            <!-- Município de Atendimento -->
            <div class="space-y-1">
              <label class="font-bold text-slate-700 block">Município / Localidade *</label>
              <input 
                type="text" 
                name="municipio_atendimento" 
                id="inputMunicipio" 
                required 
                placeholder="Ex: Duque de Caxias, Niterói..." 
                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-700 focus:outline-none focus:border-sky-500 focus:bg-white transition-all"
              >
            </div>

            <!-- Unidade CNES -->
            <div class="space-y-1">
              <label class="font-bold text-slate-700 block">Unidade CNES (Unidade Móvel / Fixa) *</label>
              <select 
                name="id_cnes_unidade" 
                id="selectUnidade" 
                required 
                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-700 focus:outline-none focus:border-sky-500 focus:bg-white transition-all cursor-pointer"
              >
                <option value="">Selecione a Unidade</option>
                @foreach($unidades as $u)
                  <option value="{{ $u->id_cnes_unidade }}">{{ $u->nome_unidade }} (CNES: {{ $u->codigo_cnes ?? 'N/I' }})</option>
                @endforeach
              </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <!-- Procedimento / Exame -->
              <div class="space-y-1">
                <label class="font-bold text-slate-700 block">Procedimento / Exame *</label>
                <select 
                  name="Vagas_id_vagas" 
                  id="selectVaga" 
                  required 
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-700 focus:outline-none focus:border-sky-500 focus:bg-white transition-all cursor-pointer"
                >
                  <option value="">Selecione o Exame</option>
                  @foreach($vagas_tipos as $v)
                    <option value="{{ $v->id_vagas }}">{{ $v->tipo_exame }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Turno -->
              <div class="space-y-1">
                <label class="font-bold text-slate-700 block">Turno de Atendimento *</label>
                <select 
                  name="Turno_id_turno" 
                  id="selectTurno" 
                  required 
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-700 focus:outline-none focus:border-sky-500 focus:bg-white transition-all cursor-pointer"
                >
                  <option value="">Selecione o Turno</option>
                  @foreach($turnos as $t)
                    <option value="{{ $t->id_turno }}">{{ $t->turno }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Datas (Com suporte a Lote) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div class="space-y-1">
                <label class="font-bold text-slate-700 block">Data de Início *</label>
                <input 
                  type="date" 
                  name="data_atendimento" 
                  id="inputDataInicio" 
                  required 
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-700 focus:outline-none focus:border-sky-500 focus:bg-white transition-all"
                >
              </div>

              <div id="blocoDataFim" class="space-y-1">
                <label class="font-bold text-slate-700 block">Data Final (Criação em Lote)</label>
                <input 
                  type="date" 
                  name="data_fim_lote" 
                  id="inputDataFim" 
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-700 focus:outline-none focus:border-sky-500 focus:bg-white transition-all"
                >
              </div>
            </div>

            <!-- Opção de Replicar Dias Úteis -->
            <div id="blocoDiasUteis" class="flex items-center gap-2 pt-1">
              <input type="checkbox" name="replicar_dias_uteis" id="checkUteis" value="1" class="rounded text-sky-600 focus:ring-sky-500 h-4 w-4 cursor-pointer">
              <label for="checkUteis" class="text-xs text-slate-600 font-medium cursor-pointer">Replicar apenas em dias úteis (Segunda a Sexta)</label>
            </div>

            <!-- Quantidade de Vagas -->
            <div class="space-y-1">
              <label class="font-bold text-slate-700 block">Quantidade de Vagas Ofertadas (por dia) *</label>
              <input 
                type="number" 
                name="qnt_oferecidas_vagas" 
                id="inputVagas" 
                required 
                min="1" 
                max="500" 
                placeholder="Ex: 50" 
                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-700 focus:outline-none focus:border-sky-500 focus:bg-white transition-all"
              >
            </div>

          </div>

          <!-- Botões de Ação -->
          <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
            <button type="button" onclick="fecharModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs cursor-pointer">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs transition-all">
              Salvar Cronograma
            </button>
          </div>
        </form>

      </div>
    </div>

    <!-- Script Lucide e Funções do Modal -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      lucide.createIcons();

      const modal = document.getElementById('cronogramaModal');
      const form = document.getElementById('cronogramaForm');
      const modalTitulo = document.getElementById('modalTitulo');
      const formMethod = document.getElementById('formMethod');
      const blocoDataFim = document.getElementById('blocoDataFim');
      const blocoDiasUteis = document.getElementById('blocoDiasUteis');

      function abrirModalCadastro() {
        form.reset();
        form.action = "{{ route('cronograma.store') }}";
        formMethod.value = "POST";
        modalTitulo.innerText = "Criar Vagas no Cronograma";
        blocoDataFim.style.display = "block";
        blocoDiasUteis.style.display = "flex";
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function abrirModalEdicao(cronograma) {
        form.reset();
        form.action = "/cronograma/" + cronograma.id_agenda;
        formMethod.value = "PUT";
        modalTitulo.innerText = "Editar Cronograma #" + cronograma.id_agenda;
        
        blocoDataFim.style.display = "none";
        blocoDiasUteis.style.display = "none";

        document.getElementById('inputMunicipio').value = cronograma.municipio_atendimento || '';
        document.getElementById('selectUnidade').value = cronograma.id_cnes_unidade || '';
        document.getElementById('selectVaga').value = cronograma.Vagas_id_vagas || '';
        document.getElementById('selectTurno').value = cronograma.Turno_id_turno || '';
        document.getElementById('inputDataInicio').value = cronograma.data_atendimento ? cronograma.data_atendimento.split('T')[0] : '';
        document.getElementById('inputVagas').value = cronograma.qnt_oferecidas_vagas || '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function fecharModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }
    </script>
  </body>
</html>