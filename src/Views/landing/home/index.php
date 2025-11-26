<?php
$page_css = "landing/home/index.css";
$page_js = "landing/home/index.js";
include_once __DIR__ . "/../../layouts/header.php";
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 animate-fadeInUp">
                <div class="section-subtitle">Welcome to</div>
                <h1>
                    Software Engineering
                    <span class="gold-text">Laboratory</span>
                </h1>
                <p>
                    Mengembangkan inovasi teknologi dan membangun solusi
                    perangkat lunak berkualitas tinggi untuk masa depan
                    yang lebih baik.
                </p>
                <div class="hero-buttons">
                    <a href="#about" class="btn btn-primary-custom"
                        >Explore More</a
                    >
                    <a href="join.html" class="btn btn-outline-custom"
                        >Join Our Team</a
                    >
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="section-subtitle">About Us</div>
                <h2 class="section-title">
                    Laboratorium Software Engineering
                </h2>
                <p
                    class="mt-4"
                    style="
                        line-height: 1.8;
                        color: #6c757d;
                        font-size: 1.1rem;
                    "
                >
                    Software Engineering Laboratory adalah pusat
                    keunggulan dalam penelitian dan pengembangan
                    perangkat lunak. Kami berfokus pada inovasi
                    teknologi, metodologi pengembangan perangkat lunak
                    modern, dan pelatihan mahasiswa untuk menjadi
                    software engineer profesional yang kompeten.
                </p>
                <p
                    style="
                        line-height: 1.8;
                        color: #6c757d;
                        font-size: 1.1rem;
                    "
                >
                    Dengan fasilitas modern dan tim pengajar
                    berpengalaman, kami berkomitmen untuk menghasilkan
                    lulusan yang mampu bersaing di industri teknologi
                    global dan memberikan kontribusi signifikan bagi
                    perkembangan teknologi informasi di Indonesia.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <h5>Modern Technology</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h5>Expert Team</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                            <h5>Innovation</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <h5>Excellence</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-target="500">0</div>
                    <div class="stat-label">Students</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-target="50">0</div>
                    <div class="stat-label">Projects</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-target="25">0</div>
                    <div class="stat-label">Researchers</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-target="100">0</div>
                    <div class="stat-label">Publications</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-subtitle">Our Services</div>
            <h2 class="section-title">Apa yang Kami Tawarkan</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h3>Praktikum & Training</h3>
                    <p>
                        Program praktikum dan pelatihan intensif dengan
                        teknologi terkini untuk mempersiapkan mahasiswa
                        menghadapi industri.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3>Research & Development</h3>
                    <p>
                        Melakukan riset dan pengembangan dalam berbagai
                        bidang software engineering untuk menghasilkan
                        inovasi teknologi.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h3>Industry Collaboration</h3>
                    <p>
                        Kerjasama dengan industri untuk proyek nyata dan
                        peluang magang bagi mahasiswa di perusahaan
                        teknologi terkemuka.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-journal-code"></i>
                    </div>
                    <h3>Publications</h3>
                    <p>
                        Mendorong publikasi ilmiah di jurnal dan
                        konferensi internasional untuk berkontribusi
                        pada komunitas akademik global.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <h3>Workshops & Seminars</h3>
                    <p>
                        Menyelenggarakan workshop dan seminar dengan
                        expert dari industri dan akademisi untuk
                        pengembangan kompetensi.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h3>Consulting Services</h3>
                    <p>
                        Layanan konsultasi pengembangan perangkat lunak
                        untuk membantu organisasi mencapai tujuan
                        teknologi mereka.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Research Areas -->
<section class="research-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-subtitle">Research Focus</div>
            <h2 class="section-title">Area Penelitian Kami</h2>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="research-card">
                    <h4>
                        <i
                            class="bi bi-cpu me-2"
                            style="color: var(--gold)"
                        ></i>
                        Artificial Intelligence & Machine Learning
                    </h4>
                    <p>
                        Pengembangan sistem cerdas dan algoritma machine
                        learning untuk berbagai aplikasi industri dan
                        penelitian.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="research-card">
                    <h4>
                        <i
                            class="bi bi-cloud me-2"
                            style="color: var(--gold)"
                        ></i>
                        Cloud Computing & DevOps
                    </h4>
                    <p>
                        Riset dalam arsitektur cloud, containerization,
                        dan praktik DevOps modern untuk pengembangan
                        aplikasi yang scalable.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="research-card">
                    <h4>
                        <i
                            class="bi bi-phone me-2"
                            style="color: var(--gold)"
                        ></i>
                        Mobile Application Development
                    </h4>
                    <p>
                        Pengembangan aplikasi mobile cross-platform
                        dengan fokus pada user experience dan
                        performance optimization.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="research-card">
                    <h4>
                        <i
                            class="bi bi-shield-check me-2"
                            style="color: var(--gold)"
                        ></i>
                        Software Security & Testing
                    </h4>
                    <p>
                        Penelitian dalam keamanan perangkat lunak,
                        testing automation, dan quality assurance
                        methodologies.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="research-card">
                    <h4>
                        <i
                            class="bi bi-bar-chart me-2"
                            style="color: var(--gold)"
                        ></i>
                        Data Science & Analytics
                    </h4>
                    <p>
                        Analisis data besar, visualisasi data, dan
                        pengembangan sistem business intelligence yang
                        powerful.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="research-card">
                    <h4>
                        <i
                            class="bi bi-globe me-2"
                            style="color: var(--gold)"
                        ></i>
                        Web Technologies
                    </h4>
                    <p>
                        Riset dalam framework web modern, progressive
                        web apps, dan teknologi web terkini untuk
                        aplikasi enterprise.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Bergabunglah dengan Tim Kami</h2>
        <p>
            Jadilah bagian dari komunitas software engineering yang
            inovatif dan berkembang. Mari bersama-sama menciptakan
            solusi teknologi untuk masa depan yang lebih baik.
        </p>
        <a href="join.html" class="btn btn-cta">Apply Now</a>
    </div>
</section>

<?php __DIR__ . "/../../layouts/footer.php";
?>
