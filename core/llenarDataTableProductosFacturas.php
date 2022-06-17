<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	$datos = [
		"bodega" => $_POST['bodega'],
		"barcode" => '',	
	];
	
	$result = $insMainModel->getProductosFacturas($datos);
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"productos_id"=>$row['productos_id'],
			"barCode"=>$row['barCode'],
			"nombre"=>$row['nombre'],
			"cantidad"=>$row['cantidad'],
			"medida"=>$row['medida'],
			"tipo_producto_id"=>$row['tipo_producto_id'],
			"precio_venta"=>$row['precio_venta'],
			"almacen"=>$row['almacen'],
			"almacen_id"=>$row['almacen_id'],
			"tipo_producto"=>$row['tipo_producto'],
			"impuesto_venta"=>$row['impuesto_venta'],
			"precio_mayoreo"=>$row['precio_mayoreo'],
			"cantidad_mayoreo"=>$row['cantidad_mayoreo']	
		);		
	}
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);