<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/record.css">
    <title>Breakout-Record</title>
    <style>
        .bar {
            height: 20px;
            background-color: #A6E22E;
            animation-name: barFrame;
            animation-duration: 2s;
            transform-origin: left;
        }

        @keyframes barFrame {
            0% {
                transform: scaleX(0);
            }
            100% {
                transform: scaleX(1.0);
            }
        }

        .total {
            height: 20px;
            animation-name: barFrame;
            animation-duration: 2s;
            transform-origin: center;
        }
    </style>
</head>

<body>
    <h1>Record</h1>
    <a href="index.php">INDEX</a>
    <br>
    <br>

    <?php 
    $dbhost = 'localhost';
    $dbname = 'mongo_breakout';
    
    $mongoClient = new MongoClient('mongodb://' . $dbhost);
    
    $db = $mongoClient->$dbname;
    $cUsers = $db->users;

    $doc = $cUsers->find();
    foreach ($doc as $id => $value) {

        $total = (int)$value["win"] + (int)$value["lose"];

        echo "<fieldset><legend>" . $id . "</legend>";

        echo "Last Login: " . date("Y-m-d H:i:s", $value["lastloginTS"]) . "(UTC)<br>";

        $winPercent = $value["win"] / $total * 100;
        echo "Win " . $value["win"] . " - " . $value["lose"] . " Lose<br>";
        echo '<div style="width:' . $total * 50 . 'px; background:linear-gradient(90deg,#7FBA00 ' . $winPercent . '%,#F74E1E ' . (1 - $winPercent) . '%); " class="total"></div>';

        echo "Win : " . $value["win"] . "<br>";
        echo '<div style="width: ' . $value["win"] * 20 . 'px" class="bar"></div>';
        echo "Lose: " . $value["lose"] . "<br>";
        echo '<div style="width: ' . $value["lose"] * 20 . 'px" class="bar"></div>';


        echo "Total Score: " . $value["totalScore"] . "<br>";
        echo '<div style="width: ' . $value["totalScore"] * 2 . 'px" class="bar"></div>';
        echo "Total Play Time: " . $value["totalPlayTime"] . "<br>";
        echo '<div style="width: ' . $value["totalPlayTime"] * 2 . 'px" class="bar"></div>';

        //var_dump($value);

        echo "</fieldset>";
    }
    ?>
</body>

</html>