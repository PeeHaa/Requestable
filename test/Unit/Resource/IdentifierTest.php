<?php

namespace RequestableTest\Resource;

use Requestable\Resource\Identifier;

class IdentifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testConstructCorrectInterface()
    {
        $identifier = new Identifier();

        $this->assertInstanceOf('\\Requestable\\Resource\\Converter', $identifier);
    }

    /**
     *
     */
    public function testConstructCorrectInstance()
    {
        $identifier = new Identifier();

        $this->assertInstanceOf('\\Requestable\\Resource\\Identifier', $identifier);
    }

    /**
     * @covers Requestable\Resource\Identifier::toPlain
     */
    public function testToPlainFirst()
    {
        $identifier = new Identifier();

        $this->assertSame(1, $identifier->toPlain('NEaj'));
    }

    /**
     * @covers Requestable\Resource\Identifier::toPlain
     */
    public function testToPlainSixCharacters()
    {
        $identifier = new Identifier();

        $this->assertSame(123456, $identifier->toPlain('AWopzMd'));
    }

    /**
     * @covers Requestable\Resource\Identifier::toPlain
     */
    public function testToPlainMaxInt()
    {
        $identifier = new Identifier();

        $this->assertSame(2147483647, $identifier->toPlain('zDZaUCNPj'));
    }

    /**
     * @covers Requestable\Resource\Identifier::toHash
     */
    public function testToHashFirst()
    {
        $identifier = new Identifier();

        $this->assertSame('NEaj', $identifier->toHash(1));
    }

    /**
     * @covers Requestable\Resource\Identifier::toHash
     */
    public function testToHashSixCharacters()
    {
        $identifier = new Identifier();

        $this->assertSame('AWopzMd', $identifier->toHash(123456));
    }

    /**
     * @covers Requestable\Resource\Identifier::toHash
     */
    public function testToHashMaxInt()
    {
        $identifier = new Identifier();

        $this->assertSame('zDZaUCNPj', $identifier->toHash(2147483647));
    }
}
