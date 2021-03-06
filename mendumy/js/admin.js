//script encargado de subir cursos
function subir() {

    let descripcion = $('#descripcion').val();
    console.log($('#descripcion').val());
    console.log($('#input-select').val());

    if (descripcion.length < 500) {
        $('#precio').removeAttr("disabled");
        var Form = new FormData($("#formFile")[0]);
        // alert($("#formFile").serialize());    

        $.ajax({

            url: "./php/file.php",
            type: "post",
            dataType: "html",
            data: Form,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () { //Previo a la peticion tenemos un cargando
                $('#cargarCurso').removeClass('btn-warning');
                $('#cargarCurso').addClass('btn-dark');
                $('#cargarCurso').html('<span class="spinner-border spinner-border-sm" disabled></span>');

            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#cargarCurso').removeClass('disabled');
                $('#cargarCurso').addClass('btn-primary');
                $('#cargarCurso').html('Enviar');

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#cargarCurso').removeClass('btn-info');
                $('#cargarCurso').removeClass('btn-dark');
                $('#cargarCurso').addClass('btn-warning');
                $('#cargarCurso').html('Enviar');
            },

            success: function (data) {
                console.log(data);
                //$('#alert').addClass('alert-warning');
                $('#alert').empty().append(data);
            }

        });

    } else {

        cartelError('Cantidad máxima de caracteres 500');
    }

}

function botonGratis() {
    $('#cb-gratis').on('change', function (e) {
        if (this.checked) {
            $('#precio').attr("disabled", "disabled");
            $('#precio').val(0);
            //console.log($('#precio').val)
            //console.log('Checkbox ' + $(e.currentTarget).val() + ' checked');
        } else {
            $('#precio').removeAttr("disabled");
            $('#precio').val("");
            //console.log('Checkbox ' + $(e.currentTarget).val() + ' unchecked');
        }
    });
}





function cargarCategorias(operacion, categoria) {

    $.ajax({

        url: "./php/categoria.php",
        type: "post",
        dataType: "html",
        data: {
            "operacion": operacion,
            "categoria": categoria
        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando


        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (rs) {
            //console.log(rs);
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
            //detectamos si el select de categoria ha sido cambiado para activar el select de subcategorias
            $('#input-select').on('change', function (e) {
                console.log($("#input-select option:selected").val());

                if ($("#input-select option:selected").text() != "Seleccionar...") {
                    $('#categoria').val($("#input-select option:selected").text());
                    habilitasubcategoria(true)

                    subcategoria("traer", $("#input-select option:selected").val(), "");

                } else {
                    habilitasubcategoria(false)
                }

            });
        }

    });


}

function habilitasubcategoria(op) {
    if (op) {
        $('#subcategoria').removeAttr("disabled");
        $('#input-select-sub').removeAttr("disabled");
        $('#btn-agregar-sub').removeAttr("disabled");
        $('#btn-eliminar-sub').removeAttr("disabled");
    } else {
        $('#subcategoria').attr("disabled", "disabled");
        $('#input-select-sub').attr("disabled", "disabled");
        $('#btn-agregar-sub').attr("disabled", "disabled");
        $('#btn-eliminar-sub').attr("disabled", "disabled");
        $('#categoria').val("");
    }
}


function subcategoria(operacion, idcategoria, subcategoria) {

    $.ajax({

        url: "./php/subcategoria.php",
        type: "post",
        dataType: "html",
        data: {
            "operacion": operacion,
            "idcategoria": idcategoria,
            "subcategoria": subcategoria
        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando


        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (rs) {
            //console.log(rs);
            //$('#alert').addClass('alert-warning');

            switch (rs) {

                case "1": cartelError('¡Subcategoria existente!'); break;
                case "2": cartelError('No puede borrar esta categoría por que esta asignada a un curso'); break;
                case "3": cartelError("Subcategoría inexistente"); break;
                case "4": cartelError('Valor no permitido.'); break;
                case "5": cartelError('No se pudo ejecutar la consulta a la base de datos'); break;
                default:
                    $('#input-select-sub').empty().append(rs);
                    $("#subcategoria").empty();
                    console.log(rs);
                    ; break;
            }


            $('#input-select-sub').on('change', function (e) {
                console.log($("#input-select-sub option:selected").text());

                if ($("#input-select-sub option:selected").text() != "Seleccionar...") {
                    $('#subcategoria').val($("#input-select-sub option:selected").text());

                } else {
                    $('#subcategoria').val("");
                }

            });
        }

    });


}

function agregasubcategoria() {

    $("#btn-agregar-sub").click(function () {
        let subcat = $("#subcategoria").val();
        let idcategoria = $("#input-select option:selected").val();
        if (subcat != "") {
            subcategoria('agrega', idcategoria, subcat);
        }
    });
}
function eliminarsubcat() {

    $("#btn-eliminar-sub").click(function () {
        let subcat = $("#subcategoria").val();//capturo el nombre de la subcategoria
        let idcategoria = $("#input-select option:selected").val();//capturo el id de la categoria dentro de la cual se va a a guardar la subcat

        if (subcat != "") {

            var opcion = confirm("¿Esta seguro que desea eliminar esta categoría?");
            if (opcion == true) {

                console.log("eliminar subcategoria: " + subcat);
                subcategoria('borra', idcategoria, subcat);
            } else {
                cartel("Ha cancelado la operación.");
            }
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
function traerCredenciales(operation, credential, name, id) {
  
    //solo se usa operation
    $.ajax({

        url: "./php/credentials.php",//script para subir cursos a la base de datos
        type: "post",
        data: {

            "operation": operation,
            "credential": credential,
            "name": name,
            "id": id,

        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando
                
                   
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {
            
                
           
            //console.log(data);
            //$('#alert').addClass('alert-warning');
            if (data == 1) {
                credenciales("traer2", "", "", "");
                $('#alert').empty().append('<h6 class="alert alert-success"> <strong>¡Guardado exitoso!</strong>. </h6>');
            } else {
                if (data == 2) {
                    credenciales("traer2", "", "", "");
                    $('#alert').empty().append('<h6 class="alert alert-warning"> <strong>¡Error!</strong>. </h6>');
                } else {
                    $('#input-select-credential').empty().append(data);
                   
                }
            }




        }

    });

}



$(document).ready(function () {



    $("#cargarCurso").click(function (e) {
        e.preventDefault(); //prevenimos accion por defecto del form
        subir();
    });
    traerCredenciales('traerselect',"","","");
    cargarCategorias('agregaconsulta', 'traer');

    botonGratis();
    $("#btn-eliminar").click(function () {
        let categoria = $("#categoria").val();
        if (categoria != "") {

            var opcion = confirm("¿Esta seguro que desea eliminar esta categoría?");
            if (opcion == true) {

                console.log("eliminar categoria: " + categoria);
                cargarCategorias('borrar', categoria);
            } else {
                cartel("Ha cancelado la operación.");
            }
        }

    });

    $("#btn-agregar").click(function () {
        let categoria = $("#categoria").val();
        if (categoria != "") {
            cargarCategorias('agregaconsulta', categoria);
        }
    });
    agregasubcategoria();
    eliminarsubcat();
});