<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	$bodega = '';

	if(isset($_POST['bodega'])){
		$bodega = $_POST['bodega'];
	}

	$datos = [
		"bodega" => $bodega,
		"barcode" => '',	
	];
	
	$result = $insMainModel->getProductosCantidad($datos);
	
	$arreglo = array();
	$data = array();
	
	$entradaH = 0;
	$salidaH = 0;
	
	while($row = $result->fetch_assoc()){	
		$result_productos = $insMainModel->getCantidadProductos($row['productos_id']);	
		if($result_productos->num_rows>0){
			while($consulta = $result_productos->fetch_assoc()){
				if($row['almacen_id'] == 0 || $row['almacen_id'] == null){
					$bodega = "Sin bodega";
				}else{
					$bodega = $row['almacen'];
				}

				$data[] = array( 
					"productos_id"=>$row['productos_id'],
					"barCode"=>$row['barCode'],
					"nombre"=>$row['nombre'],
					"cantidad"=>$row['cantidad'],
					"medida"=>$row['medida'],
					"tipo_producto_id"=>$row['tipo_producto_id'],
					"precio_venta"=>$row['precio_venta'],
					"almacen"=>$bodega,
					"almacen_id"=>$row['almacen_id'],
					"tipo_producto"=>$row['tipo_producto'],
					"impuesto_venta"=>$row['impuesto_venta'],
					"precio_mayoreo"=>$row['precio_mayoreo'],
					"cantidad_mayoreo"=>$row['cantidad_mayoreo'],
					"tipo_producto_nombre"=>$row['tipo_producto_nombre'],
					"isv_venta"=>$row['isv_venta'],
					"isv_compra"=>$row['isv_compra']
				);
			}
		}			
	}
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);
?>	