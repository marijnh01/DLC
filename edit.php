<?php
/** @var mysqli $db */
//Require database in this file
require_once "database.php";

//checks if admin is logged in
//if admin is not in session
session_start();
if(!isset($_SESSION['loggedInUser'])){
    header("location: login.php");
}
//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $id = $_GET['id'];
    $name   = mysqli_escape_string($db, $_POST['name']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $phone  = mysqli_escape_string($db, $_POST['phone']);
    $dati = mysqli_escape_string($db, $_POST['dati']);
    $comment = mysqli_escape_string($db, $_POST['comment']);

    //Require the form validation handling
    require_once "form-validations.php";

    //Save variables to array
    $reservations = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'dati' => $dati,
        'comment' => $comment,
    ];

    if (empty($errors)) {
        //Save the record to the database
        $query = "UPDATE reservation
                  SET name = '$name', email = '$email', phone ='$phone', dati ='$dati', comment = '$comment'
                  WHERE ID = '$id'";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);



        if ($result) {
            header('Location: reservation.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }
}
//if submit is not pressed/page is loaded for the first time
// if there is an id in url
else if (isset($_GET['id'])) {
    //Retrieve the id from url
    $id = $_GET['id'];

    //query to get reservation from the database
    $query = "SELECT * FROM reservation WHERE ID = " . mysqli_escape_string($db, $id);
    //runs query in database and puts result in $result
    $result = mysqli_query($db, $query);

    //if there is exactly 1 result
    if (mysqli_num_rows($result) == 1) {
        //fetches data and put in $reservations to read data
        $reservations = mysqli_fetch_assoc($result);

    }
    //if there is not exactly 1 result
    else {
        // redirect to admin
        header('Location: reservation.php');
        exit;
    }
}
//if there is no id in url
else {
    //redirect to admin
    header('Location: reservation.php');
    exit;
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit reservering <?= $id ?></title>
    <link rel="stylesheet" href="rese.css">
</head>
<body>
<div class = "item">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="subtitle">
            <div class = "centerTextAlign">
                <h1>Reservering ID <?= $id ?></h1>
            </div>
        </div>
        <br>
        <div class="rules">
            <div class="centerTextAlign">
               <h2>Edit</h2>
                <br>
                <br>
                <span><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
                <input class="center-block" type="text" name="name" value="<?= htmlentities($reservations['name']) ?>"><br>

                <span><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
                <input class="center-block" type="text" name="email" value="<?= htmlentities($reservations['email']) ?>"><br>

                <span><?= isset($errors['phone']) ? $errors['phone'] : '' ?></span>
                <input class="center-block" type="text" name="phone" value="<?= htmlentities($reservations['phone']) ?>"><br>

                <span><?= isset($errors['dati']) ? $errors['dati'] : '' ?></span>
                <input class="center-block" type="datetime-local" name="dati" value="<?= htmlentities($reservations['dati']) ?>"><br>

                <span><?= isset($errors['comment']) ? $errors['comment'] : '' ?></span><br>
                <input class="center-block" type="text" name="comment" value="<?= htmlentities($reservations['comment']) ?>"><br>
            </div>
        </div>
        <br>
        <br>
        <div class="centerTextAlign"
            <input type="hidden" name="ID" value="<?= $id ?>"/>
            <input type="submit" value="Save" name="submit">
        <p> <a href="reservation.php">Back</a></p>
        </div>
    </form>
</div>
</body>
</html>