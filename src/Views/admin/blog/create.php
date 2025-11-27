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
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/assets/css/admin/blog/create.css">

</head>

<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Bootstrap Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
            <!-- Custom Fonts -->
            <link
                href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap"
                rel="stylesheet">

            <!-- Custom CSS File -->
            <link rel="stylesheet" href="/assets/css/admin/blog/create.css">

            </head>

            <body>

                <div class="wrapper">
                    <!-- Sidebar -->
                    <aside id="sidebar">
                        <div>
                            <div class="brand"><img class="logo-icon" src="/assets/img/mascot-head.png"
                                    alt="mascot-lab-se">SE Laboratory
                                <div class="sidebar-divider"></div>
                            </div>
                            <ul class="sidebar-menu">
                                <li><a href="/admin"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                                <li><a href="/admin/blog-list" class="active"><i class="bi bi-pencil-square"></i> Blog
                                        Management</a></li>
                                <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a>
                                </li>
                                <li><a href="/admin/profil-pages"><i class="bi bi-person-badge"></i> Profile Pages</a>
                                </li>
                                <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join
                                        Applications</a></li>
                                <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </div>
                    </aside>

                    <!-- Main Content -->
                    <div id="main-content">


                        <!-- Main Content Area: Blog Creation Form -->
                        <main class="content-fluid">
                            <div class="page-header">
                                <h1>Tambah Blog Post Baru</h1>
                            </div>

                            <form id="blogPostForm" enctype="multipart/form-data">
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
                                                    <input type="text" class="form-control" id="postTitle" name="judul"
                                                        placeholder="Masukkan judul artikel..." required>
                                                </div>

                                                <!-- Cuplikan -->
                                                <div class="mb-4">
                                                    <label for="cuplikan" class="form-label">Cuplikan (Opsional)</label>
                                                    <textarea class="form-control" id="cuplikan" name="cuplikan"
                                                        rows="2"
                                                        placeholder="Cuplikan artikel (akan digenerate otomatis jika kosong)"></textarea>
                                                </div>

                                                <!-- Konten Artikel (Rich Text Editor Placeholder) -->
                                                <div class="mb-4">
                                                    <label for="blogContent" class="form-label">Konten</label>
                                                    <!-- Ini adalah placeholder untuk Rich Text Editor, menggunakan textarea besar -->
                                                    <textarea class="form-control" id="blogContent" name="konten"
                                                        placeholder="Mulai tulis konten artikel Anda di sini..."
                                                        required></textarea>
                                                </div>

                                                <!-- Upload Featured Image -->
                                                <div class="mb-4">
                                                    <label for="featuredImage" class="form-label">Upload Featured Image
                                                        (Opsional)</label>
                                                    <input class="form-control" type="file" id="featuredImage"
                                                        name="featured_image" accept="image/*">
                                                    <div id="image-preview-container">
                                                        <img id="image-preview" src="#" alt="Preview Gambar">
                                                        <span class="preview-placeholder"
                                                            id="placeholder-text">Pratinjau Gambar (300x180)</span>
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
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="statusDraft" value="draft" checked>
                                                        <label class="form-check-label" for="statusDraft">Draft</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="statusPublished" value="published">
                                                        <label class="form-check-label"
                                                            for="statusPublished">Published</label>
                                                    </div>
                                                </div>

                                                <!-- Meta Info (Read-only/Auto) -->
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Post</label>
                                                    <input type="text" class="form-control" id="metaDate"
                                                        value="Otomatis (Saat dipublikasikan)" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Estimasi Waktu Baca</label>
                                                    <input type="text" class="form-control" id="metaReadingTime"
                                                        value="Otomatis (0 menit)" readonly>
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
                                                    <select class="form-select" id="postCategory" name="kategori_id"
                                                        required>
                                                        <option value="" selected disabled>Pilih Kategori</option>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?= $category['id'] ?>">
                                                                <?= htmlspecialchars($category['name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- Penulis (Dropdown) -->
                                                <div class="mb-4">
                                                    <label for="postAuthor" class="form-label">Penulis</label>
                                                    <select class="form-select" id="postAuthor" name="penulis_id"
                                                        required>
                                                        <option value="" selected disabled>Pilih Penulis</option>
                                                        <?php foreach ($personils as $personil): ?>
                                                            <option value="<?= $personil['id'] ?>">
                                                                <?= htmlspecialchars($personil['nama_lengkap']) ?>
                                                                (<?= htmlspecialchars($personil['role']) ?>)</option>
                                                        <?php endforeach; ?>
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
                                <span class="text-muted">&copy; 2025 Software Engineering Laboratory. All rights
                                    reserved.</span>
                            </div>
                        </footer>

                    </div>
                </div>

                <!-- Bootstrap JS Bundle -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                <!-- Custom JS File -->
                <script src="/assets/js/admin/blog/create.js"></script>

            </body>

</html>