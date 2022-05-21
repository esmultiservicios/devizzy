<?php
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$fecha = date("Y-m-d");
	$result = $insMainModel->getCambioDolar($fecha);

	$compra = 0;
	$venta = 0;

	if($result->num_rows>0){
		$consulta2 = $result->fetch_assoc();
		$compra = $consulta2['compra'];
		$venta = $consulta2['venta'];
	}else{
		$compra = 1;
		$venta = 1;		
	}

	$datos = array(
		0 => $compra,
		1 => $venta											
	);	

	echo json_encode($datos);	
?>