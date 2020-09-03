'use strict';



$(function () {

    // Sidebar toggle behavior //comportamiento de barra lateral
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
    });
});

$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled"); //agregamos la classe toggle al wrapper para que aparezca y desaparezca la barra lateral 
});

//Realizamos la carga de cursos cuando la página ya está lista
//operacion, categoria,subcategoria
//comprados, listar
function carga(operacion, categoria, subcategoria) {
    let listar = false;
    if (operacion == 'listar') {
        listar = true;
        operacion = 'todos'
    }

    $('#contenedor_home').empty();
    var cuerpo = "";
    $.ajax({
        url: "php/traer_cursos_main.php",
        method: "POST",
        //dataType: "json", //preguntar por que en la version 7.4 de php tengo problemas 
        data: {
            "operacion": operacion,
            "categoria": categoria,
            "subcategoria": subcategoria

        },
        beforeSend: function () { //Previo a la peticion tenemos un cargando
            $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
        },
        success: function (rs) {
            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
            //console.log(rs);


            if (rs == 0) { //No hay cursos
                cuerpo = "<div class='text-center'><h3>No hay cursos</h3></div>";
                //$('#curso' + i).empty();
                //$('#curso' + i).append(cuerpo);
            }
            if (rs != 0 && rs != 4) {

                //console.log(rs);
                //  let courses = eval(rs);
                //console.log((rs));
                let courses = JSON.parse(rs);
                //console.log(courses);
                //mostramos los cursos en el body
                //alert(courses);
                if (!listar) {
                    $('#contenedor_home').empty();
                    var fila = 0;
                    $.each(courses, (i, r) => {
                        if ((i % 3) == 0) {
                            fila++;
                            $('#contenedor_home').append('<div class="row" id="fila' + fila + '"> </div>');
                        }
                        if (r['bought']) { //CURSOS COMPRADOS
                            $('#fila' + fila).append(

                                '<div class="col-xl-4 mt-2">' +
                                '<div class="  mendocard shadow-lg" style="width: 18rem;" curso=' + r['id'] + '>' +
                                '<img src="imgcourses/' + r['imgname'] + '"' + 'id=img' + r['id'] + '" class="mendocard-picture">' +
                                '<div class="">' +
                                '<h5 class="pt-2">' + r['name'] + '</h5>' +
                                '<p class="">' + r['description'] + '</p>' +
                                '<button class="curso btn btn-block btn-info text-white" title="' + r['name'] + '" tipo="Ver" curso="' + r['id'] + '" id=curso' + r['id'] + '> Ver </button>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                        } else if (!(r['bought'])) { //CURSOS SIN COMPRAR
                            let color;
                            let tipo;
                            let opcion;
                            let precio;
                            if (r['price'] == 0) {
                                color = 'warning';
                                tipo = "¡Curso Gratuito!";
                                opcion = '';
                                precio = r['price'] + '$';

                            } else {
                                //console.log("Precio ", r['price']);

                                if (r['price'] == -1) {
                                    color = 'success';
                                    tipo = "Cupos agotados";
                                    opcion = 'disabled';
                                    precio = 'No disponible';
                                } else {
                                    color = 'success';
                                    tipo = "¡Comprar!";
                                    opcion = '';
                                    precio = r['price'] + '$';


                                }

                            }
                            $('#fila' + fila).append(

                                '<div class="col-xl-4 mt-2">' +
                                '<div class="mendocard shadow-lg " style="width: 18rem;" curso=' + r['id'] + '>' +
                                '<img src="imgcourses/' + r['imgname'] + '"' + 'img=' + r['imgname'] + '" class="mendocard-picture">' +
                                '<div class="">' +
                                '<h5 class="pt-2">' + r['name'] + '</h5>' +
                                '<p class="">' + r['description'] + '</p>' +
                                '<p class="">Precio: ' + precio + '</p>' +
                                '<button class="curso btn btn-block btn-' + color + ' "  title="' + r['name'] + '" tipo=Comprar curso=' + r['id'] + ' id="curso' + r['id'] + '" ' + opcion + '> ' + tipo + ' </button>' +
                                '<p class="" id="pago' + r["preferenceid"] + '"></p>' +
                                '</div>' +
                                '</div>' +
                                '</div>');

                        }

                        //una vez cargados los cursos llamamos a la funcion carga cursos parar que al precionar en comprar reacciones de derentes maneras dependendiendo del curso
                        cargacurso();


                    });
                    resultadocompra();
                } else {
                    //------------------mostramos los cursos en el body en forma de tabla con la opcion de modificar y eliminar---------- 
                    jumbotron(true, 'Modificar Cursos', '');
                    let tabla = '<div class="container"> <table id="table" class="table table-light table-responsive-sm ">' +
                        '<thead class="thead-dark">' +
                        '<tr>' +
                        '<th>#</th>' +
                        '<th>Curso</th>' +
                        '<th></th>' +
                        '<th>Opciones</th>' +
                        '<th></th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    $.each(courses, (i, r) => {

                        tabla +=

                            '<tr>' +

                            '<th >' + (i + 1) +
                            '</th>' +

                            '<th>' + r['name'] +
                            '</th>' +

                            '<th>' +
                            '<a class="modificar-curso text-decoration-none btn btn-info" href="#"  id="' + r['id'] + '" >Modificar</a>' +
                            '</th>' +

                            '<th>' +
                            '<a class="modificar-videos text-decoration-none btn btn-secondary" href="#"  id="' + r['id'] + '" >Modificar videos</a>' +
                            '</th>' +

                            '<th>' +
                            '<a id="curso' + r['id'] + '" class="eliminar-curso text-decoration-none btn btn-danger" href="#"  ide="' + r['id'] + '" >Eliminar</a>' +
                            '</th>' +

                            '</tr>';

                    });
                    tabla += '</tbody></table> </div>';
                    $('#contenedor_home').empty().append(tabla);


                    $.getScript("js/datatable-lanzador.js", function () {


                    });

                    $('.buttons-excel').hide();


                }

                $(".modificar-curso").click(function () {

                    let id = $(this).attr("id");
                    modificarcurso(id);
                });

                $(".modificar-videos").click(function () {

                    let id = $(this).attr("id");
                    mostrarcurso(id, true); //el segundo parametro habilita la modificacion del curso
                });

                $(".eliminar-curso").click(function () {



                    var opcion = confirm("¿Esta seguro que desea eliminar este curso?");
                    if (opcion == true) {

                        let id = $(this).attr("ide");
                        eliminarcurso(id);
                    } else {
                        cartel("Ha cancelado la operación.");
                    }



                });

            }
        }
    });
}

