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
function carga(comprados) {
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
                        $('#fila' + fila).append(

                            '<div class="col-xl-4 mt-2">' +
                            '<div class="mendocard shadow-lg " style="width: 18rem;" curso=' + r['id'] + '>' +
                            '<img src="imgcourses/' + r['imgname'] + '"' + 'img=' + r['imgname'] + '" class="mendocard-picture">' +
                            '<div class="">' +
                            '<h5 class="pt-2">' + r['name'] + '</h5>' +
                            '<p class="">' + r['description'] + '</p>' +
                            '<button class="curso btn btn-block btn-success " tipo=Comprar curso=' + r['id'] + ' id=curso' + r['id'] + '> Comprar </button>' +
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



                $(".curso").click(function () {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-dark');

                    $('.modal-body').empty();

                    let id = $(this).attr("curso");
                    let tipo = $(this).attr("tipo");
                    console.log(id);
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
                            console.log(courses);
                            let r = JSON.parse(courses);
                            let rs = r[0];
                            console.log(rs[0]);
                            console.log(rs['videoname']);

                            if (rs['bought'] == true) {
                                console.log("cargó el curso");
                                $('#pago').empty().append('<h2 class="display-5 alert alert-info"> <strong>La carga de cursos estará habilitada en breve</strong>. </br></br>¡Muchas gracias!</h2>');
                                $('#exampleModal').modal('show');

                                /*  $('#contenedor_home').empty().append('Aqui estará el curso');
                                $('#video').attr('src', "coursesvideos/" + rs['videoname']);
                                $('#modalvideo').modal("show");*/

                            } else {
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
                                    carga(false);


                                });
                            }

                        }
                    });
                });




            }
        }
    });
}


function admin(ok) {
    if (ok) {
        $.ajax({

            url: "./php/admin.php",
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

$(document).ready(function () {

    carga(false);
    $("#cursos").click(function () {
        $('#jumbotron').removeClass('d-none');
        $('#jumbotron').addClass('d-block');
        carga(false);
    });
    $("#cursos_comprados").click(function () {
        $('#jumbotron').removeClass('d-block');
        $('#jumbotron').addClass('d-none');
        carga(true);
    });
    $("#adminpanel").click(function () {
        $('#jumbotron').removeClass('d-block');
        $('#jumbotron').addClass('d-none');

    });


    $('#adminpanel').click(() => {
        admin(true);
        console.log("Admin");
    });

    $('#subirvideo').click(() => {
        $('#pago').empty().append('<h2 class="alert alert-info"> <strong>La subida de videos estará habilitada en breve</strong>. </br></br>¡Muchas gracias!</h2>');
        $('#exampleModal').modal('show');

    });

    $('#modificarcurso').click(() => {
        $('#pago').empty().append('<h2 class=" alert alert-info"> <strong>La modificación de cursos estará habilitada en breve</strong>. </br></br>¡Muchas gracias!</h2>');
        $('#exampleModal').modal('show');
    });





});
