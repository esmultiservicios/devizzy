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
	$logotipo = '';
	$firma_documento = '';

	//OBTENEMOS LOS DATOS DEL DETALLE DE FACTURA
	$result_factura_detalle = $insMainModel->getDetalleFactura($noFactura);	
	
	//OBTENEMOS LAS FORMAS DE PAGO
	$result_metodos_pago = $insMainModel->getMetodoPagoFactura($noFactura);	

	//CONSULTAMOS SI LA FACTURA ESTA EN PROFORMA
	$facturaTitle = "Factura";
	$proformaUso = 0;

	$resultProforma = $insMainModel->getConsultaFacturaProforma($noFactura);	
	if($resultProforma->num_rows>0){
		$consultaProforma = $resultProforma->fetch_assoc();
		$facturaTitle = "Factura Profomra";
		$proformaUso = 1;
	}
		
	if($result->num_rows>0){
		$consulta_registro = $result->fetch_assoc();	
		
		$logotipo = $consulta_registro['logotipo'];
		$firma_documento = $consulta_registro['firma_documento'];
		$no_factura = str_pad($consulta_registro['numero_factura'], $consulta_registro['relleno'], "0", STR_PAD_LEFT);

		if($consulta_registro['estado'] == 4){
			$anulada = '<img class="anulada" src="'.SERVERURL.'vistas/plantilla/img/anulado.png" alt="Anulada">';
		}

		ob_start();
		include(dirname('__FILE__').'/ticket.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->set_option('margin-bottom', 0);
		$dompdf->set_option('margin-left', 0); // Ajuste para quitar el borde izquierdo
		$dompdf->set_option('isRemoteEnabled', true);

		$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
		
		//$dompdf->setPaper(array(0, 0, 230, 1000), 'portrait');
		$dompdf->setPaper(array(0, 0, 210, 1000), 'portrait');

		// Render the HTML as PDF
		$dompdf->render();
		
		file_put_contents(dirname('__FILE__').'/facturas/ticket_'.$no_factura.'.pdf', $dompdf->output());
		
		// Output the generated PDF to Browser
		$dompdf->stream('ticket_'.$no_factura.'_'.$consulta_registro['cliente'].'.pdf',array('Attachment'=>0));
		
		exit;	
	}