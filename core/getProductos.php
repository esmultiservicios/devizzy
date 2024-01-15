<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	$estado = 1;

	$result = $insMainModel->getProductos($estado);
	
	if($result->num_rows>0){
		echo '<option value="0">Todo</option>';
		while($consulta2 = $result->fetch_assoc()){
			 echo '<option value="'.$consulta2['productos_id'].'">'.$consulta2['nombre'].' '.$consulta2['medida'].'</option>';
		}
	}else{
		echo '<option value="">No hay datos que mostrar</option>';
	}
?>