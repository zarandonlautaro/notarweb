'use strict';



$(function () {

    // Sidebar toggle behavior //comportamiento de barra lateral
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
    });
});

$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");//agregamos la classe toggle al wrapper para que aparezca y desaparezca la barra lateral 
});

//Realizamos la carga de cursos cuando la página ya está lista
function carga(comprados,listar) {
    
    var cuerpo = "";
    $.ajax({
        url: "php/traer_cursos_main.php",
        method: "POST",
        //dataType: "json", //preguntar por que en la version 7.4 de php tengo problemas 
        data: { "comprados": comprados },


        beforeSend: function () { //Previo a la peticion tenemos un cargando
            $('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast");//mostramos rapidamente los elementos que representan a los cursos
        },
        success: function (rs) {
            $('#carga_cursos').hide("fast");//escondemos rapidamente los elementos que representan a los cursos
            if (rs == 0) { //No hay cursos
                cuerpo = "<div class='text-center'><h3>No hay cursos</h3></div>";
                $('#curso' + i).empty();
                $('#curso' + i).append(cuerpo);
            }
            if (rs != 0 && rs != 4) {

                //console.log(rs);
                //  let courses = eval(rs);
                //console.log((rs));
                let courses = JSON.parse(rs);


                //alert(courses);
                if (!listar) {
                   
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
                                '<button class="curso btn btn-block btn-info text-white" tipo=Ver curso=' + r['id'] + ' id=curso' + r['id'] + '> Ver </button>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                        } else if (!(r['bought'])) { //CURSOS SIN COMPRAR
                            let color;
                            let tipo;
                            if (r['price'] == 0) {
                                color = 'warning';
                                tipo = "¡Curso Gratuito!";
                            } else {
                                color = 'success';
                                tipo = "¡Comprar Curso!";
                            }
                            $('#fila' + fila).append(

                                '<div class="col-xl-4 mt-2">' +
                                '<div class="mendocard shadow-lg " style="width: 18rem;" curso=' + r['id'] + '>' +
                                '<img src="imgcourses/' + r['imgname'] + '"' + 'img=' + r['imgname'] + '" class="mendocard-picture">' +
                                '<div class="">' +
                                '<h5 class="pt-2">' + r['name'] + '</h5>' +
                                '<p class="">' + r['description'] + '</p>' +
                                '<button class="curso btn btn-block btn-'+color+' " tipo=Comprar curso=' + r['id'] + ' id=curso' + r['id'] + '> '+tipo+' </button>' +
                                '<p class="" id="pago' + r["preferenceid"] + '"></p>' +
                                '</div>' +
                                '</div>' +
                                '</div>');

                            /*var form = document.createElement("form");
                            form.method = "POST";
                            form.action = "/procesar-pago";
                            form.id = "form_pago_" + r['preferenceid'];
                            document.getElementById('pago' + r['preferenceid']).appendChild(form);
                            var script = document.createElement("script");
                            script.type = "text/javascript";
                            script.src = 'https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js';    // use this for linked script
                            script.setAttribute("data-preference-id", r['preferenceid']);
                            document.getElementById('form_pago_' + r['preferenceid']).appendChild(script);*/

                        }




                    });
                } else {
                    let tabla='<div class="container"> <table class="table table-light table-responsive-sm ">'+
                    '<thead class="thead-dark">'+
                                            '<tr>'+
                                                '<th scope="col">#</th>'+
                                                '<th scope="col">Curso</th>'+
                                                '<th colspan="2" scope="col" class="text-center">Opciones</th>'+
                        
                                                '</tr>'+
                                            '</thead>';
                    $.each(courses, (i, r) => {

                            tabla+=
                                            '<tbody>'+
                                                '<tr>'+
                                                    '<th scope="row">'+(i+1)+'</th>'+
                                                    '<td>'+r['name']+'</td>'+
                                                    '<td colspan="2">'+
                        
                                                        '<div class="row d-flex justify-content-around">'+
                                                        '<div class="col "> <button class="modificar-curso btn btn-dark"  id="'+r['id']+'" >Modificar</button> </div>'+
                                                            '<div class="col "> <button class="modificar-videos btn btn-info" id="'+r['id']+'" >Modificar Videos</button> </div>'+
                                                            '<div class="col"> <button class="eliminar-curso btn btn-danger" id="'+r['id']+'" >Eliminar</button></div>'+
                                                        '</div>'+
                        
                                                    '</td>'+
                        
                                                '</tr>';
                    
                            
                     });
                     tabla+='</tbody></table> </div>';
                     $('#contenedor_home').append(tabla);


                }
                $(".modificar-curso").click(function () {
                    
                    let id = $(this).attr("id");
                    modificarcurso(id);
                });


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
                        data: { "idcourse": id },
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

                                $('#jumbotron').removeClass('d-none');
                                $('#jumbotron').addClass('d-block');
                                $('#jumbotron').empty().append(
                                    '<div class="container">' +
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
                                    '<p class="card-text"><small class="text-muted">' + rs['description'] + '</small></p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +






                                    '</div>'

                                );

                                mostrarcurso(id);



                            } else {
                                //------------------------------------------------------------------CURSO NO COMPRADO---------------------------------------------------------------------------                                
                                console.log("Elemento no comprado");
                                console.log(rs["preferenceid"]);
                                var preferenceid = rs["preferenceid"];
                                //var img=  $('#img'+id);


                                if (preferenceid != 0) {
                                    //creamos formulario de pago  
                                    $('#pago').empty();
                                    var form = document.createElement("form");
                                    form.method = "POST";
                                    form.action = "/procesar-pago";
                                    form.id = "form_pago";
                                    document.getElementById('pago').appendChild(form);
                                    var script = document.createElement("script");
                                    script.type = "text/javascript";
                                    script.src = 'https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js';    // use this for linked script
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
                                    carga(false, false);


                                });
                            }

                        }
                    });
                });




            }
        }
    });
}

