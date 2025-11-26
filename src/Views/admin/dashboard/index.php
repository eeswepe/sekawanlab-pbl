<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - SE Laboratory</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <!-- Google Fonts: Nunito (SB Admin 2 default) -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

  <!-- Custom CSS (Modern Clean) -->
  <link rel="stylesheet" href="/assets/css/admin/dashboard/index.css">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper" class="wrapper"><!-- class="wrapper" dipertahankan demi kompatibilitas JS lama -->

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar d-flex flex-column">

      <!-- Sidebar Brand -->
      <div class="sidebar-brand">
        <span class="fw-bold">SE Laboratory</span>
      </div>

      <!-- Sidebar Menu (menggunakan struktur mirip SB Admin 2) -->
      <ul class="nav flex-column mt-3">
        <li class="nav-item">
          <a href="/admin" class="nav-link active">
            <i class="bi bi-grid-fill me-2"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/blog-list" class="nav-link">
            <i class="bi bi-pencil-square me-2"></i>
            <span>Blog Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/personil" class="nav-link">
            <i class="bi bi-people-fill me-2"></i>
            <span>Personil Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/profil-pages" class="nav-link">
            <i class="bi bi-person-badge me-2"></i>
            <span>Profile Pages</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/join-applications" class="nav-link">
            <i class="bi bi-file-earmark-text me-2"></i>
            <span>Join Applications</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <a href="/logout" class="nav-link">
            <i class="bi bi-box-arrow-left me-2"></i>
            <span>Logout</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper">

      <!-- Main Content -->
      <div id="content" class="content"><!-- class="content" dipertahankan untuk jaga-jaga -->

        <!-- (Optional) Topbar minimal, clean -->
        <div class="topbar d-flex align-items-center justify-content-between mb-4">
          <div>
            <h1 class="page-title mb-1">Selamat Datang, Admin!</h1>
            <p class="text-muted mb-0">Berikut ringkasan aktivitas hari ini.</p>
          </div>
        </div>

        <!-- Statistic Cards -->
        <div class="row g-3 mb-4">
          <div class="col-md-4 col-lg-3">
            <div class="card stat-card">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div class="stat-info">
                  <h3><?= htmlspecialchars($totalPersonil) ?></h3>
                  <p>Total Personil</p>
                </div>
                <div class="stat-icon">
                  <i class="bi bi-people-fill"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-lg-3">
            <div class="card stat-card">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div class="stat-info">
                  <h3><?= htmlspecialchars($totalBlogPosts) ?></h3>
                  <p>Blog Posts</p>
                </div>
                <div class="stat-icon">
                  <i class="bi bi-pencil-square"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-lg-3">
            <div class="card stat-card">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div class="stat-info">
                  <h3><?= htmlspecialchars($pendingApplications) ?></h3>
                  <p>Pending Applications</p>
                </div>
                <div class="stat-icon">
                  <i class="bi bi-file-earmark-text"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activities -->
        <div class="card mb-4">
          <div class="card-header">
            Aktivitas Terbaru
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Nama</th>
                    <th>Aktivitas</th>
                    <th>Target</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($recentActivities)): ?>
                    <tr>
                      <td colspan="4" class="text-center text-muted">Belum ada aktivitas</td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($recentActivities as $activity): ?>
                      <tr>
                        <td><?= htmlspecialchars($activity['nama']) ?></td>
                        <td><?= htmlspecialchars($activity['aktivitas']) ?></td>
                        <td>"<?= htmlspecialchars($activity['target']) ?>"</td>
                        <td>
                          <?php
                          $statusClass = 'secondary';
                          $statusText = ucfirst($activity['status']);
                          if ($activity['status'] === 'published') {
                              $statusClass = 'success';
                              $statusText = 'Published';
                          } elseif ($activity['status'] === 'draft') {
                              $statusClass = 'warning text-dark';
                              $statusText = 'Draft';
                          }
                          ?>
                          <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
          <div class="card-header">
            Aksi Cepat
          </div>
          <div class="card-body d-flex gap-2 flex-wrap">
            <a href="/admin/blog/create" class="btn btn-primary-custom">
              <i class="bi bi-plus-circle me-2"></i>Tambah Blog Post
            </a>
            <a href="/admin/personil/create" class="btn btn-primary-custom">
              <i class="bi bi-person-plus me-2"></i>Tambah Personil
            </a>
            <a href="/admin/join-applications" class="btn btn-outline-secondary">
              <i class="bi bi-file-earmark-check me-2"></i>Lihat Aplikasi
            </a>
          </div>
        </div>

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="mt-auto py-3 text-center small text-muted">
        &copy; 2025 Software Engineering Laboratory. All rights reserved.
      </footer>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap 5 Bundle (with Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS (dipertahankan) -->
  <script src="/assets/js/admin/dashboard/index.js"></script>
</body>
</html>
