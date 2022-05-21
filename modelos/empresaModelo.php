<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class empresaModelo extends mainModel{
		protected function agregar_empresa_modelo($datos){
			$empresa_id = mainModel::correlativo("empresa_id", "empresa");
			$insert = "INSERT INTO empresa 
				VALUES ('$empresa_id','".$datos['razon_social']."','".$datos['empresa']."','".$datos['otra_informacion']."','".$datos['eslogan']."','".$datos['celular']."','".$datos['telefono']."','".$datos['correo']."','".$datos['rtn']."','".$datos['ubicacion']."','".$datos['facebook']."','".$datos['sitioweb']."','".$datos['horario']."','".$datos['estado']."','".$datos['usuario']."','".$datos['fecha_registro']."')";
			
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function valid_empresa_modelo($rtn){
			$query = "SELECT empresa_id FROM empresa WHERE rtn = '$rtn'";
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;
		}
		
		protected function edit_empresa_modelo($datos){
			$update = "UPDATE empresa
			SET
				razon_social = '".$datos['razon_social']."',
				nombre = '".$datos['empresa']."',
				otra_informacion = '".$datos['otra_informacion']."',
				eslogan = '".$datos['eslogan']."',				
				celular = '".$datos['celular']."',
				telefono = '".$datos['telefono']."',
				correo = '".$datos['correo']."',
				rtn = '".$datos['rtn']."',
				ubicacion = '".$datos['ubicacion']."',
				estado = '".$datos['estado']."',
				facebook = '".$datos['facebook']."',
				sitioweb = '".$datos['sitioweb']."',
				horario = '".$datos['horario']."'					
			WHERE empresa_id = '".$datos['empresa_id']."'";
			
			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function delete_empresa_modelo($empresa_id){
			$delete = "DELETE FROM empresa WHERE empresa_id = '$empresa_id'";
			
			$sql = mainModel::connection()->query($delete) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function valid_user_secuencia_user($empresa_id){
			$query = "SELECT empresa_id FROM users WHERE empresa_id = '$empresa_id'";
			
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;			
		}
	}