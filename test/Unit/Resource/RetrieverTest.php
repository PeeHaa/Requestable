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
        $retriever = new Retriever(1, $this->dbConnection);

        $this->assertInstanceOf('\\Requestable\\Resource\\Retrievable', $retriever);
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     */
    public function testConstructCorrectInstance()
    {
        $retriever = new Retriever(1, $this->dbConnection);

        $this->assertInstanceOf('\\Requestable\\Resource\\Retriever', $retriever);
    }

    /**
     * @covers Requestable\Resource\Retriever::__construct
     * @covers Requestable\Resource\Retriever::getRequest
     */
    public function testGetRequest()
    {
        $retriever = new Retriever(1, $this->dbConnection);

        $this->assertInstanceof('\\Requestable\\Data\\Storage', $retriever->getRequest());
    }
}
