<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$datos = [
		"estado" => $_POST['estado'],
		"proveedores_id" => $_POST['proveedores_id'],		
		"fechai" => $_POST['fechai'],
		"fechaf" => $_POST['fechaf'],		
	];	

	$result = $insMainModel->getCuentasporPagarProveedores($datos);
	
	$arreglo = array();
	$data = array();
	$estadoColor = 'bg-warning';
	$credito = 0.00;
	$abono = 0.00;
	$saldo = 0.00;
	
	while($row = $result->fetch_assoc()){
		$resultAbonos = $insMainModel->getAbonosPagarProveedores($row['compras_id']);
		$rowAbonos = $resultAbonos->fetch_assoc();

		if ($rowAbonos['total'] != null || $rowAbonos['total'] != ""){
			$abono = $rowAbonos['total'];
		}else{
			$abono = 0.00;
		}

		$credito = $row['importe'];
		$saldo = $row['importe'] - $abono;
					
		if($row['estado'] == 2){
			$estadoColor = 'bg-c-green';
		}

		$data[] = array( 
			"compras_id"=>$row['compras_id'],
			"fecha"=>$row['fecha'],
			"proveedores"=>$row['proveedores'],
			"factura"=>$row['factura'],
			"credito"=>'L. '.$credito,
			"abono"=>'L. '.$abono,			
			"saldo"=>$saldo,
			"color"=> $estadoColor,
			"estado"=>$row['estado'],
			"total_credito"=> number_format($credito,2),
			"total_abono"=>number_format($abono,2),
			"total_pendiente"=> number_format($saldo,2)		  
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