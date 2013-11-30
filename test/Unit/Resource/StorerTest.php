<?php

namespace RequestableTest\Unit\Resource;

use Requestable\Resource\Storer;
use RequestableTest\Mocks\Database\PDOMock;

class StorerTest extends \PHPUnit_Framework_TestCase
{
    private $dbConnection;

    public function setUp()
    {
        $this->dbConnection = new PDOMock('dsn', 'user', 'pass');
    }

    /**
     * @covers Requestable\Resource\Storer::__construct
     */
    public function testConstructCorrectInterface()
    {
        $storer = new Storer($this->getMock('\\Requestable\\Data\\Request'), $this->dbConnection);

        $this->assertInstanceOf('\\Requestable\\Resource\\Storable', $storer);
    }

    /**
     * @covers Requestable\Resource\Storer::__construct
     */
    public function testConstructCorrectInstance()
    {
        $storer = new Storer($this->getMock('\\Requestable\\Data\\Request'), $this->dbConnection);

        $this->assertInstanceOf('\\Requestable\\Resource\\Storer', $storer);
    }

    /**
     * @covers Requestable\Resource\Storer::__construct
     * @covers Requestable\Resource\Storer::save
     * @covers Requestable\Resource\Storer::saveRequest
     * @covers Requestable\Resource\Storer::saveRequestHeaders
     */
    public function testSaveWithoutHeaders()
    {
        $storer = new Storer($this->getMock('\\Requestable\\Data\\Request'), $this->dbConnection);

        $this->assertSame(10, $storer->save());
    }

    /**
     * @covers Requestable\Resource\Storer::__construct
     * @covers Requestable\Resource\Storer::save
     * @covers Requestable\Resource\Storer::saveRequest
     * @covers Requestable\Resource\Storer::saveRequestHeaders
     */
    public function testSaveWithHeaders()
    {
        $request = $this->getMock('\\Requestable\\Data\\Request');
        $request->expects($this->any())->method('getHeaders')->will($this->returnValue([
            'header1' => ['value1', 'value2'],
            'header2' => ['value1'],
        ]));

        $storer = new Storer($request, $this->dbConnection);

        $this->assertSame(10, $storer->save());
    }
}
