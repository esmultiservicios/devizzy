<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	if(!isset($_SESSION['user_sd'])){ 
	   session_start(['name'=>'SD']); 
	}
	
	$insMainModel = new mainModel();
	if(isset($_SESSION['codigoCliente'])) {
		$codigoCliente = $_SESSION['codigoCliente'];
	}else {
		$codigoCliente = "CLINICARE";
	}
	
	$datos = array(
		0 => $codigoCliente, 					
	);
	
	echo json_encode($datos);
?>