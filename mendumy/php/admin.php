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
                                <input id="nombre" type="text" class="form-control form-control-sm" name="nombre" placeholder="Título" required>
                            </div>
                        </div>

                        <div class="form-group d-flex">

                            <div class="col-6">
                                <input id="precio" type="text" class="form-control form-control-sm" name="precio" placeholder="Precio" required>
                            </div>
                            <div class="custom-control custom-checkbox  col-6">
                                <input type="checkbox" class="custom-control-input" id="cb-gratis">
                                <label class="custom-control-label" for="cb-gratis">Gratis</label>
                            </div>
                        </div>
                        <div class="input-group input-group-sm col-12">
                            <div class="input-group-prepend ">
                                <label class="input-group-text" for="input-select">Categoria</label>
                            </div>

                            <select class="custom-select custom-select col-6" id="input-select" title="seleccionar categoría">
                                <option selected>Seleccionar...</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="-">Otro</option>

                            </select>
                            <input type="text" class="form-control col-3 " id="categoria" name="categoria">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-success" id="btn-agregar" type="button" title="agregar nueva categoría"><i class="fas fa-check"></i></button>
                            </div>
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-danger" id="btn-eliminar" type="button" title="eliminar categoría"><i class="fas fa-times"></i></button>
                            </div>

                        </div>
                        <div class="modal-header pt-0">
                            <!-- Separador -->
                        </div>
                        <div class="form-group form-group-sm col-12">
                            <label for="imagen" class="col-sm-12 col-form-label">Imagen</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control-file" id="imagen" name="imagen" required>
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
            console.log($('#descripcion').val());
            console.log($('#input-select').val());

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

                cartelError('Cantidad máxima de caracteres 500');
            }

        }


        $('#cb-gratis').on('change', function(e) {
            if (this.checked) {
                $('#precio').attr("disabled", "disabled");
                $('#precio').val(0);
                console.log($('#precio').val)
                console.log('Checkbox ' + $(e.currentTarget).val() + ' checked');
            } else {
                $('#precio').removeAttr("disabled");
                $('#precio').val("");
                console.log('Checkbox ' + $(e.currentTarget).val() + ' unchecked');
            }
        });





        function cargarCategorias(operacion, categoria) {

            $.ajax({

                url: "categoria.php",
                type: "post",
                dataType: "html",
                data: {
                    "operacion": operacion,
                    "categoria": categoria
                },


                beforeSend: function() { //Previo a la peticion tenemos un cargando


                },
                error: function(error) { //Si ocurre un error en el ajax
                    //alert("Error, reintentar. "+error);

                },
                complete: function() { //Al terminar la peticion, sacamos la "carga" visual

                },

                success: function(rs) {
                    console.log(rs);
                    //$('#alert').addClass('alert-warning');
                    if (rs == 1) {

                        cartelError('¡Categoria existente!');
                    } else {
                        if (rs == 4) {
                            cartelError('Valor no permitido.');

                        } else {
                            if (rs == 3) {
                                cartelError("Categoría inexistente");

                            } else {
                                if (rs == 2) {
                                    cartelError('No puede borrar esta categoría por que esta asignada a un curso');
                                } else {
                                    $('#input-select').empty().append(rs);
                                    $("#categoria").empty();
                                }
                            }


                        }


                    }

                    $('#input-select').on('change', function(e) {
                        console.log($("#input-select option:selected").text());
                        $('#categoria').val($("#input-select option:selected").text());

                    });
                }

            });


        }

        function cartelError(contenido) {
            $('#alert').removeClass('btn-info');
            $('#alert').addClass('alert-warning');
            $('#alert').empty().append(
                '<div id="alert" class="alert alert-dismissible fade show mb-4" role="alert">' +
                '<strong>Error:</strong> ' + contenido +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' +
                '</div>'
            );

        }

        function cartel(contenido) {
            $('#alert').removeClass('btn-warning');
            $('#alert').addClass('alert-info');
            $('#alert').empty().append(
                '<div id="alert" class="alert alert-dismissible fade show mb-4" role="alert">' +
                '<strong>Aviso:</strong> ' + contenido +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' +
                '</div>'
            );

        }


        $(document).ready(function() {


            $("#cargarVideo").click(function(e) {
                e.preventDefault(); //prevenimos accion por defecto del form
                subir();
            });

            cargarCategorias('agregaconsulta', 'traer');

            $("#btn-eliminar").click(function() {
                let categoria = $("#categoria").val();
                if(categoria!=""){
                var mensaje;
                var opcion = confirm("¿Esta seguro que desea eliminar esta categoría?");
                if (opcion == true) {
                    
                    console.log("eliminar categoria: " + categoria);
                    cargarCategorias('borrar', categoria);
                } else {
                    cartel("Ha cancelado la operación.");
                }
             }

            });

            $("#btn-agregar").click(function() {
                let categoria = $("#categoria").val();
                if(categoria!=""){
                    cargarCategorias('agregaconsulta', categoria);
                }
            });

        });
    </script>

</body>

</html>