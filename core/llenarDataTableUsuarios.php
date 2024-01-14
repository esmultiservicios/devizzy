<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	require_once "Database.php";
	
	$insMainModel = new mainModel();
	
	if(!isset($_SESSION['user_sd'])){ 
		session_start(['name'=>'SD']); 
	}
	
	$database = new Database();
	
	$tablaPrivilegio = "privilegio";
	$camposPrivilegio = ["nombre"];
	$condicionesPrivilegio = ["privilegio_id" => $_SESSION['privilegio_sd']];
	$orderBy = "";
	$tablaJoin = "";
	$condicionesJoin = [];
	$resultadoPrivilegio = $database->consultarTabla($tablaPrivilegio, $camposPrivilegio, $condicionesPrivilegio, $orderBy, $tablaJoin, $condicionesJoin);

	$privilegio_colaborador = "";

	if (!empty($resultadoPrivilegio)) {
		$privilegio_colaborador = $resultadoPrivilegio[0]['nombre'];
	}

	$datos = [
		"privilegio_id" => $_SESSION['privilegio_sd'],
		"colaborador_id" => $_SESSION['colaborador_id_sd'],	
		"privilegio_colaborador" => $privilegio_colaborador,	
		"empresa_id" => $_SESSION['empresa_id_sd'],
		"db_cliente" => $_SESSION['db_cliente']
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
			"privilegio"=>$row['privilegio'],
			"estado"=>$row['estado'],
			"empresa"=>$row['empresa'],		
			"server_customers_id"=>$row['server_customers_id']
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