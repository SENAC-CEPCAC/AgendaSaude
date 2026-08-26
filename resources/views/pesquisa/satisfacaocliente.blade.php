<x-layout>

  <!--Inicio Satisfação do Cliente-->

  <div class="w-full max-w-2xl mx-auto">

    <!-- Cabeçalho -->
    <div class="text-center mb-10">
      <h1 class="text-2xl font-bold text-gray-900">Sua opinião é importante</h1>
      <p class="text-gray-500 mt-1">Leva menos de 1 minuto para responder</p>
    </div>

    <!-- Pergunta NPS -->
    <div class="mb-10">
      <p class="font-semibold text-gray-900 mb-6">
        De 0 a 10, o quanto você recomendaria o Agenda Saúde para um amigo ou familiar?
      </p>

      <div class="flex flex-wrap justify-between gap-2">
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">0</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">1</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">2</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">3</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">4</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">5</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">6</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">7</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">8</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">9</button>
        <button class="w-12 h-12 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-blue-800 hover:text-blue-800 transition-colors">10</button>
      </div>

      <div class="flex justify-between text-sm text-gray-500 mt-2">
        <span>Pouco provável</span>
        <span>Muito provável</span>
      </div>

      <hr class="border-gray-200 mt-6">
    </div>

    <!-- O que mais influenciou -->
    <div class="mb-8">
      <p class="font-semibold text-gray-900 mb-4">O que mais influenciou sua nota?</p>

      <div class="flex flex-wrap gap-3">
        <button class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm hover:border-blue-800 hover:text-blue-800 transition-colors">Tempo de espera</button>
        <button class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm hover:border-blue-800 hover:text-blue-800 transition-colors">Facilidade de agendar</button>
        <button class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm hover:border-blue-800 hover:text-blue-800 transition-colors">Atendimento</button>
        <button class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm hover:border-blue-800 hover:text-blue-800 transition-colors">Lembretes de notificação</button>
        <button class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm hover:border-blue-800 hover:text-blue-800 transition-colors">Aplicativo/site</button>
        <button class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm hover:border-blue-800 hover:text-blue-800 transition-colors">Outro</button>
      </div>
    </div>

    <!-- Comentário -->
    <div class="mb-8">
      <label for="comentario" class="font-semibold text-gray-900 block mb-3">
        Quer nos contar mais? <span class="font-normal text-gray-500">(opcional)</span>
      </label>
      <textarea
        id="comentario"
        rows="5"
        placeholder="Deixe seu comentário"
        class="w-full border border-gray-300 rounded-lg p-4 text-gray-700 placeholder-gray-400 resize-none focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent"></textarea>
    </div>

    <!-- Botão enviar -->
    <button class="w-full bg-blue-900 hover:bg-blue-950 text-white font-medium py-3 rounded-lg transition-colors">
      Enviar resposta
    </button>






    <!--Fim Satisfação do Cliente-->






    </main>

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
  </script>



</x-layout>