<?php
// Set header JSON
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
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed'
    ]);
    exit;
}

// Get input
$input = json_decode(file_get_contents('php://input'), true);
$angka = isset($input['angka']) ? $input['angka'] : '';

// Validate
if (!is_numeric($angka) || $angka <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Nominal tidak valid'
    ]);
    exit;
}

try {
    // Create image
    $width = 600;
    $height = 400;
    $image = imagecreatetruecolor($width, $height);
    
    if (!$image) {
        throw new Exception('Gagal membuat gambar');
    }
    
    // Enable anti-aliasing
    imageantialias($image, true);
    
    // Colors
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $blue = imagecolorallocate($image, 0, 102, 255);
    $lightBlue = imagecolorallocate($image, 240, 248, 255);
    $gray = imagecolorallocate($image, 128, 128, 128);
    $lightGray = imagecolorallocate($image, 240, 240, 240);
    
    // Fill background
    imagefilledrectangle($image, 0, 0, $width, $height, $white);
    
    // Header section
    imagefilledrectangle($image, 0, 0, $width, 80, $blue);
    
    // DANA Logo text
    $fontSize = 5; // built-in font size (1-5)
    $textWidth = imagefontwidth($fontSize) * strlen('DANA');
    $textHeight = imagefontheight($fontSize);
    imagestring($image, $fontSize, 20, 30, 'DANA', $white);
    
    // Card section
    imagefilledrectangle($image, 20, 100, $width - 20, 350, $lightBlue);
    imagerectangle($image, 20, 100, $width - 20, 350, $blue);
    
    // Label
    imagestring($image, 3, 40, 120, 'Saldo', $gray);
    
    // Format nominal
    $nominal = number_format($angka, 0, ',', '.');
    $fullText = 'Rp ' . $nominal;
    
    // Nominal (larger font)
    imagestring($image, 5, 40, 150, $fullText, $blue);
    
    // Date
    $date = date('d/m/Y H:i');
    imagestring($image, 2, 40, 200, 'Update: ' . $date, $gray);
    
    // Transaction list (dummy)
    imagestring($image, 2, 40, 250, 'Transaksi Terakhir:', $black);
    imagestring($image, 2, 60, 280, '• Top Up', $gray);
    imagestring($image, 2, 60, 305, '• Transfer', $gray);
    
    // Watermark
    imagestring($image, 1, $width - 150, $height - 30, 'Fake Dana Generator', $lightGray);
    
    // Output to buffer
    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();
    
    // Free memory
    imagedestroy($image);
    
    // Return as JSON with base64
    echo json_encode([
        'success' => true,
        'image' => base64_encode($imageData),
        'format' => 'png',
        'nominal' => $nominal
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Gagal generate gambar: ' . $e->getMessage()
    ]);
}
?>