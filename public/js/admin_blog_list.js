document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

    // Sidebar Toggle
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

    // Auto-submit form on filter change
    const filterCategory = document.getElementById('filterCategory');
    const filterAuthor = document.getElementById('filterAuthor');
    const filterStatus = document.getElementById('filterStatus');
    const filterForm = document.getElementById('filterForm');

    if (filterCategory) {
        filterCategory.addEventListener('change', function() {
            filterForm.submit();
        });
    }

    if (filterAuthor) {
        filterAuthor.addEventListener('change', function() {
            filterForm.submit();
        });
    }

    if (filterStatus) {
        filterStatus.addEventListener('change', function() {
            filterForm.submit();
        });
    }

    // Delete Blog Confirmation
    const deleteButtons = document.querySelectorAll('.delete-blog');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const blogId = this.getAttribute('data-id');
            
            if (!confirm('Apakah Anda yakin ingin menghapus blog ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/blog/delete/${blogId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Blog berhasil dihapus!');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus blog');
            }
        });
    });
});

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