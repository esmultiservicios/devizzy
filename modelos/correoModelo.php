<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class correoModelo extends mainModel{		
		protected function edit_correo_modelo($datos){
			$update = "UPDATE correo
			SET 
				server = '".$datos['server']."',
				correo = '".$datos['correo']."',
				password = '".$datos['password']."',
				port = '".$datos['port']."',
				smtp_secure = '".$datos['smtp_secure']."'
			WHERE correo_id = '".$datos['correo_id']."'";

			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $sql;			
		}
	}