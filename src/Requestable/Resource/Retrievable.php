<?php
/**
 * Interface for classes that retrieve requests
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

/**
 * Interface for classes that retrieve requests
 *
 * @category   Requestable
 * @package    Resource
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Retrievable
{
    /**
     * Gets the request from the storage
     *
     * @param int $id The id of the request
     *
     * @return \Requestable\Data\Storage The request
     */
    public function getRequest($id);
}
