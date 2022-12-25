<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getSecuenciaFacturacion();
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"secuencia_facturacion_id"=>$row['secuencia_facturacion_id'],
			"empresa"=>$row['empresa'],
			"documento"=>$row['documento'],
			"cai"=>$row['cai'],
			"prefijo"=>$row['prefijo'],
			"siguiente"=>$row['siguiente'],
			"rango_inicial"=>$row['rango_inicial'],
			"rango_final"=>$row['rango_final'],
			"prefijo"=>$row['prefijo'],
			"fecha_limite"=>$row['fecha_limite']			
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