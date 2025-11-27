<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management - SE Laboratory</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Custom CSS File -->
    <link rel="stylesheet" href="/assets/css/admin/blog/list.css"> 

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
                    <li><a href="/admin"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/admin/blog-list" class="active"><i class="bi bi-pencil-square"></i> Blog Management</a></li>
                    <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a></li>
                    <li><a href="/admin/profil-pages"><i class="bi bi-person-badge"></i> Profile Pages</a></li>
                    <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join Applications</a></li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>
        </nav>

        <!-- Main Content -->
        <div id="main-content">
            <!-- Main Content Area -->
            <main class="content-fluid">
                <!-- Page Header & Button -->
                <div class="page-header">
                    <div class="page-title">
                        <h1>Blog Management</h1>
                    </div>
                    <div>
                        <a href="/admin/blog/create" class="btn btn-primary-custom">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Blog Post
                        </a>
                    </div>
                </div>

                <!-- Filter and Search Section -->
                <div class="card filter-section">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Filter Blog Posts</h5>
                        <form method="GET" action="/admin/blog-list" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <!-- Search by Title -->
                                <div class="col-lg-5 col-md-6 col-sm-12">
                                    <label for="searchTitle" class="form-label visually-hidden">Search by Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchTitle" name="search" placeholder="Cari berdasarkan judul..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                                        <button class="btn btn-primary-custom" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Filter by Kategori -->
                                <div class="col-lg-2 col-md-6 col-sm-4">
                                    <label for="filterCategory" class="form-label text-muted d-block mb-1" style="font-size: 0.8rem;">Kategori</label>
                                    <select class="form-select" id="filterCategory" name="kategori">
                                        <option value="all" <?= empty($filters['kategori_id']) ? 'selected' : '' ?>>Semua</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>" <?= (isset($filters['kategori_id']) && $filters['kategori_id'] == $cat['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Filter by Penulis -->
                                <div class="col-lg-2 col-md-6 col-sm-4">
                                    <label for="filterAuthor" class="form-label text-muted d-block mb-1" style="font-size: 0.8rem;">Penulis</label>
                                    <select class="form-select" id="filterAuthor" name="penulis">
                                        <option value="all" <?= empty($filters['penulis_id']) ? 'selected' : '' ?>>Semua</option>
                                        <?php foreach ($personils as $personil): ?>
                                            <option value="<?= $personil['id'] ?>" <?= (isset($filters['penulis_id']) && $filters['penulis_id'] == $personil['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($personil['nama_lengkap']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Filter by Status -->
                                <div class="col-lg-2 col-md-6 col-sm-4">
                                    <label for="filterStatus" class="form-label text-muted d-block mb-1" style="font-size: 0.8rem;">Status</label>
                                    <select class="form-select" id="filterStatus" name="status">
                                        <option value="all" <?= empty($filters['status']) ? 'selected' : '' ?>>Semua</option>
                                        <option value="published" <?= (isset($filters['status']) && $filters['status'] === 'published') ? 'selected' : '' ?>>Published</option>
                                        <option value="draft" <?= (isset($filters['status']) && $filters['status'] === 'draft') ? 'selected' : '' ?>>Draft</option>
                                    </select>
                                </div>
                                <!-- Reset Button -->
                                <div class="col-lg-1 col-md-6 col-sm-12 d-grid">
                                    <a href="/admin/blog-list" class="btn btn-outline-secondary" title="Reset">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Data Table Section -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 5%;">#</th>
                                        <th scope="col" style="width: 10%;">Thumbnail</th>
                                        <th scope="col" style="width: 30%;">Judul</th>
                                        <th scope="col" style="width: 10%;">Kategori</th>
                                        <th scope="col" style="width: 10%;">Penulis</th>
                                        <th scope="col" style="width: 15%;">Tanggal</th>
                                        <th scope="col" style="width: 10%;">Status</th>
                                        <th scope="col" style="width: 10%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($blogs)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">Tidak ada blog ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($blogs as $index => $blog): ?>
                                            <tr>
                                                <td><?= $offset + $index + 1 ?></td>
                                                <td>
                                                    <?php if ($blog['featured_image_url']): ?>
                                                        <img src="<?= htmlspecialchars($blog['featured_image_url']) ?>" alt="Thumbnail" class="blog-thumbnail">
                                                    <?php else: ?>
                                                        <img src="https://placehold.co/80x50/B8941F/ffffff?text=No+Image" alt="Thumbnail" class="blog-thumbnail">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($blog['judul']) ?></td>
                                                <td><?= htmlspecialchars($blog['kategori_nama'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($blog['penulis_nama'] ?? '-') ?></td>
                                                <td><?= $blog['tanggal_publish'] ? date('Y-m-d', strtotime($blog['tanggal_publish'])) : date('Y-m-d', strtotime($blog['created_at'])) ?></td>
                                                <td>
                                                    <?php if ($blog['status'] === 'published'): ?>
                                                        <span class="badge" style="background-color: var(--gold); color: white;">Published</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Draft</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="action-btn-group d-flex">
                                                        <a href="/admin/blog/edit/<?= $blog['id'] ?>" class="btn btn-sm btn-info text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                                        <button class="btn btn-sm btn-danger delete-blog" data-id="<?= $blog['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end mb-0">
                                <?php if ($currentPage > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['kategori_id']) ? '&kategori='.$filters['kategori_id'] : '' ?><?= !empty($filters['penulis_id']) ? '&penulis='.$filters['penulis_id'] : '' ?><?= !empty($filters['status']) ? '&status='.$filters['status'] : '' ?>">Previous</a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php if ($i == $currentPage): ?>
                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="#" style="background-color: var(--gold); border-color: var(--dark-gold);"><?= $i ?></a>
                                        </li>
                                    <?php elseif ($i == 1 || $i == $totalPages || ($i >= $currentPage - 1 && $i <= $currentPage + 1)): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $i ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['kategori_id']) ? '&kategori='.$filters['kategori_id'] : '' ?><?= !empty($filters['penulis_id']) ? '&penulis='.$filters['penulis_id'] : '' ?><?= !empty($filters['status']) ? '&status='.$filters['status'] : '' ?>"><?= $i ?></a>
                                        </li>
                                    <?php elseif ($i == $currentPage - 2 || $i == $currentPage + 2): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                
                                <?php if ($currentPage < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['kategori_id']) ? '&kategori='.$filters['kategori_id'] : '' ?><?= !empty($filters['penulis_id']) ? '&penulis='.$filters['penulis_id'] : '' ?><?= !empty($filters['status']) ? '&status='.$filters['status'] : '' ?>">Next</a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
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
    <script src="/assets/js/admin/blog/list.js"></script> 

</body>
</html>