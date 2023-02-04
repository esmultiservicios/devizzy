<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$datos = [
		"estado" => $_POST['estado'],	
		"pago_planificado" => $_POST['pago_planificado'],
	];	

	$result = $insMainModel->getNomina($datos);
	
	$arreglo = array();
	$data = array();
	$neto_importe = 0;	

	while($row = $result->fetch_assoc()){
		$neto_importe += $row['importe'];

		$data[] = array( 
			"nomina_id"=>$row['nomina_id'],
			"empresa"=>$row['empresa'],
			"fecha_inicio"=>$row['fecha_inicio'],
			"fecha_fin"=>$row['fecha_fin'],
			"importe"=>$row['importe'],
			"notas"=>$row['notas']	,
			"detalle"=>$row['detalle'],
			"pago_planificado_id"=>$row['pago_planificado_id'],
			"estado"=>$row['estado'],
			"neto_importe"=>$neto_importe,	
			"empresa_id"=>$row['empresa_id'],	
		);			
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);