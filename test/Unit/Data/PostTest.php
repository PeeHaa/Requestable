<?php

namespace RequestableTest\Unit\Data;

use Requestable\Data\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Requestable\Data\Post::__construct
     */
    public function testConstructCorrectInterface()
    {
        $post = new Post($this->getMock('\\Requestable\\Network\\Http\\RequestData'));

        $this->assertInstanceOf('\\Requestable\\Data\\Request', $post);
    }

    /**
     * @covers Requestable\Data\Post::__construct
     */
    public function testConstructCorrectInstance()
    {
        $post = new Post($this->getMock('\\Requestable\\Network\\Http\\RequestData'));

        $this->assertInstanceOf('\\Requestable\\Data\\Post', $post);
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getUri
     */
    public function testGetUri()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue('foo'));

        $post = new Post($request);

        $this->assertSame('foo', $post->getUri());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getUri
     */
    public function testGetUriStripsFragment()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue('https://pieterhordijk.com/path#fragment'));

        $post = new Post($request);

        $this->assertSame('https://pieterhordijk.com/path', $post->getUri());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getVersion
     */
    public function testGetVersion()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('post')->will($this->returnValue('1.0'));
        $request->expects($this->at(1))->method('post')->will($this->returnValue('1.0'));

        $post = new Post($request);

        $this->assertSame('1.0', $post->getVersion());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getVersion
     */
    public function testGetVersionDefault()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue(null));

        $post = new Post($request);

        $this->assertSame('1.1', $post->getVersion());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getMethod
     */
    public function testGetMethodCustom()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('post')->will($this->returnValue('FOO'));
        $request->expects($this->at(1))->method('post')->will($this->returnArgument(0));

        $post = new Post($request);

        $this->assertSame('CUSTOMMETHOD', $post->getMethod());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getMethod
     */
    public function testGetMethodStandard()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('post')->will($this->returnValue(null));
        $request->expects($this->at(1))->method('post')->will($this->returnArgument(0));

        $post = new Post($request);

        $this->assertSame('METHOD', $post->getMethod());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::redirectsEnabled
     */
    public function testRedirectsEnabledTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue('true'));

        $post = new Post($request);

        $this->assertTrue($post->redirectsEnabled());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::redirectsEnabled
     */
    public function testRedirectsEnabledFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue(null));

        $post = new Post($request);

        $this->assertFalse($post->redirectsEnabled());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::cookiesEnabled
     */
    public function testCookiesEnabledTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue('true'));

        $post = new Post($request);

        $this->assertTrue($post->cookiesEnabled());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::cookiesEnabled
     */
    public function testCookiesEnabledFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue(null));

        $post = new Post($request);

        $this->assertFalse($post->cookiesEnabled());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getHeaders
     */
    public function testGetHeadersEmpty()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue(null));

        $post = new Post($request);

        $this->assertSame([], $post->getHeaders());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getHeaders
     */
    public function testGetHeadersFilled()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->at(0))->method('post')->will($this->returnValue('filled'));
        $request->expects($this->at(1))->method('post')->will($this->returnValue("Header1: 1\r\nHeader2: 2"));

        $post = new Post($request);

        $headers = $post->getHeaders();

        $this->assertSame(3, count($headers));
        $this->assertSame(['1'], $headers['header1']);
        $this->assertSame(['2'], $headers['header2']);
        $this->assertTrue(isset($headers['connection']));
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getBody
     */
    public function testBody()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue('foo'));

        $post = new Post($request);

        $this->assertSame('foo', $post->getBody());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::verifyPeer
     */
    public function testVerifyPeerTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue('true'));

        $post = new Post($request);

        $this->assertTrue($post->verifyPeer());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::verifyPeer
     */
    public function testVerifyPeerFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue(null));

        $post = new Post($request);

        $this->assertFalse($post->verifyPeer());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::verifyHost
     */
    public function testVerifyHostTrue()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue('true'));

        $post = new Post($request);

        $this->assertTrue($post->verifyHost());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::verifyHost
     */
    public function testVerifyHostFalse()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue(null));

        $post = new Post($request);

        $this->assertFalse($post->verifyHost());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getSslVersion
     */
    public function testGetSslVersionAutomaticWhenNotSet()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->once())->method('post')->will($this->returnValue(null));

        $post = new Post($request);

        $this->assertSame('automatic', $post->getSslVersion());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getSslVersion
     */
    public function testGetSslVersion()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');
        $request->expects($this->any())->method('post')->will($this->returnValue(3));

        $post = new Post($request);

        $this->assertSame(3, $post->getSslVersion());
    }

    /**
     * @covers Requestable\Data\Post::__construct
     * @covers Requestable\Data\Post::getCaBundle
     */
    public function testGetCaBundle()
    {
        $request = $this->getMock('\\Requestable\\Network\\Http\\RequestData');

        $post = new Post($request);

        $this->assertNull($post->getCaBundle());
    }
}
