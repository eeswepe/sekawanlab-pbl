document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

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
    
    // Photo Preview
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

    // Account Fields Toggle
    const createAccountCheck = document.getElementById('createAccountCheck');
    const accountFields = document.getElementById('account-fields');
    const usernameInput = document.getElementById('username');
    const nimNipInput = document.getElementById('nimNip');
    
    // Auto-fill username from nim_nip
    nimNipInput.addEventListener('input', function() {
        usernameInput.value = this.value;
    });
    
    createAccountCheck.addEventListener('change', function() {
        if (this.checked) {
            accountFields.style.display = 'flex';
            usernameInput.setAttribute('required', 'required');
            // Fill username with current nim_nip value
            usernameInput.value = nimNipInput.value;
        } else {
            accountFields.style.display = 'none';
            usernameInput.removeAttribute('required');
            usernameInput.value = '';
        }
    });
    
    // Dynamic Skills
    const skillsContainer = document.getElementById('skills-container');
    window.addSkillInput = function() {
        const newItem = document.createElement('div');
        newItem.classList.add('input-group', 'mb-2', 'dynamic-item');
        newItem.innerHTML = `
            <input type="text" class="form-control skill-input" placeholder="Masukkan nama skill">
            <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item'))"><i class="bi bi-x-lg"></i></button>
        `;
        skillsContainer.appendChild(newItem);
    };

    window.removeDynamicItem = function(element) {
        element.remove();
        if (element.closest('#projects-container')) {
            reIndexProjects();
        }
    };
    
    // Dynamic Projects
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
                <input type="text" class="form-control project-title" placeholder="Nama Proyek">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control project-description" rows="2" placeholder="Deskripsi singkat proyek"></textarea>
            </div>
        `;
        projectsContainer.appendChild(newItem);
    });
    
    // Form Submission
    const form = document.getElementById('personilForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Enable username temporarily to include in form data
        if (createAccountCheck.checked) {
            usernameInput.removeAttribute('disabled');
        }
        
        const formData = new FormData(form);
        
        // Collect skills
        const skills = [];
        document.querySelectorAll('.skill-input').forEach(input => {
            if (input.value.trim()) {
                skills.push(input.value.trim());
            }
        });
        formData.append('skills', JSON.stringify(skills));
        
        // Collect projects
        const projects = [];
        document.querySelectorAll('#projects-container .dynamic-item').forEach(item => {
            const title = item.querySelector('.project-title').value.trim();
            const description = item.querySelector('.project-description').value.trim();
            if (title) {
                projects.push({ title, description });
            }
        });
        formData.append('projects', JSON.stringify(projects));
        
        // Add create_account flag
        formData.append('create_account', createAccountCheck.checked ? 'true' : 'false');
        
        // Show loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        
        try {
            const response = await fetch('/admin/personil/create', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Personil berhasil dibuat!');
                window.location.href = '/admin/personil';
            } else {
                alert('Error: ' + result.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                usernameInput.setAttribute('disabled', 'disabled');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan personil');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            usernameInput.setAttribute('disabled', 'disabled');
        }
    });
});
