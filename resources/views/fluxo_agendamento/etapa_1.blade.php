<x-layouts.agendamento title="Agendamento - Etapa 1">

    <x-agendamento.barra-progresso />

    <section class="flex flex-col gap-2">
        <x-agendamento.titulo_descricao/>
        <!--
        <h2 class="text-h2 font-semibold text-on-background">
            Escolha a Especialidade
        </h2>

        <p class="text-body-sm text-on-surface-variant mb-2">
            Selecione o tipo de atendimento que você precisa.
        </p>
-->
        <div class="relative" id="especialidade">
            <button
                id="btn-especialidade"
                type="button"
                aria-expanded="false"
                class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-4
                       flex items-center justify-between text-left shadow-sm
                       transition-all duration-200
                       hover:border-primary hover:shadow-md
                       focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-fixed"
            >
                <span id="texto-especialidade" class="text-body-md text-on-surface-variant">
                    Selecione a especialidade...
                </span>

                <span
                    id="icone-especialidade"
                    class="material-symbols-outlined text-outline transition-transform duration-200"
                >
                    keyboard_arrow_down
                </span>
            </button>

            <div
                id="lista-especialidades"
                class="absolute z-20 mt-2 w-full overflow-hidden rounded-lg border border-outline-variant
                       bg-surface-container-lowest shadow-lg origin-top
                       opacity-0 scale-95 pointer-events-none
                       transition-all duration-200"
            >
                <button type="button" data-especialidade="Clínica Geral"
                    class="opcao-especialidade w-full px-4 py-3 text-left text-on-surface transition-colors hover:bg-primary-fixed">
                    Clínica Geral
                </button>

                <button type="button" data-especialidade="Ginecologia"
                    class="opcao-especialidade w-full px-4 py-3 text-left text-on-surface transition-colors hover:bg-primary-fixed">
                    Ginecologia
                </button>

                <button type="button" data-especialidade="Pediatria"
                    class="opcao-especialidade w-full px-4 py-3 text-left text-on-surface transition-colors hover:bg-primary-fixed">
                    Pediatria
                </button>
            </div>
        </div>
    </section>

    <section class="mt-8 flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h2 class="text-h2 font-semibold text-on-background">
                Unidade Móvel Próxima
            </h2>

            <button
                type="button"
                aria-label="Usar minha localização"
                class="p-2 text-primary rounded-full transition-colors hover:bg-primary-fixed"
            >
                <span class="material-symbols-outlined">my_location</span>
            </button>
        </div>

        <label class="cursor-pointer">
            <input
                checked
                class="peer sr-only"
                name="unidade"
                type="radio"
                value="Unidade Móvel Centro"
            >

            <div
                class="bg-surface-container-lowest border-2 border-outline-variant rounded-lg p-4
                       flex flex-col gap-4 shadow-sm cursor-pointer
                       transition-all duration-200 ease-out
                       hover:-translate-y-1 hover:border-primary hover:shadow-md
                       peer-checked:border-primary peer-checked:bg-primary-fixed peer-checked:shadow-md
                       peer-checked:[&_.indicador]:border-primary
                       peer-checked:[&_.ponto]:scale-100"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-h3 font-semibold text-on-background">
                            Unidade Móvel Centro
                        </h3>

                        <p class="text-body-sm text-on-surface-variant mt-1">
                            Praça da República, s/n - Centro
                        </p>
                    </div>

                    <span class="bg-primary text-on-primary px-2 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                        1,2 km
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-body-sm text-emerald-600">Aberta agora</span>
                    </div>

                    <div class="indicador w-6 h-6 rounded-full border-2 border-outline-variant flex items-center justify-center transition-colors">
                        <div class="ponto w-3 h-3 rounded-full bg-primary scale-0 transition-transform duration-200"></div>
                    </div>
                </div>
            </div>
        </label>

        <label class="cursor-pointer">
            <input
                class="peer sr-only"
                name="unidade"
                type="radio"
                value="Unidade Zona Sul"
            >

            <div
                class="bg-surface-container-lowest border-2 border-outline-variant rounded-lg p-4
                       flex flex-col gap-4 shadow-sm cursor-pointer
                       transition-all duration-200 ease-out
                       hover:-translate-y-1 hover:border-primary hover:shadow-md
                       peer-checked:border-primary peer-checked:bg-primary-fixed peer-checked:shadow-md
                       peer-checked:[&_.indicador]:border-primary
                       peer-checked:[&_.ponto]:scale-100"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-h3 font-semibold text-on-background">
                            Unidade Zona Sul
                        </h3>

                        <p class="text-body-sm text-on-surface-variant mt-1">
                            Av. das Nações, 1500
                        </p>
                    </div>

                    <span class="bg-surface-container-highest text-on-surface-variant px-2 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                        3,5 km
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-outline"></span>
                        <span class="text-body-sm text-outline">Fechada temporariamente</span>
                    </div>

                    <div class="indicador w-6 h-6 rounded-full border-2 border-outline-variant flex items-center justify-center transition-colors">
                        <div class="ponto w-3 h-3 rounded-full bg-primary scale-0 transition-transform duration-200"></div>
                    </div>
                </div>
            </div>
        </label>
    </section>

</x-layouts.agendamento>