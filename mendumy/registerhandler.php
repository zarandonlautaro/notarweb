<?php
include("php/mysqli.php");
require 'php\directorio.php';
  
if (isset($_GET['id']) && isset($_GET['token']) ) {
    $idusr = trim(filter_var($_GET['id'], FILTER_VALIDATE_INT));
    $token = trim(filter_var($_GET['token'], FILTER_SANITIZE_STRING));
    
    if (!($idusr || $token)) {
        echo 0; //Error
        die;
    }


    $check = MySQLDB::getInstance()->query("SELECT * FROM users WHERE id = '$idusr'  AND token = '$token' AND active= 0 ");
    if ($check->num_rows!=0) {
        $active=1;//usuario activo
        $sql = MySQLDB::getInstance()->query("UPDATE users SET  active='$active' WHERE id = '$idusr'");

        if ($sql) {
           // echo  1 .'<p> Registro exitoso, será redireccionado en 3 segundos.</p>'; //Registro exitoso
            header("Location: http://".$directorio."php/registro_exitoso.php"); /* Redirección del navegador */
            die;
        } else {
            echo 2; //Error en la consulta
            die;
        }
    } else {
        echo 3; //Usuario activo ó token mal  ó usuario no exite
        die;
    }
} else {
    echo 0; //Error
    die;
}
