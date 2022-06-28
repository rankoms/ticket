<?php

return [
    'base_url' => env('API_SCANNER_BASE_URL', 'http://127.0.0.1:8000'),
    'checkin' => env('API_SCANNER_CHECKIN', '/api/scanner/checkin'),
    'checkout' => env('API_SCANNER_CHECKOUT', '/api/scanner/checkout')
];
