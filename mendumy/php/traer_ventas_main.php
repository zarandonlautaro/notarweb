<?php
//ABMC =ALTA BAJA MODIFICACION Y CONSULTA
require_once('../php/funcs.php');
include("mysqli.php");

//lectura de parámetros elemento puede ser: curso,tema o video
if (isset($_POST['operation']) && !empty($_POST['operation']) && isset($_POST['courseid']) && $_POST['courseid'] != "Seleccionar..." && isset($_POST['date1']) && !empty($_POST['date1']) && isset($_POST['date2']) && !empty($_POST['date2'])) {

    //filtrado de variables
    $operation = trim(filter_var($_POST['operation'], FILTER_SANITIZE_STRING));
    $courseid = trim(filter_var($_POST['courseid'], FILTER_SANITIZE_STRING));
    $d1 = trim(filter_var($_POST['date1'], FILTER_SANITIZE_STRING));
    $d2 = trim(filter_var($_POST['date2'], FILTER_SANITIZE_STRING));

    //echo ($operation . " " . $courseid . " " . $date1 . " " . $date2);



    function traer($courseid, $d1, $d2)
    {
        /*$fecha1 = new DateTime($d1);
        $date1 = $fecha1->format('Y-d-m');
        $fecha2 = new DateTime($d2);
        $date2 = $fecha2->format('Y-d-m');
        */

        $date2 = date("Y/m/d", strtotime($d2));
        $date1 = date("Y/m/d", strtotime($d1));
        //echo ($_POST['operation'] . " " . $courseid . " " . $date1 . " " . $date2);

        $sql = MySQLDB::getInstance()->query("SELECT * FROM course WHERE id = '$courseid'");
        $curso = $sql->fetch_assoc();



        $tabla =
            '<div class="container">' .
            '<div class="row">' .
            '<div class="col-lg-12">' .
            '<div class="table-responsive">' .
            '<table id="table" class="table table-striped table-bordered" style="width:100%">' .
            '<thead class="tcabecera">' .
            '<tr>' . $curso['name'] . ' ventas entre ' . $d1 . ' y ' . $d2 . '</tr>' .
            '<tr>' .
            '<th>Video</th>' .
            '<th>Nombre</th>' .
            '<th>DNI</th>' .
            '<th>Correo</th>' .
            '<th>Fecha</th>' .
            '<th>Tipo</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';




        /*$tabla = '<div class="container"> <table id="table" class="table table-light table-responsive-sm ">' .
            '<thead class="thead-dark">' .
            '<tr>' . $curso['name'] . ' ventas entre ' . $d1 . ' y ' . $d2 . '</tr>' .
            '<tr>' .
            '<th scope="col">#</th>' .
            '<th  scope="col" class="text-center" colspan="2">Nombre</th>' .
            '<th  scope="col" class="text-center">DNI</th>' .
            '<th  scope="col" class="text-center" colspan="2">Correo</th>' .
            '<th  scope="col" class="text-center"colspan="2">Fecha de compra</th>' .
            '<th  scope="col" class="text-center"colspan="2">Pago</th>' .
            '</tr>' .
            '</thead>'.
            '<tbody>';*/
        $sqlcheck = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse = '$courseid' AND saledate BETWEEN '$date1' AND '$date2'");
        $i = 1;
        //$sqlcheck = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse=88 AND saledate BETWEEN '2020-03-20' AND '2020-07-08'"); 
        while ($rs = $sqlcheck->fetch_assoc()) {

            $id = $rs['iduser'];
            //echo $rs['idcourse']."numero usuario".$rs['iduser'];
            $sqlcheck1 = MySQLDB::getInstance()->query("SELECT * FROM users WHERE id = '$id'");
            $user = $sqlcheck1->fetch_assoc();
            //print_r($rs);

            if ($rs['paid'] == 1) {
                $res = "Pago";
            } else {
                $res = "Invitado";
            }

            $tabla .=

                '<tr>' .
                '<th scope="row" class="text-center">' . $i . '</th>' .
                '<th class="text-center">' . $user['name'] . " " . $user['lastname'] . '</td>' .
                '<th class="text-center">' . $user['dni'] . '</td>' .
                '<th class="text-center">' . $user['username'] . '</td>' .
                '<th class="text-center">' . $rs['saledate'] . '</td>' .
                '<th class="text-center">' . $res . '</td>' .
                '</tr>';
            /*
            $tabla .=
                
                '<tr>' .
                '<th scope="row" class="text-center">' . $i . '</th>' .
                '<td colspan="2" class="text-center">' . $user['name'] . " " . $user['lastname'] . '</td>' .
                '<td class="text-center">' . $user['dni'] . '</td>' .
                '<td colspan="2" class="text-center">' . $user['username'] . '</td>' .
                '<td colspan="2" class="text-center">' . $rs['saledate'] . '</td>' .
                '<td colspan="2" class="text-center">' . $res. '</td>' .
                '</tr>';*/
            $i++;
        }
        $tabla .= '</tbody></table> </div>';
        echo $tabla;
        die;
    }

    switch ($operation) {
        case "traer":
            traer($courseid, $d1, $d2);
            break;
        default:
            echo "Ingrese opción correcta";
            die;
            break;
    }
} else {
    echo 1; //"Faltaron algunos campos.";
    die;
}
