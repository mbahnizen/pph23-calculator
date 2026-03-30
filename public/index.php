<?php
/**
 * PPh 23 Calculator — Single Entry Point
 *
 * GET  / → Render empty calculator
 * POST / → Parse input, calculate, render with results
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\TaxCalculator;
use App\Helpers\NumberParser;

$calculator = new TaxCalculator();
$results    = null;
$error      = '';
$rawInput   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawInput = $_POST['subtotal'] ?? '';

    try {
        $subtotal = NumberParser::parse($rawInput);
        $results  = $calculator->calculate($subtotal);
    } catch (\InvalidArgumentException $e) {
        $error = $e->getMessage();
    }
}

require __DIR__ . '/../views/calculator.php';
