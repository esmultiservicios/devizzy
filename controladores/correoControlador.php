<?php
    if($peticionAjax){
        require_once "../modelos/correoModelo.php";
    }else{
        require_once "./modelos/correoModelo.php";
    }
	
	class correoControlador extends correoModelo{
		public function edit_correo_controlador(){
			$correo_id = $_POST['correo_id'];
			$puserverConfEmailsto = mainModel::cleanString($_POST['serverConfEmail']);
			$correoConfEmail = mainModel::cleanString($_POST['correoConfEmail']);
			$passConfEmail = mainModel::encryption(mainModel::cleanString($_POST['passConfEmail']));
			$puertoConfEmail = mainModel::cleanString($_POST['puertoConfEmail']);
			$smtpSecureConfEmail = mainModel::cleanString($_POST['smtpSecureConfEmail']);
		
			$datos = [
				"correo_id" => $correo_id,
				"server" => $puserverConfEmailsto,
				"correo" => $correoConfEmail,
				"password" => $passConfEmail,
				"port" => $puertoConfEmail,
				"smtp_secure" => $smtpSecureConfEmail,				
			];		

			$query = correoModelo::edit_correo_modelo($datos);
			
			if($query){				
				$alert = [
					"alert" => "edit",
					"title" => "Registro modificado",
					"text" => "El registro se ha modificado correctamente",
					"type" => "success",
					"btn-class" => "btn-primary",
					"btn-text" => "¡Bien Hecho!",
					"form" => "formConfEmails",	
					"id" => "pro_correos",
					"valor" => "Editar",
					"funcion" => "listar_correos_configuracion();getSMTPSecure();getTipoCorreo();",
					"modal" => "",
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
	}
?>	