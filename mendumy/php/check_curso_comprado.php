<?php
include("mysqli.php");
require('../vendor/autoload.php');
//print_r($_SESSION);
//die;
$iduser=$_SESSION['id'];

if (isset($_POST['idcourse'])) {
    $idcourse = trim(filter_var($_POST['idcourse'], FILTER_VALIDATE_INT));
    if (!($idcourse)) { //Filtrado de variables
        echo 4; //Quiere romper algo
        die;
    }

    $sql = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse = $idcourse AND iduser = " . $iduser . " ");
    if ($sql->num_rows) {

        $sql = MySQLDB::getInstance()->query("SELECT * FROM course  WHERE id = $idcourse ");
        $rs = $sql->fetch_assoc();
        if ($rs) {
            $curso[] = array(
                'id' => $rs['id'], 'imgname' => $rs['imgname'] , 'name' => $rs['name'], 'description' => $rs['description'],'bought' => true
            );
            echo json_encode($curso);
            die;
        }

        echo 3; //Comprado

    } else {

        $sql = MySQLDB::getInstance()->query("SELECT id,name,description, category, imgname, price FROM course  WHERE id = $idcourse ");
        if ($sql->num_rows) {
            $rs = $sql->fetch_assoc();

            $price = $rs['price'];
           
            if ($price >0) {
                // SDK de Mercado Pago
                //require __DIR__  . '/vendor/autoload.php';
                require('../vendor/autoload.php');
                // Agrega credenciales
                MercadoPago\SDK::setAccessToken('TEST-8911236071524493-111921-6afe41586f766724a77ca2518e96a003-179632899');
                // Crea un objeto de preferencia
                $preference = new MercadoPago\Preference();

                // Crea un ítem en la preferencia
                $item = new MercadoPago\Item();
                $item->title = $rs['name'];  //'Curso';
                $item->quantity = 1;
                $item->unit_price = $price; //intval($price);
                $preference->items = array($item);
                $preference->save(); //inicializa
            
                $curso[] = array(
                        'id' => $rs['id'],'preferenceid'=>$preference->id,'bought' => false
                    ); 
                

                echo json_encode($curso);
                die;    
                
            } else {
                if ($rs['price']==0) {
                    
                   
                    $sql = MySQLDB::getInstance()->query("INSERT INTO courseuser  (idcourse,iduser) VALUES ('$idcourse','$iduser') ");


                    

                    $cartel='<div id="alert" class="alert alert-success fade show mb-4" role="alert">' .
                    '¡Felicidades  el curso <strong>'.$rs['name']."</strong> fue adquirido con éxito!".
                    '</div>';
                    $curso[] = array(
                        'id' => $rs['id'], 'preferenceid' => 0, 'bought' => false ,'cartel'=>$cartel
                    );

                    echo json_encode($curso);
                    die;
                }

                
            }
        }
    }
} else {
    echo 1; //Error
    die;
}

?>