<?php
use MercadoPago\Preference;
include("mysqli.php");
require('../vendor/autoload.php');
include("vars.php");
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
        $sql1 = MySQLDB::getInstance()->query("SELECT * FROM users  WHERE id = '$iduser' ");
        $user = $sql1->fetch_assoc();
        $dni=$user['dni'];

        $sql = MySQLDB::getInstance()->query("SELECT id,name,description, category, imgname, price FROM course  WHERE id = $idcourse ");
        if ($sql->num_rows) {
            $rs = $sql->fetch_assoc();

            $price = $rs['price'];
           
            if ($price >0) {
                // SDK de Mercado Pago
                //require __DIR__  . '/vendor/autoload.php';
                require('../vendor/autoload.php');
                // Agrega credenciales
                MercadoPago\SDK::setAccessToken($accesstoken);
                // Crea un objeto de preferencia
                $preference = new MercadoPago\Preference();

                // Crea un ítem en la preferencia
                $item = new MercadoPago\Item();
                $item->title = $rs['name'];  //'Curso';
                $item->quantity = 1;
                $item->unit_price = $price; //intval($price);
                $item->id=$idcourse;
                $preference->items = array($item);
                //Creamos un payer
                $payer = new MercadoPago\Payer();
                $payer->identification = array(
                    "type" => "DNI",
                    "number" => $dni
                  );
                $payer->id=$iduser;
                $preference->payer=$payer;
                //urls a las que redirecciona al terminar la transaccion
                $preference->back_urls = array(
                    "success" => "http://localhost/mendumy2/mendumy/mendumy/home.php?result=success&idcourse=".$idcourse."",
                    "failure" => "http://localhost/mendumy2/mendumy/mendumy/home.php?result=fairule&idcourse=".$idcourse."",
                    "pending" => "http://localhost/mendumy2/mendumy/mendumy/home.php?result=pending&idcourse=".$idcourse."",
                );
                
                
                //excluimos algunos medios de pago
                $preference->payment_methods = array(

                    "excluded_payment_types" => array (
                        array ( "id" => "bank_transfer",    "name" => "Bank Transfer" ),
                        array ( "id" => "atm",                "name" => "ATM Bank Transfer" ),
                        array("id" => "ticket")
                    ),	

                    "excluded_payment_methods" => array(
                        array("id" => "cargavirtual"),
                        array("id" => "atm"),
                        

                    )
                    
                );


                $preference->auto_return = "approved";
                $preference->external_reference=$iduser;
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