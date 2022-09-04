<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getProductosCompras();
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"productos_id"=>$row['productos_id'],
			"barCode"=>$row['barCode'],
			"nombre"=>$row['nombre'],
			"cantidad"=>1,
			"medida"=>$row['medida'],
			"tipo_producto"=>$row['tipo_producto'],
			"precio_venta"=>$row['precio_venta'],
			"almacen"=>$row['almacen'],
			"precio_compra"=>$row['precio_compra'],
			"isv_compra"=>$row['isv_compra']		

		);		
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);