<?php

namespace App\Services\External;

use Exception;

/**
 * AssessorService
 * 
 * Service untuk memanggil microservice Assessor (Python/Flask)
 */
class AssessorService
{
    // Ganti dengan URL yang diexpose oleh microservice Python Anda
    private const ASSESSOR_URL = 'http://assessor.eeswepe.my.id/analyze';

    /**
     * Memanggil microservice Assessor untuk menganalisis pelamar.
     * 
     * @param string $githubUsername Username GitHub pelamar.
     * @param string $cvFilePath Path relatif file CV (contoh: /upload/cv/cv_123.pdf).
     * @return array Hasil analisis dari Assessor.
     * @throws Exception Jika panggilan API gagal.
     */
    public function analyzeApplication(string $githubUsername, string $cvFilePath): string
    {
        // 1. Persiapan Data
        // Path absolut ke file CV di server PHP
        $fullCvPath = realpath(__DIR__ . '/../../../public') . $cvFilePath;

        if (!file_exists($fullCvPath)) {
            throw new Exception("File CV tidak ditemukan di: " . $fullCvPath);
        }

        // 2. Persiapan cURL untuk mengirim multipart/form-data
        $ch = curl_init();

        // Data yang akan dikirim (multipart/form-data)
        $postData = [
            'username' => $githubUsername,
            // Menggunakan '@' untuk mengirim file dalam cURL
            'cv_file' => new \CURLFile($fullCvPath, 'application/pdf', basename($fullCvPath)),
        ];

        curl_setopt($ch, CURLOPT_URL, self::ASSESSOR_URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Tambahkan opsi untuk mengabaikan verifikasi SSL jika diperlukan (hanya untuk testing)
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // 3. Eksekusi cURL
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        // 4. Penanganan Respon
        if ($response === false) {
            throw new Exception("Gagal memanggil Assessor Service (cURL Error): " . $error);
        }

        // $result = json_decode($response, true);

        // if ($httpCode !== 200) {
        //     $errorMessage = $result['error'] ?? "Kesalahan tidak diketahui dari Assessor Service (HTTP Code: {$httpCode})";
        //     throw new Exception("Assessor Service mengembalikan error: " . $errorMessage);
        // }

        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     throw new Exception("Gagal mendekode JSON dari Assessor Service: " . json_last_error_msg());
        // }

        return $response;
    }
}
