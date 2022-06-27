<?php
/** @var mysqli $db */

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    //Require database in this file
    require_once "database.php";

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $name   = mysqli_escape_string($db, $_POST['name']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $phone  = mysqli_escape_string($db, $_POST['phone']);
    $dati = mysqli_escape_string($db, $_POST['dati']);
    $comment = mysqli_escape_string($db, $_POST['comment']);

    //Require the form validation handling
    require_once "form-validations.php";

    if (empty($errors)) {
        //Save the record to the database
        $query = "INSERT INTO reservation (name, email, phone, dati, comment)
                  VALUES ('$name', '$email', '$phone','$dati', '$comment')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        if ($result) {
            //If the result is there go to confirm.php
            header('Location: confirm.php');
            exit;
        } else {
            //If there is no result show error
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>DLC reservering</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="rese.css"/>
</head>
<body>
<h1>Reservering</h1>
<?php if (isset($errors['db'])) { ?>
    <div><span class="errors"><?= $errors['db']; ?></span></div>
<?php } ?>

<!-- enctype="multipart/form-data" no characters will be converted -->
<form action="" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="name">Naam</label>
        <input id="name" type="text" name="name" value="<?= isset($name) ? htmlentities($name) : '' ?>"/>
        <span class="errors"><?= $errors['name'] ?? '' ?></span>
    </div>
    <div class="data-field">
        <label for="email">Email</label>
        <input id="email" type="text" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="phone">Telefoonnummer</label>
        <input id="phone" maxlength="10" type="text" name="phone"
                value="<?= isset($phone) ? htmlentities($phone) : '' ?>"/>
        <span class="errors"><?= isset($errors['phone']) ? $errors['phone'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="dati">Datum en tijd</label>
        <input type="datetime-local" id="dati" name="dati"
               value="<?= isset($dati) ? htmlentities($dati) : '' ?>"/>
        <span class="errors"><?= isset($errors['dati']) ? $errors['dati'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="comment">Opmerking</label>
        <input id="comment" type="text" name="comment" value="<?= isset($comment) ? htmlentities($comment) : '' ?>"/>
        <span class="errors"><?= $errors['comment'] ?? '' ?></span>
    </div>
    <div class="data-submit">
        <input type="submit" name="submit" value="Save"/>
    </div>
</form>
<div>
    <a href="home.html">Terug naar home</a>
</div>
</body>
</html>
