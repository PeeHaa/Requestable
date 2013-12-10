<?php
/**
 * Formats bytes into a human readable format
 *
 * PHP version 5.4
 *
 * @category   Requestable
 * @package    Format
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Requestable\Format;

/**
 * Formats bytes into a human readable format
 *
 * @category   Requestable
 * @package    Format
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Byte
{
    /**
     * @var int The precision of the formatted string
     */
    private $precision;

    /**
     * @var array List of units
     */
    private $units;

    /**
     * Creates instance
     *
     * @param array $precision The precision of the formatted string
     * @param array $units     List of units
     */
    public function __construct($precision = 0, array $units = ['B', 'KB', 'MB', 'GB'])
    {
        $this->precision = $precision;
        $this->units     = $units;
    }

    /**
     * Formats bytes into the human readable format
     *
     * @param int $bytes The number of bytes
     *
     * @return string The human readable formatted bytes
     */
    public function format($bytes)
    {
        foreach ($this->units as $unit) {
            if ($bytes >= 1024) {
                $bytes = $bytes / 1024;

                continue;
            }

            return number_format($bytes, $this->precision) . ' ' . $unit;
        }

        return number_format($bytes, $this->precision) . ' ' . $unit;
    }
}
