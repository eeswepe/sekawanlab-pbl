<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/personil_profil-view.css"> 
</head>
<body>

    <div class="wrapper">
        <aside id="sidebar">
            <div>
                <div class="brand">
                    <span class="logo-icon">SE</span> SE Laboratory
                </div>
                <ul class="sidebar-menu">
                    <li><a href="/personil"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/personil/profile" class="active"><i class="bi bi-person-circle"></i> My Profile</a></li>
                    <li><a href="/personil/blog"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
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
                                <img src="https://via.placeholder.com/150/1a1a1a/FFFFFF?text=A" alt="Profile Picture">
                                <span class="d-none d-md-inline">Rizky Adhi</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="profile-view.html"><i class="bi bi-person-fill"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../../login.html"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>My Profile</h1>
                        <p>Kelola dan tinjau informasi profil Anda.</p>
                    </div>
                    <a href="/personil/profile/edit" class="btn btn-primary-custom d-none d-sm-inline-flex">
                        <i class="bi bi-pencil-square me-2"></i> Edit Profile
                    </a>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <img src="https://via.placeholder.com/150/D4AF37/FFFFFF?text=Rizky" 
                                     alt="Profile Picture" 
                                     class="rounded-circle mb-3" 
                                     style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--gold);">
                                
                                <h4 class="card-title mb-0">Rizky Adhi Pramana</h4>
                                <p class="text-muted mb-3">Ketua Laboratorium (Dosen)</p>
                                
                                <a href="/public/profile/rizky-adhi" target="_blank" class="btn btn-outline-secondary w-100 mb-3">
                                    <i class="bi bi-box-arrow-up-right me-2"></i> View Public Profile
                                </a>

                                <hr>
                                
                                <div class="list-group list-group-flush text-start">
                                    <h6 class="text-start mt-2 mb-2 card-title">Contact Info</h6>
                                    <div class="list-group-item d-flex align-items-center border-0 p-2">
                                        <i class="bi bi-envelope-fill me-3" style="color: var(--gold); font-size: 1.1rem;"></i> 
                                        <span class="text-muted">rizky.adhi@se.lab.id</span>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center border-0 p-2">
                                        <i class="bi bi-phone-fill me-3" style="color: var(--gold); font-size: 1.1rem;"></i> 
                                        <span class="text-muted">+62 812-3456-7890</span>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center border-0 p-2">
                                        <i class="bi bi-geo-alt-fill me-3" style="color: var(--gold); font-size: 1.1rem;"></i> 
                                        <span class="text-muted">Malang, Indonesia</span>
                                    </div>
                                </div>
                                
                                <hr>

                                <h6 class="text-start mt-2 mb-2 card-title">Social Media</h6>
                                <div class="d-flex justify-content-start gap-4">
                                    <a href="#" class="social-link fs-4"><i class="bi bi-github"></i></a>
                                    <a href="#" class="social-link fs-4"><i class="bi bi-linkedin"></i></a>
                                    <a href="#" class="social-link fs-4"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="social-link fs-4"><i class="bi bi-globe"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-star-fill me-2" style="color: var(--gold);"></i> Spesialisasi</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">Software Engineering, Arsitektur Perangkat Lunak, Microservices, Cloud Computing (AWS/GCP).</p>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-info-circle-fill me-2" style="color: var(--gold);"></i> Bio</h5>
                            </div>
                            <div class="card-body">
                                <p>Dosen dan peneliti berpengalaman lebih dari 10 tahun di bidang Rekayasa Perangkat Lunak. Fokus pada pengembangan sistem skala besar dan implementasi praktik Agile/DevOps. Berdedikasi untuk membimbing mahasiswa dalam proyek-proyek inovatif yang berdampak sosial dan industri.</p>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-lightning-fill me-2" style="color: var(--gold);"></i> Skills</h5>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-secondary me-2 mb-2 py-2 px-3">Python</span>
                                <span class="badge bg-secondary me-2 mb-2 py-2 px-3">Java</span>
                                <span class="badge bg-secondary me-2 mb-2 py-2 px-3">React/Next.js</span>
                                <span class="badge bg-secondary me-2 mb-2 py-2 px-3">Docker/Kubernetes</span>
                                <span class="badge bg-secondary me-2 mb-2 py-2 px-3">Agile/Scrum</span>
                                <span class="badge bg-secondary me-2 mb-2 py-2 px-3">System Design</span>
                                <span class="badge bg-secondary me-2 mb-2 py-2 px-3">Machine Learning</span>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-folder-fill me-2" style="color: var(--gold);"></i> Projects</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Sistem Informasi Akademik v2.0
                                        <span class="badge bg-info text-dark">Ongoing</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Aplikasi E-Commerce Microservices
                                        <span class="badge bg-success">Completed</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Smart City Data Platform
                                        <span class="badge bg-success">Completed</span>
                                    </li>
                                </ul>
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
    <script src="../../assets/js/personil_profile-view.js"></script>

</body>
</html>