function selectcourse() {
    $('#select-course').on('change', function (e) {
        if ($("#select-course option:selected").val() != 0) {
            let idcurso = $("#select-course option:selected").val();
            agregarusercourse(idcurso);
            listarusuarios(idcurso);
        }
    });

  

}

function agregarusercourse(idcurso) {

    $("#course-user-add").click(function (e) {
        e.preventDefault();
        let dni = $('#dni').val();
        let mail = $('#mail').val();
        let opcion = "agregar";
        console.log(mail);
        //Comprobamos que tenga el curso comprado

        $.ajax({
            url: "./php/asignar_curso_user.php",
            method: "POST",
            data: {
                "idcourse": idcurso,
                'dni': dni,
                "opcion": opcion,
                'mail':mail
            },
            beforeSend: function () { //Previo a la peticion tenemos un cargando
                $('#course-user-add').removeClass('btn-success');
                $('#course-user-add').addClass('btn-dark');
                $('#course-user-add').attr("disabled", "disabled");


            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#course-user-add').removeClass('btn-dark');
                $('#course-user-add').addClass('btn-success');
                $('#course-user-add').removeAttr("disabled");

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#course-user-add').removeClass('btn-dark');
                $('#course-user-add').addClass('btn-success');
                $('#course-user-add').removeAttr("disabled");

            },
            success: function (data) {
                console.log(data);
                //let r = JSON.parse(data);
                $('#alert').empty().append(data);


            }
        });
    });
}

function consultarcursos() {
    let elemento = 'curso';
    let operacion = 'consulta';
    let dato = 'select'; //consulta devuelve datos para un select

    $.ajax({

        url: "./php/abmc.php",
        type: "post",
        dataType: "html",
        data: {
            "elemento": elemento,
            "operacion": operacion,
            "dato": dato
        },
        success: function (rs) {
            //console.log(rs);
            $("#select-course").empty().append(rs);;

        }


    });


}
function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}

function listarusuarios(idcurso) {
    $("#listar-course-user-add").click(function (e) {
        e.preventDefault();

        let opcion = "listar";
        console.log("listar");
        //Comprobamos que tenga el curso comprado

        $.ajax({
            url: "./php/asignar_curso_user.php",
            method: "POST",
            data: {
                "idcourse": idcurso,
                "opcion": opcion
            },
            beforeSend: function () { //Previo a la peticion tenemos un cargando
                $('#listar-course-user-add').removeClass('btn-success');
                $('#listar-course-user-add').addClass('btn-dark');
                //$('#listar-course-user-add').attr("disabled", "disabled");


            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#course-user-add').removeClass('btn-dark');
                $('#course-user-add').addClass('btn-success');
                $('#course-user-add').removeAttr("disabled");
               
            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#listar-course-user-add').removeClass('btn-dark');
                $('#listar-course-user-add').addClass('btn-success');
                $('#listar-course-user-add').removeAttr("disabled");

            },
            success: function (data) {

             
                if(isJson(data))
                {
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
                        '<th scope="row">' + (i + 1) + '</th>' +
                        '<td>' + r['name'] + '</td>' +
                        '<td colspan="2">' +

                        '<div class="row d-flex justify-content-around">' +
                        '<li>' + r['name'] + ' ' + r['lastname'] + ' id=' + r['id'] + ' <b>DNI</b> : ' + r['dni'] + ' </li>'
                    '</div>' +

                    '</td>' +

                    '</tr>';


                });
                tabla += '</tbody></table> </div>';

                $('#alert').empty().append(tabla);
            }else{
                let rs =data;
                $('#alert').empty().append(rs);
            }



            }
        });
    });
}


$(document).ready(function () {
    consultarcursos();
    selectcourse()

});