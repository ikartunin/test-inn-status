<?php
namespace App\Services;

class RequestService
{
    public static function request($url, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
        ]);
        return curl_exec($curl);
    }
}
