<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	$result = $insMainModel->getAlmacen();
	
	$arreglo = array();
	$data = array();

	while($row = $result->fetch_assoc()){
		$data[] = array( 
			"almacen_id"=>$row['almacen_id'],
			"empresa"=>$row['empresa'],
			"almacen"=>$row['almacen'],
			"ubicacion"=>$row['ubicacion']		  
		);
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);