<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications List - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/admin_applications-list.css">
</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div>
                <div class="brand"><span class="logo-icon">SE</span> SE Laboratory</div>
                <ul class="sidebar-menu">
                    <li><a href="/admin"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="/admin/blog-list"><i class="bi bi-pencil-square"></i> Blog Management</a></li>
                    <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a></li>
                    <li><a href="/admin/profil-pages"><i class="bi bi-person-badge"></i> Profile Pages</a></li>
                    <li><a href="/admin/join-applications" class="active"><i class="bi bi-file-earmark-text"></i> Join Applications</a></li>
                    <li><a href="/admin/site-settings"><i class="bi bi-gear-fill"></i> Settings</a></li>
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>
        <div id="main-content">
            <nav id="topbar" class="navbar navbar-expand-lg">
                <div class="container-fluid d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center">
                        <button class="btn sidebar-toggle sidebar-toggle-mobile" id="sidebarToggleMobile">
                            <i class="bi bi-list"></i>
                        </button>

                        <form class="d-none d-md-inline-block ms-2" method="GET" action="/admin/join-applications">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search applications..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                                <button class="btn" style="background-color: var(--gold); color: white;" type="submit">
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
                <div class="page-header">
                    <h1>Join Applications List</h1>
                    <p>Manage and review all incoming applications to the laboratory.</p>
                </div>

                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3><?= $stats['total'] ?></h3>
                                <p>Total Applications</p>
                            </div>
                            <div class="stat-icon bg-primary">
                                <i class="bi bi-files"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3><?= $stats['pending'] ?></h3>
                                <p>Pending</p>
                            </div>
                            <div class="stat-icon bg-warning">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3><?= $stats['accepted'] ?></h3>
                                <p>Accepted</p>
                            </div>
                            <div class="stat-icon bg-success">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3><?= $stats['rejected'] ?></h3>
                                <p>Rejected</p>
                            </div>
                            <div class="stat-icon bg-danger">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Application Data</h5>
                        <form method="GET" action="/admin/join-applications" id="filterForm" class="d-flex gap-2">
                            <?php if (!empty($filters['search'])): ?>
                                <input type="hidden" name="search" value="<?= htmlspecialchars($filters['search']) ?>">
                            <?php endif; ?>
                            <select class="form-select form-select-sm" name="status" id="filterStatus" style="width: auto;">
                                <option value="all" <?= empty($filters['status']) ? 'selected' : '' ?>>All Status</option>
                                <option value="pending" <?= (isset($filters['status']) && $filters['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="reviewed" <?= (isset($filters['status']) && $filters['status'] === 'reviewed') ? 'selected' : '' ?>>Reviewed</option>
                                <option value="accepted" <?= (isset($filters['status']) && $filters['status'] === 'accepted') ? 'selected' : '' ?>>Accepted</option>
                                <option value="rejected" <?= (isset($filters['status']) && $filters['status'] === 'rejected') ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <select class="form-select form-select-sm" name="prodi" id="filterProdi" style="width: auto;">
                                <option value="all" <?= empty($filters['prodi']) ? 'selected' : '' ?>>All Prodi</option>
                                <option value="TI" <?= (isset($filters['prodi']) && $filters['prodi'] === 'TI') ? 'selected' : '' ?>>TI</option>
                                <option value="SIB" <?= (isset($filters['prodi']) && $filters['prodi'] === 'SIB') ? 'selected' : '' ?>>SIB</option>
                                <option value="PPLS" <?= (isset($filters['prodi']) && $filters['prodi'] === 'PPLS') ? 'selected' : '' ?>>PPLS</option>
                            </select>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="applicationsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Prodi</th>
                                        <th>Semester</th>
                                        <th>Tanggal Apply</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($applications)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">Tidak ada application ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($applications as $index => $app): ?>
                                            <tr>
                                                <td><?= $offset + $index + 1 ?></td>
                                                <td><?= htmlspecialchars($app['nama_lengkap']) ?></td>
                                                <td><?= htmlspecialchars($app['nim']) ?></td>
                                                <td><?= htmlspecialchars($app['prodi']) ?></td>
                                                <td><?= $app['semester'] ?></td>
                                                <td><?= date('Y-m-d', strtotime($app['tanggal_apply'])) ?></td>
                                                <td>
                                                    <?php
                                                    $badgeClass = [
                                                        'pending' => 'bg-warning',
                                                        'reviewed' => 'bg-info text-dark',
                                                        'accepted' => 'bg-success',
                                                        'rejected' => 'bg-danger'
                                                    ][$app['status']] ?? 'bg-secondary';
                                                    ?>
                                                    <span class="badge <?= $badgeClass ?>"><?= ucfirst($app['status']) ?></span>
                                                </td>
                                                <td>
                                                    <a href="/admin/join-application/<?= $app['id'] ?>" class="btn btn-sm btn-action-sm btn-primary-custom view-detail"><i class="bi bi-eye"></i> View</a>
                                                    <button class="btn btn-sm btn-action-sm btn-danger delete-application" data-id="<?= $app['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted small">Showing <?= $offset + 1 ?> to <?= min($offset + count($applications), $totalApplications) ?> of <?= $totalApplications ?> entries</span>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link text-black" href="?page=<?= $currentPage - 1 ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['status']) ? '&status='.$filters['status'] : '' ?><?= !empty($filters['prodi']) ? '&prodi='.$filters['prodi'] : '' ?>">Previous</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">Previous</a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <?php if ($i == $currentPage): ?>
                                            <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#" style="background-color: var(--gold); border-color: var(--gold); color: var(--white);"><?= $i ?></a>
                                            </li>
                                        <?php elseif ($i == 1 || $i == $totalPages || ($i >= $currentPage - 1 && $i <= $currentPage + 1)): ?>
                                            <li class="page-item">
                                                <a class="page-link text-black" href="?page=<?= $i ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['status']) ? '&status='.$filters['status'] : '' ?><?= !empty($filters['prodi']) ? '&prodi='.$filters['prodi'] : '' ?>"><?= $i ?></a>
                                            </li>
                                        <?php elseif ($i == $currentPage - 2 || $i == $currentPage + 2): ?>
                                            <li class="page-item disabled"><span class="page-link">...</span></li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    
                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link text-black" href="?page=<?= $currentPage + 1 ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['status']) ? '&status='.$filters['status'] : '' ?><?= !empty($filters['prodi']) ? '&prodi='.$filters['prodi'] : '' ?>">Next</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                        </div>
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
    <script src="/js/admin_applications-list.js"></script>

</body>
</html>