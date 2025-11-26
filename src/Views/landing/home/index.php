<?php
$page_css = "landing/home/index.css";
$page_js = "landing/home/index.js";
include_once __DIR__ . "/../../layouts/header.php";
?>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate-fadeInUp">
                <div class="hero-badge">Politeknik Negeri Malang</div>
                <h1>
                    <span class="line-1">Custom</span>
                    <span class="line-2">Character</span>
                    <span class="line-3">Software Engineering</span>
                </h1>
                <p>
                    Grab your very own software engineering expertise and start creating innovative solutions right now! FUN, FAST and EASY to work with, your projects will be delivered fully prepared and 100% ready to launch.
                </p>
                <div class="hero-buttons">
                    <a href="#about" class="btn btn-hero-primary">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="/assets/img/mascot-hero.png" alt="SE Lab Mascot">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Navigation Dots -->
    <div class="hero-nav-dots">
        <div class="dot active" data-target="hero"></div>
        <div class="dot" data-target="stats"></div>
        <div class="dot" data-target="about"></div>
        <div class="dot" data-target="services"></div>
        <div class="dot" data-target="research"></div>
        <div class="dot" data-target="join"></div>
    </div>
    
    <!-- Social Links -->
    <div class="hero-social-links">
        <span class="service-by">Follow Us</span>
        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section" id="stats">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-number" data-target="500">0</div>
                    <div class="stat-label">Students</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                    </div>
                    <div class="stat-number" data-target="50">0</div>
                    <div class="stat-label">Projects</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>
                    <div class="stat-number" data-target="25">0</div>
                    <div class="stat-label">Researchers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div class="stat-number" data-target="100">0</div>
                    <div class="stat-label">Publications</div>
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
                Pusat keunggulan dalam penelitian dan pengembangan perangkat lunak dengan fokus pada inovasi teknologi, metodologi modern, dan pelatihan software engineer profesional.
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
                Berbagai program dan layanan untuk mendukung pengembangan kompetensi dan karir di bidang software engineering.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h3>Praktikum & Training</h3>
                    <p>Program praktikum dan pelatihan intensif dengan teknologi terkini untuk mempersiapkan mahasiswa menghadapi industri.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3>Research & Development</h3>
                    <p>Melakukan riset dan pengembangan dalam berbagai bidang software engineering untuk menghasilkan inovasi teknologi.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h3>Industry Collaboration</h3>
                    <p>Kerjasama dengan industri untuk proyek nyata dan peluang magang bagi mahasiswa di perusahaan teknologi terkemuka.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-journal-code"></i>
                    </div>
                    <h3>Publications</h3>
                    <p>Mendorong publikasi ilmiah di jurnal dan konferensi internasional untuk berkontribusi pada komunitas akademik global.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <h3>Workshops & Seminars</h3>
                    <p>Menyelenggarakan workshop dan seminar dengan expert dari industri dan akademisi untuk pengembangan kompetensi.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h3>Consulting Services</h3>
                    <p>Layanan konsultasi pengembangan perangkat lunak untuk membantu organisasi mencapai tujuan teknologi mereka.</p>
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
                Fokus penelitian yang kami kembangkan untuk menghasilkan inovasi dan kontribusi nyata bagi industri dan masyarakat.
            </p>
        </div>
        <div class="research-grid">
            <div class="research-card">
                <h4>
                    <i class="bi bi-cpu"></i>
                    Artificial Intelligence & Machine Learning
                </h4>
                <p>Pengembangan sistem cerdas dan algoritma machine learning untuk berbagai aplikasi industri dan penelitian.</p>
            </div>
            <div class="research-card">
                <h4>
                    <i class="bi bi-cloud"></i>
                    Cloud Computing & DevOps
                </h4>
                <p>Riset dalam arsitektur cloud, containerization, dan praktik DevOps modern untuk pengembangan aplikasi yang scalable.</p>
            </div>
            <div class="research-card">
                <h4>
                    <i class="bi bi-phone"></i>
                    Mobile Application Development
                </h4>
                <p>Pengembangan aplikasi mobile cross-platform dengan fokus pada user experience dan performance optimization.</p>
            </div>
            <div class="research-card">
                <h4>
                    <i class="bi bi-shield-check"></i>
                    Software Security & Testing
                </h4>
                <p>Penelitian dalam keamanan perangkat lunak, testing automation, dan quality assurance methodologies.</p>
            </div>
            <div class="research-card">
                <h4>
                    <i class="bi bi-bar-chart"></i>
                    Data Science & Analytics
                </h4>
                <p>Analisis data besar, visualisasi data, dan pengembangan sistem business intelligence yang powerful.</p>
            </div>
            <div class="research-card">
                <h4>
                    <i class="bi bi-globe"></i>
                    Web Technologies
                </h4>
                <p>Riset dalam framework web modern, progressive web apps, dan teknologi web terkini untuk aplikasi enterprise.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" id="join">
    <div class="cta-content">
        <div class="container">
            <h2>Bergabunglah dengan Tim Kami</h2>
            <p>
                Jadilah bagian dari komunitas software engineering yang inovatif dan berkembang. Mari bersama-sama menciptakan solusi teknologi untuk masa depan yang lebih baik.
            </p>
            <a href="#" class="btn-cta">Apply Now <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . "/../../layouts/footer.php";
?>