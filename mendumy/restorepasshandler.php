<?php
include("php/mysqli.php");

if (isset($_GET['id']) && isset($_GET['e'])) {
    $idusr = trim(filter_var($_GET['id'], FILTER_VALIDATE_INT));
    $email = trim(filter_var($_GET['e'], FILTER_VALIDATE_EMAIL));
    if (!($idusr || $email)) {
        echo 0; //Error
        die;
    }

    $pass = "";
    $check = MySQLDB::getInstance()->query("SELECT username, idusr FROM auth WHERE username = '" . $email . "' AND idusr = " . $idusr . " ");
    if ($check->num_rows) {
        $sql = MySQLDB::getInstance()->query("UPDATE auth SET password = '" . $pass . "' WHERE username = '" . $email . "' AND idusr = " . $idusr . " ");

        if ($sql) {
            echo 1; //Cambio exitoso
            die;
        } else {
            echo 2; //Error
            die;
        }
    } else {
        echo 3; //Usuario no existe
        die;
    }
} else {
    echo 0; //Error
    die;
}
