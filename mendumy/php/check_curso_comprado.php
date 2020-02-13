<?php
include("mysqli.php");

if (isset($_POST['idcourse'])) {
    $idcourse = trim(filter_var($_POST['idcourse'], FILTER_VALIDATE_INT));
    if (!($idcourse)) { //Filtrado de variables
        echo 4; //Quiere romper algo
        die;
    }

    $sql = MySQLDB::getInstance()->query("SELECT id FROM courseuser WHERE idcourse = $idcourse AND iduser = " . $_SESSION['idusr'] . " ");
    if ($sql->num_rows) {
        echo 3; //Comprado

    } else {
        echo 2; //No comprado
        die;
    }
} else {
    echo 1; //Error
    die;
}
