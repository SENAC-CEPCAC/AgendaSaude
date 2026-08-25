<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Geral de Questionários de Anamnese (SISMAMA / SISCOLO)</title>
    <style>
        @page { size: A4 portrait; margin: 10mm 12mm; }
        body { font-family: Arial, sans-serif; color: #0f172a; margin: 0; font-size: 11px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 8px; margin-bottom: 12px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .card { border: 1px solid #cbd5e1; border-radius: 6px; padding: 10px; margin-bottom: 14px; page-break-inside: avoid; }
        .badge-sismama { background: #fdf2f8; color: #be185d; padding: 2px 6px; font-weight: bold; border-radius: 4px; }
        .badge-siscolo { background: #f0fdf4; color: #15803d; padding: 2px 6px; font-weight: bold; border-radius: 4px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 8px; }
        .box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 6px; border-radius: 4px; }
        .sim { color: #dc2626; font-weight: bold; }
        .nao { color: #16a34a; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Agenda Saúde - Relatório Unificado de Anamneses Clínicas</h1>
        <p>Tabelas fato_anamnese, anamnese_sismama e anamnese_siscolo</p>
    </div>

    @foreach($anamneses as $index => $a)
    <div class="card">
        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">
            <strong>{{ $index + 1 }}. {{ $a->nome_paciente }} (Prontuário #{{ $a->numero_sequencial }})</strong>
            <span class="{{ $a->tipo_anamnese === 'sismama' ? 'badge-sismama' : 'badge-siscolo' }}">
                Protocolo {{ strtoupper($a->tipo_anamnese) }}
            </span>
        </div>

        <div style="margin-top: 6px; font-size: 10px; color: #475569;">
            CPF: {{ $a->cpf_paciente }} | SUS: {{ $a->cartao_sus }} | Data: {{ $a->data_realizacao }} | Profissional: {{ $a->nome_profissional }} ({{ $a->crm }}) | Unidade: {{ $a->nome_unidade }}
        </div>

        @if($a->tipo_anamnese === 'sismama')
        <div class="grid">
            <div class="box">Nódulo Mama Direita: <span class="{{ $a->nodulo_mama_direita ? 'sim' : 'nao' }}">{{ $a->nodulo_mama_direita ? 'SIM' : 'NÃO' }}</span></div>
            <div class="box">Nódulo Mama Esquerda: <span class="{{ $a->nodulo_mama_esquerda ? 'sim' : 'nao' }}">{{ $a->nodulo_mama_esquerda ? 'SIM' : 'NÃO' }}</span></div>
            <div class="box">Risco Elevado de Câncer: <span class="{{ $a->risco_elevado_cancer ? 'sim' : 'nao' }}">{{ $a->risco_elevado_cancer ? 'SIM' : 'NÃO' }}</span></div>
            <div class="box">Tipo de Mamografia: {{ $a->tipo_mamografia }} (Anterior: {{ $a->fez_mamografia_anterior ? 'Sim em ' . $a->ano_ultima_mamografia : 'Não' }})</div>
            <div class="box">Localização Nódulo Dir: {{ $a->achado_nodulo_localizacao_dir ?: 'Sem achados' }}</div>
            <div class="box">Linfonodo Axilar: {{ $a->achado_linfonodo_palpavel_dir ?: 'Não palpável' }}</div>
        </div>
        @else
        <div class="grid">
            <div class="box" style="grid-column: span 2;">Motivo do Exame: {{ $a->motivo_exame }}</div>
            <div class="box">Preventivo Anterior: {{ $a->fez_preventivo_anterior ? 'Sim em ' . $a->ano_ultimo_preventivo : 'Primeira vez' }}</div>
            <div class="box">Usa Pílula: {{ $a->usa_pilula ? 'Sim' : 'Não' }} | Usa DIU: {{ $a->usa_diu ? 'Sim' : 'Não' }}</div>
            <div class="box" style="grid-column: span 2;">Inspeção do Colo: {{ $a->inspecao_colo }} (Sinais IST: {{ $a->sinais_dst ? 'Sim' : 'Não' }})</div>
        </div>
        @endif
    </div>
    @endforeach
</body>
</html>