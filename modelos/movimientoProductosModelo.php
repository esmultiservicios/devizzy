<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class movimientoProductosModelo extends mainModel{			
		protected function agregar_movimiento_productos_modelo($datos){
			$movimientos_id = mainModel::correlativo("movimientos_id", "movimientos");
			
			$insert = "INSERT INTO `movimientos`(`movimientos_id`, `productos_id`, `documento`, `cantidad_entrada`, `cantidad_salida`, `saldo`, `empresa_id`, `fecha_registro`, `clientes_id`, `comentario`, `almacen_id`) VALUES('$movimientos_id','".$datos['productos_id']."','Movimiento de Productos $movimientos_id','".$datos['cantidad_entrada']."','".$datos['cantidad_salida']."','".$datos['saldo']."','".$datos['empresa']."','".$datos['fecha_registro']."','".$datos['clientes_id']."','".$datos['comentario']."','".$datos['almacen_id']."')";
			
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
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
?>