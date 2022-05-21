<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getEmpresa();
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"empresa_id"=>$row['empresa_id'],
			"razon_social"=>$row['razon_social'],
			"nombre"=>$row['nombre'],
			"telefono"=>$row['telefono'],
			"correo"=>$row['correo'],
			"rtn"=>$row['rtn'],
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