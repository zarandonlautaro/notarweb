<?php
//ABMC =ALTA BAJA MODIFICACION Y CONSULTA
include("mysqli.php");
//lectura de parámetros elemento puede ser: curso,tema o video
if (isset($_POST['elemento']) && isset($_POST['operacion']) && isset($_POST['dato'])) {

    //filtrado de variables
    $elemento = trim(filter_var($_POST['elemento'], FILTER_SANITIZE_STRING));
    $operacion = trim(filter_var($_POST['operacion'], FILTER_SANITIZE_STRING));
    //$dato = trim(filter_var($_POST['dato'], FILTER_SANITIZE_STRING)); dato se filtrara segun el caso
    $dato=$_POST['dato'];

    if (!($elemento) || !($operacion) || !($dato)) { //Filtrado de variables
        echo "4"; //Quiere romper algo
        die;
    }
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
        //video($operacion,$dato);
        break;
    default:
        //error("elemento");//opcion de elemento no inexistente
}

//FUNCIONES DE ELEMENTO CURSO
function curso($operacion, $dato)
{


    
    /*
    //Alta
    function altacurso($dato)
    {
    }
    //baja 
    function bajacurso($dato)
    {
    }
    //modificación
    function modificacioncurso($dato)
    {
    }*/
    //Consulta

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
        }else{
            //consulta que devuelve los datos de otra forma
            echo "consulta de cursos otros";
            die;
        }
    }





    switch ($operacion) {
        case "alta":
            //altacurso($dato);
            break;
        case "baja":
            //bajacurso($dato);
            break;
        case "modificacion":
            //modificacioncurso($dato);
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
       $idcurso=$dato['idcurso'];

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
               $option = '<option value="' . $rs['id']. '">' . $rs['name'] . '</option>';
               $temas = $temas . $option;
               $i++;
           }
       }else{
           $temas="No hay temas cargados en este curso";
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

    //Alta
    function altavideo()
    {
    }
    //baja 
    function bajavideo()
    {
    }
    //modificación
    function modificacionvideo()
    {
    }
    //Consulta
    function consultavideos()
    {
    }
}
//FIN DE FUNCIONES DE VIDEO 

function error($tipoerror)
{
}
?>