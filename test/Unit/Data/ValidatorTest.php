<?php

namespace RequestableTest\Unit\Data;

use Requestable\Data\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Data\Validator::__construct
     */
    public function testConstructCorrectInstance()
    {
        $validator = new Validator($this->getMock('\\Requestable\\Data\\Request'));

        $this->assertInstanceOf('\\Requestable\\Data\\Validator', $validator);
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     */
    public function testIsValidSuccess()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('https://pieterhordijk.com'));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));

        $validator = new Validator($request);

        $this->assertTrue($validator->isValid());
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     */
    public function testIsValidMissingUri()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));

        $validator = new Validator($request);

        $this->assertFalse($validator->isValid());
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     */
    public function testIsValidMissingMethod()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('https://pieterhordijk.com'));

        $validator = new Validator($request);

        $this->assertFalse($validator->isValid());
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     */
    public function testIsValidMissingBoth()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');

        $validator = new Validator($request);

        $this->assertFalse($validator->isValid());
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     * @covers Requestable\Data\Validator::getErrors
     */
    public function testGetErrorsNone()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('https://pieterhordijk.com'));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));

        $validator = new Validator($request);
        $validator->isValid();

        $this->assertSame(0, count($validator->getErrors()));
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     * @covers Requestable\Data\Validator::getErrors
     */
    public function testGetErrorsMissingUri()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));

        $validator = new Validator($request);
        $validator->isValid();

        $this->assertSame(1, count($validator->getErrors()));
        $this->assertSame('uri.required', $validator->getErrors()[0]);
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     * @covers Requestable\Data\Validator::getErrors
     */
    public function testGetErrorsMissingMethod()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('https://pieterhordijk.com'));

        $validator = new Validator($request);
        $validator->isValid();

        $this->assertSame(1, count($validator->getErrors()));
        $this->assertSame('method.required', $validator->getErrors()[0]);
    }

    /**
     * @covers Requestable\Data\Validator::__construct
     * @covers Requestable\Data\Validator::isValid
     * @covers Requestable\Data\Validator::validate
     * @covers Requestable\Data\Validator::getErrors
     */
    public function testGetErrorsMissingBoth()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');

        $validator = new Validator($request);
        $validator->isValid();

        $this->assertSame(2, count($validator->getErrors()));
        $this->assertSame('uri.required', $validator->getErrors()[0]);
        $this->assertSame('method.required', $validator->getErrors()[1]);
    }
}
