@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>
  <div class="mx-auto max-w-4xl px-8 py-8">

    @php
      $fato = $anamneseMama->fatoAnamnese;
      $paciente = $fato?->prontuario?->paciente;
    @endphp

    <header class="mb-6 flex items-start justify-between gap-4">
      <div>
        <h1 class="text-lg font-semibold text-slate-800">
          Anamnese · Solicitação de mamografia
        </h1>
        <p class="mt-1 text-sm text-slate-400">
          {{ $paciente?->nome_completo ?? '—' }}
          · CPF {{ $paciente?->cpf ?? '—' }}
          · {{ optional($fato?->data_realizacao)->format('d/m/Y') ?? '—' }}
        </p>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('anamnese-mama.pdf', $anamneseMama->id_sismama) }}"
           class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700">
          Baixar PDF
        </a>
      </div>
    </header>

    <div class="flex flex-col gap-5">

      <!-- ---------- Dados da solicitação ---------- -->
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Dados da solicitação
        </p>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Data da solicitação</p>
            <p class="mt-1 text-sm text-slate-700">{{ optional($fato?->data_realizacao)->format('d/m/Y') ?? '—' }}</p>
          </div>
          <div>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Tipo de mamografia</p>
            <p class="mt-1 text-sm text-slate-700">{{ $anamneseMama->tipo_mamografia ?? '—' }}</p>
          </div>
        </div>
      </div>

      <!-- ---------- Histórico ---------- -->
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Histórico
        </p>
        <div class="flex flex-wrap gap-2.5">
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
          @foreach ($historico as $label => $valor)
            <span class="flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600">
              <span class="{{ $valor ? 'text-emerald-600' : 'text-slate-300' }}">
                {{ $valor ? '✓' : '—' }}
              </span>
              {{ $label }}
            </span>
          @endforeach
        </div>

        <div class="mt-4 max-w-xs">
          <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Ano da última mamografia</p>
          <p class="mt-1 text-sm text-slate-700">{{ $anamneseMama->ano_ultima_mamografia ?? '—' }}</p>
        </div>
      </div>

      <!-- ---------- Achados clínicos ---------- -->
      <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
          Achados clínicos
        </p>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div class="rounded-xl border border-slate-100 p-4">
            <p class="mb-2 text-sm font-medium text-slate-700">Descarga papilar</p>
            <div class="grid grid-cols-2 gap-3 text-sm text-slate-600">
              <div>
                <p class="text-xs text-slate-400">Dir</p>
                {{ $anamneseMama->achado_descarga_papilar_dir ?? '—' }}
              </div>
              <div>
                <p class="text-xs text-slate-400">Esq</p>
                {{ $anamneseMama->achado_descarga_papilar_esq ?? '—' }}
              </div>
            </div>
          </div>

          <div class="rounded-xl border border-slate-100 p-4">
            <p class="mb-2 text-sm font-medium text-slate-700">Nódulo · localização</p>
            <div class="grid grid-cols-2 gap-3 text-sm text-slate-600">
              <div>
                <p class="text-xs text-slate-400">Dir</p>
                {{ $anamneseMama->achado_nodulo_localizacao_dir ?? '—' }}
              </div>
              <div>
                <p class="text-xs text-slate-400">Esq</p>
                {{ $anamneseMama->achado_nodulo_localizacao_esq ?? '—' }}
              </div>
            </div>
          </div>

          <div class="rounded-xl border border-slate-100 p-4">
            <p class="mb-2 text-sm font-medium text-slate-700">Linfonodo palpável</p>
            <div class="grid grid-cols-2 gap-3 text-sm text-slate-600">
              <div>
                <p class="text-xs text-slate-400">Dir</p>
                {{ $anamneseMama->achado_linfonodo_palpavel_dir ?? '—' }}
              </div>
              <div>
                <p class="text-xs text-slate-400">Esq</p>
                {{ $anamneseMama->achado_linfonodo_palpavel_esq ?? '—' }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div>
        <a href="{{ route('anamnese-mama.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
          ← Voltar para a lista
        </a>
      </div>

    </div>
  </div>
</x-layout>