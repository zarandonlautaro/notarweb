<?php
include("mysqli.php");

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
    if (!($email || $pass)) { //Filtrado de variables
        echo 4; //Quiere romper algo
        die;
    }
    $pass_hash = hash("SHA256", $pass);
    $sql = MySQLDB::getInstance()->query("SELECT * FROM users WHERE username = '$email' AND password = '$pass_hash' ");
    
    if ($sql->num_rows == 1){
        $rs = $sql->fetch_assoc();
        if($rs["active"]==1){
        
            $id=$rs["id"];
            $_SESSION['id'] =$id;
            $_SESSION['rol'] = $rs['rol'];
            $_SESSION['nombre'] = $rs['name'];
            $auth = MySQLDB::getInstance()->query("UPDATE auth SET  last_auth=now() WHERE idusr = '$id'");
            echo 3; //Login OK
            die;
        
        }else{

                echo 4;//falta activar usuario
                die;  
             }
            
    } else {
        echo 2 ;//ERROR usr/pass
        die;
    }
} else {
    echo 1; //Faltan
    die;
}
