<?php
/**
 * Example environment file
 *
 * This file sets up the environment under which the application runs
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);

$settings = [
    'dbDsn'    => 'pgsql:dbname=requestable;host=127.0.0.1',
    'dbUser'   => 'awesomeuser',
    'dbPass'   => 'awesomepass',
    'gaCode'   => '1234567890',
    'gaDomain' => 'example.com',
];
