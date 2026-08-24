<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Anamnese de Colo — Ficha</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            color: #1e293b;
            margin: 30px;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 2px;
        }
        .subtitulo {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 20px;
        }
        .secao {
            margin-bottom: 18px;
        }
        .secao-titulo {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }
        table.dados {
            width: 100%;
            border-collapse: collapse;
        }
        table.dados td {
            padding: 4px 0;
            vertical-align: top;
            width: 50%;
        }
        .rotulo {
            font-size: 9px;
            text-transform: uppercase;
            color: #94a3b8;
            display: block;
        }
        .valor {
            font-size: 12px;
            color: #1e293b;
        }
        .historico-item {
            display: inline-block;
            width: 45%;
            padding: 3px 0;
            font-size: 11px;
        }
        .marcador {
            font-weight: bold;
        }
        .marcador.sim { color: #059669; }
        .marcador.nao { color: #cbd5e1; }
        .rodape {
            margin-top: 30px;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    @php
        $paciente = $anamneseColo->fatoAnamnese?->prontuario?->paciente;
    @endphp

    <h1>Ficha de Anamnese — Coleta de Preventivo</h1>
    <div class="subtitulo">
        Prontuário #{{ $anamneseColo->fatoAnamnese?->id_prontuario ?? '—' }} ·
        Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="secao">
        <div class="secao-titulo">Paciente</div>
        <table class="dados">
            <tr>
                <td>
                    <span class="rotulo">Nome completo</span>
                    <span class="valor">{{ $paciente?->nome_completo ?? '—' }}</span>
                </td>
                <td>
                    <span class="rotulo">CPF</span>
                    <span class="valor">{{ $paciente?->cpf ?? '—' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="rotulo">Cartão SUS</span>
                    <span class="valor">{{ $paciente?->cartao_sus ?? '—' }}</span>
                </td>
                <td>
                    <span class="rotulo">Data de nascimento</span>
                    <span class="valor">{{ optional($paciente?->data_nascimento)->format('d/m/Y') ?? '—' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="secao">
        <div class="secao-titulo">Dados da coleta</div>
        <table class="dados">
            <tr>
                <td>
                    <span class="rotulo">Data da coleta</span>
                    <span class="valor">{{ optional($anamneseColo->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}</span>
                </td>
                <td>
                    <span class="rotulo">Motivo do exame</span>
                    <span class="valor">{{ $anamneseColo->motivo_exame }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="rotulo">Última menstruação</span>
                    <span class="valor">{{ optional($anamneseColo->data_ultima_menstruacao)->format('d/m/Y') ?? '—' }}</span>
                </td>
                <td>
                    <span class="rotulo">Ano do último preventivo</span>
                    <span class="valor">{{ $anamneseColo->ano_ultimo_preventivo ?? '—' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="secao">
        <div class="secao-titulo">Histórico</div>
        @php
            $historico = [
                'Fez preventivo antes?' => $anamneseColo->fez_preventivo_anterior,
                'Está grávida?' => $anamneseColo->esta_gravida,
                'Usa DIU?' => $anamneseColo->usa_diu,
                'Usa pílula?' => $anamneseColo->usa_pilula,
                'Usa hormônio menopausa?' => $anamneseColo->usa_hormonio_menopausa,
                'Já fez radioterapia?' => $anamneseColo->ja_fez_radioterapia,
                'Sangramento após relação?' => $anamneseColo->sangramento_apos_relacao,
                'Sangramento após menopausa?' => $anamneseColo->sangramento_apos_menopausa,
            ];
        @endphp
        @foreach ($historico as $label => $valor)
            <div class="historico-item">
                <span class="marcador {{ $valor ? 'sim' : 'nao' }}">{{ $valor ? '[x]' : '[ ]' }}</span>
                {{ $label }}
            </div>
        @endforeach
    </div>

    <div class="secao">
        <div class="secao-titulo">Exame do colo</div>
        <table class="dados">
            <tr>
                <td>
                    <span class="rotulo">Inspeção do colo</span>
                    <span class="valor">{{ $anamneseColo->inspecao_colo }}</span>
                </td>
                <td>
                    <span class="rotulo">Sinais de DST observados</span>
                    <span class="valor">{{ $anamneseColo->sinais_dst ?? 'Nenhum' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="rodape">
        Documento gerado automaticamente pelo sistema AgendaSaúde. Ficha #{{ $anamneseColo->id_siscolo }}.
    </div>

</body>
</html>