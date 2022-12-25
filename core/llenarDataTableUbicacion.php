<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getUbicacion();
	
	$arreglo = array();
	$data = array();

	while($row = $result->fetch_assoc()){
		$data[] = array( 
			"ubicacion_id"=>$row['ubicacion_id'],
			"ubicacion"=>$row['ubicacion'],
			"empresa"=>$row['empresa']		  
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