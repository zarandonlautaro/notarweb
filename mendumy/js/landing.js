//Script de landing page
$(document).on('keypress', function (e) {
    if (e.which == 13) {
        $('#login_button').click();
    }
});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5500,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

$(document).ready(() => {

    //Inicializar el datepicker de Registro/Fecha Nacimiento
    $('.datepicker').datepicker({
        language: 'es'
    });

    //Inicializar el select de Registro/País
    $(".js-example-basic-single").select2({
        allowClear: true,
        width: '100%'
    });

    //Realizamos la carga de cursos cuando la página ya está lista
    $.ajax({
        url: "php/traer_ultimos_cursos_landing.php",
        method: "POST",
        beforeSend: function () { //Previo a la peticion tenemos un cargando
        },
        error: function (error) { //Si ocurre un error en el ajax
            //alert("Error, reintentar. "+error);
        },
        complete: function () { //Al terminar la peticion, sacamos la "carga" visual

        },
        success: function (rs) {
            let courses = JSON.parse(rs);

            $.each(courses, (i, r) => {
                let name = r.name;
                let description = r.description;
                let imgname = r.imgname;
                $('#contenedor_cursos').append(
                    '<div class="col-md-4 col-sm-6 portfolio-item">' +
                    '<a class="portfolio-link js-scroll-trigger" href="#page-top">' +
                    '<div class="portfolio-hover">' +
                    '<div class="portfolio-hover-content" > ' +
                    '<i class="fas fa-plus fa-3x"></i>' +
                    '</div >' +
                    '</div >' +
                    '<img class="img-fluid" src="imgcourses/' + imgname + '" alt="">' +
                    '</a>' +
                    '<div class="portfolio-caption">' +
                    '<h4>' + name + '</h4>' +
                    '<p class="text-muted">' + description + '</p>' +
                    '</div>' +
                    '</div >');
            });
        }
    });
});


$('#email').on('input', function () {
    if (IsEmail($('#email').val())) {
        $('#email').removeClass('is-invalid');
        $('#email').addClass('is-valid');
    } else {
        if ($('#email').hasClass("is-valid")) {
            $('#email').removeClass('is-valid');
            $('#email').addClass('is-invalid');
        }
    }
});


$('#pass').on('input', function () {
    if ($('#pass').val().length > 5) {
        $('#pass').removeClass('is-invalid');
        $('#pass').addClass('is-valid');
    } else {
        if ($('#pass').hasClass("is-valid")) {
            $('#pass').removeClass('is-valid');
            $('#pass').addClass('is-invalid');
        }
    }
});



$('#login_button').click(() => {
    var email = $('#email').val();
    var pass = $('#pass').val();


    if (pass != void 0 && email != void 0 && IsEmail(email)) {
        //Campos completos --> Realizamos el login
        $.ajax({
            url: "php/login.php",
            data: {
                'email': email,
                'pass': pass
            },
            method: 'POST',
            beforeSend: function () { //Previo a la peticion tenemos un cargando
            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

            },
            success: function (rs) {
                //console.log(rs);
                if (rs == 3) {
                    window.location.replace('home.php');
                } else {
                    //Alerta visual sobre usuario/contraseña erronea
                    $('#validate').html("Revise su email y contraseña");
                }
            }
        });
    } else {
        $('#validate').html("Campos vacios!");
    }
});

