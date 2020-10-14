<?php
include("mysqli.php"); 
require_once('../php/funcs.php');

$id=$_POST['id'];
$namefile=$_POST['filename'];
if(filedelete($id,$namefile)){
    echo 1;//archivo eliminado
}else{
    echo 2;//error al eliminar archivo
}

?>