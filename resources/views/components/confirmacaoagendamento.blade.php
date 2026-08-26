  <!--Inicio Confirmação Agendamento-->

  <!-- Botão fechar -->

  <!-- Tela de fundo (conteúdo por trás do modal) -->
  <div class="p-8">
    <h1 class="text-2xl font-bold text-gray-700 mb-4">Agenda Saúde</h1>
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
      <p class="text-gray-500">Lista de agendamentos...</p>
    </div>
  </div>

  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50">

    <!-- Modal -->
    <div class="bg-[#f5f6fb] w-full max-w-sm rounded-xl shadow-2xl relative px-6 py-6">

      <!-- Botão fechar -->
      <button onclick="fecharModal()" class="absolute top-4 right-5 text-black text-xl font-medium hover:text-gray-600">
        X
      </button>

      <!-- Título -->
      <h2 class="text-center text-2xl font-bold text-gray-900 mb-4">
        Confirmação
      </h2>

      <hr class="border-gray-300 mb-6">

      <!-- Mensagem -->
      <p class="text-gray-800 text-lg mb-6">
        Deseja <span class="font-bold">CONFIRMAR</span> o Agendamento?
      </p>

      <hr class="border-gray-300 mb-6">

      <!-- Botões -->
      <div class="flex justify-end gap-4">
        <button onclick="fecharModal()" class="border border-gray-300 bg-white text-gray-500 font-medium px-6 py-2 rounded-lg hover:bg-gray-50">
          Cancelar
        </button>
        <button onclick="fecharModal()" class="bg-green-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-green-700 shadow">
          Confirmar
        </button>


        <!--Fim Confirmação Agendamento-->



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

