<?php
/** @var $db */
require_once "database.php";

//Get record from the database
$query = "SELECT * FROM `reservation` WHERE ID =( SELECT MAX(ID) from reservation)";
$result = mysqli_query($db, $query) or die ('Error: ' . $query);
$reserv = mysqli_fetch_assoc($result);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservering <?= $reserv['name'] ?></title>
    <link rel="stylesheet" type="text/css" href="rese.css"/>
</head>
<body>
<h2>Reservering geslaagd</h2>
<form action="" method="post">
    <p>
       De reservering voor "<?= $reserv['name'] ?>" is aangemaakt?
    </p>
    <p>
        Controleer of al uw gegevens goed ingevuld zijn.
    </p>
    <div><p>Naam: <?= $reserv['name'] ?></p>
    <p>Email: <?= $reserv['email'] ?></p>
    <p>Telefoonnummer: <?= $reserv['phone'] ?></p>
    <p>Datum en Tijd: <?= $reserv['dati'] ?></p>
    <p>Opmerking: <?= $reserv['comment'] ?></p></div>
    <input type="hidden" name="id" value="<?= $reserv['ID'] ?>"/>
    <div>
        <a href="home.html">Ga terug</a>
    </div>
</form>
</body>
</html>

