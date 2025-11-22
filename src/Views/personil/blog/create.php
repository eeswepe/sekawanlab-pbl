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
    <link rel="stylesheet" href="/assets/css/personil/blog/create.css">

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
                <li><a href="/personil/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li><a href="/personil/profile"><i class="bi bi-person-circle"></i> My Profile</a></li>
                <li><a href="/personil/blog" class="active"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
                <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
        </nav>
        
        <!-- Main Content -->
        <div id="main-content">
            <!-- Main Content Area: Blog Creation Form -->
            <main class="content-fluid">
                <div class="page-header">
                    <h1>Tulis Blog Post Baru</h1>
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
                                        <label for="postTitle" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="postTitle" name="judul" placeholder="Masukkan judul artikel..." required>
                                    </div>

                                    <!-- Konten Artikel -->
                                    <div class="mb-4">
                                        <label for="blogContent" class="form-label">Konten <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="blogContent" name="konten" rows="15" placeholder="Mulai tulis konten artikel Anda di sini..." required></textarea>
                                        <small class="text-muted">Estimasi waktu baca akan dihitung otomatis berdasarkan jumlah kata.</small>
                                    </div>

                                    <!-- Cuplikan (Optional) -->
                                    <div class="mb-4">
                                        <label for="blogExcerpt" class="form-label">Cuplikan (Opsional)</label>
                                        <textarea class="form-control" id="blogExcerpt" name="cuplikan" rows="3" placeholder="Ringkasan singkat artikel (akan dibuat otomatis jika kosong)"></textarea>
                                    </div>

                                    <!-- Upload Featured Image -->
                                    <div class="mb-4">
                                        <label for="featuredImage" class="form-label">Upload Featured Image</label>
                                        <input class="form-control" type="file" id="featuredImage" name="featured_image" accept="image/*">
                                        <small class="text-muted">Maksimal 5MB. Format: JPG, PNG, GIF, WEBP</small>
                                        <div id="image-preview-container">
                                            <img id="image-preview" src="#" alt="Preview Gambar">
                                            <span class="preview-placeholder" id="placeholder-text">Pratinjau Gambar</span>
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
                                        <input type="text" class="form-control" id="postAuthor" value="<?= htmlspecialchars($personil['nama_lengkap']) ?>" readonly>
                                    </div>

                                    <!-- Kategori (Dropdown) -->
                                    <div class="mb-4">
                                        <label for="postCategory" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" id="postCategory" name="kategori_id" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= htmlspecialchars($category['id']) ?>">
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Status (Radio) -->
                                    <div class="mb-4">
                                        <label class="form-label d-block">Status Artikel</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft" checked>
                                            <label class="form-check-label" for="statusDraft">Draft</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="statusPublished" value="published">
                                            <label class="form-check-label" for="statusPublished">Publish</label>
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
                        <a href="/personil/blog" class="btn btn-secondary" id="cancelBtn">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary-custom" id="submitBlogBtn">
                            <i class="bi bi-send-check me-2"></i> Simpan Blog
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
    <script src="/assets/js/personil/blog/create.js"></script>

</body>

</html>