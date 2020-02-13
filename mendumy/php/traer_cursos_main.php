<?php
include('mysqli.php');

if (isset($_POST['comprados'])) {
    $comprados = $_POST['comprados'];

    if ($comprados == "true") {
        $sql = MySQLDB::getInstance()->query("SELECT course.id,name,description, category, imgname FROM course 
                                            INNER JOIN courseuser ON courseuser.idcourse = course.id
                                            WHERE courseuser.iduser = " . $_SESSION['idusr'] . " ORDER BY creationdate DESC");
        if ($sql->num_rows) {
            while ($rs = $sql->fetch_assoc()) {
                $cursos[] = array(
                    'id' => $rs['id'], 'name' => $rs['name'], 'description' => $rs['description'],
                    'category' => $rs['category'], 'imgname' => $rs['imgname'], 'bought' => true
                );
            }
            echo json_encode($cursos); //Array de cursos
        } else {
            echo 0; //No hay cursos para mostrar
            die;
        }
    } else if ($comprados == "false") {
        $sql = MySQLDB::getInstance()->query("SELECT id,name,description, category, imgname, price FROM course ORDER BY creationdate DESC");
        if ($sql->num_rows) {
            while ($rs = $sql->fetch_assoc()) {
                $sqlcheck = MySQLDB::getInstance()->query("SELECT id FROM courseuser WHERE idcourse= " . $rs['id'] . " AND iduser = " . $_SESSION['idusr'] . " ");
                if ($sqlcheck->num_rows) {
                    $cursos[] = array(
                        'id' => $rs['id'], 'name' => $rs['name'], 'description' => $rs['description'],
                        'category' => $rs['category'], 'imgname' => $rs['imgname'], 'bought' => true
                    );
                } else {


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





                    $cursos[] = array(
                        'id' => $rs['id'], 'name' => $rs['name'], 'description' => $rs['description'],
                        'category' => $rs['category'], 'imgname' => $rs['imgname'], 'bought' => false, 'preferenceid' => $preference->id
                    );
                }
            }
            echo json_encode($cursos); //Array de cursos
        } else {
            echo 0; //No hay cursos para mostrar
            die;
        }
    }
}
