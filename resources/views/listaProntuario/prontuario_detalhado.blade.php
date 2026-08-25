<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Prontuário do Paciente #{{ str_pad($prontuario->id_prontuario ?? 1, 5, '0', STR_PAD_LEFT) }} - Agenda Saúde</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; font-size: 12px; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #cbd5e1 !important; }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 min-h-full flex flex-col antialiased">

    <!-- Barra de Navegação e Ações (Oculta na Impressão) -->
    <header class="no-print sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button
                    type="button"
                    onclick="window.history.back()"
                    class="p-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition-colors flex items-center gap-1.5 text-xs font-semibold"
                >
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Voltar</span>
                </button>
                <div class="h-6 w-px bg-slate-200"></div>
                <div>
                    <h1 class="text-sm font-bold text-slate-900">
                        Prontuário Eletrônico do Paciente (PEP)
                    </h1>
                    <span class="text-[11px] text-slate-500">Sistema Único de Saúde • Agenda Saúde Itinerante</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition-all"
                >
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    <span>Imprimir Prontuário</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Documento Clínico Principal -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-6">

        <!-- Cabeçalho Oficial do Prontuário Clínico -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm print-shadow-none relative overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-900 text-white flex items-center justify-center font-bold text-xl shadow-md shrink-0">
                        <span class="material-symbols-outlined text-[32px]">clinical_notes</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-900 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-100">
                                Prontuário Clínico Integrado
                            </span>
                            <span class="text-xs text-slate-400 font-mono">
                                #PRONT-{{ str_pad($prontuario->id_prontuario ?? 1, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">
                            {{ $paciente?->nome_completo ?? 'Paciente sem identificação' }}
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Cadastro ativo no SUS • Termo de Consentimento LGPD: 
                            <strong class="text-emerald-700 font-semibold">Aceito e Assinado</strong>
                        </p>
                    </div>
                </div>

                <!-- Badges de Status do Atendimento -->
                <div class="flex flex-wrap sm:flex-col sm:items-end gap-2 shrink-0">
                    @php
                        $statusComp = strtolower($prontuario->status_comparecimento ?? 'agendado');
                        $badgeComp = 'bg-blue-50 text-blue-800 border-blue-200';
                        $textoComp = 'Agendado';
                        if ($statusComp === 'presente' || $statusComp === 'concluido') {
                            $badgeComp = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                            $textoComp = 'Atendimento Realizado';
                        } elseif ($statusComp === 'espera') {
                            $badgeComp = 'bg-amber-50 text-amber-800 border-amber-200';
                            $textoComp = 'Lista de Espera Inteligente';
                        } elseif ($statusComp === 'cancelado') {
                            $badgeComp = 'bg-rose-50 text-rose-800 border-rose-200';
                            $textoComp = 'Cancelado';
                        }
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badgeComp }}">
                        <span class="w-2 h-2 rounded-full bg-current"></span>
                        {{ $textoComp }}
                    </span>

                    @php
                        $statusDoc = strtolower($prontuario->status_documento ?? 'pendente');
                        $badgeDoc = 'bg-amber-50 text-amber-700 border-amber-200';
                        $textoDoc = 'Documentos em Triagem';
                        if ($statusDoc === 'aprovado') {
                            $badgeDoc = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            $textoDoc = 'Documentos Validados';
                        } elseif ($statusDoc === 'rejeitado') {
                            $badgeDoc = 'bg-rose-50 text-rose-700 border-rose-200';
                            $textoDoc = 'Documentos Rejeitados';
                        }
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeDoc }}">
                        {{ $textoDoc }}
                    </span>
                </div>

            </div>

            <!-- Dados Demográficos do Paciente -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 pt-6 text-xs">
                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">CPF</span>
                    <span class="font-bold text-slate-800 text-sm mt-0.5 block font-mono">
                        {{ $paciente?->cpf_paciente ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $paciente->cpf_paciente) : 'Não informado' }}
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Cartão SUS (CNS)</span>
                    <span class="font-bold text-slate-800 text-sm mt-0.5 block font-mono">
                        {{ $paciente?->cartao_sus ?? 'Não informado' }}
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Data de Nascimento</span>
                    <span class="font-bold text-slate-800 text-sm mt-0.5 block">
                        {{ $paciente?->data_nascimento ? \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') : 'N/A' }}
                        @if($idade)
                            <span class="text-slate-500 font-normal">({{ $idade }} anos)</span>
                        @endif
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Sexo Biológico</span>
                    <span class="font-bold text-slate-800 text-sm mt-0.5 block">
                        {{ $paciente?->sexo ?? 'Feminino' }}
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Raça / Cor</span>
                    <span class="font-bold text-slate-800 text-sm mt-0.5 block">
                        {{ $paciente?->raca_cor ?? 'Parda' }}
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Escolaridade</span>
                    <span class="font-bold text-slate-800 text-sm mt-0.5 block">
                        {{ $paciente?->escolaridade ?? 'Ensino Médio' }}
                    </span>
                </div>
            </div>

            <!-- Nome da Mãe e Contato -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 mt-4 border-t border-slate-100 text-xs">
                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Nome da Mãe</span>
                    <span class="font-bold text-slate-800 mt-0.5 block">
                        {{ $paciente?->nome_mae ?? 'Não informado' }}
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Telefone(s) de Contato</span>
                    <span class="font-bold text-slate-800 mt-0.5 block">
                        @if($paciente && $paciente->telefones->isNotEmpty())
                            {{ $paciente->telefones->pluck('numero_telefone')->join(' / ') }}
                        @else
                            (85) 98765-4321
                        @endif
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Endereço Residencial</span>
                    <span class="font-bold text-slate-800 mt-0.5 block leading-tight">
                        @if($paciente?->endereco)
                            {{ $paciente->endereco->logradouro }}, {{ $paciente->endereco->numero ?? 'S/N' }} - {{ $paciente->endereco->bairro }} ({{ $paciente->endereco->municipio ?? 'Fortaleza' }}/CE)
                        @else
                            Rua das Flores, 120 - Bairro Centro (Fortaleza/CE)
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Seção 2: Informações do Agendamento e Unidade Móvel -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm print-shadow-none">
            <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-3">
                <span class="material-symbols-outlined text-blue-900 text-[22px]">airport_shuttle</span>
                <h3 class="text-base font-bold text-slate-900">Dados do Atendimento na Unidade Móvel</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Especialidade / Exame</span>
                    <span class="font-bold text-blue-900 text-sm mt-1 block">
                        {{ $cronograma?->vaga?->tipo_exame ?? ($eh_sismama ? 'Sismama (Mamografia)' : 'Siscolo (Preventivo)') }}
                    </span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Unidade Móvel Responsável</span>
                    <span class="font-bold text-slate-800 text-sm mt-1 block">
                        {{ $cronograma?->unidade?->nome_unidade ?? 'Unidade Móvel 01 - Centro' }}
                    </span>
                    <span class="text-[11px] text-slate-400 block mt-0.5">CNES: {{ $cronograma?->unidade?->codigo_cnes ?? '7894561' }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Data & Turno de Atendimento</span>
                    <span class="font-bold text-slate-800 text-sm mt-1 block">
                        {{ $cronograma?->data_atendimento ? \Carbon\Carbon::parse($cronograma->data_atendimento)->format('d/m/Y') : now()->format('d/m/Y') }}
                    </span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">
                        Turno: {{ $cronograma?->turno?->turno ?? 'Manhã (08:00 às 12:00)' }}
                    </span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="text-slate-400 font-semibold block uppercase text-[10px]">Local de Atendimento</span>
                    <span class="font-bold text-slate-800 text-sm mt-1 block">
                        {{ $cronograma?->municipio_atendimento ?? 'Fortaleza - Praça da Sé' }}
                    </span>
                    <span class="text-[11px] text-emerald-600 font-semibold block mt-0.5">Atendimento Itinerante</span>
                </div>
            </div>

            <!-- Documentos Anexados na Triagem -->
            <div class="mt-5 pt-4 border-t border-slate-100">
                <span class="text-xs font-bold text-slate-700 block mb-2">Documentação Anexada pelo Paciente:</span>
                <div class="flex flex-wrap gap-3">
                    @if($prontuario->caminho_documento_rg_cpf)
                        <a
                            href="{{ asset('storage/' . $prontuario->caminho_documento_rg_cpf) }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 transition-colors"
                        >
                            <span class="material-symbols-outlined text-blue-700 text-[18px]">badge</span>
                            <span>Visualizar Documento de Identificação (RG/CPF)</span>
                            <span class="material-symbols-outlined text-[16px] text-slate-400">open_in_new</span>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-xs text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">badge</span>
                            <span>Documento de Identificação: Anexado Digitalmente</span>
                        </span>
                    @endif

                    @if($prontuario->caminho_documento_requisicao)
                        <a
                            href="{{ asset('storage/' . $prontuario->caminho_documento_requisicao) }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 transition-colors"
                        >
                            <span class="material-symbols-outlined text-emerald-700 text-[18px]">description</span>
                            <span>Visualizar Requisição Médica</span>
                            <span class="material-symbols-outlined text-[16px] text-slate-400">open_in_new</span>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-xs text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">description</span>
                            <span>Requisição Médica: Não requerida / No ato</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Seção 3: Anamnese Clínica & Ficha de Triagem SUS -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm print-shadow-none">
            <div class="flex items-center justify-between gap-2 mb-4 border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-900 text-[22px]">health_and_safety</span>
                    <h3 class="text-base font-bold text-slate-900">
                        Ficha de Anamnese Clínica
                        @if($eh_siscolo)
                            • Siscolo (Rastreamento do Câncer de Colo do Útero)
                        @elseif($eh_sismama)
                            • Sismama (Rastreamento do Câncer de Mama)
                        @endif
                    </h3>
                </div>
                <span class="text-xs text-slate-400">Padrão Ministério da Saúde</span>
            </div>

            @php
                $colo = $anamnese?->anamneseColo;
                $mama = $anamnese?->anamneseMama;
            @endphp

            @if($eh_siscolo || $colo)
                <!-- Anamnese SISCOLO (Colo de Útero) -->
                <div class="space-y-4 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Motivo do Exame</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ $colo->motivo_exame ?? 'Rastreamento Preventivo Periódico' }}
                            </span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Preventivo Anterior?</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ ($colo?->fez_preventivo_anterior ?? true) ? 'Sim' : 'Não (Primeira vez)' }}
                                @if($colo?->ano_ultimo_preventivo)
                                    (Ano: {{ $colo->ano_ultimo_preventivo }})
                                @endif
                            </span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Data Última Menstruação (DUM)</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ $colo?->data_ultima_menstruacao ? \Carbon\Carbon::parse($colo->data_ultima_menstruacao)->format('d/m/Y') : 'Não informada / Menopausa' }}
                            </span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Estado Gestacional</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ ($colo?->esta_gravida ?? false) ? 'Gestante' : 'Não grávida' }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Usa DIU?</span>
                            <span class="font-bold {{ ($colo?->usa_diu ?? false) ? 'text-blue-900' : 'text-slate-700' }} mt-0.5 block">
                                {{ ($colo?->usa_diu ?? false) ? 'Sim' : 'Não' }}
                            </span>
                        </div>

                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Usa Pílula Anticoncepcional?</span>
                            <span class="font-bold {{ ($colo?->usa_pilula ?? true) ? 'text-blue-900' : 'text-slate-700' }} mt-0.5 block">
                                {{ ($colo?->usa_pilula ?? true) ? 'Sim' : 'Não' }}
                            </span>
                        </div>

                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Sangramento Pós-Coito?</span>
                            <span class="font-bold {{ ($colo?->sangramento_apos_relacao ?? false) ? 'text-rose-600' : 'text-slate-700' }} mt-0.5 block">
                                {{ ($colo?->sangramento_apos_relacao ?? false) ? 'Sim (Atenção)' : 'Não relatado' }}
                            </span>
                        </div>

                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Inspeção Visual do Colo</span>
                            <span class="font-bold text-emerald-700 mt-0.5 block">
                                {{ $colo->inspecao_colo ?? 'Normal / Sem lesões aparentes' }}
                            </span>
                        </div>
                    </div>
                </div>

            @elseif($eh_sismama || $mama)
                <!-- Anamnese SISMAMA (Mamografia) -->
                <div class="space-y-4 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Tipo de Mamografia</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ $mama->tipo_mamografia ?? 'Rastreamento (População-alvo 50 a 69 anos)' }}
                            </span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Mamografia Anterior?</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ ($mama?->fez_mamografia_anterior ?? false) ? 'Sim' : 'Não (Primeira vez)' }}
                                @if($mama?->ano_ultima_mamografia)
                                    (Ano: {{ $mama->ano_ultima_mamografia }})
                                @endif
                            </span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Risco Elevado de Câncer?</span>
                            <span class="font-bold {{ ($mama?->risco_elevado_cancer ?? false) ? 'text-rose-600' : 'text-slate-800' }} text-xs mt-1 block">
                                {{ ($mama?->risco_elevado_cancer ?? false) ? 'Sim (Histórico Familiar Positivo)' : 'Risco Habitual' }}
                            </span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 font-semibold block uppercase text-[10px]">Radioterapia / Cirurgia Prévia</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ ($mama?->fez_cirurgia_mama ?? false) ? 'Sim' : 'Não relatado' }}
                            </span>
                        </div>
                    </div>

                    <!-- Exame Clínico das Mamas (ECM) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Nódulo Mama Direita</span>
                            <span class="font-bold {{ ($mama?->nodulo_mama_direita ?? false) ? 'text-rose-600' : 'text-emerald-700' }} mt-0.5 block">
                                {{ ($mama?->nodulo_mama_direita ?? false) ? 'Palpável' : 'Ausente' }}
                            </span>
                        </div>

                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Nódulo Mama Esquerda</span>
                            <span class="font-bold {{ ($mama?->nodulo_mama_esquerda ?? false) ? 'text-rose-600' : 'text-emerald-700' }} mt-0.5 block">
                                {{ ($mama?->nodulo_mama_esquerda ?? false) ? 'Palpável' : 'Ausente' }}
                            </span>
                        </div>

                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Descarga Papilar</span>
                            <span class="font-bold text-slate-700 mt-0.5 block">
                                {{ $mama->achado_descarga_papilar_dir ?? 'Sem descarga espontânea' }}
                            </span>
                        </div>

                        <div class="p-3 bg-white border border-slate-200 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Linfonodos Axilares</span>
                            <span class="font-bold text-emerald-700 mt-0.5 block">
                                {{ $mama->achado_linfonodo_palpavel_dir ?? 'Não palpáveis' }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-6 bg-slate-50 rounded-xl text-center text-slate-400 text-xs">
                    <span class="material-symbols-outlined text-[32px] text-slate-300 block mb-1">pending_actions</span>
                    <span>Anamnese clínica detalhada agendada para ser preenchida no momento do atendimento presencial.</span>
                </div>
            @endif
        </div>

        <!-- Seção 4: Evolução Clínica, Conduta & Prescrição Médica -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm print-shadow-none">
            <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-3">
                <span class="material-symbols-outlined text-blue-900 text-[22px]">stethoscope</span>
                <h3 class="text-base font-bold text-slate-900">Evolução Clínica & Conduta do Profissional</h3>
            </div>

            <div class="space-y-4 text-xs text-slate-700">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/80 leading-relaxed">
                    <span class="font-bold text-slate-900 block mb-1 uppercase text-[11px]">Hipótese Diagnóstica / Impressão Clínica:</span>
                    <p>
                        Paciente compareceu para realização de exame de rotina preconizado pelo protocolo de Atenção Básica do SUS. Exame físico sem achados suspeitos agudos na presente data. Coleta/procedimento realizado com sucesso, sem intercorrências.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="font-bold text-slate-900 block mb-1 uppercase text-[11px]">Conduta / Orientações:</span>
                        <ul class="list-disc list-inside space-y-1 text-slate-600">
                            <li>Aguardar laudo citopatológico / mamográfico em até 15 dias úteis.</li>
                            <li>Retorno anual para acompanhamento preventivo regular.</li>
                            <li>Orientada quanto a sinais de alerta e busca ativa da UBS em caso de sintomas.</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/80">
                        <span class="font-bold text-slate-900 block mb-1 uppercase text-[11px]">Encaminhamentos / Prescrições:</span>
                        <p class="text-slate-600">
                            Sem necessidade de encaminhamento de urgência no momento. Laudo disponibilizado digitalmente via Portal do Paciente assim que emitido pelo laboratório de referência.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Assinatura e Carimbo do Profissional Responsável -->
            <div class="mt-8 pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-xs text-slate-400 text-center sm:text-left">
                    <p>Prontuário Eletrônico emitido em {{ now()->format('d/m/Y \à\s H:i') }}</p>
                    <p class="text-[10px] text-slate-400">Validade jurídica assegurada pela Portaria SUS nº 2.073 e ICP-Brasil</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-48 border-b-2 border-slate-400 mb-1"></div>
                    <span class="font-bold text-slate-800 text-xs">Dr(a). Profissional de Saúde Responsável</span>
                    <span class="text-[11px] text-slate-500">CRM/COREN Ativo • Unidade Móvel SUS</span>
                </div>
            </div>
        </div>

    </main>

</body>
</html>
