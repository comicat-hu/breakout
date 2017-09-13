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

    $postData = $_POST;
    if (!empty($postData)) {
        if (isset($postData["username"])) {
            $username = convertInput($_POST["username"]);
            if (strlen($username) > 0) {
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["loginTS"] = time();
                header("location:main.php");
            }
        }
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
    
    ?>
</body>

</html>