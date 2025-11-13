<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personil Management - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>
<body>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="dashboard.html">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li class="sidebar-nav-item">
                    <a href="dashboard.html" class="sidebar-nav-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="blog-list.html" class="sidebar-nav-link">
                        <i class="bi bi-pencil-square"></i>
                        <span>Blog Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="personil-list.html" class="sidebar-nav-link active">
                        <i class="bi bi-people-fill"></i>
                        <span>Personil Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-file-person"></i>
                        <span>Profile Pages</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Join Applications</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="../login.html" class="sidebar-nav-link">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </li>
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
                    <a href="#" class="btn btn-primary-custom flex-shrink-0">
                        <i class="bi bi-person-plus-fill me-2"></i> Tambah Personil
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-6 col-lg-4 mb-3 mb-md-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by name...">
                                    <button class="btn" style="background-color: var(--gold); color: white;" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 offset-lg-4">
                                <select class="form-select" aria-label="Filter by Type">
                                    <option selected>Filter by Tipe (All)</option>
                                    <option value="dosen">Dosen Pembimbing</option>
                                    <option value="talent">Talent/Geeks</option>
                                </select>
                            </div>
                        </div>
                        
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">All (125)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Dosen Pembimbing (15)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Talent/Geeks (110)</a>
                            </li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Nama</th>
                                        <th>Role</th>
                                        <th>Tipe</th>
                                        <th>Email</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/150/505050/FFFFFF?text=DR" alt="Avatar" class="personil-avatar"></td>
                                        <td>Dr. Anita Sari, S.Kom., M.T.</td>
                                        <td>Head of Lab</td>
                                        <td><span class="badge bg-secondary">Dosen Pembimbing</span></td>
                                        <td>anita.sari@lab.ac.id</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info action-button"><i class="bi bi-eye"></i></button>
                                            <button class="btn btn-sm btn-warning action-button"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger action-button"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/150/D4AF37/FFFFFF?text=BU" alt="Avatar" class="personil-avatar"></td>
                                        <td>Budi Santoso</td>
                                        <td>Mobile Developer</td>
                                        <td><span class="badge" style="background-color: var(--gold); color: white;">Talent/Geek</span></td>
                                        <td>budi.s@geek.id</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info action-button"><i class="bi bi-eye"></i></button>
                                            <button class="btn btn-sm btn-warning action-button"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger action-button"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/150/007bff/FFFFFF?text=CL" alt="Avatar" class="personil-avatar"></td>
                                        <td>Citra Lestari</td>
                                        <td>UI/UX Designer</td>
                                        <td><span class="badge" style="background-color: var(--gold); color: white;">Talent/Geek</span></td>
                                        <td>citra.l@geek.id</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info action-button"><i class="bi bi-eye"></i></button>
                                            <button class="btn btn-sm btn-warning action-button"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger action-button"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/150/28a745/FFFFFF?text=PR" alt="Avatar" class="personil-avatar"></td>
                                        <td>Prof. Dr. Rahmat</td>
                                        <td>Supervisor</td>
                                        <td><span class="badge bg-secondary">Dosen Pembimbing</span></td>
                                        <td>rahmat.p@lab.ac.id</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info action-button"><i class="bi bi-eye"></i></button>
                                            <button class="btn btn-sm btn-warning action-button"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger action-button"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center justify-content-md-end mt-3">
                            <nav aria-label="Personil page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
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

</body>
</html>