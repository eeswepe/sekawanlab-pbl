document.addEventListener('DOMContentLoaded', function() {
    // --- Logika Sidebar Toggle ---
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebarToggleMobile');

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

    // --- Logika Estimasi Waktu Baca ---
    const contentTextarea = document.getElementById('blogContent');
    const readingTimeInput = document.getElementById('metaReadingTime');
    const wordsPerMinute = 200;

    function updateReadingTime() {
        let text = contentTextarea.value;
        
        // Check if Summernote is initialized and get code from it
        if (typeof $ !== 'undefined' && $('#blogContent').summernote('instance')) {
            const htmlContent = $('#blogContent').summernote('code');
            // Strip HTML tags for word count
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = htmlContent;
            text = tempDiv.textContent || tempDiv.innerText || '';
        }

        text = text.trim();
        const wordCount = text.match(/\b\w+\b/g) ? text.match(/\b\w+\b/g).length : 0;
        
        let readingTimeEstimate;
        if (wordCount === 0) {
            readingTimeEstimate = 'Otomatis (0 menit)';
        } else {
            const minutes = Math.ceil(wordCount / wordsPerMinute);
            readingTimeEstimate = `Otomatis (${minutes} menit)`;
        }

        readingTimeInput.value = readingTimeEstimate;
    }

    contentTextarea.addEventListener('input', updateReadingTime);
    // Also listen for summernote change events if dispatched manually
    // (The onChange callback in create.php dispatches 'input' event)

    // --- Logika Tombol Cancel ---
    const cancelBtn = document.getElementById('cancelBtn');
    cancelBtn.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin membatalkan? Data yang belum disimpan akan hilang.')) {
            window.location.href = '/admin/blog-list';
        }
    });

    // --- Logika Submit Form ---
    const form = document.getElementById('blogPostForm');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        // Explicitly set content from Summernote if available
        if (typeof $ !== 'undefined' && $('#blogContent').summernote('instance')) {
            formData.set('konten', $('#blogContent').summernote('code'));
        }
        
        // Show loading
        const submitBtn = e.submitter;
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        
        try {
            const response = await fetch('/admin/blog/create', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Blog berhasil dibuat!');
                window.location.href = '/admin/blog-list';
            } else {
                alert('Error: ' + result.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan blog');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    // --- Summernote Initialization ---
    $(document).ready(function() {
        if (typeof $.fn.summernote !== 'undefined') {
            $('#blogContent').summernote({
                height: 400,
                minHeight: 300,
                maxHeight: 600,
                placeholder: 'Mulai tulis konten artikel Anda di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Courier New', 'Helvetica', 'Times New Roman', 'Verdana', 'Poppins', 'Montserrat'],
                fontNamesIgnoreCheck: ['Poppins', 'Montserrat'],
                callbacks: {
                    // Update reading time when content changes
                    onChange: function(contents) {
                        // Trigger input event manually for the custom JS to pick up
                        const event = new Event('input', {
                            bubbles: true,
                            cancelable: true,
                        });
                        document.getElementById('blogContent').dispatchEvent(event);
                    }
                }
            });
        } else {
            console.error('Summernote library not found!');
        }
    });
});
