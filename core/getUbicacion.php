<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$result = $insMainModel->getUbicacion();
	
	if($result->num_rows>0){
		while($consulta2 = $result->fetch_assoc()){
			 echo '<option value="'.$consulta2['ubicacion_id'].'">'.$consulta2['ubicacion'].'</option>';
		}
	}else{
		echo '<option value="">Seleccione</option>';
	}
?>	