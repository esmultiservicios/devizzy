<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getTotalSuppliers();
	
	$totalSuppliers = 0;
	
	if($result->num_rows>0){
		$consulta2 = $result->fetch_assoc();
		$totalSuppliers = $consulta2['total'];
	}
	
	echo $totalSuppliers;
	