<?php
session_start();


if (!isset($_SESSION['id'])) {

    echo 1; //redireccion no esta seteada la variable de sesion
    die();
} else {
    include("mysqli.php");
    $iduser = $_SESSION['id'];
    //echo "el usuario " .$iduser. "solicitó el curso ".$_POST['idcurso'];

    $idcourse = $_POST['idcurso'];

    $sql = MySQLDB::getInstance()->query("SELECT * FROM course  WHERE id = $idcourse ");
    if ($sql->num_rows) {

        //verificamos por seguridad que el curso haya sido comprado con anterioridad
        $sql = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse = $idcourse AND iduser = $iduser  ");



        if ($sql->num_rows) {
            $sql = MySQLDB::getInstance()->query("SELECT * FROM themes  WHERE idcourse = $idcourse ");


            while ($rs = $sql->fetch_assoc()) {
                $idtheme = $rs['id'];
                $sql2 = MySQLDB::getInstance()->query("SELECT * FROM videoscourse  WHERE idtheme = $idtheme ");

                while ($rs1 = $sql2->fetch_assoc()) {
                    $idvideo = $rs1['id'];
                    $sql3 = MySQLDB::getInstance()->query("SELECT * FROM files  WHERE idvideo = $idvideo ");
                    while ($rs2 = $sql3->fetch_assoc()) {
                        $archivos[] = array(
                            'name' => $rs2['name'], 'filename' => $rs2['filename']
                        );
                    }

                    if (!isset($archivos)) {
                        $videos[] = array(
                            'id' => $rs1['id'], 'name' => $rs1['name'], 'title' => $rs1['title'],
                            'description' => $rs1['description']
                        );
                    } else {
                        $videos[] = array(
                            'id' => $rs1['id'], 'name' => $rs1['name'], 'title' => $rs1['title'],
                            'description' => $rs1['description'], 'archivos' => $archivos
                        );
                    }
                    unset($archivos);
                }
                if (isset($videos)) {
                    $temas[] = array(
                        'name' => $rs['name'], 'videos' => $videos
                    );
                }
                //borramos la variable video para volver a usarla en la proxima iteración
                unset($videos);
            }
            echo json_encode($temas); //  Array de cursos
            die;
        }else{
            if($_POST["modificar"]){
               echo json_encode(2);//debe tener el curso asignado para poder modificarlo
               die; 
            }

        }
    }
}
