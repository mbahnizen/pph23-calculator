<?php

namespace Tests;

use App\Helpers\NumberParser;
use PHPUnit\Framework\TestCase;

class NumberParserTest extends TestCase
{
    // --- Valid inputs ---

    public function testPlainInteger(): void
    {
        $this->assertEquals(1000000, NumberParser::parse('1000000'));
    }

    public function testIndonesianDotFormat(): void
    {
        $this->assertEquals(1000000, NumberParser::parse('1.000.000'));
    }

    public function testIndonesianDecimalComma(): void
    {
        $this->assertEqualsWithDelta(1500.50, NumberParser::parse('1.500,50'), 0.001);
    }

    public function testSimpleAddition(): void
    {
        $this->assertEquals(650000, NumberParser::parse('500.000 + 150.000'));
    }

    public function testMultipleAddition(): void
    {
        $this->assertEquals(300000, NumberParser::parse('100.000 + 100.000 + 100.000'));
    }

    public function testAdditionWithSpaces(): void
    {
        $this->assertEquals(600000, NumberParser::parse('  300.000  +  300.000  '));
    }

    public function testMixedFormats(): void
    {
        // 1000000 + 500.000 = 1500000
        $this->assertEquals(1500000, NumberParser::parse('1000000 + 500.000'));
    }

    public function testSmallNumber(): void
    {
        $this->assertEquals(100, NumberParser::parse('100'));
    }

    // --- Invalid inputs ---

    public function testEmptyStringThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('');
    }

    public function testWhitespaceOnlyThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('   ');
    }

    public function testAlphabeticInputThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('abc');
    }

    public function testSpecialCharsThrow(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('100 * 2');
    }

    public function testOnlyPlusOperatorThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('+');
    }

    public function testTrailingPlusThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('100.000 +');
    }

    public function testLeadingPlusThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('+ 100.000');
    }

    public function testScriptInjectionThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse('<script>alert(1)</script>');
    }

    public function testExcessivelyLongInputThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        NumberParser::parse(str_repeat('1', 101));
    }
}
