<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css">
    <title>Breakout</title>
</head>

<body>
    <form action="index.php" method="post">
        <input type="text" name="username" placeholder="Name" class="username" required>
        <br><br>
        <input type="submit" name="submit" value="-START-" class="submit"><br>
        <a href="record.php">-RECORD-</a>
    </form>

    <?php

    /**
     * PHP version 5.6.31
     * Check post data and save in session
     *
     * @category None
     * @package  None
     * @author   comi.hu <comi.hu@104.com.tw>
     * @license  PHP License
     * @link     None
     */

    require_once 'php/lib.php';

    $postData = $_POST;
    if (!empty($postData)) {
        if (isset($postData["username"])) {
            $username = convertInput($_POST["username"]);
            if (strlen($username) > 0 && strlen($username) <= 20) {
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["loginTS"] = time();
                header("location:main.php");
            } else {
                echo '<script>alert("valid name");</script>';
            }
        }
    }
    
    ?>

    <script>
        var usernameElement = document.querySelector(".username");
        usernameElement.addEventListener('keyup', () => {
            var username = usernameElement.value;
            console.log(username);
            if(username.length > 20) {
                usernameElement.value = usernameElement.value.substr(0, 20);
            }
        });
    </script>
</body>

</html>