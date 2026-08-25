<!-- Time Slots Component -->
<section class="flex flex-col gap-sm" data-horarios id="secao-horarios">
    <h3 class="font-h3 text-h3 text-primary-container flex items-center gap-2">
        <span class="material-symbols-outlined text-[20px]" data-icon="schedule">schedule</span>
        <span id="titulo-data-horarios">Horários para 15 de Novembro</span>
    </h3>

    <!-- Grade de Horários Disponíveis (Visível quando há vagas regulares no dia) -->
    <div id="grade-horarios-disponiveis" class="grid grid-cols-3 gap-sm mt-xs">
        <!-- Morning Slots -->
        <div class="col-span-3 text-label-bold font-label-bold text-on-surface-variant uppercase tracking-wider mt-2 mb-1">Manhã</div>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            08:00
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            08:30
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border-2 border-primary-container bg-primary-fixed/30 flex items-center justify-center font-body-md text-body-md text-primary-container font-medium shadow-sm transition-all cursor-pointer">
            09:30
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            10:30
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            11:00
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            11:30
        </button>

        <!-- Afternoon Slots -->
        <div class="col-span-3 text-label-bold font-label-bold text-on-surface-variant uppercase tracking-wider mt-4 mb-1">Tarde</div>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            13:30
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            14:00
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            14:30
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            15:00
        </button>
        <button type="button" class="btn-horario h-12 rounded-lg border border-outline-variant flex items-center justify-center font-body-md text-body-md text-on-surface hover:border-primary-container hover:bg-primary-fixed/20 transition-all cursor-pointer">
            15:30
        </button>
    </div>

    <!-- Mensagem de Vagas Esgotadas para o dia selecionado (Visível SOMENTE quando o dia não tem horários disponíveis) -->
    <div id="aviso-dia-esgotado" class="hidden p-5 rounded-xl border border-dashed border-amber-300 bg-amber-50/60 text-center flex flex-col items-center justify-center gap-2 transition-all">
        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[24px]">event_busy</span>
        </div>
        <p class="text-sm font-bold text-amber-950">Vagas Diretas Esgotadas para este Dia</p>
        <p class="text-xs text-amber-800 leading-relaxed max-w-sm">
            Não há horários regulares disponíveis nesta data. Você pode se inscrever na Lista de Espera Inteligente logo abaixo para ser notificado caso surjam desistências.
        </p>
    </div>
</section>
