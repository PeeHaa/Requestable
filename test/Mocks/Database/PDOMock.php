<?php

namespace RequestableTest\Mocks\Database;

class PDOMock extends \PDO
{
    public function __construct($dsn, $user, $pass)
    {
    }

    public function prepare($statement, $options = null)
    {
        return new PDOStatementMock();
    }

    public function lastInsertId($seqname = null)
    {
        return 10;
    }
}
