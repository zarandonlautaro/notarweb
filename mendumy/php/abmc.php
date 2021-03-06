<?php
//ABMC =ALTA BAJA MODIFICACION Y CONSULTA
require_once('../php/funcs.php');
include("mysqli.php");
//lectura de parámetros elemento puede ser: curso,tema o video
if (isset($_POST['elemento']) && isset($_POST['operacion'])) {

    //filtrado de variables
    $elemento = trim(filter_var($_POST['elemento'], FILTER_SANITIZE_STRING));
    $operacion = trim(filter_var($_POST['operacion'], FILTER_SANITIZE_STRING));
    //$dato = trim(filter_var($_POST['dato'], FILTER_SANITIZE_STRING)); dato se filtrara segun el caso
    if (isset($_POST['dato'])) {
        $dato = $_POST['dato'];
    } else {
        $dato = "";
    }


    if (!($elemento) || !($operacion)) { //Filtrado de variables
        echo "4"; //Quiere romper algo
        die;
    }
} else {
    echo "Faltaron algunos campos.";
    die;
}

//Switch para seleccionar elemento sobre el cual queremos hacer ABM o consulta
switch ($elemento) {
    case "curso":
        curso($operacion, $dato);
        break;
    case "tema":
        tema($operacion, $dato);
        break;
    case "video":
        video($operacion, $dato);
        break;
    case "perfil":
        perfil($operacion, $dato);
        break;
    case "view":
        view($operacion);
        break;
    default:
        //error("elemento");//opcion de elemento no inexistente
}
function view($operacion)
{

    function registraview()
    {
        $userid = $_SESSION['id'];
        $videoid = $_POST["videoid"];

        $sql = MySQLDB::getInstance()->query("SELECT * FROM views WHERE videoid='$videoid' and userid='$userid'");

        if ($sql->num_rows != 0) {
            echo 1; //view existente existente
            die;
        } else {
            //realizamos el insert del nuevo tema   

            $sql = MySQLDB::getInstance()->query("INSERT INTO views (videoid,userid,created) VALUES ('$videoid','$userid',now())");
            die;
        }
    }

    function consultaview()
    {

        $d1 = $_POST["date1"];
        $d2 = $_POST["date2"];
        $date2 = date("Y/m/d", strtotime($d2));
        $date1 = date("Y/m/d", strtotime($d1));
        //echo $date1."  ".$date2;
        $courseid = $_POST["courseid"];
        $sql = MySQLDB::getInstance()->query("SELECT title,id,idtheme FROM videoscourse WHERE idcourse = '$courseid'");
        $v = $sql;
        //AND created BETWEEN '$d1' AND '$d2'
       
        while ($r = $sql->fetch_assoc()) {
            $videoid = $r['id'];
            $title = $r['title'];
            $idtheme = $r['idtheme'];
            $sql2 = MySQLDB::getInstance()->query("SELECT name FROM themes WHERE id = '$idtheme'");
            $r2 = $sql2->fetch_assoc();
            $theme=$r2['name'];
            $sql1 = MySQLDB::getInstance()->query("SELECT * FROM views WHERE videoid = '$videoid' AND created BETWEEN '$date1' AND '$date2'");

            while ($r1 = $sql1->fetch_assoc()) {
                $userid = $r1['userid'];
                $q = MySQLDB::getInstance()->query("SELECT * FROM users WHERE id = '$userid'");
                $user = $q->fetch_assoc();
                $views[] = array(
                    'name' => $user['name'], 'lastname' => $user['lastname'], 'dni' => $user['dni'],
                    'date' => $r1['created'],'title' => $title,'theme'=>$theme
                );
            }
            /*if (isset($views)) {
                $videos[] = array(
                    'id' => $r['id'], 'title' => $r['title'], 'views' => $views
                );
            }
            unset($views);*/
        }

        if (isset($views)) {
            echo json_encode($views);
            die;
        } else {
            echo 1;
            die;
        }
    }
    switch ($operacion) {

        case "registrar":
            registraview();
            break;
        case "consultar":
            consultaview();
            break;
        default:
            //error("operacion");//opcion de operacion no inexistente
    }
}
//FUNCIONES DE ELEMENTO CURSO
function perfil($operacion, $dato)
{

    function modificaperfil($dato)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();

            $userid = $_SESSION['id'];
        } else {
            $userid = $_SESSION['id'];
        }

        if ($dato == "contraseña") {
            $p1 = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
            $p2 = trim(filter_var($_POST['con_password'], FILTER_SANITIZE_STRING));

            if (validaPassword($p1, $p2) && longitudPass($p1)) {
                $pass = $pass_hash = hash("SHA256", $p1);
                $q1 = MySQLDB::getInstance()->query("UPDATE recover SET password_request=0,last_modification=NOW() WHERE idusr = '$userid'");
                $q2 = MySQLDB::getInstance()->query("UPDATE users SET password='$pass' WHERE id = '$userid'");
                if ($q1 && $q2) {
                    echo 1;
                    die;
                }
            } else {
                echo 3; //"La contraseña y su confirmación deben ser iguales y longitud mayor a 7 caracteres";
                die;
            }
        } else {
            if (!is_numeric($_POST['formacion']) || !($_POST['formacion'] > 0 && $_POST['formacion'] < 6)) {
                echo 7; //error
                die;
            }
            if (!ctype_alnum(limpia_espacios($_POST['nombre'])) || !ctype_alnum(limpia_espacios($_POST['apellido']))) {
                echo 6;
                die;
            }
            if (!is_numeric($_POST['dni'])) {
                echo 5;
                die;
            }
            if (isNull($_POST['nombre'], $_POST['apellido'], $_POST['formacion'],  $_POST['dni'], $_POST['fecha'])) {
                echo 4;
                die;
            }
            $name = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
            $lastname = trim(filter_var($_POST['apellido'], FILTER_SANITIZE_STRING));
            $idprofesion = trim(filter_var($_POST['formacion'], FILTER_SANITIZE_STRING));
            $dni = trim(filter_var($_POST['dni'], FILTER_SANITIZE_STRING));
            $d = trim(filter_var($_POST['fecha'], FILTER_SANITIZE_STRING));
            $date = date("Y/m/d", strtotime($d));
            $q2 = MySQLDB::getInstance()->query("UPDATE users SET name='$name', lastname='$lastname', idprofesion='$idprofesion',dni='$dni', date_birth='$date' WHERE id = '$userid'");
            if ($q2) {
                echo 1;
                die;
            } else {
                echo 2;
                die;
            }
        }
    }
    function consultaperfil($dato)
    {
        $userid = $dato;
    }
    switch ($operacion) {

        case "modificar":
            modificaperfil($dato);
            break;
        case "consultar":
            consultaperfil($dato);
            break;
        default:
            //error("operacion");//opcion de operacion no inexistente
    }
}
function curso($operacion, $dato)
{

    /*//modificación
    function modificacioncurso($dato)
    {
    }*/
    //Consulta

    /*
    //Alta
    function altacurso($dato)
    {
    }*/
    //baja 


    function bajacurso($dato)
    {
        $idcourse = $dato;
        $sql3 = MySQLDB::getInstance()->query("SELECT * FROM files  WHERE idcourse = $idcourse ");
        while ($rs2 = $sql3->fetch_assoc()) {

            $namefile = $rs2['filename'];
            $idfile = $rs2['id'];
            filedelete($idfile, $namefile);
        }
        $sql = MySQLDB::getInstance()->query("SELECT imgname FROM course WHERE id ='$idcourse'");
        $rs = $sql->fetch_assoc();
        $imgname = $rs['imgname'];
        $rutaImg = "../imgcourses/" . $imgname;
        unlink($rutaImg);



        $sql = MySQLDB::getInstance()->query("DELETE FROM course WHERE id ='$idcourse'");
        if ($sql) {
            echo 1;
            die;
        } else {
            echo 2; //error al borrar video
            die;
        }
    }


    function consultacursos($dato)
    {
        if ($dato == 'select') {
            //consulta que devuelve select
            $sql = MySQLDB::getInstance()->query("SELECT * FROM course ");
            if ($sql->num_rows) {

                $cursos = '<option value="0" selected>Seleccionar...</option>';
                while ($rs = $sql->fetch_assoc()) {
                    $option = '<option value="' . $rs['id'] . '">' . $rs['name'] . '</option>';
                    $cursos = $cursos . $option;
                }
            }

            echo $cursos;
            die;
        } else {
            //consulta que devuelve los datos de otra forma
            $sql = MySQLDB::getInstance()->query("SELECT * FROM course where id='$dato' ");

            if ($sql->num_rows) {
                $rs = $sql->fetch_assoc();

                $curso = array(
                    'id' => $rs['id'], 'name' => $rs['name'], 'description' => $rs['description'],
                    'category' => $rs['category'], 'imgname' => $rs['imgname'], 'price' => $rs['price'], 'subcategory' => $rs['subcategory']
                );

                echo json_encode($curso);
                die;
            }
        }
    }
    function modificacioncurso()
    {
        $formulario = $_POST;

        if ($_POST['categoria'] != "" && $_POST['subcategoria'] != "") {
            $category = trim(filter_var($_POST['categoria'], FILTER_SANITIZE_STRING));
            $subcategory = trim(filter_var($_POST['subcategoria'], FILTER_SANITIZE_STRING));
        } else {
            $msg[] = "Seleccione categoria y subcategoria, porfavor";
            echo resultBlock($msg, 2);
            die;
        }
        if ($_POST['credencial'] != "Seleccionar...") {
            $credentialid = trim(filter_var($_POST['credencial'], FILTER_SANITIZE_STRING));
        } else {
            $msg[] = "Debe asignar credencial";
            echo resultBlock($msg, 2);
            die;
        }
        if (isset($_POST['nombre']) && isset($_POST['precio'])) {

            $name = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
            $price = trim(filter_var($_POST['precio'], FILTER_SANITIZE_STRING));

            if (isset($_POST['descripcion'])) {
                $description = trim(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));
            } else {
                $description = "";
            }
            $id = $_POST['id'];
        } else {
            $msg[] = "¡No deje campos vacios!";
            echo resultBlock($msg, 2);
            die;
        }


        //obtenemos el nombre anterior de la imagen
        $sql1 = MySQLDB::getInstance()->query("SELECT * FROM course where id='$id'");
        $rs1 = $sql1->fetch_assoc();

        $imgAnterior = $rs1['imgname'];
        $rutaImgAnterior = "../imgcourses/" . $imgAnterior;

        if (!isset($_FILES['imagen'])) {
            $imgname = $imgAnterior; //no se cambia el archivo imagen

        } else {
            $imagen = $_FILES['imagen'];
            $imageExtension = $imagen["type"];
            $allowedfileExtensions = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
            if (!(in_array($imageExtension, $allowedfileExtensions))) {
                $msg[] = "Extensión de imagen no valida </br> Formatos permitidos[jpg,jpeg,gif,png]";
                echo resultBlock($msg, 2);
                die;
            }
            /*creamos un nombre para el archivo codificando el nombre del directorio 
                temporario del archivo (este siempre es diferente)*/
            $imgname = md5($imagen["tmp_name"]) . "." . extension($imageExtension);
            $rutaImagen = "../imgcourses/" . $imgname;
        }
        //hacemos un update teniendo en cuenta la imagen
        $sql = MySQLDB::getInstance()->query("SELECT * FROM categories where name='$category'");
        $idcat = $sql->fetch_assoc();
        $categoryid = $idcat['id'];
        $sql = MySQLDB::getInstance()->query("SELECT * FROM subcategories WHERE name='$subcategory' AND idcategory='$categoryid'");
        $idsubcat = $sql->fetch_assoc();
        $subcategoryid = $idsubcat['id'];



        $sql = MySQLDB::getInstance()->query("UPDATE course SET price='$price', name='$name', description='$description', category='$categoryid', modificationdate=NOW() , imgname='$imgname',subcategory='$subcategoryid',credentialid='$credentialid' WHERE id='$id'");

        if ($sql) {
            //movemos la imagen y el video desde su ubicación temporaria hasta los directorios imgcourses y coursesvideo respectivamente
            if (isset($_FILES['imagen'])) {
                unlink($rutaImgAnterior);
                move_uploaded_file($imagen["tmp_name"], $rutaImagen);
            }

            $msg[] = "¡Curso subido con éxito!";
            echo resultBlock($msg, 1);
            die;
        } else {
            $msg[] = "¡Error al cargar la base de datos!";
            echo resultBlock($msg, 2);
            die;
        }





        //print_r($imagen);

        die;
    }




    switch ($operacion) {
        case "alta":
            //altacurso($dato);
            break;
        case "baja":
            bajacurso($dato);
            break;
        case "modificacion":
            modificacioncurso($dato);
            break;
        case "consulta":
            consultacursos($dato);
            break;
        default:
            //error("operacion");//opcion de operacion no inexistente
    }
}
//FIN DE FUNCIONES DE CURSO 


