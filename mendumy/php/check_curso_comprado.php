<?php
include("mysqli.php");
require('../vendor/autoload.php');

if (isset($_POST['idcourse'])) {
    $idcourse = trim(filter_var($_POST['idcourse'], FILTER_VALIDATE_INT));
    if (!($idcourse)) { //Filtrado de variables
        echo 4; //Quiere romper algo
        die;
    }

    $sql = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse = $idcourse AND iduser = " . $_SESSION['id'] . " ");
    if ($sql->num_rows) {
        
        $sql = MySQLDB::getInstance()->query("SELECT id,videoname FROM course  WHERE id = $idcourse ");

        if ($rs = $sql->fetch_assoc()) {
            $curso[] = array(
                'id' => $rs['id'],'videoname'=>$rs['videoname'],'bought' => true
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
        // SDK de Mercado Pago
       //require __DIR__  . '/vendor/autoload.php';
       require('../vendor/autoload.php');
       // Agrega credenciales
       MercadoPago\SDK::setAccessToken('TEST-8911236071524493-111921-6afe41586f766724a77ca2518e96a003-179632899');
       // Crea un objeto de preferencia
       $preference = new MercadoPago\Preference();
      
       // Crea un ítem en la preferencia
       $item = new MercadoPago\Item();
       $item->title =$rs['name'];  //'Curso';
       $item->quantity = 1;
       $item->unit_price =$price;//intval($price);
       $preference->items = array($item);
       $preference->save(); //inicializa

       
       if ($rs) {
        $curso[] = array(
            'id' => $rs['id'],'preferenceid'=>$preference->id,'bought' => false
        );}

        echo json_encode($curso);


       // echo $preference->id; //No comprado
        
        //echo "Adquiera este producto";
        die;

        }
    }
} else {
    echo 1; //Error
    die;
}
