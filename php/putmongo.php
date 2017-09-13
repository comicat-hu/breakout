<?php
/**
 * PHP version 5.6.31
 * MongoDB save $_POST data
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

    $dataToSave = array(
        '_id' => (string)$_POST['_id'],
        'lastloginTS' => (int)$_POST['lastloginTS'],
        'win' => (int)$_POST['win'],
        'lose' => (int)$_POST['lose'],
        'totalScore' => (int)$_POST['totalScore'],
        'totalPlayTime' => (int)$_POST['totalPlayTime'],
    );

    echo json_encode($cUsers->save($dataToSave));
}