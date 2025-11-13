<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management - SE Laboratory</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/css/admin_blog_list.css"> 

</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div>
                <div class="brand"><span class="logo-icon">SE</span> SE Laboratory</div>
                <ul class="sidebar-menu">
                    <li><a href="/admin"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/admin/blog-list" class="active"><i class="bi bi-pencil-square"></i> Blog Management</a></li>
                    <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a></li>
                    <li><a href="/admin/profil-pages"><i class="bi bi-person-badge"></i> Profile Pages</a></li>
                    <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join Applications</a></li>
                    <li><a href="/admin/site-settings"><i class="bi bi-gear-fill"></i> Settings</a></li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>
        </nav>

        <!-- Main Content -->
        <div id="main-content">
            <!-- Top Navbar -->
            <nav id="topbar" class="navbar navbar-expand-lg">
                <div class="container-fluid d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center">
                        <button class="btn sidebar-toggle sidebar-toggle-mobile" id="sidebarToggleMobile">
                            <i class="bi bi-list"></i>
                        </button>

                        <!-- Search Bar di Topbar (untuk desktop) -->
                        <form class="d-none d-md-inline-block ms-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari di sini...">
                                <button class="btn" style="background-color: var(--gold); color: white;" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <ul class="navbar-nav topbar-nav ms-auto">
                        <!-- Notifikasi -->
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
                        <!-- Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle profile-dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="https://placehold.co/150x150/1a1a1a/ffffff?text=AD" alt="Profile Picture">
                                <span class="d-none d-md-inline">Admin User</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="content-fluid">
                <!-- Page Header & Button -->
                <div class="page-header">
                    <div class="page-title">
                        <h1>Blog Management</h1>
                    </div>
                    <div>
                        <a href="blog_create.html" class="btn btn-primary-custom">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Blog Post
                        </a>
                    </div>
                </div>

                <!-- Filter and Search Section -->
                <div class="card filter-section">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Filter Blog Posts</h5>
                        <div class="row g-3 align-items-end">
                            <!-- Search by Title -->
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <label for="searchTitle" class="form-label visually-hidden">Search by Title</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchTitle" placeholder="Cari berdasarkan judul...">
                                    <button class="btn btn-primary-custom" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Filter by Kategori -->
                            <div class="col-lg-2 col-md-6 col-sm-4">
                                <label for="filterCategory" class="form-label text-muted d-block mb-1" style="font-size: 0.8rem;">Kategori</label>
                                <select class="form-select" id="filterCategory">
                                    <option selected>Semua</option>
                                    <option value="Research">Research</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Events">Events</option>
                                </select>
                            </div>
                            <!-- Filter by Penulis -->
                            <div class="col-lg-2 col-md-6 col-sm-4">
                                <label for="filterAuthor" class="form-label text-muted d-block mb-1" style="font-size: 0.8rem;">Penulis</label>
                                <select class="form-select" id="filterAuthor">
                                    <option selected>Semua</option>
                                    <option value="Dr. Anita">Dr. Anita</option>
                                    <option value="Prof. Budi">Prof. Budi</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <!-- Filter by Status -->
                            <div class="col-lg-2 col-md-6 col-sm-4">
                                <label for="filterStatus" class="form-label text-muted d-block mb-1" style="font-size: 0.8rem;">Status</label>
                                <select class="form-select" id="filterStatus">
                                    <option selected>Semua</option>
                                    <option value="Published">Published</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </div>
                            <!-- Reset Button -->
                            <div class="col-lg-1 col-md-6 col-sm-12 d-grid">
                                <button class="btn btn-outline-secondary" type="button" id="resetFilters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table Section -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 5%;">#</th>
                                        <th scope="col" style="width: 10%;">Thumbnail</th>
                                        <th scope="col" style="width: 30%;">Judul</th>
                                        <th scope="col" style="width: 10%;">Kategori</th>
                                        <th scope="col" style="width: 10%;">Penulis</th>
                                        <th scope="col" style="width: 10%;">Tanggal</th>
                                        <th scope="col" style="width: 5%;">Views</th>
                                        <th scope="col" style="width: 10%;">Status</th>
                                        <th scope="col" style="width: 10%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Contoh Data Baris 1 -->
                                    <tr>
                                        <td>1</td>
                                        <td><img src="https://placehold.co/80x50/B8941F/ffffff?text=Thumb" alt="Thumbnail" class="blog-thumbnail"></td>
                                        <td>Penerapan Machine Learning dalam Analisis Sentimen</td>
                                        <td>Technology</td>
                                        <td>Dr. Anita</td>
                                        <td>2025-11-01</td>
                                        <td>1.2K</td>
                                        <td><span class="badge" style="background-color: var(--gold); color: white;">Published</span></td>
                                        <td>
                                            <div class="action-btn-group d-flex">
                                                <button class="btn btn-sm btn-info text-white" title="Edit"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                                <button class="btn btn-sm btn-primary" title="View"><i class="bi bi-eye"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Contoh Data Baris 2 -->
                                    <tr>
                                        <td>2</td>
                                        <td><img src="https://placehold.co/80x50/D4AF37/1a1a1a?text=Thumb" alt="Thumbnail" class="blog-thumbnail"></td>
                                        <td>Panduan Praktis Menggunakan React Hooks</td>
                                        <td>Research</td>
                                        <td>Prof. Budi</td>
                                        <td>2025-10-25</td>
                                        <td>850</td>
                                        <td><span class="badge bg-secondary">Draft</span></td>
                                        <td>
                                            <div class="action-btn-group d-flex">
                                                <button class="btn btn-sm btn-info text-white" title="Edit"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                                <button class="btn btn-sm btn-primary" title="View"><i class="bi bi-eye"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Contoh Data Baris 3 -->
                                    <tr>
                                        <td>3</td>
                                        <td><img src="https://placehold.co/80x50/1a1a1a/D4AF37?text=Thumb" alt="Thumbnail" class="blog-thumbnail"></td>
                                        <td>Ringkasan Acara Seminar Big Data 2025</td>
                                        <td>Events</td>
                                        <td>Admin</td>
                                        <td>2025-10-20</td>
                                        <td>4.1K</td>
                                        <td><span class="badge" style="background-color: var(--gold); color: white;">Published</span></td>
                                        <td>
                                            <div class="action-btn-group d-flex">
                                                <button class="btn btn-sm btn-info text-white" title="Edit"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                                <button class="btn btn-sm btn-primary" title="View"><i class="bi bi-eye"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="#" style="background-color: var(--gold); border-color: var(--dark-gold);">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </main>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid text-center">
                    <span class="text-muted">&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                </div>
            </footer>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS File -->
    <script src="/js/admin_blog_list.js"></script> 

</body>
</html>