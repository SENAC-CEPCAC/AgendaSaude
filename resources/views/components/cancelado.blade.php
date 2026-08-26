  <!--Início Cancelado-->
  <!-- Overlay do modal -->
  <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <!-- Caixa do modal -->
    <div class="w-full max-w-md bg-[#f7f7fb] rounded-lg shadow-xl p-6 relative">

      <button class="absolute top-4 right-5 text-black text-xl font-medium hover:opacity-70">
        &times;
      </button>

      <hr class="border-t border-gray-300 mt-8 mb-8">

      <div class="flex items-center justify-center gap-3">
        <span class="text-2xl font-bold text-[#ff4d4d] leading-none">&times;</span>
        <span class="text-xl font-bold tracking-wide text-[#ff4d4d]">CANCELADO</span>
      </div>

      <hr class="border-t border-gray-300 mt-8">



      <!--Final Cancelado-->






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

