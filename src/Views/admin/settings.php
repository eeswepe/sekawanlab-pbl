<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Settings - SE Laboratory</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../public/css/admin_settings.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="brand">
        <span class="logo-icon">SE</span> SE Laboratory
      </div>
      <ul class="sidebar-menu">
        <li><a href="/admin/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
        <li><a href="/admin/settings" class="active"><i class="bi bi-gear-fill"></i> Settings</a></li>
        <li><a href="#"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <div id="main-content">
      <!-- Topbar -->
      <nav class="topbar">
        <div class="d-flex justify-content-between align-items-center w-100">
          <h5 class="m-0 fw-semibold">Pengaturan Website</h5>
          <div class="dropdown profile-dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-dark text-decoration-none" href="#" data-bs-toggle="dropdown">
              <img src="https://via.placeholder.com/40" alt="Profile">
              <span class="ms-2">Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i>Profil</a></li>
              <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Settings Tabs -->
      <main class="content">
        <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" id="lab-tab" data-bs-toggle="tab" href="#lab-info">Lab Information</a></li>
          <li class="nav-item"><a class="nav-link" id="social-tab" data-bs-toggle="tab" href="#social">Social Media</a></li>
          <li class="nav-item"><a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#users">User Management</a></li>
          <li class="nav-item"><a class="nav-link" id="site-tab" data-bs-toggle="tab" href="#site">Site Settings</a></li>
        </ul>

        <div class="tab-content">
          <!-- Lab Information -->
          <div class="tab-pane fade show active" id="lab-info">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-3">Informasi Laboratorium</h5>
                <form>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Lab Name</label>
                      <input type="text" class="form-control" placeholder="Software Engineering Lab">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" placeholder="se.lab@example.com">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Phone</label>
                      <input type="text" class="form-control" placeholder="+62 812 3456 7890">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Address</label>
                      <input type="text" class="form-control" placeholder="Jl. Teknik Informatika No. 10">
                    </div>
                    <div class="col-12">
                      <label class="form-label">Description</label>
                      <textarea class="form-control" rows="3" placeholder="Deskripsi singkat laboratorium..."></textarea>
                    </div>
                  </div>
                  <div class="text-end mt-3">
                    <button type="button" class="btn btn-primary-custom">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Social Media -->
          <div class="tab-pane fade" id="social">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-3">Social Media Links</h5>
                <form>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Facebook URL</label>
                      <input type="url" class="form-control" placeholder="https://facebook.com/selab">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Twitter URL</label>
                      <input type="url" class="form-control" placeholder="https://twitter.com/selab">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Instagram URL</label>
                      <input type="url" class="form-control" placeholder="https://instagram.com/selab">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">LinkedIn URL</label>
                      <input type="url" class="form-control" placeholder="https://linkedin.com/company/selab">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">GitHub URL</label>
                      <input type="url" class="form-control" placeholder="https://github.com/selab">
                    </div>
                  </div>
                  <div class="text-end mt-3">
                    <button type="button" class="btn btn-primary-custom">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- User Management -->
          <div class="tab-pane fade" id="users">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="card-title">Manajemen Admin</h5>
                  <button class="btn btn-primary-custom"><i class="bi bi-plus-circle me-2"></i>Tambah Admin</button>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Admin Utama</td>
                        <td>admin@selab.com</td>
                        <td><span class="badge bg-primary">Super Admin</span></td>
                        <td><button class="btn btn-sm btn-outline-secondary">Ganti Password</button></td>
                      </tr>
                      <tr>
                        <td>Rina S.</td>
                        <td>rina@selab.com</td>
                        <td><span class="badge bg-secondary">Editor</span></td>
                        <td><button class="btn btn-sm btn-outline-secondary">Ganti Password</button></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Site Settings -->
          <div class="tab-pane fade" id="site">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-3">Site Settings</h5>
                <form>
                  <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="maintenanceMode">
                    <label class="form-check-label" for="maintenanceMode">Maintenance Mode</label>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Contact Form Email</label>
                    <input type="email" class="form-control" placeholder="contact@selab.com">
                  </div>
                  <div class="text-end">
                    <button type="button" class="btn btn-primary-custom">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>

      <footer class="footer text-center py-3 mt-auto">
        <small class="text-muted">&copy; 2025 Software Engineering Laboratory. All rights reserved.</small>
      </footer>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/js/admin_settings.js"></script>
</body>
</html>
