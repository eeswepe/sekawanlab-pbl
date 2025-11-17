<?php
$page_css = "landing/join/application.css";
$page_js = "landing/join/application.js";
include_once __DIR__ . "/../../layouts/header.php";
?>

<section class="page-header">
 <div class="container">
  <h1>
   Bergabung Bersama Kami
  </h1>
  <p>
   Jadilah bagian dari komunitas software engineering yang inovatif dan berkembang di Software Engineering Laboratory
  </p>
 </div>
</section>
<!-- Form Section -->
<section class="form-section">
 <div class="container">
  <div class="form-wrapper">
   <!-- Info Box -->
   <div class="info-box d-flex align-items-start">
    <i class="bi bi-info-circle-fill">
    </i>
    <div class="info-box-content">
     <h5>
      Persyaratan Pendaftaran
     </h5>
     <p>
      Pastikan Anda mengisi semua data dengan benar dan lengkap. Setelah submit, tim kami akan meninjau aplikasi Anda dan menghubungi melalui email atau WhatsApp dalam 3-5 hari kerja.
     </p>
    </div>
   </div>
   <!-- Form Container -->
   <div class="form-container">
    <form action="#" enctype="multipart/form-data" id="joinForm" method="POST">
     <!-- Data Pribadi Section -->
     <h3 class="section-title">
      Data Pribadi
     </h3>
     <div class="row">
      <div class="col-md-12 mb-3">
       <label class="form-label" for="namaLengkap">
        Nama Lengkap
        <span class="required">
         *
        </span>
       </label>
       <input class="form-control" id="namaLengkap" name="namaLengkap" placeholder="Masukkan nama lengkap Anda" required="" type="text"/>
      </div>
     </div>
     <div class="row">
      <div class="col-md-6 mb-3">
       <label class="form-label" for="email">
        Email
        <span class="required">
         *
        </span>
       </label>
       <input class="form-control" id="email" name="email" placeholder="contoh@email.com" required="" type="email"/>
      </div>
      <div class="col-md-6 mb-3">
       <label class="form-label" for="telepon">
        No. Telepon/WhatsApp
        <span class="required">
         *
        </span>
       </label>
       <input class="form-control" id="telepon" name="telepon" placeholder="08xxxxxxxxxx" required="" type="tel"/>
      </div>
     </div>
     <div class="row">
      <div class="col-md-12 mb-3">
       <label class="form-label" for="nim">
        NIM (Nomor Induk Mahasiswa)
        <span class="required">
         *
        </span>
       </label>
       <input class="form-control" id="nim" name="nim" placeholder="Masukkan NIM Anda" required="" type="text"/>
      </div>
     </div>
     <hr class="section-divider"/>
     <!-- Data Akademik Section -->
     <h3 class="section-title">
      Data Akademik
     </h3>
     <div class="row">
      <div class="col-md-6 mb-3">
       <label class="form-label" for="prodi">
        Program Studi
        <span class="required">
         *
        </span>
       </label>
       <select class="form-select" id="prodi" name="prodi" required="">
        <option disabled="" selected="" value="">
         Pilih Program Studi
        </option>
        <option value="TI">
         Teknik Informatika (TI)
        </option>
        <option value="SIB">
         Sistem Informasi Bisnis (SIB)
        </option>
        <option value="PPLS">
        Pengembangan Perangkat Lunak (PPLS)
        </option>
       </select>
      </div>
      <div class="col-md-6 mb-3">
       <label class="form-label" for="semester">
        Semester
        <span class="required">
         *
        </span>
       </label>
       <select class="form-select" id="semester" name="semester" required="">
        <option disabled="" selected="" value="">
         Pilih Semester
        </option>
        <option value="1">
         Semester 1
        </option>
        <option value="2">
         Semester 2
        </option>
        <option value="3">
         Semester 3
        </option>
        <option value="4">
         Semester 4
        </option>
        <option value="5">
         Semester 5
        </option>
        <option value="6">
         Semester 6
        </option>
        <option value="7">
         Semester 7
        </option>
        <option value="8">
         Semester 8
        </option>
       </select>
      </div>
     </div>
     <hr class="section-divider"/>
     <!-- Motivasi & Portfolio Section -->
     <h3 class="section-title">
      Motivasi &amp; Portfolio
     </h3>
     <div class="mb-3">
      <label class="form-label" for="alasan">
       Alasan Bergabung
       <span class="required">
        *
       </span>
      </label>
      <textarea class="form-control" id="alasan" name="alasan" placeholder="Ceritakan mengapa Anda tertarik bergabung dengan Software Engineering Laboratory dan apa yang ingin Anda capai..." required="" rows="5"></textarea>
     </div>
     <div class="mb-3">
      <label class="form-label" for="github">
       Link Github
       <span class="required">
        *
       </span>
      </label>
      <input class="form-control" id="github" name="github" placeholder="https://github.com/username" required="" type="url"/>
      <small class="text-muted">
       Pastikan profile Github Anda dapat diakses secara public
      </small>
     </div>
     <hr class="section-divider"/>
     <!-- Upload CV Section -->
     <h3 class="section-title">
      Dokumen Pendukung
     </h3>
     <div class="mb-3">
      <label class="form-label">
       Upload CV/Resume
       <span class="required">
        *
       </span>
      </label>
      <div class="file-upload-wrapper">
       <input accept=".pdf" id="cv" name="cv" required="" type="file"/>
       <div class="file-upload-icon">
        <i class="bi bi-cloud-upload">
        </i>
       </div>
       <div class="file-upload-text">
        <strong>
         Klik untuk upload
        </strong>
        atau drag and drop
        <br/>
        <small>
         PDF (Max. 5MB)
        </small>
       </div>
       <div class="file-name" id="fileName">
        <i class="bi bi-file-earmark-pdf">
        </i>
        <span id="fileNameText">
        </span>
       </div>
      </div>
     </div>
     <!-- Submit Button -->
     <button class="btn-submit" type="submit">
      <i class="bi bi-send me-2">
      </i>
      Submit Pendaftaran
     </button>
    </form>
   </div>
  </div>
 </div>
</section>

<?php include_once __DIR__ . "/../../layouts/footer.php"; ?>
