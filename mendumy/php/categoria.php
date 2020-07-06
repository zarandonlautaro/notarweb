<?php
include("mysqli.php");

//Si operacion igual a cargar devuelve las categorias y las subcategorias
if (isset($_POST['operacion']) && $_POST['operacion'] == 'cargar'){

    $sql = MySQLDB::getInstance()->query("SELECT * FROM categories ");
    
    if ($sql->num_rows>0) {
        
        $i=0;
        $j=0;
        $categorias='';
        while ($rs = $sql->fetch_assoc()) {
            $idcat = $rs['id'];
            $sql1 = MySQLDB::getInstance()->query("SELECT * FROM subcategories WHERE idcategory='$idcat'");
            $i++; 
            $categorias .= '<li class="dropdown-item dropdown">
                            <a class="dropdown-toggle" id="dropdown1-'.$i.'"data-toggle="dropdown"'
                                .'aria-haspopup="true" aria-expanded="false">'.$rs['name'].'</a>
                                <!--Item subcategoria-->
                                <ul class="dropdown-menu" aria-labelledby="dropdown1-'.$i.'">';
                         

            while ($rs1=$sql1->fetch_assoc()) {    
                    
                    $categorias .= '<!--Item categoria-->
                                    <li class="dropdown-item " href="#"><a categoryname="'.$rs['name'].'" idcategory="'.$rs['id'].'" idsubcategory="'.$rs1['id'].'" class="subcategory">'.$rs1['name'].'</a></li>
                                ';
                            
                }
            $categorias.='</li></ul>';    
        }
    }else{
        $categorias="No hay cursos cargados";
    }

  echo( $categorias);
  die;
}

if (isset($_POST['categoria'])) {
    $categoria = trim(filter_var($_POST['categoria'], FILTER_SANITIZE_STRING));

    if (!($categoria)) { //Filtrado de variables
        echo 4; //Quiere romper algo
        die;
    }
}

if (isset($_POST['operacion']) && $_POST['operacion'] == 'agregaconsulta') {
    //Agregar categoria o consultar


    if ($categoria == "traer") {

        //Select las categorias
        echo buscarCategorias();
    } else {

        //Insertamos la nueva categoria
        //devolvemos categorias actulizadas
        $sql = MySQLDB::getInstance()->query("SELECT * FROM categories where name='$categoria' ");

        if ($sql->num_rows != 0) {
            echo 1; //categoria existente
            die;
        } else {
            //realizamos el insert de la nueva categoria        

            $sql = MySQLDB::getInstance()->query("INSERT INTO categories (name) VALUES ('$categoria')");
            echo buscarCategorias();
            die;
        }
    }
} else {

    $sql = MySQLDB::getInstance()->query("SELECT * FROM categories where name='$categoria' ");

    if ($sql->num_rows != 0) {
        //Eliminamos la categoria

        if (MySQLDB::getInstance()->query("DELETE FROM categories WHERE name ='$categoria'")) {
            echo buscarCategorias();
            die;
        } else {
            echo 2; //no puede borrar esta categoria por que esta asignada a al menos un video
        }
    } else {
        echo 3; //categoria inexistente
    }



    /*
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>*/
}



function buscarCategorias()
{

    //Select las categorias
    $sql = MySQLDB::getInstance()->query("SELECT * FROM categories ");
    if ($sql->num_rows) {
        $categorias = '<option selected>Seleccionar...</option>';
        while ($rs = $sql->fetch_assoc()) {
            $option = '<option value="' . $rs['id'] . '">' . $rs['name'] . '</option>';
            $categorias = $categorias . $option;
        }
    }

    return $categorias;
}
