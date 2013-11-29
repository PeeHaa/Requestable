<?php
/**
 * Interface for classes that store requests
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
 * Interface for classes that store requests
 *
 * @category   Requestable
 * @package    Resource
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Storable
{
    /**
     * Persists the entire request in the database and get the id
     *
     * @return int The id of the stored request
     */
    public function save();
}