//carga el dropdown de categorias
function cargacategorias() {

    let operacion = "cargar";
    $.ajax({

        url: "php/categoria.php",
        type: "post",
        data: {
            'operacion': operacion,
        },

        beforeSend: function () { //Previo a la peticion tenemos un cargando


        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);


        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (cat) {


            //console.log(cat);
            $.getScript("./js/dropdown.js", function () {}); //llamamos a dropdown.js par recargar el script con los datos traidos de la BD
            $('#categorias').empty().append(cat);


            //cuando hago clic en una subcategoria del dropdown
            $(".subcategory").click(function () {

                let subcategoria = $(this).text();
                let categoria = $(this).attr("categoryname");
                let idsubcategory = $(this).attr("idsubcategory");
                let idcategory = $(this).attr("idcategory");


                console.log(subcategoria);
                jumbotron(true, categoria + " " + subcategoria, '');
                $('.nav-element').click(() => {
                    $('#navbarCollapse').removeClass('show');

                });
                carga("categoria", idcategory, idsubcategory);
            });


        }
    });


}





//Esta funcion solo sirve dentro de la funcion carga(), y se encarga de cargar los cursos si el curso fue comprado o traer la opcion de pago usando la api de mercado pago
function cargacurso() {
    $(".curso").click(function () {
        $(this).removeClass('btn-success');
        $(this).addClass('btn-dark');
        $('.modal-body').empty();

        let id = $(this).attr("curso");
        let tipo = $(this).attr("tipo");
        //console.log(id);
        //Comprobamos que tenga el curso comprado

        $.ajax({
            url: "php/check_curso_comprado.php",
            method: "POST",
            data: {
                "idcourse": id
            },
            beforeSend: function () { //Previo a la peticion tenemos un cargando
                $('#curso' + id).removeClass('btn-success');
                $('#curso' + id).addClass('btn-dark');
                $('#curso' + id).attr("disabled", "disabled");
                $('#curso' + id).html('<span class="spinner-border spinner-border-sm" disabled></span>');

            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#curso' + id).removeClass('disabled');
                $('#curso' + id).addClass('btn-success');
                $('#curso' + id).html(tipo);
                $('#curso' + id).removeAttr("disabled");

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#curso' + id).removeClass('btn-dark');
                $('#curso' + id).addClass('btn-success');
                $('#curso' + id).removeAttr("disabled");
                $('#curso' + id).html(tipo);
            },
            success: function (courses) {
                //console.log(courses);
                let r = JSON.parse(courses);
                let rs = r[0];
                //console.log(rs[0]);
                // console.log(rs['videoname']);
                //--------------------------------------------------------------------CURSO COMPRADO----------------------------------------------------------------------------
                if (rs['bought'] == true) {

                    //$('#pago').empty().append('<h2 class="display-5 alert alert-info"> <strong>La carga de cursos estará habilitada en breve</strong>. </br></br>¡Muchas gracias!</h2>');
                    //$('#exampleModal').modal('show');

                    //$('#contenedor_home').empty().append('Aqui estará el curso');
                    //$('#video').attr('src', "coursesvideos/" + rs['videoname']);
                    //$('#modalvideo').modal("show");
                    let sessionrol = $('#role').val();
                    $('#jumbotron').removeClass('d-none');
                    $('#jumbotron').addClass('d-block');
                    let videostarjeta = '<div class="container">' +
                        /*'<h1 class="display-4"> '+rs['name  ']+' </h1>'+
                        
                        '<p class="lead">¿Listo para continuar? </p>'+*/
                        '<div class="" style="max-width: 540px;" >' +
                        '<div class="row no-gutters">' +
                        '<div class="col-md-4">' +
                        '<img src="imgcourses/' + rs['imgname'] + '" class="card-img" alt="foto de curso">' +
                        '</div>' +
                        '<div class="col-md-8">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + rs['name'] + '<h5>' +
                        '<p class="card-text">' + rs['description'] + '</p>' +
                        // '<p class="card-text"><small class="text-muted">' + rs['description'] + '</small></p>' +
                        '</div>' +
                        '</div>';
                    if (sessionrol == 0) {
                        videostarjeta += '<div class="mt-3 d-flex justify-content-end ">' +
                            '<a id="view" href="#" class="text-info font-weight-bold text-decoration-none" >Visualizaciones   <i class="fas fa-download"></i></a>' +
                            '</div>';
                    }

                    videostarjeta +=
                        '</div>' +
                        '</div>' +
                        '</div>';

                    videostarjeta +=
                        '<div class="container d-flex justify-content-center  " id="ventana-admin">' +

                        '<div id="box1" style="background:white;" class="mainbox-sm col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-1 mb-5 d-none ">' +

                        '<div class="panel panel-info">' +
                        '<div class="modal-header">' +
                        '<div class="panel-title ">Seleccione periodo </div> <i class="fas fa-photo-video"></i>' +

                        '</div>' +

                        '<div style="padding-top:30px" class="panel-body">' +

                        '<form id="form-views" class="form-horizontal" >' +
                        '<input type="hidden" name="courseid" value="' + id + '" />' +
                        '<div class="form-group">' +
                        '<label for="date1">Desde</label>' +
                        '<input type="text" id="date1" class="form-control datepicker" name="date1" value="" placeholder="Fecha inicio" data-date-format="mm/dd/yyyy">' +

                        '</div>' +

                        '<div class="form-group">' +
                        '<label for="date2">Hasta</label>' +
                        '<input type="text" id="date2" class="form-control datepicker" name="date2" value="" placeholder="Fecha Fin" data-date-format="mm/dd/yyyy">' +
                        '</div>' +


                        '<div style="margin-top:10px" class="form-group">' +
                        '<div class="col-sm-12 controls">' +
                        '<button id="find-views" type="submit"  class="btn btn-warning">Consultar</button>' +
                        '<a id="courses-back-button" href="#" class="text-info font-weight-bold text-decoration-none"style="float:right; font-size: 80%; position: relative;" >Volver</a>' +
                        '</div>' +
                        '</div>' +


                        '<div id="alert">' +

                        '</div>' +

                        '</form>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $('#jumbotron').empty().append(videostarjeta);

                    $('#courses-back-button').click(function (e) {
                        $('#box1').removeClass('d-block');
                        $('#box1').addClass('d-none');
                        $('#accordion').removeClass('d-none');
                        $('#accordion').addClass('d-block');

                    });
                    $('#view').click(function (e) {
                        $('#accordion').removeClass('d-block');
                        $('#accordion').addClass('d-none');
                        $('#box1').removeClass('d-none');
                        $('#box1').addClass('d-block');

                    });
                    $.getScript("./vendor/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js", function () {
                        $.getScript("./vendor/vitalets-bootstrap-datepicker-c7af15b/js/locales/bootstrap-datepicker.es.js", function () {
                            $('.datepicker').datepicker({
                                uiLibrary: 'bootstrap4',
                                language: 'es',
                                format: 'dd-mm-yyyy'
                            });

                            $('.datepicker').datepicker()
                                .on('changeDate', function (ev) {
                                    $('.datepicker').datepicker('hide');
                                });

                        });

                    });
                    $('#find-views').click(function (e) {
                        e.preventDefault();
                        viewsquery();

                    });


                    mostrarcurso(id, false); //el segundo parametro habilita la edicion lo pasamos como falso



                } else {
                    //------------------------------------------------------------------CURSO NO COMPRADO---------------------------------------------------------------------------                                
                    //console.log("Elemento no comprado");
                    //console.log(rs["preferenceid"]);
                    var preferenceid = rs["preferenceid"];
                    //var img=  $('#img'+id);


                    if (preferenceid != 0) {
                        //creamos formulario de pago  
                        $('#pago').empty();
                        var form = document.createElement("form");
                        form.method = "POST";
                        form.action = "/mendumy2/mendumy/mendumy/home.php"; //"/procesar-pago";
                        form.id = "form_pago";
                        document.getElementById('pago').appendChild(form);
                        var script = document.createElement("script");
                        script.type = "text/javascript";
                        script.src = 'https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js'; // use this for linked script
                        script.setAttribute("data-preference-id", preferenceid);
                        document.getElementById('form_pago').appendChild(script);


                    } else {
                        var cartel = rs['cartel'];
                        $('#pago').empty().append(cartel);
                    }


                    $('#exampleModal').modal('show');
                    //cuando se cierra el modal recargamos los cursos
                    $("#exampleModal").on("hidden.bs.modal", function () {

                        $('#jumbotron').removeClass('d-none');
                        $('#jumbotron').addClass('d-block');
                        carga("todos", "", "");


                    });
                }

            }
        });
    });
}


