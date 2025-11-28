<?php
$page_css = "landing/home/index.css";
$page_js = "landing/home/index.js";
include_once __DIR__ . "/../../layouts/header.php";
?>

<!-- Hero Section -->
<section class="hero-section">

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate-fadeInUp">
                <div class="hero-badge">Politeknik Negeri Malang</div>
                <h1>
                    <span class="line-1">Bangun</span>
                    <span class="line-2">Teknologi</span>
                    <span class="line-3">untuk Dunia yang Terus Bergerak</span>
                </h1>
                <p>
                    Selamat datang di SE Laboratory! Tempat di mana ide-liar kamu bertemu teknologi, dibentuk, dan diwujudkan menjadi solusi nyata.
                </p>

                <div class="hero-buttons">
                    <a href="#about" class="btn btn-hero-primary">Lets Explore</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="/assets/img/mascot-hero.png" alt="SE Lab Mascot">
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-number" data-target="<?= isset($studentsCount) ? (int)$studentsCount : 0 ?>">0</div>
                    <div class="stat-label">Students</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                    </div>
                    <div class="stat-number" data-target="<?= isset($projectsCount) ? (int)$projectsCount : 0 ?>">0</div>
                    <div class="stat-label">Projects</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>
                    <div class="stat-number" data-target="<?= isset($researchersCount) ? (int)$researchersCount : 0 ?>">0</div>
                    <div class="stat-label">Researchers</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">About Us</div>
            <h2 class="section-title">Laboratorium Software Engineering</h2>
            <p class="section-description">
                Pusat keunggulan dalam penelitian dan pengembangan perangkat lunak dengan fokus pada inovasi teknologi,
                metodologi modern, dan pelatihan software engineer profesional.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="bi bi-code-slash"></i>
                    </div>
                    <h3>Modern Technology</h3>
                    <p>Menggunakan teknologi dan tools terkini dalam pengembangan software.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>Expert Team</h3>
                    <p>Tim pengajar dan peneliti berpengalaman di industri teknologi.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h3>Innovation Focus</h3>
                    <p>Mendorong inovasi dan kreativitas dalam setiap project.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h3>Excellence</h3>
                    <p>Berkomitmen pada standar kualitas dan keunggulan tertinggi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" id="services">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Our Services</div>
            <h2 class="section-title" style="color: var(--dusk-blue);">Apa yang Kami Tawarkan</h2>
            <p class="section-description">
                Berbagai program dan layanan untuk mendukung pengembangan kompetensi dan karir di bidang software
                engineering.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h3>Praktikum & Training</h3>
                    <p>Program praktikum dan pelatihan intensif dengan teknologi terkini untuk mempersiapkan mahasiswa
                        menghadapi industri.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3>Research & Development</h3>
                    <p>Melakukan riset dan pengembangan dalam berbagai bidang software engineering untuk menghasilkan
                        inovasi teknologi.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h3>Industry Collaboration</h3>
                    <p>Kerjasama dengan industri untuk proyek nyata dan peluang magang bagi mahasiswa di perusahaan
                        teknologi terkemuka.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Research Section -->
<section class="research-section" id="research">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Research Focus</div>
            <h2 class="section-title">Area Penelitian Kami</h2>
            <p class="section-description">
                Fokus penelitian yang kami kembangkan untuk menghasilkan inovasi dan kontribusi nyata bagi industri dan
                masyarakat.
            </p>
        </div>
        <div class="research-grid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <div class="research-card">
                        <h4>
                            <i class="bi bi-folder"></i>
                            <?= htmlspecialchars($cat['name']) ?>
                        </h4>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted py-4">Belum ada kategori blog.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" id="join">
    <div class="cta-content">
        <div class="container">
            <h2>Bergabunglah dengan Tim Kami</h2>
            <p>
                Jadilah bagian dari komunitas software engineering yang inovatif dan berkembang. Mari bersama-sama
                menciptakan solusi teknologi untuk masa depan yang lebih baik.
            </p>
            <a href="/join" class="btn-cta">Apply Now <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . "/../../layouts/footer.php";
?>