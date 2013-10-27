<?php

namespace RequestableTest\Unit\Core;

use Requestable\Core\Autoloader;

class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Core\Autoloader::__construct
     */
    public function testConstructCorrectInstance()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertInstanceOf('\\Requestable\\Core\\Autoloader', $autoloader);
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     */
    public function testRegister()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertTrue($autoloader->register());
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     * @covers Requestable\Core\Autoloader::unregister
     */
    public function testUnregister()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertTrue($autoloader->register());
        $this->assertTrue($autoloader->unregister());
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     * @covers Requestable\Core\Autoloader::load
     */
    public function testLoadSuccess()
    {
        $autoloader = new Autoloader('FakeProject', dirname(__DIR__) . '/../Mocks/Core');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     * @covers Requestable\Core\Autoloader::load
     */
    public function testLoadSuccessExtraSlashedNamespace()
    {
        $autoloader = new Autoloader('\\\\FakeProject', dirname(__DIR__) . '/../Mocks/Core');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     * @covers Requestable\Core\Autoloader::load
     */
    public function testLoadSuccessExtraForwardSlashedPath()
    {
        $autoloader = new Autoloader('FakeProject', dirname(__DIR__) . '/../Mocks/Core//');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     * @covers Requestable\Core\Autoloader::load
     */
    public function testLoadSuccessExtraBackwardSlashedPath()
    {
        $autoloader = new Autoloader('FakeProject', dirname(__DIR__) . '/../Mocks/Core\\');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     * @covers Requestable\Core\Autoloader::load
     */
    public function testLoadSuccessExtraMixedSlashedPath()
    {
        $autoloader = new Autoloader('FakeProject', dirname(__DIR__) . '/../Mocks/Core\\\\/\\//');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers Requestable\Core\Autoloader::__construct
     * @covers Requestable\Core\Autoloader::register
     * @covers Requestable\Core\Autoloader::load
     */
    public function testLoadUnknownClass()
    {
        $autoloader = new Autoloader('FakeProject', dirname(__DIR__) . '/../Mocks/Core\\\\/\\//');

        $this->assertTrue($autoloader->register());

        $this->assertFalse($autoloader->load('IDontExistClass'));
    }
}
