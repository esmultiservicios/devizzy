<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$datos = [
		"estado" => $_POST['estado'],	
		"colaboradores_id" => $_POST['colaborador'],
		"fechai" => $_POST['fechai'],
		"fechaf" => $_POST['fechaf'],
	];	

	$result = $insMainModel->getAsistencia($datos);
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"empleado"=>$row['empleado'],
			"lunes"=>$row['lunes'] == 0 ? 'No' : 'Sí',
			"martes"=>$row['martes'] == 0 ? 'No' : 'Sí',
			"miercoles"=>$row['miercoles'] == 0 ? 'No' : 'Sí',
			"jueves"=>$row['jueves'] == 0 ? 'No' : 'Sí',
			"viernes"=>$row['viernes'] == 0 ? 'No' : 'Sí',	
			"sabado"=>$row['sabado'] == 0 ? 'No' : 'Sí',
			"domingo"=>$row['domingo'] == 0 ? 'No' : 'Sí',
			"total"=>$row['total']					
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