<?php
/** @var $db */
require_once "database.php";
session_start();

//Checks if the user is logged in
//If admin is not in this session
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}


//Get username from session
$username = $_SESSION['loggedInUser']['username'];

//Get the record from the database result
$query = "SELECT * FROM reservation";
$result = mysqli_query($db, $query);

$reserv = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reserv[] = $row;
}
//close the database
mysqli_close($db);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="rese.css"/>
    <title>Barbershop DLC</title>
</head>
<body>
<h1>Reserveringen</h1>
<table>
    <thead>
    <tr>
        <th>Naam</th>
        <th>Email</th>
        <th>Telefoonnummer</th>
        <th>Datum en tijd</th>
        <th>Opmerking</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="6">DLC</td>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($reserv as $reservations) {?>
        <tr>
            <td><?= $reservations['name'] ?></td>
            <td><?= $reservations['email'] ?></td>
            <td><?= $reservations['phone'] ?></td>
            <td><?= $reservations['dati'] ?></td>
            <td><?= $reservations['comment'] ?></td>
            <td><a href="delete.php?id=<?= $reservations['ID'] ?>">Delete</a></td>
            <td><a href="edit.php?id=<?= $reservations['ID'] ?>">Edit</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<p><a href="home.html">Home</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>

