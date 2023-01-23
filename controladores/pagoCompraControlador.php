<?php
    if($peticionAjax){
        require_once "../modelos/pagoCompraModelo.php";
    }else{
        require_once "./modelos/pagoCompraModelo.php";
    }
	
	class pagoCompraControlador extends pagoCompraModelo{
		public function agregar_pago_compra_controlador_efectivo(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$compras_id = $_POST['compras_id_efectivo'];
			$consulta_fecha_compra = pagoCompraModelo::consultar_compra_fecha($compras_id)->fetch_assoc();
			$fecha = $_POST['fecha_compras_efectivo'];
			$importe = $_POST['monto_efectivoPurchase'];
			$abono = isset($_POST['efectivo_Purchase']) ? $_POST['efectivo_Purchase'] : 0;
			$cambio = $_POST['cambio_efectivoPurchase'];
			$empresa_id = $_SESSION['empresa_id_sd'];	
			$banco_id = 0;//SIN BANCO	
			$tipo_pago = $_POST['tipo_factura'];//1. CONTADO 2. CRÉDITO
			$metodo_pago = 1; //EFECTIVO
			$efectivo = 0;
			$tarjeta = 	0;			
			$multiple_pago = $_POST['multiple_pago'];
					
			$referencia_pago1 = "";
			$referencia_pago2 = "";
			$referencia_pago3 = "";
			$colaboradores_id = $_SESSION['colaborador_id_sd'];

			if($_POST['usuario_efectivo_compras'] == 0){
				$usuario = $_SESSION['colaborador_id_sd'];
			}else{
				$usuario = $_POST['usuario_efectivo_compras'];
			}
			
			$fecha_registro = date("Y-m-d H:i:s");
			$estado = 1;
			
			$datos = [
				"multiple_pago" => isset($_POST['multiple_pago']) ? $_POST['multiple_pago'] : 0,
				"compras_id" => $compras_id,
				"fecha" => $fecha,
				"importe" => $importe,
				"abono" => $abono,
				"cambio" => $cambio,
				"usuario" => $usuario,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,
				"empresa" => $empresa_id,
				"tipo_pago" => $tipo_pago,
				"metodo_pago" => 1, //efectivo
				"efectivo" => isset($_POST['efectivo_Purchase'])? $_POST['efectivo_Purchase'] : $_POST['monto_efectivoPurchase'],
				"tarjeta" => 0,
				"banco_id" => $banco_id,
				"referencia_pago1" => $referencia_pago1,
				"referencia_pago2" => $referencia_pago2,
				"referencia_pago3" => $referencia_pago3,
			];

			$alert = pagoCompraModelo::agregar_pago_compras_base($datos);

			return mainModel::sweetAlert($alert);
		}
		
		public function agregar_pago_compra_controlador_tarjeta(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
			
			if($_POST['usuario_tarjeta_compras'] == 0){
				$usuario = $_SESSION['colaborador_id_sd'];
			}else{
				$usuario = $_POST['usuario_tarjeta_compras'];
			}

			$datos = [
				"multiple_pago" => $_POST['multiple_pago'],
				"compras_id" =>$_POST['compras_id_tarjeta'],
				"fecha" => $_POST['fecha_compras_tarjeta'],
				"importe" => $_POST['monto_efectivoPurchase'],
				"abono" => isset($_POST['monto_efectivo']) ? $_POST['monto_efectivo'] : 0,
				"cambio" => 0,
				"usuario" => $usuario,
				"estado" => 1,
				"fecha_registro" => date("Y-m-d H:i:s"),
				"empresa" =>  $_SESSION['empresa_id_sd'],
				"tipo_pago" => $_POST['tipo_factura'],//1. CONTADO 2. CRÉDITO
				"metodo_pago" => 2,//TARJETA
				"efectivo" => 0,
				"tarjeta" => isset($_POST['monto_efectivo']) ? $_POST['monto_efectivo'] :  $_POST['monto_efectivoPurchase'],
				"banco_id" => 0,
				"referencia_pago1" => mainModel::cleanStringConverterCase($_POST['cr_Purchase']),//TARJETA DE CREDITO
				"referencia_pago2" => mainModel::cleanStringConverterCase($_POST['exp']),//FECHA DE EXPIRACION
				"referencia_pago3" => mainModel::cleanStringConverterCase($_POST['cvcpwd'])//NUMERO DE APROBACIÓN
			];

			$alert = pagoCompraModelo::agregar_pago_compras_base($datos);
			return mainModel::sweetAlert($alert);

		}

		//MIXTO
		public function agregar_pago_compra_controlador_mixto(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$compras_id = $_POST['compras_id_mixto'];
			$consulta_fecha_compra = pagoCompraModelo::consultar_compra_fecha($compras_id)->fetch_assoc();
			$fecha = $_POST['fecha_compras_tarjeta'];
			$importe = $_POST['fecha_compras_mixto'];
			$efectivo = $_POST['efectivo_bill'];
			$cambio = $_POST['cambio_efectivo'];
			$empresa_id = $_SESSION['empresa_id_sd'];	
			$tarjeta = 	$_POST['monto_tarjeta'];	
			$tipo_pago_id = 5;//mixto			
			$banco_id = 0;//SIN BANCO	
			$tipo_pago = 1;//1. CONTADO 2. CRÉDITO 3.mixto	

			$referencia_pago1 = mainModel::cleanStringConverterCase($_POST['cr_Purchase']);//TARJETA DE CREDITO
			$referencia_pago2 = mainModel::cleanStringConverterCase($_POST['exp']);//FECHA DE EXPIRACION
			$referencia_pago3 = mainModel::cleanStringConverterCase($_POST['cvcpwd']);//NUMERO DE APROBACIÓN
			
			if($_POST['usuario_mixto_compras'] == 0){
				$usuario = $_SESSION['colaborador_id_sd'];
			}else{
				$usuario = $_POST['usuario_mixto_compras'];
			}

			$colaboradores_id = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");
			$estado = 1;
			
			$datos = [
				"multiple_pago" => $_POST['multiple_pago'],
				"compras_id" => $compras_id,
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
			
			$result_valid_pagos_compras = pagoCompraModelo::valid_pagos_compras($compras_id);
			
			//VERIFICAMOS QUE NO SE HA INGRESADO EL PAGO, SI NO SE HA REALIZADO EL INGRESO, PROCEDEMOS A ALMACENAR EL PAGO
			if($result_valid_pagos_compras->num_rows==0){
				$query = pagoCompraModelo::agregar_pago_compras_modelo($datos);

				if($query){
					//ACTUALIZAMOS EL DETALLE DEL PAGO
					$consulta_pago = pagoCompraModelo::consultar_codigo_pago_modelo($compras_id)->fetch_assoc();
					$pagoscompras_id = $consulta_pago['pagoscompras_id'];
												
					$datos_pago_detalle = [
						"pagoscompras_id" => $pagoscompras_id,
						"tipo_pago_id" => $tipo_pago_id,
						"banco_id" => $banco_id,
						"efectivo" => $importe,
						"descripcion1" => $referencia_pago1,
						"descripcion2" => $referencia_pago2,
						"descripcion3" => $referencia_pago3,			
					];	

					$result_valid_pagos_detalles_compras = pagoCompraModelo::valid_pagos_detalles_compras($pagoscompras_id, $tipo_pago_id);
					
					//VALIDAMOS QUE NO EXISTA EL DETALLE DEL PAGO, DE NO EXISTIR SE ALMACENA EL DETALLE DEL PAGO
					if($result_valid_pagos_detalles_compras->num_rows==0){
						pagoCompraModelo::agregar_pago_detalles_compras_modelo($datos_pago_detalle);
					}
					
					//ACTUALIZAMOS EL ESTADO DE LA FACTURA
					pagoCompraModelo::update_status_compras($compras_id);
					
					//VERIFICAMOS SI ES UNA CUENTA POR COBRAR, DE SERLO ACTUALIZAMOS EL ESTADO DEL PAGO PARA LA CUENTA POR COBRAR
					$result_cxp_clientes = pagoCompraModelo::consultar_compra_cuentas_por_pagar($compras_id);
					
					if($result_cxp_clientes->num_rows>0){
						pagoCompraModelo::update_status_compras_cuentas_por_pagar($compras_id);
					}
					
					/**###########################################################################################################*/
					//CONSULTAMOS EL SUBTOTAL, ISV, DESCUENTO, NC Y TOTAL EN LOS COMPRAS DETALLES
					$resultDetallesCompras = pagoCompraModelo::consulta_detalle_compras($compras_id);

					$total_despues_isvMontoTipoPago = 0;
					$isv_neto = 0;
					$descuentos = 0;
					$total_antes_isvMontoTipoPago = 0;
					$nc = 0;

					while($dataDetallesCompra = $resultDetallesCompras->fetch_assoc()){
						$total_despues_isvMontoTipoPago = $dataDetallesCompra['monto'];
						$isv_neto = $dataDetallesCompra['isv_valor'];
						$descuentos = $dataDetallesCompra['descuento'];
						$total_antes_isvMontoTipoPago = ($total_despues_isvMontoTipoPago - $isv_neto) - $descuentos;
					}
					
					//CONSULTAMOS LA CUENTA_ID SEGUN EL TIPO DE PAGO
					$consulta_fecha_compra = pagoCompraModelo::consultar_cuenta_contabilidad_tipo_pago($tipo_pago_id)->fetch_assoc();
					$cuentas_id = $consulta_fecha_compra['cuentas_id'];

					//CONSULTAMOS EL PROVEEDOR
					$consulta_fecha_compra = pagoCompraModelo::consultar_proveedor_id_compra($compras_id)->fetch_assoc();
					$proveedores_id = $consulta_fecha_compra['proveedores_id'];	
					$factura = $consulta_fecha_compra['factura'];				
					$tipo_egreso = 1;//COMPRA
					$observacion = "Egresos por compras";

					//AGREGAMOS LOS EGRESOS DE LA COMPRA
					$datosEgresos = [
						"proveedores_id" => $proveedores_id,
						"cuentas_id" => $cuentas_id,
						"empresa_id" => $empresa_id,
						"tipo_egreso" => $tipo_egreso,
						"fecha" => $fecha,
						"factura" => $factura,
						"subtotal" => $total_antes_isvMontoTipoPago,
						"isv" => $isv_neto,
						"descuento" => $descuentos,
						"nc" => $nc,
						"total" => $total_despues_isvMontoTipoPago,
						"observacion" => $observacion,
						"estado" => $estado,
						"fecha_registro" => $fecha_registro,						
						"colaboradores_id" => $colaboradores_id					
					];

					//AGREGAMOS LOS EGRESOS
					$result_valid_egresos = pagoCompraModelo::valid_egresos_cuentas_modelo($datosEgresos);
			
					if($result_valid_egresos->num_rows==0 ){
						pagoCompraModelo::agregar_egresos_contabilidad_modelo($datosEgresos);

						//CONSULTAMOS EL SALDO DISPONIBLE PARA LA CUENTA
						$consulta_ingresos_contabilidad = pagoCompraModelo::consultar_saldo_movimientos_cuentas_contabilidad($cuentas_id)->fetch_assoc();
						$saldo_consulta = $consulta_ingresos_contabilidad['saldo'];	
						$ingreso = 0;
						$egreso = $total_despues_isvMontoTipoPago;
						$saldo = $saldo_consulta - $egreso;
						
						//AGREGAMOS LOS MOVIMIENTOS DE LA CUENTA
						$datos_movimientos = [
							"cuentas_id" => $cuentas_id,
							"empresa_id" => $empresa_id,
							"fecha" => $fecha,
							"ingreso" => $ingreso,
							"egreso" => $egreso,
							"saldo" => $saldo,
							"colaboradores_id" => $usuario,
							"fecha_registro" => $fecha_registro,				
						];
						
						pagoCompraModelo::agregar_movimientos_contabilidad_modelo($datos_movimientos);
					}					
					/**###########################################################################################################*/

					$alert = [
						"alert" => "clear_pay",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formTarjetaPurchase",
						"id" => "proceso_pagosPurchase",
						"valor" => "Registro",	
						"funcion" => "getBancoPurchase();listar_cuentas_por_pagar_proveedores();printPurchase(".$compras_id.");",
						"modal" => "modal_pagosPurchase",
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

		//TRANSFERENCIA
		public function agregar_pago_compra_controlador_transferencia(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
			
			if($_POST['usuario_transferencia_compras'] == 0){
				$usuario = $_SESSION['colaborador_id_sd'];
			}else{
				$usuario = $_POST['usuario_transferencia_compras'];
			}

			$datos = [
				"multiple_pago" => $_POST['multiple_pago'],
				"compras_id" =>$_POST['compras_id_transferencia'],
				"fecha" => $_POST['fecha_compras_transferencia'],
				"importe" => $_POST['monto_efectivoPurchase'],
				"abono" => isset($_POST['importe']) ? $_POST['importe'] : 0,
				"cambio" => 0,
				"usuario" => $usuario,
				"estado" => 1,
				"fecha_registro" => date("Y-m-d H:i:s"),
				"empresa" =>  $_SESSION['empresa_id_sd'],
				"tipo_pago" => $_POST['tipo_factura'],//1. CONTADO 2. CRÉDITO
				"metodo_pago" => 3,//TRASFERENCIA
				"tarjeta" => 0,
				"efectivo" => isset($_POST['importe']) ? $_POST['importe'] :  $_POST['monto_efectivoPurchase'],
				"banco_id" => $_POST['bk_nm'],
				"referencia_pago1" => mainModel::cleanStringConverterCase($_POST['ben_nm']),//TARJETA DE CREDITO
				"referencia_pago2" => '',
				"referencia_pago3" => ''
			];

			$alert = pagoCompraModelo::agregar_pago_compras_base($datos);
			return mainModel::sweetAlert($alert);			
		}		

		//PAGO CON CHEQUE
		public function agregar_pago_compra_controlador_cheque(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}	
			
			if($_POST['usuario_cheque_compras'] == 0){
				$usuario = $_SESSION['colaborador_id_sd'];
			}else{
				$usuario = $_POST['usuario_cheque_compras'];
			}

			$datos = [
				"multiple_pago" => $_POST['multiple_pago'],
				"compras_id" =>$_POST['compras_id_cheque'],
				"fecha" => $_POST['fecha_compras_cheque'],
				"importe" => $_POST['importe'],
				"abono" => isset($_POST['importe']) ? $_POST['importe'] : 0,
				"cambio" => 0,
				"usuario" => $usuario,
				"estado" => 1,
				"fecha_registro" => date("Y-m-d H:i:s"),
				"empresa" =>  $_SESSION['empresa_id_sd'],
				"tipo_pago" => $_POST['tipo_factura'],//1. CONTADO 2. CRÉDITO
				"metodo_pago" => 4,//CHEQUE
				"tarjeta" => 0,
				"efectivo" => isset($_POST['importe']) ? $_POST['importe'] :  $_POST['monto_efectivoPurchase'],
				"banco_id" => $_POST['bk_nm_chk'],
				"referencia_pago1" => mainModel::cleanStringConverterCase($_POST['check_num']),
				"referencia_pago2" => '',
				"referencia_pago3" => ''
			];

			$alert = pagoCompraModelo::agregar_pago_compras_base($datos);
			return mainModel::sweetAlert($alert);

			
			
		}				
		
		public function cancelar_pago_controlador(){
			$pagos_id = $_POST['pagos_id'];
			
			$query = pagoCompraModelo::cancelar_pago_modelo($pagos_id);
			
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
					"funcion" => "modal_pagosPurchase"
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