$('#register_button').click(() => {
    let name = $('#nameR').val();
    let lastname = $('#lastnameR').val();
    let dni = $('#dniR').val();
    let email = $('#emailR').val();
    let legajo = $('#legajoR').val();
    let pass = $('#passR').val();


    if (!(pass.length > 6)) {
        $('#validate_register').empty().append("La contraseña debe contener por lo menos 7 caracteres");
    } else {
        $('#validate_register').empty();
        if (!(legajo.length > 2)) {
            $('#validate_register').empty().append("¡El legajo no puede estar vacio!");
        } else {
            $('#validate_register').empty();
            if (!IsEmail(email)) {
                $('#validate_register').empty().append("Formato de mail incorrecto");
            } else {
                $('#validate_register').empty();
                if (!is_ok(name)) {
                    $('#validate_register').empty().append("El campo nombre, se encuentra vacio");
                } else {
                    $('#validate_register').empty();
                    if (!is_ok(lastname)) {
                        $('#validate_register').empty().append("El campo apellido, se encuentra vacio");
                    } else {
                        if (!is_ok(dni)) {
                            $('#validate_register').empty().append("El campo DNI, se encuentra vacio");
                        } else {
                            $('#validate_register').empty();
                        }
                    }
                }
            }
        }
    }



    if (is_ok(name) && is_ok(lastname) && is_ok(legajo) && IsEmail(email) && is_ok(pass) && pass.length > 6 && is_ok(dni)) {
        $.ajax({
            method: 'POST',
            url: "php/register.php",
            data: {
                'name': name,
                'lastname': lastname,
                'dni': dni,
                'email': email,
                'legajo': legajo,
                'pass': pass,
                'captcha': grecaptcha.getResponse() //obtiene la respuesta para el widget reCaptcha 

            },
            beforeSend: function () { //Previo a la peticion tenemos un cargando

            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

            },
            success: function (rs) {
                console.log(rs);
                if (rs == 1) {
                    //Registro correcto
                    Toast.fire({
                        icon: 'success',
                        title: 'Revise su casilla de correos!'
                    });
                    $('#exampleModalCenter').modal("hide");
                }
                if (rs == 0) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error al enviar el mail!'
                    });
                }
                if (rs == 3) {
                    $('#validate_register').empty().append("Confirme que es humano!");
                }
            }
        });
    } else {
        Toast.fire({
            icon: 'error',
            title: 'Revisar campos del registro!'
        })
    }
});

$('#pass_button').click(() => {
    alert('Se lo dejo al master of PHP LEFELD');
    /*let name = $('#nameR').val();
    let lastname = $('#lastnameR').val();
    let dni = $('#dniR').val();
    let email = $('#emailR').val();
    let legajo = $('#legajoR').val();
    let pass = $('#passR').val();

    if (!(pass.length > 6)) {
        $('#validate_register').empty().append("Contraseña muy corta!");
    } else {
        $('#validate_register').empty();
        if (!(legajo.length > 2)) {
            $('#validate_register').empty().append("El legajo no puede estar vacio!");
        } else {
            $('#validate_register').empty();
            if (!IsEmail(email)) {
                $('#validate_register').empty().append("Formato de mail incorrecto");
            } else {
                $('#validate_register').empty();
                if (!is_ok(name)) {
                    $('#validate_register').empty().append("El campo nombre, se encuentra vacio");
                } else {
                    $('#validate_register').empty();
                    if (!is_ok(lastname)) {
                        $('#validate_register').empty().append("El campo apellido, se encuentra vacio");
                    } else {
                        if (!is_ok(dni)) {
                            $('#validate_register').empty().append("El campo DNI, se encuentra vacio");
                        } else {
                            $('#validate_register').empty();
                        }
                    }
                }
            }
        }
    }
    if (is_ok(name) && is_ok(lastname) && is_ok(legajo) && IsEmail(email) && is_ok(pass) && pass.length > 6 && is_ok(dni)) {
        $.ajax({
            method: 'POST',
            url: "php/register.php",
            data: {
                'name': name,
                'lastname': lastname,
                'dni': dni,
                'email': email,
                'legajo': legajo,
                'pass': pass,
                'captcha': grecaptcha.getResponse()

            },
            beforeSend: function () { //Previo a la peticion tenemos un cargando

            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual

            },
            success: function (rs) {
                console.log(rs);
                if (rs == 1) {
                    //Registro correcto
                    Toast.fire({
                        icon: 'success',
                        title: 'Revise su casilla de correos!'
                    });
                    $('#exampleModalCenter').modal("hide");
                }
                if (rs == 0) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error al enviar el mail!'
                    });
                }
                if (rs == 3) {
                    $('#validate_register').empty().append("Confirme que es humano!");
                }
            }
        });
    } else {
        Toast.fire({
            icon: 'error',
            title: 'Revisar campos del registro!'
        })
    }*/
});


function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

function is_ok(input) {
    if (input) {
        return 1;
    } else {
        return 0;
    }
}

