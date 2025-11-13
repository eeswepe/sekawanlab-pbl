// Logika Sidebar Toggle (Diambil dari dashboard.html)
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

    function toggleSidebar() {
        sidebar.classList.toggle('toggled');
        mainContent.classList.toggle('toggled');
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    // Set default toggle state for mobile
    if (window.innerWidth < 992) {
        sidebar.classList.add('toggled');
        mainContent.classList.add('toggled');
    }
    
    // Resize listener untuk menyesuaikan tampilan desktop/mobile
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('toggled');
            mainContent.classList.remove('toggled');
        } else {
            sidebar.classList.add('toggled');
            mainContent.classList.add('toggled');
        }
    });
});

// Fungsi Image Preview (Dibuat global agar bisa dipanggil dari HTML onchange)
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// Fungsi Konfirmasi Hapus Draft (Dibuat global agar bisa dipanggil dari HTML onclick)
function confirmDelete() {
    // Di sini Anda bisa menambahkan logika pengecekan status post (draft/review) 
    // sebelum menampilkan konfirmasi.
    
    // Contoh: Asumsi hanya boleh dihapus jika status bukan 'published'
    const postStatus = document.getElementById('postStatus').value;
    
    if (postStatus === 'published') {
        alert('Artikel berstatus "Published" hanya dapat dihapus oleh Administrator.');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin menghapus Draf ini? Tindakan ini tidak dapat dibatalkan.')) {
        // Logika untuk mengirim permintaan DELETE ke backend (simulasi)
        alert(`Draf ID #123 (Status: ${postStatus}) berhasil dihapus (Simulasi)`);
        
        // Arahkan kembali ke daftar blog
        window.location.href = 'blog-list.html'; 
    }
}