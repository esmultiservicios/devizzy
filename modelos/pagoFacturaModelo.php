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

		//funcion para realizar todos lo pagos de factura
		protected function agregar_pago_factura_base($res){			
			if($res['estado_factura'] == 2){ // si es credito esto es un abono a la factura				
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
							"funcion" => "listar_cuentas_por_cobrar_clientes();",
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
				}
			}else{
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
							"funcion" => "printBill(".$res['facturas_id'].",".$res['print_comprobante'].");listar_cuentas_por_cobrar_clientes();mailBill(".$res['facturas_id'].");",
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