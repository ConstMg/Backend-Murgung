<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], // Metode yang benar-benar Anda gunakan

    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        'https://const-mg.vercel.app',
        'https://front-end-const-mg.vercel.app',
        'https://frontend.constmg.murgung.id',
        'https://murgung.id',
    ],



    'allowed_origins_patterns' => [
        '/^https:\/\/const-[a-z0-9]+-[a-z0-9-]+-projects\.vercel\.app$/', 
        '/^https:\/\/front-end-const-[a-z0-9]+-herros27s-projects\.vercel\.app$/',],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
    ],

    'exposed_headers' => [
        
    ],

    'max_age' => 3600, // Cache preflight request selama 1 jam (dalam detik)

    'supports_credentials' => true, // di frontend harus di set : credentials: "include", kalo di vite

];

// return [

//     /*
//     |--------------------------------------------------------------------------
//     | Cross-Origin Resource Sharing (CORS) Configuration
//     |--------------------------------------------------------------------------
//     |
//     | Here you may configure your settings for cross-origin resource sharing
//     | or "CORS". This determines what cross-origin operations may execute
//     | in web browsers. You are free to adjust these settings as needed.
//     |
//     | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
//     |
//     */

//     'paths' => ['api/*'], // Sesuaikan jika endpoint API Anda berbeda

//     'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], // Izinkan hanya metode HTTP yang benar-benar Anda gunakan

//     'allowed_origins' => [
//         // Ganti dengan domain frontend production Anda yang sebenarnya
//         'https://your-production-domain.com',
//         'https://www.your-production-domain.com',
//         // Tambahkan domain lain yang diizinkan jika ada (misalnya, subdomain khusus untuk aplikasi mobile)
//     ],

//     'allowed_origins_patterns' => [
//         // Jika Anda memiliki pola domain yang dinamis (misalnya, untuk preview deployment),
//         // Anda bisa menambahkannya di sini. Contoh:
//         // '/^https:\/\/.*\.your-preview-domain\.com$/'
//         // Namun, gunakan ini dengan hati-hati dan pastikan polanya ketat.
//     ],

//     'allowed_headers' => [
//         'Content-Type',
//         'X-Requested-With',
//         'Authorization', // Jika Anda menggunakan token otentikasi
//         // Tambahkan header lain yang secara spesifik dibutuhkan oleh frontend Anda
//         // Hindari penggunaan '*' di production
//     ],

//     'exposed_headers' => [
//         // Jika frontend Anda perlu mengakses header tertentu dari response,
//         // daftarkan di sini. Contoh:
//         // 'X-RateLimit-Remaining',
//         // 'Content-Disposition',
//     ],

//     'max_age' => 3600, // Setel durasi caching untuk preflight request (dalam detik). 1 jam (3600) adalah nilai yang umum.

//     'supports_credentials' => true, // Tetap true jika frontend Anda mengirimkan credentials (cookies, authorization headers)
//     // dan Anda sudah mengatur `credentials: "include"` di frontend.

// ];