<?php
require_once('../php/funcs.php');
include("mysqli.php");
//print_r( $_FILES['imagen']['name']);
/*if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0){
print_r($_POST);}
*/
//print_r($_POST);
//print_r($files);

//
if (isset($_FILES['imagen']) && isset($_FILES['video']) && isset($_POST['titulo']) && isset($_POST['tema']) && isset($_POST['descripcion']) && isset($_POST['curso'])) {
    //Almacenamos en variables llegadas por métodos post
    if($_POST['tema']==0||!(isset($_POST['tema']))){
        $msg[] = "Seleccione tema.";
        echo resultBlock($msg, 2);
        die;
    }
    if ($_FILES['video']['error'] === 0 && $_FILES['imagen']['error'] === 0) {
        $imagen = $_FILES['imagen'];
        $video = $_FILES['video'];
    } else {
        $msg[] = "Obligatorio seleccionar archivo de video e imagen de portada";
        echo resultBlock($msg, 2);
        die;
    }

    //preparamos el array de archivos 
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        controlArchivos($file['error']);

        $cant = count($file['name']);
        for ($i = 0; $i < $cant; $i++) {

            $error = $file['error'][$i];
            $typef = $file['type'][$i];
            $tmp_name = $file['tmp_name'][$i];
            $size = $file['size'][$i];
            $name = $file['name'][$i];
            $filename = md5($tmp_name) . "." . extension($typef);
            $path = "../coursefiles/" . $filename;

            $files[] = array(
                "name" => $name,
                "filename" => $filename,
                "type" => $typef,
                "tmp_name" => $tmp_name,
                "path" => $path,
                "error" => $error,
                "size" => $size
            );
        }
    }


    //filtrado de variables
    $title = trim(filter_var($_POST['titulo'], FILTER_SANITIZE_STRING));
    $idtheme = trim(filter_var($_POST['tema'], FILTER_SANITIZE_STRING));
    $description = trim(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));
    $idcourse = trim(filter_var($_POST['curso'], FILTER_SANITIZE_STRING));

    if (!($title || $idtheme || $description)) {
        $msg[] = "Caracter no permitido";
        echo resultBlock($msg, 2);
        die;
    }




    $imageExtension = $imagen["type"];
    $allowedfileExtensions = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
    //controlamos que el tipo de imagen ingresado sea un tipo permitido 
    if (in_array($imageExtension, $allowedfileExtensions)) {
        $videoExtension = $video["type"];
        $allowedfileExtensions2 = array('video/mp4', 'video/wmv', 'video/flv', 'video/mov', 'video/avi');
        //hacemos lo mismo con el video
        if (in_array($videoExtension, $allowedfileExtensions2)) {
            //creamos un nombre para el archivo codificando el nombre del directorio 
            //temporario del archivo (este siempre es diferente)
            $imgname = md5($imagen["tmp_name"]) . "." . extension($imageExtension);
            $videoname = md5($video["tmp_name"]) . "." . extension($videoExtension);
            $rutaImagen = "../imgcourses/" . $imgname;
            $rutaVideo = "../coursesvideos/" . $videoname;
            //cargamos el formulario en la base de datos

            $sql1 = MySQLDB::getInstance()->query("INSERT INTO videoscourse (idcourse,name,title,uploaddate,idtheme,imgvideo,description) VALUES ('$idcourse','$videoname','$title',NOW(),'$idtheme','$imgname','$description' ) ");
            $sqlid = MySQLDB::getInstance()->query("SELECT LAST_INSERT_ID() as id");
            $id = $sqlid->fetch_assoc();
            $idvideo = $id['id'];
           
            if ($sql1) {

                if (isset($_FILES['file'])) {
                    foreach ($files as $archivo) {
    
                        $name = $archivo['name'];
                        $filename=$archivo['filename'];
                        $sql2 = MySQLDB::getInstance()->query("INSERT INTO files (idvideo,name,uploaddate,idcourse,filename) VALUES ('$idvideo','$name',NOW(),'$idcourse','$filename') ");
                        if($sql2){
                            move_uploaded_file($archivo["tmp_name"], $archivo['path']);
                          

                        }
                   
                    }
                }
    
                //movemos la imagen y el video desde su ubicación temporaria hasta los directorios imgcourses y coursesvideo respectivamente
                move_uploaded_file($imagen["tmp_name"], $rutaImagen);
                move_uploaded_file($video["tmp_name"], $rutaVideo);




                $msg[] = "¡Curso subido con éxito!";
                echo resultBlock($msg, 1);
                die;
            } else {
                $msg[] = "¡Error al cargar a la base de datos!";
                echo resultBlock($msg, 2);
                die;
            }
        } else {
            $msg[] = "extensión de video no valida </br> Formatos permitidos[mp4,wmv,flv,mov,avi]";
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

function controlArchivos($files)
{

    $errores = 0;
    $archivos = $files;

    foreach ($archivos as $archivo) {

        $error = $archivo;
        if ($error != 0) {
            $errores = 1;
        }
    }
    if ($errores != 0) {

        $msg[] = "No se permite envio de archivos vacios.Elimine los archivos que no va a enviar.";
        echo resultBlock($msg, 2);
        die;
    }
}