function viewsquery() {


    let elemento = 'view';
    let operacion = 'consultar';
    var Form = new FormData($("#form-views")[0]);
    Form.append('operacion', operacion);
    Form.append('elemento', elemento);

    $.ajax({

        url: "./php/abmc.php",
        type: "post",
        dataType: "html",
        data: Form,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function () { //Previo a la peticion tenemos un cargando
            $('#find-views').removeClass('btn-warning');
            $('#find-views').addClass('btn-dark');
            $('#find-views').html('<span class="spinner-border spinner-border-sm" disabled></span>');

        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);
            $('#find-views').removeClass('disabled');
            $('#find-views').addClass('btn-primary');
            $('#find-views').html('Consultar');

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual
            $('#find-views').removeClass('btn-info');
            $('#find-views').removeClass('btn-dark');
            $('#find-views').addClass('btn-warning');
            $('#find-views').html('Consultar');
        },

        success: function (data) {
            //console.log("Resultado de la peticion " + data);
            //$('#alert').addClass('alert-warning');
            let r = JSON.parse(data);
            //console.log(r);
            if (r == 1) {
                $('#alert').empty().append('<h6 class="alert alert-info mb-2"> <strong>No hay visualizaciones en el rango introducido.</strong></h6>');
            } else {
                printTablaView(r);


            }

        }

    });




}

