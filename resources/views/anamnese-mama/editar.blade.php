<x-layout sidebar="n3">

    @php
        $fato = $anamneseMama->fatoAnamnese;
        $paciente = $fato?->prontuario?->paciente;
    @endphp

    <div class="mx-auto max-w-5xl px-8 py-8">

        <header class="mb-6">
            <h1 class="text-lg font-semibold text-slate-800">
                Editar Anamnese · Solicitação de mamografia
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                {{ $paciente?->nome_completo ?? '—' }}
                · CPF {{ $paciente?->cpf ?? '—' }}
            </p>
        </header>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold mb-1">Corrija os campos abaixo:</p>

                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('anamnese-mama.update', $anamneseMama->id_sismama) }}"
            class="flex flex-col gap-5"
        >

            @csrf
            @method('PUT')

            <input
                type="hidden"
                name="id_prontuario"
                value="{{ $fato?->id_prontuario }}"
            >

            <!-- DADOS DA SOLICITAÇÃO -->

            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

                <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Dados da solicitação
                </p>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <label class="flex flex-col gap-1.5">

                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Data da solicitação
                        </span>

                        <input
                            type="date"
                            name="data_realizacao"
                            required
                            value="{{ old('data_realizacao', optional($fato?->data_realizacao)->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        />

                    </label>

                    <label class="flex flex-col gap-1.5">

                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Tipo de mamografia
                        </span>

                        <select
                            name="tipo_mamografia"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                            <option value="" {{ old('tipo_mamografia', $anamneseMama->tipo_mamografia) ? '' : 'selected' }}>
                                Selecione
                            </option>

                            <option
                                value="Rastreamento"
                                @selected(old('tipo_mamografia', $anamneseMama->tipo_mamografia) == 'Rastreamento')
                            >
                                Rastreamento
                            </option>

                            <option
                                value="Diagnóstica"
                                @selected(old('tipo_mamografia', $anamneseMama->tipo_mamografia) == 'Diagnóstica')
                            >
                                Diagnóstica
                            </option>

                            <option
                                value="Controle"
                                @selected(old('tipo_mamografia', $anamneseMama->tipo_mamografia) == 'Controle')
                            >
                                Controle
                            </option>

                        </select>

                    </label>

                </div>

            </div>


            <!-- HISTÓRICO -->

            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

                <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Histórico
                </p>

                <div class="flex flex-wrap gap-2.5">

                    @php
                        $checkboxes = [
                            'nodulo_mama_direita' => 'Nódulo mama direita?',
                            'nodulo_mama_esquerda' => 'Nódulo mama esquerda?',
                            'risco_elevado_cancer' => 'Risco elevado câncer?',
                            'mamas_examinadas_anteriormente' => 'Mamas já examinadas?',
                            'fez_mamografia_anterior' => 'Fez mamografia antes?',
                            'fez_radioterapia_mama' => 'Já fez radioterapia?',
                            'fez_cirurgia_mama' => 'Já fez cirurgia na mama?',
                        ];
                    @endphp

                    @foreach ($checkboxes as $campo => $label)

                        <label class="flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300 cursor-pointer">

                            <input
                                type="hidden"
                                name="{{ $campo }}"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="{{ $campo }}"
                                value="1"
                                @checked(old($campo, $anamneseMama->$campo))
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100"
                            >

                            {{ $label }}

                        </label>

                    @endforeach

                </div>


                <div class="mt-4 max-w-xs">

                    <label class="flex flex-col gap-1.5">

                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Ano da última mamografia
                        </span>

                        <input
                            type="number"
                            name="ano_ultima_mamografia"
                            placeholder="2023"
                            min="2000"
                            max="2099"
                            value="{{ old('ano_ultima_mamografia', $anamneseMama->ano_ultima_mamografia) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-300 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        />

                    </label>

                </div>

            </div>


            <!-- ACHADOS CLÍNICOS -->

            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

                <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Achados clínicos
                </p>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">


                    <!-- DESCARGA PAPILAR -->

                    <div class="rounded-xl border border-slate-100 p-4">

                        <p class="mb-3 text-sm font-medium text-slate-700">
                            Descarga papilar
                        </p>

                        <div class="grid grid-cols-2 gap-3">

                            <label class="flex flex-col gap-1.5">

                                <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Dir
                                </span>

                                <input
                                    type="text"
                                    name="achado_descarga_papilar_dir"
                                    maxlength="30"
                                    value="{{ old('achado_descarga_papilar_dir', $anamneseMama->achado_descarga_papilar_dir) }}"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </label>

                            <label class="flex flex-col gap-1.5">

                                <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Esq
                                </span>

                                <input
                                    type="text"
                                    name="achado_descarga_papilar_esq"
                                    maxlength="30"
                                    value="{{ old('achado_descarga_papilar_esq', $anamneseMama->achado_descarga_papilar_esq) }}"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </label>

                        </div>

                    </div>


                    <!-- NÓDULO -->

                    <div class="rounded-xl border border-slate-100 p-4">

                        <p class="mb-3 text-sm font-medium text-slate-700">
                            Nódulo · localização
                        </p>

                        <div class="grid grid-cols-2 gap-3">

                            <label class="flex flex-col gap-1.5">

                                <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Dir
                                </span>

                                <input
                                    type="text"
                                    name="achado_nodulo_localizacao_dir"
                                    maxlength="30"
                                    value="{{ old('achado_nodulo_localizacao_dir', $anamneseMama->achado_nodulo_localizacao_dir) }}"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </label>

                            <label class="flex flex-col gap-1.5">

                                <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Esq
                                </span>

                                <input
                                    type="text"
                                    name="achado_nodulo_localizacao_esq"
                                    maxlength="30"
                                    value="{{ old('achado_nodulo_localizacao_esq', $anamneseMama->achado_nodulo_localizacao_esq) }}"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </label>

                        </div>

                    </div>


                    <!-- LINFONODO -->

                    <div class="rounded-xl border border-slate-100 p-4">

                        <p class="mb-3 text-sm font-medium text-slate-700">
                            Linfonodo palpável
                        </p>

                        <div class="grid grid-cols-2 gap-3">

                            <label class="flex flex-col gap-1.5">

                                <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Dir
                                </span>

                                <input
                                    type="text"
                                    name="achado_linfonodo_palpavel_dir"
                                    maxlength="30"
                                    value="{{ old('achado_linfonodo_palpavel_dir', $anamneseMama->achado_linfonodo_palpavel_dir) }}"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </label>

                            <label class="flex flex-col gap-1.5">

                                <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Esq
                                </span>

                                <input
                                    type="text"
                                    name="achado_linfonodo_palpavel_esq"
                                    maxlength="30"
                                    value="{{ old('achado_linfonodo_palpavel_esq', $anamneseMama->achado_linfonodo_palpavel_esq) }}"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            <!-- BOTÕES -->

            <div class="flex items-center justify-end gap-3 pb-4">

                <a
                    href="{{ route('anamnese-mama.show', $anamneseMama->id_sismama) }}"
                    class="rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                >
                    Salvar alterações
                </button>

            </div>

        </form>

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