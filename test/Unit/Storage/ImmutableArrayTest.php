<?php

namespace RequestableTest\Storage;

use Requestable\Storage\ImmutableArray;

class ImmutableArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Storage\ImmutableArray::__construct
     */
    public function testConstructCorrectInterface()
    {
        $array = new ImmutableArray();

        $this->assertInstanceOf('\\Requestable\\Storage\\ImmutableKeyValue', $array);
    }

    /**
     * @covers Requestable\Storage\ImmutableArray::__construct
     */
    public function testConstructCorrectInstance()
    {
        $array = new ImmutableArray();

        $this->assertInstanceOf('\\Requestable\\Storage\\ImmutableArray', $array);
    }

    /**
     * @covers Requestable\Storage\ImmutableArray::__construct
     * @covers Requestable\Storage\ImmutableArray::isKeyValid
     */
    public function testIsKeyValidInvalid()
    {
        $array = new ImmutableArray();

        $this->assertFalse($array->isKeyValid('foo'));
    }

    /**
     * @covers Requestable\Storage\ImmutableArray::__construct
     * @covers Requestable\Storage\ImmutableArray::isKeyValid
     */
    public function testIsKeyValidValid()
    {
        $array = new ImmutableArray(['foo' => 'bar']);

        $this->assertTrue($array->isKeyValid('foo'));
    }

    /**
     * @covers Requestable\Storage\ImmutableArray::__construct
     * @covers Requestable\Storage\ImmutableArray::get
     */
    public function testGetExists()
    {
        $array = new ImmutableArray(['foo' => 'bar']);

        $this->assertSame('bar', $array->get('foo'));
    }

    /**
     * @covers Requestable\Storage\ImmutableArray::__construct
     * @covers Requestable\Storage\ImmutableArray::get
     */
    public function testGetNotExistsDefaultValue()
    {
        $array = new ImmutableArray();

        $this->assertNull($array->get('foo'));
    }

    /**
     * @covers Requestable\Storage\ImmutableArray::__construct
     * @covers Requestable\Storage\ImmutableArray::get
     */
    public function testGetNotExistsCustomDefaultValue()
    {
        $array = new ImmutableArray();

        $this->assertSame('bar', $array->get('foo', 'bar'));
    }
}
