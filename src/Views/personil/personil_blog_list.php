<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Saya - SE Laboratory (Personil)</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/css/personil_blog_list.css"> 

</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="#">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li><a href="#"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li><a href="#"><i class="bi bi-person-circle"></i> My Profile</a></li>
                <li><a href="#" class="active"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
                <li><a href="#"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div id="main-content">
            <!-- Top Navbar (diambil dari dashboard.html) -->
            <nav id="topbar" class="navbar navbar-expand-lg">
                <div class="container-fluid d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center">
                        <button class="btn sidebar-toggle sidebar-toggle-mobile" id="sidebarToggleMobile">
                            <i class="bi bi-list"></i>
                        </button>

                        <form class="d-none d-md-inline-block ms-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari Blog Saya...">
                                <button class="btn" style="background-color: var(--gold); color: white;" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <ul class="navbar-nav topbar-nav ms-auto">
                        <!-- Notification & Profile Dropdown (disingkat) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle profile-dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="https://placehold.co/150x150/1a1a1a/ffffff?text=P" alt="Profile Picture">
                                <span class="d-none d-md-inline">Personil Name</span>
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

            <!-- Main Content Area: Blog List -->
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
                    <h1>Blog Saya</h1>
                    <a href="/personil/blog/create" class="btn btn-primary-custom" id="tulisBlogBaruBtn">
                        <i class="bi bi-plus-circle me-2"></i> Tulis Blog Baru
                    </a>
                </div>

                <!-- Statistics -->
                <div class="row g-3 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3 id="totalPosts">6</h3>
                                <p>Total Posts</p>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3 id="totalViews">8,450</h3>
                                <p>Total Views</p>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-eye-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Daftar Artikel Anda</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Thumbnail</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tanggal</th>
                                        <th>Views</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="blogTableBody">
                                    <!-- Artikel Published -->
                                    <tr data-status="Published" data-id="101">
                                        <td><img src="https://placehold.co/80x50/3498db/ffffff?text=ML" class="post-thumbnail" alt="Thumbnail"></td>
                                        <td>Penerapan Machine Learning dalam Analisis Sentimen</td>
                                        <td>Machine Learning</td>
                                        <td>2025-11-01</td>
                                        <td>4,200</td>
                                        <td><span class="badge bg-success">Published</span></td>
                                        <td class="text-center table-actions">
                                            <button class="btn btn-sm btn-primary edit-btn"><i class="bi bi-pencil-square"></i> Edit</button>
                                            <button class="btn btn-sm btn-secondary view-btn"><i class="bi bi-eye"></i> View</button>
                                            <!-- Delete hanya untuk draft, jadi tidak ditampilkan di published -->
                                        </td>
                                    </tr>
                                    <!-- Artikel Draft -->
                                    <tr data-status="Draft" data-id="102">
                                        <td><img src="https://placehold.co/80x50/f39c12/1a1a1a?text=CLOUD" class="post-thumbnail" alt="Thumbnail"></td>
                                        <td>Panduan Dasar Migrasi ke AWS S3</td>
                                        <td>Cloud Computing</td>
                                        <td>2025-11-10</td>
                                        <td>0</td>
                                        <td><span class="badge bg-warning text-dark">Draft</span></td>
                                        <td class="text-center table-actions">
                                            <button class="btn btn-sm btn-primary edit-btn"><i class="bi bi-pencil-square"></i> Edit</button>
                                            <button class="btn btn-sm btn-secondary view-btn"><i class="bi bi-eye"></i> View</button>
                                            <button class="btn btn-sm btn-danger delete-btn"><i class="bi bi-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                    <!-- Artikel Published -->
                                    <tr data-status="Published" data-id="103">
                                        <td><img src="https://placehold.co/80x50/e74c3c/ffffff?text=WEB" class="post-thumbnail" alt="Thumbnail"></td>
                                        <td>Membangun Component Reusable dengan React Hooks</td>
                                        <td>Web Development</td>
                                        <td>2025-10-15</td>
                                        <td>3,120</td>
                                        <td><span class="badge bg-success">Published</span></td>
                                        <td class="text-center table-actions">
                                            <button class="btn btn-sm btn-primary edit-btn"><i class="bi bi-pencil-square"></i> Edit</button>
                                            <button class="btn btn-sm btn-secondary view-btn"><i class="bi bi-eye"></i> View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted" id="pagination-info">Menampilkan 3 dari 6 Artikel</small>
                        <!-- Pagination -->
                        <nav>
                            <ul class="pagination pagination-sm my-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
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
    <script src="/js/personil_blog_list.js"></script>

</body>
</html>