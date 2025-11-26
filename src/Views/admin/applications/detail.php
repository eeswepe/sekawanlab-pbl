<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aplikasi (<?= htmlspecialchars($application['nim']) ?>) - SE Lab</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="/assets/css/admin/applications/detail.css">
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="bi bi-code-square"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SE Lab Admin</div>
            </a>

            <hr class="sidebar-divider my-0" style="border-top: 1px solid rgba(255,255,255,0.15);">

            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/blog-list">
                    <i class="bi bi-pencil-square"></i>
                    <span>Blog Management</span>
                </a>
            </li>
            <li class="nav-item">
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
                <a class="nav-link active" href="/admin/join-applications">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Join Applications</span>
                </a>
            </li>
             <li class="nav-item mt-3">
                <a class="nav-link text-danger" href="/logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow px-4">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="bi bi-list"></i>
                    </button>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrator</span>
                                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name=Admin&background=4e73df&color=fff" style="width:32px; height:32px;">
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Detail Aplikasi</h1>
                        <a href="/admin/join-applications" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                            <i class="bi bi-arrow-left fa-sm text-white-50"></i> Kembali
                        </a>
                    </div>

                    <div class="row">

                        <div class="col-lg-8">

                            <div class="card shadow mb-4 border-left-primary">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Status Terkini</h6>
                                </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                                     <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-gray-800">Nama Pelamar</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= htmlspecialchars($application['nama_lengkap']) ?></div>
                                        <div class="text-muted small mt-1">NIM: <?= htmlspecialchars($application['nim']) ?></div>
                                    </div>
                                    <div class="text-end">
                                        <?php
                                        $statusClass = 'secondary';
                                        if ($application['status'] == 'accepted') $statusClass = 'success';
                                        elseif ($application['status'] == 'rejected') $statusClass = 'danger';
                                        elseif ($application['status'] == 'reviewed') $statusClass = 'info';
                                        elseif ($application['status'] == 'pending') $statusClass = 'warning';
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?> fs-6 px-3 py-2">
                                            <?= strtoupper($application['status']) ?>
                                        </span>
                                        <div class="small text-muted mt-2">
                                            Applied: <?= date('d M Y', strtotime($application['tanggal_apply'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Akademik & Kontak</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="small text-muted font-weight-bold">Email</label>
                                            <div class="text-dark"><?= htmlspecialchars($application['email']) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted font-weight-bold">Nomor Telepon</label>
                                            <div class="text-dark"><?= htmlspecialchars($application['phone']) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted font-weight-bold">Program Studi</label>
                                            <div class="text-dark"><?= htmlspecialchars($application['prodi']) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted font-weight-bold">Semester</label>
                                            <div class="text-dark"><?= $application['semester'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Motivasi & Portfolio</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label class="small text-muted font-weight-bold">Alasan Bergabung</label>
                                        <div class="p-3 bg-light rounded border-0" style="white-space: pre-wrap;"><?= htmlspecialchars($application['alasan_bergabung']) ?></div>
                                    </div>
                                    <?php if (!empty($application['github_url'])): ?>
                                        <div>
                                            <label class="small text-muted font-weight-bold">Link Portfolio/GitHub</label>
                                            <div>
                                                <a href="<?= htmlspecialchars($application['github_url']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-github me-1"></i> <?= htmlspecialchars($application['github_url']) ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="card shadow mb-4 border-left-warning">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-warning">Quick Actions</h6>
                                </div>
                                <div class="card-body d-grid gap-2" id="quickActions">
                                    <?php if ($application['status'] === 'accepted'): ?>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $application['phone']) ?>" target="_blank" class="btn btn-success btn-icon-split justify-content-start">
                                            <span class="icon text-white-50"><i class="bi bi-whatsapp"></i></span>
                                            <span class="text">Hubungi via WhatsApp</span>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-success btn-icon-split justify-content-start" id="quickAccept" data-id="<?= $application['id'] ?>">
                                            <span class="icon text-white-50"><i class="bi bi-check-lg"></i></span>
                                            <span class="text w-100">Terima Aplikasi</span>
                                        </button>
                                        <button class="btn btn-danger btn-icon-split justify-content-start" id="quickReject" data-id="<?= $application['id'] ?>">
                                            <span class="icon text-white-50"><i class="bi bi-x-lg"></i></span>
                                            <span class="text w-100">Tolak Aplikasi</span>
                                        </button>
                                    <?php endif; ?>
                                    <hr>
                                    <button class="btn btn-outline-danger btn-sm" id="deleteApplication" data-id="<?= $application['id'] ?>">
                                        <i class="bi bi-trash"></i> Hapus Permanen
                                    </button>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Lampiran CV</h6>
                                </div>
                                <div class="card-body text-center">
                                    <?php if (!empty($application['cv_file_path'])): 
                                        $cvName = basename($application['cv_file_path']);
                                        $cvPath = ltrim($application['cv_file_path'], '/');
                                        $cvExt = strtolower(pathinfo($cvPath, PATHINFO_EXTENSION));
                                    ?>
                                        <div class="mb-3">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger display-4"></i>
                                            <div class="small text-gray-800 mt-2 text-truncate"><?= htmlspecialchars($cvName) ?></div>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <a href="/<?= htmlspecialchars($cvPath) ?>" class="btn btn-primary btn-sm" download>
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                            <?php if ($cvExt === 'pdf'): ?>
                                                <button type="button" id="previewCvBtn" data-cv-path="<?= htmlspecialchars($cvPath) ?>" data-cv-name="<?= htmlspecialchars($cvName) ?>" class="btn btn-info btn-sm text-white">
                                                    <i class="bi bi-eye"></i> Preview
                                                </button>
                                            <?php endif; ?>
                                             <button type="button" id="viewSummaryBtn" class="btn btn-secondary btn-sm" data-cv-path="<?= htmlspecialchars($cvPath) ?>" data-cv-name="<?= htmlspecialchars($cvName) ?>">
                                                <i class="bi bi-robot"></i> AI Summary
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted small">Tidak ada CV dilampirkan.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SE Laboratory 2025</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <div class="modal fade" id="cvPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cvPreviewModalLabel">Preview CV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="cvPreviewIframe" src="" style="width:100%;height:75vh;border:0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Summary Modal -->
    <div class="modal fade" id="viewSummaryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewSummaryModalLabel">
                        <i class="bi bi-robot me-2"></i>AI Summary - CV Analysis
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="summaryLoadingState" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Menganalisis CV dengan AI...</p>
                    </div>
                    <div id="summaryContent" class="d-none">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Catatan:</strong> Analisis ini dihasilkan oleh AI dan mungkin tidak 100% akurat.
                        </div>
                        <div id="summaryResult"></div>
                    </div>
                    <div id="summaryError" class="d-none">
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <span id="summaryErrorMessage">Gagal menganalisis CV. Silakan coba lagi.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="retrySummary" class="btn btn-primary d-none">
                        <i class="bi bi-arrow-clockwise me-1"></i>Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
    
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/applications/detail.js"></script>

</body>
</html>