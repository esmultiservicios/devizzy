<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$datos = [
		"estado" => $_POST['estado'],
		"clientes_id" => $_POST['clientes_id'],
		"fechai" => $_POST['fechai'],
		"fechaf" => $_POST['fechaf'],		
	];	

	$result = $insMainModel->getCuentasporCobrarClientes($datos);
	
	$arreglo = array();
	$data = array();
	$estadoColor = 'bg-warning';
	$credito = 0.00;
	$abono = 0.00;
	$saldo = 0.00;
	$totalCredito = 0;
	$totalAbono = 0;
	$totalPendiente = 0;

	while($row = $result->fetch_assoc()){
		$resultAbonos = $insMainModel->getAbonosCobrarClientes($row['facturas_id']);
		$rowAbonos = $resultAbonos->fetch_assoc();

		if ($rowAbonos['total'] != null || $rowAbonos['total'] != ""){
			$abono = $rowAbonos['total'];
		}else{
			$abono = 0.00;
		}

		$credito = $row['importe'];
		$saldo = $row['importe'] - $abono;

		$totalCredito += $credito;
		$totalAbono += $abono;
		$totalPendiente += $saldo;

		if($row['estado'] == 2){
			$estadoColor = 'bg-c-green';
		}

		$data[] = array( 
			"cobrar_clientes_id"=>$row['cobrar_clientes_id'],
			"facturas_id"=>$row['facturas_id'],
			"fecha"=>$row['fecha'],
			"cliente"=> $row['cliente'],
			"numero"=>$row['numero'],
			"credito"=> $credito,
			"abono"=>$abono,						
			"saldo"=>$saldo,
			"color"=> $estadoColor,
			"estado"=>$row['estado'],
			"total_credito"=> number_format($totalCredito,2),
			"total_abono"=>number_format($totalAbono,2),
			"total_pendiente"=> number_format($totalPendiente,2),
			"vendedor"=>$row['vendedor'],
		);		
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);
?>	