function printTablaView(data) {


    //tabla creamos la tabla 
    let tabla =
        '<div class="container">' +
        '<div class="row">' +
        '<div class="col-lg-12">' +
        '<div class="table-responsive">' +
        '<table id="table" class="table table-striped table-bordered" style="width:100%">' +
        '<thead class="tcabecera">' +
        '<tr>' +
        '<th>Video</th>' +
        '<th>Nombre</th>' +
        '<th>Apellido</th>' +
        '<th>DNI</th>' +
        '<th>Fecha</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';
    //lista elementos de tabla
    $.each(data, (i, r) => {

        tabla +=
            '<tr>' +
            '<th>' + r["title"] + '</th>' +
            '<th>' + r["name"] + '</th>' +
            '<th>' + r["lastname"] + '</th>' +
            '<th>' + r["dni"] + '</th>' +
            '<th>' + r["date"] + '</th>' +
            '</tr>';
    });
    tabla +=
        '</tbody>' +
        '</table>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    //imprimimos
    $('#jumbotron').empty().append(tabla);

    $.getScript("vendor/popper/popper.min.js", function () {
        $.getScript("vendor/DataTables/datatables.min.js", function () {
            $.getScript("vendor/DataTables/Buttons-1.6.3/js/dataTables.buttons.min.js", function () {
                $.getScript("vendor/DataTables/JSZip-2.5.0/jszip.min.js", function () {
                    $.getScript("vendor/DataTables/Buttons-1.6.3/js/buttons.html5.min.js", function () {
                        $.getScript("js/datatable-lanzador.js", function () {



                        });


                    });


                });

            });

        });

    });

}



