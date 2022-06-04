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

	$result = $insMainModel->getCuentasporPagarProveedores($datos);
	
	$arreglo = array();
	$data = array();

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

		$credito = $row['saldo'];
		$saldo = $row['saldo'] - $abono;
								
		$data[] = array( 
			"pagar_proveedores_id"=>$row['pagar_proveedores_id'],
			"compras_id"=>$row['compras_id'],
			"fecha"=>$row['fecha'],
			"proveedores"=>$row['proveedores'],
			"factura"=>$row['factura'],
			"credito"=>'L. '.$credito,
			"abono"=>'L. '.$abono,			
			"saldo"=>'L. '.$row['saldo']		  
		);		
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);