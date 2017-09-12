<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>Breakout</title>
    <?php 
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:index.php");
    }
    ?>
</head>

<body>
    <canvas class="canvas"></canvas>

    <script src="js/main.js"></script>
    
    <script>
        var username = <?php echo '"' . $_SESSION["username"] .'"'; ?>;
        var lastloginTS = <?php echo '"' . $_SESSION["loginTS"] .'"'; ?>;
        console.log(username);

        let putUrl = "php/putmongo.php";
        let getUrl = "php/getmongo.php";

        $.post(getUrl, {"_id": username})
        .done((response) => {
            var userData = JSON.parse(response);
            console.log(userData);
            if(!userData) {
                $.post(putUrl, {
                    "_id": username,
                    "lastloginTS": lastloginTS,
                    "win": 0,
                    "lose": 0,
                    "totalScore": 0,
                    "totalPlayTime": 0,
                }).done((res) => {
                    console.log(res);
                });
            }
        });

    </script>
</body>

</html>