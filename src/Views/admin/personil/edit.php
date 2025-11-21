<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personil - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/admin/personil/edit.css">


</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div>
                <div class="brand"><span class="logo-icon">SE</span> SE Laboratory</div>
                <ul class="sidebar-menu">
                    <li><a href="/admin"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/admin/blog-list"><i class="bi bi-pencil-square"></i> Blog Management</a></li>
                    <li><a href="/admin/personil" class="active"><i class="bi bi-people-fill"></i> Personil Management</a></li>
                    <li><a href="/admin/profil-pages"><i class="bi bi-person-badge"></i> Profile Pages</a></li>
                    <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join Applications</a></li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>

        <div id="main-content">
            <nav id="topbar" class="navbar navbar-expand-lg">
                <div class="container-fluid d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center">
                        <button class="btn sidebar-toggle sidebar-toggle-mobile" id="sidebarToggleMobile">
                            <i class="bi bi-list"></i>
                        </button>

                        <form class="d-none d-md-inline-block ms-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <button class="btn" style="background-color: var(--gold); color: white;" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <ul class="navbar-nav topbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-bell-fill"></i>
                                <span class="notification-badge">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-text"></i> New Application</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-chat-dots"></i> New Comment</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Show All Alerts</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle profile-dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="https://via.placeholder.com/150" alt="Profile Picture">
                                <span class="d-none d-md-inline">Admin User</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../login.html"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>

            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Edit Data Personil</h1>
                        <p>Perbarui informasi untuk **<?= htmlspecialchars($personil['nama_lengkap']) ?> (<?= htmlspecialchars(ucfirst($personil['role'])) ?>)**.</p>
                    </div>
                </div>

                <form id="personilEditForm" data-personil-id="<?= $personil['id'] ?>">
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">1. Data Pribadi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 text-center mb-4">
                                    <label class="form-label">Foto Profil Saat Ini</label>
                                    <div class="d-flex flex-column align-items-center">
                                        <img id="photo-preview" src="<?= !empty($personil['foto_url']) ? htmlspecialchars($personil['foto_url']) : 'https://via.placeholder.com/120/D4AF37/FFFFFF?text=' . strtoupper(substr($personil['nama_lengkap'], 0, 2)) ?>" alt="Foto Profil">
                                        <input class="form-control mt-3" type="file" id="photo" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="mb-3">
                                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="namaLengkap" value="<?= htmlspecialchars($personil['nama_lengkap']) ?>" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tipe Personil</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipePersonil" id="tipeDosen" value="dosen" <?= $personil['role'] === 'dosen' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="tipeDosen">Dosen Pembimbing</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipePersonil" id="tipeTalent" value="talent" <?= $personil['role'] === 'talent' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="tipeTalent">Talent/Geeks</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                            <input type="text" class="form-control" id="spesialisasi" value="<?= htmlspecialchars($personil['spesialisasi'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">2. Kontak & Bio</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($personil['email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" value="<?= htmlspecialchars($personil['phone'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" value="<?= htmlspecialchars($personil['location'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggalBergabung" class="form-label">Tanggal Bergabung</label>
                                    <input type="date" class="form-control" id="tanggalBergabung" value="<?= htmlspecialchars($personil['tanggal_bergabung'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Tentang (Bio)</label>
                                <textarea class="form-control" id="bio" rows="4"><?= htmlspecialchars($personil['bio'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">3. Skills</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Tambahkan daftar skill atau kemampuan teknis yang dimiliki.</p>
                            <div id="skills-container">
                                <?php if (!empty($personil['skills'])): ?>
                                    <?php foreach ($personil['skills'] as $skill): ?>
                                        <div class="input-group mb-2 dynamic-item">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($skill) ?>">
                                            <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this)"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="addSkillInput()">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Skill
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">4. Projects</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Daftar proyek yang pernah dikerjakan personil.</p>
                            <div id="projects-container" data-project-count="<?= count($personil['projects'] ?? []) ?>">
                                <?php if (!empty($personil['projects'])): ?>
                                    <?php foreach ($personil['projects'] as $index => $project): ?>
                                        <div class="dynamic-item" data-index="<?= $index + 1 ?>">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">Project #<?= $index + 1 ?></h6>
                                                <button class="btn btn-sm btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item'))">Hapus</button>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Judul Proyek</label>
                                                <input type="text" class="form-control project-title" value="<?= htmlspecialchars($project['title']) ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control project-description" rows="2"><?= htmlspecialchars($project['description']) ?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="addProjectBtn">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Project
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-3 mb-5">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
                            <i class="bi bi-trash me-2"></i> Delete Personil
                        </button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="bi bi-x-lg me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-arrow-clockwise me-2"></i> Update Data
                            </button>
                        </div>
                    </div>
                </form>

            </main>

            <footer class="footer">
                <div class="container-fluid text-center">
                    <span class="text-muted">&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                </div>
            </footer>

        </div>
    </div>
    
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <script src="/assets/js/admin/personil/edit.js"></script>

</body>
</html>