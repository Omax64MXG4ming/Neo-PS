<?php

function checkService($url): array
{
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_NOBODY => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_USERAGENT => "NeoPS-ServiceChecker/1.0"
    ]);

    curl_exec($ch);

    $error = curl_error($ch);
    $errno = curl_errno($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($errno !== 0) {
        return [
            "online" => false,
            "http_code" => $httpCode,
            "error" => $error
        ];
    }

    return [
        "online" => ($httpCode >= 200 && $httpCode < 300),
        "http_code" => $httpCode,
        "error" => null
    ];
}
