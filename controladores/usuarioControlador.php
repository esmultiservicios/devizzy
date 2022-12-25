<?php
    if($peticionAjax){
        require_once "../modelos/usuarioModelo.php";
    }else{
        require_once "./modelos/usuarioModelo.php";
    }

    class usuarioControlador extends usuarioModelo{
		public function agregar_usuario_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$colaborador_id = mainModel::cleanString($_POST['colaborador_id_usuario']);
			$colaborador = mainModel::cleanString($_POST['colaborador_id_usuario']);
			$privilegio_id = mainModel::cleanString($_POST['privilegio_id']);			
			$nickname = mainModel::cleanString($_POST['nickname']);	
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
							$result_empresa = usuarioModelo::get_empresa_factura_correo_usuarios_modelo($usuario_sistema);	
	
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
							$result_correo = usuarioModelo::get_email_usuarios_modelo($tipo_correo);
						
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
	
							$from = "Creación de Usuario";	   
							$asunto = "Creación de Usuario\n";
							$para = $correo_usuario;
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
								<td colspan='2'><center><b><h4>Creación de Usuario</h4></b></center></td>
								</tr>
								<tr>
								<td>
									<p style='text-align: justify'>Estimado(a) <b>".$colaborador."</b>, Le damos la mas cordial bienvenida al sistema, Le notificamos lo siguiente.
									<br/>Se ha creado su nuevo usuario de acceso el cual es <b>".$nickname."</b> y la contraseña asignada es: <b>".$pass."</b> se requiere que la cambie a la brevedad posible.
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
								<td>
									<td colspan='2'><center><img width='25%' heigh='20%' src='".$url_footer."'></center></td>
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
	
							usuarioModelo::send_email_usuarios_modelo($datos_correo);
	
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