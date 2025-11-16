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
        } else {
            imagePreview.src = '#';
            imagePreview.style.display = 'none';
            placeholderText.style.display = 'block';
            previewContainer.style.border = '2px dashed #ccc';
        }
    });

    // --- Logika Estimasi Waktu Baca (Frontend Dummy) ---
    const contentTextarea = document.getElementById('blogContent');
    const readingTimeInput = document.getElementById('metaReadingTime');
    const wordsPerMinute = 200; // Standar rata-rata

    contentTextarea.addEventListener('input', function() {
        const text = contentTextarea.value.trim();
        // Menggunakan regex untuk menghitung kata secara lebih akurat
        const wordCount = text.match(/\b\w+\b/g) ? text.match(/\b\w+\b/g).length : 0;
        
        let readingTimeEstimate;
        if (wordCount === 0) {
            readingTimeEstimate = 'Otomatis (0 menit)';
        } else {
            const minutes = Math.ceil(wordCount / wordsPerMinute);
            readingTimeEstimate = `${minutes} menit`;
        }

        readingTimeInput.value = readingTimeEstimate;
    });

    // --- Logika Submit Form ---
    const form = document.getElementById('blogPostForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        const judul = document.getElementById('postTitle').value.trim();
        const konten = document.getElementById('blogContent').value.trim();
        const kategori_id = document.getElementById('postCategory').value;
        
        if (!judul || !konten || !kategori_id) {
            alert('Harap lengkapi semua field yang wajib diisi (Judul, Konten, Kategori)');
            return;
        }
        
        // Disable submit button
        const submitBtn = document.getElementById('submitBlogBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        
        // Prepare form data
        const formData = new FormData(form);
        
        // Send AJAX request
        fetch('/personil/blog/create', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Blog berhasil dibuat!');
                window.location.href = data.redirect || '/personil/blog';
            } else {
                alert('Gagal membuat blog: ' + (data.message || 'Unknown error'));
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membuat blog.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    console.log("Halaman Personil Blog Create script siap.");
});