//FUNCIONES DE ELEMENTO TEMA
function tema($operacion, $dato)
{
    //Alta
    function altatema($dato)
    {
        //$imagen=$dato['imagen']
        //$descripcion=$dato['descripcion'];
        $idcurso = $dato['idcurso'];
        $nombre = $dato['nombre'];
        //Insertamos tema nuevo y devolvemos temas actulizados,la descripcion e imagenes se podra cargar despues
        $sql = MySQLDB::getInstance()->query("SELECT * FROM themes where idcourse='$idcurso' and name='$nombre'");

        if ($sql->num_rows != 0) {
            echo 1; //tema existente
            die;
        } else {
            //realizamos el insert del nuevo tema   

            $sql = MySQLDB::getInstance()->query("INSERT INTO themes (idcourse,name) VALUES ('$idcurso','$nombre')");
            echo consultatemas($idcurso);
            die;
        }
    }
    //baja 
    function bajatema($dato)
    {

        $idtema = $dato['idtema'];
        $idcurso = $dato['idcurso'];

        $sql = MySQLDB::getInstance()->query("SELECT * FROM themes where id='$idtema' ");

        if ($sql->num_rows != 0) {
            //Eliminamos el tema

            if (MySQLDB::getInstance()->query("DELETE FROM themes WHERE id ='$idtema'")) {
                consultatemas($idcurso);
                die;
            } else {
                echo 2; //no puede borrar esta categoria por que esta asignada a al menos un video
                die;
            }
        } else {
            echo 3; //categoria inexistente
            die;
        }
    }
    //modificación
    /*function modificaciontema($dato)
   {
   }*/
    //Consulta
    function consultatemas($dato)
    {
        $idcurso = $dato;
        //Listamos todos los temas de un curso usando su id
        $sql = MySQLDB::getInstance()->query("SELECT * FROM themes where idcourse='$idcurso' ");
        if ($sql->num_rows) {
            $i = 0;
            $temas = '<option value="0" selected>Seleccionar...</option>';
            while ($rs = $sql->fetch_assoc()) {
                $option = '<option value="' . $rs['id'] . '">' . $rs['name'] . '</option>';
                $temas = $temas . $option;
                $i++;
            }
        } else {
            $temas = "No hay temas cargados en este curso";
        }

        echo $temas;
        die;
    }


    switch ($operacion) {
        case "alta":
            altatema($dato);
            break;
        case "baja":
            bajatema($dato);
            break;
        case "modificacion":
            // modificaciontema($dato);
            break;
        case "consulta":
            consultatemas($dato);
            break;
        default:
            //error("operacion");//opcion de operacion no inexistente
    }
}
//FIN DE FUNCIONES DE TEMA 

