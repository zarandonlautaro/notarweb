<?php
include('mysqli.php');

$sql = MySQLDB::getInstance()->query("SELECT name,description,category,imgname FROM course ORDER BY creationdate DESC");
if ($sql->num_rows) {
    while ($rs = $sql->fetch_assoc()) {
        $cursos[] = $rs;
    }
    echo json_encode($cursos); //Array de cursos
} else {
    echo 0; //No hay cursos para mostrar
    die;
}
