<?php
    if($peticionAjax){
        require_once "../modelos/pagoFacturaModelo.php";
    }else{
        require_once "./modelos/pagoFacturaModelo.php";
    }
	
	class pagoFacturaControlador extends pagoFacturaModelo{
		//PAGO CON EFECTIVO
		public function agregar_pago_factura_controlador_efectivo(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$facturas_id = $_POST['factura_id_efectivo'];
			$print_comprobante = $_POST['comprobante_print'];
			$consulta_fecha_factura = pagoFacturaModelo::consultar_factura_fecha($facturas_id)->fetch_assoc();
			$fecha = date("Y-m-d");
			$importe = $_POST['monto_efectivo'];
			$cambio = $_POST['cambio_efectivo'];
			$empresa_id = $_SESSION['empresa_id_sd'];			
			$tipo_pago_id = 1;//EFECTIVO		
			$banco_id = 0;//SIN BANCO
			$tipo_pago = 1;//1. CONTADO 2. CRÉDITO
			$referencia_pago1 = "";
			$referencia_pago2 = "";
			$referencia_pago3 = "";
			$usuario = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");
			$estado = 1;
			$estado_factura = 2;//PAGADA
			$efectivo = 0;
			$tarjeta = 	0;			
			
			$datos = [
				"facturas_id" => $facturas_id,
				"fecha" => $fecha,
				"importe" => $importe,
				"cambio" => $cambio,
				"usuario" => $usuario,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,
				"empresa" => $empresa_id,
				"tipo_pago" => $tipo_pago,
				"efectivo" => $efectivo,
				"tarjeta" => $tarjeta							
			];
			
			//VERIFICAMOS QUE NO SE HA INGRESADO EL PAGO, SI NO SE HA REALIZADO EL INGRESO, PROCEDEMOS A ALMACENAR EL PAGO
			$result_valid_pagos_facturas = pagoFacturaModelo::valid_pagos_factura($facturas_id);
			
			if($result_valid_pagos_facturas->num_rows==0){
				$query = pagoFacturaModelo::agregar_pago_factura_modelo($datos);

				if($query){
					//ACTUALIZAMOS EL DETALLE DEL PAGO
					$consulta_pago = pagoFacturaModelo::consultar_codigo_pago_modelo($facturas_id)->fetch_assoc();
					$pagos_id = $consulta_pago['pagos_id'];
												
					$datos_pago_detalle = [
						"pagos_id" => $pagos_id,
						"tipo_pago_id" => $tipo_pago_id,
						"banco_id" => $banco_id,
						"efectivo" => $importe,
						"descripcion1" => $referencia_pago1,
						"descripcion2" => $referencia_pago2,
						"descripcion3" => $referencia_pago3,
					];	
					
					$result_valid_pagos_detalles_facturas = pagoFacturaModelo::valid_pagos_detalles_facturas($pagos_id, $tipo_pago_id);
					
					//VALIDAMOS QUE NO EXISTA EL DETALLE DEL PAGO, DE NO EXISTIR SE ALMACENA EL DETALLE DEL PAGO
					if($result_valid_pagos_detalles_facturas->num_rows==0){
						pagoFacturaModelo::agregar_pago_detalles_factura_modelo($datos_pago_detalle);
					}					
					
					//ACTUALIZAMOS EL ESTADO DE LA FACTURA
					pagoFacturaModelo::update_status_factura($facturas_id);
					
					//VERIFICAMOS SI ES UNA CUENTA POR COBRAR, DE SERLO ACTUALIZAMOS EL ESTADO DEL PAGO PARA LA CUENTA POR COBRAR
					$result_cxc_clientes = pagoFacturaModelo::consultar_factura_cuentas_por_cobrar($facturas_id);
					
					if($result_cxc_clientes->num_rows>0){
						pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($facturas_id);
					}
					
					//VALIDAMOS EL TIPO DE FACTURA, SI ES AL CONTADO, VERIFICAMOS EL NUMERO DE FACTURA QUE SIGUE, SI ES AL CREDITO, SOLO CONSULTAMOS EL ULTIMO NUMERO ALMACENADO PARA QUE NO PASE AL SIGUIENTE
					$tipo_factura = pagoFacturaModelo::consultar_tipo_factura($facturas_id)->fetch_assoc();

					if($tipo_factura['tipo_factura'] == 1){
						$secuenciaFacturacion = pagoFacturaModelo::secuencia_facturacion_modelo($empresa_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['numero'];
						$incremento = $secuenciaFacturacion['incremento'];
						$no_factura = $secuenciaFacturacion['prefijo']."".str_pad($secuenciaFacturacion['numero'], $secuenciaFacturacion['relleno'], "0", STR_PAD_LEFT);
					}else{
						$secuenciaFacturacion = pagoFacturaModelo::consultar_numero_factura($facturas_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['number'];				
					}

					//ACTUALIZAMOS EL ESTADO DE LA FACTURA Y EL NUMERO DE FACTURACION
					$datos_update_factura = [
						"facturas_id" => $facturas_id,
						"estado" => $estado_factura,
						"number" => $numero,
					];	

					pagoFacturaModelo::actualizar_factura($datos_update_factura);

					//ACTUALIZAMOS EL NUMERO SIGUIENTE DE LA SECUENCIA PARA LA FACTURACION, SIEMPRE QUE LA FACTURA SEA AL CONTADO
					if($tipo_factura['tipo_factura'] == 1){
						$numero += $incremento;
						pagoFacturaModelo::actualizar_secuencia_facturacion_modelo($secuencia_facturacion_id, $numero);		
					}	

					$alert = [
						"alert" => "clear_pay",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formEfectivoBill",
						"id" => "proceso_pagos",
						"valor" => "Registro",	
						"funcion" => "printBill(".$facturas_id.",".$print_comprobante.");listar_cuentas_por_cobrar_clientes();cleanBill();mailBill(".$facturas_id.");",
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
		
			return mainModel::sweetAlert($alert);
		}
		
		//PAGO CON TARJETA
		public function agregar_pago_factura_controlador_tarjeta(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$facturas_id = $_POST['factura_id_tarjeta'];
			$print_comprobante = $_POST['comprobante_print'];
			$consulta_fecha_factura = pagoFacturaModelo::consultar_factura_fecha($facturas_id)->fetch_assoc();
			$fecha = date("Y-m-d");
			$importe = $_POST['monto_efectivo'];
			$cambio = 0;
			$empresa_id = $_SESSION['empresa_id_sd'];			
			$tipo_pago_id = 2;//TARJETA	
			$banco_id = 0;//SIN BANCO	
			$tipo_pago = 2;//1. CONTADO 2. CRÉDITO	3.MIXTO	
			$estado_factura = 2;//PAGADA
			$efectivo = 0;
			$tarjeta = 	0;					

			$referencia_pago1 = mainModel::cleanStringConverterCase($_POST['cr_bill']);//TARJETA DE CREDITO
			$referencia_pago2 = mainModel::cleanStringConverterCase($_POST['exp']);//FECHA DE EXPIRACION
			$referencia_pago3 = mainModel::cleanStringConverterCase($_POST['cvcpwd']);//NUMERO DE APROBACIÓN
			
			$usuario = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");
			$estado = 1;
			
			$datos = [
				"facturas_id" => $facturas_id,
				"fecha" => $fecha,
				"importe" => $importe,
				"cambio" => $cambio,
				"usuario" => $usuario,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,
				"empresa" => $empresa_id,
				"tipo_pago" => $tipo_pago,
				"efectivo" => $efectivo,
				"tarjeta" => $tarjeta						
			];
			
			$result_valid_pagos_facturas = pagoFacturaModelo::valid_pagos_factura($facturas_id);
			
			//VERIFICAMOS QUE NO SE HA INGRESADO EL PAGO, SI NO SE HA REALIZADO EL INGRESO, PROCEDEMOS A ALMACENAR EL PAGO
			if($result_valid_pagos_facturas->num_rows==0){
				$query = pagoFacturaModelo::agregar_pago_factura_modelo($datos);

				if($query){
					//ACTUALIZAMOS EL DETALLE DEL PAGO
					$consulta_pago = pagoFacturaModelo::consultar_codigo_pago_modelo($facturas_id)->fetch_assoc();
					$pagos_id = $consulta_pago['pagos_id'];
												
					$datos_pago_detalle = [
						"pagos_id" => $pagos_id,
						"tipo_pago_id" => $tipo_pago_id,
						"banco_id" => $banco_id,
						"efectivo" => $importe,
						"descripcion1" => $referencia_pago1,
						"descripcion2" => $referencia_pago2,
						"descripcion3" => $referencia_pago3,
					];	
					
					$result_valid_pagos_detalles_facturas = pagoFacturaModelo::valid_pagos_detalles_facturas($pagos_id, $tipo_pago_id);
					
					//VALIDAMOS QUE NO EXISTA EL DETALLE DEL PAGO, DE NO EXISTIR SE ALMACENA EL DETALLE DEL PAGO
					if($result_valid_pagos_detalles_facturas->num_rows==0){
						pagoFacturaModelo::agregar_pago_detalles_factura_modelo($datos_pago_detalle);
					}	
										
					//ACTUALIZAMOS EL ESTADO DE LA FACTURA
					pagoFacturaModelo::update_status_factura($facturas_id);
					
					//VERIFICAMOS SI ES UNA CUENTA POR COBRAR, DE SERLO ACTUALIZAMOS EL ESTADO DEL PAGO PARA LA CUENTA POR COBRAR
					$result_cxc_clientes = pagoFacturaModelo::consultar_factura_cuentas_por_cobrar($facturas_id);
					
					if($result_cxc_clientes->num_rows>0){
						pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($facturas_id);
					}
					
					//VALIDAMOS EL TIPO DE FACTURA, SI ES AL CONTADO, VERIFICAMOS EL NUMERO DE FACTURA QUE SIGUE, SI ES AL CREDITO, SOLO CONSULTAMOS EL ULTIMO NUMERO ALMACENADO PARA QUE NO PASE AL SIGUIENTE
					$tipo_factura = pagoFacturaModelo::consultar_tipo_factura($facturas_id)->fetch_assoc();

					if($tipo_factura['tipo_factura'] == 1){
						$secuenciaFacturacion = pagoFacturaModelo::secuencia_facturacion_modelo($empresa_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['numero'];
						$incremento = $secuenciaFacturacion['incremento'];
						$no_factura = $secuenciaFacturacion['prefijo']."".str_pad($secuenciaFacturacion['numero'], $secuenciaFacturacion['relleno'], "0", STR_PAD_LEFT);
					}else{
						$secuenciaFacturacion = pagoFacturaModelo::consultar_numero_factura($facturas_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['number'];				
					}

					//ACTUALIZAMOS EL ESTADO DE LA FACTURA Y EL NUMERO DE FACTURACION
					$datos_update_factura = [
						"facturas_id" => $facturas_id,
						"estado" => $estado_factura,
						"number" => $numero,
					];	

					pagoFacturaModelo::actualizar_factura($datos_update_factura);

					//ACTUALIZAMOS EL NUMERO SIGUIENTE DE LA SECUENCIA PARA LA FACTURACION, SIEMPRE QUE LA FACTURA SEA AL CONTADO
					if($tipo_factura['tipo_factura'] == 1){
						$numero += $incremento;
						pagoFacturaModelo::actualizar_secuencia_facturacion_modelo($secuencia_facturacion_id, $numero);		
					}

					$alert = [
						"alert" => "clear_pay",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formTarjetaBill",
						"id" => "proceso_pagos",
						"valor" => "Registro",	
						"funcion" => "printBill(".$facturas_id.",".$print_comprobante.");listar_cuentas_por_cobrar_clientes();mailBill(".$facturas_id.");",
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
		
			return mainModel::sweetAlert($alert);
		}

		//PAGO MIXTO EFECTIVO Y TARJETA
		public function agregar_pago_factura_controlador_mixto(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$facturas_id = $_POST['factura_id_mixto'];
			$print_comprobante = $_POST['comprobante_print'];
			$consulta_fecha_factura = pagoFacturaModelo::consultar_factura_fecha($facturas_id)->fetch_assoc();
			$fecha = date("Y-m-d");
			$importe = $_POST['monto_efectivo'];
			$efectivo = $_POST['efectivo_bill'];
			$tarjeta = 	$_POST['monto_tarjeta'];	
			$cambio = $_POST['cambio_efectivo'];
			$empresa_id = $_SESSION['empresa_id_sd'];			
			$tipo_pago_id = 5;//PAGO MIXTO		
			$banco_id = 0;//SIN BANCO	
			$tipo_pago = 3;//1. CONTADO 2. CRÉDITO 3.MIXTO		
			$estado_factura = 2;//PAGADA

			$referencia_pago1 = mainModel::cleanStringConverterCase($_POST['cr_bill']);//TARJETA DE CREDITO
			$referencia_pago2 = mainModel::cleanStringConverterCase($_POST['exp']);//FECHA DE EXPIRACION
			$referencia_pago3 = mainModel::cleanStringConverterCase($_POST['cvcpwd']);//NUMERO DE APROBACIÓN
			
			$usuario = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");
			$estado = 1;
			
			$datos = [
				"facturas_id" => $facturas_id,
				"fecha" => $fecha,
				"importe" => $importe,
				"efectivo" => $efectivo,
				"cambio" => $cambio,
				"tarjeta" => $tarjeta,
				"usuario" => $usuario,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,
				"empresa" => $empresa_id,
				"tipo_pago" => $tipo_pago				
			];
			
			$result_valid_pagos_facturas = pagoFacturaModelo::valid_pagos_factura($facturas_id);
			
			//VERIFICAMOS QUE NO SE HA INGRESADO EL PAGO, SI NO SE HA REALIZADO EL INGRESO, PROCEDEMOS A ALMACENAR EL PAGO
			if($result_valid_pagos_facturas->num_rows==0){
				$query = pagoFacturaModelo::agregar_pago_factura_modelo($datos);

				if($query){
					//ACTUALIZAMOS EL DETALLE DEL PAGO
					$consulta_pago = pagoFacturaModelo::consultar_codigo_pago_modelo($facturas_id)->fetch_assoc();
					$pagos_id = $consulta_pago['pagos_id'];
												
					$datos_pago_detalle = [
						"pagos_id" => $pagos_id,
						"tipo_pago_id" => $tipo_pago_id,
						"banco_id" => $banco_id,
						"efectivo" => $importe,
						"descripcion1" => $referencia_pago1,
						"descripcion2" => $referencia_pago2,
						"descripcion3" => $referencia_pago3,
					];	
					
					$result_valid_pagos_detalles_facturas = pagoFacturaModelo::valid_pagos_detalles_facturas($pagos_id, $tipo_pago_id);
					
					//VALIDAMOS QUE NO EXISTA EL DETALLE DEL PAGO, DE NO EXISTIR SE ALMACENA EL DETALLE DEL PAGO
					if($result_valid_pagos_detalles_facturas->num_rows==0){
						pagoFacturaModelo::agregar_pago_detalles_factura_modelo($datos_pago_detalle);
					}	
										
					//ACTUALIZAMOS EL ESTADO DE LA FACTURA
					pagoFacturaModelo::update_status_factura($facturas_id);
					
					//VERIFICAMOS SI ES UNA CUENTA POR COBRAR, DE SERLO ACTUALIZAMOS EL ESTADO DEL PAGO PARA LA CUENTA POR COBRAR
					$result_cxc_clientes = pagoFacturaModelo::consultar_factura_cuentas_por_cobrar($facturas_id);
					
					if($result_cxc_clientes->num_rows>0){
						pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($facturas_id);
					}
					
					//VALIDAMOS EL TIPO DE FACTURA, SI ES AL CONTADO, VERIFICAMOS EL NUMERO DE FACTURA QUE SIGUE, SI ES AL CREDITO, SOLO CONSULTAMOS EL ULTIMO NUMERO ALMACENADO PARA QUE NO PASE AL SIGUIENTE
					$tipo_factura = pagoFacturaModelo::consultar_tipo_factura($facturas_id)->fetch_assoc();

					if($tipo_factura['tipo_factura'] == 1){
						$secuenciaFacturacion = pagoFacturaModelo::secuencia_facturacion_modelo($empresa_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['numero'];
						$incremento = $secuenciaFacturacion['incremento'];
						$no_factura = $secuenciaFacturacion['prefijo']."".str_pad($secuenciaFacturacion['numero'], $secuenciaFacturacion['relleno'], "0", STR_PAD_LEFT);
					}else{
						$secuenciaFacturacion = pagoFacturaModelo::consultar_numero_factura($facturas_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['number'];				
					}

					//ACTUALIZAMOS EL ESTADO DE LA FACTURA Y EL NUMERO DE FACTURACION
					$datos_update_factura = [
						"facturas_id" => $facturas_id,
						"estado" => $estado_factura,
						"number" => $numero,
					];	

					pagoFacturaModelo::actualizar_factura($datos_update_factura);

					//ACTUALIZAMOS EL NUMERO SIGUIENTE DE LA SECUENCIA PARA LA FACTURACION, SIEMPRE QUE LA FACTURA SEA AL CONTADO
					if($tipo_factura['tipo_factura'] == 1){
						$numero += $incremento;
						pagoFacturaModelo::actualizar_secuencia_facturacion_modelo($secuencia_facturacion_id, $numero);		
					}

					$alert = [
						"alert" => "clear_pay",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formTarjetaBill",
						"id" => "proceso_pagos",
						"valor" => "Registro",	
						"funcion" => "printBill(".$facturas_id.",".$print_comprobante.");listar_cuentas_por_cobrar_clientes();mailBill(".$facturas_id.");",
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
		
			return mainModel::sweetAlert($alert);
		}
		
		//PAGO CON TRANSFERENCIA
		public function agregar_pago_factura_controlador_transferencia(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
			
			$facturas_id = $_POST['factura_id_transferencia'];
			$print_comprobante = $_POST['comprobante_print'];
			$consulta_fecha_factura = pagoFacturaModelo::consultar_factura_fecha($facturas_id)->fetch_assoc();
			$fecha = date("Y-m-d");
			$importe = $_POST['monto_efectivo'];
			$cambio = 0;
			$empresa_id = $_SESSION['empresa_id_sd'];			
			$tipo_pago_id = 3;//TRANSFERENCIA		
			$banco_id = $_POST['bk_nm'];
			$tipo_pago = 1;//1. CONTADO 2. CRÉDITO			
			$estado_factura = 2;//PAGADA
			$efectivo = 0;
			$tarjeta = 	0;				

			$referencia_pago1 = mainModel::cleanStringConverterCase($_POST['ben_nm']);//TARJETA DE CREDITO
			$referencia_pago2 = "";
			$referencia_pago3 = "";
			
			$usuario = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");
			$estado = 1;
			
			$datos = [
				"facturas_id" => $facturas_id,
				"fecha" => $fecha,
				"importe" => $importe,
				"cambio" => $cambio,
				"usuario" => $usuario,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,
				"empresa" => $empresa_id,
				"tipo_pago" => $tipo_pago,
				"efectivo" => $efectivo,
				"tarjeta" => $tarjeta						
			];
			
			$result_valid_pagos_facturas = pagoFacturaModelo::valid_pagos_factura($facturas_id);
			
			//VERIFICAMOS QUE NO SE HA INGRESADO EL PAGO, SI NO SE HA REALIZADO EL INGRESO, PROCEDEMOS A ALMACENAR EL PAGO
			if($result_valid_pagos_facturas->num_rows==0){
				$query = pagoFacturaModelo::agregar_pago_factura_modelo($datos);

				if($query){
					//ACTUALIZAMOS EL DETALLE DEL PAGO
					$consulta_pago = pagoFacturaModelo::consultar_codigo_pago_modelo($facturas_id)->fetch_assoc();
					$pagos_id = $consulta_pago['pagos_id'];
												
					$datos_pago_detalle = [
						"pagos_id" => $pagos_id,
						"tipo_pago_id" => $tipo_pago_id,
						"banco_id" => $banco_id,
						"efectivo" => $importe,
						"descripcion1" => $referencia_pago1,
						"descripcion2" => $referencia_pago2,
						"descripcion3" => $referencia_pago3,
					];	
					
					$result_valid_pagos_detalles_facturas = pagoFacturaModelo::valid_pagos_detalles_facturas($pagos_id, $tipo_pago_id);
					
					//VALIDAMOS QUE NO EXISTA EL DETALLE DEL PAGO, DE NO EXISTIR SE ALMACENA EL DETALLE DEL PAGO
					if($result_valid_pagos_detalles_facturas->num_rows==0){
						pagoFacturaModelo::agregar_pago_detalles_factura_modelo($datos_pago_detalle);
					}	
														
					//ACTUALIZAMOS EL ESTADO DE LA FACTURA
					pagoFacturaModelo::update_status_factura($facturas_id);
					
					//VERIFICAMOS SI ES UNA CUENTA POR COBRAR, DE SERLO ACTUALIZAMOS EL ESTADO DEL PAGO PARA LA CUENTA POR COBRAR
					$result_cxc_clientes = pagoFacturaModelo::consultar_factura_cuentas_por_cobrar($facturas_id);
					
					if($result_cxc_clientes->num_rows>0){
						pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($facturas_id);
					}
					
					//VALIDAMOS EL TIPO DE FACTURA, SI ES AL CONTADO, VERIFICAMOS EL NUMERO DE FACTURA QUE SIGUE, SI ES AL CREDITO, SOLO CONSULTAMOS EL ULTIMO NUMERO ALMACENADO PARA QUE NO PASE AL SIGUIENTE
					$tipo_factura = pagoFacturaModelo::consultar_tipo_factura($facturas_id)->fetch_assoc();

					if($tipo_factura['tipo_factura'] == 1){
						$secuenciaFacturacion = pagoFacturaModelo::secuencia_facturacion_modelo($empresa_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['numero'];
						$incremento = $secuenciaFacturacion['incremento'];
						$no_factura = $secuenciaFacturacion['prefijo']."".str_pad($secuenciaFacturacion['numero'], $secuenciaFacturacion['relleno'], "0", STR_PAD_LEFT);
					}else{
						$secuenciaFacturacion = pagoFacturaModelo::consultar_numero_factura($facturas_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['number'];				
					}

					//ACTUALIZAMOS EL ESTADO DE LA FACTURA Y EL NUMERO DE FACTURACION
					$datos_update_factura = [
						"facturas_id" => $facturas_id,
						"estado" => $estado_factura,
						"number" => $numero,
					];	

					pagoFacturaModelo::actualizar_factura($datos_update_factura);

					//ACTUALIZAMOS EL NUMERO SIGUIENTE DE LA SECUENCIA PARA LA FACTURACION, SIEMPRE QUE LA FACTURA SEA AL CONTADO
					if($tipo_factura['tipo_factura'] == 1){
						$numero += $incremento;
						pagoFacturaModelo::actualizar_secuencia_facturacion_modelo($secuencia_facturacion_id, $numero);		
					}

					$alert = [
						"alert" => "clear_pay",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formTransferenciaBill",
						"id" => "proceso_pagos",
						"valor" => "Registro",	
						"funcion" => "printBill(".$facturas_id.",".$print_comprobante.");listar_cuentas_por_cobrar_clientes();mailBill(".$facturas_id.");",
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
		
			return mainModel::sweetAlert($alert);
		}		
	
		//PAGO CON CHEQUE
		public function agregar_pago_factura_controlador_cheque(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
			
			$facturas_id = $_POST['factura_id_cheque'];
			$print_comprobante = $_POST['comprobante_print'];
			$consulta_fecha_factura = pagoFacturaModelo::consultar_factura_fecha($facturas_id)->fetch_assoc();
			$fecha = date("Y-m-d");
			$importe = $_POST['monto_efectivo'];
			$cambio = 0;
			$empresa_id = $_SESSION['empresa_id_sd'];			
			$tipo_pago_id = 4;//CHEQUE		
			$banco_id = $_POST['bk_nm_chk'];
			$tipo_pago = 1;//1. CONTADO 2. CRÉDITO			
			$estado_factura = 2;//PAGADA
			$efectivo = 0;
			$tarjeta = 	0;				
			
			$referencia_pago1 = mainModel::cleanStringConverterCase($_POST['check_num']);//TARJETA DE CREDITO
			$referencia_pago2 = "";
			$referencia_pago3 = "";
			
			$usuario = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");
			$estado = 1;
			
			$datos = [
				"facturas_id" => $facturas_id,
				"fecha" => $fecha,
				"importe" => $importe,
				"cambio" => $cambio,
				"usuario" => $usuario,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,
				"empresa" => $empresa_id,
				"tipo_pago" => $tipo_pago,
				"efectivo" => $efectivo,
				"tarjeta" => $tarjeta						
			];
			
			$result_valid_pagos_facturas = pagoFacturaModelo::valid_pagos_factura($facturas_id);
			
			//VERIFICAMOS QUE NO SE HA INGRESADO EL PAGO, SI NO SE HA REALIZADO EL INGRESO, PROCEDEMOS A ALMACENAR EL PAGO
			if($result_valid_pagos_facturas->num_rows==0){
				$query = pagoFacturaModelo::agregar_pago_factura_modelo($datos);

				if($query){
					//ACTUALIZAMOS EL DETALLE DEL PAGO
					$consulta_pago = pagoFacturaModelo::consultar_codigo_pago_modelo($facturas_id)->fetch_assoc();
					$pagos_id = $consulta_pago['pagos_id'];
												
					$datos_pago_detalle = [
						"pagos_id" => $pagos_id,
						"tipo_pago_id" => $tipo_pago_id,
						"banco_id" => $banco_id,
						"efectivo" => $importe,
						"descripcion1" => $referencia_pago1,
						"descripcion2" => $referencia_pago2,
						"descripcion3" => $referencia_pago3,
					];	
					
					$result_valid_pagos_detalles_facturas = pagoFacturaModelo::valid_pagos_detalles_facturas($pagos_id, $tipo_pago_id);
					
					//VALIDAMOS QUE NO EXISTA EL DETALLE DEL PAGO, DE NO EXISTIR SE ALMACENA EL DETALLE DEL PAGO
					if($result_valid_pagos_detalles_facturas->num_rows==0){
						pagoFacturaModelo::agregar_pago_detalles_factura_modelo($datos_pago_detalle);
					}	
														
					//ACTUALIZAMOS EL ESTADO DE LA FACTURA
					pagoFacturaModelo::update_status_factura($facturas_id);
					
					//VERIFICAMOS SI ES UNA CUENTA POR COBRAR, DE SERLO ACTUALIZAMOS EL ESTADO DEL PAGO PARA LA CUENTA POR COBRAR
					$result_cxc_clientes = pagoFacturaModelo::consultar_factura_cuentas_por_cobrar($facturas_id);
					
					if($result_cxc_clientes->num_rows>0){
						pagoFacturaModelo::update_status_factura_cuentas_por_cobrar($facturas_id);
					}
					
					//VALIDAMOS EL TIPO DE FACTURA, SI ES AL CONTADO, VERIFICAMOS EL NUMERO DE FACTURA QUE SIGUE, SI ES AL CREDITO, SOLO CONSULTAMOS EL ULTIMO NUMERO ALMACENADO PARA QUE NO PASE AL SIGUIENTE
					$tipo_factura = pagoFacturaModelo::consultar_tipo_factura($facturas_id)->fetch_assoc();

					if($tipo_factura['tipo_factura'] == 1){
						$secuenciaFacturacion = pagoFacturaModelo::secuencia_facturacion_modelo($empresa_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['numero'];
						$incremento = $secuenciaFacturacion['incremento'];
						$no_factura = $secuenciaFacturacion['prefijo']."".str_pad($secuenciaFacturacion['numero'], $secuenciaFacturacion['relleno'], "0", STR_PAD_LEFT);
					}else{
						$secuenciaFacturacion = pagoFacturaModelo::consultar_numero_factura($facturas_id)->fetch_assoc();
						$secuencia_facturacion_id = $secuenciaFacturacion['secuencia_facturacion_id'];
						$numero = $secuenciaFacturacion['number'];				
					}

					//ACTUALIZAMOS EL ESTADO DE LA FACTURA Y EL NUMERO DE FACTURACION
					$datos_update_factura = [
						"facturas_id" => $facturas_id,
						"estado" => $estado_factura,
						"number" => $numero,
					];	

					pagoFacturaModelo::actualizar_factura($datos_update_factura);

					//ACTUALIZAMOS EL NUMERO SIGUIENTE DE LA SECUENCIA PARA LA FACTURACION, SIEMPRE QUE LA FACTURA SEA AL CONTADO
					if($tipo_factura['tipo_factura'] == 1){
						$numero += $incremento;
						pagoFacturaModelo::actualizar_secuencia_facturacion_modelo($secuencia_facturacion_id, $numero);		
					}
										
					$alert = [
						"alert" => "clear_pay",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formTransferenciaBill",
						"id" => "proceso_pagos",
						"valor" => "Registro",	
						"funcion" => "printBill(".$facturas_id.",".$print_comprobante.");listar_cuentas_por_cobrar_clientes();mailBill(".$facturas_id.");",
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
		
			return mainModel::sweetAlert($alert);
		}	

		public function cancelar_pago_controlador(){
			$pagos_id = $_POST['pagos_id'];
			
			$query = facturasModelo::cancelar_pago_modelo($pagos_id);
			
			if($query){
				$alert = [
					"alert" => "clear",
					"title" => "Registro eliminado",
					"text" => "El registro se ha eliminado correctamente",
					"type" => "success",
					"btn-class" => "btn-primary",
					"btn-text" => "¡Bien Hecho!",
					"form" => "",	
					"id" => "",
					"valor" => "Cancelar",
					"funcion" => "modal_pagos"
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
			
			return mainModel::sweetAlert($alert);			
		}
	}