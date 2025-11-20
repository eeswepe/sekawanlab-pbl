<?php

namespace App\Services\External;

class SiakadService
{

    public function checkPassword(string $nimNip, string $password)
    {
        $POST_URL = "https://siakad.polinema.ac.id/login";

        // payload (seperti yang kamu kirim di Burp)
        $payload = http_build_query([
            "username" => $nimNip,
            "password" => $password
        ]);

        // headers
        $headers = [
            "X-Requested-With: XMLHttpRequest",
            "Accept: application/json, text/javascript, */*; q=0.01",
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            "Origin: https://siakad.polinema.ac.id",
            "Referer: https://siakad.polinema.ac.id/",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36",
        ];
        // init curl
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $POST_URL,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYHOST => false,   // verify=False
            CURLOPT_SSL_VERIFYPEER => false     // cookies dari Burp
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        // tampilkan
        if ($response !== false && strpos($response, 'Salah') !== false) {
            return false;
        }

        return true;
    }
}
