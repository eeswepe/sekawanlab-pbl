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
  <link rel="stylesheet" href="/assets/css/personil/dashboard/index.css">
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
        <li><a href="/personil" class="active"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
        <li><a href="/personil/profile"><i class="bi bi-person-circle"></i> My Profile</a></li>
        <li><a href="/personil/blog"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
        <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </nav>

    <!-- Main Content -->
    <div id="main-content">

      <!-- Main Dashboard -->
      <main class="content">
        <div class="page-header">
          <h1>Selamat datang, <?= htmlspecialchars($personil['nama_lengkap']) ?>!</h1>
          <p class="text-muted">Berikut ringkasan aktivitas kamu hari ini.</p>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-info">
                <h3><?= number_format($stats['total_blogs']) ?></h3>
                <p>Blog Posts</p>
              </div>
              <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-info">
                <h3><?= number_format($stats['total_projects']) ?></h3>
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
            <a href="/personil/blog/create" class="btn btn-primary-custom"><i class="bi bi-pencil-square me-2"></i> Tulis Blog Baru</a>
            <a href="/personil/profile/edit" class="btn btn-outline-secondary"><i class="bi bi-person-lines-fill me-2"></i> Edit Profil</a>
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
                  <?php if (empty($recentBlogs)): ?>
                    <tr>
                      <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada blog post. <a href="/personil/blog/create">Buat yang pertama!</a>
                      </td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($recentBlogs as $blog): ?>
                      <tr>
                        <td><?= htmlspecialchars($blog['judul']) ?></td>
                        <td>
                          <?php
                          $date = $blog['tanggal_publish'] ?? $blog['created_at'];
                          echo date('d M Y', strtotime($date));
                          ?>
                        </td>
                        <td>
                          <?php if ($blog['status'] === 'published'): ?>
                            <span class="badge bg-success">Published</span>
                          <?php else: ?>
                            <span class="badge bg-warning text-dark">Draft</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <?php if (!empty($recentBlogs)): ?>
              <div class="text-center mt-3">
                <a href="/personil/blog" class="btn btn-sm btn-outline-primary">Lihat Semua Blog Post</a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </main>

      <footer class="footer text-center py-3 mt-auto">
        <small class="text-muted">&copy; 2025 SE Laboratory. All rights reserved.</small>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/personil/dashboard/index.js"></script>
</body>
</html>
