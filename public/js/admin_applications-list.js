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
    
    // Auto-hide sidebar on small screens initially
    if (window.innerWidth <= 992) {
        sidebar.classList.add('toggled');
        mainContent.classList.add('toggled');
    }

    // --- 2. Select All Checkbox Logic ---
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
    }
    
    if (rowCheckboxes.length > 0) {
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    // Check if all other checkboxes are now checked
                    const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                }
            });
        });
    }

    // --- 3. Action Button Handlers (Placeholder) ---
    // Actions for individual rows
    document.querySelectorAll('.view-detail').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            alert(`Melihat detail aplikasi dengan ID: ${id}`);
        });
    });

    document.querySelectorAll('.update-status').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            alert(`Membuka modal/form Update Status untuk ID: ${id}`);
        });
    });

    // Bulk actions
    document.getElementById('bulkAccept')?.addEventListener('click', function(e) {
        e.preventDefault();
        const selectedIds = Array.from(rowCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.getAttribute('data-id'));
        
        if (selectedIds.length > 0) {
            alert(`Menerima aplikasi yang dipilih: ${selectedIds.join(', ')}`);
            // Di sini Anda akan mengirim permintaan AJAX/Fetch ke server
        } else {
            alert('Pilih setidaknya satu aplikasi untuk diterima.');
        }
    });

    document.getElementById('bulkReject')?.addEventListener('click', function(e) {
        e.preventDefault();
        const selectedIds = Array.from(rowCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.getAttribute('data-id'));
        
        if (selectedIds.length > 0) {
            alert(`Menolak aplikasi yang dipilih: ${selectedIds.join(', ')}`);
            // Di sini Anda akan mengirim permintaan AJAX/Fetch ke server
        } else {
            alert('Pilih setidaknya satu aplikasi untuk ditolak.');
        }
    });

    // --- 4. Filter Handlers (Placeholder) ---
    // Logika filtering di proyek riil akan memanggil API untuk mendapatkan data baru.
    document.querySelectorAll('.filter-controls select, .filter-controls input').forEach(input => {
        input.addEventListener('change', function() {
            console.log('Filter changed. Triggering data refresh...');
        });
    });
});