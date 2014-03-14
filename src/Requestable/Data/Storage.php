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
     * Gets the URI supplied by the user
     *
     * @return string The URI supplied by the user
     */
    public function getVersion()
    {
        return $this->recordset[0]['version'];
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

    /**
     * Gets whether to verify the peer's certificate.
     *
     * @return boolean Whether to verify the peer's certificate
     */
    public function verifyPeer()
    {
        return $this->recordset[0]['verifypeer'];
    }

    /**
     * Gets whether to check the existence of a common name and also verify that it matches the hostname provided
     *
     * @return boolean Whether to check the existence of a common name and also
     *                 verify that it matches the hostname provided
     */
    public function verifyHost()
    {
        return $this->recordset[0]['verifyhost'];
    }

    /**
     * Gets the SSL version
     *
     * @return string|int The SSL version
     */
    public function getSslVersion()
    {
        return $this->recordset[0]['sslversion'];
    }

    /**
     * Gets the custom ca bundle
     *
     * @return null|string The custom ca bundle
     */
    public function getCaBundle()
    {
        return null;
    }

    /**
     * Gets the optional password to protect requests
     *
     * @return null|string The password to protect the request
     */
    public function getPassword()
    {
        if ($this->recordset[0]['protected']) {
            return $this->recordset[0]['protected'];
        }

        return false;
    }
}
