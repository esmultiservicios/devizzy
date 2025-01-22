<?php
	header("Content-Type: text/html;charset=utf-8");
	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	include_once "dompdf/vendor/autoload.php";

	use Dompdf\Dompdf;
	use Dompdf\Options;

	$noFactura = $_GET['facturas_id'];
	$formato = $_GET['formato'];  // Recibimos el formato (Carta, Ticket, Media Carta)

	//OBTENEMOS LOS DATOS DEL ENCABEZADO DE LA FACTURA
	$result = $insMainModel->getFactura($noFactura);
	
	//OBTENEMOS LAS FORMAS DE PAGO
	$result_metodos_pago = $insMainModel->getMetodoPagoFactura($noFactura);	
	
	$anulada = '';
	$logotipo = '';
	$firma_documento = '';

	//OBTENEMOS LOS DATOS DEL DETALLE DE FACTURA
	$result_factura_detalle = $insMainModel->getDetalleFactura($noFactura);								

	//CONSULTAMOS SI LA FACTURA ESTA EN PROFORMA
	$facturaTitle = "Factura";
	$proformaUso = 0;

	$resultProforma = $insMainModel->getConsultaFacturaProforma($noFactura);	
	if($resultProforma->num_rows>0){
		$consultaProforma = $resultProforma->fetch_assoc();
		$facturaTitle = "Factura Proforma";
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

		// Verificamos el formato y incluimos el archivo correspondiente
		if ($formato == 'Carta') {
			include(dirname('__FILE__') . '/plantilla_factura_carta.php');
			$formatoArchivo = 'carta';
		} elseif ($formato == 'Ticket') {
			include(dirname('__FILE__') . '/plantilla_factura_ticket.php');
			$formatoArchivo = 'ticket';
		} elseif ($formato == 'Media Carta') {
			include(dirname('__FILE__') . '/plantilla_factura_media_carta.php'); 
			$formatoArchivo = 'media_carta';
		}
		
		$html = ob_get_clean();

		$options = new Options();
		$options->set('isHtml5ParserEnabled', true);
		$options->set('isRemoteEnabled', true);
		
		// Verificamos si el formato es 'Ticket' para aplicar la configuración
		if ($formato == 'Ticket') {
			// Configuración para Ticket
			$options->set('margin-bottom', 0);
			$options->set('margin-left', 0);
			
			$dompdf = new Dompdf($options);
			// Establecer tamaño para el ticket
			$dompdf->setPaper(array(0, 0, 210, 1000), 'portrait'); // Ajusta las dimensiones según el ancho y alto del ticket
		} elseif ($formato == 'Media Carta') {
			// Configuración para Media Carta
			$options->set('margin-bottom', 0);
			$options->set('margin-left', 0);
			$dompdf = new Dompdf($options);
			// Media Carta es la mitad de carta: 5.5 x 8.5 pulgadas
			$dompdf->setPaper(array(0, 0, 612, 396), 'portrait'); // Media Carta: Ancho igual, alto dividido entre 2
		} else {
			// Configuración predeterminada para otros formatos (Carta completa)
			$dompdf = new Dompdf($options);
			$dompdf->setPaper('letter', 'portrait');
		}		

		$dompdf->loadHtml($html);
		// Renderizar el HTML como PDF
		$dompdf->render();
		
		// Guardar el PDF en el servidor (opcional)
		//file_put_contents(dirname('__FILE__').'/facturas/factura_'.$no_factura.'.pdf', $dompdf->output());
		
		// Mostrar el PDF en el navegador
		$dompdf->stream('factura_'.$no_factura.'_'.$consulta_registro['cliente'].'.pdf',array('Attachment'=>0));
		
		exit;	
	}