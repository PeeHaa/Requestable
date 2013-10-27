<?php
/**
 * Interface for HTTP clients
 *
 * PHP version 5.4
 *
 * @category   Requestable
 * @package    Network
 * @subpackage Client
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Requestable\Network\Client;

/**
 * Interface for HTTP clients
 *
 * @category   Requestable
 * @package    Network
 * @subpackage Client
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Client
{
    /**
     * Makes the request to the external service
     *
     * @returns array The headers and body of the response
     * @throws \Requestable\Network\Client\CurlException When the request failed
     */
    public function run();
}
