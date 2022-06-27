<?php
//Checks if user is logged in
session_start();
if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
require_once "database.php";
//Checks if post is submitted
if (isset($_POST['submit'])) {
    $username = mysqli_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    $errors = [];
    if($username == '') {
        $errors['username'] = 'Voer een gebruikersnaam in';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in';
    }

    if(empty($errors))
    {
        //Get record from DB based on first name
        $query = "SELECT * FROM admin WHERE username='$username'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'username' => $user['username'],
                    'id' => $user['id']
                ];
            } else {
                //error wrong username or password
                $errors['loginFailed'] = 'De combinatie van username en wachtwoord is bij ons niet bekend';
            }
        } else {
            //error wrong username or password
            $errors['loginFailed'] = 'De combinatie van username en wachtwoord is bij ons niet bekend';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="rese.css"/>
    <title>Login</title>
</head>
<body>
<h2>Inloggen</h2>
<?php if ($login) { ?>
    <p>Je bent ingelogd!</p>
    <p><a href="reservation.php">Reserveringen</a></p>
    <p><a href="logout.php">Uitloggen</a></p>

<?php } else { ?>
    <form action="" method="post">
        <div>
            <label for="username">Username</label>
            <input id="username" type="text" name="username" value="<?= $username ?? '' ?>"/>
            <span class="errors"><?= $errors['username'] ?? '' ?></span>
        </div>
        <div>
            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" />
            <span class="errors"><?= $errors['password'] ?? '' ?></span>
        </div>
        <div>
            <p class="errors"><?= $errors['loginFailed'] ?? '' ?></p>
            <input type="submit" name="submit" value="Login"/>
        </div>
    </form>
<p><a href="home.html">Home</a></p>
<?php } ?>
</body>
</html>

