<?php

require_once '../vendor/autoload.php';
//use workers\Books as Books;
//require_once 'Books.php';
//use workers\Uniques;
//use workers\Books;
use Monolog\Logger;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/21/17
 * Time: 11:27 AM
 */

$logger = new Logger('mysql_import');
$logger->addInfo("\n### Database ####\n");
$logger->addInfo("### Connecting ###\n");
require_once('local.conf');

$conn = mysqli_connect(
    $conf['mysql']['host'],
    $conf['mysql']['user'],
    $conf['mysql']['password'],
    $conf['mysql']['database']) or die ('CAN NOT CONNECT TO DB');

$logger->addInfo("### Connection done ###\n");
$logger->addInfo("### Database done ###\n\n");

/**
 * m => media type
 * l => limit per requests
 */
$options = "";
$longOptions = ['media-type:','limit::'];
$params = getopt($options, $longOptions);
$validMediaTypes = ['books','movies','albums','songs','audiobooks','games','uniques'];
if (
    !array_key_exists('media-type', $params)
    || (array_key_exists('media-type', $params) && !in_array($params['media-type'], $validMediaTypes))
) {
    $message = 'wrong or missing argument media-type';
    error_log($message);
    exit(1);
}

$logger->addInfo("### Main process start ###\n");
$logger->addInfo("### Proceeding with media type " . $params['media-type'] . " ###\n");
$limit = (array_key_exists('limit', $params)) ?
    $params['limit']:null;

try {
    $className = 'workers\\' . ucfirst($params['media-type']);
    $class = new $className($conn, $limit);
    $class->process();
    $logger->addInfo("### " . $params['media-type'] . " data sampling done ###");
    $conn->close();
    exit(0);
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(1);
}
