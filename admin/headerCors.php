<?php
// $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// $allowedOrigins = [
//    'https://miramarinmobiliario.com.ar',
//    'https://www.miramarinmobiliario.com.ar'
// ];

// if (in_array($origin, $allowedOrigins)) {
//     header("Access-Control-Allow-Origin: $origin");
//     header("Access-Control-Allow-Credentials: true");
// }

header('https://localhost:3000');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
