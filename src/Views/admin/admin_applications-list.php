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

                        <form class="d-none d-md-inline-block ms-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search applications...">
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
                <div class="page-header">
                    <h1>Join Applications List</h1>
                    <p>Manage and review all incoming applications to the laboratory.</p>
                </div>

                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>210</h3>
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
                                <h3>15</h3>
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
                                <h3>180</h3>
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
                                <h3>15</h3>
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
                        <div class="d-flex align-items-center mt-2 mt-sm-0">
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary dropdown-toggle btn-action-sm" type="button" id="bulkActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-lightning-fill me-1"></i> Bulk Actions
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bulkActionsDropdown">
                                    <li><a class="dropdown-item text-success" href="#" id="bulkAccept"><i class="bi bi-check-circle me-2"></i> Accept Selected</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" id="bulkReject"><i class="bi bi-x-circle me-2"></i> Reject Selected</a></li>
                                </ul>
                            </div>
                             <a href="#" class="btn btn-primary-custom btn-action-sm">
                                <i class="bi bi-upload me-1"></i> Export Data
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4 filter-controls">
                            <div class="col-md-3 col-sm-6">
                                <select class="form-select" aria-label="Filter by Prodi" id="filterProdi">
                                    <option selected>Filter by Prodi</option>
                                    <option value="SE">Software Engineering</option>
                                    <option value="CS">Computer Science</option>
                                    <option value="IS">Information Systems</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <select class="form-select" aria-label="Filter by Status" id="filterStatus">
                                    <option selected>Filter by Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="reviewed">Reviewed</option>
                                    <option value="accepted">Accepted</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <input type="date" class="form-control" id="filterDateFrom" placeholder="From Date">
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <input type="date" class="form-control" id="filterDateTo" placeholder="To Date">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="applicationsTable">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input" type="checkbox" id="selectAll"></th>
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
                                    <tr>
                                        <td><input class="form-check-input row-checkbox" type="checkbox" data-id="1"></td>
                                        <td>Joko Susilo</td>
                                        <td>18021234</td>
                                        <td>Software Engineering</td>
                                        <td>5</td>
                                        <td>2025-11-10</td>
                                        <td><span class="badge bg-warning bg-pending">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-action-sm btn-primary-custom view-detail" data-id="1"><i class="bi bi-eye"></i> View</button>
                                            <button class="btn btn-sm btn-action-sm btn-outline-secondary update-status" data-id="1"><i class="bi bi-arrow-repeat"></i> Update</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input class="form-check-input row-checkbox" type="checkbox" data-id="2"></td>
                                        <td>Citra Lestari</td>
                                        <td>19035678</td>
                                        <td>Computer Science</td>
                                        <td>7</td>
                                        <td>2025-10-28</td>
                                        <td><span class="badge bg-success">Accepted</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-action-sm btn-primary-custom view-detail" data-id="2"><i class="bi bi-eye"></i> View</button>
                                            <button class="btn btn-sm btn-action-sm btn-outline-secondary update-status" data-id="2"><i class="bi bi-arrow-repeat"></i> Update</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input class="form-check-input row-checkbox" type="checkbox" data-id="3"></td>
                                        <td>Ahmad Yani</td>
                                        <td>18019012</td>
                                        <td>Information Systems</td>
                                        <td>5</td>
                                        <td>2025-11-05</td>
                                        <td><span class="badge bg-danger">Rejected</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-action-sm btn-primary-custom view-detail" data-id="3"><i class="bi bi-eye"></i> View</button>
                                            <button class="btn btn-sm btn-action-sm btn-outline-secondary update-status" data-id="3"><i class="bi bi-arrow-repeat"></i> Update</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input class="form-check-input row-checkbox" type="checkbox" data-id="4"></td>
                                        <td>Budi Santoso</td>
                                        <td>20040045</td>
                                        <td>Software Engineering</td>
                                        <td>3</td>
                                        <td>2025-11-01</td>
                                        <td><span class="badge bg-info text-dark">Reviewed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-action-sm btn-primary-custom view-detail" data-id="4"><i class="bi bi-eye"></i> View</button>
                                            <button class="btn btn-sm btn-action-sm btn-outline-secondary update-status" data-id="4"><i class="bi bi-arrow-repeat"></i> Update</button>
                                        </td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted small">Showing 1 to 10 of 210 entries</span>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="#" style="background-color: var(--gold); border-color: var(--gold); color: var(--white);">1</a></li>
                                    <li class="page-item"><a class="page-link text-black" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link text-black" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link text-black" href="#">Next</a></li>
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
    <script src="assets/js/admin_applications-list.js"></script>

</body>
</html>