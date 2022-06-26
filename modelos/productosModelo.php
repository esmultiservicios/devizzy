<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class productosModelo extends mainModel{
		protected function agregar_productos_modelo($datos){
			$productos_id = mainModel::correlativo("productos_id", "productos");
			$insert = "INSERT INTO productos VALUES('$productos_id','".$datos['bar_code_product']."','".$datos['almacen_id']."','".$datos['medida_id']."','".$datos['categoria_id']."','".$datos['nombre']."','".$datos['descripcion']."','".$datos['tipo_producto']."','".$datos['cantidad']."','".$datos['precio_compra']."','".$datos['porcentaje_venta']."','".$datos['precio_venta']."','".$datos['cantidad_mayoreo']."','".$datos['precio_mayoreo']."','".$datos['cantidad_minima']."','".$datos['cantidad_maxima']."','".$datos['estado']."','".$datos['isv_venta']."','".$datos['isv_compra']."','".$datos['colaborador_id']."','".$datos['file']."','".$datos['empresa']."','".$datos['fecha_registro']."')";
			
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function agregar_movimientos_productos_modelo($datos){
			$movimientos_id = mainModel::correlativo("movimientos_id", "movimientos");
			$documento = "entrada productos ".$movimientos_id;
			$insert = "INSERT INTO movimientos 
				VALUES('$movimientos_id','".$datos['productos_id']."','$documento','".$datos['cantidad_entrada']."','".$datos['cantidad_salida']."','".$datos['saldo']."','".$datos['empresa']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;			
		}
		
		protected function valid_productos_modelo($nombre){
			$query = "SELECT productos_id FROM productos WHERE nombre = '$nombre'";

			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;
		}	

		protected function edit_productos_modelo($datos){
			$update = "UPDATE productos
			SET
				nombre = '".$datos['nombre']."',
				descripcion = '".$datos['descripcion']."',
				precio_compra = '".$datos['precio_compra']."',
				porcentaje_venta = '".$datos['porcentaje_venta']."',
				precio_venta = '".$datos['precio_venta']."',
				precio_mayoreo = '".$datos['precio_mayoreo']."',
				estado = '".$datos['estado']."',
				isv_venta = '".$datos['isv_venta']."',
				isv_compra = '".$datos['isv_compra']."',
				file_name = '".$datos['file']."'			
			WHERE productos_id = '".$datos['productos_id']."'";
			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		protected function edit_bodega_productos_modelo($datos){
			$update = "UPDATE productos
			SET				
				almacen_id = '".$datos['bodega']."'			
			WHERE productos_id = '".$datos['productos_id']."'";
			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function delete_productos_modelo($productos_id){
			$delete = "DELETE FROM productos WHERE productos_id = '$productos_id'";
			$sql = mainModel::connection()->query($delete) or die(mainModel::connection()->error);
		
			return $sql;			
		}
		
		protected function valid_productos_factura($productos_id){
			$query = "SELECT facturas_id 
				FROM facturas_detalles 
				WHERE productos_id = '$productos_id'";
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function valid_productos_compras($productos_id){
			$query = "SELECT compras_id 
				FROM compras_detalles 
				WHERE productos_id = '$productos_id'";
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		protected function consultar_codigo_producto($producto){
			$query = "SELECT productos_id
				FROM productos
				WHERE nombre = '$producto'";
				
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;					
		}
		
		protected function tipo_producto_modelo($productos_id){
			$result = mainModel::getTipoProducto($productos_id);
			
			return $result;			
		}		
	}