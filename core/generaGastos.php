<?php
	header("Content-Type: text/html;charset=utf-8");
	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	include_once "dompdf/autoload.inc.php";
	require_once 'pdf/vendor/autoload.php';

	use Dompdf\Dompdf;

	$noFactura = $_GET['egresos_id'];

	//OBTENEMOS LOS DATOS DEL ENCABEZADO DE LA FACTURA
	$result = $insMainModel->getEgresosContablesReporte($noFactura);	
	
	$anulada = '';							

	if($result->num_rows>0){
		$consulta_registro = $result->fetch_assoc();	
		
		$no_factura = $consulta_registro['egresos_id'];

		if($consulta_registro['estado'] == 2){
			$anulada = '<img class="anulada" src="'.SERVERURL.'vistas/plantilla/img/anulado.png" alt="Anulada">';
		}

		ob_start();
		include(dirname('__FILE__').'/gastos.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		
		$dompdf->set_option('isRemoteEnabled', true);

		$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		
		file_put_contents(dirname('__FILE__').'/gastos/gastos_'.$no_factura.'.pdf', $dompdf->output());
		
		// Output the generated PDF to Browser
		$dompdf->stream('gastos_'.$no_factura.'.pdf',array('Attachment'=>0));
		
		exit;	
	}