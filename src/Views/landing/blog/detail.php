<?php
$page_css = "landing/blog/detail.css";
$page_js = "";
include_once __DIR__ . "/../../layouts/header.php";
?>

<!-- Blog Detail Hero -->
<section class="blog-detail-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="blog-meta mb-3">
                    <span
                        class="badge bg-gold"><?= htmlspecialchars($blog['kategori_nama'] ?? 'Uncategorized') ?></span>
                    <span class="meta-divider">•</span>
                    <span><i class="bi bi-calendar3"></i>
                        <?= date('d M Y', strtotime($blog['tanggal_publish'] ?? $blog['created_at'])) ?></span>
                    <span class="meta-divider">•</span>
                    <span><i class="bi bi-clock"></i> <?= $blog['reading_time'] ?? 5 ?> min read</span>
                </div>
                <h1 class="blog-title"><?= htmlspecialchars($blog['judul']) ?></h1>
                <div class="author-info">
                    <div class="author-avatar">
                        <?= strtoupper(substr($blog['penulis_nama'], 0, 1)) ?>
                    </div>
                    <div class="author-details">
                        <div class="author-name"><?= htmlspecialchars($blog['penulis_nama']) ?></div>
                        <div class="author-bio"><?= htmlspecialchars($blog['penulis_bio']) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="blog-content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if (!empty($blog['featured_image_url'])): ?>
                    <div class="featured-image">
                        <img src="<?= htmlspecialchars($blog['featured_image_url']) ?>"
                            alt="<?= htmlspecialchars($blog['judul']) ?>" class="img-fluid">
                    </div>
                <?php endif; ?>

                <div class="blog-content">
                    <!-- Output raw HTML from Summernote. Ensure content is sanitized in backend! -->
                    <?= $blog['konten'] ?>
                </div>

                <div class="blog-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="share-section">
                            <span class="me-3">Share:</span>
                            <a href="#" class="share-btn"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="share-btn"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="share-btn"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="share-btn"><i class="bi bi-link-45deg"></i></a>
                        </div>
                        <a href="/blog" class="btn btn-outline-custom">
                            <i class="bi bi-arrow-left"></i> Kembali ke Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . "/../../layouts/footer.php"; ?>