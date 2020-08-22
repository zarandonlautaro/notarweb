<?php
require_once('../php/funcs.php');
include("mysqli.php");
//print_r( $_FILES['imagen']['name']);
/*if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0){
print_r($_POST);}
die;*/

if (isset($_FILES['imagen']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['subcategoria']) && isset($_POST['categoria']) && isset($_POST['credencial'])) {
    //Almacenamos en variables llegadas por métodos post
    if ($_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
    } else {
        $msg[] = "Debe seleccionar una imagen de portada.";
        echo resultBlock($msg, 2);
        die;
    }
    if ($_POST['subcategoria'] == "") {
        $msg[] = "Seleccione categoria y subcategoria";
        echo resultBlock($msg, 2);
        die;
    }
    if ($_POST['credencial'] == "Seleccionar...") {
        $msg[] = "Debe asignar credencial";
        echo resultBlock($msg, 2);
        die;
    }
    if ($_POST['nombre'] == "") {
        $msg[] = "Escriba un nombre";
        echo resultBlock($msg, 2);
        die;
    }


    $credentialid= trim(filter_var($_POST['credencial'], FILTER_SANITIZE_STRING));
    $name = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $price = trim(filter_var($_POST['precio'], FILTER_SANITIZE_STRING));
    $category = trim(filter_var($_POST['categoria'], FILTER_SANITIZE_STRING));
    $subcategory = trim(filter_var($_POST['subcategoria'], FILTER_SANITIZE_STRING));
    $description = trim(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));

    $imageExtension = $imagen["type"];
    $allowedfileExtensions = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
    if (in_array($imageExtension, $allowedfileExtensions)) {


        /*creamos un nombre para el archivo codificando el nombre del directorio 
            temporario del archivo (este siempre es diferente)*/
        $imgname = md5($imagen["tmp_name"]) . "." . extension($imageExtension);
        $rutaImagen = "../imgcourses/" . $imgname;

        //cargamos el formulario en la base de datos

        $sql = MySQLDB::getInstance()->query("SELECT * FROM categories where name='$category'");
        $id = $sql->fetch_assoc();
        $categoryid = $id['id'];


        $sql1 = MySQLDB::getInstance()->query("SELECT * FROM subcategories WHERE  idcategory='$categoryid' AND name='$subcategory'");
        $id1 = $sql1->fetch_assoc();
        $subcategoryid = $id1['id'];


        //verificamos que no exista un curso con el mismo nombre
        $sql = MySQLDB::getInstance()->query("SELECT * FROM course where name='$name'");
        if ($sql->num_rows == 0) {


            $sql = MySQLDB::getInstance()->query("INSERT INTO course (price, name, description, category, creationdate, modificationdate , imgname, subcategory,credentialid) VALUES ('$price', '$name', '$description','$categoryid',NOW(), NULL ,'$imgname','$subcategoryid','$credentialid') ");

            if ($sql) {
                //movemos la imagen y el video desde su ubicación temporaria hasta los directorios imgcourses y coursesvideo respectivamente
                move_uploaded_file($imagen["tmp_name"], $rutaImagen);


                $msg[] = "¡Curso subido con éxito!";
                echo resultBlock($msg, 1);
                die;
            } else {
                $msg[] = "¡Error al cargar la base de datos!";
                echo resultBlock($msg, 2);
                die;
            }
        } else {
            $msg[] = "¡Nombre de curso no disponible!";
            echo resultBlock($msg, 2);
            die;
        }
    } else {
        $msg[] = "Extensión de imagen no valida </br> Formatos permitidos[jpg,jpeg,gif,png]";
        echo resultBlock($msg, 2);
        die;
    }



    //print_r( $file_post['name'] . '  ' . $file_post2['name']." ".limpia_espacios($name));
} else {
    $msg[] = "Todos los campos son obligatorios";
    echo resultBlock($msg, 2);
    die;
}
