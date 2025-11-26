document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================
    // 1. Auto-submit form on filter change (Role)
    // ===================================
    const filterRole = document.getElementById('filterRole');
    const filterForm = document.getElementById('filterForm');

    if (filterRole && filterForm) {
        filterRole.addEventListener('change', function() {
            // Langsung submit form untuk menerapkan filter, 
            // query string 'search', 'role', dan 'page' akan otomatis terkirim.
            filterForm.submit();
        });
    }

    // ===================================
    // 2. Delete Personil Confirmation & AJAX
    // ===================================
    const deleteButtons = document.querySelectorAll('.delete-personil');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const personilId = this.getAttribute('data-id');
            // Mengambil nama personil dari kolom nama di baris yang sama (asumsi td:nth-child(2))
            const personilName = this.closest('tr').querySelector('td:nth-child(2) span')?.textContent.trim() || 'Personil Ini'; 
            
            if (!confirm(`Apakah Anda yakin ingin menghapus personil "${personilName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                return;
            }
            
            // Nonaktifkan tombol dan tampilkan spinner loading
            this.disabled = true;
            const originalHTML = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'; // Bootstrap Spinner
            
            try {
                // Endpoint DELETE, asumsikan /admin/personil/delete/{id}
                const response = await fetch(`/admin/personil/delete/${personilId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                const result = await response.json(); // Backend harus mengembalikan JSON { success: bool, message: string }
                
                if (result.success) {
                    alert('Personil berhasil dihapus!');
                    window.location.reload(); // Reload halaman untuk update daftar/pagination
                } else {
                    alert('Error: ' + (result.message || 'Gagal menghapus personil'));
                    this.disabled = false;
                    this.innerHTML = originalHTML;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus personil: ' + error.message);
                this.disabled = false;
                this.innerHTML = originalHTML;
            }
        });
    });
});