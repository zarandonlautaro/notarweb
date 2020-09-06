
<?php

include("funcs.php");
include("mysqli.php");

$opcion = $_POST['opcion'];
$idcourse = $_POST['idcourse'];
$nombrecurso = 'Nombre de curso';

if ($opcion == "agregar") {
    $dni = $_POST['dni'];
    $mail = $_POST['mail'];
    
    if($dni==""||$mail==""){
        $msg = array("Debe introducir DNI y correo.");
        resultBlock($msg, 2);
        die;
    }
    $sql1 = MySQLDB::getInstance()->query("SELECT * FROM users WHERE dni='$dni' AND username='$mail'");

    if ($sql1->num_rows) {

        $rs = $sql1->fetch_assoc();
        $id = $rs['id'];
        $nombre = $rs['name'];
        $apellido = $rs['lastname'];

        $sql2 = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse='$idcourse' AND iduser='$id'");

        if ($sql2->num_rows) {
            $msg = array("<b>" . $nombre . "</b> <b>" . $apellido . "</b> ya tiene asignado el curso <b>" . $nombrecurso . "</b>");
            resultBlock($msg, 2);
            die;
        } else {
            $sql2 = MySQLDB::getInstance()->query("INSERT INTO courseuser  (idcourse,iduser,saledate,paid) VALUES ('$idcourse','$id',NOW(),0)");

            $msg = array('<b>' . $nombre . "</b> <b>" . $apellido . "</b> id=" . $id . "  ha sido inscripto en el curso: <b>" . $nombrecurso . "</b>  con éxito");
            resultBlock($msg, 1);
            die;
        }
    } else {
        $msg = array("DNI: <b>" . $dni . "</b> correo: <b>" . $mail . "</b> no se encuentra en la base de datos");
        resultBlock($msg, 2);
        die;
    }
} else {
    if ($opcion == "listar") {
        $sql3 = MySQLDB::getInstance()->query("SELECT * FROM courseuser WHERE idcourse='$idcourse'");
        if ($sql3->num_rows) {
            while ($rs3 = $sql3->fetch_assoc()) {
                $iduser = $rs3['iduser'];
                $sql4 = MySQLDB::getInstance()->query("SELECT * FROM users WHERE  id='$iduser'");
                $rs4 = $sql4->fetch_assoc();

                $usuarios[] = array('id' => $rs4['id'], 'name' => $rs4['name'], 'lastname' => $rs4['lastname'], 'dni' => $rs4['dni']);

                $usuarios2[] = array(
                    'id = ' . $rs4['id'] . '  name = ' . $rs4['name'] . ' lastname = ' . $rs4['lastname']
                );
            }

            echo json_encode($usuarios);
            die;
        } else {
            $msg = array("Curso vacío");
            //echo "curso vacio";
            resultBlock($msg, 2);
            die;
        }
    }
}

?>