//-------------------------------TRAE CONTENIDO DE CURSOS AL BOODY---------------------------------------
function mostrarcurso(idcurso) {
    $('#jumbotron').removeClass('d-none');
    $('#jumbotron').addClass('d-block');
    // console.log("id del curso a mostrar" + idcurso);
    $.ajax({

        url: "./php/consulta_cursos.php",//hacemos una peticion al archivo de altabajamodificacion consulta
        type: "post",
        data: { 'idcurso': idcurso },


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            $('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast");//mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {
            //escondemos el jumbotron de bienvenida

            $('#carga_cursos').hide("fast");//escondemos rapidamente los elementos que representan a los cursos

            let rs = JSON.parse(data);
            //console.log(rs);
            //$('#alert').addClass('alert-warning');
            //limpiamos contenedor 
            $('#contenedor_home').empty().append('<div id="accordion" > </div>');
            //agregamos acordeon con temas  y videos

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
                    '<div id="collapse' + i + '" class="collapse" aria-labelledby="heading' + i + '" data-parent="#accordion">' +
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


            //Funcion que se ejecuta cuando presionamos un videos
            $(".boton_video").click(function () {

                $('.modal-body').empty();
                $('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
                $('#carga_cursos').show("fast");
                $('#carga_cursos').hide("fast");

                $('#jumbotron').removeClass('d-block');
                $('#jumbotron').addClass('d-none');
                let idcourse = $(this).attr("curso");
                let id = $(this).attr("id");
                let tema = $(this).attr("tema");
                //console.log(tema);
                //console.log(rs[0]['videos'][0]['archivos']);
                let description;
                let namevideo;
                let imgvideo;
                let title;
                let archivos = '<ul class="list-group list-group-flush"><div class="card-body pb-0"> <h6 class="card-title">Archivos adjuntos</h6></div>';
                let datosVideo;
                let videocard;
                $.each(rs, (i, r) => {



                    if (r['name'] == tema) {


                        $.each(r['videos'], (j, r1) => {


                            if (r1['id'] == id) {

                                description = r1['description'];
                                namevideo = r1['name'];
                                imgvideo = r1['imgvideo'];
                                title = r1['title'];
                                datosVideo = description + "  " + namevideo + "  " + imgvideo + "  " + title;

                                $.each(r1['archivos'], (z, r2) => {


                                    archivos += '<a  class="list-group-item list-group-item-action text-info" download="' + r2['name'] + '" href="coursefiles/' + r2['filename'] + '"><i class="fas fa-file-alt"></i>' + ': ' + r2['name'] + ' </a>';
                                });

                            }


                        });
                    }

                });
                archivos += '</ul>';
                console.log(archivos);
                //preparamos video card del curso
                videocard =
                    '<div class=" row justify-content-center" >' +
                    '<div class="col-xl-6 mt-2">' +
                    '<div class="  mendocard shadow-lg w-100" style="width: 18rem;">' +
                    '<img src="imgcourses/' + imgvideo + '" class="mendocard-picture">' +
                    '<div class="">' +
                    '<h5 class="pt-2">' + title + '</h5>' +

                    '<p class=""> ' + description + ' </p>' +
                    archivos +
                    '<div class="container d-flex justify-content-around mb-3 mt-3 ">' +
                    '<button class=" btn btn-md p-1  btn-outline-dark mr-2 col-xs-12 col-xl-4"  id="' + idcourse + '">Volver</button>' +
                    '<button class=" btn btn-md p-1  btn-warning mr-2 col-xs-12 col-xl-4" id="video' + id + '">Ver </button>' +
                    '</div>' +
                    '</div>' +

                    '</div>' +
                    '</div>' +
                    '</div>';









                /*' <div class="card" style="width: 18rem;">' +
                    '<img src = "imgcourses/' + imgvideo + '" class="card-img-top" alt = "imagen de video">' +
                    '<div class="card-body pt-2 pb-0">' +
                    '<h5 class="card-title">' + title + '</h5>' +
                    '<p class="card-text">' + description + '</p>' +
                    ' </div>' + archivos +
                    '<div class="card-body">' +
                    '<a href="#" class="card-link" id="'+idcourse+'">Volver</a>' +
                    '<a href="#" class="card-link" id="video'+id+'">Ver video</a>' +
                    '</div>'
                '</div >';*/


                $('#contenedor_home').empty().append(videocard);

                $('#video' + id).click(function () {

                    $('#video').attr('src', "coursesvideos/" + namevideo);
                    $('#modalvideo').modal("show");

                });
                $('#' + idcourse).click(function () {
                    console.log(idcourse);
                    mostrarcurso(idcourse);

                });

                console.log("el id del video seleccionado es: " + id);
            });






            // $.getScript("./js/mostrarcurso.js", function () { });




        }

    });



}



//-------------------------------CARGA CURSO ------------------------------------------------------------   

function subircurso(ok) {
    if (ok) {
        $.ajax({

            url: "./php/admin.php",//script para subir cursos a la base de datos
            type: "post",
            data: ok,


            beforeSend: function () { //Previo a la peticion tenemos un cargando

                $('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
                $('#carga_cursos').show("fast");//mostramos rapidamente los elementos que representan a los cursos
            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

            },

            success: function (data) {

                $('#carga_cursos').hide("fast");//escondemos rapidamente los elementos que representan a los cursos
                //console.log(data);
                //$('#alert').addClass('alert-warning');
                $('#contenedor_home').empty().append(data);

                $.getScript("./js/admin.js", function () {


                });

            }

        });

    }

}
function jumbotron(accion) {


    if(accion==true){
        
    $('#jumbotron').removeClass('d-none');
    $('#jumbotron').addClass('d-block');

    /*//script para cambiar el jumbotron
    $('#jumbotron').empty().append(
        '<div class="container">' +
        '<h1 class="display-4">¡Hola' +
        '</h1>' +
        '<p class="lead">¿Listo para continuar?' +
        '</p>' +

        '</div>'
        );*/
    }else{
        
        $('#jumbotron').removeClass('d-block');
        $('#jumbotron').addClass('d-none');
    }
}

function subirvideo(ok) {
    jumbotron(false);
    if (ok) {
        $.ajax({

            url: "./php/subirvideo.php",
            type: "post",
            data: ok,
    
    
            beforeSend: function () { //Previo a la peticion tenemos un cargando
    
                $('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
                $('#carga_cursos').show("fast");//mostramos rapidamente los elementos que representan a los cursos
            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
    
            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
    
            },
    
            success: function (data) {
    
                $('#carga_cursos').hide("fast");//escondemos rapidamente los elementos que representan a los cursos
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
    jumbotron(false);

    $.ajax({

        url: "./php/admin.php",//script para subir cursos a la base de datos
        type: "post",
        data:  {"id":id},


        beforeSend: function () { //Previo a la peticion tenemos un cargando

            $('#contenedor_home').empty();//vaciamos el contenedor en el cual van a cargarse los cursos
            $('#carga_cursos').show("fast");//mostramos rapidamente los elementos que representan a los cursos
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);

        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },

        success: function (data) {

            $('#carga_cursos').hide("fast");//escondemos rapidamente los elementos que representan a los cursos
            //console.log(data);
            //$('#alert').addClass('alert-warning');
            $('#contenedor_home').empty().append(data);

            $.getScript("./js/modificarcurso.js", function () {


            });

        }

    });

}

$(document).ready(function () {

    carga(false, false);
    $("#cursos").click(function () {
        jumbotron(true);
        carga(false, false);
    });
    $("#cursos_comprados").click(function () {
        $('#jumbotron').removeClass('d-block');
        $('#jumbotron').addClass('d-none');
        carga(true, false);
    });
    $("#adminpanel").click(function () {
        $('#jumbotron').removeClass('d-block');
        $('#jumbotron').addClass('d-none');

    });


    $('#adminpanel').click(() => {
        subircurso(true);
        console.log("Admin");
    });

    $('#subirvideo').click(() => {
        //$('#pago').empty().append('<h2 class="alert alert-info"> <strong>La subida de videos estará habilitada en breve</strong>. </br></br>¡Muchas gracias!</h2>');
        //$('#exampleModal').modal('show');
       
        subirvideo(true);

    });

    
    $('#modificarcurso').click(() =>{ 
        jumbotron(false);
        carga(false,true);

     });




});
