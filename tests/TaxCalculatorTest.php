<?php

namespace Tests;

use App\Services\TaxCalculator;
use PHPUnit\Framework\TestCase;

class TaxCalculatorTest extends TestCase
{
    private TaxCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new TaxCalculator();
    }

    public function testStandardCalculation(): void
    {
        $result = $this->calculator->calculate(1_000_000);

        $this->assertEquals(1_000_000, $result['subtotal']);
        $this->assertEquals(0.11, $result['ppn_rate']);
        $this->assertEquals(110_000, $result['ppn_value']);
        $this->assertEquals(1_110_000, $result['subtotal_plus_ppn']);
        $this->assertEquals(0.02, $result['pph23_rate']);
        $this->assertEquals(20_000, $result['pph23_value']);
        $this->assertEquals(1_090_000, $result['total']);
    }

    public function testZeroSubtotal(): void
    {
        $result = $this->calculator->calculate(0);

        $this->assertEquals(0, $result['ppn_value']);
        $this->assertEquals(0, $result['pph23_value']);
        $this->assertEquals(0, $result['total']);
    }

    public function testDecimalSubtotal(): void
    {
        $result = $this->calculator->calculate(1_500_000.50);

        $this->assertEqualsWithDelta(165_000.055, $result['ppn_value'], 0.01);
        $this->assertEqualsWithDelta(30_000.01, $result['pph23_value'], 0.01);
        $this->assertEqualsWithDelta(1_635_000.545, $result['total'], 0.01);
    }

    public function testLargeNumber(): void
    {
        $result = $this->calculator->calculate(999_999_999);

        $this->assertEqualsWithDelta(109_999_999.89, $result['ppn_value'], 0.01);
        $this->assertEqualsWithDelta(19_999_999.98, $result['pph23_value'], 0.01);
    }

    public function testReturnStructure(): void
    {
        $result = $this->calculator->calculate(100);

        $this->assertArrayHasKey('subtotal', $result);
        $this->assertArrayHasKey('ppn_rate', $result);
        $this->assertArrayHasKey('ppn_value', $result);
        $this->assertArrayHasKey('subtotal_plus_ppn', $result);
        $this->assertArrayHasKey('pph23_rate', $result);
        $this->assertArrayHasKey('pph23_value', $result);
        $this->assertArrayHasKey('total', $result);
    }

    public function testTotalFormula(): void
    {
        // total = subtotal + ppn - pph23
        $result = $this->calculator->calculate(500_000);

        $expected = $result['subtotal_plus_ppn'] - $result['pph23_value'];
        $this->assertEquals($expected, $result['total']);
    }
}
