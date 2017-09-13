<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/record.css">
    <title>Breakout-Record</title>
    <style>

    </style>
</head>

<body>
    <header>
        <h1>Record</h1>
        <h3><a href="index.php">Back Index</a></h3>
    </header>
    <form action="record.php" method="post">
        <label>Sort By</label>
        <select name="sortBy" onchange="this.form.submit();">
            <option value="lastloginTS">Last Login</option>
            <option value="totalPlayTime" <?php echo (isset($_POST['sortBy']) && $_POST['sortBy'] === 'totalPlayTime') ? 'selected' : ''; ?> >Total Play Time</option>
            <option value="win" <?php echo (isset($_POST['sortBy']) && $_POST['sortBy'] === 'win') ? 'selected' : ''; ?> >Win</option>
            <option value="lose" <?php echo (isset($_POST['sortBy']) && $_POST['sortBy'] === 'lose') ? 'selected' : ''; ?> >Lose</option>
            <option value="_id" <?php echo (isset($_POST['sortBy']) && $_POST['sortBy'] === '_id') ? 'selected' : ''; ?> >Username</option>
        </select>
        <select name="order" onchange="this.form.submit();">
            <option value="-1">Asc</option>
            <option value="1" <?php echo (isset($_POST['order']) && $_POST['order'] === '1') ? 'selected' : ''; ?> >Desc</option>
        </select>
    </form>
    <?php require 'php/allrecord.php' ?>
</body>

</html>