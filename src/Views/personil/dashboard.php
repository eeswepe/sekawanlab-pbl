<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personil Dashboard - SE Laboratory</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../public/css/personil_dashboard.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <a class="sidebar-brand" href="#">
          <div class="logo-icon">SE</div>
          <span>SE Laboratory</span>
        </a>
      </div>

      <ul class="sidebar-nav">
        <li><a href="#" class="active"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
        <li><a href="#"><i class="bi bi-person-circle"></i> My Profile</a></li>
        <li><a href="#"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
        <li><a href="#"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </nav>

    <!-- Main Content -->
    <div id="main-content">
      <!-- Top Navbar -->
      <nav class="topbar">
        <div class="d-flex justify-content-end align-items-center w-100">
          <div class="dropdown me-3">
            <a class="nav-link position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown">
              <i class="bi bi-bell-fill fs-5"></i>
              <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle p-1">2</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-chat-dots"></i> Komentar baru di blog kamu</a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-heart"></i> Blog kamu mendapat 10 likes</a></li>
            </ul>
          </div>

          <div class="dropdown profile-dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-dark text-decoration-none" href="#" data-bs-toggle="dropdown">
              <img src="https://via.placeholder.com/40" alt="Profile">
              <span class="ms-2">John Doe</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i> Profil Saya</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-left me-2"></i> Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Main Dashboard -->
      <main class="content">
        <div class="page-header">
          <h1>Selamat datang, John Doe!</h1>
          <p class="text-muted">Berikut ringkasan aktivitas kamu hari ini.</p>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-info">
                <h3>12</h3>
                <p>Blog Posts</p>
              </div>
              <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-info">
                <h3>5.8K</h3>
                <p>Total Views</p>
              </div>
              <div class="stat-icon"><i class="bi bi-eye-fill"></i></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-info">
                <h3>3</h3>
                <p>Projects</p>
              </div>
              <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4">
          <div class="card-header fw-semibold">Aksi Cepat</div>
          <div class="card-body d-flex flex-wrap gap-3">
            <button class="btn btn-primary-custom"><i class="bi bi-pencil-square me-2"></i> Tulis Blog Baru</button>
            <button class="btn btn-outline-secondary"><i class="bi bi-person-lines-fill me-2"></i> Edit Profil</button>
          </div>
        </div>

        <!-- Recent Blog Posts -->
        <div class="card">
          <div class="card-header fw-semibold">Blog Terbaru Kamu</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead>
                  <tr>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Views</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Pengalaman Mengajar Machine Learning</td>
                    <td>5 Nov 2025</td>
                    <td><span class="badge bg-success">Published</span></td>
                    <td>1.2K</td>
                  </tr>
                  <tr>
                    <td>AI dalam Dunia Pendidikan</td>
                    <td>30 Okt 2025</td>
                    <td><span class="badge bg-warning text-dark">Draft</span></td>
                    <td>687</td>
                  </tr>
                  <tr>
                    <td>Kolaborasi Riset Terbaru</td>
                    <td>20 Okt 2025</td>
                    <td><span class="badge bg-success">Published</span></td>
                    <td>2.3K</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>

      <footer class="footer text-center py-3 mt-auto">
        <small class="text-muted">&copy; 2025 SE Laboratory. All rights reserved.</small>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/js/personil_dashboard.js"></script>
</body>
</html>
