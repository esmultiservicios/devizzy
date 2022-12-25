<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getClientes();
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"clientes_id"=>$row['clientes_id'],
			"cliente"=>$row['cliente'],
			"rtn"=>$row['rtn'],
			"localidad"=>$row['localidad'],
			"telefono"=>$row['telefono'],
			"correo"=>$row['correo'],
			"departamento"=>$row['departamento'],
			"municipio"=>$row['municipio']			
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