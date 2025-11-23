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

    // --- 2. Quick Actions Handlers ---
    
    // Quick Accept
    document.getElementById('quickAccept')?.addEventListener('click', async function() {
        const id = this.dataset.id;
        if (!confirm('Terima aplikasi ini? Sistem akan membuat akun personil dengan password kosong.')) return;
        try {
            const response = await fetch(`/admin/join-application/update-status/${id}`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({status: 'accepted'})
            });
            const result = await response.json();
            if (result.success) {
                const pid = result.personil_id ?? null;
                if (pid) {
                    alert(`Aplikasi berhasil diterima. Akun personil dibuat (ID: ${pid}).`);
                } else {
                    alert('Aplikasi berhasil diterima.');
                }
                location.reload();
            } else {
                alert(result.message || 'Gagal memperbarui status');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });

    // Quick Reject
    document.getElementById('quickReject')?.addEventListener('click', async function() {
        const id = this.dataset.id;
        if (!confirm('Tolak aplikasi ini?')) return;
        try {
            const response = await fetch(`/admin/join-application/update-status/${id}`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({status: 'rejected'})
            });
            const result = await response.json();
            if (result.success) {
                alert('Aplikasi berhasil ditolak');
                location.reload();
            } else {
                alert(result.message || 'Gagal memperbarui status');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });

    // Delete Application
    document.getElementById('deleteApplication')?.addEventListener('click', async function() {
        const id = this.dataset.id;
        if (!confirm('YAKIN hapus aplikasi ini PERMANEN? Tidak dapat dibatalkan.')) return;
        try {
            const response = await fetch(`/admin/join-application/delete/${id}`, {method: 'DELETE'});
            const result = await response.json();
            if (result.success) {
                alert('Aplikasi berhasil dihapus');
                window.location.href = '/admin/join-applications';
            } else {
                alert(result.message || 'Gagal menghapus aplikasi');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });
    
    // Save New Status
    document.getElementById('updateStatusForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.querySelector('[data-id]').dataset.id;
        const newStatus = document.getElementById('newStatus').value;
        
        if (newStatus === 'accepted') {
            if (!confirm('Terima aplikasi ini? Sistem akan membuat akun personil dengan password kosong.')) return;
        }
        
        try {
            const response = await fetch(`/admin/join-application/update-status/${id}`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({status: newStatus})
            });
            const result = await response.json();
            if (result.success) {
                const pid = result.personil_id ?? null;
                if (pid) {
                    alert(`Status berhasil diperbarui. Akun personil dibuat (ID: ${pid}).`);
                } else {
                    alert('Status berhasil diperbarui');
                }
                location.reload();
            } else {
                alert(result.message || 'Gagal memperbarui status');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });
    
    // Save Admin Notes
    document.getElementById('adminNotesForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.querySelector('[data-id]').dataset.id;
        const notes = document.getElementById('adminNotes').value;
        try {
            const response = await fetch(`/admin/join-application/update-notes/${id}`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({admin_notes: notes})
            });
            const result = await response.json();
            if (result.success) {
                alert('Catatan admin berhasil disimpan');
            } else {
                alert(result.message || 'Gagal menyimpan catatan');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });

    // --- 3. CV Download & Preview ---
    const downloadBtn = document.getElementById('downloadCvBtn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            const path = this.dataset.cvPath;
            const name = this.dataset.cvName || 'cv';
            try {
                const resp = await fetch('/' + path);
                if (!resp.ok) throw new Error('Gagal mengambil file');
                const blob = await resp.blob();
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = name;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            } catch (err) {
                alert('Gagal download CV: ' + err.message);
            }
        });
    }

    const previewBtn = document.getElementById('previewCvBtn');
    if (previewBtn) {
        previewBtn.addEventListener('click', function() {
            const path = this.dataset.cvPath;
            const name = this.dataset.cvName || 'CV Preview';
            const iframe = document.getElementById('cvPreviewIframe');
            const titleEl = document.getElementById('cvPreviewModalLabel');
            if (iframe) {
                iframe.src = '/' + path;
            }
            if (titleEl) {
                titleEl.textContent = 'Preview CV: ' + name;
            }
            const modalEl = document.getElementById('cvPreviewModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    }
});