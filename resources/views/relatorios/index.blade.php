<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relatórios Gerenciais e Clínicos - Agenda Saúde</title>

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
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body class="bg-[#f8fafc]">
    <div id="app-root" class="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased" x-data="{ 
        macroArea: '{{ $area ?? 'cronograma' }}',
        subAbaAtendimento: '{{ $tipoAtendimento ?? 'atendidos' }}',
        busca: '{{ $busca ?? '' }}',
        dataInicio: '{{ $dataInicio ?? '' }}',
        dataFim: '{{ $dataFim ?? '' }}',
        modalAberto: false,
        anamneseSelecionada: null,
        gerarUrlDownload() {
          const params = new URLSearchParams();
          if (this.busca) params.append('search', this.busca);
          if (this.dataInicio) params.append('data_inicio', this.dataInicio);
          if (this.dataFim) params.append('data_fim', this.dataFim);
          const tipoExport = this.macroArea === 'cronograma' ? 'cronograma' : this.subAbaAtendimento;
          return '{{ url('/relatorios/exportar') }}/' + tipoExport + '?' + params.toString();
        }
    }">
      
      <!-- Top Bar / Header
      <header id="top-bar" class="h-16 bg-white border-b border-slate-100 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 shadow-xs">
        <div class="flex items-center gap-3">
          <div id="breadcrumb" class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <span>Portal Gestão</span>
            <span>/</span>
            <span class="text-slate-600 font-semibold">Relatórios Gerenciais</span>
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
      </header> -->

  <button id="mobile-menu-toggle" type="button" class="fixed left-3 top-3 z-[60] flex items-center justify-center rounded-lg bg-blue-600 p-2 text-white shadow-sm transition hover:bg-blue-800 sm:left-5 sm:top-5" aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menu">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="menu" aria-hidden="true" class="lucide lucide-menu h-4 w-4">
      <path d="M4 5h16"></path>
      <path d="M4 12h16"></path>
      <path d="M4 19h16"></path>
    </svg>
  </button>

      <!-- Conteúdo Principal -->
      <main id="main-content" class="max-w-7xl w-full mx-auto p-6 md:p-8 space-y-6">
        @include('sidebar.sidebar_n4')
        <!-- Cabeçalho e Ações -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1">Visão consolidada dividida em <strong>Área de Cronograma</strong> e <strong>Área de Atendimentos</strong>.</p>
          </div>

          <div class="flex flex-wrap items-center gap-2">
            <!-- Botão de Impressão de Anamneses -->
            <template x-if="macroArea === 'atendimentos' && subAbaAtendimento === 'anamneses'">
              <a href="{{ route('relatorios.anamneses.imprimir-todas', request()->all()) }}" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                Imprimir Todas Anamneses (PDF)
              </a>
            </template>

            <!-- Exportar CSV Dinâmico -->
            <a :href="gerarUrlDownload()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs">
              <i data-lucide="download" class="w-4 h-4"></i>
              <span>Exportar CSV (<span x-text="macroArea === 'cronograma' ? 'CRONOGRAMA' : subAbaAtendimento.toUpperCase().replace('_', ' ')"></span>)</span>
            </a>

            <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs cursor-pointer">
              <i data-lucide="printer" class="w-4 h-4"></i>
              Imprimir
            </button>
          </div>
        </div>

        <!-- SELETOR DAS 2 MACRO-ÁREAS (CRONOGRAMA vs ATENDIMENTOS) -->
        <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-xs flex gap-2">
          <button 
            @click="macroArea = 'cronograma'" 
            :class="macroArea === 'cronograma' ? 'bg-sky-600 text-white font-bold shadow-xs' : 'bg-transparent text-slate-600 hover:bg-slate-50 font-medium'"
            class="flex-1 py-3 px-4 rounded-xl text-xs md:text-sm flex items-center justify-center gap-2 transition-all cursor-pointer"
          >
            <i data-lucide="calendar" class="w-4 h-4"></i>
            <span>ÁREA 1: RELATÓRIO DE CRONOGRAMA & CAPACIDADE</span>
          </button>

          <button 
            @click="macroArea = 'atendimentos'" 
            :class="macroArea === 'atendimentos' ? 'bg-sky-600 text-white font-bold shadow-xs' : 'bg-transparent text-slate-600 hover:bg-slate-50 font-medium'"
            class="flex-1 py-3 px-4 rounded-xl text-xs md:text-sm flex items-center justify-center gap-2 transition-all cursor-pointer"
          >
            <i data-lucide="users" class="w-4 h-4"></i>
            <span>ÁREA 2: RELATÓRIO DE ATENDIMENTOS & CLÍNICA</span>
          </button>
        </div>

        <!-- ======================================================= -->
        <!-- MACRO-ÁREA 1: CRONOGRAMA & CAPACIDADE DE VAGAS           -->
        <!-- ======================================================= -->
        <div x-show="macroArea === 'cronograma'" class="space-y-6">
          
          <!-- 4 Cards de Vagas e Ocupação do Cronograma -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Vagas Ofertadas</span>
                <span class="p-2 bg-sky-100 text-sky-700 rounded-lg">
                  <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['vagas_ofertadas'] ?? 0 }}</span>
                <span class="text-xs text-sky-600 font-bold">Capacidade</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Em {{ $totais['total_agendas'] ?? 0 }} agendas programadas</p>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Vagas Preenchidas</span>
                <span class="p-2 bg-indigo-100 text-indigo-700 rounded-lg">
                  <i data-lucide="user-check" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['vagas_preenchidas'] ?? 0 }}</span>
                <span class="text-xs text-indigo-600 font-bold">Agendados</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Horários reservados</p>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Vagas Livres</span>
                <span class="p-2 bg-emerald-100 text-emerald-700 rounded-lg">
                  <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['vagas_livres'] ?? 0 }}</span>
                <span class="text-xs text-emerald-600 font-bold">Disponíveis</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Restantes para agendamento</p>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Taxa de Ocupação</span>
                <span class="p-2 bg-amber-100 text-amber-700 rounded-lg">
                  <i data-lucide="pie-chart" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['taxa_ocupacao'] ?? 0 }}%</span>
                <span class="text-xs text-amber-700 font-bold">Média</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Aproveitamento das cotas</p>
            </div>
          </div>

          <!-- Filtro da Área de Cronograma -->
          <form method="GET" action="{{ route('relatorios.index') }}" class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xs">
            <input type="hidden" name="area" value="cronograma">

            <div class="relative w-full md:w-96 flex items-center">
              <i data-lucide="search" class="absolute left-4 text-slate-400 w-5 h-5 pointer-events-none"></i>
              <input 
                type="text" 
                name="search" 
                value="{{ $busca ?? '' }}" 
                placeholder="Buscar por município, unidade ou procedimento..." 
                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-12 pr-4 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition-all"
              >
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
              <span class="text-xs text-slate-400 font-medium">Período:</span>
              <input type="date" name="data_inicio" value="{{ $dataInicio ?? '' }}" class="bg-white border border-slate-200 text-slate-600 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-sky-500 transition-all">
              <span class="text-xs text-slate-400">até</span>
              <input type="date" name="data_fim" value="{{ $dataFim ?? '' }}" class="bg-white border border-slate-200 text-slate-600 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-sky-500 transition-all">
              
              <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition-all cursor-pointer">
                Filtrar Cronogramas
              </button>
            </div>
          </form>

          <!-- Tabela de Cronogramas -->
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
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                  @forelse($cronogramas as $c)
                    @php
                      $ofertadas = $c->qnt_oferecidas_vagas;
                      $preenchidas = $c->prenchida_vagas;
                      $percentual = $ofertadas > 0 ? min(100, round(($preenchidas / $ofertadas) * 100)) : 0;
                      $livres = max(0, $ofertadas - $preenchidas);
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                      <td class="py-4 px-6 font-mono font-medium text-slate-700">#{{ $c->id_agenda }}</td>
                      <td class="py-4 px-6 text-xs text-slate-700 font-semibold">{{ \Carbon\Carbon::parse($c->data_atendimento)->format('d/m/Y') }}</td>
                      <td class="py-4 px-6 font-semibold text-slate-800">{{ $c->municipio_atendimento }}</td>
                      <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700 text-xs">{{ $c->nome_unidade }}</div>
                        <div class="text-[11px] text-slate-400 font-mono">CNES: {{ $c->codigo_cnes ?? 'N/I' }}</div>
                      </td>
                      <td class="py-4 px-6 text-xs">
                        <div class="font-bold text-slate-800">{{ $c->tipo_exame }}</div>
                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                          {{ strtoupper($c->turno) }}
                        </span>
                      </td>
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
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Nenhum cronograma encontrado para o período selecionado.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if(method_exists($cronogramas, 'links'))
              <div class="p-4 border-t border-slate-100">{{ $cronogramas->appends(['area' => 'cronograma'])->links() }}</div>
            @endif
          </div>

        </div>


        <!-- ======================================================= -->
        <!-- MACRO-ÁREA 2: ATENDIMENTOS & CLÍNICA                     -->
        <!-- ======================================================= -->
        <div x-show="macroArea === 'atendimentos'" class="space-y-6" style="display: none;">
          
          <!-- 4 Cards de Totais por Sub-área -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div @click="subAbaAtendimento = 'atendidos'" :class="subAbaAtendimento === 'atendidos' ? 'bg-sky-50/60 border-sky-300 ring-2 ring-sky-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pacientes Atendidos</span>
                <span class="p-2 bg-sky-100 text-sky-700 rounded-lg">
                  <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['atendidos'] ?? 0 }}</span>
                <span class="text-xs text-emerald-600 font-bold">Presente</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Status confirmado / presente</p>
            </div>

            <div @click="subAbaAtendimento = 'anamneses'" :class="subAbaAtendimento === 'anamneses' ? 'bg-indigo-50/60 border-indigo-300 ring-2 ring-indigo-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Questionários Clínicos</span>
                <span class="p-2 bg-indigo-100 text-indigo-700 rounded-lg">
                  <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['anamneses'] ?? 0 }}</span>
                <span class="text-xs text-indigo-600 font-bold">SISMAMA / SISCOLO</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Fichas clínicas preenchidas</p>
            </div>

            <div @click="subAbaAtendimento = 'desistencias'" :class="subAbaAtendimento === 'desistencias' ? 'bg-amber-50/60 border-amber-300 ring-2 ring-amber-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Desistências / 24h</span>
                <span class="p-2 bg-amber-100 text-amber-700 rounded-lg">
                  <i data-lucide="user-x" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['desistencias'] ?? 0 }}</span>
                <span class="text-xs text-amber-700 font-bold">Expirados</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Prazo 24h ou cancelamento</p>
            </div>

            <div @click="subAbaAtendimento = 'fila_espera'" :class="subAbaAtendimento === 'fila_espera' ? 'bg-purple-50/60 border-purple-300 ring-2 ring-purple-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Fila de Espera Ativa</span>
                <span class="p-2 bg-purple-100 text-purple-700 rounded-lg">
                  <i data-lucide="clock" class="w-4 h-4"></i>
                </span>
              </div>
              <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-900">{{ $totais['fila_espera'] ?? 0 }}</span>
                <span class="text-xs text-purple-700 font-bold">Em Espera</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Aguardando vagas</p>
            </div>
          </div>

          <!-- Barra de Abas e Filtros de Atendimento -->
          <div class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 space-y-4 shadow-xs">
            <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
              <button @click="subAbaAtendimento = 'atendidos'" :class="subAbaAtendimento === 'atendidos' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
                1. Pacientes Atendidos
              </button>
              <button @click="subAbaAtendimento = 'anamneses'" :class="subAbaAtendimento === 'anamneses' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
                2. Questionários de Anamnese (SISCOLO / SISMAMA)
              </button>
              <button @click="subAbaAtendimento = 'desistencias'" :class="subAbaAtendimento === 'desistencias' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
                3. Desistências e Cancelamentos
              </button>
              <button @click="subAbaAtendimento = 'fila_espera'" :class="subAbaAtendimento === 'fila_espera' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
                4. Fila de Espera
              </button>
            </div>

            <!-- Filtros de Busca e Período -->
            <form method="GET" action="{{ route('relatorios.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
              <input type="hidden" name="area" value="atendimentos">
              <input type="hidden" name="tipo" :value="subAbaAtendimento">

              <div class="relative w-full md:w-96 flex items-center">
                <i data-lucide="search" class="absolute left-4 text-slate-400 w-5 h-5 pointer-events-none"></i>
                <input 
                  type="text" 
                  name="search" 
                  x-model="busca"
                  value="{{ $busca ?? '' }}" 
                  placeholder="Buscar por paciente, CPF ou exame..." 
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-12 pr-4 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition-all"
                >
              </div>

              <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
                <span class="text-xs text-slate-400 font-medium">Período:</span>
                <input type="date" name="data_inicio" x-model="dataInicio" value="{{ $dataInicio ?? '' }}" class="bg-white border border-slate-200 text-slate-600 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-sky-500 transition-all">
                <span class="text-xs text-slate-400">até</span>
                <input type="date" name="data_fim" x-model="dataFim" value="{{ $dataFim ?? '' }}" class="bg-white border border-slate-200 text-slate-600 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-sky-500 transition-all">
                
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition-all cursor-pointer">
                  Filtrar Atendimentos
                </button>
              </div>
            </form>
          </div>

          <!-- 2.1 Tabela de Atendidos -->
          <div x-show="subAbaAtendimento === 'atendidos'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                    <th class="py-4 px-6 w-[12%]">Prontuário</th>
                    <th class="py-4 px-6 w-[28%]">Paciente / CPF</th>
                    <th class="py-4 px-6 w-[16%]">Data Atendimento</th>
                    <th class="py-4 px-6 w-[20%]">Tipo Exame / Unidade</th>
                    <th class="py-4 px-6 w-[10%]">Turno</th>
                    <th class="py-4 px-4 w-[14%] text-center">Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                  @forelse($atendidos as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                      <td class="py-4 px-6 font-mono font-medium text-slate-700">#{{ $item->numero_sequencial ?? $item->id_prontuario }}</td>
                      <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700">{{ $item->nome_paciente }}</div>
                        <div class="text-xs text-slate-400 font-mono">CPF: {{ $item->cpf_paciente }} • SUS: {{ $item->cartao_sus }}</div>
                      </td>
                      <td class="py-4 px-6 text-xs text-slate-700 font-medium">{{ $item->data_atendimento }}</td>
                      <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700 text-xs">{{ $item->tipo_exame }}</div>
                        <div class="text-[11px] text-slate-400">{{ $item->nome_unidade }}</div>
                      </td>
                      <td class="py-4 px-6 text-xs">{{ $item->turno }}</td>
                      <td class="py-4 px-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">
                          {{ strtoupper($item->status_comparecimento) }}
                        </span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Nenhum atendimento encontrado para o período.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if(method_exists($atendidos, 'links'))
              <div class="p-4 border-t border-slate-100">{{ $atendidos->appends(['area' => 'atendimentos', 'tipo' => 'atendidos'])->links() }}</div>
            @endif
          </div>

          <!-- 2.2 Tabela de Questionários de Anamnese -->
          <div x-show="subAbaAtendimento === 'anamneses'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                    <th class="py-4 px-6 w-[12%]">Prontuário</th>
                    <th class="py-4 px-6 w-[28%]">Paciente / CPF</th>
                    <th class="py-4 px-6 w-[14%]">Data</th>
                    <th class="py-4 px-4 w-[14%] text-center">Protocolo</th>
                    <th class="py-4 px-6 w-[20%]">Profissional Responsável</th>
                    <th class="py-4 px-4 w-[12%] text-center">Ficha Clínica</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                  @forelse($anamneses as $anamnese)
                    <tr class="hover:bg-slate-50 transition-colors">
                      <td class="py-4 px-6 font-mono font-medium text-slate-700">#{{ $anamnese->numero_sequencial ?? $anamnese->id_prontuario }}</td>
                      <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700">{{ $anamnese->nome_paciente }}</div>
                        <div class="text-xs text-slate-400 font-mono">CPF: {{ $anamnese->cpf_paciente }}</div>
                      </td>
                      <td class="py-4 px-6 text-xs text-slate-700">{{ $anamnese->data_realizacao }}</td>
                      <td class="py-4 px-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold {{ $anamnese->tipo_anamnese === 'sismama' ? 'bg-pink-100 text-pink-700' : 'bg-emerald-100 text-emerald-800' }}">
                          {{ strtoupper($anamnese->tipo_anamnese) }}
                        </span>
                      </td>
                      <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700 text-xs">{{ $anamnese->nome_profissional }}</div>
                        <div class="text-[11px] text-slate-400">{{ $anamnese->crm }} • {{ $anamnese->cargo_funcao }}</div>
                      </td>
                      <td class="py-4 px-4 text-center">
                        <button 
                          @click="anamneseSelecionada = {{ json_encode($anamnese) }}; modalAberto = true;"
                          class="px-3 py-1.5 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-bold transition-all cursor-pointer">
                          Ver Ficha
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Nenhum questionário de anamnese encontrado.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if(method_exists($anamneses, 'links'))
              <div class="p-4 border-t border-slate-100">{{ $anamneses->appends(['area' => 'atendimentos', 'tipo' => 'anamneses'])->links() }}</div>
            @endif
          </div>

          <!-- 2.3 Tabela de Desistências -->
          <div x-show="subAbaAtendimento === 'desistencias'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                    <th class="py-4 px-6 w-[12%]">Prontuário</th>
                    <th class="py-4 px-6 w-[28%]">Paciente / Telefone</th>
                    <th class="py-4 px-6 w-[16%]">Data Agendada</th>
                    <th class="py-4 px-6 w-[16%]">Data Cancelamento</th>
                    <th class="py-4 px-6 w-[28%]">Motivo da Liberação de Vaga</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                  @forelse($desistencias as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                      <td class="py-4 px-6 font-mono font-medium text-slate-700">#{{ $item->numero_sequencial ?? $item->id_prontuario }}</td>
                      <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700">{{ $item->nome_paciente }}</div>
                        <div class="text-xs text-slate-400">{{ $item->telefone ?? 'Sem telefone' }}</div>
                      </td>
                      <td class="py-4 px-6 text-xs">{{ $item->data_atendimento }}</td>
                      <td class="py-4 px-6 font-mono text-xs">{{ $item->data_cancelamento }}</td>
                      <td class="py-4 px-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold">
                          {{ $item->motivo_rejeicao_documento ?? 'Prazo 24h expirado sem confirmação' }}
                        </span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="py-8 text-center text-slate-500 font-medium">Nenhuma desistência registrada.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if(method_exists($desistencias, 'links'))
              <div class="p-4 border-t border-slate-100">{{ $desistencias->appends(['area' => 'atendimentos', 'tipo' => 'desistencias'])->links() }}</div>
            @endif
          </div>

          <!-- 2.4 Tabela da Fila de Espera -->
          <div x-show="subAbaAtendimento === 'fila_espera'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                    <th class="py-4 px-6 w-[10%]">Posição</th>
                    <th class="py-4 px-6 w-[28%]">Paciente / CPF</th>
                    <th class="py-4 px-6 w-[20%]">Cartão SUS / Telefone</th>
                    <th class="py-4 px-6 w-[16%]">Data de Entrada</th>
                    <th class="py-4 px-6 w-[14%]">Tipo de Exame</th>
                    <th class="py-4 px-4 w-[12%] text-center">Documentos</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                  @forelse($filaEspera as $pos => $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                      <td class="py-4 px-6 font-mono font-bold text-sky-700">#{{ $pos + 1 }}</td>
                      <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700">{{ $item->nome_paciente }}</div>
                        <div class="text-xs text-slate-400 font-mono">CPF: {{ $item->cpf_paciente }}</div>
                      </td>
                      <td class="py-4 px-6 text-xs">
                        <div>{{ $item->cartao_sus }}</div>
                        <div class="text-slate-400">{{ $item->telefone }}</div>
                      </td>
                      <td class="py-4 px-6 text-xs">{{ $item->data_entrada }}</td>
                      <td class="py-4 px-6 text-xs font-semibold text-slate-700">{{ $item->tipo_exame }}</td>
                      <td class="py-4 px-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->status_documentos === 'aprovado' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                          {{ strtoupper($item->status_documentos ?? 'pendente') }}
                        </span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Fila de espera vazia.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if(method_exists($filaEspera, 'links'))
              <div class="p-4 border-t border-slate-100">{{ $filaEspera->appends(['area' => 'atendimentos', 'tipo' => 'fila_espera'])->links() }}</div>
            @endif
          </div>

        </div>

      </main>

      <!-- Modal de Anamnese Clínica -->
      <div x-show="modalAberto" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" style="display: none;">
        <div @click.away="modalAberto = false" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
          
          <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="font-mono font-bold text-sky-400" x-text="'#' + (anamneseSelecionada?.numero_sequencial || anamneseSelecionada?.id_prontuario)"></span>
              <h3 class="font-bold text-white text-base">Questionário de Anamnese</h3>
            </div>
            <button @click="modalAberto = false" class="text-slate-400 hover:text-white p-1 cursor-pointer">
              <i data-lucide="x" class="w-5 h-5"></i>
            </button>
          </div>

          <div class="p-6 space-y-4 text-xs text-slate-600 max-h-[75vh] overflow-y-auto">
            <!-- Dados do Paciente -->
            <div class="p-4 bg-slate-50 rounded-xl space-y-2 border border-slate-100">
              <p><strong>Paciente:</strong> <span class="font-bold text-slate-800" x-text="anamneseSelecionada?.nome_paciente"></span></p>
              <p><strong>CPF / Cartão SUS:</strong> <span x-text="(anamneseSelecionada?.cpf_paciente) + ' • ' + (anamneseSelecionada?.cartao_sus || 'Não informado')"></span></p>
              <p><strong>Data Realização:</strong> <span x-text="anamneseSelecionada?.data_realizacao"></span></p>
              <p><strong>Profissional:</strong> <span x-text="(anamneseSelecionada?.nome_profissional) + ' (' + (anamneseSelecionada?.crm) + ')'"></span></p>
            </div>

            <!-- SISMAMA -->
            <template x-if="anamneseSelecionada?.tipo_anamnese === 'sismama'">
              <div class="border-t border-slate-100 pt-4 space-y-3">
                <h4 class="font-bold text-pink-700 uppercase tracking-wider text-[11px]">Protocolo SISMAMA (Mamografia)</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                  <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Nódulo Mama Direita</span>
                    <strong :class="anamneseSelecionada?.nodulo_mama_direita ? 'text-rose-600' : 'text-emerald-600'" x-text="anamneseSelecionada?.nodulo_mama_direita ? 'SIM' : 'NÃO'"></strong>
                  </div>
                  <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Nódulo Mama Esquerda</span>
                    <strong :class="anamneseSelecionada?.nodulo_mama_esquerda ? 'text-rose-600' : 'text-emerald-600'" x-text="anamneseSelecionada?.nodulo_mama_esquerda ? 'SIM' : 'NÃO'"></strong>
                  </div>
                  <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Risco Elevado Câncer</span>
                    <strong :class="anamneseSelecionada?.risco_elevado_cancer ? 'text-rose-600' : 'text-emerald-600'" x-text="anamneseSelecionada?.risco_elevado_cancer ? 'SIM (Histórico Positivo)' : 'NÃO'"></strong>
                  </div>
                  <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Mamografia Anterior</span>
                    <strong class="text-slate-800" x-text="anamneseSelecionada?.fez_mamografia_anterior ? 'Sim em ' + anamneseSelecionada?.ano_ultima_mamografia : 'Não'"></strong>
                  </div>
                </div>
              </div>
            </template>

            <!-- SISCOLO -->
            <template x-if="anamneseSelecionada?.tipo_anamnese === 'siscolo'">
              <div class="border-t border-slate-100 pt-4 space-y-3">
                <h4 class="font-bold text-emerald-800 uppercase tracking-wider text-[11px]">Protocolo SISCOLO (Preventivo)</h4>
                <div class="space-y-2">
                  <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Motivo do Exame</span>
                    <strong class="text-slate-800" x-text="anamneseSelecionada?.motivo_exame || 'Rotina Citopatológica'"></strong>
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                      <span class="text-slate-400 block text-[10px] uppercase font-bold">Preventivo Anterior</span>
                      <strong class="text-slate-800" x-text="anamneseSelecionada?.fez_preventivo_anterior ? 'Sim em ' + anamneseSelecionada?.ano_ultimo_preventivo : 'Não'"></strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                      <span class="text-slate-400 block text-[10px] uppercase font-bold">Contraceptivos</span>
                      <strong class="text-slate-800" x-text="'Pílula: ' + (anamneseSelecionada?.usa_pilula ? 'Sim' : 'Não') + ' | DIU: ' + (anamneseSelecionada?.usa_diu ? 'Sim' : 'Não')"></strong>
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </div>

          <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-xs cursor-pointer shadow-xs">
              Imprimir Ficha
            </button>
            <button @click="modalAberto = false" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs cursor-pointer">
              Fechar
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- Script Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
      });
    </script>

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
  
  </body>
</html>