<?php
include("mysqli.php");
include("mail.php");
require_once('../php/funcs.php');

if (isset($_POST['email'])) {
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    if (!($email)) { //Filtrado de variables
        echo 2; //Quiere romper algo
        die;
    }


    //reCaptcha Script--------------------------------------------------------------------------------------------------
    $secret = "6LfM59sUAAAAAIxYsIxCeHgNFOm_y0IMrjH-t2e7";
    //"6Lf9lsMUAAAAAKC8PMden4YhjyJ5AZ9yQi_ip1Kc";
    $response = $_POST["captcha"]; //obtenemos el valor de captcha enviado desde landing.jp
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
    //puede ser reemplazada por curl_get_file_contents() ya que algunos servidores no la soportan
    $captcha_success = json_decode($verify); //decodifica el json y devuelve array asociativo 
    //fin reCaptcha Script--------------------------------------------------------------------------------------------------

    if ($captcha_success->success == false) {
        //This user was not verified by recaptcha.
        echo $verify; //3 No hizo el captcha
        die;
    } else if ($captcha_success->success == true) {

        $check = MySQLDB::getInstance()->query("SELECT username, id FROM users WHERE username = '" . $email . "' ");
       
        if ($check->num_rows) {

            //El usuario existe, tenemos que hacer el proceso
            $rs = $check->fetch_assoc();
            $iduser = $rs['id'];
            $token = generaTokenPass($iduser); // genera el token y pone en 1 el password request
            if (sendMail($email, 2, $iduser, $token)) {
                echo 1; //Mail enviado
                die;
            }
        } else {
            echo 0; //Usuario inexistente, que se cree uno
            die;
        }
    }
}
?>