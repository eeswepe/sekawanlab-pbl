
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButton = document.getElementById('sidebarToggleMobile');

            // Function to toggle sidebar visibility
            function toggleSidebar() {
                sidebar.classList.toggle('toggled');
                mainContent.classList.toggle('toggled');
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', toggleSidebar);
            }
            
            // Initial check for mobile view (for better UX)
            if (window.innerWidth < 992) {
                sidebar.classList.add('toggled');
                mainContent.classList.add('toggled');
            }
            
            // Handle window resize for desktop view
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('toggled');
                    mainContent.classList.remove('toggled');
                } else {
                    // Only toggle on smaller screens if not explicitly showing sidebar
                    if (!toggleButton.classList.contains('active')) {
                        sidebar.classList.add('toggled');
                        mainContent.classList.add('toggled');
                    }
                }
            });
        });
