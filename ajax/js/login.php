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
                    icon: '<?php echo SERVERURL; ?>vistas/plantilla/img/gif-load.gif',
                    buttons: false, // Deshabilitar botones
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false, // Prevenir que el usuario cierre el modal al hacer clic afuera
                });
                $("#loginform #acceso").show();
            },
            success: function(resp) {
                var datos = eval(resp);
                if (datos[0] !== "") {
                    setTimeout(window.location = datos[0], 1200);
                } else if (datos[1] === "ErrorS") {
                    swal({
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML: `
                                <h2 style="color: #d9534f; font-size: 22px; margin-bottom: 15px;">
                                    ⚠️ Error de Autenticación
                                </h2>
                                <p style="font-size: 16px; color: #555;">
                                    <strong>Usuario o contraseña incorrectos.</strong> Por favor, verifique los datos ingresados.
                                </p>
                                <p style="font-size: 16px; color: #555;">
                                    🔑 Asegúrese de que el nombre de usuario y la contraseña sean correctos.
                                </p>
                            `
                        }
                    },
                    icon: "error",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                });
                } else if (datos[1] === "ErrorP") {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #f0ad4e; font-size: 22px; margin-bottom: 15px;">
                                        ⚠️ ¡Problemas con el Pago!
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        😕 ¡Oops! Parece que hay un problema con su acceso al sistema debido a un inconveniente con el pago.
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        📅 <strong>Fecha máxima de pago:</strong> El pago debe realizarse antes del <strong>día 15 de cada mes</strong>. A partir del <strong>día 16</strong>, su acceso podría verse restringido si la factura sigue pendiente.
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        No se preocupe, solo necesita ponerse en contacto con nuestro equipo de recaudación de pagos para arreglarlo.
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        💬 Puede escribirnos al 📞 <strong>+504 8913-6844</strong>, ¡y con gusto le ayudaremos! 😊
                                    </p>
                                `
                            }
                        },
                        icon: "warning",
                        dangerMode: true,
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    });
                } else if (datos[1] === "ErrorVacio") {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #d9534f; font-size: 22px; margin-bottom: 15px;">
                                        ⚠️ Error
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        <strong>Lo sentimos</strong>, uno de los dos campos no puede ir en blanco. El sistema requiere tanto el cliente como el PIN para continuar.
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        Si lo desea, puede dejar ambos campos en blanco, y el sistema los ignorará.
                                        <span style="color: #5bc0de;">Por favor, complete los campos para continuar.</span>
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        😓 Lamentamos el inconveniente, y agradecemos su comprensión. 🙏
                                    </p>
                                `
                            }
                        },
                        icon: "error",
                        dangerMode: true,
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                    });
                } else if (datos[1] === "ErrorPinInvalido") {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #d9534f; font-size: 22px; margin-bottom: 15px;">
                                        ⚠️ Error
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        <strong>Lo sentimos</strong>, el código del cliente o el PIN son inválidos, o el mismo ha vencido. 
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        Por favor, solicite un nuevo PIN al cliente para continuar con el proceso.
                                        <span style="color: #5bc0de;">Agradecemos su comprensión.</span>
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        😔 Si necesita asistencia adicional, no dude en ponerse en contacto con nuestro soporte. 🙏
                                    </p>
                                `
                            }
                        },
                        icon: "error",
                        dangerMode: true,
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                    });
                } else if (datos[1] === "ErrorC") {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #5bc0de; font-size: 22px; margin-bottom: 15px;">
                                        📧 No se encontró una cuenta asociada a este correo electrónico
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        <strong>¿Desea registrarse o explorar nuestros productos?</strong>
                                    </p>
                                `
                            }
                        },
                        icon: "info",
                        buttons: {
                            cancel: "Cerrar",
                            register: {
                                text: "Sí, registrarme!",
                                value: "register",
                            },
                            explore: {
                                text: "Explorar productos",
                                value: "explore",
                            }
                        },
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    })
                    .then((value) => {
                        switch (value) {
                            case "register":
                                // El usuario eligió registrarse, muestra el formulario de registro.
                                setTimeout(function() {
                                    $("#form_registro").show();
                                    $("#loginform").hide();
                                    swal.close();
                                }, 1000);
                                break;

                            case "explore":
                                // El usuario eligió explorar productos, muestra el mensaje de mantenimiento.
                                swal({
                                    content: {
                                        element: "div",
                                        attributes: {
                                            innerHTML: `
                                                <h2 style="color: #f0ad4e; font-size: 22px; margin-bottom: 15px;">
                                                    🔧 Mantenimiento en Curso
                                                </h2>
                                                <p style="font-size: 16px; color: #555;">
                                                    Estamos trabajando para mejorar nuestros servicios. <strong>Disculpa las molestias.</strong>
                                                </p>
                                                <p style="font-size: 16px; color: #555;">
                                                    ⚙️ Agradecemos tu paciencia. ¡Pronto estaremos de vuelta!
                                                </p>
                                            `
                                        }
                                    },
                                    icon: "error",
                                    buttons: {
                                        confirm: {
                                            text: "Aceptar",
                                            closeModal: true,
                                        }
                                    },
                                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                                });
                                break;

                            default:
                                // El usuario eligió cerrar el cuadro de diálogo.
                                swal.close();
                        }
                    });
                } else {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #d9534f; font-size: 22px; margin-bottom: 15px;">
                                        ❌ Error
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        <strong>No se enviaron los datos</strong>, por favor, corrija los errores y vuelva a intentar.
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        ⚠️ Asegúrese de verificar los campos obligatorios y los datos ingresados.
                                    </p>
                                `
                            }
                        },
                        icon: "error",
                        dangerMode: true,
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                    });
                }
            },
            error: function() {
                swal({
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML: `
                                <h2 style="color: #d9534f; font-size: 22px; margin-bottom: 15px;">
                                    ❗ Error Inesperado
                                </h2>
                                <p style="font-size: 16px; color: #555;">
                                    <strong>Ocurrió un error inesperado</strong>, o tal vez no tenga conexión con el sistema.
                                </p>
                                <p style="font-size: 16px; color: #555;">
                                    🚧 Por favor, intente nuevamente más tarde.
                                </p>
                            `
                        }
                    },
                    icon: "error",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
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
            content: {
                element: "div",
                attributes: {
                    innerHTML: `
                        <h2 style="color: #f0ad4e; font-size: 22px; margin-bottom: 15px;">
                            🔧 Mantenimiento en Curso
                        </h2>
                        <p style="font-size: 16px; color: #555;">
                            Estamos trabajando para mejorar nuestros servicios. <strong>Disculpa las molestias.</strong>
                        </p>
                        <p style="font-size: 16px; color: #555;">
                            ⚙️ Pronto estará disponible nuevamente. ¡Gracias por tu comprensión!
                        </p>
                    `
                }
            },
            icon: "error",
            buttons: {
                confirm: {
                    text: "Aceptar",
                    closeModal: true,
                }
            },
            closeOnEsc: false, // Desactiva el cierre con la tecla Esc
            closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
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
                    icon: '<?php echo SERVERURL; ?>vistas/plantilla/img/gif-load.gif',
                    closeOnConfirm: false,
                    showConfirmButton: false,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    imageSize: '150x150',
                });
                $("#loginform #acceso").show();
            },
            success: function(resp) {
                if (resp == 1) {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #28a745; font-size: 22px; margin-bottom: 15px;">
                                        ✅ ¡Éxito!
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        Tu <strong>contraseña</strong> ha sido reseteada exitosamente. 🎉
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        Un correo electrónico ha sido enviado con los detalles para que puedas acceder nuevamente. 📧
                                    </p>
                                `
                            }
                        },
                        icon: "success",
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                    });
                } else if (resp == 2) {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #dc3545; font-size: 22px; margin-bottom: 15px;">
                                        ❌ Error
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        Lamentablemente, hubo un problema al resetear tu <strong>contraseña</strong>. 😔
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        Por favor, intenta nuevamente más tarde o contacta con nuestro soporte. 📞
                                    </p>
                                `
                            }
                        },
                        icon: "error",
                        dangerMode: true,
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                    });
                } else if (resp == 3) {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #dc3545; font-size: 22px; margin-bottom: 15px;">
                                        ❌ Error
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        El <strong>usuario</strong> ingresado no existe. 😕
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        Verifica si el nombre de usuario está escrito correctamente o si aún no estás registrado. 📲
                                    </p>
                                `
                            }
                        },
                        icon: "error",
                        dangerMode: true,
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                    });
                } else {
                    swal({
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: `
                                    <h2 style="color: #dc3545; font-size: 22px; margin-bottom: 15px;">
                                        ❌ Error
                                    </h2>
                                    <p style="font-size: 16px; color: #555;">
                                        Hubo un problema al completar los datos. 😓
                                    </p>
                                    <p style="font-size: 16px; color: #555;">
                                        Verifica que todos los campos estén correctamente llenos. Si el problema persiste, inténtalo de nuevo. 🔄
                                    </p>
                                `
                            }
                        },
                        icon: "error",
                        dangerMode: true,
                        closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                        closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
                    });
                }
            },
            error: function() {
                swal({
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML: `
                                <h2 style="color: #dc3545; font-size: 22px; margin-bottom: 15px;">
                                    ❌ Error de Inicio de Sesión
                                </h2>
                                <p style="font-size: 16px; color: #555;">
                                    Oops! 😕 Hubo un problema al procesar su solicitud de inicio de sesión.
                                </p>
                                <p style="font-size: 16px; color: #555;">
                                    Verifique sus credenciales o intente nuevamente en unos minutos. 🔄
                                </p>
                            `
                        }
                    },
                    icon: "error",
                    dangerMode: true,
                    closeOnEsc: false, // Desactiva el cierre con la tecla Esc
                    closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
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