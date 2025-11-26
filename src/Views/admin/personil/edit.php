<?php
// --- SIMULASI DATA YANG DIAMBIL DARI DATABASE UNTUK DIEDIT ---
$personilId = 123;
$personil = [
    'id' => $personilId,
    'nama_lengkap' => 'Budi Setiawan, S.T., M.Kom.',
    'nim_nip' => '198012012005011001',
    'role' => 'dosen', // or 'talent'
    'spesialisasi' => 'Software Architecture, Clean Code',
    'email' => 'budi.setiawan@lab.ac.id',
    'phone' => '+6281234567890',
    'location' => 'Bandung, Indonesia',
    'tanggal_bergabung' => '2005-01-01',
    'bio' => "Dosen senior dengan keahlian mendalam di bidang arsitektur perangkat lunak dan pengembangan sistem skala besar. Mengawasi berbagai proyek riset dan pengembangan di SE Laboratory.",
    'photo_url' => 'https://via.placeholder.com/120/4e73df/ffffff?text=BS', // Dummy URL
    'linkedin' => 'https://linkedin.com/in/budisetiawan-se',
    'github' => 'https://github.com/budisetiawan-dev',
    'website' => 'https://budisetiawan.id',
    'has_account' => true,
    'username' => '198012012005011001'
];

$skills = [
    'PHP (Laravel)',
    'Vue.js',
    'Docker',
    'Agile/Scrum',
    'REST API Design'
];

$projects = [
    [
        'title' => 'Laboratory Management System',
        'description' => 'Sistem internal untuk manajemen inventaris, aset, dan jadwal lab.',
    ],
    [
        'title' => 'Smart E-Voting Platform',
        'description' => 'Platform voting online untuk pemilihan ketua laboratorium dan acara internal.',
    ]
];
// --- AKHIR SIMULASI DATA ---

$skills_json = htmlspecialchars(json_encode($skills), ENT_QUOTES, 'UTF-8');
$projects_json = htmlspecialchars(json_encode($projects), ENT_QUOTES, 'UTF-8');
$project_count = count($projects);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personil: <?= htmlspecialchars($personil['nama_lengkap']) ?></title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/admin/personil/edit.css">

