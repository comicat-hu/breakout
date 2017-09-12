<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <title>Breakout</title>
    <?php session_start(); ?>
</head>

<body>
    <form action="index.php" method="post">
        <!-- <label>Name: </label> -->
        <input type="text" name="username" placeholder="Name" class="username" required>
        <br><br>
        <input type="submit" name="submit" value="START" class="submit"><br>
        <a href="record.php">RECORD</a>
        
    </form>

    <?php
    if ($_POST) {
        $username = htmlspecialchars($_POST["username"]);
        $_SESSION["username"] = $username;
        $_SESSION["loginTS"] = time();
        header("location:main.php");
    }
    ?>
</body>

</html>