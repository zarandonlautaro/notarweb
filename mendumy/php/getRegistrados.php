<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("mysqli.php");

$sql = MySQLDB::getInstance()->query("SELECT COUNT(id) FROM users");
if ($sql->num_rows){
    $rs = $sql->fetch_array();
    echo "Usuarios activos: " . $rs[0];
    die;
} else {
    echo 2 ;//ERROR usr/pass
    die;
}

