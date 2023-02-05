<?php
    if($peticionAjax){
        require_once "../modelos/asistenciaModelo.php";
    }else{
        require_once "./modelos/asistenciaModelo.php";
    }
	
	class asistenciaControlador extends asistenciaModelo {
		public function agregar_asistencia_controlador(){
			$colaborador = $_POST['asistencia_empleado'];
			$fecha = $_POST['fecha'];
			$hora = $_POST['hora'];
			$estado = 0;
			$fecha_registro = date("Y-m-d H:i:s");	
			
			$datos = [
				"colaborador" => $colaborador,
				"fecha" => $fecha,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,				
			];
			
			$resultVarios = asistenciaModelo ::valid_asistencia_modelo($datos);
			
			if($resultVarios->num_rows==0){
				$query = asistenciaModelo ::agregar_asistencia_modelo($datos);
				
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formAsistencia",
						"id" => "proceso_asistencia",
						"valor" => "Registro",
						"funcion" => "listar_asistencia();getColaboradores();",
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
		
		public function delete_privilegio_controlador(){
			$privilegio_id = $_POST['privilegio_id_'];
			
			$resultVarios = asistenciaModelo ::valid_privilegio_usuarios($privilegio_id);
			
			if($resultVarios->num_rows==0 ){
				$query = asistenciaModelo ::delete_asistencia_modelo($privilegio_id);
								
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro eliminado",
						"text" => "El registro se ha eliminado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formPrivilegios",	
						"id" => "proceso_privilegios",
						"valor" => "Eliminar",
						"funcion" => "listar_privilegio();",
						"modal" => "modal_registrar_privilegios",
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