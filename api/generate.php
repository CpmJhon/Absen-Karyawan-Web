<?php
/**
 * API GENERATE - PROXY VERSION
 * File ini berfungsi sebagai proxy jika endpoint asli tidak tersedia
 * atau untuk testing lokal. Hapus atau sesuaikan sesuai kebutuhan.
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get input
$input = json_decode(file_get_contents('php://input'), true);
$angka = isset($input['angka']) ? $input['angka'] : '';

// Validate
if (!is_numeric($angka) || $angka <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Nominal tidak valid']);
    exit;
}

/**
 * VERSION 1: Jika Anda punya endpoint asli (seperti di code original)
 * Uncomment kode di bawah ini dan sesuaikan URL-nya
 */

/*
try {
    $ch = curl_init('https://backend-asli.com/api/generate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['angka' => $angka]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        echo $response;
    } else {
        http_response_code($httpCode);
        echo json_encode(['error' => 'Gagal memanggil API eksternal']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
exit;
*/

/**
 * VERSION 2: Generate dummy image (untuk testing)
 * Hapus komentar di bawah untuk testing tanpa backend asli
 */

// Create dummy image
$width = 600;
$height = 400;
$image = imagecreatetruecolor($width, $height);

// Colors
$bgBlue = imagecolorallocate($image, 0, 102, 255); // #0066FF
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 240, 240, 240);

// Fill background
imagefilledrectangle($image, 0, 0, $width, $height, $white);

// Add header
imagefilledrectangle($image, 0, 0, $width, 80, $bgBlue);
imagestring($image, 5, 20, 30, 'DANA', $white);

// Add nominal
$nominal = 'Rp ' . number_format($angka, 0, ',', '.');
imagestring($image, 5, 50, 150, 'Saldo:', $black);
imagestring($image, 5, 50, 180, $nominal, $bgBlue);

// Add date
$date = date('d/m/Y H:i');
imagestring($image, 2, 50, 300, $date, $gray);

// Add watermark
imagestring($image, 1, $width - 150, $height - 30, 'DANA Generator', $gray);

// Output as PNG
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
exit;
?>