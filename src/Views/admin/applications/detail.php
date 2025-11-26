<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Detail (18021234) - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/admin/applications/detail.css">
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
                    <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                </ul>
            </div>
        </aside>
        <div id="main-content">

            <main class="content-fluid">

                <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1>Detail Aplikasi: <?= htmlspecialchars($application['nama_lengkap']) ?></h1>
                        <p>Tinjauan lengkap aplikasi bergabung dari mahasiswa dengan NIM: <?= htmlspecialchars($application['nim']) ?>.</p>
                    </div>
                </div>

                <a href="/admin/join-applications" class="btn btn-outline-secondary mb-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Aplikasi
                </a>

                <div class="row g-3">
                    <div class="col-lg-8">

                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h5 class="card-title mb-0 me-3">Status Aplikasi:</h5>
                                </div>
                                <div class="mt-2 mt-sm-0">
                                    <?php
                                    $statusBadge = [
                                        'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'hourglass-split', 'text' => 'PENDING'],
                                        'reviewed' => ['class' => 'bg-info text-dark', 'icon' => 'eye', 'text' => 'REVIEWED'],
                                        'accepted' => ['class' => 'bg-success', 'icon' => 'check-circle', 'text' => 'ACCEPTED'],
                                        'rejected' => ['class' => 'bg-danger', 'icon' => 'x-circle', 'text' => 'REJECTED']
                                    ][$application['status']] ?? ['class' => 'bg-secondary', 'icon' => 'question', 'text' => 'UNKNOWN'];
                                    ?>
                                    <span class="badge badge-status <?= $statusBadge['class'] ?>">
                                        <i class="bi bi-<?= $statusBadge['icon'] ?> me-1"></i> <?= $statusBadge['text'] ?>
                                    </span>
                                    <span class="ms-3 text-muted small">
                                        Tanggal Apply: <?= date('d M Y', strtotime($application['tanggal_apply'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill me-2"></i> Data Pribadi & Akademik</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <span class="detail-label">Nama Lengkap</span>
                                            <span class="detail-value"><?= htmlspecialchars($application['nama_lengkap']) ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">NIM</span>
                                            <span class="detail-value"><?= htmlspecialchars($application['nim']) ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Email</span>
                                            <span class="detail-value"><?= htmlspecialchars($application['email']) ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Nomor Telepon</span>
                                            <span class="detail-value"><?= htmlspecialchars($application['phone']) ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <span class="detail-label">Program Studi (Prodi)</span>
                                            <span class="detail-value"><?= htmlspecialchars($application['prodi']) ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Semester Aktif</span>
                                            <span class="detail-value"><?= $application['semester'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-lightbulb-fill me-2"></i> Motivasi & Kompetensi</h5>
                            </div>
                            <div class="card-body">
                                <div class="detail-item">
                                    <span class="detail-label">Alasan Bergabung (Motivasi)</span>
                                    <p class="detail-value" style="white-space: pre-wrap;"><?= htmlspecialchars($application['alasan_bergabung']) ?></p>
                                </div>
                                <?php if (!empty($application['github_url'])): ?>
                                    <div class="detail-item">
                                        <span class="detail-label">Link Portfolio (GitHub/Lainnya)</span>
                                        <a href="<?= htmlspecialchars($application['github_url']) ?>" target="_blank" class="detail-value">
                                            <?= htmlspecialchars($application['github_url']) ?> <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-paperclip me-2"></i> Dokumen Lampiran (CV)</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($application['cv_file_path'])):
                                    $cvName = basename($application['cv_file_path']);
                                    $cvPath = ltrim($application['cv_file_path'], '/');
                                    $cvExt = strtolower(pathinfo($cvPath, PATHINFO_EXTENSION));
                                ?>
                                    <span class="detail-label">Nama File:</span>
                                    <span class="detail-value d-block mb-3"><?= htmlspecialchars($cvName) ?></span>

                                    <a href="/<?= htmlspecialchars($cvPath) ?>" id="downloadCvBtn" data-cv-path="<?= htmlspecialchars($cvPath) ?>" data-cv-name="<?= htmlspecialchars($cvName) ?>" class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="bi bi-download me-1"></i> Download CV
                                    </a>
                                    <?php if ($cvExt === 'pdf'): ?>
                                        <button type="button" id="previewCvBtn" data-cv-path="<?= htmlspecialchars($cvPath) ?>" data-cv-name="<?= htmlspecialchars($cvName) ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Preview PDF
                                        </button>
                                    <?php endif; ?>
                                    <button type="button" id="viewSummaryBtn" data-cv-path="<?= htmlspecialchars($cvPath) ?>" data-cv-name="<?= htmlspecialchars($cvName) ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-file-earmark-pdf me-1"></i> View Summary
                                    </button>
                                <?php else: ?>
                                    <p class="text-muted mb-0">Tidak ada CV yang dilampirkan</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="bi bi-lightning-fill me-2"></i> Quick Actions</h5>
                            </div>
                            <div class="card-body d-grid gap-2" id="quickActions">
                                <?php if ($application['status'] === 'accepted'): ?>
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $application['phone']) ?>?text=<?= urlencode('Selamat! Aplikasi Anda untuk bergabung dengan Software Engineering Laboratory telah diterima. Silakan hubungi kami untuk informasi lebih lanjut.') ?>" target="_blank" class="btn btn-success">
                                        <i class="bi bi-whatsapp me-2"></i> Konfirmasi via WhatsApp
                                    </a>
                                    <hr>
                                <?php else: ?>
                                    <button class="btn btn-success" id="quickAccept" data-id="<?= $application['id'] ?>">
                                        <i class="bi bi-check-circle me-2"></i> Terima Aplikasi
                                    </button>
                                    <button class="btn btn-danger" id="quickReject" data-id="<?= $application['id'] ?>">
                                        <i class="bi bi-x-circle me-2"></i> Tolak Aplikasi
                                    </button>
                                    <hr>
                                <?php endif; ?>
                                <button class="btn btn-outline-danger" id="deleteApplication" data-id="<?= $application['id'] ?>">
                                    <i class="bi bi-trash me-2"></i> Hapus Aplikasi Permanen
                                </button>
                            </div>
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

    <div class="modal fade" id="cvPreviewModal" tabindex="-1" aria-labelledby="cvPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewSummaryModalLabel">Preview CV: Joko Susilo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <small class="text-muted">Jika file PDF, pratinjau akan ditampilkan di bawah.</small>
                        <?php echo "<pre>";
                        print_r($application["assessor_summary"]);
                        echo "</pre>"; ?>
                    </div>
                    <div class="border rounded bg-light p-2">
                        <iframe id="cvPreviewIframe" src="" style="width:100%;height:70vh;border:0" aria-label="CV Preview"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewSummaryModal" tabindex="-1" aria-labelledby="viewSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="viewSummaryModalLabel">Assessment Summary: <?= htmlspecialchars($application['nama_lengkap']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <?php if (!empty($application['assessor_summary'])): ?>
                        <?php $application['assessor_summary'] = json_decode($application['assessor_summary'], true); ?>

                        <!-- Executive Summary -->
                        <?php if (!empty($application['assessor_summary']['executive_summary'])): ?>
                            <div class="card mb-4 border-1">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 small"><i class="bi bi-clipboard-data me-2"></i>Executive Summary</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0"><?= nl2br(htmlspecialchars($application['assessor_summary']['executive_summary'])) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <!-- Recruiter Insight -->
                            <?php if (!empty($application['assessor_summary']['recruiter_insight'])): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 border-1">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 small"><i class="bi bi-person-check me-2"></i>Recruiter Insight</h6>
                                        </div>
                                        <div class="card-body">
                                            <?php $insight = $application['assessor_summary']['recruiter_insight']; ?>

                                            <!-- Final Verdict (simplified) -->
                                            <?php if (!empty($insight['final_verdict'])): ?>
                                                <?php
                                                $verdict = strtolower($insight['final_verdict']);
                                                // neutral badge with subtle contextual class
                                                $ctxClass = 'bg-secondary text-white';
                                                if (in_array($verdict, ['hire', 'accept'])) $ctxClass = 'bg-success text-white';
                                                elseif (in_array($verdict, ['consideration', 'consider'])) $ctxClass = 'bg-warning text-dark';
                                                elseif (in_array($verdict, ['reject', 'skip'])) $ctxClass = 'bg-danger text-white';
                                                ?>
                                                <div class="mb-3 text-center">
                                                    <span class="badge <?= $ctxClass ?> px-3 py-2">
                                                        <i class="bi bi-circle-fill me-1" style="opacity:.85;font-size:.6rem"></i>
                                                        <?= strtoupper(htmlspecialchars($insight['final_verdict'])) ?>
                                                    </span>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Reasons to Hire / Skip (compact list) -->
                                            <?php if (!empty($insight['reasons_to_hire']) && is_array($insight['reasons_to_hire'])): ?>
                                                <div class="mb-3">
                                                    <h6 class="mb-2 small text-muted">Reasons to Hire</h6>
                                                    <ul class="ps-3 mb-0 small">
                                                        <?php foreach ($insight['reasons_to_hire'] as $reason): ?>
                                                            <li><?= htmlspecialchars($reason) ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($insight['reasons_to_skip']) && is_array($insight['reasons_to_skip'])): ?>
                                                <div class="mb-0">
                                                    <h6 class="mb-2 small text-muted">Reasons to Skip</h6>
                                                    <ul class="ps-3 mb-0 small">
                                                        <?php foreach ($insight['reasons_to_skip'] as $reason): ?>
                                                            <li><?= htmlspecialchars($reason) ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Top Projects -->
                            <?php if (!empty($application['assessor_summary']['top_projects']) && is_array($application['assessor_summary']['top_projects'])): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 border-1">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 small"><i class="bi bi-star me-2"></i>Top Projects</h6>
                                        </div>
                                        <div class="card-body">
                                            <?php foreach ($application['assessor_summary']['top_projects'] as $index => $project): ?>
                                                <div class="mb-3 p-3 border rounded" style="background: #fbfbfb;">
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <span class="badge bg-secondary rounded-pill"><?= $index + 1 ?></span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="mb-1 small"><?= htmlspecialchars($project['name'] ?? 'Untitled') ?></h6>
                                                            </div>
                                                            <p class="mb-2 small text-muted"><?= htmlspecialchars($project['description'] ?? '') ?></p>

                                                            <?php if (!empty($project['tech_stack']) && is_array($project['tech_stack'])): ?>
                                                                <div class="small text-muted">
                                                                    <?php foreach ($project['tech_stack'] as $tech): ?>
                                                                        <span class="me-1 small"><?= htmlspecialchars($tech) ?></span>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                            <?php if (empty($application['assessor_summary']['top_projects'])): ?>
                                                <div class="text-center text-muted py-3 small">
                                                    <i class="bi bi-folder2-open" style="font-size: 1.6rem;"></i>
                                                    <div class="mt-2">No notable projects found</div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-exclamation-triangle text-muted" style="font-size: 2rem;"></i>
                            <h6 class="mt-3">No Assessment Data Available</h6>
                            <p class="text-muted small">The assessment summary has not been generated yet or is not available.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/applications/detail.js"></script>

</body>

</html>