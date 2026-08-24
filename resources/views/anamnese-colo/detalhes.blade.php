@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>
  <div class="mx-auto max-w-3xl px-8 py-8">
    <header class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold text-slate-800">
          Anamnese · Detalhes
        </h1>
        <p class="mt-1 text-sm text-slate-400">
          Prontuário #{{ $anamneseColo->fatoAnamnese?->id_prontuario ?? '—' }} ·
          {{ optional($anamneseColo->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}
        </p>
      </div>
      <a href="{{ route('anamnese-colo.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
        ← Voltar à lista
      </a>
    </header>

    @php
      $paciente = $anamneseColo->fatoAnamnese?->prontuario?->paciente;
    @endphp

    <div class="flex flex-col gap-5">
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Paciente
        </p>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Nome completo</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $paciente?->nome_completo ?? '—' }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">CPF</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $paciente?->cpf ?? '—' }}</dd>
          </div>
        </dl>
      </div>

      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Dados da coleta
        </p>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Data da coleta</dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ optional($anamneseColo->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}
            </dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Motivo do exame</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->motivo_exame }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Última menstruação</dt>
            <dd class="mt-1 text-sm text-slate-700">
              {{ optional($anamneseColo->data_ultima_menstruacao)->format('d/m/Y') ?? '—' }}
            </dd>
          </div>
        </dl>
      </div>

      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Histórico
        </p>
        <div class="flex flex-wrap gap-2.5">
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
            <span class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600">
              <span class="{{ $valor ? 'text-emerald-600' : 'text-slate-300' }}">
                {{ $valor ? '✓' : '—' }}
              </span>
              {{ $label }}
            </span>
          @endforeach
        </div>

        <div class="mt-4 max-w-xs">
          <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Ano do último preventivo</dt>
          <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->ano_ultimo_preventivo ?? '—' }}</dd>
        </div>
      </div>

      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Exame do colo
        </p>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Inspeção do colo</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->inspecao_colo }}</dd>
          </div>
          <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Sinais de DST observados</dt>
            <dd class="mt-1 text-sm text-slate-700">{{ $anamneseColo->sinais_dst ?? 'Nenhum' }}</dd>
          </div>
        </dl>
      </div>

      <div class="flex items-center justify-end gap-3 pb-4">
        <a href="{{ route('anamnese-colo.pdf', $anamneseColo->id_siscolo) }}"
           class="rounded-lg border border-emerald-200 px-5 py-2.5 text-sm font-medium text-emerald-600 transition hover:bg-emerald-50">
          Baixar PDF
        </a>
        <a href="{{ route('anamnese-colo.edit', $anamneseColo->id_siscolo) }}"
           class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
          Editar
        </a>
      </div>
    </div>
  </div>
</x-layout>