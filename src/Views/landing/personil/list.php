<?php

$page_css = "landing/personil/list.css";
$page_js = "";
include_once __DIR__ . "/../../layouts/header.php";
?>
<section class="page-header">
 <div class="container">
  <h1>
   Tim Kami
  </h1>
  <p>
   Bertemu dengan para ahli dan talent berbakat di Software Engineering Laboratory
  </p>
 </div>
</section>
<!-- Dosen Pembimbing Section -->
<section class="personil-section">
    <div class="container">
        <div class="mb-5">
            <div class="section-subtitle">Leadership</div>
            <h2 class="section-title">Dosen Pembimbing</h2>
            <p class="text-muted mt-3">
                Tim dosen yang berpengalaman dan berdedikasi membimbing
                mahasiswa dalam penelitian dan pengembangan
            </p>
        </div>
        <div class="row g-4">
            <?php if (
                !empty($data["personils"]) &&
                is_array($data["personils"])
            ): ?>
                <?php foreach ($data["personils"] as $personil): ?>
                <?php if ($personil["role"] === "dosen"): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <a class="person-card" href="/personil/<?php echo htmlspecialchars(
                            $personil["id"],
                        ); ?>">
                            <div class="person-image">
                                <?php if (!empty($personil["foto_url"])): ?>
                                    <img src="<?php echo htmlspecialchars(
                                        $personil["foto_url"],
                                    ); ?>"
                                         alt="<?php echo htmlspecialchars(
                                             $personil["nama_lengkap"],
                                         ); ?>"
                                         class="img-fluid rounded-circle">
                                <?php else: ?>
                                    <div class="person-avatar">
                                        <?php
                                        $nama = trim($personil["nama_lengkap"]);
                                        $kata = explode(" ", $nama);
                                        $inisial = "";
                                        foreach ($kata as $k) {
                                            $inisial .= strtoupper(
                                                substr($k, 0, 1),
                                            );
                                            if (strlen($inisial) >= 2) {
                                                break;
                                            }
                                        }
                                        echo htmlspecialchars($inisial);
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <div class="view-detail-badge">
                                    View Profile
                                </div>
                            </div>

                            <div class="person-info">
                                <h3 class="person-name">
                                    <?php echo htmlspecialchars(
                                        $personil["nama_lengkap"],
                                    ); ?>
                                </h3>
                                <div class="person-role">
                                    <?php echo htmlspecialchars(
                                        $personil["spesialisasi"] ?? "-",
                                    ); ?>
                                </div>
                                <p class="person-specialization">
                                    <?php echo htmlspecialchars(
                                        $personil["bio"] ?? "-",
                                    ); ?>
                                </p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data personil yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Talent/Geeks Section -->
<section class="personil-section section-divider">
    <div class="container">
        <div class="mb-5">
            <div class="section-subtitle">Our Team</div>
            <h2 class="section-title">Talent &amp; Geeks</h2>
            <p class="text-muted mt-3">
                Mahasiswa berbakat yang aktif dalam penelitian dan
                pengembangan software engineering
            </p>
        </div>
        <div class="row g-4">
            <?php if (
                !empty($data["personils"]) &&
                is_array($data["personils"])
            ): ?>
                <?php foreach ($data["personils"] as $personil): ?>
                <?php if ($personil["role"] === "talent"): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <a class="person-card" href="/personil/<?php echo htmlspecialchars(
                            $personil["id"],
                        ); ?>">
                            <div class="person-image">
                                <?php if (!empty($personil["foto_url"])): ?>
                                    <img src="<?php echo htmlspecialchars(
                                        $personil["foto_url"],
                                    ); ?>"
                                         alt="<?php echo htmlspecialchars(
                                             $personil["nama_lengkap"],
                                         ); ?>"
                                         class="img-fluid rounded-circle">
                                <?php else: ?>
                                    <div class="person-avatar">
                                        <?php
                                        $nama = trim($personil["nama_lengkap"]);
                                        $kata = explode(" ", $nama);
                                        $inisial = "";
                                        foreach ($kata as $k) {
                                            $inisial .= strtoupper(
                                                substr($k, 0, 1),
                                            );
                                            if (strlen($inisial) >= 2) {
                                                break;
                                            }
                                        }
                                        echo htmlspecialchars($inisial);
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <div class="view-detail-badge">
                                    View Profile
                                </div>
                            </div>

                            <div class="person-info">
                                <h3 class="person-name">
                                    <?php echo htmlspecialchars(
                                        $personil["nama_lengkap"],
                                    ); ?>
                                </h3>
                                <div class="person-role">
                                    <?php echo htmlspecialchars(
                                        $personil["spesialisasi"] ?? "-",
                                    ); ?>
                                </div>
                                <p class="person-specialization">
                                    <?php echo htmlspecialchars(
                                        $personil["bio"] ?? "-",
                                    ); ?>
                                </p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data personil yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include_once __DIR__ . "/../../layouts/footer.php";
?>
