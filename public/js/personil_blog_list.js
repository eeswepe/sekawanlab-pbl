document.addEventListener('DOMContentLoaded', function() {
    // --- Logika Sidebar Toggle ---
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

    // Handle sidebar state on initial load for responsiveness
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
    
    // --- Logika Simulasi Aksi Tombol ---
    const tableBody = document.getElementById('blogTableBody');

    tableBody.addEventListener('click', function(event) {
        const target = event.target;
        // Cari tombol terdekat yang diklik
        const button = target.closest('.btn');

        if (button) {
            const row = button.closest('tr');
            const postId = row.dataset.id;
            const postTitle = row.cells[1].textContent;
            
            let actionMessage = '';

            if (button.classList.contains('edit-btn')) {
                actionMessage = `Simulasi: Mengedit artikel #${postId} - "${postTitle}".`;
                // Di aplikasi nyata: window.location.href = \`/personil/blog/edit/${postId}\`;
            } else if (button.classList.contains('view-btn')) {
                actionMessage = `Simulasi: Melihat artikel #${postId} - "${postTitle}".`;
                // Di aplikasi nyata: window.open(\`/blog/${postId}\`, '_blank');
            } else if (button.classList.contains('delete-btn')) {
                actionMessage = `Simulasi: Menghapus draft artikel #${postId} - "${postTitle}".`;
            }

            if (actionMessage) {
                console.log(actionMessage);
                alert(actionMessage);
            }
        }
    });

    // --- Logika Tombol Tulis Blog Baru (Simulasi) ---
    const tulisBlogBaruBtn = document.getElementById('tulisBlogBaruBtn');
    tulisBlogBaruBtn.addEventListener('click', function(e) {
        e.preventDefault();
        console.log("Simulasi: Navigasi ke halaman buat blog baru.");
        alert("Simulasi: Navigasi ke halaman buat blog baru.");
    });
    
    console.log("Halaman Personil Blog List script siap.");
});