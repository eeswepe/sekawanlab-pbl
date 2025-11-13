<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - SE Laboratory</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/css/admin_dashboard.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside id="sidebar">
      <div>
        <div class="brand"><span class="logo-icon">SE</span> SE Laboratory</div>
        <ul class="sidebar-menu">
          <li><a href="/admin" class="active"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
          <li><a href="/admin/blog-list"><i class="bi bi-pencil-square"></i> Blog Management</a></li>
          <li><a href="/admin/personil"><i class="bi bi-people-fill"></i> Personil Management</a></li>
          <li><a href="/admin/profil-pages"><i class="bi bi-person-badge"></i> Profile Pages</a></li>
          <li><a href="/admin/join-applications"><i class="bi bi-file-earmark-text"></i> Join Applications</a></li>
          <li><a href="/admin/site-settings"><i class="bi bi-gear-fill"></i> Settings</a></li>
          <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content">
      <!-- Topbar -->
      <nav class="topbar">
        <div class="search-bar d-flex">
          <input type="text" class="form-control" placeholder="Cari...">
          <button class="btn"><i class="bi bi-search"></i></button>
        </div>
        <div class="icons">
          <div class="notification">
            <i class="bi bi-bell-fill fs-5"></i>
            <span class="badge">3</span>
          </div>
          <div class="dropdown profile-dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-dark text-decoration-none" href="#" data-bs-toggle="dropdown">
              <img src="https://via.placeholder.com/100" alt="Profile"> Admin
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i>Profil</a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2"></i>Pengaturan</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Dashboard Content -->
      <div class="content">
        <h1 class="page-title">Selamat Datang, Admin!</h1>
        <p class="mb-4 text-muted">Berikut ringkasan aktivitas hari ini.</p>

        <!-- Statistic Cards -->
        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-info">
                <h3>125</h3>
                <p>Total Personil</p>
              </div>
              <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-info">
                <h3>42</h3>
                <p>Blog Posts</p>
              </div>
              <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-info">
                <h3>15</h3>
                <p>Pending Applications</p>
              </div>
              <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-info">
                <h3>1.2M</h3>
                <p>Total Views</p>
              </div>
              <div class="stat-icon"><i class="bi bi-eye-fill"></i></div>
            </div>
          </div>
        </div>

        <!-- Recent Activities -->
        <div class="card mb-4">
          <div class="card-header fw-semibold">Aktivitas Terbaru</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Aktivitas</th>
                    <th>Target</th>
                    <th>Status</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Dr. Anita</td>
                    <td>Menambahkan Blog Baru</td>
                    <td>"AI in Education"</td>
                    <td><span class="badge bg-success">Published</span></td>
                    <td>15m lalu</td>
                  </tr>
                  <tr>
                    <td>Budi (Talent)</td>
                    <td>Memperbarui Profil</td>
                    <td>Profile Page</td>
                    <td><span class="badge bg-primary">Updated</span></td>
                    <td>45m lalu</td>
                  </tr>
                  <tr>
                    <td>System</td>
                    <td>Permohonan Baru</td>
                    <td>"Joko S."</td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                    <td>1h lalu</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
          <div class="card-header fw-semibold">Aksi Cepat</div>
          <div class="card-body d-flex gap-3 flex-wrap">
            <button class="btn btn-primary-custom"><i class="bi bi-plus-circle me-2"></i>Tambah Blog Post</button>
            <button class="btn btn-primary-custom"><i class="bi bi-person-plus me-2"></i>Tambah Personil</button>
            <button class="btn btn-outline-secondary"><i class="bi bi-file-earmark-check me-2"></i>Lihat Aplikasi</button>
          </div>
        </div>
      </div>

      <footer>
        &copy; 2025 Software Engineering Laboratory. All rights reserved.
      </footer>
    </div>
  </div>

  <!-- Bootstrap & Custom JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/js/admin_dashboard.js"></script>
</body>
</html>
