<?php
$page_css = "landing/personil/detail.css";
$page_js = "";
include_once __DIR__ . "/../../layouts/header.php";
?>

<section class="personil-detail-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <?php if (!empty($data["personil"]["foto_url"])): ?>
                    <img src="<?php echo htmlspecialchars($data["personil"]["foto_url"]); ?>" 
                         alt="<?php echo htmlspecialchars($data["personil"]["nama_lengkap"]); ?>"
                         class="personil-photo img-fluid rounded-circle">
                <?php else: ?>
                    <div class="personil-avatar-large">
                        <?php
                        $nama = trim($data["personil"]["nama_lengkap"]);
                        $kata = explode(" ", $nama);
                        $inisial = "";
                        foreach ($kata as $k) {
                            $inisial .= strtoupper(substr($k, 0, 1));
                            if (strlen($inisial) >= 2) {
                                break;
                            }
                        }
                        echo htmlspecialchars($inisial);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-8">
                <div class="personil-info">
                    <div class="personil-meta mb-3">
                        <span class="badge bg-secondary">
                            <?php echo htmlspecialchars($data["personil"]["role"] === "dosen" ? "Dosen Pembimbing" : "Talent & Geeks"); ?>
                        </span>
                    </div>
                    <h1 class="personil-name"><?php echo htmlspecialchars($data["personil"]["nama_lengkap"]); ?></h1>
                    <p class="personil-role"><?php echo htmlspecialchars($data["personil"]["spesialisasi"] ?? "-"); ?></p>
                    <?php if (!empty($data["personil"]["bio"])): ?>
                        <p class="personil-bio"><?php echo htmlspecialchars($data["personil"]["bio"]); ?></p>
                    <?php endif; ?>
                    
                    <div class="personil-contact mt-4">
                        <?php if (!empty($data["personil"]["email"])): ?>
                            <div class="contact-item">
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:<?php echo htmlspecialchars($data["personil"]["email"]); ?>">
                                    <?php echo htmlspecialchars($data["personil"]["email"]); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($data["personil"]["no_hp"])): ?>
                            <div class="contact-item">
                                <i class="bi bi-phone"></i>
                                <a href="tel:<?php echo htmlspecialchars($data["personil"]["no_hp"]); ?>">
                                    <?php echo htmlspecialchars($data["personil"]["no_hp"]); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="personil-skills">
    <div class="container">
        <h2 class="section-title">Skills & Expertise</h2>
        <?php if (!empty($data["personil"]["skills"]) && is_array($data["personil"]["skills"])): ?>
            <div class="skills-list">
                <?php foreach ($data["personil"]["skills"] as $skill): ?>
                    <span class="skill-badge"><?php echo htmlspecialchars($skill); ?></span>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted text-center">Belum ada data skills yang tersedia.</p>
        <?php endif; ?>
    </div>
</section>

<section class="personil-projects">
    <div class="container">
        <h2 class="section-title">Projects</h2>
        <?php if (!empty($data["personil"]["projects"]) && is_array($data["personil"]["projects"])): ?>
            <div class="row g-4">
                <?php foreach ($data["personil"]["projects"] as $project): ?>
                    <div class="col-lg-6">
                        <div class="project-card">
                            <h3 class="project-title"><?php echo htmlspecialchars($project["title"]); ?></h3>
                            <p class="project-description"><?php echo htmlspecialchars($project["description"] ?? "-"); ?></p>
                            <?php if (!empty($project["link_project"])): ?>
                                <a href="<?php echo htmlspecialchars($project["link_project"]); ?>" 
                                   class="project-link" 
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    View Project <i class="bi bi-arrow-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted text-center">Belum ada data projects yang tersedia.</p>
        <?php endif; ?>
    </div>
</section>

<section class="back-section">
    <div class="container text-center">
        <a href="/personil-list" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Tim Kami
        </a>
    </div>
</section>

<?php include_once __DIR__ . "/../../layouts/footer.php"; ?>
