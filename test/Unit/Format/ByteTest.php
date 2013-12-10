<?php

namespace RequestableTest\Unit\Format;

use Requestable\Format\Byte;

class ByteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Format\Byte::__construct
     * @covers Requestable\Format\Byte::format
     */
    public function testFormatDefaultB()
    {
        $formatter = new Byte();

        $this->assertSame('10 B', $formatter->format(10));
    }

    /**
     * @covers Requestable\Format\Byte::__construct
     * @covers Requestable\Format\Byte::format
     */
    public function testFormatDefaultMB()
    {
        $formatter = new Byte();

        $this->assertSame('977 MB', $formatter->format(1024000000));
    }

    /**
     * @covers Requestable\Format\Byte::__construct
     * @covers Requestable\Format\Byte::format
     */
    public function testFormatDefaultOverflow()
    {
        $formatter = new Byte();

        $this->assertSame('93 GB', $formatter->format(102400000000000));
    }

    /**
     * @covers Requestable\Format\Byte::__construct
     * @covers Requestable\Format\Byte::format
     */
    public function testFormatCustomPrecision()
    {
        $formatter = new Byte(2);

        $this->assertSame('1.00 KB', $formatter->format(1024));
    }

    /**
     * @covers Requestable\Format\Byte::__construct
     * @covers Requestable\Format\Byte::format
     */
    public function testFormatCustomPrecisionAndUnits()
    {
        $formatter = new Byte(2, ['B', 'AWESOME']);

        $this->assertSame('1.00 AWESOME', $formatter->format(1024));
    }
}
