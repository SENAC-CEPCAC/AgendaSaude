@vite(['resources/css/app.css'])


  <!--Inicio Confirmado-->


  <!-- Overlay -->
  <div class="fixed inset-0 bg-black/50"></div>

  <!-- Modal -->
  <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-md bg-[#f7f8fc] rounded-xl shadow-2xl px-6 py-5">
    <!-- Botão fechar -->
    <div class="flex justify-end">
      <button class="text-gray-800 hover:text-gray-600 text-lg leading-none">
        &times;
      </button>
    </div>

    <hr class="border-gray-300 mt-3">

    <!-- Conteúdo confirmado -->
    <div class="flex items-center justify-center gap-2 py-6">
      <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      <span class="text-green-600 font-semibold tracking-wide text-sm">
        CONFIRMADO
      </span>
    </div>

    <hr class="border-gray-300">
  </div>



  <!--Final Confirmado-->

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



