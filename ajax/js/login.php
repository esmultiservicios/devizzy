<script>
function sf(ID) {
    document.getElementById(ID).focus();
}

function redireccionar() {
    window.location = "../vistas/index.php";
}
$(document).ready(function() {
    $("#loginform").submit(function() {
        var url = '<?php echo SERVERURL;?>ajax/iniciarSesionAjax.php';
		
        $.ajax({
            type: 'POST',
            url: url,
            data: $('#loginform').serialize(),
            beforeSend: function() {
                swal({
                    title: "",
                    text: "Por favor espere...",
                    imageUrl: '<?php echo SERVERURL;?>vistas/plantilla/img/gif-load.gif',
                    closeOnConfirm: false,
                    showConfirmButton: false,
                    imageSize: '150x150',
                });
                $("#loginform #acceso").show();
            },
            success: function(resp) {
                var datos = eval(resp);
                if (datos[0] != "") {
                    setTimeout(window.location = datos[0], 1200);
                } else if (datos[1] == "ErrorS") {
                    swal({
                        title: "Error",
                        text: "Usuario o contraseña son incorrectos por favor corregir",
                        type: "error",
                        confirmButtonClass: 'btn-danger'
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
	
    $("#forgot_form").submit(function() {
        var url = '<?php echo SERVERURL;?>ajax/resetearContrasenaLoginAjax.php';
		
        $.ajax({
            type: 'POST',
            url: url,
            data: $('#forgot_form').serialize(),
            beforeSend: function() {
                swal({
                    title: "",
                    text: "Por favor espere...",
                    imageUrl: '<?php echo SERVERURL;?>vistas/plantilla/img/gif-load.gif',
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
                }else {
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