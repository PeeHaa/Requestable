<?php

namespace RequestableTest\Unit\Resource;

use Requestable\Resource\Retriever;
use RequestableTest\Mocks\Database\PDOMock;

class RetrieverTest extends \PHPUnit_Framework_TestCase
{
    private $dbConnection;

    public function setUp()
    {
        $this->dbConnection = new PDOMock('dsn', 'user', 'pass');
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     */
    public function testConstructCorrectInterface()
    {
        $retriever = new Retriever($this->dbConnection);

        $this->assertInstanceOf('\\Requestable\\Resource\\Retrievable', $retriever);
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     */
    public function testConstructCorrectInstance()
    {
        $retriever = new Retriever($this->dbConnection);

        $this->assertInstanceOf('\\Requestable\\Resource\\Retriever', $retriever);
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     * @covers Requestable\Resource\Retriever::getRequest
     */
    public function testGetRequest()
    {
        $retriever = new Retriever($this->dbConnection);

        $this->assertInstanceof('\\Requestable\\Data\\Storage', $retriever->getRequest(1));
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     * @covers Requestable\Resource\Retriever::getRecent
     * @covers Requestable\Resource\Retriever::isFieldValid
     */
    public function testGetRecentInvalidField()
    {
        $retriever = new Retriever($this->dbConnection);

        $this->assertSame([], $retriever->getRecent(1, 100, 'invalid'));
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     * @covers Requestable\Resource\Retriever::getRecent
     * @covers Requestable\Resource\Retriever::isFieldValid
     */
    public function testGetRecentInvalidSort()
    {
        $retriever = new Retriever($this->dbConnection);

        $this->assertSame([], $retriever->getRecent(1, 100, 'requests.id', 'invalid'));
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     * @covers Requestable\Resource\Retriever::getRecent
     * @covers Requestable\Resource\Retriever::isFieldValid
     * @covers Requestable\Resource\Retriever::getOffset
     */
    public function testGetRecentValid()
    {
        $retriever = new Retriever($this->dbConnection);

        $this->assertSame(2, count($retriever->getRecent(2)));
    }
}
