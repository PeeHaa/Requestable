<?php
/**
 * Interface for form data parsers
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
 * Interface for form data parsers
 *
 * @category   Requestable
 * @package    Data
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Request
{
    /**
     * Gets the URI supplied by the user
     *
     * @return string The URI supplied by the user
     */
    public function getUri();

    /**
     * Gets the HTTP version supplied by the user
     *
     * @return string The HTTP version supplied by the user
     */
    public function getVersion();

    /**
     * Gets the method supplied by the user
     *
     * @return string The method supplied by the user
     */
    public function getMethod();

    /**
     * Gets whether redirects needs to be followed
     *
     * @return boolean Whether redirects needs to be followed
     */
    public function redirectsEnabled();

    /**
     * Gets whether cookies are enabled
     *
     * @return boolean Whether cookies are enabled
     */
    public function cookiesEnabled();

    /**
     * Gets the headers supplied by the user
     *
     * @return array The headers supplied by the user
     */
    public function getHeaders();

    /**
     * Gets the body supplied by the user
     *
     * @return string The body supplied by the user
     */
    public function getBody();

    /**
     * Gets whether to verify the peer's certificate.
     *
     * @return boolean Whether to verify the peer's certificate
     */
    public function verifyPeer();

    /**
     * Gets whether to check the existence of a common name and also verify that it matches the hostname provided
     *
     * @return boolean Whether to check the existence of a common name and also
     *                 verify that it matches the hostname provided
     */
    public function verifyHost();

    /**
     * Gets the SSL version
     *
     * @return string|int The SSL version
     */
    public function getSslVersion();

    /**
     * Gets the custom ca bundle
     *
     * @return null|string The custom ca bundle
     */
    public function getCaBundle();
}
