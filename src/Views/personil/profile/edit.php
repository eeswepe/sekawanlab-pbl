<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/personil/profile/edit.css"> 
</head>
<body>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="../dashboard.html">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li><a href="/personil"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li><a href="/personil/profile" class="active"><i class="bi bi-person-circle"></i> My Profile</a></li>
                <li><a href="/personil/blog"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
                <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
        </nav>
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
                                <img src="<?= htmlspecialchars($personil['foto_url'] ?? 'https://via.placeholder.com/150/1a1a1a/FFFFFF?text=P') ?>" alt="Profile Picture">
                                <span class="d-none d-md-inline"><?= htmlspecialchars($personil['nama_lengkap']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="/personil/profile"><i class="bi bi-person-fill"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Edit Profile</h1>
                        <p>Perbarui informasi pribadi dan profesional Anda.</p>
                    </div>
                </div>

                <form id="editProfileForm" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="card text-center">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-person-fill me-2" style="color: var(--gold);"></i> Info Akun (Read-only)</h5>
                                </div>
                                <div class="card-body">
                                    <img src="<?= htmlspecialchars($personil['foto_url'] ?? 'https://via.placeholder.com/150/D4AF37/FFFFFF?text=' . substr($personil['nama_lengkap'], 0, 1)) ?>" 
                                        alt="Current Profile Picture" 
                                        class="avatar-preview mb-3" 
                                        id="avatarPreview">

                                    <div class="mb-3">
                                        <label for="profilePhoto" class="form-label text-start w-100">Upload Foto Baru</label>
                                        <input class="form-control" type="file" id="profilePhoto" name="foto_url" accept="image/*">
                                    </div>

                                    <hr>

                                    <div class="mb-3 text-start">
                                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="namaLengkap" value="<?= htmlspecialchars($personil['nama_lengkap']) ?>" readonly>
                                        <small class="text-muted">Nama hanya bisa diubah oleh Administrator.</small>
                                    </div>
                                    
                                    <div class="mb-3 text-start">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" class="form-control" id="role" value="<?= htmlspecialchars(ucfirst($personil['role'])) ?>" readonly>
                                    </div>
                                    
                                    <div class="mb-0 text-start">
                                        <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                        <input type="text" class="form-control" id="spesialisasi" value="<?= htmlspecialchars($personil['spesialisasi'] ?? '-') ?>" readonly>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-info-circle-fill me-2" style="color: var(--gold);"></i> Bio & Kontak</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label for="bio" class="form-label">Tentang Anda (Bio)</label>
                                        <textarea class="form-control" id="bio" name="bio" rows="5" placeholder="Tuliskan deskripsi singkat mengenai pengalaman dan fokus Anda."><?= htmlspecialchars($personil['bio'] ?? '') ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($personil['email']) ?>" required>
                                    </div>
                                    
                                    <div class="mb-0">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($personil['phone']) ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-lightning-fill me-2" style="color: var(--gold);"></i> Skills</h5>
                                </div>
                                <div class="card-body">
                                    <div id="skillsContainer" class="d-flex flex-wrap align-items-center mb-3">
                                        <?php if (!empty($personil['skills'])): ?>
                                            <?php foreach ($personil['skills'] as $skill): ?>
                                                <span class="skill-tag" data-skill="<?= htmlspecialchars($skill) ?>"><?= htmlspecialchars($skill) ?> <button type="button" class="btn-close"></button></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="skillInput" placeholder="Tambahkan skill baru (mis: Docker)">
                                        <button class="btn btn-primary-custom" type="button" id="addSkillBtn">
                                            <i class="bi bi-plus me-2"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0"><i class="bi bi-folder-fill me-2" style="color: var(--gold);"></i> Projects</h5>
                                    <button class="btn btn-primary-custom btn-sm" type="button" id="addProjectBtn">
                                        <i class="bi bi-plus-lg me-2"></i> Tambah Proyek
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="projectsContainer">
                                        <?php if (!empty($projects)): ?>
                                            <?php foreach ($projects as $index => $project): ?>
                                                <div class="project-item" data-project-id="<?= $project['id'] ?>">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <h6 class="mb-0 text-dark">Proyek #<?= $index + 1 ?></h6>
                                                        <button type="button" class="btn btn-danger btn-sm btn-remove-project">
                                                            <i class="bi bi-trash-fill"></i> Hapus
                                                        </button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul Proyek</label>
                                                        <input type="text" class="form-control project-title" value="<?= htmlspecialchars($project['title']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea class="form-control project-description" rows="3" required><?= htmlspecialchars($project['description']) ?></textarea>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-3 mt-4 mb-5">
                        <a href="/personil/profile" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle-fill me-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save-fill me-2"></i> Save Changes
                        </button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/personil/profile/edit.js"></script>
</body>
</html>