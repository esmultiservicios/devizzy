<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$datos = [
		"tipo_busqueda" => $_POST['tipo_busqueda'],
		"fechai" => $_POST['fechai'],
		"fechaf" => $_POST['fechaf'],		
	];	

	$result = $insMainModel->getCuentasporCobrarClientes($datos);
	
	$arreglo = array();
	$data = array();

	$credito = 0.00;
	$abono = 0.00;
	$saldo = 0.00;

	while($row = $result->fetch_assoc()){
		$resultAbonos = $insMainModel->getAbonosCobrarClientes($row['facturas_id']);
		$rowAbonos = $resultAbonos->fetch_assoc();

		if ($rowAbonos['total'] != null || $rowAbonos['total'] != ""){
			$abono = $rowAbonos['total'];
		}else{
			$abono = 0.00;
		}

		$credito = $row['saldo'];
		$saldo = $row['saldo'] - $abono;

		$data[] = array( 
			"cobrar_clientes_id"=>$row['cobrar_clientes_id'],
			"facturas_id"=>$row['facturas_id'],
			"fecha"=>$row['fecha'],
			"cliente"=>$row['cliente'],
			"numero"=>$row['numero'],
			"credito"=>'L. '.$credito,
			"abono"=>'L. '.$abono,						
			"saldo"=>'L. '.$saldo		  
		);		
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);