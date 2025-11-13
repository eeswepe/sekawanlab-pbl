<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post - SE Laboratory</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/css/admin_blog_edit.css"> 

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

            <!-- Main Content Area: Blog Editing Form -->
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h1>Edit Blog Post: #101</h1>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted d-none d-sm-inline">Status: <span class="badge bg-success">Published</span></span>
                        <button type="button" class="btn btn-danger" id="deleteBtn">
                            <i class="bi bi-trash me-2"></i> Delete Post
                        </button>
                    </div>
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
                                    <!-- Judul Artikel (Pre-filled) -->
                                    <div class="mb-4">
                                        <label for="postTitle" class="form-label">Judul Artikel</label>
                                        <input type="text" class="form-control" id="postTitle" value="Penerapan Machine Learning dalam Analisis Sentimen" required>
                                    </div>
                                    
                                    <!-- Konten Artikel (Pre-filled) -->
                                    <div class="mb-4">
                                        <label for="blogContent" class="form-label">Konten</label>
                                        <textarea class="form-control" id="blogContent" required>Analisis sentimen menggunakan Machine Learning telah menjadi pilar penting dalam memahami opini publik dari data teks yang masif. Model-model seperti Naive Bayes dan Recurrent Neural Networks (RNN) digunakan untuk mengklasifikasikan sentimen sebagai positif, negatif, atau netral. Dalam implementasinya, data harus melalui tahapan preprocessing yang ketat, termasuk tokenisasi, stemming, dan penghapusan stop words. Proyek ini bertujuan mengeksplorasi efektivitas model-model ML terbaru, termasuk transformer-based models, dalam konteks bahasa Indonesia. Hasil awal menunjukkan bahwa model berbasis BERT memberikan akurasi tertinggi dalam kasus multi-class sentiment analysis.</textarea>
                                    </div>

                                    <!-- Upload Featured Image -->
                                    <div class="mb-4">
                                        <label for="featuredImage" class="form-label">Update Featured Image</label>
                                        <input class="form-control" type="file" id="featuredImage" accept="image/*">
                                        <div id="image-preview-container">
                                            <!-- Simulasi gambar existing -->
                                            <img id="image-preview" src="https://placehold.co/300x180/D4AF37/1a1a1a?text=ML+Sentiment" alt="Preview Gambar">
                                            <span class="preview-placeholder" id="placeholder-text">Pratinjau Gambar (300x180)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Meta, Kategori, Penulis, Status -->
                        <div class="col-lg-4">
                            <!-- Data Tambahan (View Count, Published Date) -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Analytics & Info</h5>
                                </div>
                                <div class="card-body">
                                    <div class="meta-info-item">
                                        <span class="label">ID Artikel</span>
                                        <span class="value">#101</span>
                                    </div>
                                    <div class="meta-info-item">
                                        <span class="label"><i class="bi bi-eye me-2"></i> View Count</span>
                                        <span class="value">12,450</span>
                                    </div>
                                    <div class="meta-info-item">
                                        <span class="label"><i class="bi bi-calendar me-2"></i> Published Date</span>
                                        <span class="value">2025-11-01 10:30 WIB</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status dan Klasifikasi -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Status & Klasifikasi</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Status (Radio - Pre-filled to Published) -->
                                    <div class="mb-4">
                                        <label class="form-label d-block">Status Artikel</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="postStatus" id="statusDraft" value="Draft">
                                            <label class="form-check-label" for="statusDraft">Draft</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="postStatus" id="statusPublished" value="Published" checked>
                                            <label class="form-check-label" for="statusPublished">Published</label>
                                        </div>
                                    </div>

                                    <!-- Kategori (Dropdown - Pre-filled) -->
                                    <div class="mb-4">
                                        <label for="postCategory" class="form-label">Kategori</label>
                                        <select class="form-select" id="postCategory" required>
                                            <option value="" disabled>Pilih Kategori</option>
                                            <option value="Machine Learning" selected>Machine Learning</option>
                                            <option value="Cloud Computing">Cloud Computing</option>
                                            <option value="Mobile Development">Mobile Development</option>
                                            <option value="Security">Security</option>
                                            <option value="Data Science">Data Science</option>
                                            <option value="Web Development">Web Development</option>
                                        </select>
                                    </div>

                                    <!-- Penulis (Dropdown - Pre-filled) -->
                                    <div class="mb-4">
                                        <label for="postAuthor" class="form-label">Penulis</label>
                                        <select class="form-select" id="postAuthor" required>
                                            <option value="" disabled>Pilih Penulis</option>
                                            <option value="Admin User">Admin User</option>
                                            <option value="Dr. Anita" selected>Dr. Anita</option>
                                            <option value="Prof. Budi">Prof. Budi</option>
                                            <option value="Mahasiswa A">Mahasiswa A</option>
                                        </select>
                                    </div>

                                    <!-- Meta Info (Read-only/Auto) -->
                                    <div class="mb-3">
                                        <label class="form-label">Estimasi Waktu Baca</label>
                                        <input type="text" class="form-control" id="metaReadingTime" value="Otomatis (4 menit)" readonly>
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
                        <button type="submit" class="btn btn-primary-custom btn-update">
                            <i class="bi bi-arrow-clockwise me-2"></i> Update Post
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
    <script src="/js/admin_blog_edit.js"></script>

</body>
</html>