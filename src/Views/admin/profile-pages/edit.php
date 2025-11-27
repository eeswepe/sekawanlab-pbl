<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Halaman Profil - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/admin/profile-pages/edit.css">

</head>

<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div>
                <div class="brand"><img class="logo-icon" src="/assets/img/mascot-head.png" alt="mascot-lab-se">SE
                    Laboratory
                    <div class="sidebar-divider"></div>
                </div>
                <ul class="sidebar-menu">
                    <li><a href="/admin"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/admin/blog-list"><i class="bi bi-pencil-square"></i> Blog Management</a></li>
                    <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a></li>
                    <li><a href="/admin/profil-pages" class="active"><i class="bi bi-person-badge"></i> Profile
                            Pages</a></li>
                    <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join Applications</a>
                    </li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>

        <div id="main-content">
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Edit Halaman Profil: <?= htmlspecialchars($page['page_title']) ?></h1>
                        <p>Perbarui konten dan tampilan untuk halaman **<?= htmlspecialchars($page['page_title']) ?>**.
                        </p>
                    </div>
                </div>

                <form id="profilePageEditForm" method="POST" enctype="multipart/form-data">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">1. Data Hero Section (Bagian Atas Halaman)</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    value="<?= htmlspecialchars($page['slug']) ?>" required>
                                <small class="form-text text-muted">URL-friendly identifier untuk halaman ini.</small>
                            </div>
                            <div class="mb-3">
                                <label for="pageTitle" class="form-label">Page Title (Judul Utama/Hero)</label>
                                <input type="text" class="form-control" id="pageTitle" name="page_title"
                                    value="<?= htmlspecialchars($page['page_title']) ?>" required>
                                <small class="form-text text-muted">Judul ini muncul paling besar di bagian atas (hero
                                    section).</small>
                            </div>
                            <div class="mb-3">
                                <label for="pageSubtitle" class="form-label">Page Subtitle (Deskripsi Hero)</label>
                                <textarea class="form-control" id="pageSubtitle" name="page_subtitle" rows="2"
                                    required><?= htmlspecialchars($page['page_subtitle']) ?></textarea>
                                <small class="form-text text-muted">Sub-judul pendukung di bawah judul utama.</small>
                            </div>
                            <div class="mb-3">
                                <label for="featuredImage" class="form-label">Featured Image (Gambar Utama)</label>
                                <div class="d-flex flex-column">
                                    <?php if (!empty($page['featured_image_url'])): ?>
                                        <img id="featured-image-preview"
                                            src="<?= htmlspecialchars($page['featured_image_url']) ?>"
                                            alt="Featured Image Preview">
                                    <?php else: ?>
                                        <img id="featured-image-preview"
                                            src="https://via.placeholder.com/800x250/1a1a1a/D4AF37?text=No+Image"
                                            alt="No Image">
                                    <?php endif; ?>
                                    <input class="form-control" type="file" id="featuredImage" name="featured_image"
                                        accept="image/*">
                                    <small class="form-text text-muted">Unggah gambar baru (rasio ideal 16:5 atau 16:6)
                                        untuk mengganti gambar saat ini.</small>
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
                                <input type="text" class="form-control" id="contentTitle" name="content_title"
                                    value="<?= htmlspecialchars($page['content_title']) ?>" required>
                                <small class="form-text text-muted">Judul utama konten yang muncul setelah hero
                                    section.</small>
                            </div>
                            <div class="mb-3">
                                <label for="contentSubtitle" class="form-label">Content Subtitle (Subjudul
                                    Konten)</label>
                                <textarea class="form-control" id="contentSubtitle" name="content_subtitle" rows="15"
                                    required><?= htmlspecialchars($page['content_subtitle']) ?></textarea>
                                <small class="form-text text-muted">Isi lengkap konten halaman. Gunakan format plain
                                    text atau markdown.</small>
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
    <script src="/assets/js/admin/profile-pages/edit.js"></script>

</body>

</html>