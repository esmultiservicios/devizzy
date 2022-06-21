<?php
	header("Content-Type: text/html;charset=utf-8");
	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	include_once "dompdf/autoload.inc.php";
	require_once 'pdf/vendor/autoload.php';

	use Dompdf\Dompdf;

	$noFactura = $_GET['facturas_id'];

	//OBTENEMOS LOS DATOS DEL ENCABEZADO DE LA FACTURA
	$result = $insMainModel->getFactura($noFactura);	
	
	$anulada = '';

	//OBTENEMOS LOS DATOS DEL DETALLE DE FACTURA
	$result_factura_detalle = $insMainModel->getDetalleFactura($noFactura);								

	if($result->num_rows>0){
		$consulta_registro = $result->fetch_assoc();	
		
		$no_factura = str_pad($consulta_registro['numero_factura'], $consulta_registro['relleno'], "0", STR_PAD_LEFT);

		if($consulta_registro['estado'] == 4){
			$anulada = '<img class="anulada" src="'.SERVERURL.'vistas/plantilla/img/anulado.png" alt="Anulada">';
		}

		ob_start();
		include(dirname('__FILE__').'/comprobante.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		
		$dompdf->set_option('isRemoteEnabled', true);

		$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		
		file_put_contents(dirname('__FILE__').'/facturas/comprobante_'.$no_factura.'.pdf', $dompdf->output());
		
		// Output the generated PDF to Browser
		$dompdf->stream('comprobante_'.$no_factura.'_'.$consulta_registro['cliente'].'.pdf',array('Attachment'=>0));
		
		exit;	
	}
?>