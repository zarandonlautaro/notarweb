<?php
include("mysqli.php");


if (isset($_POST['operacion']) && isset($_POST['idcategoria']) && isset($_POST['subcategoria'])) {

    //control de variables post
    $operacion = $_POST['operacion'];

    if (isset($_POST['subcategoria']) && isset($_POST['subcategoria'])) {
        $subcategoria = trim(filter_var($_POST['subcategoria'], FILTER_SANITIZE_STRING));
        $idcategoria = trim(filter_var($_POST['idcategoria'], FILTER_SANITIZE_STRING));
        //echo "operacion ".$operacion." nombre: ".$subcategoria." ".$idcategoria." recibido ok";
        //die;



        if (!($subcategoria) && !($idcategoria)) { //Filtrado de variables
            echo "4"; //Quiere romper algo
            die;
        }
       

    
        switch ($operacion) {
            case "traer":
                echo buscarSubcategorias($idcategoria);
                break;
            case "agrega":agregaSubcategoria($subcategoria,$idcategoria);
                break;
            case "borra":borraSubcategoria($subcategoria,$idcategoria);
                break;
        }
    }
}

function buscarSubcategorias($idcategoria)
{ //Select las categorias
    $sql1 = MySQLDB::getInstance()->query("SELECT * FROM subcategories WHERE idcategory='$idcategoria'");
    if ($sql1->num_rows) {
        $subcategorias = '<option selected>Seleccionar...</option>';
        while ($rs = $sql1->fetch_assoc()) {
            $option = '<option value="' . $rs['id'] . '">' . $rs['name'] . '</option>';
            $subcategorias = $subcategorias . $option;
        }
    }

    return $subcategorias;
}

function agregasubcategoria($subcategoria,$idcategoria){

   
    $sql = MySQLDB::getInstance()->query("SELECT * FROM subcategories WHERE  idcategory='$idcategoria' AND name='$subcategoria'");
    if ($sql->num_rows != 0) {
        
        echo 1; //categoria existente
        die;
    } else {
        //realizamos el insert de la nueva categoria        

        $sql = MySQLDB::getInstance()->query("INSERT INTO subcategories (name,idcategory) VALUES ('$subcategoria','$idcategoria')");
        if ($sql) {
            echo buscarSubcategorias($idcategoria);
            die;
        }else{
            echo 5;//"problemas al cargar en la base de datos";
        }
       
    }


}
function borraSubcategoria($subcategoria,$idcategoria){

$sql = MySQLDB::getInstance()->query("SELECT * FROM subcategories WHERE  idcategory='$idcategoria' AND name='$subcategoria'");

    if ($sql->num_rows != 0) {
        //Eliminamos la categoria

        if (MySQLDB::getInstance()->query("DELETE FROM subcategories WHERE name ='$subcategoria'")) {
            echo buscarSubcategorias($idcategoria);
            die;

        } else {
            echo 2; //no puede borrar esta categoria por que esta asignada a al menos un curso
        }
    } else {
        echo 3; //categoria inexistente
    }

}
?>
