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
    $userData = $cUsers->findOne($postData);
    echo json_encode($userData);
} else {
    echo json_encode(array('errmsg' => 'post data is empty.'));
}

/**
 * Return convert special chars and more spaces
 * 
 * @param string $data input
 * 
 * @return string
 */
function convertInput($data) 
{
    $data = trim($data); // Remove more space
    $data = stripcslashes($data); // Remove "\"
    $data = htmlspecialchars($data); // HTML special chars encode
    return $data;
}