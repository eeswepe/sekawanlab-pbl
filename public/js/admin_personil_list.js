
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButton = document.getElementById('sidebarToggleMobile');

            // Check if screen is small enough to be toggled by default
            if (window.innerWidth < 992) {
                sidebar.classList.add('toggled');
                mainContent.classList.add('toggled');
            }

            function toggleSidebar() {
                sidebar.classList.toggle('toggled');
                mainContent.classList.toggle('toggled');
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', toggleSidebar);
            }
        });
