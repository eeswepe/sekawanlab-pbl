document.addEventListener('DOMContentLoaded', function() {
    
    // Catatan: Logika sidebar toggle telah dipindahkan ke file HTML/PHP utama 
    // agar sesuai dengan mekanisme SB Admin 2 (menambahkan kelas pada body/sidebar).
    
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
            // Enable username field to be sent with form data
            usernameInput.removeAttribute('disabled'); 
        } else {
            accountFields.style.display = 'none';
            usernameInput.removeAttribute('required');
            usernameInput.value = '';
            // Disable username field again
            usernameInput.setAttribute('disabled', 'disabled'); 
        }
    });
    
    // Dynamic Skills
    const skillsContainer = document.getElementById('skills-container');
    window.addSkillInput = function() {
        const newItem = document.createElement('div');
        newItem.classList.add('input-group', 'mb-2', 'dynamic-item-compact'); 
        newItem.innerHTML = `
            <input type="text" class="form-control skill-input" placeholder="Masukkan nama skill">
            <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item-compact'))"><i class="bi bi-x-lg"></i></button>
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
    let projectIndex = projectsContainer.querySelectorAll('.dynamic-item').length; 

    function reIndexProjects() {
        const projectItems = projectsContainer.querySelectorAll('.dynamic-item');
        let currentIdx = 1;
        projectItems.forEach(item => {
            item.querySelector('h6').textContent = `Project #${currentIdx}`;
            item.setAttribute('data-index', currentIdx);
            currentIdx++;
        });
        projectIndex = currentIdx - 1; // Update global index
    }
    
    // Initial indexing for existing item
    reIndexProjects(); 

    addProjectBtn.addEventListener('click', function() {
        projectIndex++; // Increment index for new item
        const newItem = document.createElement('div');
        newItem.classList.add('dynamic-item');
        newItem.setAttribute('data-index', projectIndex);
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
    
    // Form Submission
    const form = document.getElementById('personilForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Ensure username is enabled if account creation is checked
        if (createAccountCheck.checked) {
            usernameInput.removeAttribute('disabled');
        } else {
            usernameInput.setAttribute('disabled', 'disabled');
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
            
            // Re-disable username input after form data is constructed (before API call is crucial, but keeping it here for safety after it's been sent)
            if (createAccountCheck.checked) {
                usernameInput.setAttribute('disabled', 'disabled');
            }
            
            const result = await response.json();
            
            if (result.success) {
                alert('Personil berhasil dibuat!');
                window.location.href = '/admin/personil';
            } else {
                alert('Error: ' + result.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan personil');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            // Re-disable username input in case of error
            if (createAccountCheck.checked) {
                usernameInput.setAttribute('disabled', 'disabled');
            }
        }
    });
});