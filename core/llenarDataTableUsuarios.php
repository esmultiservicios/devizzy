<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	if(!isset($_SESSION['user_sd'])){ 
		session_start(['name'=>'SD']); 
	}
	
	$datos = [
		"privilegio_id" => $_SESSION['privilegio_sd'],
		"colaborador_id" => $_SESSION['colaborador_id_sd'],	
	];	

	$result = $insMainModel->getUsuarios($datos);
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"users_id"=>$row['users_id'],
			"colaborador"=>$row['colaborador'],
			"username"=>$row['username'],
			"correo"=>$row['correo'],
			"tipo_usuario"=>$row['tipo_usuario'],
			"estado"=>$row['estado'],
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