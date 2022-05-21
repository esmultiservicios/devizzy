<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getProductos();
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"productos_id"=>$row['productos_id'],
			"image"=>$row['image'],
			"barCode"=>$row['barCode'],
			"nombre"=>$row['nombre'],
			"cantidad"=>$row['cantidad'],
			"medida"=>$row['medida'],
			"categoria"=>$row['categoria'],
			"precio_compra"=>'L. '.$row['precio_compra'],
			"precio_venta"=>'L. '.$row['precio_venta']		 			
		);			
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);