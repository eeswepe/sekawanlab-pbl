document.addEventListener('DOMContentLoaded', function() {
    const personilId = document.getElementById('personilEditForm').dataset.personilId;
    let projectCounter = parseInt(document.getElementById('projects-container').dataset.projectCount || 0);

    // ===================================
    // 1. Sidebar Toggle Functionality
    // ===================================
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
    // 3. Dynamic Form: Skills (Add/Remove)
    // ===================================
    window.addSkillInput = function() {
        const container = document.getElementById('skills-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 dynamic-item';
        div.innerHTML = `
            <input type="text" class="form-control" placeholder="Nama skill">
            <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this)"><i class="bi bi-x-lg"></i></button>
        `;
        container.appendChild(div);
    };

    // Remove dynamic item
    window.removeDynamicItem = function(element) {
        const item = element.closest('.dynamic-item');
        if (item) item.remove();
    };

    // ===================================
    // 4. Dynamic Form: Projects (Add/Remove)
    // ===================================
    document.getElementById('addProjectBtn')?.addEventListener('click', function() {
        projectCounter++;
        const container = document.getElementById('projects-container');
        const div = document.createElement('div');
        div.className = 'dynamic-item';
        div.setAttribute('data-index', projectCounter);
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Project #${projectCounter}</h6>
                <button class="btn btn-sm btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item'))">Hapus</button>
            </div>
            <div class="mb-3">
                <label class="form-label">Judul Proyek</label>
                <input type="text" class="form-control project-title">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control project-description" rows="2"></textarea>
            </div>
        `;
        container.appendChild(div);
    });

    // ===================================
    // 5. Submit Form
    // ===================================
    document.getElementById('personilEditForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Gather skills
        const skills = [];
        document.querySelectorAll('#skills-container .dynamic-item input').forEach(input => {
            if (input.value.trim()) {
                skills.push(input.value.trim());
            }
        });

        // Gather projects
        const projects = [];
        document.querySelectorAll('#projects-container .dynamic-item').forEach(item => {
            const title = item.querySelector('.project-title')?.value || '';
            const description = item.querySelector('.project-description')?.value || '';
            if (title.trim()) {
                projects.push({ title: title.trim(), description: description.trim() });
            }
        });

        const data = {
            nama_lengkap: document.getElementById('namaLengkap').value,
            role: document.querySelector('input[name="tipePersonil"]:checked')?.value || 'talent',
            spesialisasi: document.getElementById('spesialisasi').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            location: document.getElementById('location').value,
            tanggal_bergabung: document.getElementById('tanggalBergabung').value,
            bio: document.getElementById('bio').value,
            skills: skills,
            projects: projects
        };

        try {
            const response = await fetch(`/admin/personil/update/${personilId}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                alert('Data personil berhasil diupdate!');
                window.location.href = '/admin/personil';
            } else {
                alert(result.message || 'Gagal update personil');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });

    // ===================================
    // 6. Delete Personil
    // ===================================
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', async function() {
        try {
            const response = await fetch(`/admin/personil/delete/${personilId}`, {
                method: 'DELETE'
            });

            const result = await response.json();

            if (result.success) {
                alert('Personil berhasil dihapus!');
                window.location.href = '/admin/personil';
            } else {
                alert(result.message || 'Gagal menghapus personil');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });
});
