<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	require_once "Database.php";
	
	$insMainModel = new mainModel();
	$database = new Database();
		
	$estado = isset($_POST['estado']) ? $_POST['estado'] : 1;
	$result = $insMainModel->getClientes($estado);
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){	
		$sistema_nombre = "";

		//CONSULTAMOS EL NOMBRE DEL SISTEMA
		if($row['sistema_id'] !== "") {
			$tablaSistema = "sistema";
			$camposSistema = ["nombre"];
			$condicionesSistema = ["sistema_id" => $row['sistema_id']];
			$orderBy = "";
			$tablaJoin = "";
			$condicionesJoin = [];
			$resultadoSistema = $database->consultarTabla($tablaSistema, $camposSistema, $condicionesSistema, $orderBy, $tablaJoin, $condicionesJoin);			
	
			if (!empty($resultadoSistema)) {
				$sistema_nombre = trim($resultadoSistema[0]['nombre']);
			}
		}
		
		$data[] = array( 
			"clientes_id"=>$row['clientes_id'],
			"cliente"=>$row['cliente'],
			"rtn"=>$row['rtn'],
			"localidad"=>$row['localidad'],
			"telefono"=>$row['telefono'],
			"correo"=>$row['correo'],
			"departamento"=>$row['departamento'],
			"municipio"=>$row['municipio'],
			"sistema"=>$sistema_nombre,
			"eslogan" => $row['eslogan'],
			"otra_informacion" => $row['otra_informacion'],
			"whatsapp" => $row['whatsapp'],
			"empresa" => $row['empresa'],
			"sistema_id" => $row['sistema_id'],
			"planes_id" => $row['planes_id'],
			"db" => $row['db']
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