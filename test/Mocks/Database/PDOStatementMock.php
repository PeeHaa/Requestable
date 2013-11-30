<?php

namespace RequestableTest\Mocks\Database;

class PDOStatementMock
{
    public function execute(array $data)
    {
    }

    public function fetchAll()
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
                'id'      => 1,
                'uri'     => 'https://pieterhordijk.com',
                'method'  => 'POST',
                'follow'  => true,
                'cookies' => true,
                'body'    => 'The body',
                'header'  => 'Header2: Content',
            ],
        ];
    }
}
