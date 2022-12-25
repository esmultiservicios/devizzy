<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$ano = date("Y");
	$result = $insMainModel->getFacturasAnual($ano);
	
	$arreglo = array();

	while( $row = $result->fetch_assoc()){	  
	   $arreglo[] = array( 
		  "mes"=>$insMainModel->nombremes(date("m", strtotime($row['fecha']))),
		  "total"=>$row['total'],	  
	  );	  
	}	

	echo json_encode($arreglo);
?>	