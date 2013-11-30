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
}
