<?php

namespace App;

class TaxCalculator
{
    private const PPN_RATE = 0.11; // 11%
    private const PPH23_RATE = 0.02; // 2%

    /**
     * Calculate tax details from a subtotal.
     *
     * @param float $subtotal
     * @return array
     */
    public function calculate(float $subtotal): array
    {
        $ppnValue = $subtotal * self::PPN_RATE;
        $subtotalPlusPpn = $subtotal + $ppnValue;
        $pph23Value = $subtotal * self::PPH23_RATE;
        $total = $subtotalPlusPpn - $pph23Value;

        return [
            'subtotal' => $subtotal,
            'ppn_rate' => self::PPN_RATE,
            'ppn_value' => $ppnValue,
            'subtotal_plus_ppn' => $subtotalPlusPpn,
            'pph23_rate' => self::PPH23_RATE,
            'pph23_value' => $pph23Value,
            'total' => $total,
        ];
    }
}
