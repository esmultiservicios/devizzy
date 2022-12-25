<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();
	
	$colaboradores_id = $_POST['colaboradores_id'];
	$result = $insMainModel->getEmpleadoContratoEdit($colaboradores_id);
	$valores2 = $result->fetch_assoc();
	$salario = $valores2['salario'];

	$datos = array(
		0 => $valores2['puesto'],
		1 => $valores2['identidad'],
		2 => $valores2['contrato_id'],
		3 => $salario,	
		4 => $valores2['fecha_ingreso'],
		5 => $valores2['tipo_empleado_id'],
		6 => $valores2['pago_planificado_id']
	);

	echo json_encode($datos);