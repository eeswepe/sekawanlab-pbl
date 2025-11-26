<?php
// views/layouts/footer.php
?>
<footer class="footer">
    <div class="container footer-grid">
        <div>
            <h3>SE Laboratory</h3>
            <p>
                Laboratorium Rekayasa Perangkat Lunak yang berfokus pada pengembangan solusi
                perangkat lunak modern berbasis riset dan kolaborasi.
            </p>
        </div>
        <div>
            <h4>Kontak</h4>
            <ul>
                <li>Email: selab@example.ac.id</li>
                <li>Lokasi: Gedung Laboratorium, Fakultas Teknologi Informasi</li>
            </ul>
        </div>
        <div>
            <h4>Link Cepat</h4>
            <ul>
                <li><a href="/index.php?page=profil">Profil Lab</a></li>
                <li><a href="/index.php?page=kegiatan">Kegiatan</a></li>
                <li><a href="/index.php?page=join">Bergabung</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        © <?= date('Y'); ?> SE Laboratory. All rights reserved.
    </div>
</footer>

<script src="/public/assets/js/main.js"></script>
</body>
</html>
