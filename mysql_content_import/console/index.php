<?php

//use workers\Books as Books;
//require_once 'Books.php';
use workers\Uniques;
use workers\Books;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/21/17
 * Time: 11:27 AM
 */

echo "\n### Database ####\n";
echo "### Connecting ###\n";
require_once('local.conf');

$conn = mysqli_connect(
    $conf['mysql']['host'],
    $conf['mysql']['user'],
    $conf['mysql']['password'],
    $conf['mysql']['database']) or die ('CAN NOT CONNECT TO DB');

echo "### Connection done ###\n";
echo "### Database done ###\n\n";
//$sql = 'SELECT * FROM music ORDER BY id DESC LIMIT 1';
//$result = mysqli_query($conn, $sql);
//$data = mysqli_fetch_all($result);
//var_dump($data);


/**
 * m => media type
 * l => limit per requests
 */
$options = "";
$longOptions = ['media-type:','limit::'];
$params = getopt($options, $longOptions);
$validMediaTypes = ['books','movies','songs','audiobooks','games','uniques'];
if (
    !array_key_exists('media-type', $params)
    || (array_key_exists('media-type', $params) && !in_array($params['media-type'], $validMediaTypes))
) {
    $message = 'wrong or missing argument media-type';
    error_log($message);
    exit(1);
}

echo "### Main process start ###\n";
echo "### Proceeding with media type " . $params['media-type'] . " ###\n";
$limit = (array_key_exists('limit', $params)) ?
    $params['limit']:null;

try {
    $className = ucfirst($params['media-type']);
    $class = new $className($conn, $limit);
    $class->process();
    echo "### " . $params['media-type'] . " data sampling done ###\n";
    exit(0);
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(1);
}
