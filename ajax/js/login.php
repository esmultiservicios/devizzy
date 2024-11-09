<script>
function sf(ID) {
    document.getElementById(ID).focus();
}

function redireccionar() {
    window.location = "../vistas/index.php";
}

$(document).ready(function() {
    $("#generate_pin_link").click(function(e) {
        e.preventDefault();

        // Generar un nuevo número de PIN (puedes personalizar esta lógica)
        var newPin = Math.floor(Math.random() * 10000);

        // Actualizar el valor del número de PIN en el elemento span correspondiente
        $("#pin_value").text(newPin);
    });

    $("#cancel_reset").on("click", function() {
        $('#form-signin')[0].reset();
        document.getElementById("inputEmail").focus();
    });

    $("#cancel_signup").on("click", function() {
        $('#form-signin')[0].reset();
        document.getElementById("inputEmail").focus();
    });

    $("#forgot_pswd").on("click", function() {
        document.getElementById("usu_forgot").focus();
    });

    $("#btn-signup").on("click", function() {
        document.getElementById("user_name").focus();
    });
});

var timeout; // Variable para manejar el tiempo de espera entre escritura y validación

$('#inputCliente').on('input', function() {
    var inputEmailValue = $(this).val();

    if (inputEmailValue.length === 8) {
        $('#inputPin').focus();
    }
});

$("#inputEmail, #inputPassword").on("input blur", function() {
    clearTimeout(timeout); // Limpiar el temporizador anterior
    var email = $("#inputEmail").val();
    var password = $("#inputPassword").val();

    timeout = setTimeout(function() {
            if (email !== "" && password !== "") {
                var url = '<?php echo SERVERURL; ?>core/getValidUserSesion.php';

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        email: email,
                        pass: password
                    },
                    success: function(resp) {
                        if (resp === "1") {
                            $("#groupDB").show();
                            $("#inputCliente").focus();
                        } else {
                            $("#groupDB").hide();
                            // Limpia y oculta los campos de inputCliente e inputPin
                            $("#inputCliente, #inputPin").val("");
                        }
                    },
                    error: function() {
                        $("#groupDB").hide(); // Oculta el campo de selección inputDB
                        // Limpia y oculta los campos de inputCliente e inputPin
                        $("#inputCliente, #inputPin").val("");
                        $(".RespuestaAjax").html(
                            "Error de autenticación"); // Muestra un mensaje de error al usuario
                    }
                });
            } else {
                $("#groupDB").hide();
                // Limpia los campos de inputCliente e inputPin si alguno está vacío
                if (email === "") {
                    $("#inputCliente").val("");
                }
                if (password === "") {
                    $("#inputPin").val("");
                }
            }
        },
        300
    ); // Establece un tiempo de espera de 300 milisegundos (medio segundo) después de que el usuario deje de escribir
});


