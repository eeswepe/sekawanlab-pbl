<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Blog Baru - SE Laboratory (Personil)</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/css/personil_blog_create.css">

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
                                <input type="text" class="form-control" placeholder="Cari di sini...">
                                <button class="btn" style="background-color: var(--gold); color: white;" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <ul class="navbar-nav topbar-nav ms-auto">
                        <!-- Notification & Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle profile-dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="https://placehold.co/150x150/1a1a1a/ffffff?text=P" alt="Profile Picture">
                                <span class="d-none d-md-inline" id="currentUser">Dr. Anita</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>

            <!-- Main Content Area: Blog Creation Form -->
            <main class="content-fluid">
                <div class="page-header">
                    <h1>Tulis Blog Post Baru</h1>
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
                                    <!-- Penulis (Otomatis) -->
                                    <div class="mb-4">
                                        <label class="form-label">Penulis</label>
                                        <!-- Nilai diambil dari script/simulasi pengguna login -->
                                        <input type="text" class="form-control" id="postAuthor" value="Dr. Anita" readonly>
                                    </div>

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

                                    <!-- Status (Radio) -->
                                    <div class="mb-4">
                                        <label class="form-label d-block">Status Artikel</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="postStatus" id="statusDraft" value="Draft" checked>
                                            <label class="form-check-label" for="statusDraft">Draft</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="postStatus" id="statusReview" value="Review">
                                            <label class="form-check-label" for="statusReview">Submit for Review</label>
                                        </div>
                                    </div>

                                    <!-- Meta Info (Read-only/Auto) -->
                                    <div class="mb-3">
                                        <label class="form-label">Estimasi Waktu Baca</label>
                                        <input type="text" class="form-control" id="metaReadingTime" value="Otomatis (0 menit)" readonly>
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
                        <button type="submit" class="btn btn-save-draft" id="saveDraftBtn">
                            <i class="bi bi-save me-2"></i> Save as Draft
                        </button>
                        <button type="submit" class="btn btn-primary-custom" id="submitReviewBtn">
                            <i class="bi bi-send-check me-2"></i> Submit for Review
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
    <script src="/js/personil_blog_create.js"></script>

</body>

</html>