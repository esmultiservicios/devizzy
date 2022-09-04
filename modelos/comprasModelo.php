<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class comprasModelo extends mainModel{		
		protected function agregar_compras_modelo($datos){
			$compras_id = mainModel::correlativo("compras_id", "compras");
			$insert = "INSERT INTO compras 
				VALUES('$compras_id','".$datos['proveedores_id']."','".$datos['number']."','".$datos['tipoPurchase']."','".$datos['colaboradores_id']."','".$datos['importe']."','".$datos['notas']."','".$datos['fecha']."','".$datos['estado']."','".$datos['usuario']."','".$datos['empresa']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function agregar_detalle_compras($datos){
			$compras_detalles_id = mainModel::correlativo("compras_detalles_id", "compras_detalles");
			$insert = "INSERT INTO compras_detalles 
				VALUES('$compras_detalles_id','".$datos['compras_id']."','".$datos['productos_id']."','".$datos['cantidad']."',
				'".$datos['precio']."','".$datos['isv_valor']."','".$datos['descuento']."','".$datos['medida']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function agregar_movimientos_productos_modelo($datos){
			$movimientos_id = mainModel::correlativo("movimientos_id", "movimientos");
			$insert = "INSERT INTO movimientos
				VALUES('$movimientos_id','".$datos['productos_id']."','".$datos['documento']."','".$datos['cantidad_entrada']."',
				'".$datos['cantidad_salida']."','".$datos['saldo']."','".$datos['empresa']."','".$datos['fecha_registro']."',
				'".$datos['clientes_id']."','".$datos['comentario']."'
				)";
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;				
		}
		
		protected function agregar_cuenta_por_pagar_proveedores($datos){
			$pagar_proveedores_id = mainModel::correlativo("pagar_proveedores_id", "pagar_proveedores");
			$insert = "INSERT INTO pagar_proveedores
				VALUES('$pagar_proveedores_id','".$datos['proveedores_id']."','".$datos['compras_id']."','".$datos['fecha']."','".$datos['saldo']."','".$datos['estado']."','".$datos['usuario']."','".$datos['empresa']."','".$datos['fecha_registro']."')";
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;				
		}
		
		protected function insert_price_list($datos){
			$price_list_id = mainModel::correlativo("price_list_id", "price_list");
			$insert = "INSERT INTO price_list
				VALUES('$price_list_id','".$datos['compras_id']."','".$datos['productos_id']."','".$datos['prices']."','".$datos['fecha']."','".$datos['usuario']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;	
		}
		
		protected function actualizar_detalle_compras($datos){
			$update = "UPDATE compras_detalles
						SET 
							cantidad = '".$datos['cantidad']."',
							precio = '".$datos['precio']."',
							isv_valor = '".$datos['isv_valor']."',
							descuento = '".$datos['descuento']."'
						WHERE compras_id = '".$datos['compras_id']."'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;					
		}
		
		protected function actualizar_compra_importe($datos){
			$update = "UPDATE compras
				SET
					importe = '".$datos['importe']."'
				WHERE compras_id = '".$datos['compras_id']."'";
				
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;				
		}		
		
		protected function actualizar_productos_modelo($productos_id, $cantidad, $precio_compra){
			$update = "UPDATE productos
				SET
					cantidad = '$cantidad',
					precio_compra = '$precio_compra'
				WHERE productos_id = '$productos_id'";

			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
		
			return $result;				
		}
		
		protected function actualizar_secuencia_compras_modelo($secuencia_facturacion_id, $numero){
			$update = "UPDATE secuencia_facturacion
				SET
					siguiente = '$numero'
				WHERE secuencia_facturacion_id = '$secuencia_facturacion_id'";
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
		
			return $result;				
		}
		
		protected function cancelar_compra_modelo($compras_id){
			$estado = 4;//COMPRA CANCELADA
			$update = "UPDATE compras
				SET
					estado = '$estado'
				WHERE compras_id = '$compras_id'";
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
		
			return $result;			
		}
		
		protected function secuencia_compras($empresa_id){
			$query = "SELECT secuencia_facturacion_id, prefijo, siguiente AS 'numero', rango_final, fecha_limite, incremento, relleno
			   FROM secuencia_facturacion
			   WHERE activo = '1' AND empresa_id = '$empresa_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;
		}
		
		protected function obtener_compraID_modelo($proveedores_id, $fecha, $number, $colaboradores_id){
			$query = "SELECT compras_id 
				FROM compras 
				WHERE proveedores_id = '$proveedores_id' AND fecha = '$fecha' AND number = '$number' AND colaboradores_id = '$colaboradores_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function validNumberCompras($proveedores_id, $fecha, $number, $colaboradores_id){
			$query = "SELECT compras_id
				FROM compras 
				WHERE proveedores_id = '$proveedores_id' AND fecha = '$fecha' AND number = '$number' AND colaboradores_id = '$colaboradores_id'";
			
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;					
		}
		
		protected function validDetalleCompras($compras_id, $productos_id){
			$query = "SELECT compras_id
				FROM compras_detalles
				WHERE compras_id = '$compras_id' AND productos_id  = '$productos_id'";
			
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function saldo_productos_movimientos_modelo($productos_id){
			$result = mainModel::getSaldoProductosMovimientos($productos_id);
			
			return $result;			
		}
		
		protected function getISV_modelo(){
			$result = mainModel::getISV();
			
			return $result;
		}
		
		protected function getISVEstadoProducto_modelo($productos_id){
			$result = mainModel::getISVEstadoProducto($productos_id);
			
			return $result;			
		}
		
		protected function tipo_producto_modelo($productos_id){
			$result = mainModel::getTipoProducto($productos_id);
			
			return $result;			
		}
		
		protected function cantidad_producto_modelo($productos_id){
			$result = mainModel::getCantidadProductos($productos_id);
			
			return $result;			
		}			
	}