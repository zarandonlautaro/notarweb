$('#adminpanel').click(() => {
    console.log("admin");
});

$(function () {
    // Sidebar toggle behavior
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
    });
});

$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

//Realizamos la carga de cursos cuando la página ya está lista
function carga(comprados) {
    var cuerpo = "";
    $.ajax({
        url: "php/traer_cursos_main.php",
        method: "POST",
        data: { "comprados": comprados },
        beforeSend: function () { //Previo a la peticion tenemos un cargando
            $('#contenedor_home').empty();
            $('#carga_cursos').show("fast");
        },
        success: function (rs) {
            $('#carga_cursos').hide("fast");
            if (rs == 0) { //No hay cursos
                cuerpo = "<div class='text-center'><h3>No hay cursos</h3></div>";
                $('#curso' + i).empty();
                $('#curso' + i).append(cuerpo);
            }
            if (rs != 0 && rs != 4) {
                let courses = JSON.parse(rs);
                var fila = 0;
                $.each(courses, (i, r) => {
                    if ((i % 3) == 0) {
                        fila++;
                        $('#contenedor_home').append('<div class="row" id="fila' + fila + '"> </div>');
                    }
                    if (r['bought']) { //CURSOS COMPRADOS
                        $('#fila' + fila).append(
                            '<div class="col-xl-4 mt-4">' +
                            '<div class="mendocard shadow-lg" style="width: 18rem;" curso=' + r['id'] + ' id=curso' + r['id'] + '>' +
                            '<img src="imgcourses/' + r['imgname'] + '" class="mendocard-picture">' +
                            '<div class="">' +
                            '<h5 class="pt-2">' + r['name'] + '</h5>' +
                            '<p class="">' + r['description'] + '</p>' +
                            '<p class="btn btn-block btn-primary"> Ver </p>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                    } else if (!(r['bought'])) { //CURSOS SIN COMPRAR
                        $('#fila' + fila).append(
                            '<div class="col-xl-4 mt-4">' +
                            '<div class="mendocard shadow-lg" style="width: 18rem;" curso=' + r['id'] + ' id=curso' + r['id'] + '>' +
                            '<img src="imgcourses/' + r['imgname'] + '" class="mendocard-picture">' +
                            '<div class="">' +
                            '<h5 class="pt-2">' + r['name'] + '</h5>' +
                            '<p class="">' + r['description'] + '</p>' +
                            '<p class="" id="pago' + r["preferenceid"] + '"></p>' +
                            '</div>' +
                            '</div>' +
                            '</div>');

                        var form = document.createElement("form");
                        form.method = "POST";
                        form.action = "/procesar-pago";
                        form.id = "form_pago_" + r['preferenceid'];
                        document.getElementById('pago' + r['preferenceid']).appendChild(form);

                        var script = document.createElement("script");
                        script.type = "text/javascript";
                        script.src = 'https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js';    // use this for linked script
                        script.setAttribute("data-preference-id", r['preferenceid']);
                        document.getElementById('form_pago_' + r['preferenceid']).appendChild(script);
                    }



                    $('#curso' + r.id).click(function () {
                        //Comprobamos que tenga el curso comprado
                        let id = $(this).attr("curso");
                        $.ajax({
                            url: "php/check_curso_comprado.php",
                            method: "POST",
                            data: { "idcourse": id },
                            beforeSend: function () { //Previo a la peticion tenemos un cargando

                            },
                            error: function (error) { //Si ocurre un error en el ajax
                                //alert("Error, reintentar. "+error);
                            },
                            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

                            },
                            success: function (rs) {
                                if (rs == 3) {
                                    $('#video').attr('src', "coursesvideos/" + id + ".mp4");
                                    $('#modalvideo').modal("show");
                                }
                            }
                        });
                    });
                });
            }
        }
    });
}


$(document).ready(function () {
    carga(false);
    $("#cursos").click(function () {
        carga(false);
    });
    $("#cursos_comprados").click(function () {
        carga(true);
    });
});
