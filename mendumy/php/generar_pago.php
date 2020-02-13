<?php
include("mysqli.php");

if (isset($_POST['idcourse'])) {
    $idcourse = trim(filter_var($_POST['idcourse'], FILTER_VALIDATE_INT));
    if (!($idcourse)) { //Filtrado de variables
        echo 3; //Quiere romper algo
        die;
    }

    $sql = MySQLDB::getInstance()->query("SELECT price FROM course WHERE id = $idcourse ");
    echo MySQLDB::getInstance()->error();
    if ($sql->num_rows) {
        $rs = $sql->fetch_assoc();
        $price = $rs['price'];

        // SDK de Mercado Pago
        require('../vendor/autoload.php');
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken('TEST-8911236071524493-111921-6afe41586f766724a77ca2518e96a003-179632899');

        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

        // Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = 'Curso';
        $item->quantity = 1;
        $item->unit_price = intval($price);
        $preference->items = array($item);
        $preference->save();
        
        echo $preference->id;
    } else { //Curso sin precio (wot?)
        echo 2;
        die;
    }
} else {
    echo 1; //Error
    die;
}
