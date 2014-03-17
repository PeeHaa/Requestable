<?php
/**
 * Stores requests
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

use Requestable\Data\Request;

/**
 * Stores requests
 *
 * @category   Requestable
 * @package    Resource
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Storer implements Storable
{
    /**
     * @var \Requestable\Data\Request Implementation of request data
     */
    private $request;

    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * Creates instance
     *
     * @param \Requestable\Data\Request $request      Implementation of request data
     * @param \PDO                      $dbConnection The database connection
     */
    public function __construct(Request $request, \PDO $dbConnection)
    {
        $this->request      = $request;
        $this->dbConnection = $dbConnection;
    }

    /**
     * Persists the entire request in the database and get the id
     *
     * @return int The id of the stored request
     */
    public function save()
    {
        return $this->saveRequestHeaders($this->saveRequest());
    }

    /**
     * Perists the request in the database
     *
     * @return int The id of the stored request
     */
    private function saveRequest()
    {
        $query = 'INSERT INTO requests (uri, version, method, follow, cookies, body, verifypeer, verifyhost, sslversion, cabundle, protected)';
        $query.= ' VALUES (:uri, :version, :method, :follow, :cookies, :body, :verifypeer, :verifyhost, :sslversion, :cabundle, :protected)';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            'uri'        => $this->request->getUri(),
            'version'    => $this->request->getVersion(),
            'method'     => $this->request->getMethod(),
            'follow'     => $this->request->redirectsEnabled() ? 't' : 'f',
            'cookies'    => $this->request->cookiesEnabled() ? 't' : 'f',
            'body'       => $this->request->getBody(),
            'verifypeer' => $this->request->verifyPeer() ? 't' : 'f',
            'verifyhost' => $this->request->verifyHost() ? 't' : 'f',
            'sslversion' => $this->request->getSslversion(),
            'cabundle'   => $this->request->getCaBundle(),
            'protected'  => $this->request->getPassword() ? password_hash($this->request->getPassword(), PASSWORD_DEFAULT, ['cost' => 14]) : null,
        ]);

        return $this->dbConnection->lastInsertId('requests_id_seq');
    }

    /**
     * Persists the request headers (if any)
     *
     * @return int The id of request the headers belong to
     */
    private function saveRequestHeaders($requestId)
    {
        if (!$this->request->getHeaders()) {
            return $requestId;
        }

        foreach ($this->request->getHeaders() as $key => $headers) {
            foreach ($headers as $value) {
                $query = 'INSERT INTO requestheaders (requestid, header) VALUES (:requestid, :header)';

                $stmt = $this->dbConnection->prepare($query);
                $stmt->execute([
                    'requestid' => $requestId,
                    'header'    => $key . ': ' . $value,
                ]);
            }
        }

        return $requestId;
    }
}
