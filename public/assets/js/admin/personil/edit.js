document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('personilEditForm');
    const personilId = form.dataset.personilId;
    
    const projectsContainer = document.getElementById('projects-container');
    const addProjectBtn = document.getElementById('addProjectBtn');
    const addSkillBtn = document.getElementById('addSkillBtn');
    const skillsContainer = document.getElementById('skills-container');
    const createAccountCheck = document.getElementById('createAccountCheck');
    const accountFields = document.getElementById('account-fields');
    const usernameInput = document.getElementById('username');
    const nimNipInput = document.getElementById('nimNip');

    // ===================================
    // 1. Initial State & Data
    // ===================================
    // Initial project index for adding new projects
    let projectCounter = parseInt(projectsContainer.dataset.projectCount || 0);

    // Initial check for Account Fields
    if (createAccountCheck.checked) {
        accountFields.style.display = 'flex';
        usernameInput.removeAttribute('disabled');
    } else {
        accountFields.style.display = 'none';
        usernameInput.setAttribute('disabled', 'disabled');
    }

    // ===================================
    // 2. Photo Preview Functionality
    // ===================================
    document.getElementById('photo')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photo-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // ===================================
    // 3. Account Fields Toggle
    // ===================================
    createAccountCheck.addEventListener('change', function() {
        if (this.checked) {
            accountFields.style.display = 'flex';
            usernameInput.removeAttribute('disabled');
            usernameInput.value = usernameInput.value || nimNipInput.value; // Use existing value or fill from NIM/NIP
        } else {
            accountFields.style.display = 'none';
            usernameInput.setAttribute('disabled', 'disabled');
        }
    });
    
    // Auto-fill username from nim_nip
    nimNipInput.addEventListener('input', function() {
        if (!usernameInput.value || usernameInput.value === this.value) { // Only auto-fill if empty or currently matching
             usernameInput.value = this.value;
        }
    });


    // ===================================
    // 4. Dynamic Elements: Skills
    // ===================================
    window.addSkillInput = function() {
        const newItem = document.createElement('div');
        newItem.classList.add('input-group', 'mb-2', 'dynamic-item-compact'); 
        newItem.innerHTML = `
            <input type="text" class="form-control skill-input" placeholder="Masukkan nama skill">
            <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item-compact'))"><i class="bi bi-x-lg"></i></button>
        `;
        skillsContainer.appendChild(newItem);
    };

    addSkillBtn.addEventListener('click', addSkillInput);

    // Reusable remove function for both Skills and Projects
    window.removeDynamicItem = function(element) {
        element.remove();
        if (element.closest('#projects-container')) {
            reIndexProjects();
        }
    };


    // ===================================
    // 5. Dynamic Elements: Projects
    // ===================================
    function reIndexProjects() {
        const projectItems = projectsContainer.querySelectorAll('.dynamic-item');
        let currentIdx = 1;
        projectItems.forEach(item => {
            item.querySelector('h6').textContent = `Project #${currentIdx}`;
            item.setAttribute('data-index', currentIdx);
            currentIdx++;
        });
        projectCounter = currentIdx - 1; // Update global index
    }

    function addProjectInput() {
        projectCounter++;
        const newItem = document.createElement('div');
        newItem.classList.add('dynamic-item');
        newItem.setAttribute('data-index', projectCounter);
        newItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Project #${projectCounter}</h6>
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
            <div class="mb-1">
                <small class="text-muted">Catatan: Fitur Tech Stack dinamis dihilangkan untuk fokus pada inti fungsionalitas.</small>
            </div>
        `;
        projectsContainer.appendChild(newItem);
    }

    addProjectBtn.addEventListener('click', addProjectInput);


    // ===================================
    // 6. Form Submission (Update)
    // ===================================
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Temporarily enable username if checked for submission
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
            const title = item.querySelector('.project-title')?.value.trim();
            const description = item.querySelector('.project-description')?.value.trim();
            if (title) {
                projects.push({ title, description });
            }
        });
        formData.append('projects', JSON.stringify(projects));
        
        // Add has_account flag
        formData.append('has_account', createAccountCheck.checked ? 'true' : 'false');

        // Show loading state
        const updateBtn = document.getElementById('updateBtn');
        const originalText = updateBtn.innerHTML;
        updateBtn.disabled = true;
        updateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
        
        try {
            const response = await fetch(`/admin/personil/update/${personilId}`, {
                method: 'POST', // Use POST for form data submission
                body: formData
            });

            // Re-disable username input after form data is prepared
            if (createAccountCheck.checked) {
                usernameInput.setAttribute('disabled', 'disabled');
            }
            
            const result = await response.json();

            if (result.success) {
                alert('Data personil berhasil diupdate!');
                window.location.href = '/admin/personil';
            } else {
                alert(result.message || 'Gagal update personil');
                updateBtn.disabled = false;
                updateBtn.innerHTML = originalText;
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
            updateBtn.disabled = false;
            updateBtn.innerHTML = originalText;
            // Re-disable username input in case of error
            if (createAccountCheck.checked) {
                usernameInput.setAttribute('disabled', 'disabled');
            }
        }
    });

    // ===================================
    // 7. Delete Personil
    // ===================================
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', async function() {
        const deleteBtn = this;
        const originalText = deleteBtn.innerHTML;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';

        try {
            const response = await fetch(`/admin/personil/delete/${personilId}`, {
                method: 'DELETE' // Use DELETE method
            });

            const result = await response.json();

            if (result.success) {
                // Manually hide modal after successful deletion
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
                modal?.hide(); 
                alert('Personil berhasil dihapus!');
                window.location.href = '/admin/personil';
            } else {
                alert(result.message || 'Gagal menghapus personil');
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = originalText;
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = originalText;
        }
    });
});