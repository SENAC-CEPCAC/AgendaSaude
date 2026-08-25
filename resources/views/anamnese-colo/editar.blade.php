@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>

    @php
        $fato = $anamneseColo->fatoAnamnese;
        $paciente = $fato?->prontuario?->paciente;
    @endphp

    <div class="mx-auto max-w-5xl px-8 py-8">

        <header class="mb-6">
            <h1 class="text-lg font-semibold text-slate-800">
                Editar Anamnese · Exame de colo do útero
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                {{ $paciente?->nome_completo ?? '—' }}
                · CPF {{ $paciente?->cpf ?? '—' }}
            </p>
        </header>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="mb-1 font-semibold">Corrija os campos abaixo:</p>

                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('sucesso'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('sucesso') }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('anamnese-colo.update', $anamneseColo->id_siscolo) }}"
            class="flex flex-col gap-5"
        >

            @csrf
            @method('PUT')

            <input
                type="hidden"
                name="id_prontuario"
                value="{{ $fato?->id_prontuario }}"
            >

            <!-- ---------- Dados da solicitação ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

                <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Dados da solicitação
                </p>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <label class="flex flex-col gap-1.5">
                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Data da realização
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
                            Motivo do exame
                        </span>

                        <input
                            type="text"
                            name="motivo_exame"
                            maxlength="50"
                            required
                            value="{{ old('motivo_exame', $anamneseColo->motivo_exame) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        />
                    </label>

                </div>
            </div>

            <!-- ---------- Histórico ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

                <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Histórico
                </p>

                @php
                    $checkboxes = [
                        'fez_preventivo_anterior' => 'Fez preventivo anterior?',
                        'usa_diu' => 'Usa DIU?',
                        'esta_gravida' => 'Está grávida?',
                        'usa_pilula' => 'Usa pílula?',
                        'usa_hormonio_menopausa' => 'Usa hormônio para menopausa?',
                        'ja_fez_radioterapia' => 'Já fez radioterapia?',
                        'sangramento_apos_relacao' => 'Sangramento após relação?',
                        'sangramento_apos_menopausa' => 'Sangramento após menopausa?',
                    ];
                @endphp

                <div class="flex flex-wrap gap-2.5">

                    @foreach ($checkboxes as $campo => $label)

                        <label class="flex cursor-pointer items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition-colors hover:border-slate-300">

                            <input
                                type="hidden"
                                name="{{ $campo }}"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="{{ $campo }}"
                                value="1"
                                @checked(old($campo, $anamneseColo->$campo))
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-100"
                            >

                            {{ $label }}

                        </label>

                    @endforeach

                </div>

                <div class="mt-4 max-w-xs">

                    <label class="flex flex-col gap-1.5">

                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Ano do último preventivo
                        </span>

                        <input
                            type="number"
                            name="ano_ultimo_preventivo"
                            min="1900"
                            max="2099"
                            placeholder="2023"
                            value="{{ old('ano_ultimo_preventivo', $anamneseColo->ano_ultimo_preventivo) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        />

                    </label>

                </div>

                <div class="mt-4 max-w-xs">

                    <label class="flex flex-col gap-1.5">

                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Data da última menstruação
                        </span>

                        <input
                            type="date"
                            name="data_ultima_menstruacao"
                            value="{{ old('data_ultima_menstruacao', optional($anamneseColo->data_ultima_menstruacao)->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        />

                    </label>

                </div>

            </div>

            <!-- ---------- Exame ---------- -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

                <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Exame
                </p>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <label class="flex flex-col gap-1.5">

                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Inspeção do colo
                        </span>

                        <input
                            type="text"
                            name="inspecao_colo"
                            maxlength="50"
                            required
                            value="{{ old('inspecao_colo', $anamneseColo->inspecao_colo) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        />

                    </label>

                    <label class="flex flex-col gap-1.5">

                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Sinais de DST
                        </span>

                        <input
                            type="text"
                            name="sinais_dst"
                            maxlength="30"
                            value="{{ old('sinais_dst', $anamneseColo->sinais_dst) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        />

                    </label>

                </div>

            </div>

            <!-- ---------- Botões ---------- -->
            <div class="flex items-center justify-end gap-3 pb-4">

                <a
                    href="{{ route('anamnese-colo.show', $anamneseColo->id_siscolo) }}"
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

</x-layout>