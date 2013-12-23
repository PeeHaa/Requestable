<?php

namespace RequestableTest\Unit\Data;

use Requestable\Data\Get;

class GetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Data\Get::__construct
     */
    public function testConstructCorrectInterface()
    {
        $get = new Get($this->getMock('\\Requestable\\Network\\Http\\RequestData'));

        $this->assertInstanceOf('\\Requestable\\Data\\Request', $get);
    }

    /**
     * @covers Requestable\Data\Get::__construct
     */
    public function testConstructCorrectInstance()
    {
        $get = new Get($this->getMock('\\Requestable\\Network\\Http\\RequestData'));

        $this->assertInstanceOf('\\Requestable\\Data\\Get', $get);
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getUri
     */
    public function testGetUri()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue('foo'));

        $get = new Get($request);

        $this->assertSame('foo', $get->getUri());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getVersion
     */
    public function testGetVersion()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('get')->will($this->returnValue('1.0'));
        $request->expects($this->at(1))->method('get')->will($this->returnValue('1.0'));

        $get = new Get($request);

        $this->assertSame('1.0', $get->getVersion());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getVersion
     */
    public function testGetVersionDefault()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue(null));

        $get = new Get($request);

        $this->assertSame('1.1', $get->getVersion());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getMethod
     */
    public function testGetMethodCustom()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('get')->will($this->returnValue('FOO'));
        $request->expects($this->at(1))->method('get')->will($this->returnArgument(0));

        $get = new Get($request);

        $this->assertSame('CUSTOMMETHOD', $get->getMethod());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getMethod
     */
    public function testGetMethodStandard()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('get')->will($this->returnValue(null));
        $request->expects($this->at(1))->method('get')->will($this->returnArgument(0));

        $get = new Get($request);

        $this->assertSame('METHOD', $get->getMethod());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::redirectsEnabled
     */
    public function testRedirectsEnabledTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue('true'));

        $get = new Get($request);

        $this->assertTrue($get->redirectsEnabled());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::redirectsEnabled
     */
    public function testRedirectsEnabledFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue(null));

        $get = new Get($request);

        $this->assertFalse($get->redirectsEnabled());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::cookiesEnabled
     */
    public function testCookiesEnabledTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue('true'));

        $get = new Get($request);

        $this->assertTrue($get->cookiesEnabled());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::cookiesEnabled
     */
    public function testCookiesEnabledFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue(null));

        $get = new Get($request);

        $this->assertFalse($get->cookiesEnabled());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getHeaders
     */
    public function testGetHeadersEmpty()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue(null));

        $get = new Get($request);

        $this->assertSame([], $get->getHeaders());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getHeaders
     */
    public function testGetHeadersFilled()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('get')->will($this->returnValue('filled'));
        $request->expects($this->at(1))->method('get')->will($this->returnValue("Header1: 1\r\nHeader2: 2"));

        $get = new Get($request);

        $headers = $get->getHeaders();

        $this->assertSame(3, count($headers));
        $this->assertSame(['1'], $headers['header1']);
        $this->assertSame(['2'], $headers['header2']);
        $this->assertTrue(isset($headers['connection']));
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getBody
     */
    public function testBody()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue('foo'));

        $get = new Get($request);

        $this->assertSame('foo', $get->getBody());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::verifyPeer
     */
    public function testVerifyPeerTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue('true'));

        $get = new Get($request);

        $this->assertTrue($get->verifyPeer());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::verifyPeer
     */
    public function testVerifyPeerFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue(null));

        $get = new Get($request);

        $this->assertFalse($get->verifyPeer());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::verifyHost
     */
    public function testVerifyHostTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue('true'));

        $get = new Get($request);

        $this->assertTrue($get->verifyHost());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::verifyHost
     */
    public function testVerifyHostFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue(null));

        $get = new Get($request);

        $this->assertFalse($get->verifyHost());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getSslVersion
     */
    public function testGetSslVersionAutomaticWhenNotSet()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('get')->will($this->returnValue(null));

        $get = new Get($request);

        $this->assertSame('automatic', $get->getSslVersion());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getSslVersion
     */
    public function testGetSslVersion()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->any())->method('get')->will($this->returnValue(3));

        $get = new Get($request);

        $this->assertSame(3, $get->getSslVersion());
    }

    /**
     * @covers Requestable\Data\Get::__construct
     * @covers Requestable\Data\Get::getCaBundle
     */
    public function testGetCaBundle()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');

        $get = new Get($request);

        $this->assertNull($get->getCaBundle());
    }
}
