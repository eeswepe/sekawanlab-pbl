<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Pages Management - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/admin/profile-pages/list.css">


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
                    <li><a href="/admin/blog-list"><i class="bi bi-pencil-square"></i> Blog Management</a></li>
                    <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a></li>
                    <li><a href="/admin/profil-pages" class="active"><i class="bi bi-person-badge"></i> Profile Pages</a></li>
                    <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join Applications</a></li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>
        </nav>

        <div id="main-content">
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Profile Pages Management</h1>
                        <p>Kelola dan perbarui halaman-halaman informasi statis (Tentang Kami, Visi & Misi, dll.).</p>
                    </div>
                    <a href="/admin/profil-pages/create" class="btn btn-primary-custom">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Halaman Baru
                    </a>
                </div>

                <div class="row g-4">
                    <?php if (empty($pages)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">Belum ada halaman profil yang dibuat.</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($pages as $page): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="card profile-card-item">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <h5 class="card-title"><?= htmlspecialchars($page['page_title']) ?></h5>
                                            <small>Last updated: <?= date('d M Y', strtotime($page['last_updated'])) ?></small>
                                        </div>
                                        <div class="d-grid mt-auto">
                                            <a href="/admin/profil-pages/edit/<?= $page['id'] ?>" class="btn btn-primary-custom btn-sm">
                                                <i class="bi bi-pencil-square me-2"></i> Edit Halaman
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

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