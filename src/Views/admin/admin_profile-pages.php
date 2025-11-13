<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Pages Management - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">


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
                    <a href="personil-list.html" class="sidebar-nav-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Personil Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link active">
                        <i class="bi bi-file-person"></i>
                        <span>Profile Pages</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
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
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Profile Pages Management</h1>
                        <p>Kelola dan perbarui halaman-halaman informasi statis (Tentang Kami, Visi & Misi, dll.).</p>
                    </div>
                </div>

                <div class="row g-4">
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="card profile-card-item">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="page-thumbnail me-3">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </div>
                                    <div class="page-info">
                                        <h5 class="card-title">Tentang Kami</h5>
                                        <small>Last updated: 14 Mei 2024</small>
                                    </div>
                                </div>
                                <div class="d-grid mt-auto">
                                    <a href="profile-pages-edit.html?id=tentang-kami" class="btn btn-primary-custom btn-sm">
                                        <i class="bi bi-pencil-square me-2"></i> Edit Halaman
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="card profile-card-item">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="page-thumbnail me-3" style="background-color: transparent;">
                                        <i class="bi bi-binoculars-fill" style="background: linear-gradient(135deg, #1e3c72, #2a5298);"></i>
                                    </div>
                                    <div class="page-info">
                                        <h5 class="card-title">Visi & Misi</h5>
                                        <small>Last updated: 01 Februari 2024</small>
                                    </div>
                                </div>
                                <div class="d-grid mt-auto">
                                    <a href="profile-pages-edit.html?id=visi-misi" class="btn btn-primary-custom btn-sm">
                                        <i class="bi bi-pencil-square me-2"></i> Edit Halaman
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="card profile-card-item">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="page-thumbnail me-3" style="background-color: transparent;">
                                        <i class="bi bi-trophy-fill" style="background: linear-gradient(135deg, #FFD700, #DAA520);"></i>
                                    </div>
                                    <div class="page-info">
                                        <h5 class="card-title">Prestasi</h5>
                                        <small>Last updated: 28 April 2024</small>
                                    </div>
                                </div>
                                <div class="d-grid mt-auto">
                                    <a href="profile-pages-edit.html?id=prestasi" class="btn btn-primary-custom btn-sm">
                                        <i class="bi bi-pencil-square me-2"></i> Edit Halaman
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="card profile-card-item">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="page-thumbnail me-3" style="background-color: transparent;">
                                        <i class="bi bi-diagram-3-fill" style="background: linear-gradient(135deg, #5CB85C, #3F903F);"></i>
                                    </div>
                                    <div class="page-info">
                                        <h5 class="card-title">Struktur Organisasi</h5>
                                        <small>Last updated: 10 Maret 2024</small>
                                    </div>
                                </div>
                                <div class="d-grid mt-auto">
                                    <a href="profile-pages-edit.html?id=struktur-organisasi" class="btn btn-primary-custom btn-sm">
                                        <i class="bi bi-pencil-square me-2"></i> Edit Halaman
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="card profile-card-item">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="page-thumbnail me-3" style="background-color: transparent;">
                                        <i class="bi bi-folder-fill" style="background: linear-gradient(135deg, #F0AD4E, #EEA236);"></i>
                                    </div>
                                    <div class="page-info">
                                        <h5 class="card-title">Dokumen Publik</h5>
                                        <small>Last updated: 05 Januari 2024</small>
                                    </div>
                                </div>
                                <div class="d-grid mt-auto">
                                    <a href="profile-pages-edit.html?id=dokumen-publik" class="btn btn-primary-custom btn-sm">
                                        <i class="bi bi-pencil-square me-2"></i> Edit Halaman
                                    </a>
                                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>