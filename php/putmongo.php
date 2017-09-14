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

try {
    $mongoClient = new MongoClient('mongodb://' . $dbhost);
} catch (Exception $e) {
    echo json_encode(array('errmsg' => 'Failed connect to db.'));
    exit;
}

$db = $mongoClient->$dbname;
$cUsers = $db->users;

if (!empty($_POST)) {

    $postData = $_POST;

    try {
        $dataToSave = array(
            '_id' => (string)$postData['_id'],
            'lastloginTS' => (int)$postData['lastloginTS'],
            'win' => (int)$postData['win'],
            'lose' => (int)$postData['lose'],
            'totalScore' => (int)$postData['totalScore'],
            'totalPlayTime' => (int)$postData['totalPlayTime'],
        );
    } catch (Exception $e) {
        echo json_encode(array('errmsg' => 'valid _id.'));
        exit;
    }

    echo json_encode($cUsers->save($dataToSave));
}