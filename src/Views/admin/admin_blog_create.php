<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Blog Post - SE Laboratory</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/public/css/admin_blog_create.css"> 

</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
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
                    <!-- Link aktif ke halaman Blog Management -->
                    <a href="admin-blog-list.html" class="sidebar-nav-link active">
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
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </li>
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
                                <input type="text" class="form-control" placeholder="Cari di sini...">
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

            <!-- Main Content Area: Blog Creation Form -->
            <main class="content-fluid">
                <div class="page-header">
                    <h1>Tambah Blog Post Baru</h1>
                </div>

                <form id="blogPostForm">
                    <div class="row g-4">
                        <!-- Kolom Kiri: Judul, Konten, Gambar -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Konten Utama</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Judul Artikel -->
                                    <div class="mb-4">
                                        <label for="postTitle" class="form-label">Judul Artikel</label>
                                        <input type="text" class="form-control" id="postTitle" placeholder="Masukkan judul artikel..." required>
                                    </div>
                                    
                                    <!-- Konten Artikel (Rich Text Editor Placeholder) -->
                                    <div class="mb-4">
                                        <label for="blogContent" class="form-label">Konten</label>
                                        <!-- Ini adalah placeholder untuk Rich Text Editor, menggunakan textarea besar -->
                                        <textarea class="form-control" id="blogContent" placeholder="Mulai tulis konten artikel Anda di sini..." required></textarea>
                                    </div>

                                    <!-- Upload Featured Image -->
                                    <div class="mb-4">
                                        <label for="featuredImage" class="form-label">Upload Featured Image</label>
                                        <input class="form-control" type="file" id="featuredImage" accept="image/*">
                                        <div id="image-preview-container">
                                            <img id="image-preview" src="#" alt="Preview Gambar">
                                            <span class="preview-placeholder" id="placeholder-text">Pratinjau Gambar (300x180)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Meta, Kategori, Penulis, Status -->
                        <div class="col-lg-4">
                            <!-- Status dan Metadata -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Status & Metadata</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Status (Radio) -->
                                    <div class="mb-4">
                                        <label class="form-label d-block">Status Artikel</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="postStatus" id="statusDraft" value="Draft" checked>
                                            <label class="form-check-label" for="statusDraft">Draft</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="postStatus" id="statusPublished" value="Published">
                                            <label class="form-check-label" for="statusPublished">Published</label>
                                        </div>
                                    </div>

                                    <!-- Meta Info (Read-only/Auto) -->
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Post</label>
                                        <input type="text" class="form-control" id="metaDate" value="Otomatis (Saat dipublikasikan)" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estimasi Waktu Baca</label>
                                        <input type="text" class="form-control" id="metaReadingTime" value="Otomatis (0 menit)" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kategori dan Penulis -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Klasifikasi</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Kategori (Dropdown) -->
                                    <div class="mb-4">
                                        <label for="postCategory" class="form-label">Kategori</label>
                                        <select class="form-select" id="postCategory" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <option value="Machine Learning">Machine Learning</option>
                                            <option value="Cloud Computing">Cloud Computing</option>
                                            <option value="Mobile Development">Mobile Development</option>
                                            <option value="Security">Security</option>
                                            <option value="Data Science">Data Science</option>
                                            <option value="Web Development">Web Development</option>
                                        </select>
                                    </div>

                                    <!-- Penulis (Dropdown) -->
                                    <div class="mb-4">
                                        <label for="postAuthor" class="form-label">Penulis</label>
                                        <select class="form-select" id="postAuthor" required>
                                            <option value="" selected disabled>Pilih Penulis</option>
                                            <option value="Admin User">Admin User</option>
                                            <option value="Dr. Anita">Dr. Anita</option>
                                            <option value="Prof. Budi">Prof. Budi</option>
                                            <option value="Mahasiswa A">Mahasiswa A</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" id="cancelBtn">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-save-draft">
                            <i class="bi bi-save me-2"></i> Save Draft
                        </button>
                        <button type="submit" class="btn btn-primary-custom" id="saveAndPublishBtn">
                            <i class="bi bi-check-circle me-2"></i> Save & Publish
                        </button>
                    </div>
                </form>
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
    <script src="/public/js/admin_blog_create.js"></script>

</body>
</html>