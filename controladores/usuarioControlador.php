<?php
    if($peticionAjax){
        require_once "../modelos/usuarioModelo.php";
		require_once "../core/Database.php";
		require_once "../core/sendEmail.php";
    }else{
        require_once "./modelos/usuarioModelo.php";
		require_once "../core/Database.php";
		require_once "./core/sendEmail.php";
    }

    class usuarioControlador extends usuarioModelo{
		public function agregar_usuario_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$database = new Database();
			$sendEmail = new sendEmail();
			
			$colaborador_id = mainModel::cleanString($_POST['colaborador_id_usuario']);
			$colaborador = mainModel::cleanString($_POST['colaborador_id_usuario']);
			$privilegio_id = mainModel::cleanString($_POST['privilegio_id']);			
			$nickname = "";	
			$pass = mainModel::generar_password_complejo();
			$contraseña_generada =  mainModel::encryption($pass);	
			$correo_usuario = mainModel::cleanStringStrtolower($_POST['correo_usuario']);
			$empresa = mainModel::cleanString($_POST['empresa_usuario']);
			$tipo_user = mainModel::cleanString($_POST['tipo_user']);			
			$fecha_registro = date("Y-m-d H:i:s");
			$usuario_sistema = $_SESSION['colaborador_id_sd'];	
			$estado = 1;		
			
			$datos = [
				"colaborador_id" => $colaborador_id,
				"privilegio_id" => $privilegio_id,				
				"nickname" => $nickname,
				"pass" => $contraseña_generada,				
				"correo" => $correo_usuario,				
				"empresa" => $empresa,
				"tipo_user" => $tipo_user,				
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,				
			];
			
			//VALIDAMOS QUE EL CORREO NO SE ESTE DUPLICANDO
			$result_correo_usuario = usuarioModelo::valid_correo_modelo($correo_usuario);

			if($result_correo_usuario->num_rows==0){
				$result_usuario = usuarioModelo::valid_user_modelo($colaborador_id);
				$cantidad_usuario_sistema = usuarioModelo::getTotalUsuarios()->fetch_assoc();
				$total_usuarios_sistema = $cantidad_usuario_sistema['total_usuarios'];
	
				$cantidad_usuario_plan = usuarioModelo::cantidad_usuarios_modelo()->fetch_assoc();
				$total_usuarios_plan = $cantidad_usuario_plan['users'] + $cantidad_usuario_plan['user_extra'];
	
				//SI EL LIMITE DEL PLAN SE ESTABLECE EN CERO, ESTE PERMITIRA AGREGAR MAS USUARIOS SIN NINGUN LIMITE
				if($cantidad_usuario_plan['users'] == 0){
					$total_usuarios_plan = $total_usuarios_sistema + 1;
				}
				
				if($total_usuarios_sistema < $total_usuarios_plan){
					if($result_usuario->num_rows==0){
						$query = usuarioModelo::agregar_usuario_modelo($datos);
						
						if($query){
							//ENVIAMOS EL CORREO ELECTRONICO AL USUARIO
							//OBTENEMOS EL NOMBRE DEL COLABORADOR
							$tablColaborador = "colaboradores";
							$camposColaborador = ["nombre", "apellido"];
							$condicionesColaborador = ["colaboradores_id" => $usuario_sistema];
							$orderBy = "";
							$resultadoColaborador = $database->consultarTabla($tablColaborador, $camposColaborador, $condicionesColaborador, $orderBy);
				
							$colaborador_nombre = "";

							if (!empty($resultadoColaborador)) {
								$colaborador_nombre = trim($resultadoColaborador[0]['nombre'].' '.$resultadoColaborador[0]['apellido']);
							}		
							
							//OBTENEMOS EL NOMBRE DEL PERFIL
							$tablaPrivilegio = "privilegio";
							$camposPrivilegio = ["nombre"];
							$condicionesPrivilegio = ["privilegio_id" => $privilegio_id];
							$orderBy = "";
							$resultadoPrivilegio = $database->consultarTabla($tablaPrivilegio, $camposPrivilegio, $condicionesPrivilegio, $orderBy);
				
							$privilegio_nombre = "";

							if (!empty($resultadoPrivilegio)) {
								$privilegio_nombre = trim($resultadoPrivilegio[0]['nombre']);
							}								

							$correo_tipo_id = "1";//Notificaciones
							$urlSistema = "https://izzycloud.app/";
							$destinatarios = array($correo_usuario => $colaborador_nombre);
							$asunto = "¡Bienvenido! Registro de Usuario Exitoso";
							$mensaje = '
								<div style="padding: 20px;">
									<p style="margin-bottom: 10px;">
										¡Hola '.$colaborador_nombre.'!
									</p>
									
									<p style="margin-bottom: 10px;">
										¡Bienvenido a CLINICARE con IZZY! Estamos encantados de darte la bienvenida a nuestra plataforma de gestión de facturación e inventario diseñada para hacer tu vida más fácil.
									</p>								
									
									<p style="margin-bottom: 10px;">
										Te damos las gracias por elegirnos como tu solución de confianza para administrar tu negocio de manera eficiente. Tu registro en nuestro sistema ha sido exitoso y ahora eres parte de la familia CLINICARE.
									</p>
									
									<ul style="margin-bottom: 12px;">
										<li><b>Usuario</b>: '.$correo_usuario.'</li>
										<li><b>Contraseña</b>: '.$pass.'</li>
										<li><b>Perfil</b>: '.$privilegio_nombre.'</li>
										<li><b>Acceso al Sistema</b>: '.$urlSistema.'</li>
									</ul>
									
									<p style="margin-bottom: 10px;">
										Recuerda que la seguridad es una prioridad para nosotros. Por ello, te recomendamos cambiar tu contraseña temporal en tu primera sesión.
									</p>
									
									<p style="margin-bottom: 10px;">
										Si tienes alguna pregunta o necesitas ayuda en cualquier momento, no dudes en ponerte en contacto con nuestro dedicado equipo de soporte. Estamos aquí para proporcionarte la asistencia que necesitas.
									</p>
									
									<p style="margin-bottom: 10px;">
										Te invitamos a explorar todas las características y funcionalidades que IZZY ofrece para simplificar la gestión de tu negocio. Tu éxito es nuestro objetivo y estamos comprometidos a ayudarte en cada paso del camino.
									</p>
									
									<p style="margin-bottom: 10px;">
										Gracias por unirte a CLINICARE con IZZY. Esperamos que esta plataforma sea una herramienta valiosa para tu negocio.
									</p>
									
									<p style="margin-bottom: 10px;">
										Saludos cordiales,
									</p>
									
									<p>
										<b>El Equipo de  CLINICARE</b>
									</p>                
								</div>
							';

							$sendEmail->enviarCorreo($destinatarios, $asunto, $mensaje, $correo_tipo_id);

	
							$alert = [
								"alert" => "clear",
								"title" => "Registro almacenado",
								"text" => "El registro se ha almacenado correctamente",
								"type" => "success",
								"btn-class" => "btn-primary",
								"btn-text" => "¡Bien Hecho!",
								"form" => "formUsers",
								"id" => "proceso_usuarios",
								"valor" => "Registro",
								"funcion" => "listar_usuarios();getTipoUsuario();getPrivilegio();getEmpresaUsers();getColaboradoresUsuario();",
								"modal" => ""
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
					}else{
						$alert = [
							"alert" => "simple",
							"title" => "Resgistro ya existe",
							"text" => "Lo sentimos este registro ya existe",
							"type" => "error",	
							"btn-class" => "btn-danger",						
						];				
					}
				}else{
					$alert = [
						"alert" => "simple",
						"title" => "Límite de usuarios excedido",
						"text" => "Lo sentimos, ha excedido el límite de usuarios según su plan",
						"type" => "error",	
						"btn-class" => "btn-danger",						
					];			
				}
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Correo duplicado",
					"text" => "Lo sentimos este correo ya ha sido registrado, por favor corregir",
					"type" => "error",	
					"btn-class" => "btn-danger",						
				];				
			}
			
			return mainModel::sweetAlert($alert);
		}
		
		public function edit_user_controlador(){
			$usuarios_id = $_POST['usuarios_id'];
		
			$correo = mainModel::cleanStringStrtolower($_POST['correo_usuario']);
			$tipo_user = mainModel::cleanString($_POST['tipo_user']);
			$privilegio_id = mainModel::cleanString($_POST['privilegio_id']);			

			if (isset($_POST['usuarios_activo'])){
				$estado = $_POST['usuarios_activo'];
			}else{
				$estado = 2;
			}	
			
			$datos = [
				"usuarios_id" => $usuarios_id,				
				"correo" => $correo,				
				"tipo_user" => $tipo_user,	
				"privilegio_id" => $privilegio_id,					
				"estado" => $estado,				
			];
			
			$query = usuarioModelo::edit_user_modelo($datos);
			
			if($query){				
				$alert = [
					"alert" => "edit",
					"title" => "Registro modificado",
					"text" => "El registro se ha modificado correctamente",
					"type" => "success",
					"btn-class" => "btn-primary",
					"btn-text" => "¡Bien Hecho!",
					"form" => "formUsers",	
					"id" => "proceso_usuarios",
					"valor" => "Editar",
					"funcion" => "listar_usuarios();getTipoUsuario();getPrivilegio();getEmpresaUsers();getColaboradoresUsuario();",
					"modal" => ""
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
		
		public function delete_user_controlador(){
			$usuarios_id = $_POST['usuarios_id'];
			
			$result_valid_usuarios = usuarioModelo::valid_user_bitacora($usuarios_id);
			
			if($result_valid_usuarios->num_rows==0){
				$query = usuarioModelo::delete_user_modelo($usuarios_id);
								
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro eliminado",
						"text" => "El registro se ha eliminado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formUsers",	
						"id" => "proceso_usuarios",
						"valor" => "Eliminar",
						"funcion" => "listar_usuarios();getTipoUsuario();getPrivilegio();getEmpresaUsers();getColaboradoresUsuario();",
						"modal" => "modal_registrar_usuarios"
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
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Este registro cuenta con información almacenada",
					"text" => "No se puede eliminar este registro",
					"type" => "error",	
					"btn-class" => "btn-danger",						
				];				
			}
			
			return mainModel::sweetAlert($alert);
		}
    }
?>	