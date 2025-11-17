<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - SE Laboratory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/personil/profile/index.css">
</head>

<body>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="#">
                    <div class="logo-icon">SE</div>
                    <span>SE Laboratory</span>
                </a>
            </div>

            <ul class="sidebar-nav">
                <li><a href="/personil/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li><a href="/personil/profile"  class="active"><i class="bi bi-person-circle"></i> My Profile</a></li>
                <li><a href="/personil/blog"><i class="bi bi-journal-text"></i> My Blog Posts</a></li>
                <li><a href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
        </nav>
        <div id="main-content">
            <main class="content-fluid">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1>My Profile</h1>
                        <p>Kelola dan tinjau informasi profil Anda.</p>
                    </div>
                    <a href="/personil/profile/edit" class="btn btn-primary-custom d-none d-sm-inline-flex">
                        <i class="bi bi-pencil-square me-2"></i> Edit Profile
                    </a>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <img src="<?= htmlspecialchars($personil['foto_url'] ?? 'https://via.placeholder.com/150') ?>"
                                    alt="Profile Picture"
                                    class="rounded-circle mb-3"
                                    style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--gold);">

                                <h4 class="card-title mb-0"><?= htmlspecialchars($personil['nama_lengkap']) ?></h4>
                                <p class="text-muted mb-3"><?= htmlspecialchars($personil['role']) ?></p>

                                <a href="/personil-detail?id=<?= $personil['id'] ?>" target="_blank" class="btn btn-outline-secondary w-100 mb-3">
                                    <i class="bi bi-box-arrow-up-right me-2"></i> View Public Profile
                                </a>

                                <hr>

                                <div class="list-group list-group-flush text-start">
                                    <h6 class="text-start mt-2 mb-2 card-title">Contact Info</h6>
                                    <div class="list-group-item d-flex align-items-center border-0 p-2">
                                        <i class="bi bi-envelope-fill me-3" style="color: var(--gold); font-size: 1.1rem;"></i>
                                        <span class="text-muted"><?= htmlspecialchars($personil['email']) ?></span>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center border-0 p-2">
                                        <i class="bi bi-phone-fill me-3" style="color: var(--gold); font-size: 1.1rem;"></i>
                                        <span class="text-muted"><?= htmlspecialchars($personil['phone']) ?></span>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center border-0 p-2">
                                        <i class="bi bi-geo-alt-fill me-3" style="color: var(--gold); font-size: 1.1rem;"></i>
                                        <span class="text-muted"><?= htmlspecialchars($personil['location'] ?? 'N/A') ?></span>
                                    </div>
                                    <?php if (!empty($personil['tanggal_bergabung'])): ?>
                                        <div class="list-group-item d-flex align-items-center border-0 p-2">
                                            <i class="bi bi-calendar-fill me-3" style="color: var(--gold); font-size: 1.1rem;"></i>
                                            <span class="text-muted">Joined <?= date('F Y', strtotime($personil['tanggal_bergabung'])) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <hr>

                                <h6 class="text-start mt-2 mb-2 card-title">Social Media</h6>
                                <div class="d-flex justify-content-start gap-4">
                                    <?php
                                    // Decode social links if stored as JSON
                                    $socialLinks = !empty($personil['social_links']) ?
                                        json_decode($personil['social_links'], true) : [];
                                    ?>
                                    <?php if (!empty($socialLinks['github'])): ?>
                                        <a href="<?= htmlspecialchars($socialLinks['github']) ?>" target="_blank" class="social-link fs-4"><i class="bi bi-github"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($socialLinks['linkedin'])): ?>
                                        <a href="<?= htmlspecialchars($socialLinks['linkedin']) ?>" target="_blank" class="social-link fs-4"><i class="bi bi-linkedin"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($socialLinks['website'])): ?>
                                        <a href="<?= htmlspecialchars($socialLinks['website']) ?>" target="_blank" class="social-link fs-4"><i class="bi bi-globe"></i></a>
                                    <?php endif; ?>
                                    <?php if (empty($socialLinks)): ?>
                                        <span class="text-muted small">No social media links</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <?php if (!empty($personil['spesialisasi'])): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-star-fill me-2" style="color: var(--gold);"></i> Spesialisasi</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0"><?= nl2br(htmlspecialchars($personil['spesialisasi'])) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($personil['bio'])): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-info-circle-fill me-2" style="color: var(--gold);"></i> Bio</h5>
                                </div>
                                <div class="card-body">
                                    <p><?= nl2br(htmlspecialchars($personil['bio'])) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($personil['skills']) && count($personil['skills']) > 0): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-lightning-fill me-2" style="color: var(--gold);"></i> Skills</h5>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($personil['skills'] as $skill): ?>
                                        <span class="badge bg-secondary me-2 mb-2 py-2 px-3"><?= htmlspecialchars($skill) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($personil['projects']) && count($personil['projects']) > 0): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-folder-fill me-2" style="color: var(--gold);"></i> Projects</h5>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($personil['projects'] as $project): ?>
                                        <div class="mb-4 pb-3 <?= $project !== end($personil['projects']) ? 'border-bottom' : '' ?>">
                                            <h6 class="fw-bold"><?= htmlspecialchars($project['title']) ?></h6>
                                            <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="bi bi-folder-fill me-2" style="color: var(--gold);"></i> Projects</h5>
                                </div>
                                <div class="card-body text-center text-muted py-4">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                    No projects added yet.
                                </div>
                            </div>
                        <?php endif; ?>

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
    <script src="../../assets/js/personil_profile-view.js"></script>

</body>

</html>