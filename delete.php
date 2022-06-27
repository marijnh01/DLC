<?php
/** @var $db */
require_once "database.php";

session_start();
//checks if admin is logged in
//if admin is not in session
if(!isset($_SESSION['loggedInUser'])){
    //redirects to login page
    header("Location: login.php");
}

// Get the record from the database result
$reseid = $_GET['id'];
$query = "SELECT * FROM reservation WHERE ID = '$reseid'";
$result = mysqli_query($db, $query) or die ('Error: ' . $query);
$reserv = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {

    // Remove the album data from the database with the existing albumId
    $query = "DELETE FROM reservation WHERE ID = " . $reseid;
    $result = mysqli_query($db, $query);

    //Close connection
    mysqli_close($db);

    //Redirect to homepage after deletion & exit script
    header("Location: reservation.php");
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="rese.css"/>
    <title>Verwijder - <?= $reserv['name'] ?></title>
</head>
<body>
<h2>Verwijder - <?= $reserv['name'] ?></h2>
<form action="" method="post">
    <p>
        Weet u zeker dat u de reservering van "<?= $reserv['name'] ?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= $reserv['ID'] ?>"/>
    <input type="submit" name="submit" value="Verwijderen"/>
    <div>
    <a href="reservation.php">Ga terug</a>
    </div>
</form>
</body>
</html>
