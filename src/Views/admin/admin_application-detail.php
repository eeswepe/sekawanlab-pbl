<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Detail (18021234) - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin_application-detail.css">
</head>
<body>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="dashboard.html">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li class="sidebar-nav-item">
                    <a href="dashboard.html" class="sidebar-nav-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="blog-list.html" class="sidebar-nav-link">
                        <i class="bi bi-pencil-square"></i>
                        <span>Blog Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Personil Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-file-person"></i>
                        <span>Profile Pages</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="admin_applications-list.html" class="sidebar-nav-link active">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Join Applications</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="../login.html" class="sidebar-nav-link">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </li>
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

                <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1>Detail Aplikasi: Joko Susilo</h1>
                        <p>Tinjauan lengkap aplikasi bergabung dari mahasiswa dengan NIM: 18021234.</p>
                    </div>
                </div>

                <a href="admin_applications-list.html" class="btn btn-outline-secondary mb-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Aplikasi
                </a>

                <div class="row g-3">
                    <div class="col-lg-8">

                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h5 class="card-title mb-0 me-3">Status Aplikasi:</h5>
                                </div>
                                <div class="mt-2 mt-sm-0">
                                    <span class="badge badge-status bg-warning text-dark">
                                        <i class="bi bi-hourglass-split me-1"></i> PENDING
                                    </span>
                                    <span class="ms-3 text-muted small">
                                        Tanggal Apply: 10 Nov 2025
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill me-2"></i> Data Pribadi & Akademik</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <span class="detail-label">Nama Lengkap</span>
                                            <span class="detail-value">Joko Susilo</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">NIM</span>
                                            <span class="detail-value">18021234</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Email</span>
                                            <span class="detail-value">joko.susilo@mail.com</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Nomor Telepon</span>
                                            <span class="detail-value">+62 812-3456-7890</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <span class="detail-label">Program Studi (Prodi)</span>
                                            <span class="detail-value">Software Engineering</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Semester Aktif</span>
                                            <span class="detail-value">5</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">IPK Terakhir</span>
                                            <span class="detail-value">3.75</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Tanggal Lahir</span>
                                            <span class="detail-value">12 Januari 2000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-lightbulb-fill me-2"></i> Motivasi & Kompetensi</h5>
                            </div>
                            <div class="card-body">
                                <div class="detail-item">
                                    <span class="detail-label">Alasan Bergabung (Motivasi)</span>
                                    <p class="detail-value" style="white-space: pre-wrap;">Saya ingin berkontribusi aktif dalam proyek riset laboratorium, khususnya dalam pengembangan aplikasi web skala besar. Saya melihat lab SE memiliki fokus yang sejalan dengan minat saya di bidang arsitektur mikroservis dan *cloud computing*.</p>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Link Portfolio (GitHub/Lainnya)</span>
                                    <a href="https://github.com/jokosusilo" target="_blank" class="detail-value">https://github.com/jokosusilo <i class="bi bi-box-arrow-up-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-paperclip me-2"></i> Dokumen Lampiran (CV)</h5>
                            </div>
                            <div class="card-body">
                                <span class="detail-label">Nama File:</span>
                                <span class="detail-value d-block mb-3">CV_Joko_Susilo_18021234.pdf</span>
                                
                                <a href="#" class="btn btn-sm btn-outline-secondary me-2">
                                    <i class="bi bi-download me-1"></i> Download CV
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#cvPreviewModal">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Preview (Jika PDF)
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-arrow-repeat me-2"></i> Update Status</h5>
                            </div>
                            <div class="card-body">
                                <form id="updateStatusForm">
                                    <div class="mb-3">
                                        <label for="newStatus" class="form-label">Ubah Status Menjadi</label>
                                        <select class="form-select" id="newStatus">
                                            <option value="pending" selected>Pending</option>
                                            <option value="reviewed">Reviewed</option>
                                            <option value="accepted">Accepted</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary-custom w-100">
                                        <i class="bi bi-save me-2"></i> Simpan Status Baru
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-journal-text me-2"></i> Catatan Admin</h5>
                            </div>
                            <div class="card-body">
                                <form id="adminNotesForm">
                                    <div class="mb-3">
                                        <textarea class="form-control" id="adminNotes" rows="4" placeholder="Tulis catatan peninjauan Anda di sini..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-save me-2"></i> Simpan Catatan
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-lightning-fill me-2"></i> Quick Actions</h5>
                            </div>
                            <div class="card-body d-grid gap-2" id="quickActions">
                                <button class="btn btn-success" id="quickAccept">
                                    <i class="bi bi-check-circle me-2"></i> Terima Aplikasi
                                </button>
                                <button class="btn btn-danger" id="quickReject">
                                    <i class="bi bi-x-circle me-2"></i> Tolak Aplikasi
                                </button>
                                <hr>
                                <button class="btn btn-outline-danger" id="deleteApplication">
                                    <i class="bi bi-trash me-2"></i> Hapus Aplikasi Permanen
                                </button>
                            </div>
                        </div>

                    </div>
                    </div>

            </main>
            <footer class="footer">
                <div class="container-fluid text-center">
                    <span class="text-muted">&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                </div>
            </footer>
            </div>
    </div>

    <div class="modal fade" id="cvPreviewModal" tabindex="-1" aria-labelledby="cvPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cvPreviewModalLabel">Preview CV: Joko Susilo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center p-5 border rounded bg-light">
                        <i class="bi bi-file-earmark-pdf" style="font-size: 3rem; color: #dc3545;"></i>
                        <p class="mt-3">Area Pratinjau Dokumen PDF</p>
                        <small class="text-muted">Dalam implementasi nyata, gunakan `&lt;iframe&gt;` atau pustaka penampil PDF di sini.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" class="btn btn-primary-custom"><i class="bi bi-download"></i> Unduh</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin_application-detail.js"></script>

</body>
</html>