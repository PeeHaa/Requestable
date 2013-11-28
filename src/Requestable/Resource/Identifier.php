<?php
/**
 * Resource identifier converter
 *
 * Converts ids in URI to resources
 * http://stackoverflow.com/questions/5422065/php-random-url-names-short-url
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
 * Resource identifier converter
 *
 * @category   Requestable
 * @package    Resource
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Identifier implements Converter
{
    /**
     * @var string Pool of characters that are allowed in the hashes
     */
    const POOL = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var string Prefix for ids to make longer hashes
     */
    const PREFIX = '214748';

    /**
     * Converts hashed ids to plain ids
     *
     * @param string $id The hashed id
     *
     * @return id The plain id
     */
    public function toPlain($id)
    {
        $in  = strrev($id);
        $result = 0;
        $len = strlen($id) - 1;

        for ($i = 0; $i <= $len; $i++) {
            $bcpow = bcpow(strlen(self::POOL), $len - $i);
            $result += strpos(self::POOL, substr($in, $i, 1)) * $bcpow;
        }

        $result = sprintf('%F', $result);
        return (int) substr($result, strlen(self::PREFIX), strpos($result, '.'));
    }

    /**
     * Converts plain ids to hashes ids
     *
     * @param string $id The plain id
     *
     * @return id The hashed id
     */
    public function toHash($id)
    {
        $id  = self::PREFIX . $id;

        $result = '';
        for ($i = floor(log($id, strlen(self::POOL))); $i >= 0; $i--) {
            $bcp     = bcpow(strlen(self::POOL), $i);
            $a       = floor($id / $bcp) % strlen(self::POOL);
            $result .= substr(self::POOL, $a, 1);
            $id     -= ($a * $bcp);
        }

        return strrev($result);
    }
}
