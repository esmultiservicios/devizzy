<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	$datos = [
		"tipo_producto_id" => $_POST['tipo_producto_id'],
		//"fechai" => $_POST['fechai'],
		//"fechaf" => $_POST['fechaf'],
		"bodega" => $_POST['bodega'] 		
	];	
	
	$result = $insMainModel->getTranferenciaProductos($datos);
	
	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"fecha_registro"=>$row['fecha_registro'],
			"barCode"=>$row['barCode'],
			"producto"=>$row['producto'],
			"medida"=>$row['medida'],
			"movimientos_id"=>$row['movimientos_id'],
			"entrada"=>$row['entrada'],
			"salida"=>$row['salida'],
			"saldo"=>$row['saldo'],
			"bodega"=>$row['bodega'],
			"id_bodega"=>$row['almacen_id'],
			"productos_id"=>$row['productos_id'],
			"superior"=>$row['id_producto_superior']			
		
		);	
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);