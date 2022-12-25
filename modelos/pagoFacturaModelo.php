<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class pagoFacturaModelo extends mainModel{
		protected function agregar_pago_factura_modelo($datos){

			$importe = $datos['importe'];

			if($datos['abono']>0){
				$importe = $datos['abono'];
			}

			$pagos_id = mainModel::correlativo("pagos_id", "pagos");
			$insert = "INSERT INTO pagos 
				VALUES('$pagos_id','".$datos['facturas_id']."','".$datos['tipo_pago']."','".$datos['fecha']."',
				'".$importe."','".$datos['efectivo']."','".$datos['cambio']."','".$datos['tarjeta']."',
				'".$datos['usuario']."','".$datos['estado']."','".$datos['empresa']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $result;		
		}
		
		protected function agregar_pago_detalles_factura_modelo($datos){	

			$pagos_detalles_id = mainModel::correlativo("pagos_detalles_id", "pagos_detalles");
			$insert = "INSERT INTO pagos_detalles 
				VALUES('$pagos_detalles_id','".$datos['pagos_id']."','".$datos['tipo_pago_id']."','".$datos['banco_id']."','".$datos['efectivo']."','".$datos['descripcion1']."','".$datos['descripcion2']."','".$datos['descripcion3']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;			
		}
		
		protected function cancelar_pago_modelo($pagos_id){
			$estado = 2;//Pago CANCELADA
			$update = "UPDATE pagos
				SET
					estado = '$estado'
				WHERE pagos_id = '$pagos_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function consultar_codigo_pago_modelo($facturas_id){
			$query = "SELECT pagos_id
				FROM pagos
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}

		protected function getLastInserted(){
			$query = "SELECT MAX(pagos_id) AS id
			FROM pagos";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function update_status_factura($facturas_id){
			$estado = 2;//FACTURA PAGADA
			$update = "UPDATE facturas
				SET
					estado = '$estado'
				WHERE facturas_id = '$facturas_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
		
			return $result;					
		}	

		protected function update_status_factura_cuentas_por_cobrar($facturas_id,$estado = 2,$importe = ''){ //DONDE 2 ES PAGO REALIZADO			
			if($importe != ''){
				$importe = ', saldo = '.$importe;
			}

			$update = "UPDATE cobrar_clientes
				SET
					estado = '$estado'
					$importe
				WHERE facturas_id = '$facturas_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			
			return $result;					
		}		
		
		protected function consultar_factura_cuentas_por_cobrar($facturas_id){
			$query = "SELECT *
				FROM cobrar_clientes
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
		
			return $result;				
		}	

		protected function consultar_factura_fecha($facturas_id){
			$query = "SELECT fecha
				FROM facturas
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function consultar_tipo_factura($facturas_id){
			$query = "SELECT tipo_factura
				FROM facturas
				WHERE facturas_id = '$facturas_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;	
		}

		protected function consultar_numero_factura($facturas_id){
			$query = "SELECT number, secuencia_facturacion_id
				FROM facturas
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;	
		}

		protected function valid_pagos_factura($facturas_id){
			$query = "SELECT pagos_id
				FROM pagos
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function valid_pagos_detalles_facturas($pagos_id, $tipo_pago){
			$query = "SELECT pagos_detalles_id
					FROM pagos_detalles
					WHERE pagos_id = '$pagos_id' AND tipo_pago_id = '$tipo_pago'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}

		protected function secuencia_facturacion_modelo($empresa_id){
			$query = "SELECT secuencia_facturacion_id, prefijo, siguiente AS 'numero', rango_final, fecha_limite, incremento, relleno
			   FROM secuencia_facturacion
			   WHERE activo = '1' AND empresa_id = '$empresa_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;
		}	

		protected function consulta_cuenta_pago_modelo($tipo_pago_id){
			$query = "SELECT cuentas_id
			   FROM tipo_pago
			   WHERE tipo_pago_id = '$tipo_pago_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
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
		
		protected function actualizar_factura($datos){
			$update = "UPDATE facturas
			SET
				estado = '".$datos['estado']."',
				number = '".$datos['number']."'
			WHERE facturas_id = '".$datos['facturas_id']."'";

			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);	

			return $result;					
		}
		
	    //METODO QUE PERMITE AGREGAR EL INGRESO DEL PAGO DEL CLIENTE
		protected function agregar_ingresos_contabilidad_pagos_modelo($datos){	
			$ingresos_id = mainModel::correlativo("ingresos_id", "ingresos");		
			$insert = "INSERT INTO ingresos VALUES('".$ingresos_id."','".$datos['cuentas_id']."','".$datos['clientes_id']."','".$datos['empresa_id']."','".$datos['tipo_ingreso']."','".$datos['fecha']."','".$datos['factura']."','".$datos['subtotal']."','".$datos['descuento']."','".$datos['nc']."','".$datos['isv']."','".$datos['total']."','".$datos['observacion']."','".$datos['estado']."','".$datos['colaboradores_id']."','".$datos['fecha_registro']."')";
			
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		protected function agregar_movimientos_contabilidad_pagos_modelo($datos){
			$movimientos_cuentas_id = mainModel::correlativo("movimientos_cuentas_id", "movimientos_cuentas");
			$insert = "INSERT INTO movimientos_cuentas VALUES('$movimientos_cuentas_id','".$datos['cuentas_id']."','".$datos['empresa_id']."','".$datos['fecha']."','".$datos['ingreso']."','".$datos['egreso']."','".$datos['saldo']."','".$datos['colaboradores_id']."','".$datos['fecha_registro']."')";
			
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		protected function consultar_saldo_movimientos_cuentas_pagos_contabilidad($cuentas_id){
			$query = "SELECT ingreso, egreso, saldo
				FROM movimientos_cuentas
				WHERE cuentas_id = '$cuentas_id'
				ORDER BY movimientos_cuentas_id DESC LIMIT 1";
			
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;				
		}

		//funcion para realizar todos lo pagos de factura
		protected function agregar_pago_factura_base($res){	
			//SI EL PAGO QUE SE ESTA REALIZANDO ES DE UN DOCUMENTO AL CREDITO
			if($res['estado_factura'] == 2){//SI ES CREDITO ESTO ES UN ABONO A LA FACTURA
				$saldo_credito = 0;
				$nuevo_saldo = 0;

				//consultamos a la tabla cobrar cliente
				$get_cobrar_cliente = pagoFacturaModelo::consultar_factura_cuentas_por_cobrar($res['facturas_id']);
								
				if($get_cobrar_cliente->num_rows > 0){
					$rec = $get_cobrar_cliente->fetch_assoc();
					$saldo_credito = $rec['saldo'];
					
				}else{
					$alert = [
						"alert" => "simple",
						"title" => "Ocurrio un error inesperado",
						"text" => "No hemos podido procesar su solicitud",
						"type" => "error",
						"btn-class" => "btn-danger",					
					];
				}
	
				//validar que no se hagan mas abonos que el importe
				if($res['abono'] <= $saldo_credito ){
					//update tabla cobrar cliente
					if($res['abono'] == $saldo_credito){
						//actualizamos el estado a pagado (2)
						$put_cobrar_cliente = pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($res['facturas_id'],2);
						//ACTUALIZAMOS EL ESTADO DE LA FACTURA
						pagoFacturaModelo::update_status_factura($res['facturas_id']);
					}else{
						$nuevo_saldo = $saldo_credito - $res['abono'];
						$put_cobrar_cliente = pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($res['facturas_id'],1,$nuevo_saldo);
					}
	
					$query = pagoFacturaModelo::agregar_pago_factura_modelo($res);					
	
					if($query){
						//ACTUALIZAMOS EL DETALLE DEL PAGO
						$consulta_pago = pagoFacturaModelo::getLastInserted()->fetch_assoc();

						$pagos_id = $consulta_pago['id'];
													
						$datos_pago_detalle = [
							"pagos_id" => $pagos_id,
							"tipo_pago_id" => $res['tipo_pago_id'],
							"banco_id" => $res['banco_id'],
							"efectivo" => $res['importe'],
							"descripcion1" => $res['referencia_pago1'],
							"descripcion2" => $res['referencia_pago2'],
							"descripcion3" => $res['referencia_pago3'],
						];	
						
						$result_valid_pagos_detalles_facturas = pagoFacturaModelo::valid_pagos_detalles_facturas($pagos_id, $res['tipo_pago_id']);
						
						pagoFacturaModelo::agregar_pago_detalles_factura_modelo($datos_pago_detalle);

						//INGRESAMOS LOS DATOS DEL PAGO EN LA TABLA ingresos

						//CONSULTAMOS LA CUENTA DONDE SE ENLZARA CON EL PAGO
						$consulta_cuenta_ingreso = self::consulta_cuenta_pago_modelo($res['tipo_pago_id'])->fetch_assoc();
						$cuentas_id = $consulta_cuenta_ingreso['cuentas_id'];					
						$empresa_id = $res['empresa'];

						//CONSULTMOS EL NUMERO DE FACTURA QUE ESTAMOS PAGANDO O ABONANDO
						$consulta_factura = mainModel::getFactura($res['facturas_id'])->fetch_assoc();
						$no_factura = str_pad($consulta_factura['numero_factura'], $consulta_factura['relleno'], "0", STR_PAD_LEFT);
						$clientes_id = $consulta_factura['clientes_id'];	
						$clientes_id = $consulta_factura['clientes_id'];

						$subtotal = $res['abono'];
						$isv = 0;
						$descuento = 0;
						$nc = 0;
						$total = $res['abono'];
						$observacion = "Ingresos por venta Cierre de Caja";
						$tipo_ingreso = 2;//OTROS INGRESOS
						$fecha = date("Y-m-d");
						$fecha_registro = date("Y-m-d H:i:s");
						$estado = 1;
						
						$datos_ingresos = [
							"clientes_id" => $clientes_id,
							"cuentas_id" => $cuentas_id,
							"empresa_id" => $empresa_id,
							"fecha" => $fecha,
							"factura" => $no_factura,
							"subtotal" => $subtotal,
							"isv" => $isv,
							"descuento" => $descuento,
							"nc" => $nc,
							"total" => $total,
							"observacion" => $observacion,
							"estado" => $estado,
							"fecha_registro" => $fecha_registro,
							"colaboradores_id" => $res['colaboradores_id'],
							"tipo_ingreso" => $tipo_ingreso								
						];						

						//ALMACENAMOS EL INGRESO DEL PAGO
						self::agregar_ingresos_contabilidad_pagos_modelo($datos_ingresos);

						//INGRESAMOS LOS DATOS DEL PAGO EN LA TABLA movimientos_cuentas
						//CONSULTAMOS EL SALDO DISPONIBLE PARA LA CUENTA
						$consulta_ingresos_contabilidad = self::consultar_saldo_movimientos_cuentas_pagos_contabilidad($cuentas_id)->fetch_assoc();
						$saldo_consulta = $consulta_ingresos_contabilidad['saldo'];	
						$ingreso = $total;
						$egreso = 0;
						$saldo = $saldo_consulta + $ingreso;

						$datos_movimientos = [
							"cuentas_id" => $cuentas_id,
							"empresa_id" => $empresa_id,
							"fecha" => $fecha,
							"ingreso" => $ingreso,
							"egreso" => $egreso,
							"saldo" => $saldo,
							"colaboradores_id" => $res['colaboradores_id'],
							"fecha_registro" => $fecha_registro,				
						];

						//ALMACENAMOS EL MOVIMIENTO DE CUENTA DEL PAGO
						self::agregar_movimientos_contabilidad_pagos_modelo($datos_movimientos);
																	
						$alert = [
							"alert" => "save_simple",
							"title" => "Registro almacenado",
							"text" => "El registro se ha almacenado correctamente",
							"type" => "success",
							"btn-class" => "btn-primary",
							"btn-text" => "¡Bien Hecho!",
							"form" => "formEfectivoBill",
							"id" => "proceso_pagos",
							"valor" => "Registro",	
							"funcion" => "listar_cuentas_por_cobrar_clientes();getCollaboradoresModalPagoFacturas();",
							"modal" => "modal_pagos",													
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
						"title" => "El abono es mayor al importe",
						"text" => "No hemos podido procesar su solicitud",
						"type" => "error",
						"btn-class" => "btn-danger",					
					];

					return $alert;
				}
			}else{//CUANDO LA FACTURA ES AL CONTADO
				//VERIFICAMOS QUE NO SE HA INGRESADO EL PAGO, SI NO SE HA REALIZADO EL INGRESO, PROCEDEMOS A ALMACENAR EL PAGO
				$result_valid_pagos_facturas = pagoFacturaModelo::valid_pagos_factura($res['facturas_id']);
				if($result_valid_pagos_facturas->num_rows==0){	
					$query = pagoFacturaModelo::agregar_pago_factura_modelo($res);
	
					if($query){
						//ACTUALIZAMOS EL DETALLE DEL PAGO
						
						$consulta_pago = pagoFacturaModelo::getLastInserted()->fetch_assoc();

						$pagos_id = $consulta_pago['id'];
						
													
						$datos_pago_detalle = [
							"pagos_id" => $pagos_id,
							"tipo_pago_id" => $res['tipo_pago_id'],
							"banco_id" => $res['banco_id'],
							"efectivo" => $res['importe'],
							"descripcion1" => $res['referencia_pago1'],
							"descripcion2" => $res['referencia_pago2'],
							"descripcion3" => $res['referencia_pago3'],
						];
						
						$result_valid_pagos_detalles_facturas = pagoFacturaModelo::valid_pagos_detalles_facturas($pagos_id, $res['tipo_pago_id']);
						
						//VALIDAMOS QUE NO EXISTA EL DETALLE DEL PAGO, DE NO EXISTIR SE ALMACENA EL DETALLE DEL PAGO
						if($result_valid_pagos_detalles_facturas->num_rows==0){
							pagoFacturaModelo::agregar_pago_detalles_factura_modelo($datos_pago_detalle);
						}					
						
						//ACTUALIZAMOS EL ESTADO DE LA FACTURA
						pagoFacturaModelo::update_status_factura($res['facturas_id']);
						pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($res['facturas_id']);
						
						//VALIDAMOS EL TIPO DE FACTURA, SI ES AL CONTADO, VERIFICAMOS EL NUMERO DE FACTURA QUE SIGUE, SI ES AL CREDITO, SOLO CONSULTAMOS EL ULTIMO NUMERO ALMACENADO PARA QUE NO PASE AL SIGUIENTE
						$tipo_factura = pagoFacturaModelo::consultar_tipo_factura($res['facturas_id'])->fetch_assoc();
	
						if($tipo_factura['tipo_factura'] == 1){
							$secuenciaFacturacion = pagoFacturaModelo::secuencia_facturacion_modelo($res['empresa'])->fetch_assoc();
							$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
							$numero = $secuenciaFacturacion['numero'];
							$incremento = $secuenciaFacturacion['incremento'];
							$no_factura = $secuenciaFacturacion['prefijo']."".str_pad($secuenciaFacturacion['numero'], $secuenciaFacturacion['relleno'], "0", STR_PAD_LEFT);
						}else{
							$secuenciaFacturacion = pagoFacturaModelo::consultar_numero_factura($res['facturas_id'])->fetch_assoc();
							$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
							$numero = $secuenciaFacturacion['number'];				
						}
	
						//ACTUALIZAMOS EL ESTADO DE LA FACTURA Y EL NUMERO DE FACTURACION
						$datos_update_factura = [
							"facturas_id" => $res['facturas_id'],
							"estado" => 2,//pagado
							"number" => $numero,
						];	
	
						pagoFacturaModelo::actualizar_factura($datos_update_factura);
	
						//ACTUALIZAMOS EL NUMERO SIGUIENTE DE LA SECUENCIA PARA LA FACTURACION, SIEMPRE QUE LA FACTURA SEA AL CONTADO
						if($tipo_factura['tipo_factura'] == 1){
							$numero += $incremento;
							pagoFacturaModelo::actualizar_secuencia_facturacion_modelo($secuencia_facturacion_id, $numero);		
						}	
	
						$alert = [
							"alert" => "save_simple",
							"title" => "Registro almacenado",
							"text" => "El registro se ha almacenado correctamente",
							"type" => "success",
							"btn-class" => "btn-primary",
							"btn-text" => "¡Bien Hecho!",
							"form" => "formEfectivoBill",
							"id" => "proceso_pagos",
							"valor" => "Registro",	
							"funcion" => "printBill(".$res['facturas_id'].",".$res['print_comprobante'].");listar_cuentas_por_cobrar_clientes();mailBill(".$res['facturas_id'].");getCollaboradoresModalPagoFacturas();",
							"modal" => "modal_pagos",
													
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
						"title" => "Error al ingresar el pago",
						"text" => "Lo sentimos este pago ya ha sido ingresado, por favor valide el registro de pagos.",
						"type" => "error",
						"btn-class" => "btn-danger",					
					];					
				}						
			}			
			
			return $alert;
		}
	}