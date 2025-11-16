<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Halaman Profil - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/admin_profile-page_edit.css">

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
                    <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a></li>
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
                        <h1>Tambah Halaman Profil Baru</h1>
                        <p>Buat halaman informasi statis baru untuk website.</p>
                    </div>
                </div>

                <form id="profilePageCreateForm" method="POST" enctype="multipart/form-data">
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">1. Data Hero Section (Bagian Atas Halaman)</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="tentang-kami" required>
                                <small class="form-text text-muted">URL-friendly identifier (contoh: tentang-kami, visi-misi).</small>
                            </div>
                            <div class="mb-3">
                                <label for="pageTitle" class="form-label">Page Title (Judul Utama/Hero)</label>
                                <input type="text" class="form-control" id="pageTitle" name="page_title" placeholder="Mengenal Lebih Dekat Software Engineering Laboratory" required>
                                <small class="form-text text-muted">Judul ini muncul paling besar di bagian atas (hero section).</small>
                            </div>
                            <div class="mb-3">
                                <label for="pageSubtitle" class="form-label">Page Subtitle (Deskripsi Hero)</label>
                                <textarea class="form-control" id="pageSubtitle" name="page_subtitle" rows="2" placeholder="Deskripsi singkat halaman..." required></textarea>
                                <small class="form-text text-muted">Sub-judul pendukung di bawah judul utama.</small>
                            </div>
                            <div class="mb-3">
                                <label for="featuredImage" class="form-label">Featured Image (Gambar Utama)</label>
                                <div class="d-flex flex-column">
                                    <img id="featured-image-preview" src="https://via.placeholder.com/800x250/1a1a1a/D4AF37?text=No+Image" alt="No Image">
                                    <input class="form-control" type="file" id="featuredImage" name="featured_image" accept="image/*">
                                    <small class="form-text text-muted">Unggah gambar utama (rasio ideal 16:5 atau 16:6).</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">2. Isi Konten Halaman</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="contentTitle" class="form-label">Content Title (Judul Konten)</label>
                                <input type="text" class="form-control" id="contentTitle" name="content_title" placeholder="Apa Itu SE Laboratory?" required>
                                <small class="form-text text-muted">Judul utama konten yang muncul setelah hero section.</small>
                            </div>
                            <div class="mb-3">
                                <label for="contentSubtitle" class="form-label">Content Subtitle (Isi Konten)</label>
                                <textarea class="form-control" id="contentSubtitle" name="content_subtitle" rows="15" placeholder="Tulis konten lengkap di sini..." required></textarea>
                                <small class="form-text text-muted">Isi lengkap konten halaman. Gunakan format plain text atau markdown.</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-3 mb-5">
                        <a href="/admin/profil-pages" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="bi bi-x-lg me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-plus-circle me-2"></i> Buat Halaman
                            </button>
                        </div>
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
    <script src="/js/admin_profile-page_create.js"></script>

</body>
</html>
