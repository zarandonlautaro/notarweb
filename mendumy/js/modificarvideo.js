
//funcion subir para enviar todo el formulario y subir el video
function subir(operacion) {

    let descripcion = $('#descripcion').val();
    //console.log($('#descripcion').val());


    if (descripcion.length < 500) {
        var Form = new FormData($("#formFile")[0]);
        Form.append('operacion',operacion);
        // alert($("#formFile").serialize());    

        $.ajax({

            url: "./php/upload-video.php",
            type: "post",
            dataType: "html",
            data:Form,
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
function temas(operacion, dato, idtema) {
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
            //console.log(rs);
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

            if(idtema){
                let idtheme=idtema;

                    //selecciona el tema del video
                    $('#select-theme option').each(function () {
                        //console.log($(this).val() + " " + $(this).text());

                        if ($(this).val() == idtheme) {

                            $(this).attr("selected", idtheme);
                            $('#theme').val($(this).text());
                        }

                    });

                    


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

function deshabilita() {

    console.log($("#select-course option:selected").text());
    //controlo que haya seleccionado un curso para recien ahi habilitar el selector de temas

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

}

function habilita() {
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
function habilitarformulario() {

    $('#select-course').on('change', function (e) {
        if ($("#select-course option:selected").val() == 0) {
            deshabilita();

        } else {

            habilita();

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
function eliminararchivo(id,filename){

    $.ajax({
        url: "php/deletefile.php",
        method: "POST",
        data: { "id": id,"filename": filename },
        beforeSend: function () { //Previo a la peticion tenemos un cargando


        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);
    

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },
        success: function (rs) {
            console.log(rs);
            //let r = JSON.parse(rs);
            if(rs==1){
                $('#file'+id).remove();
            }else{
                if(rs==2){
                    cartel("Error al eliminar archivo");
                }
            }
        }
    
    });     

}

function cargarform() {

    let id = $('#CVideo').attr("idvideo");
    let elemento = 'video';
    let operacion = 'consulta';
    let dato = id; //devuelve datos enviando un id

    $.ajax({

        url: "./php/abmc.php",
        type: "post",
        dataType: "html",
        data: {
            "elemento": elemento,
            "operacion": operacion,
            "dato": dato
        },

        success: function (r) {

            let rs = JSON.parse(r);
            let idcurso = rs['idcourse'];
            let idtheme = rs['idtheme'];
            //console.log(rs);
            //LLegnamos el select con los temas


            if (rs['price'] == 0) {
                $('#cb-gratis').attr("checked", "checked");
                $('#precio').attr("disabled", "disabled");
            }


            //Selecciona el curso del video
            $('#select-course option').each(function () {
                //console.log($(this).val() + " " + $(this).text());

                if ($(this).val() == idcurso) {

                    $(this).attr("selected", rs['idcourse']);
                    habilita();
                    temas('consulta', idcurso,idtheme);


                }

            });
            //cargamos los datos traidos de la base de datos en los inputs del formulario
            $('#videoID').val(rs['name']);
            $('#nombre').val(rs['title']);
            $('#precio').val(rs['price']);
            $('#descripcion').val(rs['description']);
            //colocamos los archivos para poder poner una opcion de eliminar archivos
            let archivos=rs['archivos'];
            let files="";
           

            $.each(archivos, (z, r2) => {

                files +=
                

                '<div class="container" id="file'+r2['id']+'" ">'+
                '<div class="row d-flex justify-content-around">'+    
                    '<span  class="archivo text-info text-center col-sm-11 ">' +r2['name']+ '</span>'+
                    '<button class="btn-delete-file btn btn-outline-danger  col-sm-1 " id="'+r2['id']+'" filename="'+r2['filename']+'" type="button" title="eliminar tema" ><i class="fas fa-times"></i></button></div>'+
                '</div>'+ 
                '</div>';


            });
            //console.log(archivos);

            $('#archivos-cargados').empty().append(files);

            $(".btn-delete-file").click(function () {

                let id = $(this).attr("id");
                let filename=$(this).attr("filename");

                var opcion = confirm("¿Estás seguro que desea eliminar este archivo?");
                if (opcion == true) {
                   
                    eliminararchivo(id,filename);
                    
                } else {
                    cartel("Ha cancelado la operación.");
                }

            });
            



        }
        


    });



}





//eventos disparadores
$(document).ready(function () {


    //Primero que nada consultamos cursos
    consultarcursos();
    //cargar temas de un curso seleccionado
    cargatemas();
    //cargamos el formulario con los datos del video seleccionado
    cargarform();
    //Funciones de inputs
    nombreInputfile();
    agregarinput();
    quitarinput();

    //mostramos un cartel de control
    cartel("Debe seleccionar un curso.");

    habilitarformulario();


    //eliminar tema----------------------------------------------------------------
    eliminartemas();


    //agregar tema------------------------------------------------------------------
    agregartema();


    //evento para subir video
    $("#cargarVideo").click(function (e) {
        e.preventDefault(); //prevenimos accion por defecto del form
        subir('update');
    });




});
