<?php
include("mysqli.php");
include("funcs.php");
include("vars.php");

//require __DIR__  . '/vendor/autoload.php';
require('../vendor/autoload.php');
// Agrega credenciales
header("HTTP/1.2 200 OK");

MercadoPago\SDK::setAccessToken($accesstoken);
//$json_event = file_get_contents('php://input', true);
//$event = json_decode($json_event);
//print_r($event->type);
//die;

$merchant_order = null;

$payment = MercadoPago\Payment::find_by_id($_GET["id"]);
// Get the payment and the corresponding merchant_order reported by the IPN.
$merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);

$idcourse = $merchant_order->items[0]->id;
$iduser = $merchant_order->external_reference;

//verifico que se haya pagado la totalidad de monto
$paid_amount = 0;
foreach ($merchant_order->payments as $payment) {
    if ($payment->status == 'approved') {
        $paid_amount += $payment->transaction_amount;
    }
}

// If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
if ($paid_amount >= $merchant_order->total_amount) {
    //var_export($payment);

    $sql = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse = $idcourse AND iduser = " . $iduser . " ");
    if ($sql->num_rows){
        echo "el curso ya fue comprado";
    }else{
    $sql = MySQLDB::getInstance()->query("INSERT INTO courseuser  (idcourse,iduser) VALUES ('$idcourse','$iduser')");
    }
} else {
    print_r("Not paid yet. Do not release your item.");
    $status = "in_process";
    if ($payment->status == $status) {
        echo "El estado de la compra es: " . $status;
    }
}






/*
$iduser = $_SESSION['id'];
$secret_token = "APP_USR-2242931866985656-051120-c6aa618ca1695edb68ff8b1d5b4a2276-566667855";
$idcompra = $_GET['collection_id'];
//variables provenientes del webhook
$variables = json_decode(curl_get_file_contents("https://api.mercadopago.com/v1/payments/" . $idcompra . "?access_token=" . $secret_token));
$idcompraWh = $variables->id;
$idcourseWh = $variables->external_reference;
$statusWh = $variables->status;
//variables backurl
if (isset($_GET['collection_status'])) {
    if ($_GET['collection_status'] == "approved") {
        $idcompra = $_GET['collection_id'];
        $idcourse = $_GET['external_reference'];
        $status = $_GET['collection_status'];

        //revision de seguridad para que no puedan cambiar la url y agregarse cursos
        if ($idcompraWh == $idcompra && $idcourseWh == $idcourse) {
            $sql = MySQLDB::getInstance()->query("INSERT INTO courseuser  (idcourse,iduser) VALUES ('$idcourse','$iduser') ");
            echo "Curso agregado con exito!";
            die;
        } else {
            echo "1"; //ha modificado la url
            die;
        }
    } else {
        //en caso de ser pendiente verificamos con el webhook y almacenamos la variables en la base de datos 
        //,hasta que llegue el mensaje desde el webhook indicando que el pago se realizó con exito

    }
}else{
//en el caso de que las variables GETS no esten seteadas significa que esta llegando un mensaje del webhook


}
(object) array( 
    'id' => 6737802403, 
    'transaction_amount' => 1, 
    'total_paid_amount' => 1,
     'shipping_cost' => 0, 
     'currency_id' => 'ARS', 
     'status' => 'approved', 
     'status_detail' => 'accredited', 
     'operation_type' => 'regular_payment', 
     'date_approved' => '2020-05-19T16:28:01.000-04:00', 
     'date_created' => '2020-05-19T16:28:00.000-04:00', 
     'last_modified' => '2020-05-19T16:28:01.000-04:00', 
     'amount_refunded' => 0, );


*/