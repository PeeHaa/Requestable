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
use Requestable\Resource\Identifier;
use Requestable\Resource\Storer;
use Requestable\Resource\Retriever;
use Requestable\Data\Post;
use Requestable\Data\Get;
use Requestable\Network\Client\Curl;
use Requestable\Network\Client\Exception;

/**
 * Bootstrap the Requestable library
 */
require_once __DIR__ . '/src/Requestable/bootstrap.php';

/**
 * Load the environment specific settings
 */
require_once __DIR__ . '/init.deployment.php';

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
 * Handle CORS
 */
if ($request->server('HTTP_ORIGIN') !== null) {
    header('Access-Control-Allow-Origin: *');
}

if ($request->getMethod() === 'OPTIONS') {
    if ($request->server('HTTP_ACCESS_CONTROL_REQUEST_METHOD')) {
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    }

    if ($request->server('HTTP_ACCESS_CONTROL_REQUEST_HEADERS')) {
        header('Access-Control-Allow-Headers: ' . $request->server('HTTP_ACCESS_CONTROL_REQUEST_HEADERS'));
    }

    exit;
}

/**
 * Setup the id converter
 */
$identifier = new Identifier();

/**
 * Setup the database connection
 */
$dbConnection = new \PDO(
    $settings['dbDsn'],
    $settings['dbUser'],
    $settings['dbPass'],
    [
        \PDO::ATTR_EMULATE_PREPARES   => false,
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ]
);

/**
 * Check if access is through api to prefix the path with the API identifier
 */
$apiPrefix = '';
if ($request->getPath() === '/api') {
    $apiPrefix = '/api';
}

/**
 * Parse the request data
 */
if ($request->getPath() === '/about') {
    ob_start();
    require __DIR__ . '/templates/about.phtml';
    $content = ob_get_contents();
    ob_end_clean();
} elseif ($request->getPath() === '/recent') {
    $storage        = new Retriever($dbConnection);
    $recentRequests = $storage->getRecent(1, 100);

    ob_start();
    require __DIR__ . '/templates/recent.phtml';
    $content = ob_get_contents();
    ob_end_clean();
} elseif ($request->post('uri') !== null) {
    $requestData = new Post($request);
    $storage     = new Storer($requestData, $dbConnection);

    header('Location: ' . $request->getBaseUrl() . $apiPrefix .'/' . $identifier->toHash($storage->save()));
    exit;
} elseif ($request->get('uri') !== null) {
    $requestData = new Get($request);
    $storage     = new Storer($requestData, $dbConnection);

    header('Location: ' . $request->getBaseUrl() . $apiPrefix .'/' . $identifier->toHash($storage->save()));
    exit;
} elseif (!in_array($request->getPath(), ['', '/'], true)) {
    $path  = trim($request->getPath(), '/ ');
    $parts = explode('/', $path);
    $hash  = strpos($request->getPath(), '/api') === 0 ? $parts[1] : $parts[0];

    $storage     = new Retriever($dbConnection);
    $requestData = $storage->getRequest($identifier->toPlain($hash));
}

/**
 * Fire the request to the webservice
 */
if (isset($requestData)) {
    $client = new Curl($requestData);

    try {
        $requestInfo = $client->run();
    } catch(\Exception $e) {
        $error = $e->getMessage();
    }
} else {
    $requestData = new Post($request);
}

/**
 * Get the result
 */
if (isset($client)) {
    if (strpos($request->getPath(), '/api') === 0) {
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

        echo json_encode([
            'result' => $result,
            'hash'   => $hash,
        ]);
        exit;
    }
}


/**
 * Load the form template
 */
if (!isset($content)) {
    ob_start();
    require __DIR__ . '/templates/form.phtml';
    $content = ob_get_contents();
    ob_end_clean();
}

/**
 * Render the response
 */
require __DIR__ . '/templates/page.phtml';
