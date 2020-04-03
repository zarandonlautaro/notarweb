<?php
include("mysqli.php");


if (isset($_POST['categoria'])) {
    $categoria = trim(filter_var($_POST['categoria'], FILTER_SANITIZE_STRING));

        if (!($categoria)) { //Filtrado de variables
        echo "4"; //Quiere romper algo
        die;
        }
    }

if (isset($_POST['operacion'])&&$_POST['operacion']=='agregaconsulta'){
    //Agregar categoria o consultar
 
        
                if($categoria=="traer"){

                //Select las categorias
                    echo buscarCategorias();
                }else{
                
                    //Insertamos la nueva categoria
                    //devolvemos categorias actulizadas
                    $sql = MySQLDB::getInstance()->query("SELECT * FROM categories where name='$categoria' ");
                
                    if ($sql->num_rows!=0) {
                        echo 1;//categoria existente
                        die;
                        }else{
                        //realizamos el insert de la nueva categoria        
                        
                        $sql = MySQLDB::getInstance()->query("INSERT INTO categories (name) VALUES ('$categoria')");      
                        echo buscarCategorias();
                        die;
                        }

                
                
                }    
             

    }
    else{
      
                $sql = MySQLDB::getInstance()->query("SELECT * FROM categories where name='$categoria' ");   
           
                if ($sql->num_rows!=0) {
                //Eliminamos la categoria
                     
                    if(MySQLDB::getInstance()->query("DELETE FROM categories WHERE name ='$categoria'") ){
                        echo buscarCategorias(); 
                        die;
                    }else{
                        echo 2;//no puede borrar esta categoria por que esta asignada a al menos un video
                    }
                   

                }
                else{
                    echo 3;//categoria inexistente
                }
            

            
            /*
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>*/
        
    }



    function buscarCategorias(){

    //Select las categorias
    $sql = MySQLDB::getInstance()->query("SELECT * FROM categories ");
        if ($sql->num_rows) {
            $i=0;
            $categorias='<option selected>Seleccionar...</option>';
            while ($rs = $sql->fetch_assoc()) {
                $option='<option value="'.$i.'">'.$rs['name'].'</option>';
                $categorias=$categorias.$option;
                $i++;
            }
            
        }

        return $categorias;
  }

  
?>