function eliminarcurso(id) {
    let elemento = 'curso';
    let operacion = 'baja';
    let dato = id;
    $.ajax({

        url: "./php/abmc.php",
        type: "post",
        data: {
            'id': id,
            'elemento': elemento,
            'operacion': operacion,
            'dato': dato
        },

        beforeSend: function () { //Previo a la peticion tenemos un cargando
            $('#curso' + id).removeClass('btn-success');
            $('#curso' + id).addClass('btn-dark');
            $('#curso' + id).attr("disabled", "disabled");
            $('#curso' + id).html('<span class="spinner-border spinner-border-sm" disabled></span>');

        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);
            $('#curso' + id).removeClass('disabled');
            $('#curso' + id).addClass('btn-success');
            $('#curso' + id).removeAttr("disabled");

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual
            $('#curso' + id).removeClass('btn-dark');
            $('#curso' + id).addClass('btn-success');
            $('#curso' + id).removeAttr("disabled");
            $('#curso' + id).html('Eliminar');
        },

        success: function (data) {

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos

            //$('#alert').addClass('alert-warning');
            if (data == 1) {
                $('#curso' + id).closest("tr").remove(); //navego hasta el tr y lo borro 
            } else {
                alert("error al eliminar curso");
            }




        }
    });
}
//-------------------------------TRAE CONTENIDO DE CURSOS AL BOODY , el segundo argumento sirve para  modificar los cursos que trae---------------------------------------
function mostrarcurso(idcurso, modificar) {
    $('#jumbotron').removeClass('d-none');
    $('#jumbotron').addClass('d-block');
    // console.log("id del curso a mostrar" + idcurso);
    $.ajax({

        url: "./php/consulta_cursos.php", //hacemos una peticion al archivo de altabajamodificacion consulta
        type: "post",
        data: {
            'idcurso': idcurso,
            'modificar': modificar
        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {
            //escondemos el jumbotron de bienvenida

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos

            let rs = JSON.parse(data);
            //console.log(rs);
            //$('#alert').addClass('alert-warning');
            //limpiamos contenedor 
            $('#contenedor_home').empty().append('<div id="accordion" > </div>');
            //agregamos acordeon con temas  y videos

            if (!modificar) {
                let videos = "Videos:";
                $.each(rs, (i, r) => {

                    videos += '<div class="list-group list-group-flush">';
                    //console.log(r['videos'][0]['title']);

                    $.each(r['videos'], (j, r1) => {

                        videos += '<a href="#" class="list-group-item list-group-item-action  boton_video " id="' + r1['id'] + '" curso="' + idcurso + '"tema="' + r['name'] + '">' +
                            '<i class="text-success fas fa-play-circle"></i>  ' + r1['title'] + '</a>';
                        //console.log(r1['title']);
                    });

                    videos += '</div>';

                    $('#accordion').append(

                        '<!--Elemento colapsable-->' +
                        '<div class="card">' +
                        '<!--Cabecera de elemento de acordeon-->' +
                        '<div class="card-header" id="heading' + i + '">' +
                        ' <h5 class="mb-0">' +
                        '<button class="btn  " data-toggle="collapse" data-target="#collapse' + i + '" aria-expanded="true" aria-controls="collapse' + i + '">' +
                        '<i class=" text-info fas fa-plus"></i>   ' + r['name'] +
                        '</button>' +
                        '</h5>' +
                        '</div>' +
                        '<!--Elemento colapsable al tocar cabecera-->' +
                        '<div id="collapse' + i + '" class="collapse show" aria-labelledby="heading' + i + '" data-parent="#accordion">' +
                        '<div class="card-body">' +
                        videos +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<!--Elemento no colapsable-->'




                    );
                    //console.log("elemento " + i + " es " + r['name']);
                    videos = [];
                    videos = "Videos:";


                });

                function registrarview(videoid, courseid) {
                    $.ajax({

                        url: "./php/abmc.php",
                        type: "post",
                        data: {
                            'courseid': courseid,
                            'videoid': videoid,
                            'operacion': 'registrar',
                            'elemento': 'view',

                        },

                        success: function (data) {

                            console.log(data);

                        }
                    });
                }
                //Funcion que se ejecuta cuando presionamos un videos
                $(".boton_video").click(function () {

                    $('.modal-body').empty();
                    $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
                    $('#carga_cursos').show("fast");
                    $('#carga_cursos').hide("fast");

                    $('#jumbotron').removeClass('d-block');
                    $('#jumbotron').addClass('d-none');
                    let idcourse = $(this).attr("curso");
                    let id = $(this).attr("id");
                    let tema = $(this).attr("tema");
                    registrarview(id, idcourse);
                    //console.log(tema);
                    //console.log(rs[0]['videos'][0]['archivos']);
                    let description;
                    let videoID;
                    //let imgvideo;
                    let title;
                    let archivos = '<ul class="list-group list-group-flush"><div class="card-body pb-0"> <h6 class="card-title">Archivos adjuntos</h6></div>';
                    let datosVideo;
                    let videocard;
                    $.each(rs, (i, r) => {



                        if (r['name'] == tema) {


                            $.each(r['videos'], (j, r1) => {


                                if (r1['id'] == id) {

                                    description = r1['description'];
                                    videoID = r1['name'];
                                    //imgvideo = r1['imgvideo'];
                                    title = r1['title'];
                                    //datosVideo = description + "  " + videoID + "  " + imgvideo + "  " + title;

                                    $.each(r1['archivos'], (z, r2) => {


                                        archivos += '<a  class="list-group-item list-group-item-action text-info" download="' + r2['name'] + '" href="coursefiles/' + r2['filename'] + '"><i class="fas fa-file-alt"></i>' + ': ' + r2['name'] + ' </a>';
                                    });

                                }


                            });
                        }

                    });
                    archivos += '</ul>';
                    //console.log(archivos);
                    //preparamos video card del curso
                    videocard =
                        '<div class=" row justify-content-center" >' +
                        '<div class="col-xl-6 mt-2">' +
                        '<div class="  mendocard shadow-lg w-100 mt-4" style="width: 18rem;">' +
                        '<div class="embed-responsive embed-responsive-16by9">' +
                        '<iframe src="https://player.vimeo.com/video/' + videoID + '"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>' +
                        '</div>' +
                        '<div class="">' +
                        '<h5 class="pt-2">' + title + '</h5>' +

                        '<p class=""> ' + description + ' </p>' +
                        archivos +
                        '<div class="container d-flex justify-content-around mb-3 mt-3 ">' +
                        '<button class=" btn btn-md p-1  btn-outline-dark mr-2 col-xs-12 col-xl-4"  id="' + idcourse + '">Volver</button>' +
                        '<a class=" btn btn-md p-1  btn-warning mr-2 col-xs-12 col-xl-4" href="mailto:soporte@notarweb.com.ar?subject=consulta en ' + title + '" id="video' + id + '">Consultas</a>' +
                        '</div>' +
                        '</div>' +

                        '</div>' +
                        '</div>' +
                        '</div>';



                    $('#contenedor_home').empty().append(videocard);

                    $('#video' + id).click(function () {

                        $('#video').attr('src', "coursesvideos/" + namevideo);
                        $('#modalvideo').modal("show");

                    });
                    $('#' + idcourse).click(function () {
                        //console.log(idcourse);
                        mostrarcurso(idcourse);

                    });

                    console.log("el id del video seleccionado es: " + id);
                });

            } else {
                jumbotron(true, 'Modificar videos', 'Seleccione una opción');
                //---------------------------------------MODIFICAR VIDEOS --------------------------------------------------
                //--------------------------ENCABEZADO DE LA TABLA-----------------------------------------------
                if (rs == 2) {
                    //console.log("se dio el caso 1");
                }
                listarvideos(rs);
                modificarvideo();



            }









        }

    });



}
//--------------LISTAR VIDEOS DE UN CURSO PARA MODIFICAR------------------------------------------- 
function listarvideos(rs) {
    let tabla;
    if (rs == 2) {
        tabla = '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
            '<strong>Información: </strong>Por motivos de seguridad debe tener el curso asignado para poder modificar su contenido.' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>'
        '</div>'

    } else {
        tabla = '<div class="container"> <table class="table table-light table-responsive-sm ">' +
            '<thead class="thead-dark">' +
            '<tr>' +
            '<th scope="col">#</th>' +
            '<th scope="col">Videos</th>' +
            '<th colspan="2" scope="col" class="text-center">Opciones</th>' +

            '</tr>' +
            '</thead>';
        let videos;
        $.each(rs, (i, r) => {
            //tema 
            tabla +=
                '<thead class="thead-dark">' +
                '<tr>' +
                '<th colspan="3" scope="col" class="text-center">TEMA:' + r['name'] + '</th>' +
                '</tr>' +
                '</thead>';
            //lista de videos de cada tema
            $.each(r['videos'], (j, r1) => {

                tabla +=
                    '<tbody>' +
                    '<tr>' +
                    '<th scope="row">' + (j + 1) + '</th>' +
                    '<td>' + r1['title'] + '</td>' +
                    '<td colspan="2">' +

                    '<div class="row d-flex justify-content-around">' +
                    '<div class="col "> <button class="modificar-video btn btn-dark"  id="' + r1['id'] + '" >Modificar</button> </div>' +
                    '<div class="col"> <button class="eliminar-video btn btn-danger" id="video' + r1['id'] + '" ide="' + r1['id'] + '" >Eliminar</button></div>' +
                    '</div>' +

                    '</td>' +

                    '</tr>';
            });

        });
        tabla += '</tbody></table> </div>';
    }

    $('#contenedor_home').append(tabla);

    $(".eliminar-video").click(function () {



        var opcion = confirm("¿Esta seguro que desea eliminar este video?");
        if (opcion == true) {

            let id = $(this).attr("ide");
            eliminarvideo(id);
        } else {
            cartel("Ha cancelado la operación.");
        }





    });

}
//-----------------------------------Eliminar video----------------------------------------------------
function eliminarvideo(id) {

    let elemento = 'video';
    let operacion = 'baja';
    let dato = id;
    $.ajax({

        url: "./php/abmc.php",
        type: "post",
        data: {
            'id': id,
            'elemento': elemento,
            'operacion': operacion,
            'dato': dato
        },

        beforeSend: function () { //Previo a la peticion tenemos un cargando
            $('video' + id).removeClass('btn-success');
            $('#video' + id).addClass('btn-dark');
            $('#video' + id).attr("disabled", "disabled");
            $('#video' + id).html('<span class="spinner-border spinner-border-sm" disabled></span>');

        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);
            $('#video' + id).removeClass('disabled');
            $('#video' + id).addClass('btn-success');
            $('#video' + id).removeAttr("disabled");

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual
            $('#video' + id).removeClass('btn-dark');
            $('#video' + id).addClass('btn-success');
            $('#video' + id).removeAttr("disabled");
            $('#video' + id).html('Eliminar');
        },

        success: function (data) {

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos

            //$('#alert').addClass('alert-warning');
            if (data == 1) {
                $('#video' + id).closest("tr").remove(); //navego hasta el tr y lo borro 
            } else {
                alert("error al eliminar video");
            }




        }
    });


}


