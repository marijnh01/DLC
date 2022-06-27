<?php
//Check if data is valid & generate error if not so
$errors = [];
if ($name == "") {
    $errors['name'] = 'Naam mag niet leeg zijn';
}
if ($email == "") {
    $errors['email'] = 'Email mag niet leeg zijn';
}
if (!is_numeric($phone) || strlen($phone) != 10) {
    $errors['phone'] = 'Telefoonnummer heeft 10 cijfers';
}
if ($phone == "") {
    $errors['phone'] = 'Telefoonnummer mag niet leeg zijn';
}
if ($dati == "") {
    $errors['dati'] = 'Datum en tijd mag niet leeg zijn';
}
