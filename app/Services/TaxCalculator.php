<?php

namespace App\Services;

/**
 * Calculates Indonesian tax breakdown from a subtotal.
 *
 * - PPN  (Pajak Pertambahan Nilai): 11%
 * - PPh 23 (Pajak Penghasilan 23):  2%
 */
class TaxCalculator
{
    private const PPN_RATE = 0.11;
    private const PPH23_RATE = 0.02;

    /**
     * Calculate tax details from a subtotal.
     *
     * @param  float $subtotal Base amount before tax
     * @return array{
     *     subtotal: float,
     *     ppn_rate: float,
     *     ppn_value: float,
     *     subtotal_plus_ppn: float,
     *     pph23_rate: float,
     *     pph23_value: float,
     *     total: float
     * }
     */
    public function calculate(float $subtotal): array
    {
        $ppn         = $subtotal * self::PPN_RATE;
        $subtotalPpn = $subtotal + $ppn;
        $pph23       = $subtotal * self::PPH23_RATE;
        $total       = $subtotalPpn - $pph23;

        return [
            'subtotal'          => $subtotal,
            'ppn_rate'          => self::PPN_RATE,
            'ppn_value'         => $ppn,
            'subtotal_plus_ppn' => $subtotalPpn,
            'pph23_rate'        => self::PPH23_RATE,
            'pph23_value'       => $pph23,
            'total'             => $total,
        ];
    }
}
