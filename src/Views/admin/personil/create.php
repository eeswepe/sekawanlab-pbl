<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Personil - SE Laboratory</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/admin/personil/create.css">

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
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-bell-fill"></i>
                                <span class="badge bg-danger badge-counter">3+</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Alerts Center</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="me-3"><div class="icon-circle bg-primary"><i class="bi bi-file-earmark-text text-white"></i></div></div>
                                    <div><div class="small text-gray-500">November 25, 2025</div><span class="font-weight-bold">New Personil Application!</span></div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Personil Baru</h1>
                            <p class="text-muted">Isi formulir di bawah ini untuk menambahkan personil (Dosen/Talent) baru ke sistem.</p>
                        </div>
                    </div>

                    <form id="personilForm" method="POST" enctype="multipart/form-data">
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">1. Data Pribadi</h5>
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
                                        <div class="mb-3">
                                            <label for="nimNip" class="form-label">NIM / NIP</label>
                                            <input type="text" class="form-control" id="nimNip" name="nim_nip" placeholder="Masukkan NIM (mahasiswa) atau NIP (dosen)" required>
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

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">2. Kontak & Bio</h5>
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
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">3. Skills</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Tambahkan daftar skill atau kemampuan teknis yang dimiliki (Contoh: Python, React, Scrum).</p>
                                <div id="skills-container">
                                    <div class="input-group mb-2 dynamic-item">
                                        <input type="text" class="form-control skill-input" placeholder="Masukkan nama skill">
                                        <button class="btn btn-danger" type="button" onclick="removeDynamicItem(this.closest('.dynamic-item'))"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="addSkillInput()">
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
                                        <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="github" class="form-label">GitHub URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-github"></i></span>
                                        <input type="url" class="form-control" id="github" name="github" placeholder="https://github.com/username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="url" class="form-control" id="website" name="website" placeholder="https://personil.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">5. Projects</h5>
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

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">6. Account (Optional)</h5>
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
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username unik" disabled>
                                        <small class="text-muted">Username akan otomatis diisi dari NIM/NIP. Password akan diatur melalui proses terpisah</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mb-5">
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i> Save Personil
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

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple Sidebar Toggle for SB Admin 2 structure
        document.querySelector('#sidebarToggle, #sidebarToggleMobile').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('body').classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });
    </script>
    <script src="/assets/js/admin/personil/create.js"></script>

</body>
</html>