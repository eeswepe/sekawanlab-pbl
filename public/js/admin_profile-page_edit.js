    
        document.addEventListener('DOMContentLoaded', function() {
            // ===================================
            // 1. Sidebar Toggle Functionality
            // ===================================
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
            
            // Handle window resize for desktop view
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('toggled');
                    mainContent.classList.remove('toggled');
                }
            });


            // ===================================
            // 2. Featured Image Preview
            // ===================================
            const imageInput = document.getElementById('featuredImage');
            const imagePreview = document.getElementById('featured-image-preview');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
