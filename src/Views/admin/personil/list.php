<?php
// --- SIMULASI PHP LOGIC (Data, Filters, and Pagination) ---

// 1. Simulating Data Fetch
$personilData = [
    [
        'id' => 1,
        'nama_lengkap' => 'Budi Setiawan, S.T., M.Kom.',
        'role' => 'Dosen Pembimbing',
        'spesialisasi' => 'Software Architecture',
        'photo_url' => 'https://via.placeholder.com/40/4e73df/ffffff?text=BS',
        'status' => 'Aktif',
    ],
    [
        'id' => 2,
        'nama_lengkap' => 'Ani Rachman',
        'role' => 'Talent/Geeks',
        'spesialisasi' => 'Full-Stack Developer',
        'photo_url' => 'https://via.placeholder.com/40/858796/ffffff?text=AR',
        'status' => 'Aktif',
    ],
    [
        'id' => 3,
        'nama_lengkap' => 'Cahya Gumilang',
        'role' => 'Talent/Geeks',
        'spesialisasi' => 'Data Scientist',
        'photo_url' => 'https://via.placeholder.com/40/1cc88a/ffffff?text=CG',
        'status' => 'Inactive',
    ],
    [
        'id' => 4,
        'nama_lengkap' => 'Dina Kartika',
        'role' => 'Dosen Pembimbing',
        'spesialisasi' => 'UI/UX Design',
        'photo_url' => 'https://via.placeholder.com/40/f6c23e/ffffff?text=DK',
        'status' => 'Aktif',
    ],
    [ 'id' => 5, 'nama_lengkap' => 'Eko Prasetyo', 'role' => 'Talent/Geeks', 'spesialisasi' => 'DevOps', 'photo_url' => 'https://via.placeholder.com/40/e74a3b/ffffff?text=EP', 'status' => 'Aktif' ],
    [ 'id' => 6, 'nama_lengkap' => 'Fani Wijaya', 'role' => 'Talent/Geeks', 'spesialisasi' => 'Mobile Developer', 'photo_url' => 'https://via.placeholder.com/40/5a5c69/ffffff?text=FW', 'status' => 'Aktif' ],
    [ 'id' => 7, 'nama_lengkap' => 'Gita Permata', 'role' => 'Dosen Pembimbing', 'spesialisasi' => 'Product Owner', 'photo_url' => 'https://via.placeholder.com/40/4e73df/ffffff?text=GP', 'status' => 'Aktif' ],
];

// 2. Simulating Filters and Pagination Parameters
$itemsPerPage = 5;
$totalItems = count($personilData); 
$totalPages = ceil($totalItems / $itemsPerPage);

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$filters = [
    'search' => isset($_GET['search']) ? trim($_GET['search']) : '',
    'role' => isset($_GET['role']) ? trim($_GET['role']) : ''
];

// Filter data 
$filteredData = array_filter($personilData, function($personil) use ($filters) {
    $matchSearch = empty($filters['search']) || stripos($personil['nama_lengkap'], $filters['search']) !== false || stripos($personil['spesialisasi'], $filters['search']) !== false;
    $matchRole = empty($filters['role']) || (strtolower($personil['role']) === strtolower($filters['role']));
    return $matchSearch && $matchRole;
});
$totalFilteredItems = count($filteredData);
$totalPages = ceil($totalFilteredItems / $itemsPerPage);
$currentPage = max(1, min($currentPage, $totalPages > 0 ? $totalPages : 1));

// Apply pagination slice
$offset = ($currentPage - 1) * $itemsPerPage;
$paginatedData = array_slice($filteredData, $offset, $itemsPerPage);


// Function to build pagination link with current filters
function getPaginationLink($page, $filters) {
    $link = "?page={$page}";
    if (!empty($filters['search'])) {
        $link .= '&search=' . urlencode($filters['search']);
    }
    if (!empty($filters['role'])) {
        $link .= '&role=' . urlencode($filters['role']);
    }
    return $link;
}
// --- END SIMULASI PHP LOGIC ---
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personil Management - SE Laboratory</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/admin/personil/list.css">

