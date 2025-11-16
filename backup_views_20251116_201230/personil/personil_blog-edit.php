<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/personil_blog-edit.css"> 
</head>
<body>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="../dashboard.html">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li><a href="/personil"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li><a href="/personil/profile"><i class="bi bi-person-circle"></i> My Profile</a></li>
                <li><a href="/personil/blog" class="active"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
                <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
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
                                <img src="<?= htmlspecialchars($personil['foto_url'] ?? 'https://via.placeholder.com/150/1a1a1a/FFFFFF?text=P') ?>" alt="Profile Picture">
                                <span class="d-none d-md-inline"><?= htmlspecialchars($personil['nama_lengkap']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="/personil/profile"><i class="bi bi-person-fill"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
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
                                    <h5 class="card-title"><i class="bi bi-file-text me-2" style="color: var(--gold);"></i> Detail Post</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="postTitle" class="form-label">Judul Post</label>
                                        <input type="text" class="form-control" id="postTitle" name="judul" value="<?= htmlspecialchars($blog['judul']) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="postContent" class="form-label">Konten Artikel</label>
                                        <textarea class="form-control" id="postContent" name="konten" rows="15" required><?= htmlspecialchars($blog['konten']) ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="postExcerpt" class="form-label">Cuplikan (Opsional)</label>
                                        <textarea class="form-control" id="postExcerpt" name="cuplikan" rows="3" placeholder="Otomatis dibuat jika kosong"><?= htmlspecialchars($blog['cuplikan'] ?? '') ?></textarea>
                                    </div>

                                    <div class="mb-0">
                                        <label for="postCategory" class="form-label">Kategori</label>
                                        <select class="form-select" id="postCategory" name="kategori_id" required>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>" <?= $category['id'] == $blog['kategori_id'] ? 'selected' : '' ?>>
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
                                    <h5 class="card-title"><i class="bi bi-clock-history me-2" style="color: var(--gold);"></i> Status & Info</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="postStatus" class="form-label">Status Post</label>
                                        <select class="form-select" id="postStatus" name="status">
                                            <option value="draft" <?= $blog['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                            <option value="published" <?= $blog['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label">Terakhir Diupdate</label>
                                        <input type="text" class="form-control" value="<?= date('d M Y H:i', strtotime($blog['updated_at'])) ?> WIB" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="bi bi-image-fill me-2" style="color: var(--gold);"></i> Gambar Unggulan</h5>
                                </div>
                                <div class="card-body">
                                    <img src="<?= htmlspecialchars($blog['featured_image_url'] ?? 'https://via.placeholder.com/400x200/444444/FFFFFF?text=No+Image') ?>" alt="Featured Image" class="img-fluid rounded mb-3" id="imagePreview">
                                    <div class="mb-3">
                                        <label for="featuredImage" class="form-label">Upload Gambar Baru</label>
                                        <input class="form-control" type="file" id="featuredImage" name="featured_image" accept="image/*">
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
    <script src="/js/personil_blog-edit.js"></script>
</body>
</html>