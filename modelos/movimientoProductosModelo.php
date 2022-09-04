<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class movimientoProductosModelo extends mainModel{
		protected function agregar_movimiento_productos_modelo($datos){
			$movimientos_id = mainModel::correlativo("movimientos_id", "movimientos");
			$documento = "Entrada Movimientos ".$movimientos_id;
			$insert = "INSERT INTO movimientos 
				VALUES('$movimientos_id','".$datos['productos_id']."','$documento','".$datos['cantidad_entrada']."',
				'".$datos['cantidad_salida']."','".$datos['saldo']."','".$datos['empresa']."','".$datos['fecha_registro']."',
				'".$datos['cliente']."','".$datos['comentario']."'
				)";

			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function actualizar_cantidad_productos_modelo($productos_id, $cantidad){
			$update = "UPDATE productos
				SET
					cantidad = '$cantidad'
				WHERE productos_id = '$productos_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
		
			return $result;				
		}
		
		protected function cantidad_producto_modelo($productos_id){
			$result = mainModel::getCantidadProductos($productos_id);
			
			return $result;			
		}

		protected function saldo_productos_movimientos_modelo($productos_id){
			$result = mainModel::getSaldoProductosMovimientos($productos_id);
			
			return $result;			
		}		
	}