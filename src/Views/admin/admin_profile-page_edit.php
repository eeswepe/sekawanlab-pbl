<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Halaman Profil - SE Laboratory</title>

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
                    <a href="profile-pages.html" class="sidebar-nav-link active">
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
                        <h1>Edit Halaman Profil: Tentang Kami</h1>
                        <p>Perbarui konten dan tampilan untuk halaman **Tentang Kami**.</p>
                    </div>
                </div>

                <form id="profilePageEditForm" action="/admin/profile-pages/update/tentang-kami" method="POST" enctype="multipart/form-data">
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">1. Data Hero Section (Bagian Atas Halaman)</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="pageTitle" class="form-label">Page Title (Judul Utama/Hero)</label>
                                <input type="text" class="form-control" id="pageTitle" value="Mengenal Lebih Dekat Software Engineering Laboratory" required>
                                <small class="form-text text-muted">Judul ini muncul paling besar di bagian atas (hero section).</small>
                            </div>
                            <div class="mb-3">
                                <label for="pageSubtitle" class="form-label">Page Subtitle (Deskripsi Hero)</label>
                                <textarea class="form-control" id="pageSubtitle" rows="2">Kami adalah pusat riset dan pengembangan di bidang rekayasa perangkat lunak, mencetak inovator masa depan.</textarea>
                                <small class="form-text text-muted">Sub-judul pendukung di bawah judul utama.</small>
                            </div>
                            <div class="mb-3">
                                <label for="featuredImage" class="form-label">Featured Image (Gambar Utama)</label>
                                <div class="d-flex flex-column">
                                    <img id="featured-image-preview" src="https://via.placeholder.com/800x250/1a1a1a/D4AF37?text=Current+Featured+Image" alt="Featured Image Preview">
                                    <input class="form-control" type="file" id="featuredImage" accept="image/*">
                                    <small class="form-text text-muted">Unggah gambar baru (rasio ideal 16:5 atau 16:6) untuk mengganti gambar saat ini.</small>
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
                                <input type="text" class="form-control" id="contentTitle" value="Apa Itu SE Laboratory?" required>
                                <small class="form-text text-muted">Judul utama konten yang muncul setelah hero section.</small>
                            </div>
                            <div class="mb-3">
                                <label for="contentText" class="form-label">Content Text (Isi Lengkap Halaman)</label>
                                <textarea class="form-control content-editor-placeholder" id="contentText" rows="15">Software Engineering Laboratory didirikan pada tahun 2018 dengan tujuan untuk menjadi pusat keunggulan dalam riset dan implementasi teknologi rekayasa perangkat lunak.

Kami berfokus pada pengembangan sistem cerdas, aplikasi mobile, dan solusi berbasis web yang inovatif. Tim kami terdiri dari dosen pembimbing, peneliti, dan *talents* (geeks) yang berdedikasi tinggi.

**Fokus Utama Kami:**
1.  **Riset Lanjutan:** Mendorong penelitian di bidang *software architecture* dan *clean code*.
2.  **Inovasi Produk:** Menciptakan prototipe dan produk nyata yang dapat diadopsi oleh industri.
3.  **Pengembangan SDM:** Memberikan pelatihan intensif kepada mahasiswa untuk menjadi profesional *software engineer* yang handal.

Dengan semangat kolaborasi, kami terus berupaya memberikan kontribusi terbaik bagi perkembangan ilmu pengetahuan dan teknologi di Indonesia.</textarea>
                                <small class="form-text text-muted">Gunakan editor ini untuk memasukkan konten lengkap halaman. (Di implementasi nyata, ini biasanya adalah Rich Text Editor seperti TinyMCE atau CKEditor).</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-3 mb-5">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.open('/preview/tentang-kami', '_blank')">
                            <i class="bi bi-eye-fill me-2"></i> Preview Halaman
                        </button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="bi bi-x-lg me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Update Halaman
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



</body>
</html>