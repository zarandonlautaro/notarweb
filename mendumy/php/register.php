<?php
include("mysqli.php");
include("mail.php");
require_once('../php/funcs.php');
$valido=false;
//validaciones del lado del servidor
if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['legajo']) && isset($_POST['pass']) && isset($_POST['rePass'])  && isset($_POST['dni'])&& isset($_POST['date'])){
$name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
$lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING));
$dni = trim(filter_var($_POST['dni'], FILTER_SANITIZE_STRING));
$email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
$legajo = trim(filter_var($_POST['legajo'], FILTER_SANITIZE_STRING));
$pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
$rePass = trim(filter_var($_POST['rePass'], FILTER_SANITIZE_STRING));
$datea= trim(filter_var($_POST['date'], FILTER_SANITIZE_STRING));
$fecha = strtotime($datea); //Convierte el string a formato de fecha en php
$dateb = date('Y-m-d',$fecha); //Lo comvierte a formato de fecha en MySQL
$valido=true;

if(!isEmail($email))
{
    //$errors[] = "Dirección de correo inválida";
    echo 2;//error de validacion
    die;
}

if(!validaPassword($pass, $rePass))
{
    //$errors[] = "Las contraseñas no coinciden";
    echo 2;//error de validacion
    die;
}

}

if ($valido) {
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING));
    $dni = trim(filter_var($_POST['dni'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $legajo = trim(filter_var($_POST['legajo'], FILTER_SANITIZE_STRING));
    $pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
    $datea= trim(filter_var($_POST['date'], FILTER_SANITIZE_STRING));
    $fecha = strtotime($datea); //Convierte el string a formato de fecha en php
    $dateb = date('Y-m-d',$fecha); //Lo comvierte a formato de fecha en MySQL
 
    if (!($name || $lastname || $email || $legajo || $pass)) { //Filtrado de variables
        echo 2; //Quiere romper algo
        die;
    }
    //hace falta validar del lado del servidor

    //reCaptcha Script del lado del servidor--------------------------------------------------------------------------------------------------
    $secret ="6LfM59sUAAAAAIxYsIxCeHgNFOm_y0IMrjH-t2e7" ;
    //"6Lf9lsMUAAAAAKC8PMden4YhjyJ5AZ9yQi_ip1Kc";
    $response = $_POST["captcha"];//obtenemos el valor de captcha enviado desde landing.jp
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
    $captcha_success = json_decode($verify);//decodifica el json y devuelve array asociativo 
    //fin reCaptcha Script--------------------------------------------------------------------------------------------------
   // $captcha_success->success = true;
    if ($captcha_success->success == false) {
        //This user was not verified by recaptcha.
        echo 3; //No hizo el captcha
        die;
    } else if ($captcha_success->success == true) {
        //generamos hashes
        $pass_hash = hash("SHA256", $pass);
        $token = generateToken();
        $active=0;

        //insertamos el usuario nuevo en la tabla user
        if(MySQLDB::getInstance()->query("SELECT username FROM users WHERE username='$email'")->num_rows !=0){
            echo 4;//correo en uso
            die; 
        }
        if(MySQLDB::getInstance()->query("SELECT username FROM users WHERE dni='$dni'")->num_rows !=0){
            echo 5;//correo en uso
            die; 
        }
    
        $sql = MySQLDB::getInstance()->query("INSERT INTO users (name, lastname, idprofesion, dni, date_birth, username , password,active,token,creation_date) VALUES ('$name', '$lastname', '$legajo','$dni','$dateb', '$email' ,'$pass_hash','$active','$token',now())");
        $sqlid = MySQLDB::getInstance()->query("SELECT LAST_INSERT_ID() as idusr");
        $id = $sqlid->fetch_assoc();
        $iduser=$id['idusr'];
        $auth = MySQLDB::getInstance()->query("INSERT INTO auth (idusr) VALUES ('$iduser') ");
        //$sql = MySQLDB::getInstance()->query("INSERT INTO auth (idusr, last_auth) VALUES ( '$iduser', NOW() )"); //ultima logeo
        /*if (!$sql) {
        echo "user id ".$iduser.'  ';
        echo $name.' '.$lastname.' '.$legajo.' '.$dni.' '.$dateb.' '.$email.' '.$pass_hash.' '.$active.' '.$token." ".$sql ;
        //echo  " error al leer base de datos";
        die;
        }*/
        if (sendMail($email, 1, $iduser, $token) && $sql) {
            echo 1;
            die;
        } else {
            echo 0;
            die;
        }
    }
} else {
    echo 2;//error de validación
    die;
}