//-----------------------------------Modificar video----------------------------------------------------
//---------------------Esta funcion solo corre despues de que se listaron los cursos en el body usando carga()
function modificarvideo() {
    $(".modificar-video").click(function () {

        let id = $(this).attr("id");

        $.ajax({

            url: "./php/subirvideo.php",
            type: "post",
            data: {
                'id': id
            },


            beforeSend: function () { //Previo a la peticion tenemos un cargando

                $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
                $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

            },

            success: function (data) {

                $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
                //console.log(data);
                //$('#alert').addClass('alert-warning');
                $('#contenedor_home').empty().append(data);

                $.getScript("./js/modificarvideo.js", function () {


                });

            }

        });




    });
}

//-------------------------------CARGA CURSO ------------------------------------------------------------   

function subircurso(ok) {
    if (ok) {
        $.ajax({

            url: "./php/admin.php", //script para subir cursos a la base de datos
            type: "post",
            data: ok,


            beforeSend: function () { //Previo a la peticion tenemos un cargando

                $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
                $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

            },

            success: function (data) {

                $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
                //console.log(data);
                //$('#alert').addClass('alert-warning');
                $('#contenedor_home').empty().append(data);

                $.getScript("./js/admin.js", function () {


                });

            }

        });

    }

}

function jumbotron(accion, titulo, subtitulo) {


    if (accion == true) {

        $('#jumbotron').removeClass('d-none');
        $('#jumbotron').addClass('d-block');

        if (titulo || subtitulo) {
            //script para cambiar el jumbotron
            $('#jumbotron').empty().append(
                '<div class="container text-right">' +
                '<h2 class="">' + titulo +
                '</h1>' +
                '<p class="lead">' + subtitulo +
                '</p> </div>'

            );
        }
    } else {
        $('#jumbotron').empty();
        $('#jumbotron').removeClass('d-block');
        $('#jumbotron').addClass('d-none');
    }
}

function subirvideo(ok) {

    if (ok) {
        $.ajax({

            url: "./php/subirvideo.php",
            type: "post",
            data: ok,


            beforeSend: function () { //Previo a la peticion tenemos un cargando

                $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
                $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

            },

            success: function (data) {

                $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
                //console.log(data);
                //$('#alert').addClass('alert-warning');
                $('#contenedor_home').empty().append(data);

                $.getScript("./js/subirvideo.js", function () {


                });

            }

        });

    }

}

function modificarcurso(id) {
    $('#contenedor_home').empty();


    $.ajax({

        url: "./php/admin.php", //formulario de subida de cursos
        type: "post",
        data: {
            "id": id
        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
            //console.log(data);
            //$('#alert').addClass('alert-warning');
            $('#contenedor_home').empty().append(data);

            $.getScript("./js/modificarcurso.js", function () {


            });

        }

    });

}

function cartelModal(contenido, tipo) {
    let cartel = '<div  class="text-center alert alert-' + tipo + ' fade show mb-4" role="alert">' + contenido + '</div>';


    $('#pago').empty().append(cartel);
    $('#exampleModal').modal('show');
}

function resultadocompra() {


    let params = new URLSearchParams(location.search);
    let result = params.get('result');
    let idcourse = params.get('idcourse');
    let status = params.get('collection_status');
    let credentialid = params.get('credentialid');
    let ide = '#curso' + idcourse;
    let curso = $(ide).attr('title');
    let id = params.get('collection_id');

    //console.log(id);
    switch (result) {
        case "success":
            if (status == 'approved') {
                successBuy(id, credentialid);
                cartelModal('¡Felicidades, has adquirido el curso <b>' + curso + '</b>!', "success");
                window.history.replaceState(null, null, window.location.pathname); //limpiamos url
            };
            break;
        case "pending":
            cartelModal('¡Gracias por iniciar la compra de <b>' + curso + '</b>!, una vez que se registre el pago podrás ingresar al curso.', "info");
            window.history.replaceState(null, null, window.location.pathname); //limpiamos url
            ;
            break;
    }


}

function successBuy(id, credentialid) {
    $.ajax({
        url: "./php/ml_checkout_response.php",
        type: "get",
        data: {
            "id": id,
            "credentialid": credentialid
        },
        success: function (r) {
            carga("todos", "", "");
        }
    });
}

function getRegistrados() {
    $.ajax({
        url: "./php/getRegistrados.php",
        type: "get",
        success: function (data) {
            $('#registradosTotales').append('<b>' + data + '</b>');
        }
    });
}

