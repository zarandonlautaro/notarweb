<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mendumy</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/home.css" rel="stylesheet">
    <link rel="shortcut icon" type="/image/png" href="../img/favicon.png" />


</head>
<!--id price name description category creationdate modificationdate imgname -->

<body class="vh-100 " style="background:black;">


    <div class="container d-flex justify-content-center ">

        <div id="loginbox" style="margin-top:50px;background:white;" class="mainbox-sm col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-1 mb-5 ">

            <div class="panel panel-info">
                <div class="modal-header">
                    <div class="panel-title ">Subir curso</div> <i class="fas fa-photo-video"></i>

                </div>

                <div style="padding-top:30px" class="panel-body">

                    <form id="formFile" class="form-horizontal" role="form" method="POST" autocomplete="off" enctype="multipart/form-data">

                        <div class="form-group">

                            <div class="col-12">
                                <input id="nombre" type="text" class="form-control form-control-sm" name="nombre" placeholder="Nombre" required>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-12">
                                <input id="precio" type="text" class="form-control form-control-sm" name="precio" placeholder="Precio" required>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-12">
                                <input id="categoria" type="text" class="form-control form-control-sm" name="categoria" placeholder="Categoría" required>
                            </div>
                        </div>
                        <div class="modal-header pt-0">
                            <!-- Separador -->
                        </div>
                        <div class="form-group">
                            <label for="imagen" class="col-sm-12 col-form-label">Imagen</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control-file" id="imagen" name="imagen" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="video" class="col-sm-12 col-form-label">Video</label>
                            <div class="col-sm-12">
                                <input type="file" class=" form-control-file" name="video" id="video" required>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col">
                                <textarea id="descripcion" class="form-control form-control-sm" name="descripcion" placeholder="Descripción" data-dispats="alert" required></textarea>
                            </div>
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button id="cargarVideo" type="submit" value="Subir" class="btn btn-warning">Enviar</button>
                            </div>
                        </div>
                        <div id="alert">

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>







    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/fontawesome-all.min.js"></script>
    <script type="text/javascript">
        function subir() {

            let descripcion = $('#descripcion').val();

            if (descripcion.length < 500) {
                var Form = new FormData($("#formFile")[0]);
                // alert($("#formFile").serialize());    

                $.ajax({

                    url: "file.php",
                    type: "post",
                    dataType: "html",
                    data: Form,
                    cache: false,
                    contentType: false,
                    processData: false,

                    beforeSend: function() { //Previo a la peticion tenemos un cargando
                        $('#cargarVideo').removeClass('btn-warning');
                        $('#cargarVideo').addClass('btn-dark');
                        $('#cargarVideo').html('<span class="spinner-border spinner-border-sm" disabled></span>');

                    },
                    error: function(error) { //Si ocurre un error en el ajax
                        //alert("Error, reintentar. "+error);
                        $('#cargarVideo').removeClass('disabled');
                        $('#cargarVideo').addClass('btn-primary');
                        $('#cargarVideo').html('Enviar');

                    },
                    complete: function() { //Al terminar la peticion, sacamos la "carga" visual
                        $('#cargarVideo').removeClass('btn-info');
                        $('#cargarVideo').removeClass('btn-dark');
                        $('#cargarVideo').addClass('btn-warning');
                        $('#cargarVideo').html('Enviar');
                    },

                    success: function(data) {
                        console.log(data);
                        //$('#alert').addClass('alert-warning');
                        $('#alert').empty().append(data);
                    }

                });

            } else {

                console.log("entro en fun");
                $('#alert').addClass('alert-warning');
                $('#alert').empty().append(
                    '<div id="alert" class="alert alert-dismissible fade show mb-4" role="alert">' +
                    '<strong>Error:</strong> Cantidad máxima de caracteres 500' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' +
                    '</div>'
                );
            }

        }

        $("#cargarVideo").click(function(e) {
            e.preventDefault(); //prevenimos accion por defecto del form
            subir();
        });
    </script>

</body>

</html>