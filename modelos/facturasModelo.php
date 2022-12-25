<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }

	class facturasModelo extends mainModel{		
		protected function agregar_facturas_modelo($datos){
			$insert = "INSERT INTO facturas 
				VALUES('".$datos['facturas_id']."','".$datos['clientes_id']."','".$datos['secuencia_facturacion_id']."','".$datos['apertura_id']."','".$datos['numero']."','".$datos['tipo_factura']."','".$datos['colaboradores_id']."','".$datos['importe']."','".$datos['notas']."','".$datos['fecha']."','".$datos['estado']."','".$datos['usuario']."','".$datos['empresa']."','".$datos['fecha_registro']."','".$datos['fecha_dolar']."')";
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);

			return $result;			
		}	

		protected function agregar_detalle_facturas_modelo($datos){
			$facturas_detalle_id = mainModel::correlativo("facturas_detalle_id", "facturas_detalles");
			$insert = "INSERT INTO facturas_detalles 
				VALUES('$facturas_detalle_id','".$datos['facturas_id']."','".$datos['productos_id']."',
				'".$datos['cantidad']."','".$datos['precio']."','".$datos['isv_valor']."','".$datos['descuento']."','".$datos['medida']."')";
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;			
		}
		
		protected function agregar_cambio_dolar_modelo($datos){
			$insert = "INSERT INTO cambio_dolar 
				VALUES('".$datos['cambio_dolar_id']."','".$datos['compra']."','".$datos['venta']."','".$datos['tipo']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);		

			return $result;			
		}

		protected function agregar_movimientos_productos_modelo($datos){
			$movimientos_id = mainModel::correlativo("movimientos_id", "movimientos");
			$insert = "INSERT INTO movimientos
				VALUES('$movimientos_id','".$datos['productos_id']."','".$datos['documento']."','".$datos['cantidad_entrada']."',
				'".$datos['cantidad_salida']."','".$datos['saldo']."','".$datos['empresa']."','".$datos['fecha_registro']."',
				'".$datos['clientes_id']."','','".$datos['almacen_id']."')";
			
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);	
			return $result;				

		}
		
		protected function agregar_cuenta_por_cobrar_clientes($datos){
			$cobrar_clientes_id = mainModel::correlativo("cobrar_clientes_id", "cobrar_clientes");
			$insert = "INSERT INTO cobrar_clientes
				VALUES('$cobrar_clientes_id','".$datos['clientes_id']."','".$datos['facturas_id']."','".$datos['fecha']."','".$datos['saldo']."','".$datos['estado']."','".$datos['usuario']."','".$datos['empresa']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
	
			return $result;				

		}	

		protected function agregar_precio_factura_clientes($datos){
			$precio_factura_id = mainModel::correlativo("precio_factura_id", "precio_factura");
			$insert = "INSERT INTO precio_factura
				VALUES('$precio_factura_id','".$datos['facturas_id']."','".$datos['productos_id']."','".$datos['clientes_id']."','".$datos['fecha']."','".$datos['referencia']."','".$datos['precio_anterior']."','".$datos['precio_nuevo']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;				
		}		
		
		protected function actualizar_detalle_facturas($datos){
			$update = "UPDATE facturas_detalles
				SET 
					cantidad = '".$datos['cantidad']."',
					precio = '".$datos['precio']."',
					isv_valor = '".$datos['isv_valor']."',
					descuento = '".$datos['descuento']."'
				WHERE facturas_id = '".$datos['facturas_id']."' AND productos_id = '".$datos['productos_id']."'";		

			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);		

			return $result;					
		}
		
		protected function actualizar_factura_importe($datos){
			$update = "UPDATE facturas
				SET
					importe = '".$datos['importe']."'
				WHERE facturas_id = '".$datos['facturas_id']."'";
				
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;				
		}
						
		protected function actualizar_secuencia_facturacion_modelo($secuencia_facturacion_id, $numero){
			$update = "UPDATE secuencia_facturacion
				SET
					siguiente = '$numero'
				WHERE secuencia_facturacion_id = '$secuencia_facturacion_id'";
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);	

			return $result;				
		}
		
		protected function cancelar_facturas_modelo($facturas_id){
			$estado = 4;//FACTURA CANCELADA
			$update = "UPDATE facturas
				SET
					estado = '$estado'
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
		
			return $result;			
		}
	
		protected function secuencia_facturacion_modelo($empresa_id, $documento_id){
			$query = "SELECT secuencia_facturacion_id, prefijo, siguiente AS 'numero', rango_final, fecha_limite, incremento, relleno
			   FROM secuencia_facturacion
			   WHERE activo = '1' AND empresa_id = '$empresa_id' AND documento_id = '$documento_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;
		}
		
		protected function validDetalleFactura($facturas_id, $productos_id){
			$query = "SELECT facturas_id
				FROM facturas_detalles
				WHERE facturas_id = '$facturas_id' AND productos_id  = '$productos_id'";
			
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}
	
		protected function valid_cambio_dolar_modelo($fecha){
			$query = "SELECT cambio_dolar_id
				FROM cambio_dolar
				WHERE CAST(fecha_registro AS DATE) = '$fecha'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}

		protected function valid_cambio_dolar_tipo2_modelo($fecha){
			$query = "SELECT cambio_dolar_id
				FROM cambio_dolar
				WHERE CAST(fecha_registro AS DATE) = '$fecha' AND tipo = 2";
			
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);		

			return $result;				
		}				

		protected function valid_precio_factura_modelo($datos){
			$query = "SELECT precio_factura_id
				FROM precio_factura
				WHERE facturas_id = '".$datos['facturas_id']."'";
		
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
		
			return $result;				
		}	

		protected function saldo_productos_movimientos_modelo($productos_id){
			$result = mainModel::getSaldoProductosMovimientos($productos_id);
			
			return $result;			
		}
		
		protected function getISV_modelo(){
			$result = mainModel::getISV('Facturas');
		
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

		protected function getMedidaProducto($productos_id){
			$query = "SELECT
			productos.productos_id,
			medida.nombre AS medida,
			medida.medida_id,
			medida.estado
			FROM
			medida
			INNER JOIN productos ON medida.medida_id = productos.medida_id	
			WHERE productos.productos_id = '".$productos_id."'
			AND medida.estado = 1";
		
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
		
			return $result;				
		}

		protected function cantidad_producto_modelo($productos_id){
			$result = mainModel::getCantidadProductos($productos_id);
			
			return $result;			
		}	

		protected function getAperturaIDModelo($datos){
			$query = "SELECT apertura_id
				FROM apertura
				WHERE colaboradores_id = '".$datos['colaboradores_id']."' AND fecha = '".$datos['fecha']."' AND estado = '".$datos['estado']."'";			
			
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}

		protected function total_hijos_segun_padre_modelo($productos_id){
			$result = mainModel::getTotalHijosporPadre($productos_id);
			
			return $result;			
		}			
	}
?>	