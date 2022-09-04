<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getProductos();
	
	$arreglo = array();
	$data = array();
	$saldo_productos = 0;
	
	while($row = $result->fetch_assoc()){		
		$result_movimientos = $insMainModel->getSaldoProductosMovimientos($row['productos_id']);
		if($result_movimientos->num_rows>0){
		$consulta = $result_movimientos->fetch_assoc();
		$saldo_productos = $consulta['saldo'];
		}

		$data[] = array( 
			"productos_id"=>$row['productos_id'],
			"image"=>$row['image'],
			"barCode"=>$row['barCode'],
			"nombre"=>$row['nombre'],
			"cantidad"=>$saldo_productos,
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