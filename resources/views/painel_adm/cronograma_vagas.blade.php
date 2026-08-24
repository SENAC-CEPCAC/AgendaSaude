<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Agenda Saúde - Gestão de Cronograma de Vagas (Nível 4)</title>

    <!-- Tailwind CSS CDN com plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#002856",
                        "primary-container": "#003e7e",
                        "primary-fixed": "#d6e3ff",
                        "on-primary": "#ffffff",
                        secondary: "#785a00",
                        "secondary-container": "#fdc008",
                        surface: "#f8fafc",
                        "surface-container": "#f1f5f9",
                        "surface-card": "#ffffff",
                        "outline-border": "#e2e8f0",
                        success: "#10b981",
                        warning: "#f59e0b",
                        danger: "#ef4444",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        };
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 min-h-full flex flex-col antialiased">

    <!-- Header / Barra Superior Administrativa -->
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Logo e Título do Painel -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-[24px]">calendar_month</span>
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">
                        Gestão de Cronogramas & Vagas
                    </h1>
                    <p class="text-xs text-slate-500 hidden sm:block">
                        Painel de Controle e Distribuição Mensal de Consultas • <span class="text-amber-600 font-semibold">Acesso Gestor N4</span>
                    </p>
                </div>
            </div>

            <!-- Identificação do Usuário e Ações -->
            <div class="flex items-center gap-3">
                <div class="hidden md:flex flex-col text-right">
                    <span class="text-xs font-bold text-slate-800">
                        {{ auth()->user()->nome ?? auth()->user()->name ?? 'Gestor Nível 4' }}
                    </span>
                    <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1 justify-end">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Nível 4 (Acesso Total)
                    </span>
                </div>

                <a
                    href="{{ route('dash.index') }}"
                    class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold flex items-center gap-1.5 transition-colors"
                >
                    <span class="material-symbols-outlined text-[18px]">dashboard</span>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button
                        type="submit"
                        class="p-2 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-colors"
                        title="Sair do Sistema"
                    >
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- Mensagens de Alerta Flash (Sucesso / Erro) -->
        @if (session('sucesso'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 flex items-center gap-3 shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="text-sm font-medium">{{ session('sucesso') }}</span>
            </div>
        @endif

        @if (session('erro'))
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 flex items-center gap-3 shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <span class="text-sm font-medium">{{ session('erro') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-sm shadow-sm">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-600 text-[20px]">warning</span>
                    Corrija os erros abaixo:
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Barra de Ações Rápidas & Filtro por Mês -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Filtro de Mês e Formulário -->
            <form method="GET" action="{{ route('cronograma.index') }}" class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="filtro-mes-ano" class="text-xs font-bold text-slate-600 uppercase tracking-wider">
                        Mês de Referência:
                    </label>
                    <input
                        type="month"
                        id="filtro-mes-ano"
                        name="mes_ano"
                        value="{{ $mes_ano }}"
                        onchange="this.form.submit()"
                        class="text-sm font-semibold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                    />
                </div>

                <!-- Filtro por Unidade Móvel -->
                @if(count($unidades) > 0)
                    <select
                        name="id_cnes_unidade"
                        onchange="this.form.submit()"
                        class="text-xs text-slate-700 bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 focus:ring-primary"
                    >
                        <option value="">Todas as Unidades Móveis</option>
                        @foreach($unidades as $u)
                            <option value="{{ $u->id_cnes_unidade }}" {{ ($filtros['id_cnes_unidade'] ?? '') == $u->id_cnes_unidade ? 'selected' : '' }}>
                                {{ $u->nome_unidade }}
                            </option>
                        @endforeach
                    </select>
                @endif

                <!-- Filtro por Especialidade -->
                @if(count($vagas_tipos) > 0)
                    <select
                        name="id_vagas"
                        onchange="this.form.submit()"
                        class="text-xs text-slate-700 bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 focus:ring-primary"
                    >
                        <option value="">Todas as Especialidades</option>
                        @foreach($vagas_tipos as $v)
                            <option value="{{ $v->id_vagas }}" {{ ($filtros['id_vagas'] ?? '') == $v->id_vagas ? 'selected' : '' }}>
                                {{ $v->tipo_exame }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </form>

            <!-- Botão Principal: Cadastrar Novas Vagas (Abre Modal) -->
            <button
                type="button"
                onclick="abrirModalNovoCronograma()"
                class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 active:scale-[0.98] text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md transition-all cursor-pointer whitespace-nowrap"
            >
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>Inserir Vagas do Mês</span>
            </button>
        </div>

        <!-- Cards de Métricas & KPIs do Mês -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Card 1: Total de Vagas Oferecidas -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Vagas Ofertadas</span>
                    <span class="text-2xl font-black text-slate-900 mt-1 block">{{ $total_ofertadas }}</span>
                    <span class="text-[11px] text-slate-400">em {{ $dias_atendimento }} dias de atendimento</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">event_available</span>
                </div>
            </div>

            <!-- Card 2: Vagas Preenchidas -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Agendamentos Realizados</span>
                    <span class="text-2xl font-black text-emerald-600 mt-1 block">{{ $total_preenchidas }}</span>
                    <span class="text-[11px] text-slate-400">pacientes com vaga garantida</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">group</span>
                </div>
            </div>

            <!-- Card 3: Vagas Restantes -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Vagas Disponíveis</span>
                    <span class="text-2xl font-black text-amber-600 mt-1 block">{{ $total_restantes }}</span>
                    <span class="text-[11px] text-slate-400">livres para agendamento direto</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">hourglass_top</span>
                </div>
            </div>

            <!-- Card 4: Taxa de Ocupação -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div class="w-full mr-2">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Taxa de Ocupação</span>
                    <span class="text-2xl font-black text-slate-900 mt-1 block">{{ $taxa_ocupacao }}%</span>
                    <div class="w-full bg-slate-100 h-2 rounded-full mt-2 overflow-hidden">
                        <div class="bg-primary h-full rounded-full transition-all duration-500" style="width: {{ min(100, $taxa_ocupacao) }}%"></div>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">trending_up</span>
                </div>
            </div>
        </div>

        <!-- Tabela Principal de Cronogramas -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            
            <div class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        Cronograma Detalhado do Mês de {{ \Carbon\Carbon::parse($mes_ano . '-01')->translatedFormat('F / Y') }}
                    </h2>
                    <p class="text-xs text-slate-500">
                        Total de {{ $cronogramas->count() }} registro(s) configurado(s)
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500">Legenda de Vagas:</span>
                    <span class="inline-flex items-center gap-1 text-[11px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-md font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disponível
                    </span>
                    <span class="inline-flex items-center gap-1 text-[11px] bg-amber-50 text-amber-700 px-2 py-0.5 rounded-md font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Quase Cheio
                    </span>
                    <span class="inline-flex items-center gap-1 text-[11px] bg-rose-50 text-rose-700 px-2 py-0.5 rounded-md font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Esgotado
                    </span>
                </div>
            </div>

            <!-- Tabela Responsiva -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">Data / Dia</th>
                            <th class="px-6 py-3.5">Unidade Móvel</th>
                            <th class="px-6 py-3.5">Município / Local</th>
                            <th class="px-6 py-3.5">Especialidade</th>
                            <th class="px-6 py-3.5">Turno</th>
                            <th class="px-6 py-3.5 text-center">Ofertadas</th>
                            <th class="px-6 py-3.5 text-center">Preenchidas</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($cronogramas as $cronograma)
                            @php
                                $percentual = $cronograma->qnt_oferecidas_vagas > 0 
                                    ? ($cronograma->prenchida_vagas / $cronograma->qnt_oferecidas_vagas) * 100 
                                    : 0;
                                $statusBadge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                $statusTexto = 'Disponível';
                                if ($cronograma->prenchida_vagas >= $cronograma->qnt_oferecidas_vagas) {
                                    $statusBadge = 'bg-rose-50 text-rose-700 border-rose-200';
                                    $statusTexto = 'Esgotado';
                                } elseif ($percentual >= 75) {
                                    $statusBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                    $statusTexto = 'Quase Cheio';
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                
                                <!-- Data e Dia da Semana -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-900 text-sm">
                                        {{ \Carbon\Carbon::parse($cronograma->data_atendimento)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 capitalize">
                                        {{ \Carbon\Carbon::parse($cronograma->data_atendimento)->translatedFormat('l') }}
                                    </div>
                                </td>

                                <!-- Unidade Móvel -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-800">
                                        {{ $cronograma->unidade?->nome_unidade ?? "Unidade Móvel #{$cronograma->id_cnes_unidade}" }}
                                    </span>
                                    <span class="block text-[11px] text-slate-400">
                                        CNES: {{ $cronograma->unidade?->codigo_cnes ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Município / Localidade -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5 text-slate-700">
                                        <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span>
                                        <span>{{ $cronograma->municipio_atendimento }}</span>
                                    </div>
                                </td>

                                <!-- Especialidade / Vaga -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($cronograma->Vagas_id_vagas == 1)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                                            {{ $cronograma->vaga?->tipo_exame ?? 'Siscolo (Preventivo)' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-pink-50 text-pink-700 border border-pink-200">
                                            {{ $cronograma->vaga?->tipo_exame ?? 'Sismama (Mamografia)' }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Turno -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 text-xs text-slate-700">
                                        <span class="material-symbols-outlined text-[16px] text-slate-400">schedule</span>
                                        {{ $cronograma->turno?->turno ?? "Turno #{$cronograma->Turno_id_turno}" }}
                                    </span>
                                </td>

                                <!-- Vagas Ofertadas -->
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="font-bold text-slate-800 text-sm">{{ $cronograma->qnt_oferecidas_vagas }}</span>
                                </td>

                                <!-- Vagas Preenchidas -->
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="font-bold text-slate-900 text-sm">{{ $cronograma->prenchida_vagas }}</span>
                                    <span class="text-[11px] text-slate-400 block">({{ round($percentual) }}%)</span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusBadge }}">
                                        {{ $statusTexto }}
                                    </span>
                                </td>

                                <!-- Ações (Editar e Deletar) -->
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        
                                        <!-- Botão Editar -->
                                        <button
                                            type="button"
                                            onclick='abrirModalEditarCronograma(@json($cronograma))'
                                            class="p-1.5 text-slate-500 hover:text-primary hover:bg-slate-100 rounded-lg transition-colors"
                                            title="Editar Cronograma"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>

                                        <!-- Botão Deletar -->
                                        <button
                                            type="button"
                                            onclick="confirmarExclusao('{{ $cronograma->id_agenda }}', '{{ \Carbon\Carbon::parse($cronograma->data_atendimento)->format('d/m/Y') }}')"
                                            class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                            title="Excluir Cronograma"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[42px] text-slate-300">event_busy</span>
                                        <p class="text-sm font-semibold text-slate-600">Nenhum cronograma cadastrado para este mês.</p>
                                        <p class="text-xs text-slate-400">Clique no botão "Inserir Vagas do Mês" para abrir a agenda de atendimentos.</p>
                                        <button
                                            type="button"
                                            onclick="abrirModalNovoCronograma()"
                                            class="mt-2 text-xs font-bold text-primary bg-primary-fixed hover:bg-primary-fixed/80 px-4 py-2 rounded-lg transition-all"
                                        >
                                            + Cadastrar Vagas Agora
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </main>


    <!-- =========================================================================
         MODAL 1: CADASTRAR NOVO CRONOGRAMA DE VAGAS (INDIVIDUAL OU EM LOTE)
         ========================================================================= -->
    <div
        id="modal-novo-cronograma"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300"
    >
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transform scale-95 transition-all duration-300">
            
            <div class="bg-primary px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">add_box</span>
                    <h3 class="text-base font-bold">Cadastrar Cronograma de Vagas</h3>
                </div>
                <button type="button" onclick="fecharModalNovoCronograma()" class="text-white/80 hover:text-white">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <form method="POST" action="{{ route('cronograma.store') }}" class="p-6 space-y-4">
                @csrf

                <!-- Linha 1: Período / Datas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Data de Atendimento (Início) *
                        </label>
                        <input
                            type="date"
                            name="data_atendimento"
                            required
                            value="{{ now()->format('Y-m-d') }}"
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Data Final (Opcional - Para Lote)
                        </label>
                        <input
                            type="date"
                            name="data_fim_lote"
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                        />
                        <span class="text-[11px] text-slate-400 mt-0.5 block">Preencha apenas para criar dias consecutivos.</span>
                    </div>
                </div>

                <!-- Checkbox de replicação -->
                <div class="flex items-center gap-2 bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <input
                        type="checkbox"
                        id="replicar_dias_uteis"
                        name="replicar_dias_uteis"
                        value="1"
                        checked
                        class="rounded border-slate-300 text-primary focus:ring-primary"
                    />
                    <label for="replicar_dias_uteis" class="text-xs text-slate-700 font-medium cursor-pointer">
                        Se aplicar em lote, criar apenas de <strong>Segunda a Sexta</strong> (pular finais de semana).
                    </label>
                </div>

                <!-- Linha 2: Unidade Móvel e Especialidade -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Unidade Móvel (CNES) *
                        </label>
                        <select
                            name="id_cnes_unidade"
                            required
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                        >
                            @forelse($unidades as $u)
                                <option value="{{ $u->id_cnes_unidade }}">{{ $u->nome_unidade }} (CNES: {{ $u->codigo_cnes }})</option>
                            @empty
                                <option value="1">Unidade Móvel 01 - Centro</option>
                                <option value="2">Unidade Móvel 02 - Zona Norte</option>
                            @endforelse
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Especialidade / Exame *
                        </label>
                        <select
                            name="Vagas_id_vagas"
                            required
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                        >
                            @forelse($vagas_tipos as $v)
                                <option value="{{ $v->id_vagas }}">{{ $v->tipo_exame }}</option>
                            @empty
                                <option value="1">Siscolo (Preventivo de Colo de Útero)</option>
                                <option value="2">Sismama (Mamografia)</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <!-- Linha 3: Turno e Quantidade de Vagas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Turno de Atendimento *
                        </label>
                        <select
                            name="Turno_id_turno"
                            required
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                        >
                            @forelse($turnos as $t)
                                <option value="{{ $t->id_turno }}">{{ $t->turno }}</option>
                            @empty
                                <option value="1">Manhã (08:00 às 12:00)</option>
                                <option value="2">Tarde (13:00 às 17:00)</option>
                                <option value="3">Integral (08:00 às 17:00)</option>
                            @endforelse
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Quantidade de Vagas Oferecidas *
                        </label>
                        <input
                            type="number"
                            name="qnt_oferecidas_vagas"
                            required
                            min="1"
                            max="500"
                            value="20"
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none font-bold"
                        />
                    </div>
                </div>

                <!-- Linha 4: Município / Local de Atendimento -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Município / Endereço de Atendimento da Unidade *
                    </label>
                    <input
                        type="text"
                        name="municipio_atendimento"
                        required
                        placeholder="Ex: Fortaleza - Praça da Sé / Bairro Centro"
                        class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                    />
                </div>

                <!-- Botões do Modal -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button
                        type="button"
                        onclick="fecharModalNovoCronograma()"
                        class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 text-sm font-semibold transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-bold shadow-md transition-all uppercase tracking-wider cursor-pointer"
                    >
                        Salvar Vagas
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- =========================================================================
         MODAL 2: EDITAR CRONOGRAMA DE VAGAS
         ========================================================================= -->
    <div
        id="modal-editar-cronograma"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300"
    >
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transform scale-95 transition-all duration-300">
            
            <div class="bg-primary-container px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">edit_calendar</span>
                    <h3 class="text-base font-bold">Editar Cronograma de Vagas</h3>
                </div>
                <button type="button" onclick="fecharModalEditarCronograma()" class="text-white/80 hover:text-white">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <form id="form-editar-cronograma" method="POST" action="" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Data de Atendimento *
                        </label>
                        <input
                            type="date"
                            id="edit_data_atendimento"
                            name="data_atendimento"
                            required
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Turno *
                        </label>
                        <select
                            id="edit_Turno_id_turno"
                            name="Turno_id_turno"
                            required
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                        >
                            @forelse($turnos as $t)
                                <option value="{{ $t->id_turno }}">{{ $t->turno }}</option>
                            @empty
                                <option value="1">Manhã</option>
                                <option value="2">Tarde</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Unidade Móvel (CNES) *
                        </label>
                        <select
                            id="edit_id_cnes_unidade"
                            name="id_cnes_unidade"
                            required
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                        >
                            @forelse($unidades as $u)
                                <option value="{{ $u->id_cnes_unidade }}">{{ $u->nome_unidade }}</option>
                            @empty
                                <option value="1">Unidade Móvel 01</option>
                            @endforelse
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Especialidade / Exame *
                        </label>
                        <select
                            id="edit_Vagas_id_vagas"
                            name="Vagas_id_vagas"
                            required
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                        >
                            @forelse($vagas_tipos as $v)
                                <option value="{{ $v->id_vagas }}">{{ $v->tipo_exame }}</option>
                            @empty
                                <option value="1">Siscolo (Preventivo)</option>
                                <option value="2">Sismama (Mamografia)</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Vagas Oferecidas *
                        </label>
                        <input
                            type="number"
                            id="edit_qnt_oferecidas_vagas"
                            name="qnt_oferecidas_vagas"
                            required
                            min="1"
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none font-bold"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Vagas Preenchidas
                        </label>
                        <input
                            type="number"
                            id="edit_prenchida_vagas"
                            name="prenchida_vagas"
                            min="0"
                            class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none bg-slate-50 font-bold"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Município / Endereço *
                    </label>
                    <input
                        type="text"
                        id="edit_municipio_atendimento"
                        name="municipio_atendimento"
                        required
                        class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-primary outline-none"
                    />
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button
                        type="button"
                        onclick="fecharModalEditarCronograma()"
                        class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 text-sm font-semibold transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-bold shadow-md transition-all uppercase tracking-wider cursor-pointer"
                    >
                        Atualizar Vagas
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- =========================================================================
         MODAL 3: CONFIRMAR EXCLUSÃO DE CRONOGRAMA
         ========================================================================= -->
    <div
        id="modal-excluir-cronograma"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300"
    >
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transform scale-95 transition-all duration-300 p-6 space-y-4 text-center">
            
            <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                <span class="material-symbols-outlined text-[32px]">delete_forever</span>
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-900">Excluir Cronograma de Vagas?</h3>
                <p class="text-xs text-slate-500 mt-1">
                    Tem certeza de que deseja remover o cronograma do dia <strong id="texto-data-exclusao" class="text-slate-800"></strong>? Esta ação não poderá ser desfeita.
                </p>
            </div>

            <form id="form-excluir-cronograma" method="POST" action="" class="flex items-center justify-center gap-3 pt-2">
                @csrf
                @method('DELETE')

                <button
                    type="button"
                    onclick="fecharModalExclusao()"
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="w-full px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold shadow-md transition-colors"
                >
                    Sim, Excluir
                </button>
            </form>
        </div>
    </div>


    <!-- Scripts de Interatividade dos Modais -->
    <script>
        // Modal Novo Cronograma
        function abrirModalNovoCronograma() {
            const modal = document.getElementById('modal-novo-cronograma');
            if (modal) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100', 'pointer-events-auto');
            }
        }

        function fecharModalNovoCronograma() {
            const modal = document.getElementById('modal-novo-cronograma');
            if (modal) {
                modal.classList.remove('opacity-100', 'pointer-events-auto');
                modal.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        // Modal Editar Cronograma
        function abrirModalEditarCronograma(cronograma) {
            const form = document.getElementById('form-editar-cronograma');
            form.action = `/gestao-cronograma/${cronograma.id_agenda}`;

            document.getElementById('edit_data_atendimento').value = cronograma.data_atendimento ? cronograma.data_atendimento.split('T')[0] : '';
            document.getElementById('edit_id_cnes_unidade').value = cronograma.id_cnes_unidade;
            document.getElementById('edit_Vagas_id_vagas').value = cronograma.Vagas_id_vagas;
            document.getElementById('edit_Turno_id_turno').value = cronograma.Turno_id_turno;
            document.getElementById('edit_qnt_oferecidas_vagas').value = cronograma.qnt_oferecidas_vagas;
            document.getElementById('edit_prenchida_vagas').value = cronograma.prenchida_vagas;
            document.getElementById('edit_municipio_atendimento').value = cronograma.municipio_atendimento;

            const modal = document.getElementById('modal-editar-cronograma');
            if (modal) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100', 'pointer-events-auto');
            }
        }

        function fecharModalEditarCronograma() {
            const modal = document.getElementById('modal-editar-cronograma');
            if (modal) {
                modal.classList.remove('opacity-100', 'pointer-events-auto');
                modal.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        // Modal Exclusão
        function confirmarExclusao(idAgenda, dataFormatada) {
            const form = document.getElementById('form-excluir-cronograma');
            form.action = `/gestao-cronograma/${idAgenda}`;
            document.getElementById('texto-data-exclusao').textContent = dataFormatada;

            const modal = document.getElementById('modal-excluir-cronograma');
            if (modal) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100', 'pointer-events-auto');
            }
        }

        function fecharModalExclusao() {
            const modal = document.getElementById('modal-excluir-cronograma');
            if (modal) {
                modal.classList.remove('opacity-100', 'pointer-events-auto');
                modal.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        // Fechar modais ao teclar ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fecharModalNovoCronograma();
                fecharModalEditarCronograma();
                fecharModalExclusao();
            }
        });
    </script>

</body>
</html>
