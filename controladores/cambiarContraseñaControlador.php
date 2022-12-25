<?php
    if($peticionAjax){
        require_once "../modelos/cambiarContraseñaModelo.php";
    }else{
        require_once "./modelos/cambiarContraseñaModelo.php";
    }
	
	class cambiarContraseñaControlador extends cambiarContraseñaModelo{		
		public function edit_contraseña_controlador(){
			$contraseña = mainModel::encryption($_POST['nuevacontra']);

			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$users_id = $_SESSION['users_id_sd'];

			$datos = [
				"users_id" => $users_id,
				"contraseña" => $contraseña,				
			];		

			$query = cambiarContraseñaModelo::edit_contraseña_modelo($datos);
			
			if($query){	
				//ENVIAMOS EL CORREO ELECTRONICO AL USUARIO
				$result_empresa = cambiarContraseñaModelo::get_empresa_factura_correo_usuarios_modelo($users_id);	

				$telefono = '';
				$celular = '';
				$telefono = '';
				$horario = '';
				$eslogan = '';
				$facebook = '';
				$sitioweb = '';	
				$correo = '';
			
				if($result_empresa->num_rows>=0){
					$consulta_empresa = $result_empresa->fetch_assoc();
					$telefono = $consulta_empresa['telefono'];
					$celular = $consulta_empresa['celular'];
					$correo = $consulta_empresa['correo'];   
					$horario = $consulta_empresa['horario'];
					$eslogan = $consulta_empresa['eslogan'];
					$facebook = $consulta_empresa['facebook'];
					$sitioweb = $consulta_empresa['sitioweb'];				
				}

				$tipo_correo = "Notificaciones";
				$result_correo = cambiarContraseñaModelo::get_email_usuarios_modelo($tipo_correo);
			
				$de = "";
				$contraseña = "";
				$server = "";
				$port = "";
				$smtp_secure = "";
			
				if($result_correo->num_rows>=0){
					$consulta_correo = $result_correo->fetch_assoc();
					$de = $consulta_correo['correo'];
					$contraseña = mainModel::decryption($consulta_correo['password']);
					$server = $consulta_correo['server'];   
					$port = $consulta_correo['port'];
					$smtp_secure = $consulta_correo['smtp_secure'];		
				}

				$from = "Cambio de Contraseña";
				$asunto = "Cambio de Contraseña\n";
				$consulta_correo_usuario = cambiarContraseñaModelo::getCorreoUsuario($users_id)->fetch_assoc();	
				$para = $consulta_correo_usuario['email'];
				$colaborador = $consulta_correo_usuario['usuario'];
				$URL = "";
				$url_logo = SERVERURL."vistas/plantilla/img/logo.png";
				$url_sistema = SERVERURL;
				$url_footer = SERVERURL."vistas/plantilla/img/logo.png";
				$url_facebook = $facebook;
				$url_sitio_web = $sitioweb;

				$mensaje="
				<table class='table table-striped table-responsive-md btn-table'>
				   <tr>
					<td colspan='2'><center><img width='25%' heigh='20%' src='".$url_logo."'></center></td>
				   </tr>
				   <tr>
					  <td colspan='2'><center><b><h4>Cambio de Contraseña</h4></b></center></td>
				   </tr>
				   <tr>
					  <td>
						 <p style='text-align: justify'>
						   Estimado(a) <b>".$colaborador."</b>, se le notifica que se ha cambiado su contraseña.
						   </b>Esta solicitud fue realizada por su persona. Si desconoce esta acción por favor cambie su contraseña en la página de inicio de sesión
						  <a href='".$url_sistema."'>Presione este enlace para acceder al Sistema FAYAD</a>
						 </p>
					  </td>
					</tr>
					<tr>
					   <td>
						   <p style='text-align: justify; font-size:12px;'>
							  <b>
								  Este correo fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje..
							  </b>
						   </p>
						</td>
					</tr>
					 <tr>
						<td colspan='2'>
						   <p><img width='25%' heigh='20%' src='".$url_footer."'></p>
						</td>
					 </tr> 
				  </table>
			  	";						

				$datos_correo = [
					"servidor" => $server,
					"puerto" => $port,				
					"contraseña" => $contraseña,
					"CharSet" => "UTF-8",				
					"SMTPSecure" => $smtp_secure,				
					"de" => $de,
					"para" => $para,				
					"from" => $from,
					"asunto" => $asunto,
					"mensaje" => $mensaje,				
					"URL" => $URL											
				];

				cambiarContraseñaModelo::send_email_usuarios_modelo($datos_correo);

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

			$respuesta = 0;
			$contraseña = cambiarContraseñaModelo::generar_pass_complejo();
			$contraseña_generada = $contraseña; 
			$users_id = $_POST['users_id'];

			$datos = [
				"users_id" => $users_id,
				"contraseña" => mainModel::encryption($contraseña),			
			];		

			$query = cambiarContraseñaModelo::edit_contraseña_modelo($datos);
			
			if($query){	
				//ENVIAMOS EL CORREO ELECTRONICO AL USUARIO
				$result_empresa = cambiarContraseñaModelo::get_empresa_factura_correo_usuarios_modelo($users_id);	

				$telefono = '';
				$celular = '';
				$telefono = '';
				$horario = '';
				$eslogan = '';
				$facebook = '';
				$sitioweb = '';	
				$correo = '';
			
				if($result_empresa->num_rows>=0){
					$consulta_empresa = $result_empresa->fetch_assoc();
					$telefono = $consulta_empresa['telefono'];
					$celular = $consulta_empresa['celular'];
					$correo = $consulta_empresa['correo'];   
					$horario = $consulta_empresa['horario'];
					$eslogan = $consulta_empresa['eslogan'];
					$facebook = $consulta_empresa['facebook'];
					$sitioweb = $consulta_empresa['sitioweb'];				
				}

				$tipo_correo = "Notificaciones";
				$result_correo = cambiarContraseñaModelo::get_email_usuarios_modelo($tipo_correo);
			
				$de = "";
				$contraseña = "";
				$server = "";
				$port = "";
				$smtp_secure = "";
			
				if($result_correo->num_rows>=0){
					$consulta_correo = $result_correo->fetch_assoc();
					$de = $consulta_correo['correo'];
					$contraseña = mainModel::decryption($consulta_correo['password']);
					$server = $consulta_correo['server'];   
					$port = $consulta_correo['port'];
					$smtp_secure = $consulta_correo['smtp_secure'];		
				}

				$from = "Cambio de Contraseña";
				$asunto = "Cambio de Contraseña\n";
				$consulta_correo_usuario = cambiarContraseñaModelo::getCorreoUsuario($users_id)->fetch_assoc();	
				$para = $consulta_correo_usuario['email'];
				$colaborador = $consulta_correo_usuario['usuario'];
				$URL = "";
				$url_logo = SERVERURL."img/logo.png";
				$url_sistema = SERVERURL;
				$url_footer = "";
				$url_facebook = $facebook;
				$url_sitio_web = $sitioweb;

				$mensaje="
			    <table class='table table-striped table-responsive-md btn-table'>
					<tr>
					<td colspan='2'><center><img width='25%' heigh='20%' src='".$url_logo."'></center></td>
					</tr>
					<tr>
					<td colspan='2'><center><b><h4>Notificación Cambio de Contraseña</h4></b></center></td>
					</tr>
					<tr>
					<td>
						<p style='text-align: justify'>Estimado(a) <b>$colaborador</b>, se le notifica que se ha cambiado su contraseña.
						<br/>Su nueva contraseña es: <b>$contraseña_generada</b> se requiere que la cambie a la brevedad posible.
						<a href='".$url_sistema."'>Presione este enlace para acceder al Sistema FAYAD</a>
						</p>
					</td>
					</tr>
					<tr>
					<td>
						<p style='text-align: justify; font-size:12px;'><b>
						Este mensaje ha sido enviado de forma automática, por favor no responder este correo. Cualquier duda o consulta envié un correo electrónico a: gestionsistemas@hsjddhn.com, o puede marcar  a nuestra PBX: 2512-0870 Ext. 116.<br/>Haciendo el bien a los demás nos hacemos el bien a nosotros mismos.
						</b></p>
					</td>
					</tr>
					<tr>
					<td>
						<p><img width='25%' heigh='20%' src='".$url_footer."'></p>
					</td>			  
				 </tr>   
				 </table>
				";						

				$datos_correo = [
					"servidor" => $server,
					"puerto" => $port,				
					"contraseña" => $contraseña,
					"CharSet" => "UTF-8",				
					"SMTPSecure" => $smtp_secure,				
					"de" => $de,
					"para" => $para,				
					"from" => $from,
					"asunto" => $asunto,
					"mensaje" => $mensaje,				
					"URL" => $URL											
				];

				cambiarContraseñaModelo::send_email_usuarios_modelo($datos_correo);

				$respuesta = 1;
			}else{
				$respuesta = 2;				
			}			
			
			return $respuesta;
		}	

		public function resetear_contraseña_login_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$respuesta = 0;
			$contraseña = cambiarContraseñaModelo::generar_pass_complejo();
			$contraseña_generada = $contraseña; 
			$usu_forgot = $_POST['usu_forgot'];

			$datos = [
				"users_id" => $usu_forgot,
				"contraseña" => mainModel::encryption($contraseña),			
			];		

			$result_valid_user = cambiarContraseñaModelo::valid_user($usu_forgot);
			
			if($result_valid_user->num_rows>0){
				$consultaUsuario = $result_valid_user->fetch_assoc();
				$users_id = $consultaUsuario['users_id'];				
				$query = cambiarContraseñaModelo::edit_contraseña_login_modelo($datos);
				
				if($query){	
					//ENVIAMOS EL CORREO ELECTRONICO AL USUARIO
					$result_empresa = cambiarContraseñaModelo::get_empresa_factura_correo_usuarios_modelo($users_id);	

					$telefono = '';
					$celular = '';
					$telefono = '';
					$horario = '';
					$eslogan = '';
					$facebook = '';
					$sitioweb = '';	
					$correo = '';
				
					if($result_empresa->num_rows>=0){
						$consulta_empresa = $result_empresa->fetch_assoc();
						$telefono = $consulta_empresa['telefono'];
						$celular = $consulta_empresa['celular'];
						$correo = $consulta_empresa['correo'];   
						$horario = $consulta_empresa['horario'];
						$eslogan = $consulta_empresa['eslogan'];
						$facebook = $consulta_empresa['facebook'];
						$sitioweb = $consulta_empresa['sitioweb'];				
					}

					$tipo_correo = "Notificaciones";
					$result_correo = cambiarContraseñaModelo::get_email_usuarios_modelo($tipo_correo);
				
					$de = "";
					$contraseña = "";
					$server = "";
					$port = "";
					$smtp_secure = "";
				
					if($result_correo->num_rows>=0){
						$consulta_correo = $result_correo->fetch_assoc();
						$de = $consulta_correo['correo'];
						$contraseña = mainModel::decryption($consulta_correo['password']);
						$server = $consulta_correo['server'];   
						$port = $consulta_correo['port'];
						$smtp_secure = $consulta_correo['smtp_secure'];		
					}

					$from = "Cambio de Contraseña";
					$asunto = "Cambio de Contraseña\n";
					$consulta_correo_usuario = cambiarContraseñaModelo::getCorreoUsuario($users_id)->fetch_assoc();	
					$para = $consulta_correo_usuario['email'];
					$colaborador = $consulta_correo_usuario['usuario'];
					$URL = "";
					$url_logo = SERVERURL."img/logo.png";
					$url_sistema = SERVERURL;
					$url_footer = "";
					$url_facebook = $facebook;
					$url_sitio_web = $sitioweb;

					$mensaje="
					<table class='table table-striped table-responsive-md btn-table'>
						<tr>
						<td colspan='2'><center><img width='25%' heigh='20%' src='".$url_logo."'></center></td>
						</tr>
						<tr>
						<td colspan='2'><center><b><h4>Notificación Cambio de Contraseña</h4></b></center></td>
						</tr>
						<tr>
						<td>
							<p style='text-align: justify'>Estimado(a) <b>$colaborador</b>, se le notifica que se ha cambiado su contraseña.
							<br/>Su nueva contraseña es: <b>$contraseña_generada</b> se requiere que la cambie a la brevedad posible.
							<a href='".$url_sistema."'>Presione este enlace para acceder al Sistema FAYAD</a>
							</p>
						</td>
						</tr>
						<tr>
						<td>
							<p style='text-align: justify; font-size:12px;'><b>
							Este mensaje ha sido enviado de forma automática, por favor no responder este correo. Cualquier duda o consulta envié un correo electrónico a: gestionsistemas@hsjddhn.com, o puede marcar  a nuestra PBX: 2512-0870 Ext. 116.<br/>Haciendo el bien a los demás nos hacemos el bien a nosotros mismos.
							</b></p>
						</td>
						</tr>
						<tr>
						<td>
							<p><img width='25%' heigh='20%' src='".$url_footer."'></p>
						</td>			  
					 </tr>   
					 </table>
					";						

					$datos_correo = [
						"servidor" => $server,
						"puerto" => $port,				
						"contraseña" => $contraseña,
						"CharSet" => "UTF-8",				
						"SMTPSecure" => $smtp_secure,				
						"de" => $de,
						"para" => $para,				
						"from" => $from,
						"asunto" => $asunto,
						"mensaje" => $mensaje,				
						"URL" => $URL											
					];

					cambiarContraseñaModelo::send_email_usuarios_modelo($datos_correo);

					$respuesta = 1;
				}else{
					$respuesta = 2;				
				}				
			}else{
				$respuesta = 3;//USUARIO O CORREO NO EXISTEN	
			}
			
			return $respuesta;
		}			
	}
?>	