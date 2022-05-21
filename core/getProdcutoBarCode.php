<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$barcode  = $_POST['barcode'];
	
	$result = $insMainModel->getProductoBarCodeBill($barcode);
	$valores2 = $result->fetch_assoc();
	
	$datos = array(
		0 => $valores2['nombre'],
		1 => $valores2['precio_venta'],	
		2 => $valores2['productos_id'],	
		3 => $valores2['isv_venta'],
		4 => $valores2['cantidad_mayoreo'],
		5 => $valores2['precio_mayoreo'],		
	);
	echo json_encode($datos);
	