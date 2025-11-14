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
    
    // --- Delete Blog Functionality ---
    const tableBody = document.getElementById('blogTableBody');

    tableBody.addEventListener('click', function(event) {
        const target = event.target;
        // Cari tombol delete terdekat yang diklik
        const deleteButton = target.closest('.delete-btn');

        if (deleteButton) {
            const blogId = deleteButton.dataset.blogId;
            const row = deleteButton.closest('tr');
            const postTitle = row.querySelector('td:nth-child(2) strong').textContent;
            
            // Konfirmasi delete
            if (confirm(`Apakah Anda yakin ingin menghapus artikel "${postTitle}"?`)) {
                // Kirim request delete
                fetch(`/api/personil/blog/delete/${blogId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hapus row dari tabel
                        row.remove();
                        
                        // Update statistics
                        const totalPosts = document.getElementById('totalPosts');
                        const draftPosts = document.getElementById('draftPosts');
                        
                        if (totalPosts) {
                            totalPosts.textContent = parseInt(totalPosts.textContent) - 1;
                        }
                        if (draftPosts) {
                            draftPosts.textContent = parseInt(draftPosts.textContent) - 1;
                        }
                        
                        // Show success message
                        alert('Artikel berhasil dihapus!');
                        
                        // Reload page jika tidak ada blog lagi
                        const remainingRows = tableBody.querySelectorAll('tr').length;
                        if (remainingRows === 0) {
                            window.location.reload();
                        }
                    } else {
                        alert('Gagal menghapus artikel: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus artikel.');
                });
            }
        }
    });
    
    console.log("Halaman Personil Blog List script siap.");
});