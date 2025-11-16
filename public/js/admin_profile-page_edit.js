    
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

            // ===================================
            // 3. Form Submit Handler
            // ===================================
            const form = document.getElementById('profilePageEditForm');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const pageId = window.location.pathname.split('/').pop();
                
                try {
                    const response = await fetch(`/admin/profil-pages/update/${pageId}`, {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Halaman berhasil diupdate');
                        window.location.href = '/admin/profil-pages';
                    } else {
                        alert(result.message || 'Gagal mengupdate halaman');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan: ' + error.message);
                }
            });
        });
