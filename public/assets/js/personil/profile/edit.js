// Sidebar Toggle
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

    if (toggleButton) {
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('toggled');
            mainContent.classList.toggle('toggled');
        });
    }

    if (window.innerWidth < 992) {
        sidebar.classList.add('toggled');
        mainContent.classList.add('toggled');
    }
});

// Image Preview
document.getElementById('profilePhoto')?.addEventListener('change', function(e) {
    const preview = document.getElementById('avatarPreview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => preview.src = e.target.result;
        reader.readAsDataURL(file);
    }
});

// Skills Management
let deletedProjects = [];

document.getElementById('addSkillBtn')?.addEventListener('click', function() {
    const input = document.getElementById('skillInput');
    const skill = input.value.trim();
    
    if (skill) {
        const container = document.getElementById('skillsContainer');
        const tag = document.createElement('span');
        tag.className = 'skill-tag';
        tag.dataset.skill = skill;
        tag.innerHTML = `${skill} <button type="button" class="btn-close"></button>`;
        container.appendChild(tag);
        input.value = '';
    }
});

document.getElementById('skillsContainer')?.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-close')) {
        e.target.parentElement.remove();
    }
});

// Project Management
let projectCounter = document.querySelectorAll('.project-item').length;

document.getElementById('addProjectBtn')?.addEventListener('click', function() {
    projectCounter++;
    const container = document.getElementById('projectsContainer');
    const projectDiv = document.createElement('div');
    projectDiv.className = 'project-item';
    projectDiv.dataset.projectId = '0';
    projectDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h6 class="mb-0 text-dark">Proyek #${projectCounter}</h6>
            <button type="button" class="btn btn-danger btn-sm btn-remove-project">
                <i class="bi bi-trash-fill"></i> Hapus
            </button>
        </div>
        <div class="mb-3">
            <label class="form-label">Judul Proyek</label>
            <input type="text" class="form-control project-title" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control project-description" rows="3" required></textarea>
        </div>
    `;
    container.appendChild(projectDiv);
});

document.getElementById('projectsContainer')?.addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove-project')) {
        const projectItem = e.target.closest('.project-item');
        const projectId = parseInt(projectItem.dataset.projectId);
        
        if (projectId > 0) {
            deletedProjects.push(projectId);
        }
        projectItem.remove();
    }
});

// Form Submission
document.getElementById('editProfileForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    
    const formData = new FormData(this);
    
    // Collect skills
    const skills = [];
    document.querySelectorAll('.skill-tag').forEach(tag => {
        skills.push(tag.dataset.skill);
    });
    
    // Add skills as individual array items, not JSON string
    skills.forEach(skill => {
        formData.append('skills[]', skill);
    });
    
    // Collect projects
    const projects = [];
    document.querySelectorAll('.project-item').forEach(item => {
        const projectId = parseInt(item.dataset.projectId) || 0;
        const title = item.querySelector('.project-title').value;
        const description = item.querySelector('.project-description').value;
        
        projects.push({ id: projectId, title, description });
    });
    formData.append('projects', JSON.stringify(projects));
    
    // Deleted projects
    formData.append('deleted_projects', JSON.stringify(deletedProjects));
    
    fetch('/personil/profile/update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile berhasil diupdate!');
            window.location.href = data.redirect;
        } else {
            alert('Error: ' + data.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
