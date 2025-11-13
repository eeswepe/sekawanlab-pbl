document.addEventListener('DOMContentLoaded', function() {
    // --- 1. Sidebar Toggle Logic ---
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

    // --- 2. Quick Actions Handlers (Placeholder) ---
    
    // Quick Accept
    document.getElementById('quickAccept')?.addEventListener('click', function() {
        alert('Aplikasi diterima. (Aksi: Update status menjadi Accepted)');
        // Implementasi nyata: set nilai select box dan kirim permintaan API
        document.getElementById('newStatus').value = 'accepted';
    });

    // Quick Reject
    document.getElementById('quickReject')?.addEventListener('click', function() {
        alert('Aplikasi ditolak. (Aksi: Update status menjadi Rejected)');
        // Implementasi nyata: set nilai select box dan kirim permintaan API
        document.getElementById('newStatus').value = 'rejected';
    });

    // Delete Application
    document.getElementById('deleteApplication')?.addEventListener('click', function() {
        if (confirm('APAKAH ANDA YAKIN ingin MENGHAPUS aplikasi ini secara PERMANEN? Tindakan ini tidak dapat dibatalkan.')) {
            alert('Aplikasi dihapus. (Aksi: Kirim permintaan DELETE)');
            // Implementasi nyata: Kirim permintaan DELETE ke backend dan redirect ke daftar aplikasi
        }
    });
    
    // Save New Status
    document.getElementById('updateStatusForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const newStatus = document.getElementById('newStatus').value;
        alert(`Status diperbarui menjadi: ${newStatus}.`);
        // Implementasi nyata: Kirim permintaan PATCH/PUT ke backend untuk menyimpan status
    });
    
    // Save Admin Notes
    document.getElementById('adminNotesForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const notes = document.getElementById('adminNotes').value;
        alert(`Catatan admin disimpan: ${notes.substring(0, 50)}...`);
        // Implementasi nyata: Kirim permintaan PATCH/PUT ke backend untuk menyimpan catatan
    });
});