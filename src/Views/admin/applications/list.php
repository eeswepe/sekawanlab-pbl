<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications List - SE Laboratory</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="/assets/css/admin/applications/list.css">
</head>
<body id="page-top">

    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="bi bi-gear-fill"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SE Laboratory</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admin/blog-list">
                    <i class="bi bi-pencil-square"></i>
                    <span>Blog Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/personil">
                    <i class="bi bi-people-fill"></i>
                    <span>Personil Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/profil-pages">
                    <i class="bi bi-person-badge"></i>
                    <span>Profile Pages</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/admin/join-applications">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Join Applications</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                        <i class="bi bi-list fs-4 text-gray-800"></i>
                    </button>
                    
                    <h1 class="h3 mb-0 text-gray-800 d-none d-sm-block">Join Applications List</h1>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">User Name</span>
                                <img class="img-profile rounded-circle" src="https://via.placeholder.com/60/4e73df/ffffff?text=U" style="width: 32px; height: 32px; object-fit: cover;">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person-fill fa-sm fa-fw me-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout" data-toggle="modal" data-target="#logoutModal">
                                    <i class="bi bi-box-arrow-right fa-sm fa-fw me-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">

                    <div class="page-header d-sm-none"> <h1>Join Applications List</h1>
                        <p>Manage and review all incoming applications to the laboratory.</p>
                    </div>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card border-primary d-flex align-items-center justify-content-between">
                                <div class="stat-info">
                                    <p class="text-primary">Total Applications</p>
                                    <h3><?= $stats['total'] ?></h3>
                                </div>
                                <div class="stat-icon bg-primary">
                                    <i class="bi bi-files"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card border-warning d-flex align-items-center justify-content-between">
                                <div class="stat-info">
                                    <p class="text-warning">Pending</p>
                                    <h3><?= $stats['pending'] ?></h3>
                                </div>
                                <div class="stat-icon bg-warning">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card border-success d-flex align-items-center justify-content-between">
                                <div class="stat-info">
                                    <p class="text-success">Accepted</p>
                                    <h3><?= $stats['accepted'] ?></h3>
                                </div>
                                <div class="stat-icon bg-success">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card border-danger d-flex align-items-center justify-content-between">
                                <div class="stat-info">
                                    <p class="text-danger">Rejected</p>
                                    <h3><?= $stats['rejected'] ?></h3>
                                </div>
                                <div class="stat-icon bg-danger">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Application Data</h6>
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
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="applicationsTable" width="100%" cellspacing="0">
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
                                                        // Mapping class untuk badge
                                                        $badgeClass = [
                                                            'pending' => 'bg-pending', // Custom class for warning style
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
                                        <?php 
                                            // Helper function to build pagination link
                                            $build_link = function($page) use ($filters) {
                                                $link = "?page=$page";
                                                if (!empty($filters['search'])) $link .= '&search=' . urlencode($filters['search']);
                                                if (!empty($filters['status'])) $link .= '&status=' . $filters['status'];
                                                if (!empty($filters['prodi'])) $link .= '&prodi=' . $filters['prodi'];
                                                return $link;
                                            };
                                        ?>
                                        
                                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="<?= $currentPage > 1 ? $build_link($currentPage - 1) : '#' ?>">Previous</a>
                                        </li>
                                        
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <?php if ($i == $currentPage): ?>
                                                <li class="page-item active" aria-current="page">
                                                    <a class="page-link" href="#"><?= $i ?></a>
                                                </li>
                                            <?php elseif ($i == 1 || $i == $totalPages || ($i >= $currentPage - 1 && $i <= $currentPage + 1)): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="<?= $build_link($i) ?>"><?= $i ?></a>
                                                </li>
                                            <?php elseif ($i == $currentPage - 2 || $i == $currentPage + 2): ?>
                                                <li class="page-item disabled d-none d-sm-block"><span class="page-link">...</span></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        
                                        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="<?= $currentPage < $totalPages ? $build_link($currentPage + 1) : '#' ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <footer class="footer sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="/assets/js/admin/applications/list.js"></script>
    </body>
</html>