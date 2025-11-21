<?php

namespace App\Services\Shared;

/**
 * FileUploadService
 * 
 * Shared service untuk menangani semua file uploads
 * Digunakan oleh: Admin Services, Personil Services, JoinApplicationController
 * 
 * Tanggung jawab:
 * - Upload images (blog, profile photos)
 * - Upload PDFs (CV, documents)
 * - Validasi file (type, size)
 * - Delete files
 * - Generate unique filenames
 */
class FileUploadService
{
    // Default configurations
    private const DEFAULT_IMAGE_MAX_SIZE = 5 * 1024 * 1024; // 5MB
    private const DEFAULT_PDF_MAX_SIZE = 5 * 1024 * 1024; // 5MB
    
    private const ALLOWED_IMAGE_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp'
    ];
    
    private const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    private const ALLOWED_PDF_TYPES = ['application/pdf'];
    private const ALLOWED_PDF_EXTENSIONS = ['pdf'];

    private string $baseUploadPath;

    public function __construct()
    {
        // Base upload path (relative to public/)
        // Resolve to absolute path untuk memastikan akurasi
        $this->baseUploadPath = realpath(__DIR__ . '/../../../public') . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
        
        // Create base upload directory if not exists
        if (!is_dir($this->baseUploadPath)) {
            mkdir($this->baseUploadPath, 0777, true);
        }
    }

    /**
     * Upload image file
     * 
     * @param array $file File dari $_FILES
     * @param string $directory Directory tujuan (relatif dari upload/, contoh: 'blog', 'img/foto-profil')
     * @param string $prefix Prefix untuk nama file (contoh: 'blog_', 'profile_')
     * @param int|null $maxSize Max file size dalam bytes (default: 5MB)
     * @return array ['success' => bool, 'path' => string|null, 'message' => string]
     */
    public function uploadImage(
        array $file, 
        string $directory, 
        string $prefix = 'img_',
        ?int $maxSize = null
    ): array {
        // Check if file has error
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'path' => null,
                'message' => $this->getUploadErrorMessage($file['error'] ?? UPLOAD_ERR_NO_FILE)
            ];
        }

        // Validate image
        $validation = $this->validateImage($file, $maxSize);
        if (!$validation['valid']) {
            return [
                'success' => false,
                'path' => null,
                'message' => $validation['message']
            ];
        }

        // Create directory if not exists
        $uploadDir = $this->baseUploadPath . rtrim($directory, '/') . DIRECTORY_SEPARATOR;
        if (!$this->createDirectory($uploadDir)) {
            return [
                'success' => false,
                'path' => null,
                'message' => 'Gagal membuat directory upload: ' . $uploadDir
            ];
        }

        // Generate unique filename
        $extension = $this->getFileExtension($file['name']);
        $filename = $this->generateUniqueFilename($prefix, $extension);
        $filepath = $uploadDir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Return relative path dari public/
            return [
                'success' => true,
                'path' => '/upload/' . rtrim($directory, '/') . '/' . $filename,
                'message' => 'File berhasil diupload'
            ];
        }

        return [
            'success' => false,
            'path' => null,
            'message' => 'Gagal memindahkan file dari ' . $file['tmp_name'] . ' ke ' . $filepath
        ];
    }

    /**
     * Upload PDF file
     * 
     * @param array $file File dari $_FILES
     * @param string $directory Directory tujuan (relatif dari upload/)
     * @param string $prefix Prefix untuk nama file (contoh: 'cv_', 'doc_')
     * @param int|null $maxSize Max file size dalam bytes (default: 5MB)
     * @return array ['success' => bool, 'path' => string|null, 'message' => string]
     */
    public function uploadPDF(
        array $file,
        string $directory,
        string $prefix = 'pdf_',
        ?int $maxSize = null
    ): array {
        // Check if file has error
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'path' => null,
                'message' => $this->getUploadErrorMessage($file['error'] ?? UPLOAD_ERR_NO_FILE)
            ];
        }

        // Validate PDF
        $validation = $this->validatePDF($file, $maxSize);
        if (!$validation['valid']) {
            return [
                'success' => false,
                'path' => null,
                'message' => $validation['message']
            ];
        }

        // Create directory if not exists
        $uploadDir = $this->baseUploadPath . rtrim($directory, '/') . '/';
        if (!$this->createDirectory($uploadDir)) {
            return [
                'success' => false,
                'path' => null,
                'message' => 'Gagal membuat directory upload'
            ];
        }

        // Generate unique filename
        $extension = $this->getFileExtension($file['name']);
        $filename = $this->generateUniqueFilename($prefix, $extension);
        $filepath = $uploadDir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'success' => true,
                'path' => '/upload/' . rtrim($directory, '/') . '/' . $filename,
                'message' => 'File berhasil diupload'
            ];
        }

        return [
            'success' => false,
            'path' => null,
            'message' => 'Gagal memindahkan file'
        ];
    }

    /**
     * Validasi image file
     * 
     * @param array $file File dari $_FILES
     * @param int|null $maxSize Max size dalam bytes
     * @return array ['valid' => bool, 'message' => string]
     */
    public function validateImage(array $file, ?int $maxSize = null): array
    {
        $maxSize = $maxSize ?? self::DEFAULT_IMAGE_MAX_SIZE;

        // Check file type by MIME
        if (!in_array($file['type'], self::ALLOWED_IMAGE_TYPES)) {
            return [
                'valid' => false,
                'message' => 'Tipe file tidak valid. Hanya JPG, PNG, GIF, dan WEBP yang diperbolehkan.'
            ];
        }

        // Check file extension
        $extension = strtolower($this->getFileExtension($file['name']));
        if (!in_array($extension, self::ALLOWED_IMAGE_EXTENSIONS)) {
            return [
                'valid' => false,
                'message' => 'Ekstensi file tidak valid.'
            ];
        }

        // Check file size
        if ($file['size'] > $maxSize) {
            $maxSizeMB = round($maxSize / (1024 * 1024), 2);
            return [
                'valid' => false,
                'message' => "Ukuran file terlalu besar. Maksimal {$maxSizeMB}MB."
            ];
        }

        return [
            'valid' => true,
            'message' => 'File valid'
        ];
    }

    /**
     * Validasi PDF file
     * 
     * @param array $file File dari $_FILES
     * @param int|null $maxSize Max size dalam bytes
     * @return array ['valid' => bool, 'message' => string]
     */
    public function validatePDF(array $file, ?int $maxSize = null): array
    {
        $maxSize = $maxSize ?? self::DEFAULT_PDF_MAX_SIZE;

        // Check file type by MIME
        if (!in_array($file['type'], self::ALLOWED_PDF_TYPES)) {
            return [
                'valid' => false,
                'message' => 'Tipe file tidak valid. Hanya PDF yang diperbolehkan.'
            ];
        }

        // Check file extension
        $extension = strtolower($this->getFileExtension($file['name']));
        if (!in_array($extension, self::ALLOWED_PDF_EXTENSIONS)) {
            return [
                'valid' => false,
                'message' => 'Ekstensi file tidak valid.'
            ];
        }

        // Check file size
        if ($file['size'] > $maxSize) {
            $maxSizeMB = round($maxSize / (1024 * 1024), 2);
            return [
                'valid' => false,
                'message' => "Ukuran file terlalu besar. Maksimal {$maxSizeMB}MB."
            ];
        }

        return [
            'valid' => true,
            'message' => 'File valid'
        ];
    }

    /**
     * Delete file
     * 
     * @param string $filePath Path relatif dari public/ (contoh: '/upload/blog/image.jpg')
     * @return bool
     */
    public function deleteFile(string $filePath): bool
    {
        try {
            // Remove leading slash if exists
            $filePath = ltrim($filePath, '/');
            
            // Full path
            $fullPath = __DIR__ . '/../../../public/' . $filePath;

            // Check if file exists
            if (!file_exists($fullPath)) {
                return false;
            }

            // Delete file
            return unlink($fullPath);
        } catch (\Exception $e) {
            error_log('Delete File Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate unique filename
     * 
     * @param string $prefix Prefix (contoh: 'blog_', 'cv_')
     * @param string $extension Extension (contoh: 'jpg', 'pdf')
     * @return string Unique filename
     */
    public function generateUniqueFilename(string $prefix, string $extension): string
    {
        $timestamp = time();
        $uniqueId = uniqid();
        
        return $prefix . $timestamp . '_' . $uniqueId . '.' . $extension;
    }

    /**
     * Create directory jika belum ada
     * 
     * @param string $directory Full path directory
     * @return bool
     */
    public function createDirectory(string $directory): bool
    {
        try {
            if (!is_dir($directory)) {
                return mkdir($directory, 0777, true);
            }
            return true;
        } catch (\Exception $e) {
            error_log('Create Directory Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get file extension
     * 
     * @param string $filename Nama file
     * @return string Extension (lowercase)
     */
    public function getFileExtension(string $filename): string
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Get file size in bytes
     * 
     * @param array $file File dari $_FILES
     * @return int File size dalam bytes
     */
    public function getFileSize(array $file): int
    {
        return $file['size'] ?? 0;
    }

    /**
     * Check if file type is valid
     * 
     * @param array $file File dari $_FILES
     * @param array $allowedTypes Array of allowed MIME types
     * @return bool
     */
    public function isValidFileType(array $file, array $allowedTypes): bool
    {
        return in_array($file['type'], $allowedTypes);
    }

    /**
     * Get upload error message
     * 
     * @param int $errorCode Error code dari $_FILES['error']
     * @return string Error message
     */
    private function getUploadErrorMessage(int $errorCode): string
    {
        return match ($errorCode) {
            UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize di php.ini)',
            UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE di form)',
            UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
            UPLOAD_ERR_EXTENSION => 'Upload file dihentikan oleh extension',
            default => 'Error upload file tidak diketahui'
        };
    }

    /**
     * Get allowed image types
     * 
     * @return array
     */
    public function getAllowedImageTypes(): array
    {
        return self::ALLOWED_IMAGE_TYPES;
    }

    /**
     * Get allowed image extensions
     * 
     * @return array
     */
    public function getAllowedImageExtensions(): array
    {
        return self::ALLOWED_IMAGE_EXTENSIONS;
    }

    /**
     * Get allowed PDF types
     * 
     * @return array
     */
    public function getAllowedPDFTypes(): array
    {
        return self::ALLOWED_PDF_TYPES;
    }

    /**
     * Get max image size
     * 
     * @return int Size dalam bytes
     */
    public function getMaxImageSize(): int
    {
        return self::DEFAULT_IMAGE_MAX_SIZE;
    }

    /**
     * Get max PDF size
     * 
     * @return int Size dalam bytes
     */
    public function getMaxPDFSize(): int
    {
        return self::DEFAULT_PDF_MAX_SIZE;
    }

    /**
     * Format file size untuk display
     * 
     * @param int $bytes Size dalam bytes
     * @return string Formatted size (contoh: "2.5 MB")
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
