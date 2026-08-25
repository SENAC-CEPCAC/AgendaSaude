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
    <!-- Alpine.js para controle do Modal e das Abas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body class="bg-[#f8fafc]">
    <div id="app-root" class="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased" x-data="{ 
        abaAtiva: '{{ $tipo ?? 'atendidos' }}',
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
          return '{{ url('/relatorios/exportar') }}/' + this.abaAtiva + '?' + params.toString();
        }
    }">
      
      <!-- Top Bar / Header idêntico ao de Agendamentos -->
      <header id="top-bar" class="h-16 bg-white border-b border-slate-100 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 shadow-xs">
        <div class="flex items-center gap-3">
          <div id="breadcrumb" class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <span>Portal Gestão</span>
            <span>/</span>
            <span class="text-slate-600 font-semibold">Relatórios Gerenciais e Clínicos</span>
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
        
        <!-- Título e Ações Rápidas -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Relatórios</h1>
            <p class="text-xs text-slate-500 mt-1">Extração consolidada: fato_prontuario • fato_cronogramas • fato_anamnese • sismama • siscolo</p>
          </div>

          <div class="flex flex-wrap items-center gap-2">
            <!-- Botão de Impressão PDF para Anamneses -->
            <template x-if="abaAtiva === 'anamneses'">
              <a href="{{ route('relatorios.anamneses.imprimir-todas', request()->all()) }}" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                Imprimir Todas Anamneses (PDF)
              </a>
            </template>

            <!-- Download CSV Dinâmico por Área Selecionada -->
            <a :href="gerarUrlDownload()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs">
              <i data-lucide="download" class="w-4 h-4"></i>
              <span>Exportar CSV da Área (<span x-text="abaAtiva.toUpperCase().replace('_', ' ')"></span>)</span>
            </a>

            <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs cursor-pointer">
              <i data-lucide="printer" class="w-4 h-4"></i>
              Imprimir
            </button>
          </div>
        </div>

        <!-- 4 Cards de Indicadores por Área (Totais Desacoplados) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Card 1: Atendidos -->
          <div @click="abaAtiva = 'atendidos'" :class="abaAtiva === 'atendidos' ? 'bg-sky-50/60 border-sky-300 ring-2 ring-sky-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
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
            <p class="text-[11px] text-slate-400 mt-1">Status agendamento confirmado</p>
          </div>

          <!-- Card 2: Questionários Clínicos (Área Clínica) -->
          <div @click="abaAtiva = 'anamneses'" :class="abaAtiva === 'anamneses' ? 'bg-indigo-50/60 border-indigo-300 ring-2 ring-indigo-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Questionários Clínicos</span>
              <span class="p-2 bg-indigo-100 text-indigo-700 rounded-lg">
                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
              </span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="text-3xl font-bold text-slate-900">{{ $totais['anamneses'] ?? 0 }}</span>
              <span class="text-xs text-indigo-600 font-bold">SISMAMA & SISCOLO</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Fichas clínicas completas</p>
          </div>

          <!-- Card 3: Desistências / 24h -->
          <div @click="abaAtiva = 'desistencias'" :class="abaAtiva === 'desistencias' ? 'bg-amber-50/60 border-amber-300 ring-2 ring-amber-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Desistências / 24h</span>
              <span class="p-2 bg-amber-100 text-amber-700 rounded-lg">
                <i data-lucide="user-x" class="w-4 h-4"></i>
              </span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="text-3xl font-bold text-slate-900">{{ $totais['desistencias'] ?? 0 }}</span>
              <span class="text-xs text-amber-700 font-bold">Expirados / Faltosos</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Prazo 24h ou ausência</p>
          </div>

          <!-- Card 4: Fila de Espera -->
          <div @click="abaAtiva = 'fila_espera'" :class="abaAtiva === 'fila_espera' ? 'bg-purple-50/60 border-purple-300 ring-2 ring-purple-400/20' : 'bg-white border-slate-100'" class="p-5 rounded-xl border transition-all cursor-pointer shadow-xs">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Fila de Espera Ativa</span>
              <span class="p-2 bg-purple-100 text-purple-700 rounded-lg">
                <i data-lucide="clock" class="w-4 h-4"></i>
              </span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="text-3xl font-bold text-slate-900">{{ $totais['fila_espera'] ?? 0 }}</span>
              <span class="text-xs text-purple-700 font-bold">Fila Cronológica</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Aguardando liberação de vagas</p>
          </div>
        </div>

        <!-- Barra de Abas e Filtros -->
        <div class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 space-y-4 shadow-xs">
          <!-- Abas de Navegação -->
          <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
            <button @click="abaAtiva = 'atendidos'" :class="abaAtiva === 'atendidos' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
              1. Pacientes Atendidos
            </button>
            <button @click="abaAtiva = 'anamneses'" :class="abaAtiva === 'anamneses' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
              2. Questionários de Anamnese (SISCOLO / SISMAMA)
            </button>
            <button @click="abaAtiva = 'desistencias'" :class="abaAtiva === 'desistencias' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
              3. Desistências e Cancelamentos
            </button>
            <button @click="abaAtiva = 'fila_espera'" :class="abaAtiva === 'fila_espera' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 font-medium'" class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer">
              4. Fila de Espera
            </button>
          </div>

          <!-- Filtros de Busca e Período -->
          <form method="GET" action="{{ route('relatorios.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
            <input type="hidden" name="tipo" :value="abaAtiva">

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
                Filtrar
              </button>
            </div>
          </form>
        </div>

        <!-- 1. Tabela de Atendidos -->
        <div x-show="abaAtiva === 'atendidos'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
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
            <div class="p-4 border-t border-slate-100">{{ $atendidos->links() }}</div>
          @endif
        </div>

        <!-- 2. Tabela de Questionários de Anamnese -->
        <div x-show="abaAtiva === 'anamneses'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
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
        </div>

        <!-- 3. Tabela de Desistências -->
        <div x-show="abaAtiva === 'desistencias'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
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
        </div>

        <!-- 4. Tabela da Fila de Espera -->
        <div x-show="abaAtiva === 'fila_espera'" class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
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

            <!-- Formulário SISMAMA -->
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

            <!-- Formulário SISCOLO -->
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

    <!-- Script dos Ícones Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
      });
    </script>
  </body>
</html>