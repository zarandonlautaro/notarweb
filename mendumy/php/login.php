<?php
include("mysqli.php");

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
    if (!($email || $pass)) { //Filtrado de variables
        echo 4; //Quiere romper algo
        die;
    }

    $pass = hash("SHA256", $pass);
    $sql = MySQLDB::getInstance()->query("SELECT idusr FROM auth WHERE username = '$email' AND password = '$pass' ");
    if ($sql->num_rows) {
        $rs = $sql->fetch_assoc();
        $_SESSION['idusr'] = $rs["idusr"];
        $sqlInfo = MySQLDB::getInstance()->query("SELECT rol FROM users WHERE id = " . $_SESSION['idusr'] . " ");
        if ($sqlInfo->num_rows) {
            $rsInfo = $sqlInfo->fetch_assoc();
            $_SESSION['rol'] = $rsInfo['rol'];
            echo 3; //Login OK
        }
    } else {
        echo 2; //ERROR usr/pass
        die;
    }
} else {
    echo 1; //Faltan
    die;
}
