<?php

namespace RequestableTest\Network\Http;

use Requestable\Network\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Network\Http\Request::__construct
     */
    public function testConstructCorrectInterface()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertInstanceOf('\\Requestable\\Network\\Http\\RequestData', $request);
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     */
    public function testConstructCorrectInstance()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertInstanceOf('\\Requestable\\Network\\Http\\Request', $request);
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::get
     */
    public function testGetExists()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $getVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $getVariables->expects($this->any())->method('get')->will($this->returnValue('bar'));

        $request = new Request($getVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertSame('bar', $request->get('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::get
     */
    public function testGetNotExistsDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertNull($request->get('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::get
     */
    public function testGetNotExistsCustomDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $getVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $getVariables->expects($this->any())->method('get')->will($this->returnArgument(1));

        $request = new Request($getVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertSame('bar', $request->get('foo', 'bar'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::post
     */
    public function testPostExists()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $postVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $postVariables->expects($this->any())->method('get')->will($this->returnValue('bar'));

        $request = new Request($requestVariables, $postVariables, $requestVariables, $requestVariables);

        $this->assertSame('bar', $request->post('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::post
     */
    public function testPostNotExistsDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertNull($request->post('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::post
     */
    public function testPostNotExistsCustomDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $postVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $postVariables->expects($this->any())->method('get')->will($this->returnArgument(1));

        $request = new Request($requestVariables, $postVariables, $requestVariables, $requestVariables);

        $this->assertSame('bar', $request->post('foo', 'bar'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::server
     */
    public function testServerExists()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('bar'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertSame('bar', $request->server('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::server
     */
    public function testServerNotExistsDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertNull($request->server('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::server
     */
    public function testServerNotExistsCustomDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnArgument(1));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertSame('bar', $request->server('foo', 'bar'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::files
     */
    public function testFilesExists()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $filesVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $filesVariables->expects($this->any())->method('get')->will($this->returnValue('bar'));

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $filesVariables);

        $this->assertSame('bar', $request->files('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::files
     */
    public function testFilesNotExistsDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertNull($request->files('foo'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::files
     */
    public function testFilesNotExistsCustomDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $filesVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $filesVariables->expects($this->any())->method('get')->will($this->returnArgument(1));

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $filesVariables);

        $this->assertSame('bar', $request->files('foo', 'bar'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::setParameters
     */
    public function testSetParameters()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertNull($request->setParameters([1, 2, 3, 4, 5]));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::setParameters
     * @covers Requestable\Network\Http\Request::param
     */
    public function testParamExists()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $request->setParameters(['foo', 'bar', 'baz']);

        $this->assertSame('foo', $request->param(0));
        $this->assertSame('bar', $request->param(1));
        $this->assertSame('baz', $request->param(2));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::param
     */
    public function testParamNotExistsDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertNull($request->param(0));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::param
     */
    public function testParamNotExistsCustomDefaultValue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $request = new Request($requestVariables, $requestVariables, $requestVariables, $requestVariables);

        $this->assertSame('bar', $request->param('0', 'bar'));
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::getPath
     */
    public function testGetPath()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('/foo/bar'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertSame('/foo/bar', $request->getPath());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::getPath
     */
    public function testGetPathWithQueryString()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('/foo/bar?foo=bar'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertSame('/foo/bar', $request->getPath());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::getMethod
     */
    public function testGetMethod()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('POST'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertSame('POST', $request->getMethod());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isXhr
     */
    public function testIsXhrTrue()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('XMLHttpRequest'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertTrue($request->isXhr());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isXhr
     */
    public function testIsXhrFalse()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('XMLHttpRequestFalse'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertFalse($request->isXhr());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isSecure
     */
    public function testIsSecureTrueNotEmpty()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('Non empty value'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertTrue($request->isSecure());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isSecure
     */
    public function testIsSecureTrueOn()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('on'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertTrue($request->isSecure());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isSecure
     */
    public function testIsSecureFalseEmptyString()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue(''));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertFalse($request->isSecure());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isSecure
     */
    public function testIsSecureFalseNull()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue(null));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertFalse($request->isSecure());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isSecure
     */
    public function testIsSecureFalseOff()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->any())->method('get')->will($this->returnValue('off'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertFalse($request->isSecure());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isSecure
     * @covers Requestable\Network\Http\Request::getBaseUrl
     */
    public function testGetBaseUrlSecure()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->at(0))->method('get')->will($this->returnValue('on'));
        $serverVariables->expects($this->at(1))->method('get')->will($this->returnValue('pieterhordijk.com'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertSame('https://pieterhordijk.com', $request->getBaseUrl());
    }

    /**
     * @covers Requestable\Network\Http\Request::__construct
     * @covers Requestable\Network\Http\Request::isSecure
     * @covers Requestable\Network\Http\Request::getBaseUrl
     */
    public function testGetBaseUrl()
    {
        $requestVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');

        $serverVariables = $this->getMock('\\Requestable\\Storage\\ImmutableKeyValue');
        $serverVariables->expects($this->at(0))->method('get')->will($this->returnValue('off'));
        $serverVariables->expects($this->at(1))->method('get')->will($this->returnValue('pieterhordijk.com'));

        $request = new Request($requestVariables, $requestVariables, $serverVariables, $requestVariables);

        $this->assertSame('http://pieterhordijk.com', $request->getBaseUrl());
    }
}
