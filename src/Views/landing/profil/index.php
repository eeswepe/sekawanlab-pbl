<?php
$page_css = "landing/profil/index.css";
// $page_js = "profil/tentang-kami.js";

include_once __DIR__ . "/../../layouts/header.php";
?>

<section class="page-header">
 <div class="container">
  <h1>
   <?php echo $data["profil"]["page_title"]; ?>
  </h1>
  <p>
   <?php echo $data["profil"]["page_subtitle"]; ?>
  </p>
 </div>
</section>
<!-- Content Section -->
<section class="content-section">
 <div class="container">
  <div class="content-wrapper">
   <div class="content-body">
    <!-- Featured Image -->
    <?php if (!empty($data["profil"]["featured_image_url"])): ?>
    <img src="<?= htmlspecialchars($data["profil"]["featured_image_url"]) ?>" alt="<?= htmlspecialchars($data["profil"]["page_title"]) ?>" class="featured-image" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 2rem;">
    <?php endif; ?>
    <!-- Content Title -->
    <h1 class="content-title">
    <?php echo $data["profil"]["content_title"]; ?>
    </h1>
    <!-- Content Text -->
    <div class="content-text">
        <p>
            <?php echo $data["profil"]["content_subtitle"]; ?>
        </p>
    </div>
   </div>
  </div>
 </div>
</section>

<?php include_once __DIR__ . "/../../layouts/footer.php";
?>
