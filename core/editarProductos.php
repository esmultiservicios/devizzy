<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$productos_id  = $_POST['productos_id'];
	$result = $insMainModel->getTipoProductosEdit($productos_id);
	$valores2 = $result->fetch_assoc();
	
	$datos = array(
		0 => $valores2['almacen_id'],
		1 => $valores2['medida_id'],
		2 => $valores2['nombre'],
		3 => $valores2['descripcion'],
		4 => $valores2['cantidad'],
		5 => $valores2['precio_compra'],
		6 => $valores2['precio_venta'],
		7 => $valores2['tipo_producto_id'],
		8 => $valores2['isv_venta'],	
		9 => $valores2['isv_compra'],	
		10 => $valores2['estado'],	
		11 => $valores2['file_name'],	
		12 => $valores2['empresa_id'],	
		13 => $valores2['tipo_producto'],
		14 => $valores2['porcentaje_venta'],	
		15 => $valores2['cantidad_minima'],	
		16 => $valores2['cantidad_maxima'],	
		17 => $valores2['categoria_id'],
		18 => $valores2['precio_mayoreo'],	
		19 => $valores2['cantidad_mayoreo'],
		20 => $valores2['barCode'],		
	);
	echo json_encode($datos);