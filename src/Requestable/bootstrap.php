<?php
/**
 * This bootstraps the Requestable library
 *
 * PHP version 5.4
 *
 * @category   Requestable
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Requestable;

use Requestable\Core\Autoloader;

/**
 * Setup the library autoloader
 */
require_once __DIR__ . '/Core/Autoloader.php';

$autoloader = new Autoloader(__NAMESPACE__, dirname(__DIR__));
$autoloader->register();
