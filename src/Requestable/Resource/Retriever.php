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
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * Creates instance
     *
     * @param \PDO $dbConnection The database connection
     */
    public function __construct(\PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Gets the request from the storage
     *
     * @param int $id The id of the request
     *
     * @return \Requestable\Data\Storage The request
     */
    public function getRequest($id)
    {
        $query = 'SELECT requests.id, requests.uri, requests.version, requests.method, requests.follow,';
        $query.= ' requests.cookies, requests.body, requests.verifypeer, requests.verifyhost, requests.sslversion,';
        $query.= ' requests.cabundle, requestheaders.header';
        $query.= ' FROM requests';
        $query.= ' LEFT JOIN requestheaders ON requestheaders.requestid = requests.id';
        $query.= ' WHERE requests.id = :id';
        $query.= ' ORDER BY requestheaders.id';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            'id' => $id,
        ]);

        return new Storage($stmt->fetchAll());
    }

    /**
     * Gets the most recent requests
     *
     * @param int    $page      The page number from where to start the offset
     * @param int    $size      The size of the page (number of items on the page)
     * @param string $field     The field to sort on
     * @param string $direction The direction to sort on
     *
     * @return array Collection of requests
     */
    public function getRecent($page, $size = 100, $field = 'requests.id', $direction = 'DESC')
    {
        if (!$this->isFieldValid($field) || !in_array($direction, ['ASC', 'DESC'], true)) {
            return [];
        }

        $query = 'SELECT requests.id, requests.uri, requests.version, requests.method, requests.follow,';
        $query.= ' requests.cookies, requests.body, requestheaders.header';
        $query.= ' FROM requests';
        $query.= ' LEFT JOIN requestheaders ON requestheaders.requestid = requests.id';
        $query.= ' ORDER BY ' . $field . ' ' . $direction;
        $query.= ' LIMIT ' . (int) $size . ' OFFSET ' . $this->getOffset($page, $size);

        $requests = [];
        foreach ($this->dbConnection->query($query) as $record) {
            $requests[$record['id']] = new Storage([$record]);
        }

        return $requests;
    }

    /**
     * Checks the field against the whitelist
     *
     * @param string $field The field to validate
     *
     * @return boolean True when the field is valid
     */
    private function isFieldValid($field)
    {
        $validFields = [
            'requests.id',
            'requests.uri',
            'requests.version',
            'requests.method',
            'requests.follow',
            'requests.cookies',
            'requests.verifyPeer',
            'requests.verifyHost',
            'requests.sslVersion',
            'requests.caBundle',
        ];

        return in_array($field, $validFields, true);
    }

    /**
     * Calculates the starting offset of the recordset
     *
     * @param int $page The page number from where to start the offset
     * @param int $size The size of the page (number of items on the page)
     *
     * @return int The starting offset
     */
    private function getOffset($page, $size)
    {
        return ($page - 1) * $size;
    }
}
