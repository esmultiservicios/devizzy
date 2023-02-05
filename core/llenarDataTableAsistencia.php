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
			"asistencia_id"=>$row['asistencia_id'],
			"fecha"=>$row['fecha'],
			"colaborador"=>$row['colaborador'],
			"colaborador_id"=>$row['colaborador_id'],
			"estado"=>$row['estado'],
			"colaborador_id"=>$row['colaborador_id'],				
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