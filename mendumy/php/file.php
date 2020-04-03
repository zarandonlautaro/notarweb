<?php
require_once('../php/funcs.php');
include("mysqli.php"); 
//print_r( $_FILES['imagen']['name']);
/*if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0){
print_r($_POST);}
*/

if (isset($_FILES['imagen']) && isset($_FILES['video']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['categoria']) && isset($_POST['descripcion'])) {
    //Almacenamos en variables llegadas por métodos post
    if($_FILES['video']['error'] === 0 && $_FILES['imagen']['error'] === 0){
    $imagen = $_FILES['imagen'];
    $video = $_FILES['video'];
    }else{
        $msg[]="Error al cargar los archivos";
        echo resultBlock($msg,2);
        die;
    }
    $name= trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $price = trim(filter_var($_POST['precio'], FILTER_SANITIZE_STRING));
    $category = trim(filter_var($_POST['categoria'], FILTER_SANITIZE_STRING));
    $description = trim(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));
  
    $imageExtension=$imagen["type"];
    $allowedfileExtensions = array('image/jpg', 'image/jpeg','image/gif', 'image/png');
    if (in_array($imageExtension, $allowedfileExtensions)) {
        $videoExtension=$video["type"];
        $allowedfileExtensions2 = array('video/mp4', 'video/wmv','video/flv', 'video/mov','video/avi');
        if (in_array($videoExtension, $allowedfileExtensions2)) {
            /*creamos un nombre para el archivo codificando el nombre del directorio 
            temporario del archivo (este siempre es diferente)*/
            $imgname=md5($imagen["tmp_name"]).extension($imageExtension);
            $videoname=md5($video["tmp_name"]).extension($videoExtension);
            $rutaImagen="../imgcourses/".$imgname;
            $rutaVideo="../coursesvideos/".$videoname;
            //cargamos el formulario en la base de datos
    
            $sql = MySQLDB::getInstance()->query("INSERT INTO course (price, name, description, category, creationdate, modificationdate , imgname,videoname) VALUES ('$price', '$name', '$description','$category',NOW(), NULL ,'$imgname','$videoname') ");
            
            if($sql){
                //movemos la imagen y el video desde su ubicación temporaria hasta los directorios imgcourses y coursesvideo respectivamente
                move_uploaded_file($imagen["tmp_name"],$rutaImagen);
                move_uploaded_file($video["tmp_name"],$rutaVideo);
                
                $msg[]="¡Curso subido con éxito!";
                echo resultBlock($msg,1);
                die;

            }else{
                $msg[]="¡Error al cargar a la base de datos!";
                echo resultBlock($msg,2);
                die;
            }

        }else{
            $msg[]="extensión de video no valida </br> Formatos permitidos[mp4,wmv,flv,mov,avi]";
            echo resultBlock($msg,2);
            die;
        }
    }else{
        $msg[]="Extensión de imagen no valida </br> Formatos permitidos[jpg,jpeg,gif,png]";
        echo resultBlock($msg,2);
        die;
    }



    //print_r( $file_post['name'] . '  ' . $file_post2['name']." ".limpia_espacios($name));
}else{
    $msg[]="Todos los campos son obligatorios";
    echo resultBlock($msg,2);
    die;
}

