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

    // --- Logika Tombol Cancel ---
    const cancelBtn = document.getElementById('cancelBtn');
    cancelBtn.addEventListener('click', function() {
        console.warn("Aksi Batalkan: Simulasi kembali ke halaman daftar blog.");
        alert('Aksi Batalkan: Kembali ke halaman daftar blog.'); 
    });

    // --- Logika Submit Form (Dummy) ---
    const form = document.getElementById('blogPostForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Tentukan status berdasarkan tombol yang diklik
        const submitterId = e.submitter ? e.submitter.id : '';
        let status;

        if (submitterId === 'submitReviewBtn') {
            status = 'Review';
        } else if (submitterId === 'saveDraftBtn') {
            status = 'Draft';
        } else {
            // Default status dari radio button (Draft)
            status = document.querySelector('input[name="postStatus"]:checked').value;
        }
        
        const title = document.getElementById('postTitle').value;
        
        console.log("--- Form Submission Data (Personil) ---");
        console.log(`Judul: ${title}`);
        console.log(`Status Final: ${status}`);
        console.log("--------------------------");

        // Menampilkan pesan sukses sebagai simulasi
        let action;
        if (status === 'Review') {
            action = 'disubmit untuk di-review';
        } else {
            action = 'disimpan sebagai draft';
        }
        const message = `Artikel "${title}" berhasil ${action}! (Simulasi frontend)`;

        console.warn(`[SIMULASI SUKSES]: ${message}`); 
        alert(message);
    });
});