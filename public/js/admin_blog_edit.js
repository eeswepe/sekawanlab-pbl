document.addEventListener('DOMContentLoaded', function() {
    // Data Dummy Awal
    const initialContent = document.getElementById('blogContent').value;

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
    
    // --- Logika Image Preview ---
    const imageInput = document.getElementById('featuredImage');
    const imagePreview = document.getElementById('image-preview');
    const previewContainer = document.getElementById('image-preview-container');
    const placeholderText = document.getElementById('placeholder-text');

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                placeholderText.style.display = 'none';
                previewContainer.style.border = 'none';
            };
            reader.readAsDataURL(file);
        }
        // Tidak ada else, karena gambar existing sudah ditampilkan
    });

    // --- Logika Estimasi Waktu Baca ---
    const contentTextarea = document.getElementById('blogContent');
    const readingTimeInput = document.getElementById('metaReadingTime');
    const wordsPerMinute = 200; 

    function updateReadingTime(text) {
        const wordCount = text.match(/\b\w+\b/g) ? text.match(/\b\w+\b/g).length : 0;
        
        let readingTimeEstimate;
        if (wordCount === 0) {
            readingTimeEstimate = 'Otomatis (0 menit)';
        } else {
            const minutes = Math.ceil(wordCount / wordsPerMinute);
            readingTimeEstimate = `${minutes} menit`;
        }
        readingTimeInput.value = readingTimeEstimate;
    }

    // Inisialisasi waktu baca dengan konten yang sudah ada
    updateReadingTime(initialContent);
    
    // Update waktu baca saat konten berubah
    contentTextarea.addEventListener('input', function() {
        updateReadingTime(contentTextarea.value);
    });

    // --- Logika Tombol Cancel ---
    const cancelBtn = document.getElementById('cancelBtn');
    cancelBtn.addEventListener('click', function() {
        if (confirm('Batalkan perubahan dan kembali ke halaman daftar blog?')) {
            window.location.href = '/admin/blog-list';
        }
    });

    // --- Logika Tombol Delete ---
    const deleteBtn = document.getElementById('deleteBtn');
    deleteBtn.addEventListener('click', function() {
        const blogId = this.getAttribute('data-blog-id');
        
        if (confirm('Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.')) {
            fetch(`/admin/blog/delete/${blogId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = '/admin/blog-list';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus blog');
            });
        }
    });

    // --- Logika Submit Form (Update Blog) ---
    const form = document.getElementById('blogPostForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const blogId = form.getAttribute('data-blog-id');
        const formData = new FormData(form);
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Updating...';
        
        fetch(`/admin/blog/update/${blogId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '/admin/blog-list';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengupdate blog');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });
});