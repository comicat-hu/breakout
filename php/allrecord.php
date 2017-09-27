<?php
/**
 * PHP version 5.6.31
 * Find all userdata and show with css graph
 *
 * @category None
 * @package  None
 * @author   comi.hu <comi.hu@104.com.tw>
 * @license  PHP License
 * @link     None
 */

$config = include 'php/config.php';
$dbhost = $config['dbhost'];
$dbname = $config['dbname'];

try {
    $mongoClient = new MongoClient('mongodb://' . $dbhost);
} catch (Exception $e) {
    echo 'Failed connect to db.';
    exit;
}

$db = $mongoClient->$dbname;
$cUsers = $db->users;

$doc = $cUsers->find();

$sortBy = 'lastloginTS';
$order = -1;

if ($_POST) {
    $sortBy = $_POST['sortBy'];
    $order = (int)$_POST['order'];
}

$doc->sort(array($sortBy => $order));

foreach ($doc as $id => $value) {
    $total = (int)$value["win"] + (int)$value["lose"];

    if ($total === 0) {
        continue;
    }
    echo "<fieldset><legend>" . $id . "</legend>";

    $winPercent = $value["win"] / $total * 100;
    echo "Win " . $value["win"] . " - " . $value["lose"] . " Lose<br>";
    echo '<div style="width:' . $total * 50 . 'px;' .
         'background:linear-gradient(90deg,#7FBA00 ' . $winPercent . '%,#F74E1E ' . (1 - $winPercent) . '%); " class="total"></div>';

    echo "Total Score: " . $value["totalScore"] . "<br>";
    echo '<div style="width: ' . $value["totalScore"] * 2 . 'px" class="bar"></div>';
    echo "Total Play Time: " . $value["totalPlayTime"] . "<br>";
    echo '<div style="width: ' . $value["totalPlayTime"] * 2 . 'px" class="bar"></div>';

    echo "Last Login: " . date("Y-m-d H:i:s", $value["lastloginTS"]) . "(UTC)<br>";

    echo "</fieldset>";
}

// Use for fix db data type
// foreach ($doc as $id => $value) {

//     $dataToSave = array(
//         '_id' => (string)$id,
//         'lastloginTS' => (int)$value['lastloginTS'],
//         'win' => (int)$value['win'],
//         'lose' => (int)$value['lose'],
//         'totalScore' => (int)$value['totalScore'],
//         'totalPlayTime' => (int)$value['totalPlayTime'],
//     );

//     echo json_encode($cUsers->save($dataToSave));
// }