function ventas(id) {
    $('#contenedor_home').empty();


    $.ajax({

        url: "./php/ventas.php",
        type: "post",
        data: {
            "id": id
        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
            //console.log(data);
            //$('#alert').addClass('alert-warning');
            $('#contenedor_home').empty().append(data);



            $.getScript("./vendor/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js", function () {
                $.getScript("./vendor/vitalets-bootstrap-datepicker-c7af15b/js/locales/bootstrap-datepicker.es.js", function () {
                    $('.datepicker').datepicker({
                        uiLibrary: 'bootstrap4',
                        language: 'es',
                        format: 'dd-mm-yyyy'
                    });
                    $('.datepicker').datepicker()
                        .on('changeDate', function (ev) {
                            $('.datepicker').datepicker('hide');
                        });
                    //se cargan los cursos en el select
                    ventacursos();

                });

            });




        }

    });

}
//funcion para rellenar el select de ventas con los cursos traidos de la base de datos
function ventacursos() {
    let operacion = "todos";
    let categoria = "";
    let subcategoria = "";

    $.ajax({

        url: "./php/traer_cursos_main.php", //script para subir cursos a la base de datos
        type: "post",
        data: {
            "operacion": operacion,
            "categoria": categoria,
            "subcategoria": subcategoria
        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            //$('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
            //$('#carga_cursos').show("fast");//mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            //$('#carga_cursos').hide("fast");//escondemos rapidamente los elementos que representan a los cursos
            //console.log(data);
            //$('#alert').addClass('alert-warning');

            let rs = JSON.parse(data);
            let cursos = '<option selected>Seleccionar...</option>';
            let option;
            $.each(rs, (i, r) => {

                option = '<option value="' + r['id'] + '">' + r['name'] + '</option>';
                cursos = cursos + option;
            });

            //Agregamos los cursos al select 
            $('#course-select').empty().append(cursos);
            //Una vez terminada la carga del formulario ponemos un evento para detectar cuando se haga click en consultar y largamos la funcion correspondiente



            $('#find-date').click(function (e) {
                //capturamos los valores ingresados
                e.preventDefault();

                let idcourse = $('#course-select option:selected').val();
                let f1 = $('#date1').val();
                let f2 = $('#date2').val();

                //console.log(" "+f1+" "+f2+" "+idcourse);
                //los mandamos como parametros de funcion
                cargaventas("traer", f1, f2, idcourse);

            });

        }

    });

}
//funcion para consultar las ventas de un curso seleccionado en un rango de fechas
function cargaventas(operation, date1, date2, courseid) {

    $.ajax({

        url: "./php/traer_ventas_main.php", //script para subir cursos a la base de datos
        type: "post",
        data: {

            "operation": operation,
            "date1": date1,
            "date2": date2,
            "courseid": courseid

        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            //$('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
            //$('#carga_cursos').show("fast");//mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            //$('#carga_cursos').hide("fast");//escondemos rapidamente los elementos que representan a los cursos
            //console.log(data);
            //$('#alert').addClass('alert-warning');
            if (data == 1) {
                //console.log("Error");
                $('#alert').empty().append('<h6 class="alert alert-info"> <strong>Introduzca todos los campos</strong>. </h6>');
            } else {
                $('#contenedor_home').empty().append(data);
                $.getScript("vendor/popper/popper.min.js", function () {
                    $.getScript("vendor/DataTables/datatables.min.js", function () {
                        $.getScript("vendor/DataTables/Buttons-1.6.3/js/dataTables.buttons.min.js", function () {
                            $.getScript("vendor/DataTables/JSZip-2.5.0/jszip.min.js", function () {
                                $.getScript("vendor/DataTables/Buttons-1.6.3/js/buttons.html5.min.js", function () {
                                    $.getScript("js/datatable-lanzador.js", function () {



                                    });


                                });


                            });

                        });

                    });

                });

            }


        }

    });

}
//funcion para consultar las credenciales
function credenciales(operation, credential, name, id) {


    $.ajax({

        url: "./php/credentials.php", //script para subir cursos a la base de datos
        type: "post",
        data: {

            "operation": operation,
            "credential": credential,
            "name": name,
            "id": id,

        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            if (operation == "traer2" || operation == "guardar" || operation == "eliminar" || operation == "modificar") {
                $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos

            } else {
                $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
                $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
            }
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos

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
                    $('#contenedor_home').append(data);
                }
            }


            $('.modificar-credencial').click(function () {

                let id = $(this).attr("id"); //obtenemos id de la credencial
                let name = $('#credentialname' + id).val();
                let credential = $('#credential' + id).val();
                //console.log("name: " + name + " credential: " + cred + " id: " + id);
                credenciales("modificar", credential, name, id);

            });

            $('.eliminar-credencial').click(function () {

                var opcion = confirm("¿Esta seguro que desea eliminar este curso?");
                if (opcion == true) {

                    let id = $(this).attr("ide");
                    let name = $('#credentialname' + id).val();
                    let cred = $('#credential' + id).val();
                    //console.log("name: " + name + " credential: " + cred + " id: " + id);
                    credenciales("eliminar", credential, name, id);

                } else {
                    cartel("Ha cancelado la operación.");
                }






            });
            $('#guardar-credencial').click(function () {

                var opcion = true //confirm("¿Esta seguro que desea eliminar este curso?");
                if (opcion == true) {

                    let name = $('#credentialname').val();
                    let credential = $('#credential').val();
                    //console.log("name: " + name + " credential: " + credential + " id: ");
                    credenciales("guardar", credential, name, "");

                } else {
                    cartel("Ha cancelado la operación.");
                }






            });


        }

    });

}
//traer el formulario de perfil
function formPerfil(id) {
    $('#contenedor_home').empty();


    $.ajax({

        url: "./php/form_perfil.php", //formulario de subida de cursos
        type: "post",
        data: {
            "userid": id
        },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            $('#contenedor_home').empty(); //vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast"); //mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
            //console.log(data);
            //$('#alert').addClass('alert-warning');
            $('#contenedor_home').empty().append(data);

            //buscamos el id traido de la BD de las profesiones dentro de los values del select de profesiones
            $('#input-select-formacion option').each(function () {
                //console.log($(this).val() + " " + $(this).text());
                let idprofesion = $('#input-select-formacion').attr("idprofesion");

                if ($(this).val() == idprofesion) {

                    $(this).attr("selected", idprofesion);

                }
            });

            $.getScript("./vendor/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js", function () {
                $.getScript("./vendor/vitalets-bootstrap-datepicker-c7af15b/js/locales/bootstrap-datepicker.es.js", function () {
                    $('.datepicker').datepicker({
                        uiLibrary: 'bootstrap4',
                        language: 'es',
                        format: 'dd-mm-yyyy'
                    });
                });
            });
            $('#change-pass').click(function (e) {
                $('#loginbox1').removeClass('d-block');
                $('#loginbox1').addClass('d-none');
                $('#loginbox2').removeClass('d-none');
                $('#loginbox2').addClass('d-block');

            });
            $('#back-perfil').click(function (e) {
                $('#loginbox2').removeClass('d-block');
                $('#loginbox2').addClass('d-none');
                $('#loginbox1').removeClass('d-none');
                $('#loginbox1').addClass('d-block');

            });

            $('#guardarDatos').click(function (e) {
                e.preventDefault();
                datoPerfil("modificar", "");
            });
            $('#cambiarPass').click(function (e) {
                e.preventDefault();
                datoPerfil("modificar", "contraseña");
            });

        }

    });

}
//funcion traer,consultar y modificar datos personales
function datoPerfil(operation, dato) {

    if (dato != "contraseña") {
        var datos = new FormData($("#formPerfil")[0]);
        datos.append('operacion', operation);
        datos.append('dato', dato);
        datos.append('elemento', "perfil");
    } else {
        var datos = new FormData($("#passForm")[0]);
        datos.append('operacion', operation);
        datos.append('dato', dato);
        datos.append('elemento', "perfil");
    }

    $.ajax({

        url: "./php/abmc.php", //script para subir cursos a la base de datos
        type: "post",
        dataType: "html",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,


        beforeSend: function () { //Previo a la peticion tenemos un cargando

        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            $('#carga_cursos').hide("fast"); //escondemos rapidamente los elementos que representan a los cursos
            console.log(data);
            switch (data) {
                case "1":
                    $('#alert').empty().append('<h6 class="alert alert-success"> <strong>¡Guardado exitoso!</strong>. </h6>');
                    $('#alert1').empty().append('<h6 class="alert alert-success"> <strong>¡Guardado exitoso!</strong>. </h6>');;
                    break;
                case "2":
                    $('#alert').empty().append('<h6 class="alert alert-warning"> <strong>¡Error!</strong></h6>');
                    $('#alert1').empty().append('<h6 class="alert alert-warning"> <strong>¡Error!</strong></h6>');;
                    break;
                case "3":
                    $('#alert1').empty().append('<h6 class="alert alert-warning"> <strong> *La contraseña y su confirmación deben ser iguales <br>*y  su longitud mayor a 7 caracteres</strong>. </h6>');;
                    break;
                case "4":
                    $('#alert').empty().append('<h6 class="alert alert-warning"> <strong> *Recuerde no dejar campos vacios! </strong>. </h6>');;
                    break;
                case "5":
                    $('#alert').empty().append('<h6 class="alert alert-warning"> <strong> *el dni debe ser un campo numerico! </strong>. </h6>');;
                    break;
                case "6":
                    $('#alert').empty().append('<h6 class="alert alert-warning"> <strong> *Solo caraceteres alfabéticos.</br>*No deje campos vacíos</strong> </h6>');;
                    break;
                case "7":
                    $('#alert').empty().append('<h6 class="alert alert-warning"> <strong> *Seleccione formación.</strong> </h6>');;
                    break;
                default:
                    $('#contenedor_home').append(data);
                    break;

            }




            $('.modificar-datos').click(function () {

                /*
                let id = $(this).attr("id");//obtenemos id de la credencial
                let name = $('#credentialname' + id).val();
                let credential = $('#credential' + id).val();
                //console.log("name: " + name + " credential: " + cred + " id: " + id);
                credenciales("modificar", credential, name, id);*/

            });




        }

    });

}

