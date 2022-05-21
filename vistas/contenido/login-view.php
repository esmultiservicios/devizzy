<link href="<?php echo SERVERURL; ?>ajax/sweetalert/sweetalert.css" rel="stylesheet" crossorigin="anonymous"/>	
<script src="<?php echo SERVERURL; ?>ajax/sweetalert/sweetalert.min.js" crossorigin="anonymous"></script>
<script src="<?php echo SERVERURL; ?>ajax/query/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="<?php echo SERVERURL; ?>ajax/js/script_login.js" crossorigin="anonymous"></script>

<div id="logreg-forms">
	<form class="form-signin" id="loginform" action="" method="POST" autocomplete="off">
		<h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Iniciar Sesión</h1>
		
		<p><center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo.png" width="70%"></center></p>	
			
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fas fa-envelope-square"></i></span>
			</div>
			<input type="text" id="inputEmail" name="inputEmail" class="form-control" placeholder="Usuario o Correo electrónico" required="" autofocus>
		</div>
		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa fa-lock"></i></span>
			</div>
			<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required="">
			<div class="input-group-append">
				<button id="show_password" class="btn btn-primary" type="button"> <span id="icon" class="fa fa-eye-slash icon"></span> </button>
			</div>
		</div>			

		<div class="RespuestaAjax"></div>
		
		<button class="btn btn-primary btn-block" type="submit" id="enviar"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
		<a style="text-decoration:none;" href="#" id="forgot_pswd">¿Olvido su contraseña?</a>
		<hr>
		<!-- <p>Don't have an account!</p>  -->
		<button class="btn btn-primary btn-block" type="button" id="btn-signup" style="display: none;"><i class="fas fa-user-plus"></i> Registrate</button>
	</form>

	<form class="form-reset" id="forgot_form">
		<h1 class="h3 mb-3 font-weight-normal" style="text-align: center">Restablecer Contraseña</h1>
		<p><center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo.png" width="70%" height="20%"></center></p>	
	
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fas fa-envelope-square"></i></span>
			</div>
			<input type="text" class="form-control" placeholder="Usuario o Correo electrónico" required="" autofocus name="usu_forgot" id="usu_forgot">
		</div>
		
		<div class="RespuestaAjax"></div>		
		
		<button class="btn btn-primary btn-block" type="submit"> Restablecer</button>
		<a style="text-decoration:none;" href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Atrás</a>
	</form>
				
	<form class="form-signup" id="form_registro">
		<h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Formulario de Registro</h1>
		<p><center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo.png" width="70%" height="20%"></center></p>
		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fas fa-user"></i></span>
			</div>
			<input type="text" id="user-name" class="form-control" placeholder="Nombre Completo" required="" autofocus="">
		</div>
					
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fas fa-at"></i></span>
			</div>
			<input type="text" class="form-control" placeholder="Correo Electrónico" id="mail" name="email" required="">
			<div class="input-group-append">
				<span class="input-group-text">@algo.com</span>
			</div>
		</div>			

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa fa-lock"></i></span>
			</div>
			<input type="password" id="user-pass" class="form-control" placeholder="Contraseña" required="" autofocus="">
			<div class="input-group-append">
				<button id="show_password1" class="btn btn-primary" type="button"> <span id="icon1" class="fa fa-eye-slash icon"></span> </button>
			</div>
		</div>
		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa fa-lock"></i></span>
			</div>
			<input type="password" id="user-repeatpass" class="form-control" placeholder="Repetir Contraseña" required="" autofocus="">
			<div class="input-group-append">
				<button id="show_password2" class="btn btn-primary" type="button"> <span id="icon2" class="fa fa-eye-slash icon"></span> </button>
			</div>			   
		</div>			

		<button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Registrarse</button>
		<a style="text-decoration:none;" href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Atras</a>
	</form>
	<!-- Copyright -->
        <div class="footer-copyright text-center py-3">
		   <center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/firma_fayad.png" width="65%"></center>© 2021 -  <?php echo date("Y");?> Copyright: 
           <center>
		      <p class="navbar-text"> Todos los derechos reservados 
			  </p>
		   </center>
        </div>
	<!-- Copyright -->  

	<p style="text-align:center">
        <a href="http://bit.ly/2RjWFMfunction toggleResetPswd(e){
           e.preventDefault();
           $('#logreg-forms .form-signin').toggle() // display:block or none
           $('#logreg-forms .form-reset').toggle() // display:block or none
        }

        function toggleSignUp(e){
           e.preventDefault();
           $('#logreg-forms .form-signin').toggle(); // display:block or none
           $('#logreg-forms .form-signup').toggle(); // display:block or none
        }

        $(()=>{
           // Login Register Form
           $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
           $('#logreg-forms #cancel_reset').click(toggleResetPswd);
           $('#logreg-forms #btn-signup').click(toggleSignUp);
           $('#logreg-forms #cancel_signup').click(toggleSignUp);
        })g"
    </p>	
</div>


<?php
	require_once "./ajax/js/login.php";
?>