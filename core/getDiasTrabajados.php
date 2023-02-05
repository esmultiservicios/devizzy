<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	if(!isset($_SESSION['user_sd'])){ 
	   session_start(['name'=>'SD']); 
	}
	
	$insMainModel = new mainModel();
	$colaboradores_id = $_POST['colaboradores_id'];
	$fecha = date("Y-m-d");
	
	$result = $insMainModel->getDiasTrabajados($colaboradores_id);
	
	if($result->num_rows>0){
		$valores2 = $result->fetch_assoc();
		$dt = $valores2['total'];		
	}		
	$datos = array(
		0 => $dt 					
	);
	echo json_encode($datos);
?>	