// JavaScript untuk Toggle Sidebar dan Logika Filter Frontend

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

    // 1. Logika Toggle Sidebar
    
    // Set sidebar aktif pada layar desktop saat dimuat
    if (window.innerWidth >= 992) {
        sidebar.classList.remove('toggled');
        mainContent.classList.remove('toggled');
    } else {
        sidebar.classList.add('toggled');
        mainContent.classList.add('toggled');
    }

    function toggleSidebar() {
        sidebar.classList.toggle('toggled');
        mainContent.classList.toggle('toggled');
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    // 2. Logika Filter Data Table (hanya frontend)
    const searchTitle = document.getElementById('searchTitle');
    const filterCategory = document.getElementById('filterCategory');
    const filterAuthor = document.getElementById('filterAuthor');
    const filterStatus = document.getElementById('filterStatus');
    const resetFilters = document.getElementById('resetFilters');

    /**
     * Menerapkan filter pada tabel berdasarkan nilai input filter.
     */
    function applyFilters() {
        const title = searchTitle.value.toLowerCase();
        // Menggunakan nilai teks dari option untuk filter kategori/penulis/status
        const category = filterCategory.options[filterCategory.selectedIndex].textContent;
        const author = filterAuthor.options[filterAuthor.selectedIndex].textContent;
        const status = filterStatus.options[filterStatus.selectedIndex].textContent;
        
        const rows = document.querySelectorAll('.table tbody tr');

        rows.forEach(row => {
            // Ambil teks dari sel yang sesuai
            const postTitle = row.cells[2].textContent.toLowerCase();
            const postCategory = row.cells[3].textContent;
            const postAuthor = row.cells[4].textContent;
            // Ambil teks dari badge untuk status
            const postStatus = row.cells[7].querySelector('.badge').textContent;

            // Logika pencocokan
            const titleMatch = postTitle.includes(title);
            const categoryMatch = category === 'Semua' || postCategory === category;
            const authorMatch = author === 'Semua' || postAuthor === author;
            const statusMatch = status === 'Semua' || postStatus === status;

            if (titleMatch && categoryMatch && authorMatch && statusMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    /**
     * Mereset semua nilai filter ke default 'Semua' atau kosong.
     */
    function resetAllFilters() {
        searchTitle.value = '';
        filterCategory.value = 'Semua';
        filterAuthor.value = 'Semua';
        filterStatus.value = 'Semua';
        applyFilters(); // Terapkan filter setelah reset
    }

    // Event Listeners
    searchTitle.addEventListener('input', applyFilters);
    filterCategory.addEventListener('change', applyFilters);
    filterAuthor.addEventListener('change', applyFilters);
    filterStatus.addEventListener('change', applyFilters);
    resetFilters.addEventListener('click', resetAllFilters);

    // Initial filter application on load (just to show all data)
    applyFilters();
});