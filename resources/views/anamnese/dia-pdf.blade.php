<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Relatório de Exames do Dia</title>
  <style>
    /*
      Assim como no PDF individual da mamografia: dompdf não roda
      JavaScript, então nada de Tailwind CDN aqui — só CSS puro,
      com suporte limitado a flexbox/grid (por isso usamos <table>
      pra estruturar o layout, que é o que funciona de forma confiável).
    */
    body {
      font-family: Helvetica, Arial, sans-serif;
      color: #1e293b;
      font-size: 11px;
      margin: 30px;
    }
    h1 {
      font-size: 16px;
      font-weight: 600;
      margin: 0 0 4px 0;
    }
    .subtitulo {
      color: #64748b;
      font-size: 11px;
      margin: 0 0 20px 0;
    }
    table.relatorio {
      width: 100%;
      border-collapse: collapse;
    }
    table.relatorio th {
      text-align: left;
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.03em;
      color: #64748b;
      background-color: #f8fafc;
      padding: 8px 10px;
      border-bottom: 1px solid #e2e8f0;
    }
    table.relatorio td {
      padding: 8px 10px;
      border-bottom: 1px solid #f1f5f9;
      vertical-align: top;
    }
    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 9px;
      font-weight: bold;
    }
    .badge-colo {
      background-color: #eff6ff;
      color: #1d4ed8;
    }
    .badge-mama {
      background-color: #fff1f2;
      color: #be123c;
    }
    .resumo {
      margin-top: 6px;
      margin-bottom: 18px;
      font-size: 11px;
      color: #475569;
    }
    .rodape {
      margin-top: 24px;
      font-size: 9px;
      color: #94a3b8;
      border-top: 1px solid #f1f5f9;
      padding-top: 8px;
    }
  </style>
</head>
<body>

  <h1>Relatório de Exames</h1>
  <p class="subtitulo">
    @if ($dataInicio === $dataFim)
      Data de referência: {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}
    @else
      Período: {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}
      a {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
    @endif
  </p>

  <p class="resumo">
    Total de exames: <strong>{{ $anamneses->count() }}</strong>
    — Preventivo (Colo): <strong>{{ $anamneses->where('tipo_anamnese', 'siscolo')->count() }}</strong>
    — Mamografia: <strong>{{ $anamneses->where('tipo_anamnese', 'sismama')->count() }}</strong>
  </p>

  @if ($anamneses->isEmpty())
    <p>Nenhum exame registrado nesta data.</p>
  @else
    <table class="relatorio">
      <thead>
        <tr>
          <th style="width: 28%;">Paciente</th>
          <th style="width: 18%;">CPF</th>
          <th style="width: 16%;">Tipo</th>
          <th style="width: 12%;">Data</th>
          <th style="width: 26%;">Observações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($anamneses as $anamnese)
          @php
            $paciente = $anamnese->prontuario?->paciente;
            $ehColo = $anamnese->tipo_anamnese === 'siscolo';
            $ehMama = $anamnese->tipo_anamnese === 'sismama';

            // Uma observação curta e útil por tipo, pra dar contexto no relatório
            // sem precisar entrar nos detalhes de cada paciente.
            $observacao = '—';
            if ($ehColo && $anamnese->anamneseColo) {
                $observacao = $anamnese->anamneseColo->motivo_exame ?? '—';
            } elseif ($ehMama && $anamnese->anamneseMama) {
                $observacao = $anamnese->anamneseMama->tipo_mamografia ?? '—';
            }
          @endphp
          <tr>
            <td>{{ $paciente?->nome_completo ?? '—' }}</td>
            <td>{{ $paciente?->cpf ?? '—' }}</td>
            <td>
              @if ($ehColo)
                <span class="badge badge-colo">Preventivo (Colo)</span>
              @elseif ($ehMama)
                <span class="badge badge-mama">Mamografia</span>
              @else
                {{ $anamnese->tipo_anamnese }}
              @endif
            </td>
            <td>{{ optional($anamnese->data_realizacao)->format('d/m/Y') ?? '—' }}</td>
            <td>{{ $observacao }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <p class="rodape">
    Relatório gerado em {{ now()->format('d/m/Y \à\s H:i') }} · Portal Gestão
  </p>

</body>
</html>