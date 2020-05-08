//Script de landing page
//Si el modal de registro está abierto verificamos si se presionó la tecla enter .De ser así ejecutamos el script del boton de registro. 
$('#exampleModalCenter').on('show.bs.modal', function () {
    $(document).on('keypress', function (e) {
        if (e.which == 13) {
            $('#register_button').click();
        }
    });

});
//funcion encargada de verificar si presionamos enter en la pantalla principal del login *verificar que no estemos en el modal de register 
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

    //$('#modalcartel').modal('show');
    //$('#modalcartel').modal({backdrop: 'static', keyboard: false});

    //Inicializar el datepicker de Registro/Fecha Nacimiento
    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        language: 'es',
        format: 'mm/dd/yyyy'
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
                    '<div class="col-md-3 col-sm-5 portfolio-item">' +
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
                $('#login_button').removeClass('btn-primary');
                $('#login_button').addClass('btn-info');
                $('#login_button').html('<span class="spinner-border spinner-border-sm mr-2"></span>');
            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#login_button').html('<span class="spinner-border spinner-border-sm mr-2"></span>');

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#login_button').removeClass('btn-info');
                $('#login_button').addClass('btn-primary');
                $('#login_button').html('Ingresar');
            },
            success: function (rs) {
                console.log(rs);
                if (rs == 3) {
                    window.location.replace('home.php');
                } else {
                    if (rs == 4) {
                    $('#validate').html("valíde su correo");
                    }else{
                    //Alerta visual sobre usuario/contraseña erronea
                     $('#validate').html("Revise su email y contraseña");
                    }
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
    let legajo = $("#input-select option:selected").val(); //estará determinado por la opción seleccionada
    let pass = $('#passR').val();
    let rePass = $('#passRe').val();
    let date = $('#dp2').val();

    if (!is_ok(name)) {
        $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">El campo nombre, se encuentra vacío</div>');
    } else {
        $('#validate_register').empty();
        if (!is_ok(lastname)) {
            $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">El campo apellido, se encuentra vacío</div>');
        } else {
            if (!is_ok(dni) || isNaN(dni)) {
                $('#validate_register').empty().append('<div class="alert alert-warning" role="alert"> Formato de DNI incorrecto</div>');
            } else {
                $('#validate_register').empty();

                if (!IsEmail(email)) {
                    $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">Formato de mail incorrecto.</div>');
                } else {
                    $('#validate_register').empty();

                    if ((legajo.length<0)) {
                        $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">¡Seleccione una opción correcta!</div>');
                    } else {
                        $('#validate_register').empty();

                        if (!(pass.length > 6)) {
                            $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">La contraseña debe contener por lo menos 7 caracteres.</div>');
                        } else {
                            $('#validate_register').empty();
                            if(!validaPassword(pass, rePass)){
                                $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">Las contraseñas no coinciden</div>');

                            }else{
                                $('#validate_register').empty();
                            }

                        }
                    }
                }
            }
        }
    }






    if (validaPassword(pass, rePass)&&is_ok(name) && is_ok(lastname) && is_ok(legajo) && IsEmail(email) && is_ok(pass) && pass.length > 6 && is_ok(dni) && !isNaN(dni) && legajo.length > 0) {
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
                'rePass': rePass,
                'captcha': grecaptcha.getResponse(), //obtiene la respuesta para el widget reCaptcha 
                'date': date

            },
            beforeSend: function () { //Previo a la peticion tenemos un cargando
                $('#register_button').removeClass('btn-primary');
                $('#register_button').addClass('btn-dark');
                $('#register_button').html('<span class="spinner-border spinner-border-sm" disabled></span>');

            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#register_button').removeClass('disabled');
                $('#register_button').addClass('btn-primary');
                $('#register_button').html('Aceptar');

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#register_button').removeClass('btn-info');
                $('#register_button').addClass('btn-primary');
                $('#register_button').html('Aceptar');
            },

            success: function (rs) {
                console.log(rs);
                if (rs == 1) {
                    //Registro correcto
                    Toast.fire({
                        icon: 'success',
                        title: '¡Revise su casilla de correos!'
                    });
                    $('#exampleModalCenter').modal("hide");
                }
                if (rs == 0) {
                    Toast.fire({
                        icon: 'error',
                        title: '¡Error al enviar el mail!'
                    });
                }
                if (rs == 3) {
                    $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">¡Confirme que es humano!</div>');
                    grecaptcha.reset(widgetId1);
                }
                if (rs == 4) {
                    $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">¡Correo ya registrado!</div>');

                }
                if (rs == 0) {
                    $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">¡Error al enviar correo!</div>');

                }
                if (rs == 2) {//este cartel lo veremos si alguien se saltea la validacion del lado del cliente
                    $('#validate_register').empty().append('<div class="alert alert-warning" role="alert">¡Error de validación!</div>');

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
//restaurar pass

var onloadCallback = function () {
    //necesitamos dos captchas diferentes para cada modal,ya que al poner uno solo tenemos errores.La forma de poner multiples captchas 
    //es con Explicit rendering sacado de https://developers.google.com/recaptcha/docs/display
    widgetId1 = grecaptcha.render('recaptcha1', {
        'sitekey': '6LfM59sUAAAAABDJzCxvVSSV4npQ17JkcaSoXESB', //key del lado del cliente
        'theme': 'light'
    });
    widgetId2 = grecaptcha.render('recaptcha2', {
        'sitekey': '6LfM59sUAAAAABDJzCxvVSSV4npQ17JkcaSoXESB', //key del lado del cliente
        'theme': 'light'
    });
};



    function passRestore() {
   


    let email = $('#emailR2').val();
    let captcha = grecaptcha.getResponse(widgetId2) ;
    //alert(captcha);
    //console.log(captcha);

    if (!IsEmail(email)) {
        $('#validate_restore').empty().append('<div class="alert alert-warning" role="alert">Formato de mail incorrecto.</div>');
    } else {
        $('#validate_restore').empty();

    }



    if (IsEmail(email)) {
        $.ajax({
            method: 'POST',
            url: "php/restorepass.php",
            data: {

                'email': email,
                'captcha': captcha // grecaptcha.getResponse()


            },
            beforeSend: function () { //Previo a la peticion tenemos un cargando
                $('#pass_button').removeClass('btn-primary');
                $('#pass_button').addClass('btn-dark');
                $('#pass_button').html('<span class="spinner-border spinner-border-sm" disabled></span>');

            },
            error: function (error) { //Si ocurre un error en el ajax
                //alert("Error, reintentar. "+error);
                $('#pass_button').removeClass('disabled');
                $('#pass_button').addClass('btn-primary');
                $('#pass_button').html('Aceptar');

            },
            complete: function () { //Al terminar la peticion, sacamos la "carga" visual
                $('#pass_button').removeClass('btn-info');
                $('#pass_button').addClass('btn-primary');
                $('#pass_button').html('Aceptar');
            },
            success: function (rs) {
                console.log(rs);

                if (rs == 1) {
                    //Registro correcto
                    Toast.fire({
                        icon: 'success',
                        title: '¡Revise su casilla de correos!'
                    });
                    $('#exampleModalCenter').modal("hide");
                }
                if (rs == 0) {
                    Toast.fire({
                        icon: 'error',
                        title: '¡Mail inexistente!'
                    });
                }
                if (rs == 3) {
                    $('#validate_restore').empty().append('<div class="alert alert-warning" role="alert">¡Confirme que es humano!</div>');
                }
            }
        });
    } else {
        Toast.fire({
            icon: 'error',
            title: '¡Revisar campos del registro!'
        })
    }
}


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

function validaPassword(var1, var2)
{
    if (( var1 < var2)||(var1 > var2) ) { 
        return false;
    } else {
        return true;
    }



}

$(document).ready(function (){
    $('#pass_button').click(() => {

        passRestore();
    })






})