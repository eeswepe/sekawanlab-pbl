
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
                }
            });

            // ===================================
            // 3. Dynamic Form: Skills (Add/Remove)
            // ===================================
            const skillsContainer = document.getElementById('skills-container');
            window.addSkillInput = function() {
                const newItem = document.createElement('div');
                newItem.classList.add('input-group', 'mb-2', 'dynamic-item');
                newItem.innerHTML = `
                    <input type="text" class="form-control" placeholder="Masukkan nama skill">
                    <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this)"><i class="bi bi-x-lg"></i></button>
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
            // 4. Dynamic Form: Projects (Add/Remove)
            // ===================================
            const projectsContainer = document.getElementById('projects-container');
            const addProjectBtn = document.getElementById('addProjectBtn');
            let projectIndex = projectsContainer.querySelectorAll('.dynamic-item').length;
            
            function reIndexProjects() {
                const projectItems = projectsContainer.querySelectorAll('.dynamic-item');
                let newIndex = 1;
                projectItems.forEach(item => {
                    item.querySelector('h6').textContent = `Project #${newIndex}`;
                    item.setAttribute('data-index', newIndex);
                    newIndex++;
                });
                projectIndex = newIndex - 1;
            }

            addProjectBtn.addEventListener('click', function() {
                const newIndex = ++projectIndex;
                const newItem = document.createElement('div');
                newItem.classList.add('dynamic-item');
                newItem.setAttribute('data-index', newIndex);
                newItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Project #${newIndex}</h6>
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
                            <button class="btn btn-secondary" type="button" onclick="addProjectTag(this)">Tambah</button>
                        </div>
                    </div>
                    <div class="tag-list mt-2">
                        </div>
                `;
                projectsContainer.appendChild(newItem);
            });
            
            // ===================================
            // 5. Project Tag Management
            // ===================================
            // Function to create and add a tag
            window.addProjectTag = function(buttonElement) {
                const inputGroup = buttonElement.closest('.input-group');
                const tagInput = inputGroup.querySelector('.project-tech-stack-input');
                const tagName = tagInput.value.trim();
                
                if (tagName) {
                    const tagList = buttonElement.closest('.dynamic-item').querySelector('.tag-list');
                    const newTag = document.createElement('span');
                    newTag.classList.add('badge', 'bg-info', 'text-dark', 'me-2', 'mb-2');
                    newTag.innerHTML = `${tagName} <button type="button" class="btn-close" aria-label="Remove tag" onclick="removeTag(this)"></button>`;
                    tagList.appendChild(newTag);
                    tagInput.value = ''; // Clear the input
                }
            };
            
            // Function to remove a tag
            window.removeTag = function(buttonElement) {
                buttonElement.closest('.badge').remove();
            };

            // Initial setup for the existing project tags (simulating pre-filled tags)
            projectsContainer.querySelectorAll('.dynamic-item').forEach(item => {
                const tagInput = item.querySelector('.project-tech-stack-input');
                const tagButton = item.querySelector('.input-group .btn-secondary');
                if (tagInput && tagButton) {
                    tagButton.onclick = function() {
                        addProjectTag(this);
                    };
                }
            });
            
        });
