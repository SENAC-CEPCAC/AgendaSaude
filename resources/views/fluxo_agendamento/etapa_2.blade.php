<x-layouts.agendamento title="Agendamento - Etapa 1">

    <x-agendamento.barra-progresso />

    <x-agendamento.titulo_descricao/>
         <!-- Section Title 
         <div class="my-5 flex flex-col gap-xs">
            <h2 class="font-h2 text-h2 text-primary">Escolha o melhor momento</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Selecione uma data no calendário e escolha um horário disponível para sua consulta.</p>
         </div>-->

         <x-agendamento.calendario class="my-5" />
         <x-agendamento.cx_horario class="my-5" />

</x-layouts.agendamento>