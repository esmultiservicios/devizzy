<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	if(!isset($_SESSION['user_sd'])){ 
		session_start(['name'=>'SD']); 
	}
	
	$datos = [
		"fechai" => $_POST['fechai'],
		"fechaf" => $_POST['fechaf'],
		"estado" => $_POST['estado'],
		"privilegio_id" => $_SESSION['privilegio_sd'],
		"colaborador_id" => $_SESSION['colaborador_id_sd'],	
	];	
	
	$result = $insMainModel->getCajas($datos);
	
	$arreglo = array();
	$importe_venta = 0;
	$neto = 0;
	
	$data = array();
	
	while($row = $result->fetch_assoc()){	
	   $apertura_id = $row['apertura_id'];

	   $result_venta = $insMainModel->getImporteVentaporUsuario($apertura_id);
	   $row1 = $result_venta->fetch_assoc();
	   $importe_venta = $row1['importe'];
	   $factura_inicial = "";   
	   $neto = $importe_venta + $row['monto_apertura'];
	   
	   if($row['factura_inicial'] == ""){
		   $result_facturaInicial = $insMainModel->getFacturaInicial($apertura_id);
		   $row_facturaInicial = $result_facturaInicial->fetch_assoc();
		   $factura_inicial = $row_facturaInicial['prefijo']."".str_pad($row_facturaInicial['numero'], $row_facturaInicial['relleno'], "0", STR_PAD_LEFT);
	   }else{
		   $factura_inicial = $row['factura_inicial'];
	   }
	   
	   $data[] = array( 
	      "apertura_id"=>$apertura_id,
		  "fecha"=>$row['fecha'],
		  "factura_inicial"=>$factura_inicial,
		  "factura_final"=>$row['factura_final'],
		  "caja"=>$row['caja'],
		  "usuario"=>$row['usuario'],
		  "monto_apertura"=>number_format($row['monto_apertura'],2),	
		  "importe_venta"=>number_format($importe_venta, 2),
		  "neto"=>number_format($neto,2)		  
	  );		
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);
?>	