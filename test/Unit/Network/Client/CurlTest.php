<?php

namespace RequestableTest\Unit\Network\Client;

use Requestable\Network\Client\Curl;

class CurlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Network\Client\Curl::__construct
     */
    public function testConstructCorrectInterface()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue(null));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue(null));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue([]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue(null));

        $client = new Curl($request);

        $this->assertInstanceOf('\\Requestable\\Network\\Client\\Client', $client);
    }

    /**
     * @covers Requestable\Network\Client\Curl::__construct
     */
    public function testConstructCorrectInstance()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue(null));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue(null));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue([]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue(null));

        $client = new Curl($request);

        $this->assertInstanceOf('\\Requestable\\Network\\Client\\Curl', $client);
    }

    /**
     * @covers Requestable\Network\Client\Curl::__construct
     */
    public function testConstructCorrectInstanceWithBody()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue(null));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue(null));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue([]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue('foo'));

        $client = new Curl($request);

        $this->assertInstanceOf('\\Requestable\\Network\\Client\\Curl', $client);
    }

    /**
     * @covers Requestable\Network\Client\Curl::__construct
     * @covers Requestable\Network\Client\Curl::run
     */
    public function testRunMalformedRequest()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('http'));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue([]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue('foo'));

        $client = new Curl($request);

        // because the fine cURL people thought it would be a good idea to throw different error messages when
        // using different versions I have to use this fugly hack. tnx cURL team. Really nice...

        $exceptionHit = false;

        try {
            $client->run();
        } catch (\Requestable\Network\Client\CurlException $e) {
            $exceptionHit = true;

            $possibleMessages = [
                'Making request failed: Could not resolve host: http; Host not found',
                'Making request failed: Couldn\'t resolve host \'http\'',
            ];

            $this->assertSame(1, preg_match('#' . implode('|', $possibleMessages) . '#', $e->getMessage()));
        }

        $this->assertTrue($exceptionHit);
    }

    /**
     * @covers Requestable\Network\Client\Curl::__construct
     * @covers Requestable\Network\Client\Curl::run
     * @covers Requestable\Network\Client\Curl::setOptions
     */
    public function testRunSuccessHeaders()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('http://pieterhordijk.com'));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue([]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue(null));

        $client = new Curl($request);

        $response = $client->run();

        $this->assertSame(1, preg_match('#Location: https://pieterhordijk.com#', $response['headers'][0]));
    }

    /**
     * @covers Requestable\Network\Client\Curl::__construct
     * @covers Requestable\Network\Client\Curl::run
     * @covers Requestable\Network\Client\Curl::setOptions
     */
    public function testRunSuccessBody()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('http://pieterhordijk.com'));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue([]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue(null));

        $client = new Curl($request);

        $response = $client->run();

        $this->assertSame(1, preg_match('#301 Moved Permanently#', $response['body']));
    }

    /**
     * @covers Requestable\Network\Client\Curl::__construct
     * @covers Requestable\Network\Client\Curl::run
     * @covers Requestable\Network\Client\Curl::setOptions
     * @covers Requestable\Network\Client\Curl::getHeaders
     */
    public function testRunSuccessWithHeaders()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('http://pieterhordijk.com'));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue(['foo' => ['bar']]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue(null));

        $client = new Curl($request);

        $response = $client->run();

        $this->assertSame(1, preg_match('#Location: https://pieterhordijk.com#', $response['headers'][0]));
    }

    /**
     * @covers Requestable\Network\Client\Curl::__construct
     * @covers Requestable\Network\Client\Curl::run
     * @covers Requestable\Network\Client\Curl::setOptions
     * @covers Requestable\Network\Client\Curl::getHeaders
     */
    public function testRunSuccessWithBody()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->once())->method('getUri')->will($this->returnValue('http://pieterhordijk.com'));
        $request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));
        $request->expects($this->once())->method('redirectsEnabled')->will($this->returnValue(false));
        $request->expects($this->once())->method('getHeaders')->will($this->returnValue([]));
        $request->expects($this->once())->method('getBody')->will($this->returnValue('foo'));

        $client = new Curl($request);

        $response = $client->run();

        $this->assertSame(1, preg_match('#Location: https://pieterhordijk.com#', $response['headers'][0]));
    }
}
