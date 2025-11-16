document.addEventListener('DOMContentLoaded', function() {
    // Logika Sidebar Toggle
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

    // Fungsi untuk memastikan sidebar tertutup di layar kecil saat loading
    // Ini membantu layout awal pada perangkat mobile.
    if (window.innerWidth < 992) {
        sidebar.classList.add('toggled');
        mainContent.classList.add('toggled');
    }

    // Optional: Logika tambahan untuk menangani perubahan ukuran layar
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            // Jika di desktop, pastikan sidebar terbuka
            sidebar.classList.remove('toggled');
            mainContent.classList.remove('toggled');
        } else {
            // Jika kembali ke mobile, biarkan sidebar tertutup
            sidebar.classList.add('toggled');
            mainContent.classList.add('toggled');
        }
    });
});