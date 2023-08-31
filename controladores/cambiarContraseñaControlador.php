<?php
    if($peticionAjax){
        require_once "../modelos/cambiarContraseñaModelo.php";
		require_once "../core/Database.php";
		require_once "../core/sendEmail.php";		
    }else{
        require_once "./modelos/cambiarContraseñaModelo.php";
		require_once "../core/Database.php";
		require_once "./core/sendEmail.php";		
    }
	
	class cambiarContraseñaControlador extends cambiarContraseñaModelo{		
		public function edit_contraseña_controlador(){
			$contraseña = mainModel::encryption($_POST['nuevacontra']);

			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$database = new Database();
			$sendEmail = new sendEmail();			

			$users_id = $_SESSION['users_id_sd'];

			$datos = [
				"users_id" => $users_id,
				"contraseña" => $contraseña,				
			];		

			$query = cambiarContraseñaModelo::edit_contraseña_modelo($datos);
			
			if($query){	
				//OBTENEMOS EL NOMBRE DEL COLABORADOR
				$tablColaborador = "colaboradores";
				$camposColaborador = ["nombre", "apellido"];
				$condicionesColaborador = ["colaboradores_id" => $users_id];
				$orderBy = "";
				$resultadoColaborador = $database->consultarTabla($tablColaborador, $camposColaborador, $condicionesColaborador, $orderBy);

				$colaborador_nombre = "";

				if (!empty($resultadoColaborador)) {
					$colaborador_nombre = trim($resultadoColaborador[0]['nombre'].' '.$resultadoColaborador[0]['apellido']);
				}

				//OBTENEMOS EL CORREO DEL USUARUIO
				$tablaUsuario = "users";
				$camposUsuario = ["email"];
				$condicionesUsuario = ["users_id" => $users_id];
				$orderBy = "";
				$resultadoUsuario = $database->consultarTabla($tablaUsuario, $camposUsuario, $condicionesUsuario, $orderBy);

				$correo_usuario = "";

				if (!empty($resultadoUsuario)) {
					$correo_usuario = trim($resultadoUsuario[0]['email']);
				}

				$correo_tipo_id = "1";//Notificaciones
				$urlSistema = "https://izzycloud.app/";
				$destinatarios = array($correo_usuario => $colaborador_nombre);

				// Destinatarios en copia oculta (Bcc)
				$bccDestinatarios = [];

				$asunto = "¡Cambio de Contraseña Exitoso!";
				$mensaje = '
					<div style="padding: 20px;">
						<p style="margin-bottom: 10px;">
							¡Hola '.$colaborador_nombre.'!
						</p>
						
						<p style="margin-bottom: 10px;">
							Esperamos que te encuentres bien. Queremos informarte que se ha realizado con éxito el cambio de tu contraseña en nuestro sistema IZZY. Esta solicitud de cambio de contraseña fue iniciada por ti, por lo que no debes preocuparte.
						</p>								
						
						<p style="margin-bottom: 10px;">
							Si no realizaste esta acción personalmente, te sugerimos que inicies sesión primero. Posteriormente, te recomendamos cambiar tu contraseña por una que elijas en la sección de configuración de tu cuenta. Para acceder al Sistema IZZY, simplemente haz clic en el siguiente enlace:
						</p>					
						
						<p style="margin-bottom: 10px;">
							<a href='.$urlSistema.'>Clic para Acceder a IZZY<a>
						</p>
						
						<p style="margin-bottom: 10px;">
							La seguridad de tu cuenta es de suma importancia para nosotros. Si no reconoces esta acción o tienes alguna pregunta, por favor, contáctanos de inmediato. Estamos aquí para brindarte la ayuda que necesitas y asegurarnos de que tu experiencia sea segura y sin problemas.
						</p>
																				
						<p style="margin-bottom: 10px;">
							Agradecemos tu confianza en CLINICARE y esperamos seguir ofreciéndote un servicio excepcional.
						</p>
						
						<p style="margin-bottom: 10px;">
							Saludos cordiales,
						</p>
						
						<p>
							<b>El Equipo de CLINICARE</b>
						</p>                
					</div>
				';

				$archivos_adjuntos = [];
				$sendEmail->enviarCorreo($destinatarios, $bccDestinatarios, $asunto, $mensaje, $correo_tipo_id, $users_id, $archivos_adjuntos);

				$alert = [
					"alert" => "cerrar",
					"title" => "Registro modificado",
					"text" => "La contraseña se ha cambiado satisfactoriamente",
					"type" => "success",
					"btn-class" => "btn-primary",
					"btn-text" => "¡Bien Hecho!",
				];
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Ocurrio un error inesperado",
					"text" => "No hemos podido procesar su solicitud",
					"type" => "error",
					"btn-class" => "btn-danger",					
				];				
			}			
			
			return mainModel::sweetAlert($alert);
		}

		public function resetear_contraseña_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$database = new Database();
			$sendEmail = new sendEmail();
			
			$contraseña = cambiarContraseñaModelo::generar_pass_complejo();
			$users_id = $_POST['users_id'];

			$datos = [
				"users_id" => $users_id,
				"contraseña" => mainModel::encryption($contraseña),			
			];		

			$query = cambiarContraseñaModelo::edit_contraseña_modelo($datos);

			//OBTENEMOS EL NOMBRE DEL COLABORADOR
			$respuesta = 0;
			$tablColaborador = "colaboradores";
			$camposColaborador = ["nombre", "apellido"];
			$condicionesColaborador = ["colaboradores_id" => $users_id];
			$orderBy = "";
			$resultadoColaborador = $database->consultarTabla($tablColaborador, $camposColaborador, $condicionesColaborador, $orderBy);

			$colaborador_nombre = "";

			if (!empty($resultadoColaborador)) {
				$colaborador_nombre = trim($resultadoColaborador[0]['nombre'].' '.$resultadoColaborador[0]['apellido']);
			}

			//OBTENEMOS EL CORREO DEL USUARUIO
			$tablaUsuario = "users";
			$camposUsuario = ["email"];
			$condicionesUsuario = ["users_id" => $users_id];
			$orderBy = "";
			$resultadoUsuario = $database->consultarTabla($tablaUsuario, $camposUsuario, $condicionesUsuario, $orderBy);

			$correo_usuario = "";

			if (!empty($resultadoUsuario)) {
				$correo_usuario = trim($resultadoUsuario[0]['email']);
			}	

			$correo_tipo_id = "1";//Notificaciones
			$urlSistema = "https://izzycloud.app/";
			$destinatarios = array($correo_usuario => $colaborador_nombre);

			// Destinatarios en copia oculta (Bcc)
			$bccDestinatarios = [];

			$asunto = "¡Cambio de Contraseña Exitoso!";
			$mensaje = '
				<div style="padding: 20px;">
					<p style="margin-bottom: 10px;">
						¡Hola '.$colaborador_nombre.'!
					</p>
					
					<p style="margin-bottom: 10px;">
						Esperamos que te encuentres bien. Queremos informarte que se ha realizado con éxito el cambio de tu contraseña en nuestro sistema IZZY. Esta solicitud de cambio de contraseña fue iniciada por ti, por lo que no debes preocuparte.
					</p>								
					
					<p style="margin-bottom: 10px;">
						Si no realizaste esta acción personalmente, te sugerimos que inicies sesión primero. Posteriormente, te recomendamos cambiar tu contraseña por una que elijas en la sección de configuración de tu cuenta. Para acceder al Sistema IZZY, simplemente haz clic en el siguiente enlace:
					</p>					
					
					<p style="margin-bottom: 10px;">
						<a href='.$urlSistema.'>Clic para Acceder a IZZY<a>
					</p>
					
					<p style="margin-bottom: 10px;">
						La seguridad de tu cuenta es de suma importancia para nosotros. Si no reconoces esta acción o tienes alguna pregunta, por favor, contáctanos de inmediato. Estamos aquí para brindarte la ayuda que necesitas y asegurarnos de que tu experiencia sea segura y sin problemas.
					</p>
																			
					<p style="margin-bottom: 10px;">
						Agradecemos tu confianza en CLINICARE y esperamos seguir ofreciéndote un servicio excepcional.
					</p>
					
					<p style="margin-bottom: 10px;">
						Saludos cordiales,
					</p>
					
					<p>
						<b>El Equipo de CLINICARE</b>
					</p>                
				</div>
			';

			$archivos_adjuntos = [];
			$respuesta = $sendEmail->enviarCorreo($destinatarios, $bccDestinatarios, $asunto, $mensaje, $correo_tipo_id, $users_id, $archivos_adjuntos);
			
			return $respuesta;
		}

		public function resetear_contraseña_login_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$database = new Database();
			$sendEmail = new sendEmail();

			$respuesta = 0;
			$contraseña = cambiarContraseñaModelo::generar_pass_complejo();
			$contraseña_generada = $contraseña; 
			$usu_forgot = $_POST['usu_forgot'];
			
			$result_valid_user = cambiarContraseñaModelo::valid_user($usu_forgot);
			
			if($result_valid_user->num_rows>0){
				$consultaUsuario = $result_valid_user->fetch_assoc();
				$users_id = $consultaUsuario['users_id'];	

				$datos = [
					"correo" => $usu_forgot,
					"users_id" => $users_id,
					"contraseña" => mainModel::encryption($contraseña),			
				];		

				$query = cambiarContraseñaModelo::edit_contraseña_login_modelo($datos);
				
				//OBTENEMOS EL NOMBRE DEL COLABORADOR
				$respuesta = 0;
				$tablColaborador = "colaboradores";
				$camposColaborador = ["nombre", "apellido"];
				$condicionesColaborador = ["colaboradores_id" => $users_id];
				$orderBy = "";
				$resultadoColaborador = $database->consultarTabla($tablColaborador, $camposColaborador, $condicionesColaborador, $orderBy);

				$colaborador_nombre = "";

				if (!empty($resultadoColaborador)) {
					$colaborador_nombre = trim($resultadoColaborador[0]['nombre'].' '.$resultadoColaborador[0]['apellido']);
				}		

				//OBTENEMOS EL CORREO DEL USUARUIO
				$tablaUsuario = "users";
				$camposUsuario = ["email"];
				$condicionesUsuario = ["users_id" => $users_id];
				$orderBy = "";
				$resultadoUsuario = $database->consultarTabla($tablaUsuario, $camposUsuario, $condicionesUsuario, $orderBy);

				$correo_usuario = "";

				if (!empty($resultadoUsuario)) {
					$correo_usuario = trim($resultadoUsuario[0]['email']);
				}

				$correo_tipo_id = "1";//Notificaciones
				$urlSistema = "https://izzycloud.app/";
				$destinatarios = array($correo_usuario => $colaborador_nombre);

				// Destinatarios en copia oculta (Bcc)
				$bccDestinatarios = [];

				$asunto = "¡Cambio de Contraseña Exitoso!";
				$mensaje = '
					<div style="padding: 20px;">
						<p style="margin-bottom: 10px;">
							¡Hola '.$colaborador_nombre.'!
						</p>
						
						<p style="margin-bottom: 10px;">
							Esperamos que te encuentres bien. Queremos informarte que se ha realizado con éxito el cambio de tu contraseña en nuestro sistema IZZY. Esta solicitud de cambio de contraseña fue iniciada por ti, por lo que no debes preocuparte.
						</p>								
						
						<p style="margin-bottom: 10px;">
							Tu nueva contraseña temporal es: <b>'.$contraseña.'</b>
						</p>	

						<p style="margin-bottom: 10px;">
							Te recomendamos que inicies sesión usando esta contraseña temporal y luego cambies tu contraseña por una de tu elección en la sección de configuración de tu cuenta. Puedes acceder al Sistema IZZY haciendo clic en el siguiente enlace:
						</p>											
						
						<p style="margin-bottom: 10px;">
							<a href='.$urlSistema.'>Clic para Acceder a IZZY<a>
						</p>
						
						<p style="margin-bottom: 10px;">
							La seguridad de tu cuenta es de suma importancia para nosotros. Si no reconoces esta acción o tienes alguna pregunta, por favor, contáctanos de inmediato. Estamos aquí para brindarte la ayuda que necesitas y asegurarnos de que tu experiencia sea segura y sin problemas.
						</p>
																				
						<p style="margin-bottom: 10px;">
							Agradecemos tu confianza en CLINICARE y esperamos seguir ofreciéndote un servicio excepcional.
						</p>
						
						<p style="margin-bottom: 10px;">
							Saludos cordiales,
						</p>
						
						<p>
							<b>El Equipo de CLINICARE</b>
						</p>                
					</div>
				';

				$archivos_adjuntos = [];
				$respuesta = $sendEmail->enviarCorreo($destinatarios, $bccDestinatarios, $asunto, $mensaje, $correo_tipo_id, $users_id, $archivos_adjuntos);
			}else{
				$respuesta = 3;//USUARIO O CORREO NO EXISTEN	
			}
			
			return $respuesta;
		}			
	}
?>	