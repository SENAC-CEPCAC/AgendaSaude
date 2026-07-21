    
      lucide.createIcons();
      
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