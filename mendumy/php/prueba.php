


<?php
include("mysqli.php");
require('../vendor/autoload.php');








    $idcourse = 3;
    $id=2;
    if (!($idcourse)) { //Filtrado de variables
        echo 4; //Quiere romper algo
        die;
    }

    //$sql = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse = $idcourse AND iduser = " . $id. " ");
    if ( false/*$sql->num_rows*/) {
        
        /*$sql = MySQLDB::getInstance()->query("SELECT id,videoname FROM course  WHERE id = $idcourse ");

        if ($rs = $sql->fetch_assoc()) {
            $curso[] = array(
                'id' => $rs['id'],'videoname'=>$rs['videoname'],'bought' => true
            );
            echo json_encode($curso);
        die;
        }*/

        echo 3; //Comprado

    } else {

        //$sql = MySQLDB::getInstance()->query("SELECT id,name,description, category, imgname, price FROM course  WHERE id = $idcourse ");
        //if ($sql->num_rows) {  
        //$rs = $sql->fetch_assoc();

        $price = 11;//$rs['price'];
        // SDK de Mercado Pago
       //require __DIR__  . '/vendor/autoload.php';
       require('../vendor/autoload.php');
       // Agrega credenciales
       MercadoPago\SDK::setAccessToken('TEST-8911236071524493-111921-6afe41586f766724a77ca2518e96a003-179632899');
       // Crea un objeto de preferencia
       $preference = new MercadoPago\Preference();
      
       // Crea un ítem en la preferencia
       $item = new MercadoPago\Item();
       $item->title ="curso";//$rs['name'];  //'Curso';
       $item->quantity = 1;
       $item->unit_price =$price;//intval($price);
       $preference->items = array($item);
       $preference->save(); //inicializa

       /* 
       if ($rs) {
        $curso[] = array(
            'id' => $rs['id'],'preferenceid'=>$preference->id,'bought' => false
        );}
*/
        //echo json_encode($curso);


        echo $preference->id; //No comprado
        
        //echo "Adquiera este producto";
        die;

        //}
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Comprar Curso</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div id='pago' class="modal-body">
                                <form action="/procesar-pago" method="POST">
                                <script
                                src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
                                data-preference-id="<?php echo $preference->id; ?>">
                                </script>
                                </form>
                                </div>
                               <!-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>-->
                            </div>
                        </div>
                    </div>
    </body>
    </html>