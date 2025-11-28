<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tulis Blog Baru - SE Laboratory (Personil)</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/personil/blog/create.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">

        <!-- SIDEBAR -->
        <aside id="sidebar" aria-label="Sidebar">
            <div>
                <div class="brand">
                    <img class="logo-icon" src="/assets/img/mascot-head.png" alt="mascot-lab-se" />
                    SE Laboratory
                    <div class="sidebar-divider"></div>
                </div>

                <ul class="sidebar-menu">
                    <li><a href="/personil/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/personil/profile"><i class="bi bi-person-circle"></i> My Profile</a></li>
                    <li><a href="/personil/blog" class="active"><i class="bi bi-journal-text"></i> My Blog Posts</a>
                    </li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>
        <!-- /SIDEBAR -->

        <!-- MAIN CONTENT -->
        <div id="main-content">
            <main class="content-fluid" role="main">
                <div class="page-header">
                    <h1>Tulis Blog Post Baru</h1>
                </div>

                <form id="blogPostForm" enctype="multipart/form-data" method="post" action="">
                    <div class="row g-4">
                        <!-- Left column: content -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Konten Utama</h5>
                                </div>

                                <div class="card-body">
                                    <!-- Title -->
                                    <div class="mb-4">
                                        <label for="postTitle" class="form-label">Judul Artikel <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="postTitle" name="judul"
                                            placeholder="Masukkan judul artikel..." required
                                            value="<?= isset($old['judul']) ? htmlspecialchars($old['judul']) : '' ?>" />
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-4">
                                        <label for="blogContent" class="form-label">Konten <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="blogContent" name="konten" rows="15"
                                            placeholder="Mulai tulis konten artikel Anda di sini..."
                                            required><?= isset($old['konten']) ? htmlspecialchars($old['konten']) : '' ?></textarea>
                                        <small class="text-muted">Estimasi waktu baca akan dihitung otomatis berdasarkan
                                            jumlah kata.</small>
                                    </div>

                                    <!-- Excerpt -->
                                    <div class="mb-4">
                                        <label for="blogExcerpt" class="form-label">Cuplikan (Opsional)</label>
                                        <textarea class="form-control" id="blogExcerpt" name="cuplikan" rows="3"
                                            placeholder="Ringkasan singkat artikel (akan dibuat otomatis jika kosong)"><?= isset($old['cuplikan']) ? htmlspecialchars($old['cuplikan']) : '' ?></textarea>
                                    </div>

                                    <!-- Featured image -->
                                    <div class="mb-4">
                                        <label for="featuredImage" class="form-label">Upload Featured Image</label>
                                        <input class="form-control" type="file" id="featuredImage" name="featured_image"
                                            accept="image/*" />
                                        <small class="text-muted d-block">Maksimal 5MB. Format: JPG, PNG, GIF,
                                            WEBP</small>

                                        <div id="image-preview-container" aria-hidden="true">
                                            <img id="image-preview" src="#" alt="Preview Gambar" />
                                            <span class="preview-placeholder" id="placeholder-text">Pratinjau
                                                Gambar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right column: meta -->
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Status & Metadata</h5>
                                </div>

                                <div class="card-body">
                                    <!-- Author -->
                                    <div class="mb-4">
                                        <label class="form-label">Penulis</label>
                                        <input type="text" class="form-control" id="postAuthor" name="author"
                                            value="<?= htmlspecialchars($personil['nama_lengkap']) ?>" readonly />
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-4">
                                        <label for="postCategory" class="form-label">Kategori <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="postCategory" name="kategori_id" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= htmlspecialchars($category['id']) ?>"
                                                    <?= (isset($old['kategori_id']) && $old['kategori_id'] == $category['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-4">
                                        <label class="form-label d-block">Status Artikel</label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="statusDraft"
                                                value="draft" <?= (isset($old['status']) && $old['status'] === 'published') ? '' : 'checked' ?>>
                                            <label class="form-check-label" for="statusDraft">Draft</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="statusPublished" value="published" <?= (isset($old['status']) && $old['status'] === 'published') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="statusPublished">Publish</label>
                                        </div>
                                    </div>

                                    <!-- Reading time -->
                                    <div class="mb-3">
                                        <label class="form-label">Estimasi Waktu Baca</label>
                                        <input type="text" class="form-control" id="metaReadingTime" name="reading_time"
                                            value="<?= isset($old['reading_time']) ? htmlspecialchars($old['reading_time']) . ' menit' : 'Otomatis (0 menit)' ?>"
                                            readonly />
                                    </div>
                                </div>
                            </div>

                            <!-- Optional: SEO / Tags (placeholder for future) -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Tambahan</h5>
                                </div>
                                <div class="card-body">
                                    <small class="text-muted">Opsional: tambahkan tags atau pengaturan SEO
                                        nanti.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4 mb-5">
                        <a href="/personil/blog" class="btn btn-secondary" id="cancelBtn">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>

                        <!-- If you want separate "Save draft" and "Publish" buttons, handle via name/value -->
                        <button type="submit" class="btn btn-primary-custom" id="submitBlogBtn">
                            <i class="bi bi-send-check me-2"></i> Simpan Blog
                        </button>
                    </div>
                </form>
            </main>

            <!-- FOOTER -->
            <footer class="footer">
                <div class="container-fluid text-center">
                    <span class="text-muted">&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                </div>
            </footer>
        </div>
        <!-- /MAIN CONTENT -->
    </div>
    <!-- /WRAPPER -->

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote Lite JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <!-- Small helper JS: image preview + reading time calc (optional, non-invasive) -->
    <script>
        // Image preview functionality
        (function () {
            const fileInput = document.getElementById('featuredImage');
            const img = document.getElementById('image-preview');
            const container = document.getElementById('image-preview-container');
            const placeholder = document.getElementById('placeholder-text');

            if (fileInput) {
                fileInput.addEventListener('change', (e) => {
                    const f = e.target.files && e.target.files[0];
                    if (!f) {
                        img.style.display = 'none';
                        placeholder.style.display = 'block';
                        container.classList.remove('has-image');
                        return;
                    }
                    if (!f.type.startsWith('image/')) {
                        alert('File bukan gambar.');
                        fileInput.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function (ev) {
                        img.src = ev.target.result;
                        img.style.display = 'block';
                        placeholder.style.display = 'none';
                        container.classList.add('has-image');
                    };
                    reader.readAsDataURL(f);
                });
            }
        })();

        // Initialize Summernote on the content textarea
        $(document).ready(function () {
            $('#blogContent').summernote({
                height: 400,
                placeholder: 'Mulai tulis konten artikel Anda di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onChange: function (contents, $editable) {
                        // Compute reading time based on plain text content
                        const text = $editable.text();
                        const words = text.trim().split(/\s+/).filter(Boolean).length;
                        const minutes = Math.max(0, Math.round(words / 200));
                        $('#metaReadingTime').val(minutes > 0 ? minutes + ' menit' : 'Otomatis (0 menit)');
                    }
                }
            });
            // Initial reading time calculation for any pre-filled content
            const initialText = $('#blogContent').summernote('code').replace(/<[^>]*>/g, '');
            const words = initialText.trim().split(/\s+/).filter(Boolean).length;
            const minutes = Math.max(0, Math.round(words / 200));
            $('#metaReadingTime').val(minutes > 0 ? minutes + ' menit' : 'Otomatis (0 menit)');
        });
    </script>

    <!-- Custom JS (optional - keep for existing behavior) -->
    <script src="/assets/js/personil/blog/create.js"></script>
</body>

</html>