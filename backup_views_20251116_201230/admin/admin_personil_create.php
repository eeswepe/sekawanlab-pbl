<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Personil - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin_personil_create.css">

    
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
                        <h1>Tambah Personil Baru</h1>
                        <p>Isi formulir di bawah ini untuk menambahkan personil (Dosen/Talent) baru ke sistem.</p>
                    </div>
                </div>

                <form id="personilForm" method="POST" enctype="multipart/form-data">
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">1. Data Pribadi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 text-center mb-4">
                                    <label class="form-label">Upload Foto (Optional)</label>
                                    <div class="d-flex flex-column align-items-center">
                                        <img id="photo-preview" src="https://via.placeholder.com/120/f8f9fa/adb5bd?text=No+Photo" alt="Foto Profil">
                                        <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="mb-3">
                                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="namaLengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap personil" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tipe Personil</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="role" id="tipeDosen" value="dosen" checked>
                                                    <label class="form-check-label" for="tipeDosen">Dosen Pembimbing</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="role" id="tipeTalent" value="talent">
                                                    <label class="form-check-label" for="tipeTalent">Talent/Geeks</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                        <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" placeholder="Contoh: Machine Learning, UI/UX Design">
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
                                    <input type="email" class="form-control" id="email" name="email" placeholder="contoh@lab.ac.id" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+62 812 XXXX XXXX" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Contoh: Jakarta, Indonesia">
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggalBergabung" class="form-label">Tanggal Bergabung</label>
                                    <input type="date" class="form-control" id="tanggalBergabung" name="tanggal_bergabung" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Tentang (Bio)</label>
                                <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Tuliskan deskripsi singkat mengenai personil"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">3. Skills</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Tambahkan daftar skill atau kemampuan teknis yang dimiliki (Contoh: Python, React, Scrum).</p>
                            <div id="skills-container">
                                <div class="input-group mb-2 dynamic-item">
                                    <input type="text" class="form-control skill-input" placeholder="Masukkan nama skill">
                                    <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this)"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="addSkillInput()">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Skill
                            </button>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">4. Social Media</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">LinkedIn URL</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                    <input type="url" class="form-control" id="linkedin" placeholder="https://linkedin.com/in/username">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="github" class="form-label">GitHub URL</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-github"></i></span>
                                    <input type="url" class="form-control" id="github" placeholder="https://github.com/username">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="website" class="form-label">Website URL</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="url" class="form-control" id="website" placeholder="https://personil.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">5. Projects</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Daftar proyek yang pernah dikerjakan personil.</p>
                            <div id="projects-container">
                                <div class="dynamic-item" data-index="1">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Project #1</h6>
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
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="addProjectBtn">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Project
                            </button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">6. Account (Optional)</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="createAccountCheck">
                                <label class="form-check-label" for="createAccountCheck">
                                    Buat akun pengguna untuk personil ini?
                                </label>
                            </div>
                            
                            <div id="account-fields" class="row" style="display: none;">
                                <div class="col-md-12 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username unik">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Konfirmasi password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mb-5">
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-2"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save me-2"></i> Save Personil
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
    <script src="/js/admin_personil_create.js"></script>

</body>
</html>