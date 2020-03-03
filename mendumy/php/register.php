<?php
include("mysqli.php");
include("mail.php");

if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['legajo']) && isset($_POST['pass']) && isset($_POST['dni'])) {
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING));
    $dni = trim(filter_var($_POST['dni'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $legajo = trim(filter_var($_POST['legajo'], FILTER_SANITIZE_STRING));
    $pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
    if (!($name || $lastname || $email || $legajo || $pass)) { //Filtrado de variables
        echo 2; //Quiere romper algo
        die;
    }


    //reCaptcha Script--------------------------------------------------------------------------------------------------
    $secret ="6LfM59sUAAAAAIxYsIxCeHgNFOm_y0IMrjH-t2e7" ;
    //"6Lf9lsMUAAAAAKC8PMden4YhjyJ5AZ9yQi_ip1Kc";
    $response = $_POST["captcha"];//obtenemos el valor de captcha enviado desde landing.jp
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
    $captcha_success = json_decode($verify);//decodifica el json y devuelve array asociativo 
    //fin reCaptcha Script--------------------------------------------------------------------------------------------------

    if ($captcha_success->success == false) {
        //This user was not verified by recaptcha.
        echo 3; //No hizo el captcha
        die;
    } else if ($captcha_success->success == true) {

        //This user is verified by recaptcha
        $sql = MySQLDB::getInstance()->query("INSERT INTO users (name, lastname, legajo, dni, active) VALUES ('$name', '$lastname', '$legajo','$dni', 0) ");
        $sqlid = MySQLDB::getInstance()->query("SELECT LAST_INSERT_ID() as idusr");
        $id = $sqlid->fetch_assoc();
        if (sendMail($email, 1, $id['idusr'], hash("SHA256", $pass)) && $sql) {
            echo 1;
        } else {
            echo 0;
            die;
        }
    }
} else {
    echo 2;
    die;
}
