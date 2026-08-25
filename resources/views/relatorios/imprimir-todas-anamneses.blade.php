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
        .badge-sismama { background: #fdf2f8; color: #be185d; padding: 2px 6px; font-weight: bold; border-radius: 4px; font-size: 10px; }
        .badge-siscolo { background: #f0fdf4; color: #15803d; padding: 2px 6px; font-weight: bold; border-radius: 4px; font-size: 10px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-top: 8px; }
        .box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 6px; border-radius: 4px; font-size: 10.5px; }
        .box-title { font-weight: bold; color: #475569; font-size: 10px; text-transform: uppercase; margin-bottom: 2px; }
        .sim { color: #dc2626; font-weight: bold; }
        .nao { color: #16a34a; font-weight: 600; }
        .destaque { font-weight: bold; color: #0f172a; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Agenda Saúde - Relatório Unificado de Anamneses Clínicas</h1>
        <p>Dados oficiais integrados das tabelas fato_anamnese, anamnese_sismama e anamnese_siscolo</p>
    </div>

    @foreach($anamneses as $index => $a)
    <div class="card">
        <!-- Cabeçalho do Prontuário e Paciente -->
        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">
            <strong>{{ $index + 1 }}. {{ $a->nome_paciente }} (Prontuário #{{ $a->numero_sequencial ?? $a->id_prontuario }})</strong>
            <span class="{{ $a->tipo_anamnese === 'sismama' ? 'badge-sismama' : 'badge-siscolo' }}">
                Protocolo Oficial {{ strtoupper($a->tipo_anamnese) }}
            </span>
        </div>

        <div style="margin-top: 6px; font-size: 10px; color: #475569;">
            <strong>CPF:</strong> {{ $a->cpf_paciente }} | 
            <strong>SUS:</strong> {{ $a->cartao_sus ?? 'Não informado' }} | 
            <strong>Data:</strong> {{ $a->data_realizacao }} | 
            <strong>Profissional:</strong> {{ $a->nome_profissional }} ({{ $a->crm }}) | 
            <strong>Unidade:</strong> {{ $a->nome_unidade ?? 'Unidade Geral' }}
        </div>

        <!-- 1. TODOS OS DADOS DA MIGRATION anamnese_sismama -->
        @if($a->tipo_anamnese === 'sismama')
        <div class="grid">
            <div class="box">
                <div class="box-title">1. Nódulo Mama Direita</div>
                <span class="{{ $a->nodulo_mama_direita ? 'sim' : 'nao' }}">{{ $a->nodulo_mama_direita ? 'SIM (Presente)' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">2. Nódulo Mama Esquerda</div>
                <span class="{{ $a->nodulo_mama_esquerda ? 'sim' : 'nao' }}">{{ $a->nodulo_mama_esquerda ? 'SIM (Presente)' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">3. Risco Elevado de Câncer</div>
                <span class="{{ $a->risco_elevado_cancer ? 'sim' : 'nao' }}">{{ $a->risco_elevado_cancer ? 'SIM (Histórico Positivo)' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">4. Mamas Examinadas Anteriormente</div>
                <span class="{{ $a->mamas_examinadas_anteriormente ? 'sim' : 'nao' }}">{{ $a->mamas_examinadas_anteriormente ? 'SIM' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">5. Tipo de Mamografia</div>
                <span class="destaque">{{ $a->tipo_mamografia ?? 'Rastreamento' }}</span>
            </div>
            <div class="box">
                <div class="box-title">6. Mamografia Anterior / Ano</div>
                <span class="destaque">{{ $a->fez_mamografia_anterior ? 'Sim (Ano: ' . ($a->ano_ultima_mamografia ?? 'N/I') . ')' : 'Não realizou' }}</span>
            </div>
            <div class="box">
                <div class="box-title">7. Radioterapia na Mama</div>
                <span class="{{ $a->fez_radioterapia_mama ? 'sim' : 'nao' }}">{{ $a->fez_radioterapia_mama ? 'SIM' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">8. Cirurgia na Mama</div>
                <span class="{{ $a->fez_cirurgia_mama ? 'sim' : 'nao' }}">{{ $a->fez_cirurgia_mama ? 'SIM' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">9. Descarga Papilar (Direita / Esquerda)</div>
                <span class="destaque">Dir: {{ $a->achado_descarga_papilar_dir ?: 'Sem achados' }} | Esq: {{ $a->achado_descarga_papilar_esq ?: 'Sem achados' }}</span>
            </div>
            <div class="box">
                <div class="box-title">10. Localização do Nódulo (Direita / Esquerda)</div>
                <span class="destaque">Dir: {{ $a->achado_nodulo_localizacao_dir ?: 'Sem nódulo' }} | Esq: {{ $a->achado_nodulo_localizacao_esq ?: 'Sem nódulo' }}</span>
            </div>
            <div class="box" style="grid-column: span 2;">
                <div class="box-title">11. Linfonodo Axilar Palpável (Direita / Esquerda)</div>
                <span class="destaque">Dir: {{ $a->achado_linfonodo_palpavel_dir ?: 'Não palpável' }} | Esq: {{ $a->achado_linfonodo_palpavel_esq ?: 'Não palpável' }}</span>
            </div>
        </div>

        <!-- 2. TODOS OS DADOS DA MIGRATION anamnese_siscolo -->
        @else
        <div class="grid">
            <div class="box" style="grid-column: span 2;">
                <div class="box-title">1. Motivo do Exame</div>
                <span class="destaque">{{ $a->motivo_exame ?? 'Exame Citopatológico de Rotina' }}</span>
            </div>
            <div class="box">
                <div class="box-title">2. Fez Preventivo Anterior / Ano</div>
                <span class="destaque">{{ $a->fez_preventivo_anterior ? 'Sim (Ano: ' . ($a->ano_ultimo_preventivo ?? 'N/I') . ')' : 'Não (Primeira vez)' }}</span>
            </div>
            <div class="box">
                <div class="box-title">3. Data da Última Menstruação (DUM)</div>
                <span class="destaque">{{ $a->data_ultima_menstruacao ? \Carbon\Carbon::parse($a->data_ultima_menstruacao)->format('d/m/Y') : 'Não informada / Menopausa' }}</span>
            </div>
            <div class="box">
                <div class="box-title">4. Uso de Contraceptivos</div>
                <span class="destaque">Pílula: <strong class="{{ $a->usa_pilula ? 'sim' : 'nao' }}">{{ $a->usa_pilula ? 'Sim' : 'Não' }}</strong> | DIU: <strong class="{{ $a->usa_diu ? 'sim' : 'nao' }}">{{ $a->usa_diu ? 'Sim' : 'Não' }}</strong></span>
            </div>
            <div class="box">
                <div class="box-title">5. Gravidez Atual / Hormônio Menopausa</div>
                <span class="destaque">Grávida: <strong class="{{ $a->esta_gravida ? 'sim' : 'nao' }}">{{ $a->esta_gravida ? 'Sim' : 'Não' }}</strong> | Hormônio: <strong class="{{ $a->usa_hormonio_menopausa ? 'sim' : 'nao' }}">{{ $a->usa_hormonio_menopausa ? 'Sim' : 'Não' }}</strong></span>
            </div>
            <div class="box">
                <div class="box-title">6. Já Fez Radioterapia</div>
                <span class="{{ $a->ja_fez_radioterapia ? 'sim' : 'nao' }}">{{ $a->ja_fez_radioterapia ? 'SIM' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">7. Sinais de IST / DST</div>
                <span class="{{ $a->sinais_dst ? 'sim' : 'nao' }}">{{ $a->sinais_dst ? 'SIM (Presentes)' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">8. Sangramento Após Relação Sexual</div>
                <span class="{{ $a->sangramento_apos_relacao ? 'sim' : 'nao' }}">{{ $a->sangramento_apos_relacao ? 'SIM' : 'NÃO' }}</span>
            </div>
            <div class="box">
                <div class="box-title">9. Sangramento Após Menopausa</div>
                <span class="{{ $a->sangramento_apos_menopausa ? 'sim' : 'nao' }}">{{ $a->sangramento_apos_menopausa ? 'SIM' : 'NÃO' }}</span>
            </div>
            <div class="box" style="grid-column: span 2;">
                <div class="box-title">10. Inspeção do Colo do Útero</div>
                <span class="destaque">{{ $a->inspecao_colo ?: 'Colo sem alterações aparentes' }}</span>
            </div>
        </div>
        @endif
    </div>
    @endforeach
</body>
</html>