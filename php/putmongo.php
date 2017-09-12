<?php
/**
 * PHP version 5.6.31
 */

$dbhost = 'localhost';
$dbname = 'mongo_breakout';

$mongoClient = new MongoClient('mongodb://' . $dbhost);

$db = $mongoClient->$dbname;
$cUsers = $db->users;

if ($_POST) {
    echo json_encode($cUsers->save($_POST));
}