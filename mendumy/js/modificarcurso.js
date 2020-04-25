//script encargado de subir cursos
function subir() {

    let descripcion = $('#descripcion').val();

    
    let elemento='curso';
    let operacion='modificacion';

    if (descripcion.length < 500) {
        $('#precio').removeAttr("disabled");
        var Form = new FormData($("#formFile")[0]);
        // alert($("#formFile").serialize());    
        
        Form.append('elemento',elemento);
        Form.append('operacion',operacion);
       
      
        $.ajax({

            url: "./php/abmc.php",
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

function botonimagen() {
    $('#cb-imagen').on('change', function () {
        if (this.checked) {
            $('#imagen').removeAttr("disabled");
        } else {
            $('#imagen').attr("disabled","disabled");
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

            $('#input-select').on('change', function (e) {
                console.log($("#input-select option:selected").text());
                if($("#input-select option:selected").text()!="Seleccionar..."){
                    $('#categoria').val($("#input-select option:selected").text());
                }
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

function cargarform() {

    let id = $('#cargarVideo').attr("idcurso");//Tomamos el valor del id guardado en un atributo del boton enviar 

    let elemento = 'curso';
    let operacion = 'consulta';
    let dato = id; //consulta devuelve datos para un select

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
            if (rs['price'] == 0) {
                $('#cb-gratis').attr("checked", "checked");
                $('#precio').attr("disabled", "disabled");
            }
            $('#input-select option').each(function () {
                if ($(this).val() == rs['category']) {

                    $('#categoria').val($(this).text());
                    $(this).attr("selected",rs['category']);
                }
            });
            $('#imagen').attr("disabled","disabled");

            $('#nombre').val(rs['name']);
            $('#precio').val(rs['price']);
            $('#descripcion').val(rs['description']);
           

        }


    });



}


$(document).ready(function () {
  

    
    $("#cargarVideo").click(function (e) {
        e.preventDefault(); //prevenimos accion por defecto del form
        //let id = $('#cargarVideo').attr("idcurso");//Tomamos el valor del id guardado en un atributo del boton enviar 

        subir();
    });

    cargarCategorias('agregaconsulta', 'traer');
  //cargamos los datos del curso a modificar en el formulario
    cargarform();
    botonimagen();
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
        }else{
            cartelError("No puede cargar categoría vacía.");
        }
    });


});