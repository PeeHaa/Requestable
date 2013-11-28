<?php
/**
 * Interface for resource identifier converters
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
 * Interface for resource identifier converters
 *
 * @category   Requestable
 * @package    Resource
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Converter
{
    /**
     * Converts hashed ids to plain ids
     *
     * @param string $id The hashed id
     *
     * @return id The plain id
     */
    public function toPlain($id);

    /**
     * Converts plain ids to hashes ids
     *
     * @param string $id The plain id
     *
     * @return id The hashed id
     */
    public function toHash($id);
}
