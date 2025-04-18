<?php

return [
    /*
    |--------------------------------------------------------------------------
    | N11 Seller Partner API Credentials
    |--------------------------------------------------------------------------
    |
    | N11 API'sine erişim için gerekli olan anahtarlar. Bu anahtarları
    | N11 Seller Partner API panelinden alabilirsiniz.
    |
    */
    'app_key' => env('N11_APP_KEY', ''),
    'app_secret' => env('N11_APP_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | N11 API Base URL
    |--------------------------------------------------------------------------
    |
    | N11 API'sine erişim için kullanılacak base URL.
    |
    */
    'base_url' => env('N11_API_BASE_URL', 'https://api.n11.com/ws/'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | API isteklerinin zaman aşımı süresi (saniye cinsinden)
    |
    */
    'timeout' => env('N11_API_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | API yanıtlarının önbelleğe alınmasıyla ilgili yapılandırma
    |
    */
    'cache' => [
        'enabled' => env('N11_API_CACHE_ENABLED', true),
        'ttl' => env('N11_API_CACHE_TTL', 3600), // Saniye cinsinden
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Debug modu etkinleştirildiğinde, tüm API istekleri ve yanıtları loglanır.
    |
    */
    'debug' => env('N11_API_DEBUG', false),
]; 