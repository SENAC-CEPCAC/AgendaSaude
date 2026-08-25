<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios Gerenciais e Clínicos - SUS Agenda Saúde</title>
    <!-- Tailwind CSS CDN para garantir estilização 100% imediata -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js para controle do Modal e das Abas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen font-sans" x-data="{ 
    abaAtiva: '{{ $tipo ?? 'atendidos' }}',
    modalAberto: false,
    anamneseSelecionada: null
}">

    <!-- TOPO / HEADER -->
    <header class="bg-slate-900 text-white border-b border-slate-800 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-600 flex items-center justify-center text-white shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-white flex items-center gap-2">
                        Relatórios Gerenciais e Clínicos
                        <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-sky-500/20 text-sky-300 border border-sky-400/30">SUS Oficial</span>
                    </h1>
                    <p class="text-xs text-slate-400">Extração consolidada: fato_prontuario • fato_cronogramas • fato_anamnese • sismama • siscolo</p>
                </div>
            </div>

            <!-- Botões de Ação Global -->
            <div class="flex flex-wrap items-center gap-2">
                <template x-if="abaAtiva === 'anamneses'">
                    <a href="{{ route('relatorios.imprimir.anamneses', request()->all()) }}" target="_blank" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Imprimir Todas Anamneses (PDF)
                    </a>
                </template>

                <a :href="'{{ url('/relatorios/exportar') }}/' + abaAtiva" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exportar CSV / Excel
                </a>

                <button onclick="window.print()" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-sm border border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Imprimir Tela
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <!-- 4 CARDS DE INDICADORES / TOTAIS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 no-print">
            
            <!-- Card 1: Atendidos -->
            <div @click="abaAtiva = 'atendidos'" :class="abaAtiva === 'atendidos' ? 'bg-sky-50 border-sky-300 ring-2 ring-sky-400/20' : 'bg-white border-slate-200'" class="p-5 rounded-2xl border transition-all cursor-pointer shadow-xs hover:border-slate-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pacientes Atendidos</span>
                    <span class="p-2 bg-sky-100 text-sky-700 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $totais['atendidos'] ?? 0 }}</span>
                    <span class="text-xs text-emerald-600 font-bold">Presente</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Status agendamento confirmado</p>
            </div>

            <!-- Card 2: Anamneses -->
            <div @click="abaAtiva = 'anamneses'" :class="abaAtiva === 'anamneses' ? 'bg-indigo-50 border-indigo-300 ring-2 ring-indigo-400/20' : 'bg-white border-slate-200'" class="p-5 rounded-2xl border transition-all cursor-pointer shadow-xs hover:border-slate-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Questionários de Anamnese</span>
                    <span class="p-2 bg-indigo-100 text-indigo-700 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $totais['anamneses'] ?? 0 }}</span>
                    <span class="text-xs text-indigo-600 font-bold">SISMAMA & SISCOLO</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Protocolos clínicos completos</p>
            </div>

            <!-- Card 3: Desistências / 24h -->
            <div @click="abaAtiva = 'desistencias'" :class="abaAtiva === 'desistencias' ? 'bg-amber-50 border-amber-300 ring-2 ring-amber-400/20' : 'bg-white border-slate-200'" class="p-5 rounded-2xl border transition-all cursor-pointer shadow-xs hover:border-slate-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Desistências / 24h</span>
                    <span class="p-2 bg-amber-100 text-amber-700 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $totais['desistencias'] ?? 0 }}</span>
                    <span class="text-xs text-amber-700 font-bold">Expirados</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Prazo 24h sem confirmação</p>
            </div>

            <!-- Card 4: Fila de Espera -->
            <div @click="abaAtiva = 'fila_espera'" :class="abaAtiva === 'fila_espera' ? 'bg-purple-50 border-purple-300 ring-2 ring-purple-400/20' : 'bg-white border-slate-200'" class="p-5 rounded-2xl border transition-all cursor-pointer shadow-xs hover:border-slate-300">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Fila de Espera Ativa</span>
                    <span class="p-2 bg-purple-100 text-purple-700 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $totais['fila_espera'] ?? 0 }}</span>
                    <span class="text-xs text-purple-700 font-bold">Fila Cronológica</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Aguardando liberação de vagas</p>
            </div>
        </div>

        <!-- BARRA DE FILTROS E ABAS -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-4 no-print">
            
            <!-- Navegação por Abas -->
            <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
                <button @click="abaAtiva = 'atendidos'" :class="abaAtiva === 'atendidos' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 font-medium'" class="px-4 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
                    <span>1. Pacientes Atendidos</span>
                </button>
                <button @click="abaAtiva = 'anamneses'" :class="abaAtiva === 'anamneses' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 font-medium'" class="px-4 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
                    <span>2. Questionários de Anamnese (SISCOLO / SISMAMA)</span>
                </button>
                <button @click="abaAtiva = 'desistencias'" :class="abaAtiva === 'desistencias' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 font-medium'" class="px-4 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
                    <span>3. Desistências e Cancelamentos</span>
                </button>
                <button @click="abaAtiva = 'fila_espera'" :class="abaAtiva === 'fila_espera' ? 'bg-sky-600 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 font-medium'" class="px-4 py-2.5 rounded-xl text-xs transition-all flex items-center gap-2">
                    <span>4. Fila de Espera</span>
                </button>
            </div>

            <!-- Formulário de Filtro e Busca -->
            <form method="GET" action="{{ route('relatorios.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
                <input type="hidden" name="tipo" :value="abaAtiva">

                <div class="relative w-full md:max-w-md">
                    <input type="text" name="search" value="{{ $busca ?? '' }}" placeholder="Buscar por paciente, CPF ou exame..." class="w-full pl-4 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-sky-500 focus:bg-white transition-all">
                </div>

                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                    <span class="text-xs text-slate-500 font-medium">Período:</span>
                    <input type="date" name="data_inicio" value="{{ $dataInicio ?? '' }}" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700">
                    <span class="text-xs text-slate-400">até</span>
                    <input type="date" name="data_fim" value="{{ $dataFim ?? '' }}" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700">
                    
                    <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-all">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- 1. ABA DE ATENDIDOS -->
        <div x-show="abaAtiva === 'atendidos'" class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Relatório de Pacientes Atendidos (fato_prontuario)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200 text-[11px]">
                            <th class="py-3 px-6">Prontuário</th>
                            <th class="py-3 px-6">Paciente / CPF</th>
                            <th class="py-3 px-6">Data Atendimento</th>
                            <th class="py-3 px-6">Tipo Exame / Unidade</th>
                            <th class="py-3 px-6">Turno</th>
                            <th class="py-3 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @forelse($atendidos as $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">#{{ $item->numero_sequencial ?? $item->id_prontuario }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $item->nome_paciente }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">CPF: {{ $item->cpf_paciente }} • SUS: {{ $item->cartao_sus }}</div>
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-700">{{ $item->data_atendimento }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $item->tipo_exame }}</div>
                                <div class="text-[11px] text-slate-400">{{ $item->nome_unidade }}</div>
                            </td>
                            <td class="py-4 px-6">{{ $item->turno }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    {{ strtoupper($item->status_comparecimento) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Nenhum atendimento encontrado para o período.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($atendidos, 'links'))
                <div class="p-4 border-t border-slate-100">{{ $atendidos->links() }}</div>
            @endif
        </div>

        <!-- 2. ABA DE QUESTIONÁRIOS DE ANAMNESE (SISMAMA / SISCOLO) -->
        <div x-show="abaAtiva === 'anamneses'" class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Questionários Clínicos de Anamnese (fato_anamnese)</h3>
                <a href="{{ route('relatorios.imprimir.anamneses', request()->all()) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Imprimir Todas em PDF
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200 text-[11px]">
                            <th class="py-3 px-6">Prontuário</th>
                            <th class="py-3 px-6">Paciente / CPF</th>
                            <th class="py-3 px-6">Data</th>
                            <th class="py-3 px-6">Protocolo</th>
                            <th class="py-3 px-6">Profissional Responsável</th>
                            <th class="py-3 px-6 text-center">Ficha Clínica</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @forelse($anamneses as $anamnese)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">#{{ $anamnese->numero_sequencial ?? $anamnese->id_prontuario }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $anamnese->nome_paciente }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">CPF: {{ $anamnese->cpf_paciente }}</div>
                            </td>
                            <td class="py-4 px-6">{{ $anamnese->data_realizacao }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold {{ $anamnese->tipo_anamnese === 'sismama' ? 'bg-pink-100 text-pink-700' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ strtoupper($anamnese->tipo_anamnese) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $anamnese->nome_profissional }}</div>
                                <div class="text-[11px] text-slate-400">{{ $anamnese->crm }} • {{ $anamnese->cargo_funcao }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button 
                                    @click="anamneseSelecionada = {{ json_encode($anamnese) }}; modalAberto = true;"
                                    class="px-3 py-1.5 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-bold transition-all">
                                    Visualizar Questionário
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Nenhum questionário de anamnese encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. ABA DE DESISTÊNCIAS E CANCELAMENTOS -->
        <div x-show="abaAtiva === 'desistencias'" class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Relatório de Desistências e Expirações 24h</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200 text-[11px]">
                            <th class="py-3 px-6">Prontuário</th>
                            <th class="py-3 px-6">Paciente / Telefone</th>
                            <th class="py-3 px-6">Data Agendada</th>
                            <th class="py-3 px-6">Data Cancelamento</th>
                            <th class="py-3 px-6">Motivo da Liberação de Vaga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @forelse($desistencias as $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">#{{ $item->numero_sequencial ?? $item->id_prontuario }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $item->nome_paciente }}</div>
                                <div class="text-[11px] text-slate-400">{{ $item->telefone ?? 'Sem telefone' }}</div>
                            </td>
                            <td class="py-4 px-6">{{ $item->data_atendimento }}</td>
                            <td class="py-4 px-6 font-mono text-[11px]">{{ $item->data_cancelamento }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-1 rounded bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold">
                                    {{ $item->motivo_rejeicao_documento ?? 'Prazo 24h expirado sem confirmação' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Nenhuma desistência registrada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. ABA DA FILA DE ESPERA -->
        <div x-show="abaAtiva === 'fila_espera'" class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Fila de Espera Cronológica Inteligente</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200 text-[11px]">
                            <th class="py-3 px-6">Posição</th>
                            <th class="py-3 px-6">Paciente / CPF</th>
                            <th class="py-3 px-6">Cartão SUS / Telefone</th>
                            <th class="py-3 px-6">Data de Entrada</th>
                            <th class="py-3 px-6">Tipo de Exame</th>
                            <th class="py-3 px-6 text-center">Status Documentos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @forelse($filaEspera as $pos => $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-4 px-6 font-mono font-bold text-sky-700">#{{ $pos + 1 }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $item->nome_paciente }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">CPF: {{ $item->cpf_paciente }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div>{{ $item->cartao_sus }}</div>
                                <div class="text-[11px] text-slate-400">{{ $item->telefone }}</div>
                            </td>
                            <td class="py-4 px-6">{{ $item->data_entrada }}</td>
                            <td class="py-4 px-6 font-semibold">{{ $item->tipo_exame }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $item->status_documentos === 'aprovado' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ strtoupper($item->status_documentos ?? 'pendente') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Fila de espera vazia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- MODAL PROFISSIONAL COM QUESTIONÁRIO CLÍNICO COMPLETO -->
    <div x-show="modalAberto" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" style="display: none;">
        <div @click.away="modalAberto = false" class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full border border-slate-200 overflow-hidden animate-scale-in">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold flex items-center gap-2">
                        <span>Ficha de Anamnese Clínica</span>
                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-sky-500/30 text-sky-200" x-text="'Prontuário #' + (anamneseSelecionada?.numero_sequencial || anamneseSelecionada?.id_prontuario)"></span>
                    </h3>
                    <p class="text-xs text-slate-400" x-text="'Protocolo ' + (anamneseSelecionada?.tipo_anamnese?.toUpperCase())"></p>
                </div>
                <button @click="modalAberto = false" class="text-slate-400 hover:text-white p-1 rounded-lg text-lg font-bold">✕</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                
                <!-- Informações do Paciente -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Paciente</span>
                        <strong class="text-slate-900" x-text="anamneseSelecionada?.nome_paciente"></strong>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">CPF / SUS</span>
                        <span class="text-slate-700 font-mono" x-text="(anamneseSelecionada?.cpf_paciente) + ' • ' + (anamneseSelecionada?.cartao_sus || 'SUS N/I')"></span>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Data Realização</span>
                        <span class="text-slate-700" x-text="anamneseSelecionada?.data_realizacao"></span>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Médico / CRM</span>
                        <span class="text-slate-700" x-text="(anamneseSelecionada?.nome_profissional) + ' (' + (anamneseSelecionada?.crm) + ')'"></span>
                    </div>
                </div>

                <!-- QUESTIONÁRIO SISMAMA -->
                <template x-if="anamneseSelecionada?.tipo_anamnese === 'sismama'">
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-pink-700 uppercase tracking-wider border-b pb-1">Protocolo SISMAMA (Mamografia)</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <span class="text-slate-500 font-semibold block">Nódulo Mama Direita</span>
                                <strong :class="anamneseSelecionada?.nodulo_mama_direita ? 'text-rose-600' : 'text-emerald-600'" x-text="anamneseSelecionada?.nodulo_mama_direita ? 'SIM (Presente)' : 'NÃO'"></strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <span class="text-slate-500 font-semibold block">Nódulo Mama Esquerda</span>
                                <strong :class="anamneseSelecionada?.nodulo_mama_esquerda ? 'text-rose-600' : 'text-emerald-600'" x-text="anamneseSelecionada?.nodulo_mama_esquerda ? 'SIM (Presente)' : 'NÃO'"></strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <span class="text-slate-500 font-semibold block">Risco Elevado de Câncer</span>
                                <strong :class="anamneseSelecionada?.risco_elevado_cancer ? 'text-rose-600' : 'text-emerald-600'" x-text="anamneseSelecionada?.risco_elevado_cancer ? 'SIM (Histórico Familiar Positivo)' : 'NÃO'"></strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <span class="text-slate-500 font-semibold block">Tipo de Mamografia</span>
                                <strong class="text-slate-800" x-text="(anamneseSelecionada?.tipo_mamografia || 'Rastreamento') + ' (Anterior: ' + (anamneseSelecionada?.fez_mamografia_anterior ? 'Sim' : 'Não') + ')'"></strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 sm:col-span-2">
                                <span class="text-slate-500 font-semibold block">Achados de Exame e Linfonodos</span>
                                <span class="text-slate-800" x-text="'Localização: ' + (anamneseSelecionada?.achado_nodulo_localizacao_dir || 'Sem alterações') + ' | Linfonodo Axilar: ' + (anamneseSelecionada?.achado_linfonodo_palpavel_dir || 'Não palpável')"></span>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- QUESTIONÁRIO SISCOLO -->
                <template x-if="anamneseSelecionada?.tipo_anamnese === 'siscolo'">
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-emerald-800 uppercase tracking-wider border-b pb-1">Protocolo SISCOLO (Citopatológico / Preventivo)</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 sm:col-span-2">
                                <span class="text-slate-500 font-semibold block">Motivo do Exame</span>
                                <strong class="text-slate-800" x-text="anamneseSelecionada?.motivo_exame || 'Exame Citopatológico de Rotina'"></strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <span class="text-slate-500 font-semibold block">Fez Preventivo Anterior</span>
                                <strong class="text-slate-800" x-text="anamneseSelecionada?.fez_preventivo_anterior ? 'SIM (Ano: ' + anamneseSelecionada?.ano_ultimo_preventivo + ')' : 'NÃO (Primeira vez)'"></strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <span class="text-slate-500 font-semibold block">Uso de Contraceptivo / Pílula</span>
                                <strong class="text-slate-800" x-text="'Pílula: ' + (anamneseSelecionada?.usa_pilula ? 'Sim' : 'Não') + ' | DIU: ' + (anamneseSelecionada?.usa_diu ? 'Sim' : 'Não')"></strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 sm:col-span-2">
                                <span class="text-slate-500 font-semibold block">Inspeção do Colo e Sinais de IST</span>
                                <span class="text-slate-800" x-text="(anamneseSelecionada?.inspecao_colo || 'Colo sem alterações aparentes') + ' | Sinais IST: ' + (anamneseSelecionada?.sinais_dst ? 'Sim' : 'Não')"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
                <button @click="window.print()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all">
                    Imprimir Esta Ficha
                </button>
                <button @click="modalAberto = false" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold transition-all">
                    Fechar
                </button>
            </div>
        </div>
    </div>

</body>
</html>