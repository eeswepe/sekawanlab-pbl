
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
            
            // ===================================
            // 2. Photo Preview Functionality
            // ===================================
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photo-preview');

            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    photoPreview.src = "https://via.placeholder.com/120/f8f9fa/adb5bd?text=No+Photo";
                }
            });

            // ===================================
            // 3. Account Fields Conditional Display
            // ===================================
            const createAccountCheck = document.getElementById('createAccountCheck');
            const accountFields = document.getElementById('account-fields');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            
            function toggleAccountFields() {
                if (createAccountCheck.checked) {
                    accountFields.style.display = 'flex';
                    // Set required attributes when visible (for simple frontend validation)
                    usernameInput.setAttribute('required', 'required');
                    passwordInput.setAttribute('required', 'required');
                    confirmPasswordInput.setAttribute('required', 'required');
                } else {
                    accountFields.style.display = 'none';
                    // Remove required attributes when hidden
                    usernameInput.removeAttribute('required');
                    passwordInput.removeAttribute('required');
                    confirmPasswordInput.removeAttribute('required');
                    // Clear values when hidden
                    usernameInput.value = '';
                    passwordInput.value = '';
                    confirmPasswordInput.value = '';
                }
            }

            createAccountCheck.addEventListener('change', toggleAccountFields);
            
            // ===================================
            // 4. Dynamic Form: Skills (Add/Remove)
            // ===================================
            const skillsContainer = document.getElementById('skills-container');
            window.addSkillInput = function() {
                const newItem = document.createElement('div');
                newItem.classList.add('input-group', 'mb-2', 'dynamic-item');
                newItem.innerHTML = `
                    <input type="text" class="form-control" placeholder="Masukkan nama skill">
                    <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item'))"><i class="bi bi-x-lg"></i></button>
                `;
                skillsContainer.appendChild(newItem);
            };

            // Global remove function for both Skills and Projects
            window.removeDynamicItem = function(element) {
                element.remove();
                // If the removed element was a Project, re-index the titles
                if (element.closest('#projects-container')) {
                    reIndexProjects();
                }
            };
            
            // ===================================
            // 5. Dynamic Form: Projects (Add/Remove)
            // ===================================
            const projectsContainer = document.getElementById('projects-container');
            const addProjectBtn = document.getElementById('addProjectBtn');
            let projectIndex = 1;

            function reIndexProjects() {
                const projectItems = projectsContainer.querySelectorAll('.dynamic-item');
                projectIndex = 1;
                projectItems.forEach(item => {
                    item.querySelector('h6').textContent = `Project #${projectIndex}`;
                    item.setAttribute('data-index', projectIndex);
                    projectIndex++;
                });
            }

            addProjectBtn.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.classList.add('dynamic-item');
                newItem.setAttribute('data-index', ++projectIndex);
                newItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Project #${projectIndex}</h6>
                        <button class="btn btn-sm btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item'))">Hapus</button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Proyek</label>
                        <input type="text" class="form-control" placeholder="Nama Proyek">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" rows="2" placeholder="Deskripsi singkat proyek"></textarea>
                    </div>
                    <div class="mb-1 tag-input-group">
                        <label class="form-label">Tech Stack (Tags)</label>
                        <div class="input-group">
                            <input type="text" class="form-control project-tech-stack-input" placeholder="Masukkan teknologi (contoh: PHP, Vue.js)">
                            <button class="btn btn-secondary" type="button">Tambah</button>
                        </div>
                    </div>
                    <div class="tag-list mt-2">
                        </div>
                `;
                projectsContainer.appendChild(newItem);
            });
            
        });