<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">

</head>

<body id="page-top">

    <div class="container">
        <form class="form-inline mt-4">

            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" id="dni" placeholder="DNI">
            </div>
            <div class="container">
                <button type="submit" id='course-user-add' class="btn btn-warning mb-2">Aceptar</button>
                <button id='listar-course-user-add' class="btn btn-primary mb-2">Listar</button>
            </div>
        </form>

        <div id="alert">

        </div>
    </div>


</body>
<script src="../vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    function agregarusercourse() {
        $("#course-user-add").click(function(e) {
            e.preventDefault();

            let dni = $('#dni').val();
            console.log(dni);
            let idcurso = 60;
            let opcion="agregar";
            //console.log(id);
            //Comprobamos que tenga el curso comprado

            $.ajax({
                url: "../php/asignar_curso_user.php",
                method: "POST",
                data: {
                    "idcourse": idcurso,
                    'dni': dni,
                    "opcion":opcion
                },
                beforeSend: function() { //Previo a la peticion tenemos un cargando
                    $('#course-user-add').removeClass('btn-success');
                    $('#course-user-add').addClass('btn-dark');
                    $('#course-user-add').attr("disabled", "disabled");


                },
                error: function(error) { //Si ocurre un error en el ajax
                    //alert("Error, reintentar. "+error);
                    $('#course-user-add').removeClass('disabled');
                    $('#course-user-add').addClass('btn-success');
                    $('#course-user-add').removeAttr("disabled");

                },
                complete: function() { //Al terminar la peticion, sacamos la "carga" visual
                    $('#course-user-add').removeClass('btn-dark');
                    $('#course-user-add').addClass('btn-success');
                    $('#course-user-add').removeAttr("disabled");

                },
                success: function(data) {
                    console.log(data);
                    //let r = JSON.parse(data);
                    $('#alert').append(data);


                }
            });
        });
    }
    
    function listarusuarios(){
        $("#listar-course-user-add").click(function(e) {
            e.preventDefault();

            let opcion ="listar"; 
            let idcurso = 95;
            //console.log(id);
            //Comprobamos que tenga el curso comprado

            $.ajax({
                url: "../php/asignar_curso_user.php",
                method: "POST",
                data: {
                    "idcourse": idcurso,
                    "opcion":opcion
                },
                beforeSend: function() { //Previo a la peticion tenemos un cargando
                    $('#listar-course-user-add').removeClass('btn-success');
                    $('#listar-course-user-add').addClass('btn-dark');
                    $('#listar-course-user-add').attr("disabled", "disabled");


                },
                error: function(error) { //Si ocurre un error en el ajax
                    //alert("Error, reintentar. "+error);
                    $('#listar-course-user-add').removeClass('disabled');
                    $('#listar-course-user-add').addClass('btn-success');
                    $('#listar-course-user-add').removeAttr("disabled");

                },
                complete: function() { //Al terminar la peticion, sacamos la "carga" visual
                    $('#listar-course-user-add').removeClass('btn-dark');
                    $('#listar-course-user-add').addClass('btn-success');
                    $('#listar-course-user-add').removeAttr("disabled");

                },
                success: function(data) {
                    
                    let rs = JSON.parse(data);
                    console.log(data);
            

                    let tabla = '<div class="container"> <table class="table table-light table-responsive-sm ">' +
                        '<thead class="thead-dark">' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Curso</th>' +
                        '<th colspan="2" scope="col" class="text-center">Usuarios</th>' +

                        '</tr>' +
                        '</thead>';
                    $.each(rs, (i, r) => {

                        tabla +=
                            '<tbody>' +
                            '<tr>' +
                            '<th scope="row">' + (i+1) + '</th>' +
                            '<td>' + r['name'] + '</td>' +
                            '<td colspan="2">' +

                            '<div class="row d-flex justify-content-around">' +
                            '<li>'+r['name'] +' '+r['lastname']+' id=' +r['id']+' <b>DNI</b> : '+r['dni'] +' </li>'
                            '</div>' +

                            '</td>' +

                            '</tr>';


                    });
                    tabla += '</tbody></table> </div>';

                    $('#alert').append(tabla);


                }
            });
        });
    }


    $(document).ready(function() {
        agregarusercourse();
        listarusuarios();
    });
</script>

</html>