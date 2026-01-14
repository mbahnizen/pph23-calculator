<?php

require_once __DIR__ . '/../src/TaxCalculator.php';

use App\TaxCalculator;

$calculator = new TaxCalculator();
$results = null;
$error_message = '';
$subtotal_input = '';

// Handle POST request for fallback PHP calculation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputRaw = $_POST['subtotal'] ?? '';

    // Support simple addition (e.g. 100+200)
    $parts = explode('+', $inputRaw);
    $subtotal_input = 0;
    $isValid = true;

    foreach ($parts as $part) {
        $cleanPart = trim($part);
        if ($cleanPart === '')
            continue;
        if (is_numeric($cleanPart) && $cleanPart >= 0) {
            $subtotal_input += (float) $cleanPart;
        } else {
            $isValid = false;
            break;
        }
    }

    if ($isValid && $subtotal_input >= 0) {
        $results = $calculator->calculate($subtotal_input);
        // Keep the original expression in the input
        $subtotal_input = $inputRaw;
    } else {
        $error_message = 'Masukkan nilai subtotal yang valid (angka positif atau penjumlahan seperti 500+200).';
        $subtotal_input = $inputRaw;
    }
}

// Render the view
require __DIR__ . '/../templates/main.php';
