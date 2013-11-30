<?php
/**
 * Parses the data of the stored request
 *
 * PHP version 5.4
 *
 * @category   Requestable
 * @package    Data
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Requestable\Data;

/**
 * Parses the data of the stored request
 *
 * @category   Requestable
 * @package    Data
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Storage implements Request
{
    /**
     * @var array The recordset of the request
     */
    private $recordset;

    /**
     * Creates instance
     *
     * @param array $data The recordset of the request
     */
    public function __construct(array $recordset)
    {
        $this->recordset = $recordset;
    }

    /**
     * Gets the URI supplied by the user
     *
     * @return string The URI supplied by the user
     */
    public function getUri()
    {
        return $this->recordset[0]['uri'];
    }

    /**
     * Gets the method supplied by the user
     *
     * @return string The method supplied by the user
     */
    public function getMethod()
    {
        return strtoupper($this->recordset[0]['method']);
    }

    /**
     * Gets whether redirects needs to be followed
     *
     * @return boolean Whether redirects needs to be followed
     */
    public function redirectsEnabled()
    {
        return $this->recordset[0]['follow'];
    }

    /**
     * Gets whether cookies are enabled
     *
     * @return boolean Whether cookies are enabled
     */
    public function cookiesEnabled()
    {
        return $this->recordset[0]['cookies'];
    }

    /**
     * Gets the headers supplied by the user
     *
     * @return array The headers supplied by the user
     */
    public function getHeaders()
    {
        $headers = [];

        foreach ($this->recordset as $record) {
            if ($record['header'] === null) {
                continue;
            }

            list($key, $val) = preg_split('/\s*:\s*/', $record['header'], 2);
            $headers[strtolower($key)][] = $val;
        }

        return $headers;
    }

    /**
     * Gets the body supplied by the user
     *
     * @return string The body supplied by the user
     */
    public function getBody()
    {
        return $this->recordset[0]['body'];
    }
}
