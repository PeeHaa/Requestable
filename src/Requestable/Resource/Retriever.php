<?php
/**
 * Retrieves requests
 *
 * PHP version 5.4
 *
 * @category   Requestable
 * @package    Resource
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Requestable\Resource;

use Requestable\Data\Storage;

/**
 * Retrieves requests
 *
 * @category   Requestable
 * @package    Resource
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Retriever implements Retrievable
{
    /**
     * @var int The id of the request
     */
    private $id;

    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * Creates instance
     *
     * @param int  $id           The id of the request
     * @param \PDO $dbConnection The database connection
     */
    public function __construct($id, \PDO $dbConnection)
    {
        $this->id           = $id;
        $this->dbConnection = $dbConnection;
    }

    /**
     * Gets the request from the storage
     *
     * @return \Requestable\Data\Storage The request
     */
    public function getRequest()
    {
        $query = 'SELECT requests.id, requests.uri, requests.version, requests.method, requests.follow,';
        $query.= ' requests.cookies, requests.body, requestheaders.header';
        $query.= ' FROM requests';
        $query.= ' LEFT JOIN requestheaders ON requestheaders.requestid = requests.id';
        $query.= ' WHERE requests.id = :id';
        $query.= ' ORDER BY requestheaders.id';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            'id' => $this->id,
        ]);

        return new Storage($stmt->fetchAll());
    }
}
