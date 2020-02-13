<?php
include("mysqli.php");
include("mail.php");

if (isset($_POST['email'])) {
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    if (!($email)) { //Filtrado de variables
        echo 2; //Quiere romper algo
        die;
    }

    $check = MySQLDB::getInstance()->query("SELECT username, idusr FROM auth WHERE username = '" . $email . "' ");
    if ($check->num_rows) {
        //El usuario existe, tenemos que hacer el proceso
        $rs = $check->fetch_assoc();
        if (sendMail($email, 2, $rs['idusr'])) {
            echo 1; //Mail enviado
            die;
        }
    }else{
        echo 0; //Usuario inexistente, que se cree uno
        die;
    }
}
