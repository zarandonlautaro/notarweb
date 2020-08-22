<?php
//ABMC =ALTA BAJA MODIFICACION Y CONSULTA
require_once('../php/funcs.php');
include("mysqli.php");

//lectura de parámetros elemento puede ser: curso,tema o video
if (isset($_POST['operation'])) {

    //filtrado de variables
    $operation = trim(filter_var($_POST['operation'], FILTER_SANITIZE_STRING));
    if ($operation == "traer2") {
        $operation = "traer";
    }
    //$dato = trim(filter_var($_POST['dato'], FILTER_SANITIZE_STRING)); dato se filtrara segun el caso

} else {
    echo "no seleccionó opción";
    die;
}


function traer()
{
    $filaextra ='<div id="alert"></div>'.
        '<tbody>' .
        '<tr>' .
        '<th scope="row" class="text-center">+</th>' .
        '<td class="text-center">' .
        '<div class="row">' .
        '<div class="col-sm-auto col-xl-12 ">' .
        '<input id="credentialname" type="text" class="form-control form-control-sm">' .
        '</div>' .
        '</div>' .
        '</td>' .
        '<td class="" colspan="1">' .
        '<div class="row">' .
        '<div class="col-sm-auto col-xl-12 ">' .
        '<input id="credential" type="text" class="form-control form-control-sm">' .
        '</div>' .
        '</div>' .

        '</td>' .

        '<td class="text-center">' .
        '<div class="row">' .
        '<div class="col-sm-auto col-xl-12 ">' .
        date("Y-m-d") .
        '</div>' .
        '</div>' .
        '</td>' .
        '<td colspan="2">' .
        '<div class="row d-flex justify-content-around">' .
        '<div class="col"> <button class="guardar-credencial btn btn-outline-success"  id="guardar-credencial" >Guardar</button> </div>' .

        '</div>' .
        '</td>' .
        '</tr>';;

    $tabla = '<div class="table-responsive-sm table-responsive-xl"> <table class="table table-light  ">' .
        '<thead class="thead-dark">' .
        '<th scope="col">#</th>' .
        '<th  scope="col" class="text-center">Nombre</th>' .
        '<th  scope="col" class="text-center">Credencial</th>' .
        '<th  scope="col" class="text-center">Fecha de modificación</th>' .
        '<th  scope="col" class="text-center" colspan="2">Operaciones</th>' .


        '</tr>' .
        '</thead>';
    $sqlcheck = MySQLDB::getInstance()->query("SELECT * FROM credentials");
    $i = 1;
    //$sqlcheck = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse=88 AND saledate BETWEEN '2020-03-20' AND '2020-07-08'"); 
    while ($cred = $sqlcheck->fetch_assoc()) {


        //print_r($rs);

        $tabla .=
            '<tbody>' .
            '<tr>' .
            '<th scope="row" class="text-center">' . $i . '</th>' .
            '<td class="text-center">' .
            '<div class="row">' .
            '<div class="col-sm-auto col-xl-12 ">' .
            '<input id="credentialname' . $cred['id'] . '" type="text" class="form-control form-control-sm"  value="' . $cred['name'] . '">' .
            '</div>' .
            '</div>' .
            '</td>' .
            '<td class="" colspan="1">' .
            '<div class="row">' .
            '<div class="col-sm-auto col-xl-12 ">' .
            '<input id="credential' . $cred['id'] . '" type="text" class="form-control form-control-sm"  value="' . $cred['credential'] . '">' .
            '</div>' .
            '</div>' .

            '</td>' .

            '<td class="text-center">' .
            '<div class="row">' .
            '<div class="col-sm-auto col-xl-12 ">' .
            $cred['modificationdate'] .
            '</div>' .
            '</div>' .
            '</td>' .
            '<td colspan="2">' .
            '<div class="row d-flex justify-content-around">' .
            '<div class="col"> <button class="modificar-credencial btn btn-dark"  id="' . $cred['id'] . '" >Modificar</button> </div>' .
            '<div class="col"> <button class="eliminar-credencial btn btn-danger" ide="' . $cred['id'] . '" id="curso' . $cred['id'] . '" >Eliminar</button></div>' .
            '</div>' .
            '</td>' .
            '</tr>';
        $i++;
    }
    $tabla .= $filaextra . '</tbody></table> </div>';
    echo $tabla;
    die;
}
function guardar()
{
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $credential = trim(filter_var($_POST['credential'], FILTER_SANITIZE_STRING));
    $sql = MySQLDB::getInstance()->query("INSERT INTO credentials (name,credential,modificationdate) VALUES ('$name','$credential',now()) ");
    if ($sql) {
        echo 1;
        die;
    } else {
        echo 2; //error
        die;
    }
}
function eliminar()
{
    //filtrado de variables
    $id = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));

    $sql = MySQLDB::getInstance()->query("DELETE FROM credentials WHERE id ='$id'");
    if ($sql) {
        echo 1;
        die;
    } else {
        echo 2; //error al borrar video
        die;
    }
}
function modificar()
{
    //filtrado de variables
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $credential = trim(filter_var($_POST['credential'], FILTER_SANITIZE_STRING));
    $id = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));
    $sql = MySQLDB::getInstance()->query("UPDATE credentials SET name='$name', credential='$credential', modificationdate=NOW() WHERE id='$id'");

    if ($sql) {
        echo 1;
        die;
    } else {
        echo 2; //error al borrar video
        die;
    }
}
function traerselect()
{
    $id = $_POST['id'];
  

    $sql1 = MySQLDB::getInstance()->query("SELECT * FROM course WHERE id='$id' ");
    $r = $sql1->fetch_assoc();
    $sql = MySQLDB::getInstance()->query("SELECT * FROM credentials");

    if ($sql->num_rows) {
        $credenciales = '<option>Seleccionar...</option>';
        while ($rs = $sql->fetch_assoc()) {
            if ($r['credentialid'] == $rs['id']) {
                $option = '<option selected value="' . $rs['id'] . '">' . $rs['name'] . '</option>';
            } else {
                $option = '<option value="' . $rs['id'] . '">' . $rs['name'] . '</option>';
            }
            $credenciales = $credenciales . $option;
        }
    }

    echo $credenciales;
    die;
}
//Switch para seleccionar elemento sobre el cual queremos hacer ABM o consulta
switch ($operation) {
    case "traer":
        traer();
        break;
    case "traerselect":
        traerselect();
        break;
    case "guardar":
        guardar();
        break;
    case "eliminar":
        eliminar();
        break;
    case "modificar":
        modificar();
        break;

        //error("elemento");//opcion de elemento no inexistente
}
