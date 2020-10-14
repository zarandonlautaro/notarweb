
//funcion subir para enviar todo el formulario y subir el video
function subir(operacion) {

    let descripcion = $('#descripcion').val();
    //console.log($('#descripcion').val());


    if (descripcion.length < 500) {
        var Form = new FormData($("#formFile")[0]);
        Form.append('operacion', operacion);
        // alert($("#formFile").serialize());    

        $.ajax({

            url: "./php/upload-video.php",
            type: "post",
            dataType: "html",
            data: Form,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () { //Previo a la peticion tenemos un cargando
                $('#cargarVideo').removeClass('btn-warning');
                $('#cargarVideo').addClass('btn-dark');
                $('#cargarVideo').html('<span class="spinner-border spinner-border-sm" disabled></span>');

            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#cargarVideo').removeClass('disabled');
                $('#cargarVideo').addClass('btn-primary');
                $('#cargarVideo').html('Enviar');

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#cargarVideo').removeClass('btn-info');
                $('#cargarVideo').removeClass('btn-dark');
                $('#cargarVideo').addClass('btn-warning');
                $('#cargarVideo').html('Enviar');
            },

            success: function (data) {
                console.log("Resultado de la peticion " + data);
                //$('#alert').addClass('alert-warning');
                $('#alert').empty().append(data);
            }

        });

    } else {

        cartelError('Cantidad máxima de caracteres 500');
    }

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
//funcion para cargar un tema nuevo o borrarlo 
function temas(operacion, dato) {
    let elemento = 'tema';
    //dato tiene adentro el id de curso 


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
            console.log(rs);
            //$('#alert').addClass('alert-warning');
            if (rs == 1) {

                cartelError('¡Tema existente!');
            } else {
                if (rs == 4) {
                    cartelError('Valor no permitido.');

                } else {
                    if (rs == 3) {
                        cartelError("Tema inexistente");

                    } else {
                        if (rs == 2) {
                            cartelError('No puede borrar este tema por que esta asignado a un video');
                        } else {


                            $('#select-theme').empty().append(rs);
                            $("#theme").empty();

                        }
                    }


                }


            }

            selectinput();
            /*
                                //eliminar tema----------------------------------------------------------------
                                eliminartemas();


                                //agregar tema------------------------------------------------------------------
                                agregartema();*/

        }

    });


}
//Funcion que hace que el select cambie el valor del input
function selectinput() {
    $('#select-theme').on('change', function () {
        if (($("#select-theme option:selected").val()) != 0) {
            $('#theme').val($("#select-theme option:selected").text());
        } else {
            $('#theme').val("");
        }
    });
}

//carteles
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
//funcion que habilita el formulario cuando se selecciona un curso
function habilitarformulario() {

    $('#select-course').on('change', function (e) {
        console.log($("#select-course option:selected").text());
        //controlo que haya seleccionado un curso para recien ahi habilitar el selector de temas
        if ($("#select-course option:selected").val() == 0) {
            $('#select-theme').attr("disabled", "disabled");
            $('#theme').attr("disabled", "disabled");
            $('#btn-add-theme').attr("disabled", "disabled");
            $('#btn-delete-theme').attr("disabled", "disabled");
            $('#nombre').attr("disabled", "disabled");
            $('#imagen').attr("disabled", "disabled");
            $('#videoID').attr("disabled", "disabled");
            $('#descripcion').attr("disabled", "disabled");

            $('#file1').attr("disabled", "disabled");
            $('#btnAdd').attr("disabled", "disabled");
            $('#btnDel').attr("disabled", "disabled");

            cartel("Debe seleccionar un curso.");

        } else {

            $('#select-theme').removeAttr("disabled");
            $('#theme').removeAttr("disabled");
            $('#btn-add-theme').removeAttr("disabled");
            $('#btn-delete-theme').removeAttr("disabled");

            $('#nombre').removeAttr("disabled");
            $('#imagen').removeAttr("disabled");
            $('#videoID').removeAttr("disabled");
            $('#descripcion').removeAttr("disabled");

            $('#file1').removeAttr("disabled");
            $('#btnAdd').removeAttr("disabled");
            $('#btnDel').removeAttr("disabled");


        }
    });

}

