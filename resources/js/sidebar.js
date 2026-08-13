document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
              if (sidebar) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
              }
              if (sidebarOverlay) {
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => {
                  sidebarOverlay.classList.add('opacity-100');
                }, 10);
              }
            }

            function closeSidebar() {
              if (sidebar) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
              }
              if (sidebarOverlay) {
                sidebarOverlay.classList.remove('opacity-100');
                setTimeout(() => {
                  sidebarOverlay.classList.add('hidden');
                }, 300);
              }
            }

            if (mobileMenuToggle && mobileMenuClose && sidebar && sidebarOverlay) {
              mobileMenuToggle.addEventListener('click', openSidebar);
              mobileMenuClose.addEventListener('click', closeSidebar);
              sidebarOverlay.addEventListener('click', closeSidebar);
            }

            if (window.lucide) {
              lucide.createIcons();
            }
          });