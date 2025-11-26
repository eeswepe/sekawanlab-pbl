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
  <link rel="stylesheet" href="/assets/css/admin/dashboard/index.css">
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
          <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content">
      <!-- Dashboard Content -->
      <div class="content">
        <h1 class="page-title">Selamat Datang, Admin!</h1>
        <p class="mb-4 text-muted">Berikut ringkasan aktivitas hari ini.</p>

        <!-- Statistic Cards -->
        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-info">
                <h3><?= htmlspecialchars($totalPersonil) ?></h3>
                <p>Total Personil</p>
              </div>
              <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-info">
                <h3><?= htmlspecialchars($totalBlogPosts) ?></h3>
                <p>Blog Posts</p>
              </div>
              <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-info">
                <h3><?= htmlspecialchars($pendingApplications) ?></h3>
                <p>Pending Applications</p>
              </div>
              <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
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
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($recentActivities)): ?>
                    <tr>
                      <td colspan="5" class="text-center text-muted">Belum ada aktivitas</td>
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
          <div class="card-header fw-semibold">Aksi Cepat</div>
          <div class="card-body d-flex gap-3 flex-wrap">
            <a href="/admin/blog/create" class="btn btn-primary-custom"><i class="bi bi-plus-circle me-2"></i>Tambah Blog Post</a>
            <a href="/admin/personil/create" class="btn btn-primary-custom"><i class="bi bi-person-plus me-2"></i>Tambah Personil</a>
            <a href="/admin/join-applications" class="btn btn-outline-secondary"><i class="bi bi-file-earmark-check me-2"></i>Lihat Aplikasi</a>
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
  <script src="/assets/js/admin/dashboard/index.js"></script>
</body>
</html>
