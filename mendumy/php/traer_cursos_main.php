<?php
include('mysqli.php');
require('../vendor/autoload.php');
if (isset($_POST['operacion']) && isset($_POST['categoria']) && isset($_POST['subcategoria'])) {
    $operacion = $_POST['operacion'];
    $cat = $_POST['categoria'];
    $subcat = $_POST['subcategoria'];

    //echo $operacion." "."cat".$cat." subcat".$subcat;
    //die;

}
switch ($operacion) {
    case "todos":
        todos($cat, $subcat); //devolver todos los cursos de la BD
        break;
    case "comprados":
        comprados(); //devolver solo los comprados
        break;
    case "categoria":
        todos($cat, $subcat); //devolver los de una categoria y subcategoria especifica
        break;

    default:;
        break;
}


function todos($cat, $subcat)
{
    //echo "cat ".$cat."subcat ".$subcat;
    
    if ($cat != "" && $subcat != "") {
        $sql = MySQLDB::getInstance()->query("SELECT * FROM course WHERE category='$cat' AND subcategory='$subcat' ORDER BY creationdate DESC");
        //el caso de que queramos mostrar todos los cursos
       
    } else {
        $sql = MySQLDB::getInstance()->query("SELECT * FROM course ORDER BY creationdate DESC");
    }
    

    if ($sql->num_rows) {
        while ($rs = $sql->fetch_assoc()) {
            $sqlcheck = MySQLDB::getInstance()->query("SELECT id FROM courseuser WHERE idcourse= " . $rs['id'] . " AND iduser = " . $_SESSION['id'] . " ");
            if ($sqlcheck->num_rows) {
                $cursos[] = array(
                    'id' => $rs['id'], 'name' => $rs['name'], 'description' => $rs['description'],
                    'category' => $rs['category'], 'imgname' => $rs['imgname'], 'price' => $rs['price'], 'credentialid' => $rs['credentialid'] ,'bought' => true
                );
            } else {

                $cursos[] = array(
                    "id" => $rs['id'], "name" => $rs['name'], "description" => $rs['description'],
                    "category" => $rs['category'], "imgname" => $rs['imgname'], 'price' => $rs['price'],'credentialid' => $rs['credentialid'] , 'bought' => false //"preferenceid"=>$preference->id
                );
            }
        }
        //print_r($cursos);
        if (is_array($cursos)) {

            //print_r($cursos);
            echo json_encode($cursos);
            die;
        } else {
            echo "error";
        }
    } else {
        echo 0; //No hay cursos para mostrar
        die;
    }
}

function comprados()
{

    $sql = MySQLDB::getInstance()->query("SELECT course.id,name,description, category, imgname FROM course 
                                            INNER JOIN courseuser ON courseuser.idcourse = course.id
                                            WHERE courseuser.iduser = " . $_SESSION['id'] . " ORDER BY creationdate DESC");
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
}

?>