$(document).ready(function() {
    $("#loginform").submit(function(e) {
        e.preventDefault();

        var url = '<?php echo SERVERURL; ?>ajax/iniciarSesionAjax.php';

        $.ajax({
            type: 'POST',
            url: url,
            data: $('#loginform').serialize(),
            beforeSend: function() {
                swal({
                    title: "",
                    text: "Por favor espere...",
                    imageUrl: '<?php echo SERVERURL; ?>vistas/plantilla/img/gif-load.gif',
                    closeOnConfirm: false,
                    showConfirmButton: false,
                    imageSize: '150x150',
                });
                $("#loginform #acceso").show();
            },
            success: function(resp) {
                var datos = eval(resp);
                if (datos[0] !== "") {
                    setTimeout(window.location = datos[0], 1200);
                } else if (datos[1] === "ErrorS") {
                    swal({
                        title: "Error",
                        text: "Usuario o contraseña son incorrectos por favor corregir",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
                    });
                } else if (datos[1] === "ErrorP") {
                    swal({
                        title: "¡Problemas con el Pago!",
                        text: "¡Oops! Parece que hay un problema con su acceso al sistema debido a un inconveniente con el pago. No se preocupe, solo necesita ponerse en contacto con nuestro equipo de recaudación de pagos para arreglarlo. Puede escribirnos al +504 3227-3380, ¡y con gusto le ayudaremos!",
                        type: "warning",
                        confirmButtonClass: 'btn-warning'
                    });
                } else if (datos[1] === "ErrorVacio") {
                    swal({
                        title: "Error",
                        text: "Lo sentimos, uno de los dos campos no puede ir en blanco. El sistema requiere tanto el cliente como el PIN para continuar. Si lo desea, puede dejar ambos campos en blanco, y el sistema los ignorará.",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
                    });
                } else if (datos[1] === "ErrorPinInvalido") {
                    swal({
                        title: "Error",
                        text: "Lo sentimos, el código del cliente o el pin son inválidos, o el mismo ha vencido, por favor solicite otro pin al cliente.",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
                    });
                } else if (datos[1] === "ErrorC") {
                    swal({
                        title: "No se encontró una cuenta asociada a este correo electrónico.",
                        text: "¿Desea registrarse o explorar nuestros productos?",
                        type: "info",
                        showCancelButton: true,
                        showConfirmButton: true,
                        confirmButtonText: "Sí, deseo registrarme!",
                        cancelButtonText: "Explorar productos",
                        confirmButtonClass: 'btn-primary',
                        cancelButtonClass: 'btn-danger',
                        closeOnConfirm: false,
                        closeOnCancel: false, // Evita que el cuadro de diálogo se cierre automáticamente después de hacer clic en "Cancelar"
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showLoaderOnConfirm: true // Activa el efecto de carga en el botón "Aceptar"
                    }, function(isConfirmed) {
                        // Esta función se ejecutará cuando se haga clic en el botón "Aceptar" o "Cancelar"

                        if (isConfirmed) {
                            // Realiza aquí las acciones que desees al confirmar
                            // Puedes mostrar otro cuadro de diálogo, redirigir, etc.

                            // Ejemplo: redirige a una página después de 2 segundos (ajusta el tiempo según tus necesidades)
                            setTimeout(function() {
                                // El usuario eligió registrarse, muestra el formulario de registro.
                                $("#form_registro").show();
                                // También puedes desactivar el formulario de inicio de sesión si es necesario.
                                $("#loginform").hide();

                                swal.close();
                            }, 1000);
                        } else {
                            // El usuario eligió explorar productos, puedes redirigirlo a la página de productos o a donde desees.
                            /*window.location.href =
                                "ruta/a/tu/pagina_de_productos.html";*/

                            swal({
                                title: "Mantenimiento en Curso",
                                text: "Estamos trabajando para mejorar nuestros servicios. Disculpa las molestias.",
                                type: "warning",
                                confirmButtonClass: 'btn-warning',
                                confirmButtonText: "Aceptar",
                                showCloseButton: true, // Muestra un botón de cierre (X) para cerrar el cuadro de diálogo
                                allowOutsideClick: false, // Evita que se cierre haciendo clic fuera del cuadro de diálogo
                                allowEscapeKey: false // Evita que se cierre al presionar la tecla Esc
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Error",
                        text: "No se enviaron los datos, favor corregir",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
                    });
                }
            },
            error: function() {
                swal({
                    title: "Error",
                    text: "Ocurrió un error inesperado, o quizás no tenga conexión con el sistema, por favor intentar más tarde",
                    type: "error",
                    confirmButtonClass: 'btn-danger'
                });
                $("#loginform #acceso").hide();
                $("#loginform #acceso").html("");
                $("#loginform #usu").focus();
            }
        });

        return false;
    });

    $("#form_registro #registrarse").on("click", function(e) {
        e.preventDefault();

        swal({
            title: "Mantenimiento en Curso",
            text: "Estamos trabajando para mejorar nuestros servicios. Disculpa las molestias.",
            type: "warning",
            confirmButtonClass: 'btn-warning',
            confirmButtonText: "Aceptar",
            showCloseButton: true, // Muestra un botón de cierre (X) para cerrar el cuadro de diálogo
            allowOutsideClick: false, // Evita que se cierre haciendo clic fuera del cuadro de diálogo
            allowEscapeKey: false // Evita que se cierre al presionar la tecla Esc
        });
    });

    $("#forgot_form").submit(function(e) {
        e.preventDefault();

        var url = '<?php echo SERVERURL; ?>ajax/resetearContrasenaLoginAjax.php';

        $.ajax({
            type: 'POST',
            url: url,
            data: $('#forgot_form').serialize(),
            beforeSend: function() {
                swal({
                    title: "",
                    text: "Por favor espere...",
                    imageUrl: '<?php echo SERVERURL; ?>vistas/plantilla/img/gif-load.gif',
                    closeOnConfirm: false,
                    showConfirmButton: false,
                    imageSize: '150x150',
                });
                $("#loginform #acceso").show();
            },
            success: function(resp) {
                if (resp == 1) {
                    swal({
                        title: "Success",
                        text: "Contraseña reseteada, se ha enviado a su correo electrónico",
                        type: "success",
                    });
                } else if (resp == 2) {
                    swal({
                        title: "Error",
                        text: "Error al resetear la contraseña",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
                    });
                } else if (resp == 3) {
                    swal({
                        title: "Error",
                        text: "El usuario ingresado no existe",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
                    });
                } else {
                    swal({
                        title: "Error",
                        text: "Error al completar los datos",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
                    });
                }
            },
            error: function() {
                swal({
                    title: "Error",
                    text: "Error al procesar su solicitud de inicio de sesión",
                    type: "error",
                    confirmButtonClass: 'btn-danger'
                });
            }
        });
        return false;
    });
});
$(function() {
    $('#inicio_sesion').click(function(e) {
        $("#loginform").delay(100).fadeIn(100);
        $("#forgot_form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#forgot').click(function(e) {
        $("#forgot_form #usu_forgot").focus();
        $("#forgot_form").delay(100).fadeIn(100);
        $("#loginform").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
});
$(document).ready(function() {
    $('#loginform #show_password').on('mousedown', function() {
        var cambio = $("#loginform #inputPassword")[0];
        if (cambio.type == "password") {
            cambio.type = "text";
            $('#loginform #icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        } else {
            cambio.type = "password";
            $('#loginform #icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    });
    $('#loginform #show_password').on('click', function() {
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
    });
    $('#loginform #show_password').on('mouseout', function() {
        $('#loginform #icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        var cambio = $("#loginform #inputPassword")[0];
        cambio.type = "password";
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
        return false;
    });
});
$(document).ready(function() {
    $('#form_registro #show_password1').on('mousedown', function() {
        var cambio = $("#form_registro #user-pass")[0];
        if (cambio.type == "password") {
            cambio.type = "text";
            $('#form-signup #icon1').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        } else {
            cambio.type = "password";
            $('#form-signup #icon1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    });
    $('#form_registro #show_password1').on('click', function() {
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
    });
    $('#form_registro #show_password1').on('mouseout', function() {
        $('#form_registro #icon1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        var cambio = $("#form_registro #user-pass")[0];
        cambio.type = "password";
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
        return false;
    });
    $('#form_registro #show_password2').on('mousedown', function() {
        var cambio = $("#form_registro #user-repeatpass")[0];
        if (cambio.type == "password") {
            cambio.type = "text";
            $('#form-signup #icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        } else {
            cambio.type = "password";
            $('#form-signup #icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    });
    $('#form_registro #show_password2').on('click', function() {
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
    });
    $('#form_registro #show_password2').on('mouseout', function() {
        $('#form_registro #icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        var cambio = $("#form_registro #user-repeatpass")[0];
        cambio.type = "password";
        $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
        return false;
    });
});
</script>