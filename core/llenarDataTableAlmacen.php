<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	$result = $insMainModel->getAlmacen();
	
	$arreglo = array();
	$data = array();
	$facturar_cero = 'No';

	while($row = $result->fetch_assoc()){
		if($row['facturar_cero'] == 1){
			$facturar_cero = 'Si';
		}elseif($row['facturar_cero'] == 0){
			$facturar_cero = 'No';
		}
		$data[] = array( 
			"almacen_id"=>$row['almacen_id'],
			"empresa"=>$row['empresa'],
			"facturarCero"=>$facturar_cero,
			"almacen"=>$row['almacen'],

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