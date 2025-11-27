<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Saya - SE Laboratory (Personil)</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/assets/css/personil/blog/list.css"> 

</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div>
        <div class="brand"><img class="logo-icon" src="/assets/img/mascot-head.png" alt="mascot-lab-se">SE Laboratory
          <div class="sidebar-divider"></div>
        </div>

            <ul class="sidebar-menu">
                <li><a href="/personil/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li><a href="/personil/profile"><i class="bi bi-person-circle"></i> My Profile</a></li>
                <li><a href="/personil/blog" class="active"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
                <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div id="main-content">
            <!-- Main Content Area: Blog List -->
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
                    <h1>Blog Saya</h1>
                    <a href="/personil/blog/create" class="btn btn-primary-custom" id="tulisBlogBaruBtn">
                        <i class="bi bi-plus-circle me-2"></i> Tulis Blog Baru
                    </a>
                </div>

                <!-- Statistics -->
                <div class="row g-3 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3 id="totalPosts"><?= $stats['total_posts'] ?? 0 ?></h3>
                                <p>Total Posts</p>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3 id="publishedPosts"><?= $stats['published_posts'] ?? 0 ?></h3>
                                <p>Published</p>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3 id="draftPosts"><?= $stats['draft_posts'] ?? 0 ?></h3>
                                <p>Draft</p>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Daftar Artikel Anda</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Thumbnail</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="blogTableBody">
                                    <?php if (empty($blogs)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <p class="text-muted mb-0">Belum ada blog yang dibuat.</p>
                                                <a href="/personil/blog/create" class="btn btn-primary-custom mt-2">
                                                    <i class="bi bi-plus-circle me-2"></i> Buat Blog Pertama
                                                </a>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($blogs as $blog): ?>
                                            <tr data-status="<?= htmlspecialchars($blog['status']) ?>" data-id="<?= htmlspecialchars($blog['id']) ?>">
                                                <td>
                                                    <img src="<?= htmlspecialchars($blog['featured_image_url'] ?? 'https://placehold.co/80x50/3498db/ffffff?text=Blog') ?>" 
                                                         class="post-thumbnail" 
                                                         alt="Thumbnail">
                                                </td>
                                                <td>
                                                    <strong><?= htmlspecialchars($blog['judul']) ?></strong>
                                                    <?php if ($blog['reading_time']): ?>
                                                        <br><small class="text-muted"><?= $blog['reading_time'] ?> min read</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($blog['kategori_nama'] ?? '-') ?></td>
                                                <td>
                                                    <?php if ($blog['tanggal_publish']): ?>
                                                        <?= date('d M Y', strtotime($blog['tanggal_publish'])) ?>
                                                    <?php else: ?>
                                                        <?= date('d M Y', strtotime($blog['created_at'])) ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($blog['status'] === 'published'): ?>
                                                        <span class="badge bg-success">Published</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning text-dark">Draft</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center table-actions">
                                                    <a href="/personil/blog/edit/<?= $blog['id'] ?>" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <a href="/blog/<?= htmlspecialchars($blog['slug']) ?>" target="_blank" class="btn btn-sm btn-secondary">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                    <?php if ($blog['status'] === 'draft'): ?>
                                                        <button class="btn btn-sm btn-danger delete-btn" data-blog-id="<?= $blog['id'] ?>">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if (!empty($blogs)): ?>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted" id="pagination-info">
                            Menampilkan <?= count($blogs) ?> dari <?= $totalBlogs ?> Artikel
                        </small>
                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                        <nav>
                            <ul class="pagination pagination-sm my-0">
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                                </li>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php if ($i == 1 || $i == $totalPages || abs($i - $currentPage) <= 2): ?>
                                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php elseif ($i == 2 || $i == $totalPages - 1): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                                </li>
                            </ul>
                        </aside>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
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
    <script src="/assets/js/personil/blog/list.js"></script>

</body>
</html>