function cargatemas() {
    $('#select-course').on('change', function (e) {
        if ($("#select-course option:selected").val() != 0) {
            idcurso = $("#select-course option:selected").val();
            temas('consulta', idcurso);
        }
    });
}

function agregartema() {

    $("#btn-add-theme").click(function () {
        let nombretema = $("#theme").val();
        console.log(nombretema);
        if (nombretema != "") {

            idcurso = $("#select-course option:selected").val();
            console.log(idcurso);
            var dato = {
                "idcurso": idcurso,
                "nombre": nombretema
            };
            temas('alta', dato);
        } else {
            cartelError("Introduzca nombre de tema a agregar.");
        }
    });
}

function eliminartemas() {

    $("#btn-delete-theme").click(function () {
        let nombretema = $("#theme").val();
        let idtema = $("#select-theme option:selected").val();
        let idcurso = $("#select-course option:selected").val();

        var dato = {
            "idcurso": idcurso,
            "idtema": idtema
        };


        console.log("eliminar tema: " + dato["idtema"] + "del curso: " + dato["idcurso"]);
        console.log(nombretema);

        if (nombretema != "" && idtema != 0) {

            var opcion = confirm("¿Esta seguro que desea eliminar esta categoría?");
            if (opcion == true) {



                temas('baja', dato);
            } else {
                cartel("Ha cancelado la operación.");
            }
        } else {
            cartel("No ha seleccionado ningun tema para borrar.");
        }

    });

}
//funciones para inputs dinamicos:agrega inputs file cuando se presiona el botón más + ----------------------------------------------------------------------------
function agregarinput() {
    $('#file1').val("");
    $('#btnDel').attr('disabled', 'disabled');
    $('#btnAdd').click(function () {
        var num = $('.clonedInput').length; // length devuelve la cantidad de elementos de una seleccion
        var newNum = new Number(num + 1); // the numeric ID of the new input field being added

        var newElem = '<fieldset id="input' + newNum + '" class="clonedInput custom-file mb-1">' +
            '<label class="custom-file-label" for="file' + newNum + '">Seleccionar Archivo</label>' +
            '<input type="file" class="custom-file-input " name="file[]" id="file' + newNum + '" /></fieldset>';

        $('#input' + num).after(newElem);
        // enable the "remove" button
        $('#btnDel').attr('disabled', false);

        // business rule: you can only add 10 names
        if (newNum == 10)
            $('#btnAdd').attr('disabled', 'disabled');
        nombreInputfile();

        /*
        // clonamos el elemento actual y le ponemos un id=id+numero de elemento
        var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
        // cambiamos el nombre del elemento
        newElem.children(':last').attr('id', 'input' + newNum).attr('name', 'file' + newNum);
        //newElem.children(':first').attr('placeholder', 'Nombre de archivo ' + newNum);
        //$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        */

    });



}
//quita los inputs file agregados 
function quitarinput() {

    $('#btnDel').click(function () {
        var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
        $('#input' + num).remove(); // remove the last element

        // enable the "add" button
        $('#btnAdd').attr('disabled', false);

        // if only one element remains, disable the "remove" button
        if (num - 1 == 1)
            $('#btnDel').attr('disabled', 'disabled');
    });


}
//muestra el nombre del archivo en el inputs file, esta funcion fue extraida de la pagina de boostrap
function nombreInputfile() {
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        console.log(fileName);
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
}







//eventos disparadores
$(document).ready(function () {
    //Funciones de inputs
    nombreInputfile();
    agregarinput();
    quitarinput();
    //Primero que nada consultamos cursos
    consultarcursos();
    //mostramos un cartel de control
    cartel("Debe seleccionar un curso.");

    habilitarformulario();


    //cargar temas de un curso seleccionado--------------------------------
    cargatemas();


    //eliminar tema----------------------------------------------------------------
    eliminartemas();


    //agregar tema------------------------------------------------------------------
    agregartema();


    //evento para subir video
    $("#cargarVideo").click(function (e) {
        e.preventDefault(); //prevenimos accion por defecto del form
        subir('insert');//modificacion false 
    });




});
