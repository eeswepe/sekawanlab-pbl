<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personil Management - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/admin/personil/list.css">

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
                    <li><a href="/admin/personil" class="active"><i class="bi bi-people-fill"></i> Personil Management</a></li>
                    <li><a href="/admin/profil-pages"><i class="bi bi-person-badge"></i> Profile Pages</a></li>
                    <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join Applications</a></li>
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
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Personil Management</h1>
                        <p>List dan kelola seluruh personil SE Laboratory.</p>
                    </div>
                    <a href="/admin/personil/create" class="btn btn-primary-custom flex-shrink-0">
                        <i class="bi bi-person-plus-fill me-2"></i> Tambah Personil
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="/admin/personil" id="filterForm">
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-6 col-lg-4 mb-3 mb-md-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" id="searchName" placeholder="Search by name..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                                        <button class="btn" style="background-color: var(--gold); color: white;" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 offset-lg-4">
                                    <select class="form-select" name="role" id="filterRole" aria-label="Filter by Type">
                                        <option value="all" <?= empty($filters['role']) ? 'selected' : '' ?>>Filter by Tipe (All)</option>
                                        <option value="dosen" <?= (isset($filters['role']) && $filters['role'] === 'admin') ? 'selected' : '' ?>>Dosen Pembimbing</option>
                                        <option value="talent" <?= (isset($filters['role']) && $filters['role'] === 'talent') ? 'selected' : '' ?>>Talent/Geeks</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link <?= empty($filters['role']) ? 'active' : '' ?>" href="/admin/personil">All (<?= $stats['totalAll'] ?>)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= (isset($filters['role']) && $filters['role'] === 'dosen') ? 'active' : '' ?>" href="/admin/personil?role=dosen">Dosen Pembimbing (<?= $stats['totalDosen'] ?>)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= (isset($filters['role']) && $filters['role'] === 'talent') ? 'active' : '' ?>" href="/admin/personil?role=talent">Talent/Geeks (<?= $stats['totalTalent'] ?>)</a>
                            </li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Avatar</th>
                                        <th>Nama</th>
                                        <th>NIM / NIP</th>
                                        <th>Spesialisasi</th>
                                        <th>Tipe</th>
                                        <th>Email</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($personils)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">Tidak ada personil ditemukan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($personils as $index => $personil): ?>
                                            <tr>
                                                <td><?= $offset + $index + 1 ?></td>
                                                <td>
                                                    <?php if (!empty($personil['foto_url'])): ?>
                                                        <img src="<?= htmlspecialchars($personil['foto_url']) ?>" alt="Avatar" class="personil-avatar">
                                                    <?php else: ?>
                                                        <img src="https://via.placeholder.com/150/D4AF37/FFFFFF?text=<?= strtoupper(substr($personil['nama_lengkap'], 0, 2)) ?>" alt="Avatar" class="personil-avatar">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($personil['nama_lengkap']) ?></td>
                                                <td><?= htmlspecialchars($personil['nim_nip']) ?></td>
                                                <td><?= htmlspecialchars($personil['spesialisasi'] ?? '-') ?></td>
                                                <td>
                                                    <?php if ($personil['role'] === 'admin'): ?>
                                                        <span class="badge bg-secondary">Dosen Pembimbing</span>
                                                    <?php else: ?>
                                                        <span class="badge" style="background-color: var(--gold); color: white;">Talent/Geek</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($personil['email']) ?></td>
                                                <td class="text-center">
                                                    <a href="/admin/personil/edit/<?= $personil['id'] ?>" class="btn btn-sm btn-warning action-button" title="Edit"><i class="bi bi-pencil"></i></a>
                                                    <button class="btn btn-sm btn-danger action-button delete-personil" data-id="<?= $personil['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center justify-content-md-end mt-3">
                            <nav aria-label="Personil page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['role']) ? '&role='.$filters['role'] : '' ?>">Previous</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <?php if ($i == $currentPage): ?>
                                            <li class="page-item active">
                                                <a class="page-link" href="#" style="background-color: var(--gold); border-color: var(--gold);"><?= $i ?></a>
                                            </li>
                                        <?php elseif ($i == 1 || $i == $totalPages || ($i >= $currentPage - 1 && $i <= $currentPage + 1)): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?= $i ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['role']) ? '&role='.$filters['role'] : '' ?>"><?= $i ?></a>
                                            </li>
                                        <?php elseif ($i == $currentPage - 2 || $i == $currentPage + 2): ?>
                                            <li class="page-item disabled"><span class="page-link">...</span></li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    
                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= !empty($filters['search']) ? '&search='.urlencode($filters['search']) : '' ?><?= !empty($filters['role']) ? '&role='.$filters['role'] : '' ?>">Next</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Next</a>
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
    <script src="/assets/js/admin/personil/list.js"></script>

</body>
</html>