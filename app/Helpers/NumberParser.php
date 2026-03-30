<?php

namespace App\Helpers;

/**
 * Parses Indonesian-formatted number strings into float values.
 *
 * Supports:
 *  - Thousand separators: "1.000.000" → 1000000
 *  - Decimal commas:      "1.500,50"  → 1500.50
 *  - Simple addition:     "500.000 + 150.000" → 650000
 */
class NumberParser
{
    private const MAX_INPUT_LENGTH = 100;

    /**
     * Parse an input string to a float value.
     *
     * @param  string $input Raw user input
     * @return float  Parsed numeric value
     * @throws \InvalidArgumentException On invalid input
     */
    public static function parse(string $input): float
    {
        $input = trim($input);

        if ($input === '') {
            throw new \InvalidArgumentException('Input tidak boleh kosong.');
        }

        if (strlen($input) > self::MAX_INPUT_LENGTH) {
            throw new \InvalidArgumentException('Input terlalu panjang.');
        }

        // Whitelist: digits, dots, commas, plus, spaces only
        if (preg_match('/[^0-9.,+\s]/', $input)) {
            throw new \InvalidArgumentException('Karakter tidak valid. Gunakan angka, titik, koma, atau tanda +.');
        }

        // Split by "+" and sum each part
        $parts = explode('+', $input);
        $sum = 0.0;

        foreach ($parts as $part) {
            $token = trim($part);
            if ($token === '') {
                throw new \InvalidArgumentException('Format penjumlahan tidak valid.');
            }
            $sum += self::parseToken($token);
        }

        if ($sum < 0) {
            throw new \InvalidArgumentException('Nilai tidak boleh negatif.');
        }

        return $sum;
    }

    /**
     * Parse a single number token from Indonesian format to float.
     *
     * "1.000.000" → 1000000.0
     * "1.500,50"  → 1500.50
     */
    private static function parseToken(string $token): float
    {
        // Indonesian format: dots = thousands, comma = decimal
        $clean = str_replace('.', '', $token);   // Remove thousand separators
        $clean = str_replace(',', '.', $clean);  // Convert decimal separator

        if (!is_numeric($clean)) {
            throw new \InvalidArgumentException("Bukan angka valid: \"{$token}\"");
        }

        return (float) $clean;
    }
}