//FUNCIONES DE ELEMENTO VIDEO
function video($operacion, $dato)
{



    //Alta
    function altavideo()
    {
    }

    //modificación
    function modificacionvideo()
    {
    }
    //baja 
    function bajavideo($dato)
    {

        $idvideo = $dato;
        $sql3 = MySQLDB::getInstance()->query("SELECT * FROM files  WHERE idvideo = $idvideo ");
        while ($rs2 = $sql3->fetch_assoc()) {

            $namefile = $rs2['filename'];
            $idfile = $rs2['id'];
            filedelete($idfile, $namefile);
        }

        $sql = MySQLDB::getInstance()->query("DELETE FROM videoscourse WHERE id ='$idvideo'");
        if ($sql) {
            echo 1;
            die;
        } else {
            echo 2; //error al borrar video
            die;
        }
    }
    //Consulta
    function consultavideos($dato)
    {
        $idvideo = $dato;
        //consultamos en la tabla de videos un video que tenga el mismo id
        $sql2 = MySQLDB::getInstance()->query("SELECT * FROM videoscourse  WHERE id = $idvideo");

        while ($rs1 = $sql2->fetch_assoc()) {

            $idvideo = $rs1['id'];
            $sql3 = MySQLDB::getInstance()->query("SELECT * FROM files  WHERE idvideo = $idvideo ");
            while ($rs2 = $sql3->fetch_assoc()) {
                $archivos[] = array(
                    'id' => $rs2['id'], 'name' => $rs2['name'], 'filename' => $rs2['filename']
                );
            }

            if (!isset($archivos)) {
                $videos = array(
                    'idtheme' => $rs1['idtheme'], 'idcourse' => $rs1['idcourse'], 'id' => $rs1['id'], 'name' => $rs1['name'], 'title' => $rs1['title'],
                    'description' => $rs1['description']
                );
            } else {
                $videos = array(
                    'idtheme' => $rs1['idtheme'], 'idcourse' => $rs1['idcourse'], 'id' => $rs1['id'], 'name' => $rs1['name'], 'title' => $rs1['title'],
                    'description' => $rs1['description'], 'archivos' => $archivos
                );
            }
        }
        echo json_encode($videos); //  Array de videos
        die;
    }

    switch ($operacion) {
        case "alta":
            altavideo($dato);
            break;
        case "baja":
            bajavideo($dato);
            break;
        case "modificacion":
            modificacionvideo($dato);
            break;
        case "consulta":
            consultavideos($dato);
            break;
        default:
            //error("operacion");//opcion de operacion no inexistente
    }
}
//FIN DE FUNCIONES DE VIDEO 

function error($tipoerror)
{
}
