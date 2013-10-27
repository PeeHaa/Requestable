<?php
/**
 * This bootstraps the Requestable application
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

use Requestable\Storage\ImmutableArray;
use Requestable\Network\Http\Request;
use Requestable\Data\Request as RequestData;
use Requestable\Network\Client\Curl;
use Requestable\Network\Client\Exception;

/**
 * Bootstrap the Requestable library
 */
require_once __DIR__ . '/src/Requestable/bootstrap.php';

/**
 * Setup the request object
 */
$request = new Request(
    new ImmutableArray($_GET),
    new ImmutableArray($_POST),
    new ImmutableArray($_SERVER),
    new ImmutableArray($_FILES)
);

if ($request->post('uri') !== null) {
    $requestData = new RequestData($request);
    $client      = new Curl($requestData);

    try {
        $requestInfo = $client->run();
    } catch(Exception $e) {
        $error = $e->getMessage();
    }

    ob_start();
    require __DIR__ . '/templates/result.phtml';
    $result = ob_get_contents();
    ob_end_clean();
}

ob_start();
require __DIR__ . '/templates/form.phtml';
$content = ob_get_contents();
ob_end_clean();

require __DIR__ . '/templates/page.phtml';
