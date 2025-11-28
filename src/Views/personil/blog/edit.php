<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/personil/blog/edit.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet" />
</head>

<body>

    <div class="wrapper">
        <aside id="sidebar">
            <div>
                <div class="brand"><img class="logo-icon" src="/assets/img/mascot-head.png" alt="mascot-lab-se">SE
                    Laboratory
                    <div class="sidebar-divider"></div>
                </div>

                <ul class="sidebar-menu">
                    <li><a href="/personil/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/personil/profile"><i class="bi bi-person-circle"></i> My Profile</a></li>
                    <li><a href="/personil/blog" class="active"><i class="bi bi-journal-text"></i> My Blog Posts</a>
                    </li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
        </aside>
        <div id="main-content">
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Edit Blog Post</h1>
                        <p>Perbarui artikel Anda. (ID: #<?= $blog['id'] ?>)</p>
                    </div>
                </div>

                <form id="editBlogPostForm" enctype="multipart/form-data">
                    <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-file-text me-2"
                                            style="color: var(--gold);"></i> Detail Post</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="postTitle" class="form-label">Judul Post</label>
                                        <input type="text" class="form-control" id="postTitle" name="judul"
                                            value="<?= htmlspecialchars($blog['judul']) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="postContent" class="form-label">Konten Artikel</label>
                                        <textarea class="form-control" id="postContent" name="konten" rows="15"
                                            required><?= htmlspecialchars($blog['konten']) ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="postExcerpt" class="form-label">Cuplikan (Opsional)</label>
                                        <textarea class="form-control" id="postExcerpt" name="cuplikan" rows="3"
                                            placeholder="Otomatis dibuat jika kosong"><?= htmlspecialchars($blog['cuplikan'] ?? '') ?></textarea>
                                    </div>

                                    <div class="mb-0">
                                        <label for="postCategory" class="form-label">Kategori</label>
                                        <select class="form-select" id="postCategory" name="kategori_id" required>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>"
                                                    <?= $category['id'] == $blog['kategori_id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-clock-history me-2"
                                            style="color: var(--gold);"></i> Status & Info</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="postStatus" class="form-label">Status Post</label>
                                        <select class="form-select" id="postStatus" name="status">
                                            <option value="draft" <?= $blog['status'] == 'draft' ? 'selected' : '' ?>>Draft
                                            </option>
                                            <option value="published" <?= $blog['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label">Terakhir Diupdate</label>
                                        <input type="text" class="form-control"
                                            value="<?= date('d M Y H:i', strtotime($blog['updated_at'])) ?> WIB"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-image-fill me-2"
                                            style="color: var(--gold);"></i> Gambar Unggulan</h5>
                                </div>
                                <div class="card-body">
                                    <img src="<?= htmlspecialchars($blog['featured_image_url'] ?? 'https://via.placeholder.com/400x200/444444/FFFFFF?text=No+Image') ?>"
                                        alt="Featured Image" class="img-fluid rounded mb-3" id="imagePreview">
                                    <div class="mb-3">
                                        <label for="featuredImage" class="form-label">Upload Gambar Baru</label>
                                        <input class="form-control" type="file" id="featuredImage" name="featured_image"
                                            accept="image/*">
                                    </div>
                                    <small class="text-muted">Rekomendasi rasio: 16:9. Max 5MB</small>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="bi bi-save-fill me-2"></i> Update Post
                                </button>
                                <a href="/personil/blog" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle-fill me-2"></i> Cancel
                                </a>
                            </div>
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
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote Lite JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="/assets/js/personil/blog/edit.js"></script>
</body>

</html>