</head>
<body id="page-top" class="bg-light">

    <div id="wrapper">
        
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="sidebar">
            
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
                <div class="logo-icon rotate-n-15">SE</div>
                <div class="sidebar-brand-text mx-3">SE Laboratory</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Management
            </div>

            <li class="nav-item">
                <a class="nav-link" href="/admin/blog-list">
                    <i class="bi bi-pencil-square"></i>
                    <span>Blog Management</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="/admin/personil">
                    <i class="bi bi-people-fill"></i>
                    <span>Personil Management</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admin/profil-pages">
                    <i class="bi bi-person-badge"></i>
                    <span>Profile Pages</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admin/join-applications">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Join Applications</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            
            <li class="nav-item">
                <a class="nav-link" href="/logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </li>

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleMobile" class="btn btn-link d-md-none rounded-circle me-3">
                        <i class="bi bi-list fs-4"></i>
                    </button>

                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">Admin User</span>
                                <img class="img-profile rounded-circle" src="https://via.placeholder.com/60/4e73df/ffffff?text=AU">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2 text-gray-400"></i>Profile</a>
                                <a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2 text-gray-400"></i>Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="bi bi-box-arrow-left me-2 text-gray-400"></i>Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="container-fluid">
                    <div class="page-header d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Edit Personil: <?= htmlspecialchars($personil['nama_lengkap']) ?></h1>
                            <p class="text-muted">Perbarui informasi detail personil di bawah ini.</p>
                        </div>
                        <div>
                             <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
                                <i class="bi bi-trash-fill me-2"></i> Hapus Personil
                            </button>
                        </div>
                    </div>

                    <form id="personilEditForm" method="POST" enctype="multipart/form-data" data-personil-id="<?= $personilId ?>">
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">1. Data Pribadi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 text-center mb-4">
                                        <label class="form-label">Upload Foto (Optional)</label>
                                        <div class="d-flex flex-column align-items-center">
                                            <img id="photo-preview" src="<?= htmlspecialchars($personil['photo_url']) ?>" alt="Foto Profil">
                                            <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="mb-3">
                                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="namaLengkap" name="nama_lengkap" value="<?= htmlspecialchars($personil['nama_lengkap']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nimNip" class="form-label">NIM / NIP</label>
                                            <input type="text" class="form-control" id="nimNip" name="nim_nip" value="<?= htmlspecialchars($personil['nim_nip']) ?>" required>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tipe Personil</label>
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="role" id="tipeDosen" value="dosen" <?= $personil['role'] === 'dosen' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="tipeDosen">Dosen Pembimbing</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="role" id="tipeTalent" value="talent" <?= $personil['role'] === 'talent' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="tipeTalent">Talent/Geeks</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                            <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" value="<?= htmlspecialchars($personil['spesialisasi']) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">2. Kontak & Bio</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($personil['email']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($personil['phone']) ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($personil['location']) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggalBergabung" class="form-label">Tanggal Bergabung</label>
                                        <input type="date" class="form-control" id="tanggalBergabung" name="tanggal_bergabung" value="<?= htmlspecialchars($personil['tanggal_bergabung']) ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Tentang (Bio)</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="4"><?= htmlspecialchars($personil['bio']) ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">3. Skills</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Perbarui daftar skill teknis yang dimiliki.</p>
                                <div id="skills-container" data-skills-json="<?= $skills_json ?>">
                                    <?php foreach ($skills as $skill) : ?>
                                        <div class="input-group mb-2 dynamic-item-compact">
                                            <input type="text" class="form-control skill-input" placeholder="Masukkan nama skill" value="<?= htmlspecialchars($skill) ?>">
                                            <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item-compact'))"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="addSkillBtn">
                                    <i class="bi bi-plus-circle me-2"></i> Tambah Skill
                                </button>
                            </div>
                        </div>
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">4. Social Media</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="linkedin" class="form-label">LinkedIn URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                        <input type="url" class="form-control" id="linkedin" name="linkedin" value="<?= htmlspecialchars($personil['linkedin']) ?>" placeholder="https://linkedin.com/in/username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="github" class="form-label">GitHub URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-github"></i></span>
                                        <input type="url" class="form-control" id="github" name="github" value="<?= htmlspecialchars($personil['github']) ?>" placeholder="https://github.com/username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="url" class="form-control" id="website" name="website" value="<?= htmlspecialchars($personil['website']) ?>" placeholder="https://personil.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">5. Projects</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Perbarui daftar proyek yang pernah dikerjakan personil.</p>
                                <div id="projects-container" data-projects-json="<?= $projects_json ?>" data-project-count="<?= $project_count ?>">
                                    <?php $p_index = 1; foreach ($projects as $project) : ?>
                                        <div class="dynamic-item" data-index="<?= $p_index++ ?>">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">Project #<?= $p_index - 1 ?></h6>
                                                <button class="btn btn-sm btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item'))">Hapus</button>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Judul Proyek</label>
                                                <input type="text" class="form-control project-title" placeholder="Nama Proyek" value="<?= htmlspecialchars($project['title']) ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control project-description" rows="2" placeholder="Deskripsi singkat proyek"><?= htmlspecialchars($project['description']) ?></textarea>
                                            </div>
                                            <div class="mb-1">
                                                <small class="text-muted">Catatan: Fitur Tech Stack dinamis dihilangkan untuk fokus pada inti fungsionalitas.</small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="addProjectBtn">
                                    <i class="bi bi-plus-circle me-2"></i> Tambah Project
                                </button>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">6. Account (Optional)</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="createAccountCheck" <?= $personil['has_account'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="createAccountCheck">
                                        Personil ini memiliki akun pengguna? (Centang untuk mengaktifkan/mengubah pengaturan akun)
                                    </label>
                                </div>
                                
                                <div id="account-fields" class="row" style="display: <?= $personil['has_account'] ? 'flex' : 'none' ?>;">
                                    <div class="col-md-12 mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($personil['username']) ?>" placeholder="Masukkan username unik" <?= $personil['has_account'] ? '' : 'disabled' ?>>
                                        <small class="text-muted">Username digunakan untuk login. Password akan diatur melalui proses terpisah.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mb-5">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="bi bi-x-lg me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" id="updateBtn">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Update Personil
                            </button>
                        </div>
                    </form>
                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span class="text-gray-600">&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="bi bi-angle-up"></i>
    </a>

    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin menghapus data personil **<?= htmlspecialchars($personil['nama_lengkap']) ?>**? Aksi ini tidak dapat dibatalkan.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><i class="bi bi-trash me-2"></i> Hapus Permanen</button>
          </div>
        </div>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple Sidebar Toggle for SB Admin 2 structure
        document.querySelector('#sidebarToggle, #sidebarToggleMobile')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('body').classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });
    </script>
    <script src="/assets/js/admin/personil/edit.js"></script>

</body>
</html>