document.addEventListener('DOMContentLoaded', function() {
    // 1. Logika Sidebar Toggle (Diambil dari dashboard.html)
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

    function toggleSidebar() {
        sidebar.classList.toggle('toggled');
        mainContent.classList.toggle('toggled');
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }
    
    // Set default toggle state for mobile
    if (window.innerWidth < 992) {
        sidebar.classList.add('toggled');
        mainContent.classList.add('toggled');
    }
    
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('toggled');
            mainContent.classList.remove('toggled');
        } else {
            sidebar.classList.add('toggled');
            mainContent.classList.add('toggled');
        }
    });

    // 2. Event Listener untuk Skill Input (Memungkinkan 'Enter' untuk menambah skill)
    const skillInput = document.getElementById('skillInput');
    if (skillInput) {
        skillInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                // Memanggil fungsi global addSkill yang didefinisikan di luar DOMContentLoaded jika perlu.
                // Dalam konteks ini, kita definisikan di dalam untuk memastikan akses, tapi lebih baik global.
                // Karena kita harus mendefinisikannya secara global (lihat bawah), kita abaikan di sini.
            }
        });
    }

});

// 3. Fungsi Image Preview (Dibuat global agar bisa dipanggil dari HTML onchange)
function previewImage(event) {
    const preview = document.getElementById('avatarPreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// 4. Fungsi Dynamic Skills (Dibuat global agar bisa dipanggil dari HTML onclick)
const skillsContainer = document.getElementById('skillsContainer');
const skillInput = document.getElementById('skillInput');

// Inisialisasi skillInput jika belum dilakukan di DOMContentLoaded (penting untuk akses global)
document.addEventListener('DOMContentLoaded', () => {
    // Re-inisialisasi agar fungsi addSkill/removeSkill bisa diakses
    // SkillInput Event Listener dibuat di sini untuk memastikan elemen sudah dimuat
    const skillInput = document.getElementById('skillInput');
    if (skillInput) {
        skillInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkill();
            }
        });
    }
});


function addSkill() {
    const skillInput = document.getElementById('skillInput');
    const skillsContainer = document.getElementById('skillsContainer');

    const skillValue = skillInput.value.trim();
    if (skillValue && skillValue.length > 0) {
        const existingSkills = skillsContainer.querySelectorAll('.skill-tag');
        let isDuplicate = false;
        existingSkills.forEach(tag => {
            if (tag.getAttribute('data-skill').toLowerCase() === skillValue.toLowerCase()) {
                isDuplicate = true;
            }
        });

        if (isDuplicate) {
            alert('Skill sudah ada!');
            skillInput.value = '';
            return;
        }

        const newTag = document.createElement('span');
        newTag.classList.add('skill-tag');
        newTag.setAttribute('data-skill', skillValue);
        newTag.innerHTML = `${skillValue} <button type="button" class="btn-close" onclick="removeSkill(this)"></button>`;
        
        skillsContainer.appendChild(newTag);
        skillInput.value = ''; // Clear input
    }
}

function removeSkill(button) {
    const tagToRemove = button.parentElement;
    tagToRemove.remove(); // Menggunakan .remove() yang lebih modern
}


// 5. Fungsi Dynamic Projects (Dibuat global agar bisa dipanggil dari HTML onclick)
let projectCount = 1; // Start with 1 since we have an initial project in HTML

function addProject() {
    const projectsContainer = document.getElementById('projectsContainer');

    projectCount++;
    const newId = `project-${projectCount}`;
    const newProjectHtml = `
        <div class="project-item" id="${newId}">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="mb-0 text-dark">Proyek Baru #${projectCount}</h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProject('${newId}')">
                    <i class="bi bi-trash-fill"></i> Hapus
                </button>
            </div>
            <div class="mb-3">
                <label class="form-label">Judul Proyek</label>
                <input type="text" class="form-control" placeholder="Judul Proyek">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" rows="3" placeholder="Deskripsi singkat proyek"></textarea>
            </div>
            <div class="mb-0">
                <label class="form-label">Tech Stack</label>
                <input type="text" class="form-control" placeholder="Contoh: React, Node.js, MongoDB">
            </div>
        </div>
    `;
    projectsContainer.insertAdjacentHTML('beforeend', newProjectHtml);
}

function removeProject(id) {
    const projectToRemove = document.getElementById(id);
    if (projectToRemove) {
        if (confirm('Apakah Anda yakin ingin menghapus proyek ini?')) {
            projectToRemove.remove();
        }
    }
}