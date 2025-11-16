<?php
$page_css = "blog.css";
$page_js = "blog.js";
include_once __DIR__ . "/../../layouts/header.php";

// Pagination settings
$perPage = 2; // 2 artikel per halaman untuk testing
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Hitung total blogs dan total pages
$totalBlogs = !empty($data['blogs']) ? count($data['blogs']) : 0;
$totalPages = ceil($totalBlogs / $perPage);

// Pastikan current page tidak melebihi total pages
if ($currentPage > $totalPages && $totalPages > 0) {
    $currentPage = $totalPages;
}

// Hitung offset
$offset = ($currentPage - 1) * $perPage;

// Slice array blogs untuk halaman saat ini
$blogsToShow = !empty($data['blogs']) ? array_slice($data['blogs'], $offset, $perPage) : [];
?>
<section class="page-header">
    <div class="container">
        <h1>Blog &amp; Insights</h1>
        <p>
            Artikel, tutorial, dan insight terbaru seputar software engineering
            dan teknologi
        </p>
    </div>
</section>
<!-- Blog Section -->
<section class="blog-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Search Box -->
                <div class="search-box">
                    <input placeholder="Cari artikel..." type="text" />
                    <button>
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                
                <!-- Blog Posts -->
                <div class="row g-4">
                    <?php if (!empty($blogsToShow)): ?>
                        <?php
                        // optional: kalau kamu juga mengirim map kategori id->nama, pakai itu.
                        $kategoriMap = $data['kategori_map'] ?? [];
                        foreach ($blogsToShow as $post):
                            $slug  = htmlspecialchars($post['slug']);
                            $title = htmlspecialchars($post['judul']);
                            $author = htmlspecialchars($post['penulis_nama']);
                            $dateRaw = $post['tanggal_publish'] ?? $post['created_at'] ?? null;
                            $dateFmt = $dateRaw ? date('d F Y', strtotime($dateRaw)) : '';
                            $img = !empty($post['featured_image_url']) ? htmlspecialchars($post['featured_image_url']) : null;
                            $excerpt = !empty($post['cuplikan']) ? $post['cuplikan'] : (strlen($post['konten']) > 200 ? substr($post['konten'], 0, 200) . '...' : $post['konten']);
                            $excerpt = htmlspecialchars($excerpt);
                            $kategoriNama = isset($kategoriMap[$post['kategori_id']]) ? htmlspecialchars($kategoriMap[$post['kategori_id']]) : ('Kategori ' . (int)$post['kategori_id']);
                            // set url sesuai routing: /blog/{slug} atau blog-detail.php?id={id}
                            $postUrl = '/blog/' . $slug; // ubah jika perlu
                        ?>
                            <div class="col-md-6">
                                <div class="blog-card">
                                    <div class="blog-image">
                                        <?php if ($img): ?>
                                            <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                                        <?php else: ?>
                                            <div class="blog-image-placeholder">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div class="blog-category">
                                            <?php echo $kategoriNama; ?>
                                        </div>
                                    </div>

                                    <div class="blog-content">
                                        <div class="blog-meta">
                                            <div class="blog-meta-item">
                                                <i class="bi bi-calendar"></i>
                                                <span><?php echo $dateFmt; ?></span>
                                            </div>
                                            <div class="blog-meta-item">
                                                <i class="bi bi-person"></i>
                                                <span><?php echo $author; ?></span>
                                            </div>
                                        </div>

                                        <h3 class="blog-title">
                                            <a href="<?php echo $postUrl; ?>">
                                                <?php echo $title; ?>
                                            </a>
                                        </h3>

                                        <p class="blog-excerpt">
                                            <?php echo $excerpt; ?>
                                        </p>

                                        <a class="blog-read-more" href="<?php echo $postUrl; ?>">
                                            Baca Selengkapnya
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center text-muted">Belum ada artikel tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="pagination-wrapper">
                    <nav aria-label="Blog pagination">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" style="border-radius: 10px 0 0 10px;">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                            
                            <?php
                            // Tampilkan maksimal 5 halaman di pagination
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);
                            
                            // Tampilkan halaman pertama jika tidak di range
                            if ($startPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=1">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <!-- Halaman di range -->
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>" 
                                       <?php if ($i == $currentPage): ?>
                                       style="background: var(--gold); border-color: var(--gold);"
                                       <?php endif; ?>>
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <!-- Tampilkan halaman terakhir jika tidak di range -->
                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
                                </li>
                            <?php endif; ?>
                            
                            <!-- Next Button -->
                            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" style="border-radius: 0 10px 10px 0;">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                    <!-- Info halaman -->
                    <div class="text-center mt-3 text-muted">
                        <small>
                            Menampilkan <?php echo $offset + 1; ?> - <?php echo min($offset + $perPage, $totalBlogs); ?> dari <?php echo $totalBlogs; ?> artikel
                            (Halaman <?php echo $currentPage; ?> dari <?php echo $totalPages; ?>)
                        </small>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- Categories Widget -->
                    <div class="sidebar-widget">
                        <h4 class="widget-title">Kategori</h4>
                        <ul class="category-list">
                            <li>
                                <a href="#">
                                    <span>
                                        <i class="bi bi-folder"></i>
                                        Machine Learning
                                    </span>
                                    <span class="category-count">12</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>
                                        <i class="bi bi-folder"></i>
                                        Cloud Computing
                                    </span>
                                    <span class="category-count">8</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>
                                        <i class="bi bi-folder"></i>
                                        Mobile Development
                                    </span>
                                    <span class="category-count">15</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>
                                        <i class="bi bi-folder"></i>
                                        Security
                                    </span>
                                    <span class="category-count">10</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>
                                        <i class="bi bi-folder"></i>
                                        Data Science
                                    </span>
                                    <span class="category-count">18</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>
                                        <i class="bi bi-folder"></i>
                                        Web Development
                                    </span>
                                    <span class="category-count">22</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . "/../../layouts/footer.php"; ?>