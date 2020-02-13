<?php
include("php/mysqli.php");

if (isset($_GET['id']) && isset($_GET['p']) && isset($_GET['e'])) {
    $idusr = trim(filter_var($_GET['id'], FILTER_VALIDATE_INT));
    $pass = trim(filter_var($_GET['p'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_GET['e'], FILTER_VALIDATE_EMAIL));
    if (!($idusr || $pass || $email)) {
        echo 0; //Error
        die;
    }


    $check = MySQLDB::getInstance()->query("SELECT * FROM auth WHERE idusr = " . $idusr . " OR username = '" . $email . "' ");
    if ($check->num_rows == 0) {
        $sql = MySQLDB::getInstance()->query("INSERT INTO auth (idusr, username, password, last_modification) 
        VALUES (" . $idusr . ", '$email', '$pass', NOW())");

        if ($sql) {
            echo 1; //Registro exitoso
            die;
        } else {
            echo 2; //Error
            die;
        }
    } else {
        echo 3; //Usuario duplicado
        die;
    }
} else {
    echo 0; //Error
    die;
}
