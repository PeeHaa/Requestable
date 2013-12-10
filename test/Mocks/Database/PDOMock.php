<?php

namespace RequestableTest\Mocks\Database;

class PDOMock extends \PDO
{
    public function __construct($dsn, $user, $pass)
    {
    }

    public function query()
    {
        return [
            [
                'id'      => 1,
                'uri'     => 'https://pieterhordijk.com',
                'method'  => 'POST',
                'follow'  => true,
                'cookies' => true,
                'body'    => 'The body',
                'header'  => 'Header1: Content',
            ],
            [
                'id'      => 2,
                'uri'     => 'https://google.com',
                'method'  => 'POST',
                'follow'  => true,
                'cookies' => true,
                'body'    => 'The body',
                'header'  => null,
            ],
        ];
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
