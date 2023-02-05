<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$privilegio_id = $_POST['privilegio_id_accesos'];

	$result = $insMainModel->getSubMenuAccesos($privilegio_id);
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"menu"=>$row['menu'],
			"submenu"=>$row['submenu'],
			"privilegio"=>$row['privilegio'],
			"acceso_submenu_id"=>$row['acceso_submenu_id'],				
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