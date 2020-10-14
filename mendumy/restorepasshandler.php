<?php
include("php/mysqli.php");
include("php/funcs.php");

if (isset($_POST['password'])&&isset($_POST['con_password'])) {
    $idusr = trim(filter_var($_POST['user_id'], FILTER_VALIDATE_INT));
    $token = trim(filter_var($_POST['token'], FILTER_SANITIZE_STRING));
    $p1 = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
    $p2 = trim(filter_var($_POST['con_password'], FILTER_SANITIZE_STRING));
    
    if(validaPassword($p1, $p2)&& longitudPass($p1))
    {
        $pass=$pass_hash = hash("SHA256", $p1);
        $q1 = MySQLDB::getInstance()->query("UPDATE recover SET token_password='$token', password_request=0,last_modification=NOW() WHERE idusr = '$idusr'");
        $q2 = MySQLDB::getInstance()->query("UPDATE users SET password='$pass' WHERE id = '$idusr'");
        if($q1&&$q2){
            echo "todo correcto";
        }

        
        die;
    }else{
        echo "La contraseña y su confirmación deben ser iguales y longitud mayor a 7 caracteres";
        die;
    }
   // $check = MySQLDB::getInstance()->query("UPDATE recover SET token_password='$token', password_request=0,last_modification=NOW() WHERE idusr = '$user_id'");
}

if (isset($_GET['id'])) {
    $idusr = trim(filter_var($_GET['id'], FILTER_VALIDATE_INT));
    $token = trim(filter_var($_GET['token'], FILTER_SANITIZE_STRING));
    if (!($idusr)) {
        echo 0; //Error
        die;
    }

    $sqlid = MySQLDB::getInstance()->query("SELECT * FROM recover WHERE idusr = '$idusr' AND token_password =  '$token' AND password_request = 1");
    //$registroRecover = $sqlid->fetch_assoc();
    //$passReq = $registroRecover['password_request']; $passReq == 0

    if ($sqlid->num_rows==0) {
        echo "Vuelva a solicitar cambio de password";
        die;
    } else { ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mendumy</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
    <link rel="shortcut icon" type="./image/png" href="img/favicon.png" />


</head>

<body class="d-flex justify-content-center align-items-center vh-100 ">

    <div class=".container-fluid w-100">
        <div class=" d-flex">

            <div class="justify-content-center align-items-center " id="page-content-wrapper" style="background: rgba(200, 200, 200, 0.5);">
                <div class="container d-flex justify-content-center ">

                    <div id="loginbox" style="margin-top:50px;background:white;" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-2 mb-5 ">

                        <div class="panel panel-info">
                            <div class="modal-header">
                                <div class="panel-title">Cambiar Password</div>
                                <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Iniciar Sesi&oacute;n</a></div>
                            </div>

                            <div style="padding-top:30px" class="panel-body">

                                <form id="loginform" class="form-horizontal" role="form" action="restorepasshandler.php" method="POST" autocomplete="off">

                                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $idusr; ?>" />

                                    <input type="hidden" id="token" name="token" value="<?php echo $token; ?>" />

                                    <div class="form-group">
                                        <label for="password" class="col-12 control-label">Nuevo Password</label>
                                        <div class="col-12">
                                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="con_password" class="col-12 control-label">Confirmar Password</label>
                                        <div class="col-12">
                                            <input type="password" class="form-control" name="con_password" placeholder="Confirmar Password" required>
                                        </div>
                                    </div>

                                    <div style="margin-top:10px" class="form-group">
                                        <div class="col-sm-12 controls">
                                            <button id="btn-login" type="submit" class="btn btn-warning">Modificar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/fontawesome-all.min.js"></script>


</body>

</html>








<?php }
}else{echo "error";}
?>