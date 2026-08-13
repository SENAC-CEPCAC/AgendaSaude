<x-layouts.agendamento title="Agendamento - Etapa 3">

    <x-agendamento.barra-progresso />

    <x-agendamento.titulo_descricao/>
            <!-- Instructions 
            <div class="flex flex-col gap-xs">
               <h2 class="font-h2 text-h2 text-primary">Anexar Documentos</h2>
               <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Para garantir um atendimento ágil, envie fotos claras ou arquivos PDF dos documentos solicitados abaixo.
               </p>
            </div>-->
            <!-- Upload Zone 1: RG/CPF -->
            <section class="flex flex-col gap-sm">
               <div class="flex items-center justify-between">
                  <label class="font-label-bold text-label-bold text-on-background">RG/CPF</label>
                  <span class="font-label-md text-label-md text-error bg-error-container px-2 py-0.5 rounded-sm">Obrigatório</span>
               </div>
               <button class="relative w-full flex flex-col items-center justify-center p-xl rounded-xl border-2 border-dashed border-outline-variant bg-surface hover:bg-surface-container-low active:bg-surface-container transition-all group overflow-hidden">
                  <div class="w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                     <span class="material-symbols-outlined text-primary text-[32px]" data-icon="add_a_photo">add_a_photo</span>
                  </div>
                  <span class="font-h3 text-h3 text-primary mb-xs text-center">Tirar foto ou enviar</span>
                  <span class="font-body-sm text-body-sm text-on-surface-variant text-center">Tamanho máximo: 5MB</span>
               </button>
            </section>
            <!-- Upload Zone 2: Requisição Médica -->
            <section class="flex flex-col gap-sm">
               <div class="flex items-center justify-between">
                  <label class="font-label-bold text-label-bold text-on-background">Requisição Médica</label>
                  <span class="font-label-md text-label-md text-on-surface-variant bg-surface-variant px-2 py-0.5 rounded-sm">Se possuir</span>
               </div>
               <button class="relative w-full flex flex-col items-center justify-center p-xl rounded-xl border-2 border-dashed border-outline-variant bg-surface hover:bg-surface-container-low active:bg-surface-container transition-all group overflow-hidden">
                  <div class="w-16 h-16 rounded-full bg-surface-container-highest flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                     <span class="material-symbols-outlined text-outline text-[32px]" data-icon="upload_file">upload_file</span>
                  </div>
                  <span class="font-h3 text-h3 text-on-surface mb-xs text-center">Adicionar arquivo</span>
                  <span class="font-body-sm text-body-sm text-on-surface-variant text-center">Toque para selecionar do dispositivo</span>
               </button>
            </section>
            <!-- Help Text Banner -->
            <div class="flex items-start gap-sm p-md bg-primary-fixed-dim/20 rounded-lg border border-primary-fixed-dim">
               <span class="material-symbols-outlined text-primary text-[20px] mt-0.5" data-icon="info">info</span>
               <p class="font-label-md text-label-md text-on-background">
                  Formatos aceitos: PDF, JPG, PNG
               </p>
            </div>

</x-layouts.agendamento>