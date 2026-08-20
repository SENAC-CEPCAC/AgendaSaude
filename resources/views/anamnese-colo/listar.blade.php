@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>
  <div class="mx-auto max-w-5xl px-8 py-8">
    <header class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold text-slate-800">
          Anamnese · Coleta de preventivo
        </h1>
        <p class="mt-1 text-sm text-slate-400">
          Lista de anamneses registradas
        </p>
      </div>
    </header>

    @if (session('sucesso'))
      <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
        {{ session('sucesso') }}
      </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
      @if ($anamnesesColo->isEmpty())
        <div class="p-8 text-center text-sm text-slate-400">
          Nenhuma anamnese de colo registrada ainda.
        </div>
      @else
        <table class="w-full text-left text-sm">
          <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-400">
            <tr>
              <th class="px-6 py-3">Data</th>
              <th class="px-6 py-3">Motivo do exame</th>
              <th class="px-6 py-3">Inspeção do colo</th>
              <th class="px-6 py-3">Prontuário</th>
              <th class="px-6 py-3 text-right">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach ($anamnesesColo as $anamnese)
              <tr class="hover:bg-slate-50">
                <td class="px-6 py-3 text-slate-700">
                  {{ optional($anamnese->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}
                </td>
                <td class="px-6 py-3 text-slate-700">{{ $anamnese->motivo_exame }}</td>
                <td class="px-6 py-3 text-slate-700">{{ $anamnese->inspecao_colo }}</td>
                <td class="px-6 py-3 text-slate-700">
                  #{{ $anamnese->fatoAnamnese?->id_prontuario ?? '—' }}
                </td>
                <td class="px-6 py-3">
                  <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('anamnese-colo.show', $anamnese->id_siscolo) }}"
                       class="text-sm font-medium text-blue-600 hover:text-blue-700">
                      Ver
                    </a>
                    <a href="{{ route('anamnese-colo.edit', $anamnese->id_siscolo) }}"
                       class="text-sm font-medium text-slate-500 hover:text-slate-700">
                      Editar
                    </a>
                    <form method="POST"
                          action="{{ route('anamnese-colo.destroy', $anamnese->id_siscolo) }}"
                          onsubmit="return confirm('Tem certeza que deseja excluir esta anamnese?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">
                        Excluir
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</x-layout>