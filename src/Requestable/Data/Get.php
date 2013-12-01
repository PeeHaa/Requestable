<?php
/**
 * Parses the data of the request to create an object containing all the info to fire requests to services
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

use Requestable\Network\Http\RequestData;

/**
 * Parses the data of the request to create an object containing all the info to fire requests to services
 *
 * @category   Requestable
 * @package    Data
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Get implements Request
{
    /**
     * @var \Requestable\Network\Http\RequestData The data of the request
     */
    private $request;

    /**
     * Creates instance
     *
     * @param \Requestable\Network\Http\RequestData $request The data of the request
     */
    public function __construct(RequestData $request)
    {
        $this->request = $request;
    }

    /**
     * Gets the URI supplied by the user
     *
     * @return string The URI supplied by the user
     */
    public function getUri()
    {
        return $this->request->get('uri');
    }

    /**
     * Gets the HTTP version supplied by the user
     *
     * @return string The HTTP version supplied by the user
     */
    public function getVersion()
    {
        if ($this->request->get('version') === null) {
            return '1.1';
        }

        return $this->request->get('version');
    }

    /**
     * Gets the method supplied by the user
     *
     * @return string The method supplied by the user
     */
    public function getMethod()
    {
        if ($this->request->get('custommethod')) {
            return strtoupper($this->request->get('custommethod'));
        }

        return strtoupper($this->request->get('method'));
    }

    /**
     * Gets whether redirects needs to be followed
     *
     * @return boolean Whether redirects needs to be followed
     */
    public function redirectsEnabled()
    {
        if ($this->request->get('follow')) {
            return true;
        }

        return false;
    }

    /**
     * Gets whether cookies are enabled
     *
     * @return boolean Whether cookies are enabled
     */
    public function cookiesEnabled()
    {
        if ($this->request->get('cookies')) {
            return true;
        }

        return false;
    }

    /**
     * Gets the headers supplied by the user
     *
     * @return array The headers supplied by the user
     */
    public function getHeaders()
    {
        if (!$this->request->get('headers')) {
            return [];
        }

        $headers = [];
        foreach (preg_split('/\r?\n(?![ \t])/', $this->request->get('headers'), -1, PREG_SPLIT_NO_EMPTY) as $header) {
            list($key, $val) = preg_split('/\s*:\s*/', $header, 2);
            $headers[strtolower($key)][] = $val;
        }
        $headers['connection'] = ['close'];

        return $headers;
    }

    /**
     * Gets the body supplied by the user
     *
     * @return string The body supplied by the user
     */
    public function getBody()
    {
        return $this->request->get('body');
    }
}
