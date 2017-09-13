<?php 
/**
 * PHP version 5.6.31
 * MongoDB findOne use $_POST query
 *
 * @category None
 * @package  None
 * @author   comi.hu <comi.hu@104.com.tw>
 * @license  PHP License
 * @link     None
 */
$config = include 'config.php';
$dbhost = $config['dbhost'];
$dbname = $config['dbname'];

$mongoClient = new MongoClient('mongodb://' . $dbhost);

$db = $mongoClient->$dbname;
$cUsers = $db->users;

if ($_POST) {
    echo json_encode($cUsers->findOne($_POST));
}