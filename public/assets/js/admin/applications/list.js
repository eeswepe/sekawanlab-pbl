document.addEventListener('DOMContentLoaded', function() {
    // --- Sidebar Toggle Logic (SB Admin 2 style) ---
    const sidebar = document.querySelector('.sidebar');
    const contentWrapper = document.getElementById('content-wrapper');
    const toggleButton = document.getElementById('sidebarToggle');
    const toggleButtonTop = document.getElementById('sidebarToggleTop');
    
    // Toggling function for all sidebar buttons
    function toggleSidebar() {
        sidebar.classList.toggle('toggled');
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }
    
    if (toggleButtonTop) {
        toggleButtonTop.addEventListener('click', toggleSidebar);
    }

    // Close sidebar on mobile when a link is clicked
    const navLinks = document.querySelectorAll('.nav-item .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('toggled');
            }
        });
    });

    // --- Auto-submit form on filter change ---
    const filterStatus = document.getElementById('filterStatus');
    const filterForm = document.getElementById('filterForm');

    if (filterStatus) {
        filterStatus.addEventListener('change', function() {
            filterForm.submit();
        });
    }


    // --- Delete Application Confirmation ---
    const deleteButtons = document.querySelectorAll('.delete-application');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const applicationId = this.getAttribute('data-id');
            // Safely get application name, considering the table structure
            const applicationNameElement = this.closest('tr').querySelector('td:nth-child(2)');
            const applicationName = applicationNameElement ? applicationNameElement.textContent.trim() : 'aplikasi ini';
            
            if (!confirm(`Apakah Anda yakin ingin menghapus application dari "${applicationName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                return;
            }
            
            // Disable button to prevent double-click
            this.disabled = true;
            const originalHTML = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            
            try {
                // Assuming the base URL is correct for the fetch call
                const response = await fetch(`/admin/join-application/delete/${applicationId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Application berhasil dihapus!');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                    this.disabled = false;
                    this.innerHTML = originalHTML;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus application');
                this.disabled = false;
                this.innerHTML = originalHTML;
            }
        });
    });
});