$(document).ready(function () {
    getRegistrados();
    cargacategorias();
    carga("todos", "", "");



    $("#inicio").click(function () {
        jumbotron(true, 'Todos los Cursos', '');
        carga("todos", "", "");
    });
    $("#cursos_comprados").click(function () {
        jumbotron(true, 'Mis Cursos', '');
        carga("comprados", "", "");
    });

    $('#adminpanel').click(() => {
        jumbotron(true, 'Subir Cursos', '');
        subircurso(true);
        console.log("Admin");
    });

    $('#subirvideo').click(() => {
        //$('#pago').empty().append('<h2 class="alert alert-info"> <strong>La subida de videos estará habilitada en breve</strong>. </br></br>¡Muchas gracias!</h2>');
        //$('#exampleModal').modal('show');
        jumbotron(true, 'Subir Videos', '');
        subirvideo(true);

    });


    $('#modificarcurso').click(() => {
        jumbotron(false);
        carga("listar", "", "");

    });

    $('#ventas').click(() => {
        jumbotron(true, 'Ventas', '');
        ventas();

    });
    $('#credenciales').click(() => {
        jumbotron(true, 'Credenciales', '');
        credenciales("traer", "", "", "");

    });

    $('.nav-element').click(() => {
        $('#navbarCollapse').removeClass('show');

    });

    $('#datosPersonales').click(() => {
        jumbotron(true, 'Datos personales', '');
        formPerfil();

    });


});