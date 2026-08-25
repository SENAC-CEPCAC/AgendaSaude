<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Agenda Saúde - Gestão de Cronograma de Vagas (Nível 4)</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#002856",
                        "primary-dark": "#001b3a",
                        "primary-light": "#003E7E",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-[#f8fafc] text-slate-800 font-sans antialiased min-h-full flex flex-col">

    <!-- Sidebar N4 -->
    @include('sidebar.sidebar_n4')

    <!-- Botão Menu Mobile -->
    <button id="mobile-menu-toggle" type="button" class="fixed left-3 top-3 z-[60] flex items-center justify-center rounded-lg bg-blue-900 p-2 text-white shadow-md transition hover:bg-blue-800" aria-label="Abrir menu">
        <span class="material-symbols-outlined text-[22px]">menu</span>
    </button>

    <div class="min-h-screen flex flex-col pl-0 transition-all duration-300">
        
        <!-- Top Bar Administrativo -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 md:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
            <div class="flex items-center gap-3 pl-12 md:pl-0">
                <div class="w-9 h-9 rounded-xl bg-blue-900 text-white flex items-center justify-center shadow-xs">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                </div>
                <div>
                    <h1 class="text-base font-bold text-slate-900 uppercase tracking-wide">Gestão de Cronograma de Vagas</h1>
                    <p class="text-[11px] text-slate-500 hidden sm:block">Distribuição de vagas, horários e acompanhamento de ocupação em tempo real</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-bold text-slate-800">
                        {{ auth()->user()->nome ?? auth()->user()->name ?? 'Gestor Nível 4' }}
                    </span>
                    <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">Gestor (Nível 4)</span>
                </div>

                <a href="{{ route('painel_adm.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">dashboard</span>
                    <span class="hidden md:inline">Dashboard</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Sair">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Conteúdo Principal -->
        <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6 md:p-8 space-y-6">

            <!-- Mensagens Flash -->
            @if (session('sucesso'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 flex items-center gap-3 shadow-xs">
                    <span class="material-symbols-outlined text-emerald-600 text-[22px]">check_circle</span>
                    <span class="text-xs font-semibold">{{ session('sucesso') }}</span>
                </div>
            @endif

            @if (session('erro'))
                <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 flex items-center gap-3 shadow-xs">
                    <span class="material-symbols-outlined text-rose-600 text-[22px]">error</span>
                    <span class="text-xs font-semibold">{{ session('erro') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs shadow-xs space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-sm mb-1">
                        <span class="material-symbols-outlined text-rose-600 text-[18px]">warning</span>
                        Corrija os seguintes campos:
                    </div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ========================================================================= -->
            <!-- 1. PAINEL DE CADASTRO RÁPIDO DE VAGAS E HORÁRIOS -->
            <!-- ========================================================================= -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-6 py-4 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[24px]">add_circle</span>
                        <div>
                            <h2 class="font-bold text-sm uppercase tracking-wide">Cadastro Rápido de Vagas e Horários</h2>
                            <p class="text-[11px] text-blue-200">Abra novas datas de atendimento para a população com preenchimento instantâneo</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        onclick="toggleFormRapido()"
                        id="btn-toggle-form"
                        class="self-start sm:self-auto text-xs bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1"
                    >
                        <span class="material-symbols-outlined text-[16px]" id="icone-toggle">expand_less</span>
                        <span id="texto-toggle">Recolher Formulário</span>
                    </button>
                </div>

                <form id="form-cadastro-rapido" method="POST" action="{{ route('cronograma.store') }}" class="p-6 transition-all duration-300">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                        <!-- 1. Unidade Móvel -->
                        <div class="flex flex-col gap-1">
                            <label for="id_cnes_unidade" class="text-xs font-bold text-slate-700">
                                Unidade Móvel (CNES) *
                            </label>
                            <select
                                name="id_cnes_unidade"
                                id="id_cnes_unidade"
                                required
                                class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:ring-1 focus:ring-blue-800 focus:bg-white transition-all font-medium"
                            >
                                @foreach($unidades as $u)
                                    <option value="{{ $u->id_cnes_unidade }}">{{ $u->nome_unidade }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. Tipo de Exame / Especialidade -->
                        <div class="flex flex-col gap-1">
                            <label for="Vagas_id_vagas" class="text-xs font-bold text-slate-700">
                                Especialidade / Exame *
                            </label>
                            <select
                                name="Vagas_id_vagas"
                                id="Vagas_id_vagas"
                                required
                                class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:ring-1 focus:ring-blue-800 focus:bg-white transition-all font-medium"
                            >
                                @foreach($vagas_tipos as $v)
                                    <option value="{{ $v->id_vagas }}">{{ $v->tipo_exame }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 3. Turno & Horário -->
                        <div class="flex flex-col gap-1">
                            <label for="Turno_id_turno" class="text-xs font-bold text-slate-700">
                                Turno de Atendimento *
                            </label>
                            <select
                                name="Turno_id_turno"
                                id="Turno_id_turno"
                                required
                                class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:ring-1 focus:ring-blue-800 focus:bg-white transition-all font-medium"
                            >
                                <option value="1">Manhã (08:00 às 12:00)</option>
                                <option value="2">Tarde (13:00 às 17:00)</option>
                                <option value="3">Integral (08:00 às 17:00)</option>
                            </select>
                        </div>

                        <!-- 4. Quantidade de Vagas -->
                        <div class="flex flex-col gap-1">
                            <label for="qnt_oferecidas_vagas" class="text-xs font-bold text-slate-700">
                                Quantidade de Vagas (por dia) *
                            </label>
                            <div class="flex items-center gap-2">
                                <input
                                    type="number"
                                    name="qnt_oferecidas_vagas"
                                    id="qnt_oferecidas_vagas"
                                    min="1"
                                    max="500"
                                    value="20"
                                    required
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:ring-1 focus:ring-blue-800 focus:bg-white font-bold"
                                />
                                <div class="flex gap-1 shrink-0">
                                    <button type="button" onclick="document.getElementById('qnt_oferecidas_vagas').value=15" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-[10px] font-bold rounded">15</button>
                                    <button type="button" onclick="document.getElementById('qnt_oferecidas_vagas').value=20" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-[10px] font-bold rounded">20</button>
                                    <button type="button" onclick="document.getElementById('qnt_oferecidas_vagas').value=30" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-[10px] font-bold rounded">30</button>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Data Inicial -->
                        <div class="flex flex-col gap-1">
                            <label for="data_atendimento" class="text-xs font-bold text-slate-700">
                                Data Inicial *
                            </label>
                            <input
                                type="date"
                                name="data_atendimento"
                                id="data_atendimento"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                                class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:ring-1 focus:ring-blue-800 focus:bg-white font-medium"
                            />
                        </div>

                        <!-- 6. Data Final (Opcional para Lote) -->
                        <div class="flex flex-col gap-1">
                            <label for="data_fim_lote" class="text-xs font-bold text-slate-700 flex items-center justify-between">
                                <span>Data Final (Opcional)</span>
                                <span class="text-[10px] text-slate-400 font-normal">Para cadastrar lote</span>
                            </label>
                            <input
                                type="date"
                                name="data_fim_lote"
                                id="data_fim_lote"
                                class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:ring-1 focus:ring-blue-800 focus:bg-white font-medium"
                                placeholder="Mesmo dia se vazio"
                            />
                        </div>

                        <!-- 7. Município / Local de Atendimento -->
                        <div class="flex flex-col gap-1 lg:col-span-2">
                            <label for="municipio_atendimento" class="text-xs font-bold text-slate-700">
                                Município / Localidade de Atendimento *
                            </label>
                            <input
                                type="text"
                                name="municipio_atendimento"
                                id="municipio_atendimento"
                                value="Salvador - Praça Central"
                                required
                                class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 focus:ring-1 focus:ring-blue-800 focus:bg-white font-medium"
                            />
                        </div>

                    </div>

                    <!-- Rodapé do Formulário -->
                    <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer select-none">
                            <input type="checkbox" name="replicar_dias_uteis" value="1" checked class="rounded border-slate-300 text-blue-900 focus:ring-blue-800 w-4 h-4">
                            <span>Replicar apenas em dias úteis (Segunda a Sexta-feira)</span>
                        </label>

                        <button
                            type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 uppercase tracking-wider cursor-pointer"
                        >
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Cadastrar e Disponibilizar Vagas</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ========================================================================= -->
            <!-- 2. MÉTRICAS E INDICADORES DO MÊS (KPIs) -->
            <!-- ========================================================================= -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: Vagas Ofertadas -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Vagas Ofertadas</span>
                        <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $total_ofertadas }}</span>
                        <span class="text-[11px] text-slate-500">em {{ $dias_atendimento }} dia(s) configurados</span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-800 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[26px]">event_seat</span>
                    </div>
                </div>

                <!-- Card 2: Vagas Preenchidas -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Agendadas / Preenchidas</span>
                        <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $total_preenchidas }}</span>
                        <span class="text-[11px] text-slate-500">pacientes agendados</span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[26px]">how_to_reg</span>
                    </div>
                </div>

                <!-- Card 3: Vagas Restantes -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Vagas Disponíveis</span>
                        <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $total_restantes }}</span>
                        <span class="text-[11px] text-slate-500">livres para agendamento</span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[26px]">event_available</span>
                    </div>
                </div>

                <!-- Card 4: Taxa de Ocupação -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                    <div class="w-full mr-2">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Taxa de Ocupação</span>
                        <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $taxa_ocupacao }}%</span>
                        <div class="w-full bg-slate-100 h-2 rounded-full mt-2 overflow-hidden">
                            <div class="bg-blue-900 h-full rounded-full transition-all duration-500" style="width: {{ min(100, $taxa_ocupacao) }}%"></div>
                        </div>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[26px]">trending_up</span>
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- 3. TABELA DE ACOMPANHAMENTO DO CRONOGRAMA -->
            <!-- ========================================================================= -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                
                <!-- Cabeçalho e Filtros da Tabela -->
                <div class="p-4 sm:p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 uppercase tracking-wide">
                            Acompanhamento de Vagas • {{ \Carbon\Carbon::parse($mes_ano . '-01')->translatedFormat('F / Y') }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ $cronogramas->count() }} registro(s) de cronograma cadastrado(s)
                        </p>
                    </div>

                    <!-- Formulário de Filtro -->
                    <form method="GET" action="{{ route('cronograma.index') }}" class="flex flex-wrap items-center gap-2.5">
                        <input
                            type="month"
                            name="mes_ano"
                            value="{{ $mes_ano }}"
                            onchange="this.form.submit()"
                            class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-800"
                        />

                        @if(count($unidades) > 0)
                            <select
                                name="id_cnes_unidade"
                                onchange="this.form.submit()"
                                class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-700 focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-800"
                            >
                                <option value="">Todas as Unidades</option>
                                @foreach($unidades as $u)
                                    <option value="{{ $u->id_cnes_unidade }}" {{ ($filtros['id_cnes_unidade'] ?? '') == $u->id_cnes_unidade ? 'selected' : '' }}>
                                        {{ $u->nome_unidade }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        @if(count($vagas_tipos) > 0)
                            <select
                                name="id_vagas"
                                onchange="this.form.submit()"
                                class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-700 focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-800"
                            >
                                <option value="">Todos os Exames</option>
                                @foreach($vagas_tipos as $v)
                                    <option value="{{ $v->id_vagas }}" {{ ($filtros['id_vagas'] ?? '') == $v->id_vagas ? 'selected' : '' }}>
                                        {{ $v->tipo_exame }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </form>
                </div>

                <!-- Tabela de Registros -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5">Data / Dia</th>
                                <th class="px-6 py-3.5">Unidade Móvel</th>
                                <th class="px-6 py-3.5">Município / Local</th>
                                <th class="px-6 py-3.5">Exame</th>
                                <th class="px-6 py-3.5">Turno / Horário</th>
                                <th class="px-6 py-3.5 text-center">Vagas Ofertadas</th>
                                <th class="px-6 py-3.5 text-center">Preenchidas</th>
                                <th class="px-6 py-3.5 text-center">Ocupação / Status</th>
                                <th class="px-6 py-3.5 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($cronogramas as $crono)
                                @php
                                    $percent = $crono->qnt_oferecidas_vagas > 0 
                                        ? round(($crono->prenchida_vagas / $crono->qnt_oferecidas_vagas) * 100) 
                                        : 0;
                                    
                                    $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $badgeTexto = 'Disponível';

                                    if ($crono->prenchida_vagas >= $crono->qnt_oferecidas_vagas) {
                                        $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                        $badgeTexto = 'Esgotado';
                                    } elseif ($percent >= 75) {
                                        $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                        $badgeTexto = 'Quase Cheio';
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    
                                    <!-- Data -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-900 text-sm">
                                            {{ \Carbon\Carbon::parse($crono->data_atendimento)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 capitalize">
                                            {{ \Carbon\Carbon::parse($crono->data_atendimento)->translatedFormat('l') }}
                                        </div>
                                    </td>

                                    <!-- Unidade -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-slate-800">
                                            {{ $crono->unidade?->nome_unidade ?? "Unidade Móvel #{$crono->id_cnes_unidade}" }}
                                        </span>
                                        <span class="block text-[11px] text-slate-400">
                                            CNES: {{ $crono->unidade?->codigo_cnes ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <!-- Localidade -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1 text-slate-700">
                                            <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span>
                                            <span>{{ $crono->municipio_atendimento }}</span>
                                        </div>
                                    </td>

                                    <!-- Exame -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($crono->Vagas_id_vagas == 1)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                                                Preventivo (Siscolo)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-pink-50 text-pink-700 border border-pink-200">
                                                Mamografia (Sismama)
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Turno -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 text-xs text-slate-700">
                                            <span class="material-symbols-outlined text-[16px] text-slate-400">schedule</span>
                                            {{ $crono->turno?->turno ?? "Manhã" }}
                                        </span>
                                    </td>

                                    <!-- Vagas Ofertadas -->
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="font-bold text-slate-900 text-sm">{{ $crono->qnt_oferecidas_vagas }}</span>
                                    </td>

                                    <!-- Vagas Preenchidas -->
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="font-bold text-emerald-700 text-sm">{{ $crono->prenchida_vagas }}</span>
                                    </td>

                                    <!-- Status / Ocupação -->
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badgeClass }}">
                                            {{ $badgeTexto }} ({{ $percent }}%)
                                        </span>
                                    </td>

                                    <!-- Ações -->
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button
                                                type="button"
                                                onclick='abrirModalEditar(@json($crono))'
                                                class="p-1.5 text-slate-500 hover:text-blue-900 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer"
                                                title="Editar Vagas"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </button>

                                            <form method="POST" action="{{ route('cronograma.destroy', $crono->id_agenda) }}" onsubmit="return confirm('Deseja excluir as vagas deste dia?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                                                    title="Excluir"
                                                >
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <span class="material-symbols-outlined text-[40px] text-slate-300">event_busy</span>
                                            <p class="text-sm font-semibold text-slate-600">Nenhum cronograma de vagas encontrado para este mês.</p>
                                            <p class="text-xs text-slate-400">Utilize o formulário acima para cadastrar novas datas e vagas de atendimento.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL DE EDIÇÃO DE VAGAS -->
    <!-- ========================================================================= -->
    <div id="modal-editar" class="fixed inset-0 bg-black/40 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden border border-slate-100">
            <div class="bg-blue-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">edit_calendar</span>
                    <h3 class="font-bold text-sm uppercase tracking-wide">Editar Cronograma de Vagas</h3>
                </div>
                <button type="button" onclick="fecharModalEditar()" class="text-white text-xl leading-none">&times;</button>
            </div>

            <form id="form-editar" method="POST" action="" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_cnes_unidade" id="edit_id_cnes_unidade">
                <input type="hidden" name="Vagas_id_vagas" id="edit_Vagas_id_vagas">
                <input type="hidden" name="Turno_id_turno" id="edit_Turno_id_turno">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Data do Atendimento</label>
                    <input type="date" name="data_atendimento" id="edit_data_atendimento" required class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Localidade / Município</label>
                    <input type="text" name="municipio_atendimento" id="edit_municipio_atendimento" required class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 font-medium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Total de Vagas Ofertadas</label>
                        <input type="number" name="qnt_oferecidas_vagas" id="edit_qnt_oferecidas_vagas" min="1" required class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Vagas Já Preenchidas</label>
                        <input type="number" name="prenchida_vagas" id="edit_prenchida_vagas" min="0" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-800 font-bold">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="fecharModalEditar()" class="px-4 py-2 border border-slate-300 bg-white text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50">Cancelar</button>
                    <button type="submit" class="px-5 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-bold rounded-lg shadow-sm">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts de Controle -->
    <script>
        lucide.createIcons();

        // Toggle do Formulário Rápido
        let formAberto = true;
        function toggleFormRapido() {
            const form = document.getElementById('form-cadastro-rapido');
            const icone = document.getElementById('icone-toggle');
            const texto = document.getElementById('texto-toggle');

            if (formAberto) {
                form.classList.add('hidden');
                icone.textContent = 'expand_more';
                texto.textContent = 'Expandir Formulário';
                formAberto = false;
            } else {
                form.classList.remove('hidden');
                icone.textContent = 'expand_less';
                texto.textContent = 'Recolher Formulário';
                formAberto = true;
            }
        }

        // Modal de Edição
        function abrirModalEditar(crono) {
            document.getElementById('form-editar').action = `/cronograma/${crono.id_agenda}`;
            document.getElementById('edit_id_cnes_unidade').value = crono.id_cnes_unidade;
            document.getElementById('edit_Vagas_id_vagas').value = crono.Vagas_id_vagas;
            document.getElementById('edit_Turno_id_turno').value = crono.Turno_id_turno;

            let dataFormatada = crono.data_atendimento;
            if (typeof dataFormatada === 'string' && dataFormatada.length >= 10) {
                dataFormatada = dataFormatada.substring(0, 10);
            }
            document.getElementById('edit_data_atendimento').value = dataFormatada;
            document.getElementById('edit_municipio_atendimento').value = crono.municipio_atendimento;
            document.getElementById('edit_qnt_oferecidas_vagas').value = crono.qnt_oferecidas_vagas;
            document.getElementById('edit_prenchida_vagas').value = crono.prenchida_vagas;

            document.getElementById('modal-editar').classList.remove('hidden');
        }

        function fecharModalEditar() {
            document.getElementById('modal-editar').classList.add('hidden');
        }

        // Controle da Sidebar Mobile
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const mobileClose = document.getElementById('mobile-menu-close');

        if (mobileToggle && sidebar) {
            mobileToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
        if (mobileClose && sidebar) {
            mobileClose.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
            });
        }
    </script>
</body>
</html>
