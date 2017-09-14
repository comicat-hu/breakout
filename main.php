<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script 
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <link rel="stylesheet" href="css/main.css">
    <title>Breakout</title>
    <?php
    /**
     * PHP version 5.6.31
     * Check SESSION username isset
     *
     * @category None
     * @package  None
     * @author   comi.hu <comi.hu@104.com.tw>
     * @license  PHP License
     * @link     None
     */
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:index.php");
    }
    ?>
</head>

<body>
    <header>
        <h3>
            <a href="index.php">Index</a>
            <a href="record.php">Record</a>
        </h3>
    </header>

    <canvas class="canvas"></canvas>

    <script src="js/main.js"></script>
    
    <script>
        var username = <?php echo '"' . $_SESSION["username"] .'"'; ?>;
        var lastloginTS = <?php echo '"' . $_SESSION["loginTS"] .'"'; ?>;

        let putUrl = "php/putmongo.php";
        let getUrl = "php/getmongo.php";

        $.post(getUrl, {"_id": username})
        .done((response) => {

            var userData = JSON.parse(response);

            if(userData && userData.errmsg) {
                return alert(userData.errmsg);
            }
            
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
                })
                .fail(() => {
                    alert("put fail");
                });
            }
        })
        .fail(() => {
            alert("get fail");
        });

    </script>
</body>

</html>