</head>
<body id="page-top" class="bg-light">

    <div id="wrapper">
        
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="sidebar">
            
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
                <div class="logo-icon rotate-n-15">SE</div>
                <div class="sidebar-brand-text mx-3">SE Laboratory</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Management
            </div>

            <li class="nav-item">
                <a class="nav-link" href="/admin/blog-list">
                    <i class="bi bi-pencil-square"></i>
                    <span>Blog Management</span>
                </a>
            </li>

            <li class="nav-item active">
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

            <li class="nav-item">
                <a class="nav-link" href="/admin/join-applications">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Join Applications</span>
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

                    <button id="sidebarToggleMobile" class="btn btn-link d-md-none rounded-circle me-3">
                        <i class="bi bi-list fs-4"></i>
                    </button>

                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">Admin User</span>
                                <img class="img-profile rounded-circle" src="https://via.placeholder.com/60/4e73df/ffffff?text=AU">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2 text-gray-400"></i>Profile</a>
                                <a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2 text-gray-400"></i>Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="bi bi-box-arrow-left me-2 text-gray-400"></i>Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <div class="container-fluid">
                    <div class="page-header d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Personil Management</h1>
                            <p class="text-muted">Kelola daftar Dosen Pembimbing dan Talent/Geeks.</p>
                        </div>
                        <div class="d-flex gap-3">
                             <a href="/admin/join-applications" class="btn btn-outline-secondary d-none d-md-inline-flex align-items-center">
                                <i class="bi bi-file-earmark-text me-2"></i> Lihat Aplikasi
                            </a>
                            <a href="/admin/personil/create" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-person-plus-fill me-2"></i> Tambah Personil
                            </a>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Personil (Total: <?= $totalFilteredItems ?>)</h6>
                        </div>
                        <div class="card-body">
                            
                            <form id="filterForm" method="GET" class="mb-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" id="search" placeholder="Cari Nama/Spesialisasi..." value="<?= htmlspecialchars($filters['search']) ?>">
                                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <select class="form-select" name="role" id="filterRole">
                                            <option value="" <?= empty($filters['role']) ? 'selected' : '' ?>>Semua Tipe Personil</option>
                                            <option value="dosen pembimbing" <?= strtolower($filters['role']) === 'dosen pembimbing' ? 'selected' : '' ?>>Dosen Pembimbing</option>
                                            <option value="talent/geeks" <?= strtolower($filters['role']) === 'talent/geeks' ? 'selected' : '' ?>>Talent/Geeks</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <a href="/admin/personil" class="btn btn-outline-secondary" title="Reset Filter">
                                            <i class="bi bi-arrow-clockwise"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="personilTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nama Personil</th>
                                            <th>Tipe</th>
                                            <th>Spesialisasi</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($paginatedData) && $totalFilteredItems > 0): // This block is mostly for filtering with no result ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">Tidak ada data personil yang cocok dengan filter.</td>
                                            </tr>
                                        <?php elseif (empty($personilData)): // No data at all ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">Belum ada data personil. Silakan tambahkan personil baru.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $startNum = $offset + 1; foreach ($paginatedData as $index => $personil): ?>
                                                <tr data-id="<?= htmlspecialchars($personil['id']) ?>">
                                                    <td class="text-center"><?= $startNum + $index ?></td>
                                                    <td class="d-flex align-items-center">
                                                        <img src="<?= htmlspecialchars($personil['photo_url']) ?>" alt="<?= htmlspecialchars($personil['nama_lengkap']) ?>" class="personil-avatar me-2">
                                                        <span class="text-nowrap"><?= htmlspecialchars($personil['nama_lengkap']) ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill <?= $personil['role'] === 'Dosen Pembimbing' ? 'bg-primary' : 'bg-info text-dark' ?>">
                                                            <?= htmlspecialchars($personil['role']) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= htmlspecialchars($personil['spesialisasi']) ?></td>
                                                    <td class="text-center">
                                                        <span class="badge rounded-pill <?= $personil['status'] === 'Aktif' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                                            <?= htmlspecialchars($personil['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        <a href="/admin/personil/edit/<?= $personil['id'] ?>" class="btn btn-sm btn-outline-primary action-button" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger action-button delete-personil" data-id="<?= $personil['id'] ?>" title="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted small">
                                    Menampilkan <?= count($paginatedData) ?> dari <?= $totalFilteredItems ?> data (Halaman <?= $currentPage ?> dari <?= $totalPages ?>)
                                </div>

                                <nav aria-label="Page navigation example">
                                    <ul class="pagination pagination-sm mb-0">
                                        
                                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="<?= getPaginationLink($currentPage - 1, $filters) ?>" tabindex="-1" aria-disabled="<?= $currentPage <= 1 ? 'true' : 'false' ?>">Previous</a>
                                        </li>

                                        <?php 
                                        $start = max(1, $currentPage - 1);
                                        $end = min($totalPages, $currentPage + 1);

                                        if ($currentPage == 1 && $totalPages >= 3) $end = 3;
                                        if ($currentPage == $totalPages && $totalPages >= 3) $start = $totalPages - 2;

                                        for ($i = $start; $i <= $end; $i++): ?>
                                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                                <a class="page-link" href="<?= getPaginationLink($i, $filters) ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="<?= getPaginationLink($currentPage + 1, $filters) ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span class="text-gray-600">&copy; 2025 Software Engineering Laboratory. All rights reserved.</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="bi bi-angle-up"></i>
    </a>
    
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout-process">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple Sidebar Toggle for SB Admin 2 structure
        document.querySelector('#sidebarToggle, #sidebarToggleMobile')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('body').classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });
    </script>
    <script src="/assets/js/admin/personil/list.js"></script>

</body>
</html>