<x-layout sidebar="n3">
  <div class="mx-auto max-w-6xl px-8 py-8">
    <header class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold text-slate-800">
          Anamnese · Solicitação de mamografia
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

    <form method="GET" action="{{ route('anamnese-mama.index') }}" class="mb-4 flex gap-3">
      <input
        type="text"
        name="cpf"
        value="{{ $cpfBusca }}"
        placeholder="Buscar por CPF do paciente..."
        class="w-full max-w-xs rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
      />
      <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
        Buscar
      </button>
      @if ($cpfBusca)
        <a href="{{ route('anamnese-mama.index') }}" class="flex items-center px-3 text-sm font-medium text-slate-500 hover:text-slate-700">
          Limpar busca
        </a>
      @endif
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
      @if ($anamnesesMama->isEmpty())
        <div class="p-8 text-center text-sm text-slate-400">
          @if ($cpfBusca)
            Nenhuma anamnese encontrada para o CPF "{{ $cpfBusca }}".
          @else
            Nenhuma anamnese de mama registrada ainda.
          @endif
        </div>
      @else
        <table class="w-full text-left text-sm">
          <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-400">
            <tr>
              <th class="px-6 py-3">Paciente</th>
              <th class="px-6 py-3">CPF</th>
              <th class="px-6 py-3">Data</th>
              <th class="px-6 py-3">Tipo de mamografia</th>
              <th class="px-6 py-3 text-right">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach ($anamnesesMama as $anamnese)
              @php
                $paciente = $anamnese->fatoAnamnese?->prontuario?->paciente;
              @endphp
              <tr class="hover:bg-slate-50">
                <td class="px-6 py-3 text-slate-700">{{ $paciente?->nome_completo ?? '—' }}</td>
                <td class="px-6 py-3 text-slate-700">{{ $paciente?->cpf ?? '—' }}</td>
                <td class="px-6 py-3 text-slate-700">
                  {{ optional($anamnese->fatoAnamnese?->data_realizacao)->format('d/m/Y') ?? '—' }}
                </td>
                <td class="px-6 py-3 text-slate-700">{{ $anamnese->tipo_mamografia ?? '—' }}</td>
                <td class="px-6 py-3">
                  <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('anamnese-mama.show', $anamnese->id_sismama) }}"
                       class="text-sm font-medium text-blue-600 hover:text-blue-700">
                      Ver
                    </a>
                    <a href="{{ route('anamnese-mama.edit', $anamnese->id_sismama) }}"
   class="text-sm font-medium text-amber-600 hover:text-amber-700">
  Editar
</a>
                    <a href="{{ route('anamnese-mama.pdf', $anamnese->id_sismama) }}"
                       class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                      PDF
                    </a>
                    <form method="POST"
                          action="{{ route('anamnese-mama.destroy', $anamnese->id_sismama) }}"
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
    <!-- Lucide Icon Library & Initialization -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      // Initialize Lucide icons on load
      lucide.createIcons();

      // Mobile Sidebar Toggle Logic
      const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
      const mobileMenuClose = document.getElementById('mobile-menu-close');
      const sidebar = document.getElementById('sidebar');
      const sidebarOverlay = document.getElementById('sidebar-overlay');

      function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
        setTimeout(() => {
          sidebarOverlay.classList.add('opacity-100');
        }, 10);
      }

      function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.remove('opacity-100');
        setTimeout(() => {
          sidebarOverlay.classList.add('hidden');
        }, 300);
      }

      if (mobileMenuToggle && mobileMenuClose && sidebar && sidebarOverlay) {
        mobileMenuToggle.addEventListener('click', openSidebar);
        mobileMenuClose.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
      }

       const hoje = new Date();
       const formatoData = hoje.toLocaleDateString('pt-BR')
       document.getElementById('data-atual').textContent = formatoData;
    </script>
</x-layout>