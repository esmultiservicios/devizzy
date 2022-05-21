<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getColaboradores();
	
	$arreglo = array();
	$data = array();	
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"colaborador_id"=>$row['colaborador_id'],
			"empresa"=>$row['empresa'],
			"colaborador"=>$row['colaborador'],
			"identidad"=>$row['identidad'],
			"estado"=>$row['estado'],
			"telefono"=>$row['telefono']			
		);		
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);