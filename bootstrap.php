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
use Requestable\Data\Post;
use Requestable\Data\Get;
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

/**
 * Parse the request data
 */
if ($request->post('uri') !== null) {
    $requestData = new Post($request);
} elseif ($request->get('uri') !== null) {
    $requestData = new Get($request);
}

/**
 * Fire the request to the webservice
 */
if (isset($requestData)) {
    $client = new Curl($requestData);

    try {
        $requestInfo = $client->run();
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}

/**
 * Get the result
 */
if (isset($client)) {
    if ($request->getPath() === '/api') {
        header('Content-Type: application/json');
        require __DIR__ . '/templates/result.pjson';
        exit;
    }

    ob_start();
    require __DIR__ . '/templates/result.phtml';
    $result = ob_get_contents();
    ob_end_clean();

    if ($request->isXhr()) {
        header('Content-Type: application/json');
        echo json_encode(['result' => $result]);
        exit;
    }
}

/**
 * Load the form template
 */
ob_start();
require __DIR__ . '/templates/form.phtml';
$content = ob_get_contents();
ob_end_clean();

/**
 * Render the response
 */
require __DIR__ . '/templates/page.phtml';
