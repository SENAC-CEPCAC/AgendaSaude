<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Anamnese de Mamografia</title>
  <style>
    /*
      IMPORTANTE: o dompdf não executa JavaScript, então o Tailwind
      via <script src="cdn.tailwindcss.com"> NÃO funciona aqui.
      Por isso, esse arquivo usa CSS normal, escrito à mão.
      O dompdf também tem suporte limitado a CSS moderno (flexbox e
      grid são parciais), então evitamos essas propriedades e usamos
      table/blocos simples, que é o que funciona de forma confiável.
    */
    body {
      font-family: Helvetica, Arial, sans-serif;
      color: #1e293b; /* slate-800 */
      font-size: 12px;
      margin: 30px;
    }
    h1 {
      font-size: 16px;
      font-weight: 600;
      margin: 0 0 4px 0;
    }
    .subtitulo {
      color: #94a3b8; /* slate-400 */
      font-size: 11px;
      margin: 0 0 20px 0;
    }
    .secao {
      border: 1px solid #f1f5f9; /* slate-100 */
      border-radius: 6px;
      padding: 14px 16px;
      margin-bottom: 14px;
    }
    .secao-titulo {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #94a3b8;
      margin: 0 0 10px 0;
    }
    table.campos {
      width: 100%;
      border-collapse: collapse;
    }
    table.campos td {
      padding: 4px 10px 10px 0;
      vertical-align: top;
      width: 33%;
    }
    .campo-label {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #94a3b8;
      display: block;
      margin-bottom: 2px;
    }
    .campo-valor {
      font-size: 12px;
      color: #334155; /* slate-700 */
    }
    .historico-item {
      display: inline-block;
      border: 1px solid #e2e8f0; /* slate-200 */
      border-radius: 6px;
      padding: 4px 10px;
      margin: 0 6px 6px 0;
      font-size: 11px;
    }
    .marcado { color: #059669; font-weight: bold; } /* emerald-600 */
    .nao-marcado { color: #cbd5e1; } /* slate-300 */
    .rodape {
      margin-top: 30px;
      font-size: 10px;
      color: #94a3b8;
      border-top: 1px solid #f1f5f9;
      padding-top: 10px;
    }
  </style>
</head>
<body>

  @php
    $fato = $anamneseMama->fatoAnamnese;
    $paciente = $fato?->prontuario?->paciente;
  @endphp

  <h1>Anamnese · Solicitação de mamografia</h1>
  <p class="subtitulo">
    {{ $paciente?->nome_completo ?? '—' }}
    · CPF {{ $paciente?->cpf ?? '—' }}
    · {{ optional($fato?->data_realizacao)->format('d/m/Y') ?? '—' }}
  </p>

  <!-- ---------- Dados da solicitação ---------- -->
  <div class="secao">
    <p class="secao-titulo">Dados da solicitação</p>
    <table class="campos">
      <tr>
        <td>
          <span class="campo-label">Data da solicitação</span>
          <span class="campo-valor">{{ optional($fato?->data_realizacao)->format('d/m/Y') ?? '—' }}</span>
        </td>
        <td>
          <span class="campo-label">Tipo de mamografia</span>
          <span class="campo-valor">{{ $anamneseMama->tipo_mamografia ?? '—' }}</span>
        </td>
      </tr>
    </table>
  </div>

  <!-- ---------- Histórico ---------- -->
  <div class="secao">
    <p class="secao-titulo">Histórico</p>

    @php
      $historico = [
        'Nódulo mama direita?' => $anamneseMama->nodulo_mama_direita,
        'Nódulo mama esquerda?' => $anamneseMama->nodulo_mama_esquerda,
        'Risco elevado câncer?' => $anamneseMama->risco_elevado_cancer,
        'Mamas já examinadas?' => $anamneseMama->mamas_examinadas_anteriormente,
        'Fez mamografia antes?' => $anamneseMama->fez_mamografia_anterior,
        'Já fez radioterapia?' => $anamneseMama->fez_radioterapia_mama,
        'Já fez cirurgia na mama?' => $anamneseMama->fez_cirurgia_mama,
      ];
    @endphp

    <div>
      @foreach ($historico as $label => $valor)
        <span class="historico-item">
          <span class="{{ $valor ? 'marcado' : 'nao-marcado' }}">{{ $valor ? 'Sim' : 'Não' }}</span>
          — {{ $label }}
        </span>
      @endforeach
    </div>

    <table class="campos" style="margin-top: 10px;">
      <tr>
        <td>
          <span class="campo-label">Ano da última mamografia</span>
          <span class="campo-valor">{{ $anamneseMama->ano_ultima_mamografia ?? '—' }}</span>
        </td>
      </tr>
    </table>
  </div>

  <!-- ---------- Achados clínicos ---------- -->
  <div class="secao">
    <p class="secao-titulo">Achados clínicos</p>
    <table class="campos">
      <tr>
        <td>
          <span class="campo-label">Descarga papilar — Dir</span>
          <span class="campo-valor">{{ $anamneseMama->achado_descarga_papilar_dir ?? '—' }}</span>
        </td>
        <td>
          <span class="campo-label">Nódulo · localização — Dir</span>
          <span class="campo-valor">{{ $anamneseMama->achado_nodulo_localizacao_dir ?? '—' }}</span>
        </td>
        <td>
          <span class="campo-label">Linfonodo palpável — Dir</span>
          <span class="campo-valor">{{ $anamneseMama->achado_linfonodo_palpavel_dir ?? '—' }}</span>
        </td>
      </tr>
      <tr>
        <td>
          <span class="campo-label">Descarga papilar — Esq</span>
          <span class="campo-valor">{{ $anamneseMama->achado_descarga_papilar_esq ?? '—' }}</span>
        </td>
        <td>
          <span class="campo-label">Nódulo · localização — Esq</span>
          <span class="campo-valor">{{ $anamneseMama->achado_nodulo_localizacao_esq ?? '—' }}</span>
        </td>
        <td>
          <span class="campo-label">Linfonodo palpável — Esq</span>
          <span class="campo-valor">{{ $anamneseMama->achado_linfonodo_palpavel_esq ?? '—' }}</span>
        </td>
      </tr>
    </table>
  </div>

  <p class="rodape">
    Documento gerado em {{ now()->format('d/m/Y \à\s H:i') }} · Portal Gestão
  </p>

</body>
</html>