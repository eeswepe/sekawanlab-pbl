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
    const filterRole = document.getElementById('filterRole');
    const filterForm = document.getElementById('filterForm');

    if (filterRole) {
        filterRole.addEventListener('change', function() {
            filterForm.submit();
        });
    }

    // Delete Personil Confirmation
    const deleteButtons = document.querySelectorAll('.delete-personil');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const personilId = this.getAttribute('data-id');
            const personilName = this.closest('tr').querySelector('td:nth-child(3)').textContent.trim();
            
            if (!confirm(`Apakah Anda yakin ingin menghapus personil "${personilName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                return;
            }
            
            // Disable button to prevent double-click
            this.disabled = true;
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
            
            try {
                const response = await fetch(`/admin/personil/delete/${personilId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Personil berhasil dihapus!');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                    this.disabled = false;
                    this.innerHTML = originalHTML;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus personil');
                this.disabled = false;
                this.innerHTML = originalHTML;
            }
        });
    });
});
