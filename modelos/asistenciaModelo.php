<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class asistenciaModelo  extends mainModel{
		protected function agregar_asistencia_modelo($datos){
			$asistencia_id = mainModel::correlativo("asistencia_id ", "asistencia");
			$insert = "INSERT INTO asistencia VALUES('$asistencia_id ','".$datos['colaborador']."','".$datos['fecha']."','".$datos['estado']."','".$datos['fecha_registro']."')";
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;
		}
		
		protected function valid_asistencia_modelo($datos){
			$query = "SELECT a.asistencia_id AS 'asistencia_id', a.fecha AS 'fecha', CONCAT(c.nombre, ' ', c.apellido) AS 'colaborador'
				FROM asistencia AS a
				INNER JOIN colaboradores AS c ON a.colaboradores_id = c.colaboradores_id
				WHERE a.colaboradores_id = '".$datos['colaborador']."' AND a.fecha = '".$datos['fecha']."'";
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;
		}
		
		protected function delete_asistencia_modelo($colaboradores_id){
			$delete = "DELETE FROM asistencia WHERE colaboradores_id = '$colaboradores_id' AND estado = 0";
		
			$sql = mainModel::connection()->query($delete) or die(mainModel::connection()->error);
			
			return $sql;			
		}
	}
?>	