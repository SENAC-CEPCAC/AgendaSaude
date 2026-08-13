<!-- Calendar Component -->
         <section class="bg-surface-container-lowest rounded-lg shadow-[0_12px_12px_rgba(0,62,126,0.04)] border border-outline-variant/30 overflow-hidden flex flex-col">
            <!-- Calendar Header -->
            <div class="flex justify-between items-center p-md border-b border-outline-variant/30">
               <button class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-surface-container text-on-surface-variant transition-colors">
               <span class="material-symbols-outlined text-[20px]">chevron_left</span>
               </button>
               <div class="font-h3 text-h3 text-primary-container">Novembro 2023</div>
               <button class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-surface-container text-on-surface-variant transition-colors">
               <span class="material-symbols-outlined text-[20px]">chevron_right</span>
               </button>
            </div>
            <!-- Calendar Grid -->
            <div class="p-md">
               <!-- Days of Week -->
               <div class="grid grid-cols-7 gap-1 mb-sm text-center">
                  <div class="font-label-md text-label-md text-on-surface-variant py-sm">Dom</div>
                  <div class="font-label-md text-label-md text-on-surface-variant py-sm">Seg</div>
                  <div class="font-label-md text-label-md text-on-surface-variant py-sm">Ter</div>
                  <div class="font-label-md text-label-md text-on-surface-variant py-sm">Qua</div>
                  <div class="font-label-md text-label-md text-on-surface-variant py-sm">Qui</div>
                  <div class="font-label-md text-label-md text-on-surface-variant py-sm">Sex</div>
                  <div class="font-label-md text-label-md text-on-surface-variant py-sm">Sáb</div>
               </div>
               <!-- Dates Grid -->
               <div class="grid grid-cols-7 gap-1 text-center">
                  <!-- Previous Month -->
                  <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">29</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">30</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">31</div>
                  <!-- Current Month Past -->
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">1</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">2</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">3</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">4</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">5</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">6</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">7</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">8</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">9</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">10</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">11</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 line-through opacity-50 relative">12</div>
                  <!-- Current Month Available -->
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">13</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">
                  14
                  <span class="absolute bottom-1 w-1 h-1 bg-secondary-container rounded-full"></span>
                  </button>
                  <!-- Selected Date -->
                  <button class="font-body-sm text-body-sm text-on-primary bg-primary-container p-2 rounded-full shadow-md relative flex items-center justify-center w-10 h-10 mx-auto font-medium">
                  15
                  </button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">
                  16
                  <span class="absolute bottom-1 w-1 h-1 bg-secondary-container rounded-full"></span>
                  </button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">17</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">18</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">19</button>
                  <!-- Current Month Rest -->
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">20</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">21</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">22</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">23</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">24</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">25</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">26</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">27</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">28</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">29</button>
                  <button class="font-body-sm text-body-sm text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors relative flex items-center justify-center w-10 h-10 mx-auto">30</button>
                  <!-- Next Month -->
                  <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">1</div>
                  <div class="font-body-sm text-body-sm text-outline p-2 opacity-50">2</div>
               </div>
            </div>
            <div class="bg-surface-container-low px-md py-sm border-t border-outline-variant/30 flex items-center gap-2">
               <span class="w-2 h-2 bg-secondary-container rounded-full inline-block"></span>
               <span class="font-label-md text-label-md text-on-surface-variant">Dias com alta disponibilidade</span>
            </div>
         </section>