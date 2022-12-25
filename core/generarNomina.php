<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	$nomina_id = $_POST['nomina_id'];
	$empresa_id = $_POST['empresa_id'];
	
	//CONSULTAMOS EL TOTAL DEL NETO DEL DETALLE DE LA NOMINA
	$result_saldos = $insMainModel->getTotalesNominaDetalle($nomina_id);
	$row_saldos = $result_saldos->fetch_assoc();

	$query = $insMainModel->actualizarNomina($nomina_id, $row_saldos['neto']);

	if($query){
		echo 1;//REGISTRO ACTUALIZADO CORRECTAMENTE
		$insMainModel->actualizarNominaDetalles($nomina_id);

		//CONSULTAMOS LA CUENTA QUE TIENE CONFIGURADA LA NOMINA
		if(!isset($_SESSION['user_sd'])){ 
			session_start(['name'=>'SD']); 
		}
				
		$result_cuenta = $insMainModel->getCuentaNomina("Planilla");
		$row_cuenta = $result_cuenta->fetch_assoc();		
		$cuentas_id = $row_cuenta['cuentas_id'];
		$tipo_egreso = 2;//GASTOS
		$fecha = date("Y-m-d");
		$fecha_registro = date("Y-m-d H:i:s");
		$factura = "Nomina ".$nomina_id;

		//CONSULTAMOS LOS DATOS DE LA NOMINA
		$result_datos_nomina = $insMainModel->getTotalesNominaDetalle($nomina_id);
		$row_datos_nomina = $result_datos_nomina->fetch_assoc();		
		$subtotal = $row_datos_nomina['neto'];
		$isv = 0;	
		$descuento = 0;
		$nc = 0;
		$total = $row_datos_nomina['neto'];
		$estado = 1;
		$observacion = "Pago de Nomina ".$nomina_id;
		$colaboradores_id = $_SESSION['colaborador_id_sd'];

		//REGISTRAMOS LOS GASTOS RELACIONANDO CON LA CUENTA DE LA EMPRESA COMO PROVEEDOR
		$proveedores_id = 1;

		$datos = [
			"proveedores_id" => $proveedores_id,
			"cuentas_id" => $cuentas_id,
			"empresa_id" => $empresa_id,
			"tipo_egreso" => $tipo_egreso,
			"fecha" => $fecha,
			"factura" => $factura,
			"subtotal" => $subtotal,
			"isv" => $isv,
			"descuento" => $descuento,
			"nc" => $nc,
			"total" => $total,
			"observacion" => $observacion,
			"estado" => $estado,
			"fecha_registro" => $fecha_registro,
			"colaboradores_id" => $colaboradores_id								
		];
		
		$resultEgresos = $insMainModel->validEgresosCuentasMainModel($datos);
			
		if($resultEgresos->num_rows==0){
			$query = $insMainModel->agregarEgresosMainModel($datos);
					
			if($query){
				//CONSULTAMOS EL SALDO DISPONIBLE PARA LA CUENTA
				$consulta_ingresos_contabilidad = $insMainModel->consultaSaldoMovimientosMainModel($cuentas_id)->fetch_assoc();
				$saldo_consulta = $consulta_ingresos_contabilidad['saldo'];	
				$ingreso = 0;
				$egreso = $total;
				$saldo = $saldo_consulta - $egreso;

				//AGREGAMOS LOS MOVIMIENTOS DE LA CUENTA
				$datos_movimientos = [
					"cuentas_id" => $cuentas_id,
					"empresa_id" => $empresa_id,
					"fecha" => $fecha,
					"ingreso" => $ingreso,
					"egreso" => $egreso,
					"saldo" => $saldo,
					"colaboradores_id" => $colaboradores_id,
					"fecha_registro" => $fecha_registro,				
				];

				$insMainModel->agregarMovimientosMainModel($datos_movimientos);
			}			
		}
	}else{//EL REGISTRO NO SE HA PODIDO ACTUALIZAR
		echo 2;
	}