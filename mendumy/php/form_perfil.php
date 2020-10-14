<?php
include("mysqli.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();

    $userid = $_SESSION['id'];
} else {
    $userid = $_SESSION['id'];
}

$dato = $userid;
$sql = MySQLDB::getInstance()->query("SELECT * FROM users where id='$dato' ");
$rs = $sql->fetch_assoc();
$name = $rs['name'];
$lastname = $rs['lastname'];
$idprofesion = $rs['idprofesion'];
$dni = $rs['dni'];
$d = $rs['date_birth'];
$date = date("d/m/Y", strtotime($d));
?>





<div class="container d-flex justify-content-center  " id="ventana-admin">

    <div id="loginbox1" style="background:white;" class="mainbox-sm col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-1 mb-5 ">

        <div class="panel panel-info">
            <div class="modal-header">
                <div class="panel-title ">Datos personales</div> <i class="fas fa-users-cog"></i>

            </div>

            <div style="padding-top:30px" class="panel-body">

                <form id="formPerfil" class="form-horizontal" role="form" method="POST" autocomplete="off" enctype="multipart/form-data">

                    <div class="form-group">

                        <div class="col-12">
                            <input id="nombre" type="text" class="form-control form-control-sm" value="<?php echo $name; ?>" name="nombre" placeholder="Nombre*" required>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-12">
                            <input id="apellido" type="text" class="form-control form-control-sm" value="<?php echo $lastname; ?>" name="apellido" placeholder="Apellido*" required>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-12">
                            <input id="DNI" type="text" class="form-control form-control-sm" value="<?php echo $dni; ?>" name="dni" placeholder="DNI*" required>
                        </div>
                    </div>

                    <div class="input-group input-group-sm col-12 mb-2">
                        <div class="input-group-prepend ">
                            <label class="input-group-text" for="input-select-formacion" required>Formación</label>
                        </div>

                        <select class="custom-select custom-select col-12" name="formacion" id="input-select-formacion" idprofesion="<?php echo $idprofesion; ?>" title="seleccionar formación*">
                            <option selected>Seleccionar...</option>
                            <option value="1">Estudiante de Derecho</option>
                            <option value="2">Abogado</option>
                            <option value="3">Escribano</option>
                            <option value="4">Escribano Novel</option>
                            <option value="5">Otros</option>

                        </select>


                    </div>
                    <div class="form-group">
                        <label for="date2">Fecha nacimiento</label>
                        <input type="text" id="date2" class="form-control datepicker col-12" name="fecha" placeholder="Nacimiento*" value="<?php echo $date; ?>" data-date-format="mm/dd/yyyy" id="dp">
                    </div>

                    <div class="modal-header pt-0">
                        <!-- Separador -->
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <button id="guardarDatos" type="submit" value="guardar" class="btn btn-warning">Guardar</button>
                            <div id="change-pass" style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Cambiar contraseña</a></div>
                        </div>
                    </div>
                    <div id="alert">

                    </div>

                </form>


            </div>
        </div>
    </div>

    <!--Formulario de cambio de password -->
    <div id="loginbox2" style="margin-top:50px;background:white;" class="d-none mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-2 mb-5 ">

        <div class="panel panel-info">
            <div class="modal-header">
                <div class="panel-title">Cambiar Password</div>
                <div id="back-perfil" style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Volver</a></div>
            </div>

            <div style="padding-top:30px" class="panel-body">

                <form id="passForm" class="form-horizontal" role="form" action="restorepasshandler.php" method="POST" autocomplete="off">


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
                            <button id="cambiarPass" type="submit" class="btn btn-warning">Modificar</a>
                        </div>

                    </div>
                    <div id="alert1">

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>