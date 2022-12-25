<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getTotalPurchases();
	
	$totalPurchases = 0;
	
	if($result->num_rows>0){
		$consulta2 = $result->fetch_assoc();
		$totalPurchases = $consulta2['total'];
	}
	
	echo number_format($totalPurchases,2);
?>	