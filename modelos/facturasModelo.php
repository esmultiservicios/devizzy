<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }

	class facturasModelo extends mainModel{		
		protected function agregar_facturas_modelo($datos){
			$insert = "INSERT INTO facturas (
							`facturas_id`, 
							`clientes_id`, 
							`secuencia_facturacion_id`, 
							`apertura_id`, 
							`number`, 
							`tipo_factura`, 
							`colaboradores_id`, 
							`importe`, 
							`notas`, 
							`fecha`, 
							`estado`, 
							`usuario`, 
							`empresa_id`, 
							`fecha_registro`, 
							`fecha_dolar`
						)
						VALUES (
							'".$datos['facturas_id']."',
							'".$datos['clientes_id']."',
							'".$datos['secuencia_facturacion_id']."',
							'".$datos['apertura_id']."',
							'".$datos['numero']."',
							'".$datos['tipo_factura']."',
							'".$datos['colaboradores_id']."',
							'".$datos['importe']."',
							'".$datos['notas']."',
							'".$datos['fecha']."',
							'".$datos['estado']."',
							'".$datos['usuario']."',
							'".$datos['empresa']."',
							'".$datos['fecha_registro']."',
							'".$datos['fecha_dolar']."'
						)";
		
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;			
		}		

		protected function agregar_detalle_facturas_modelo($datos){
			$facturas_detalle_id = mainModel::correlativo("facturas_detalle_id", "facturas_detalles");
			$insert = "INSERT INTO facturas_detalles (
							`facturas_detalle_id`, 
							`facturas_id`, 
							`productos_id`, 
							`cantidad`, 
							`precio`, 
							`isv_valor`, 
							`descuento`, 
							`medida`
						)
						VALUES (
							'$facturas_detalle_id',
							'".$datos['facturas_id']."',
							'".$datos['productos_id']."',
							'".$datos['cantidad']."',
							'".$datos['precio']."',
							'".$datos['isv_valor']."',
							'".$datos['descuento']."',
							'".$datos['medida']."'
						)";
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
			$insert = "INSERT INTO movimientos (
							`movimientos_id`, 
							`productos_id`, 
							`documento`, 
							`cantidad_entrada`, 
							`cantidad_salida`, 
							`saldo`, 
							`empresa_id`, 
							`fecha_registro`, 
							`clientes_id`, 
							`comentario`, 
							`almacen_id`
						)
						VALUES (
							'$movimientos_id',
							'".$datos['productos_id']."',
							'".$datos['documento']."',
							'".$datos['cantidad_entrada']."',
							'".$datos['cantidad_salida']."',
							'".$datos['saldo']."',
							'".$datos['empresa']."',
							'".$datos['fecha_registro']."',
							'".$datos['clientes_id']."',
							'',
							'".$datos['almacen_id']."'
						)";
		
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);    
			return $result;                
		}		
		
		protected function agregar_cuenta_por_cobrar_clientes($datos){
			$cobrar_clientes_id = mainModel::correlativo("cobrar_clientes_id", "cobrar_clientes");
			$insert = "INSERT INTO cobrar_clientes (
							`cobrar_clientes_id`, 
							`clientes_id`, 
							`facturas_id`, 
							`fecha`, 
							`saldo`, 
							`estado`, 
							`usuario`, 
							`empresa_id`, 
							`fecha_registro`
						)
						VALUES (
							'$cobrar_clientes_id',
							'".$datos['clientes_id']."',
							'".$datos['facturas_id']."',
							'".$datos['fecha']."',
							'".$datos['saldo']."',
							'".$datos['estado']."',
							'".$datos['usuario']."',
							'".$datos['empresa']."',
							'".$datos['fecha_registro']."'
						)";
		
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			return $result;                
		}		

		protected function agregar_precio_factura_clientes($datos){
			$precio_factura_id = mainModel::correlativo("precio_factura_id", "precio_factura");
			$insert = "INSERT INTO precio_factura (
							`precio_factura_id`, 
							`facturas_id`, 
							`productos_id`, 
							`clientes_id`, 
							`fecha`, 
							`referencia`, 
							`precio_anterior`, 
							`precio_nuevo`, 
							`fecha_registro`
						)
						VALUES (
							'$precio_factura_id',
							'".$datos['facturas_id']."',
							'".$datos['productos_id']."',
							'".$datos['clientes_id']."',
							'".$datos['fecha']."',
							'".$datos['referencia']."',
							'".$datos['precio_anterior']."',
							'".$datos['precio_nuevo']."',
							'".$datos['fecha_registro']."'
						)";
			
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			return $result;                
		} 
		
		protected function agregar_facturas_proforma_modelo($datos){
			$facturas_proforma_id = mainModel::correlativo("facturas_proforma_id", "facturas_proforma");

			$conexion = mainModel::connection();
		
			// Preparar la consulta
			$insert = "INSERT INTO facturas_proforma (
							facturas_proforma_id,
							facturas_id,
							clientes_id,
							secuencia_facturacion_id,
							numero,
							importe,
							usuario,
							empresa_id,
							estado,
							fecha_creacion
						) VALUES (
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?
						)";
			
			$stmt = $conexion->prepare($insert);
		
			if (!$stmt) {
				die("Error al preparar la consulta: " . $conexion->error);
			}
		
			// Enlazar parámetros
			$stmt->bind_param("iiisisisss", 
				$facturas_proforma_id,
				$datos['facturas_id'],
				$datos['clientes_id'],
				$datos['secuencia_facturacion_id'],
				$datos['numero'],
				$datos['importe'],
				$datos['usuario'],
				$datos['empresa_id'],
				$datos['estado'],
				$datos['fecha_creacion']
			);
		
			// Ejecutar la consulta
			$result = $stmt->execute();
		
			if (!$result) {
				die("Error al ejecutar la consulta: " . $stmt->error);
			}
		
			$stmt->close();
		
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

		protected function actualizar_estado_factura_modelo($facturas_id){
			$update = "UPDATE facturas
				SET
					estado = '2'
				WHERE facturas_id = '$facturas_id'";
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
			$estado = 4; //FACTURA CANCELADA
			$update = "UPDATE facturas
						SET
							estado = '$estado'
						WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
		
			return $result;            
		}
	
		protected function secuencia_facturacion_modelo($empresa_id, $documento_id) {
			// Consulta SQL para obtener la secuencia de facturación
			$query = "
				SELECT 
					secuencia_facturacion_id, 
					prefijo, 
					siguiente AS 'numero', 
					rango_final, 
					fecha_limite, 
					incremento, 
					relleno
				FROM 
					secuencia_facturacion
				WHERE 
					activo = '1' 
					AND empresa_id = '$empresa_id' 
					AND documento_id = '$documento_id'
			";

			// Ejecuta la consulta y maneja errores
			$result = mainModel::connection()->query($query) 
				or die(mainModel::connection()->error);

			return $result;
		}
		
		protected function validDetalleFactura($facturas_id, $productos_id){
			$query = "SELECT facturas_id
					FROM facturas_detalles
					WHERE facturas_id = '$facturas_id' AND productos_id  = '$productos_id'";
			
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;            
		}

		protected function validar_cobrarClientes_modelo($facturas_id){
			$query = "SELECT cobrar_clientes_id
					FROM cobrar_clientes
					WHERE facturas_id = '$facturas_id'";
			
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