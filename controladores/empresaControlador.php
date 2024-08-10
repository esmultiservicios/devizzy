<?php
    if($peticionAjax){
        require_once "../modelos/empresaModelo.php";
    }else{
        require_once "./modelos/empresaModelo.php";
    }
	
	class empresaControlador extends empresaModelo{
		public function agregar_empresa_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
		
			$razon_social = mainModel::cleanString($_POST['empresa_razon_social']);
			$empresa = mainModel::cleanString($_POST['empresa_empresa']);
		    $rtn = mainModel::cleanString($_POST['rtn_empresa']);
			$otra_informacion = mainModel::cleanString($_POST['empresa_otra_informacion']);
			$eslogan = mainModel::cleanString($_POST['empresa_eslogan']);			
			$correo = mainModel::cleanString($_POST['correo_empresa']);			
			$telefono = mainModel::cleanString($_POST['telefono_empresa']);
			$celular = mainModel::cleanString($_POST['empresa_celular']);
			$ubicacion = mainModel::cleanString($_POST['direccion_empresa']);
			$horario = mainModel::cleanString($_POST['horario_empresa']);
			$facebook = mainModel::cleanString($_POST['facebook_empresa']);
			$sitioweb = mainModel::cleanString($_POST['sitioweb_empresa']);

			$digits = 3;
			$valor = rand(pow(10, $digits-1), pow(10, $digits)-1);

			$imageFilename = "image_preview.png";

			if (isset($_FILES["logotipo"]["tmp_name"])) {
				if(!empty($_FILES["logotipo"]["tmp_name"])) {
					// Obtener información del archivo subido
					$imageFilename = basename($_FILES["logotipo"]["name"]);

					// Construir la ruta donde se guardará la imagen
					$imageFilename = "logo_".$valor.".png";
					$directorio_destino = "../vistas/plantilla/img/logos/";
					$imagePath = $directorio_destino.$imageFilename;

					while (file_exists($imagePath)){
						$valor = rand(pow(10, $digits-1), pow(10, $digits)-1);
						$imagePath = $directorio_destino.$imageFilename;
					}

					if (!file_exists($imagePath)) {
						move_uploaded_file($_FILES["logotipo"]["tmp_name"], $imagePath);
					} 
				}   
			} 		

			$imageFilenameFirma = "";

			if (isset($_FILES["firma_documento"]["tmp_name"])) {
				if(!empty($_FILES["firma_documento"]["tmp_name"])) {
					// Obtener información del archivo subido
					$imageFilenameFirma = basename($_FILES["firma_documento"]["name"]);

					// Construir la ruta donde se guardará la imagen
					$imageFilenameFirma = "firma_".$valor.".png";
					$directorio_destino = "../vistas/plantilla/img/logos/";
					$imagePath = $directorio_destino.$imageFilenameFirma;

					while (file_exists($imagePath)){
						$valor = rand(pow(10, $digits-1), pow(10, $digits)-1);
						$imagePath = $directorio_destino.$imageFilenameFirma;
					}

					if (!file_exists($imagePath)) {
						move_uploaded_file($_FILES["firma_documento"]["tmp_name"], $imagePath);
					} 
				}   
			} 							
			
			$usuario = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");	
			$estado = 1;	

			$datos = [
				"logotipo" => $imageFilename,
				"firma_documento" => $imageFilenameFirma,
				"razon_social" => $razon_social,
				"empresa" => $empresa,
				"rtn" => $rtn,				
				"otra_informacion" => $otra_informacion,
				"eslogan" => $eslogan,
				"correo" => $correo,			
				"telefono" => $telefono,				
				"celular" => $celular,				
				"ubicacion" => $ubicacion,
				"usuario" => $usuario,
				"estado" => $estado,
				"horario" => $horario,
				"facebook" => $facebook,
				"sitioweb" => $sitioweb,
				"fecha_registro" => $fecha_registro,			
				"MostrarFirma" => 1,
			];
			
			$resultEmpresa = empresaModelo::valid_empresa_modelo($rtn);
			
			if($resultEmpresa->num_rows==0){
				$query = empresaModelo::agregar_empresa_modelo($datos);
				
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formEmpresa",
						"id" => "proceso_empresa",
						"valor" => "Registro",	
						"funcion" => "listar_empresa();getImagenHeader();",
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
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Resgistro ya existe",
					"text" => "Lo sentimos este registro ya existe",
					"type" => "error",	
					"btn-class" => "btn-danger",						
				];					
			}
			
			return mainModel::sweetAlert($alert);			
		}
		
		public function edit_empresa_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$empresa_id = $_POST['empresa_id'];
			$razon_social = mainModel::cleanString($_POST['empresa_razon_social']);
			$empresa = mainModel::cleanString($_POST['empresa_empresa']);
		    $rtn = mainModel::cleanString($_POST['rtn_empresa']);
			$otra_informacion = mainModel::cleanString($_POST['empresa_otra_informacion']);
			$eslogan = mainModel::cleanString($_POST['empresa_eslogan']);			
			$correo = mainModel::cleanStringStrtolower($_POST['correo_empresa']);			
			$telefono = mainModel::cleanString($_POST['telefono_empresa']);
			$celular = mainModel::cleanString($_POST['empresa_celular']);
			$ubicacion = mainModel::cleanString($_POST['direccion_empresa']);
			$horario = mainModel::cleanString($_POST['horario_empresa']);
			$facebook = mainModel::cleanString($_POST['facebook_empresa']);
			$sitioweb = mainModel::cleanString($_POST['sitioweb_empresa']);			
			$usuario = $_SESSION['colaborador_id_sd'];
			$directorio_destino = "../vistas/plantilla/img/logos/";

			//OBTENEMOS EL NOMBRE DE LA IMAGEN DEL LOGO
			$getImagenEmpresa = empresaModelo::getImage($empresa_id)->fetch_assoc();
			$imageFilename = $getImagenEmpresa['logotipo'];
			$imagePath = $directorio_destino.$imageFilename;
							
			$digits = 3;
			$valor = rand(pow(10, $digits-1), pow(10, $digits)-1);
			$cargarLogo = false;

			if (isset($_FILES["logotipo"]["tmp_name"]) && $_FILES["logotipo"]["error"] == UPLOAD_ERR_OK) {
				$cargarLogo = true;
				if( $imageFilename != "image_preview.png"){
					if (file_exists($imagePath)) {
						// Eliminar la imagen anterior si existe
						unlink($imagePath);
					}
				}

				if(!empty($_FILES["logotipo"]["tmp_name"])) {
					// Obtener información del archivo subido
					$imageFilename = basename($_FILES["logotipo"]["name"]);

					// Construir la ruta donde se guardará la imagen
					$imageFilename = "logo_".$valor.".png";
					
					$imagePath = $directorio_destino.$imageFilename;					

					while (file_exists($imagePath)){
						$valor = rand(pow(10, $digits-1), pow(10, $digits)-1);
						$imagePath = $directorio_destino.$imageFilename;
					}

					if (!file_exists($imagePath)) {
						move_uploaded_file($_FILES["logotipo"]["tmp_name"], $imagePath);
					} 					
				}else{
					$imageFilename = "image_preview.png";
				}				   
			} 

			//OBTENEMOS EL NOMBRE DE LA IMAGEN DEL DOCUMENTO
			$getImagenEmpresafirma_documento = empresaModelo::getImage($empresa_id)->fetch_assoc();
			$imageFilenamefirma_documento = $getImagenEmpresafirma_documento['firma_documento'];
			$imagePathfirma_documento = $directorio_destino.$imageFilenamefirma_documento;					

			$digits = 3;
			$valor = rand(pow(10, $digits-1), pow(10, $digits)-1);

			$cargarFirma = false;
			if (isset($_FILES["firma_documento"]["tmp_name"]) && $_FILES["firma_documento"]["error"] == UPLOAD_ERR_OK) {
				$cargarFirma = true;

				if (file_exists($imagePathfirma_documento)) {
					// Eliminar la imagen anterior si existe
					unlink($imagePathfirma_documento);
				}

				if(!empty($_FILES["firma_documento"]["tmp_name"])) {
					// Obtener información del archivo subido
					$imageFilenamefirma_documento = basename($_FILES["firma_documento"]["name"]);

					// Construir la ruta donde se guardará la imagen
					$imageFilenamefirma_documento = "firma_".$valor.".png";
					
					$imagePathfirma_documento = $directorio_destino.$imageFilenamefirma_documento;					

					while (file_exists($imagePathfirma_documento)){
						$valor = rand(pow(10, $digits-1), pow(10, $digits)-1);
						$imagePathfirma_documento = $directorio_destino.$imageFilenamefirma_documento;
					}

					if (!file_exists($imagePathfirma_documento)) {
						move_uploaded_file($_FILES["firma_documento"]["tmp_name"], $imagePathfirma_documento);
					} 					
				}else{
					$imageFilenamefirma_documento = "";
				}				   
			} 

			if (isset($_POST['empresa_activo'])){
				$estado = $_POST['empresa_activo'];
			}else{
				$estado = 2;
			}			

			$datos = [
				"logotipo" => $imageFilename,
				"firma_documento" => $imageFilenamefirma_documento,
				"empresa_id" => $empresa_id,
				"razon_social" => $razon_social,
				"empresa" => $empresa,
				"rtn" => $rtn,				
				"otra_informacion" => $otra_informacion,
				"eslogan" => $eslogan,
				"correo" => $correo,			
				"telefono" => $telefono,				
				"celular" => $celular,				
				"ubicacion" => $ubicacion,
				"usuario" => $usuario,
				"horario" => $horario,
				"facebook" => $facebook,
				"sitioweb" => $sitioweb,				
				"estado" => $estado,
				"cargarLogo" => $cargarLogo,
				"cargarFirma" => $cargarFirma			
			];	

			$query = empresaModelo::edit_empresa_modelo($datos);
			
			if($query){	
				$alert = [
					"alert" => "edit",
					"title" => "Registro modificado",
					"text" => "El registro se ha modificado correctamente",
					"type" => "success",
					"btn-class" => "btn-primary",
					"btn-text" => "¡Bien Hecho!",
					"form" => "formEmpresa",	
					"id" => "proceso_empresa",
					"valor" => "Editar",
					"funcion" => "listar_empresa();getImagenHeader();",
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
		
		public function delete_empresa_controlador(){
			$empresa_id = $_POST['empresa_id'];
			
			$result_valid_empresa = empresaModelo::valid_user_secuencia_user($empresa_id);
			
			if($result_valid_empresa->num_rows==0){
				$getImagenEmpresa = empresaModelo::getImage($empresa_id)->fetch_assoc();
				$imageFilename = $getImagenEmpresa['logotipo'];
				$directorio_destino = "../vistas/plantilla/img/logos/";
				$imagePath = $directorio_destino.$imageFilename;

				if( $imageFilename != "image_preview.png"){
					if (file_exists($imagePath)) {
						// Eliminar la imagen anterior si existe
						unlink($imagePath);
					}
				}
											
				$query = empresaModelo::delete_empresa_modelo($empresa_id);
								
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro eliminado",
						"text" => "El registro se ha eliminado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formEmpresa",	
						"id" => "proceso_empresa",
						"valor" => "Eliminar",
						"funcion" => "listar_empresa();",
						"modal" => "modal_registrar_empresa",
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