<x-layout>


  <!--Inicio feedback-->



  <form class="w-full max-w-xl mx-auto">

    <!-- Cabeçalho -->
    <div class="flex flex-col items-center text-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Como foi seu atendimento?</h1>
    </div>

    <!-- Avaliação em estrelas -->
    <div class="flex flex-col items-center mb-8">
      <p class="font-semibold text-gray-900 mb-3">Avalie sua experiência</p>
      <div class="star-row" title="Avaliação geral">
        <input class="star-input" type="radio" name="estrelas" id="star5" value="5">
        <label class="star-label" for="star5">★</label>
        <input class="star-input" type="radio" name="estrelas" id="star4" value="4">
        <label class="star-label" for="star4">★</label>
        <input class="star-input" type="radio" name="estrelas" id="star3" value="3">
        <label class="star-label" for="star3">★</label>
        <input class="star-input" type="radio" name="estrelas" id="star2" value="2">
        <label class="star-label" for="star2">★</label>
        <input class="star-input" type="radio" name="estrelas" id="star1" value="1">
        <label class="star-label" for="star1">★</label>
      </div>
    </div>

    <hr class="border-gray-300 mb-6">

    <!-- Itens de pontuação -->
    <div class="mb-2">

      <!-- Cabeçalho das colunas -->
      <div class="flex items-center justify-between py-2">
        <span class="font-semibold text-gray-900">Pontue os itens abaixo</span>
        <div class="flex gap-3 text-xs text-gray-500">
          <span class="w-10 text-center">Fácil</span>
          <span class="w-10 text-center">Regular</span>
          <span class="w-10 text-center">Difícil</span>
        </div>
      </div>

      <!-- Tempo de espera -->
      <div class="flex items-center justify-between py-2">
        <span class="text-gray-800">Tempo de espera</span>
        <div class="flex gap-3">
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="tempo_espera" id="te1" value="muito_facil">
            <label class="score-label" for="te1"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="tempo_espera" id="te2" value="regular">
            <label class="score-label" for="te2"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="tempo_espera" id="te3" value="dificil">
            <label class="score-label" for="te3"></label>
          </div>
        </div>
      </div>

      <!-- Atendimento da equipe -->
      <div class="flex items-center justify-between py-2">
        <span class="text-gray-800">Atendimento da equipe</span>
        <div class="flex gap-3">
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="atendimento_equipe" id="ae1" value="muito_facil">
            <label class="score-label" for="ae1"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="atendimento_equipe" id="ae2" value="regular">
            <label class="score-label" for="ae2"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="atendimento_equipe" id="ae3" value="dificil">
            <label class="score-label" for="ae3"></label>
          </div>
        </div>
      </div>

      <!-- Clareza das informações -->
      <div class="flex items-center justify-between py-2">
        <span class="text-gray-800">Clareza das informações</span>
        <div class="flex gap-3">
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="clareza_info" id="ci1" value="muito_facil">
            <label class="score-label" for="ci1"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="clareza_info" id="ci2" value="regular">
            <label class="score-label" for="ci2"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="clareza_info" id="ci3" value="dificil">
            <label class="score-label" for="ci3"></label>
          </div>
        </div>
      </div>

      <!-- Facilidade de agendamento -->
      <div class="flex items-center justify-between py-2">
        <span class="text-gray-800">Facilidade de agendamento</span>
        <div class="flex gap-3">
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="facilidade_agendamento" id="fa1" value="muito_facil">
            <label class="score-label" for="fa1"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="facilidade_agendamento" id="fa2" value="regular">
            <label class="score-label" for="fa2"></label>
          </div>
          <div class="w-10 flex justify-center">
            <input class="score-input" type="radio" name="facilidade_agendamento" id="fa3" value="dificil">
            <label class="score-label" for="fa3"></label>
          </div>
        </div>
      </div>
    </div>

    <!-- Comentário -->
    <div class="mt-6">
      <p class="text-gray-800 mb-2">Comentário (opcional)</p>
      <textarea
        name="comentario"
        rows="4"
        placeholder="Conte um pouco mais sobre a sua experiência"
        class="w-full rounded-xl border border-gray-300 p-4 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0B3B66] focus:border-transparent resize-none"></textarea>
    </div>

    <!-- Botão de envio -->
    <button
      type="submit"
      class="w-full mt-6 bg-[#0B3B66] hover:bg-[#0a3357] text-white font-medium py-3.5 rounded-full transition-colors">
      Enviar avaliação
    </button>

  </form>





  <!--Fim feedback-->

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