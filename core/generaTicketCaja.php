<?php
	header("Content-Type: text/html;charset=utf-8");
	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	include_once "dompdf/autoload.inc.php";
	require_once 'pdf/vendor/autoload.php';

	use Dompdf\Dompdf;

	$apertura_id = $_GET['apertura_id'];

	//OBTENEMOS LOS DATOS DEL ENCABEZADO DE LA FACTURA
	$result = $insMainModel->getComprobanteCaja($apertura_id);	
	$resultCaja = $insMainModel->getComprobanteCaja($apertura_id);
	$resulFacturasCaja = $insMainModel->getFacturasCaja($apertura_id);	
	
	$anulada = '';
	$logotipo = '';
	$firma_documento = '';	
	$empresa_id = '';
	$montoApertura = 0;	
	$saldoCredito = 0;						

	if($result->num_rows>0){
		$consulta_registro = $result->fetch_assoc();

		$empresa_id = $consulta_registro['empresa_id'];

		//CONSULTAMOS EL MONTO DE LA APERTURA

		$empresa_id = $consulta_registro['empresa_id'];

		//CONSULTAMOS EL MONTO DE APERTURA
		$resultAperturaCaja = $insMainModel->getMontoAperturaCaja($apertura_id);
		$consulta_AperturaCaja = $resultAperturaCaja->fetch_assoc();
		$montoApertura = $consulta_AperturaCaja['apertura'];

		$resultMostrarDetalleFactura = $insMainModel->getAcciones("Mostrar detalle facturas - Caja");
		$consulta_MostrarDetalleFactura = $resultMostrarDetalleFactura->fetch_assoc();
		$activar = $consulta_MostrarDetalleFactura['activar'];
		
		//CONSULTAMOS EL TOTAL DE FACTURAS AL CREDITO

		//OBTENEMOS LOS DATOS DEL LA EMPRESA
		$result_empesa_caja = $insMainModel->getEmpresaConsulta($empresa_id);
		$consulta_empreasa_caja = $result_empesa_caja->fetch_assoc();

		ob_start();
		include(dirname('__FILE__').'/ticketCaja.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->set_option('margin-bottom', 0);
		$dompdf->set_option('margin-left', 0); // Ajuste para quitar el borde izquierdo
		$dompdf->set_option('isRemoteEnabled', true);

		$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
		
		$dompdf->setPaper(array(0, 0, 210, 300), 'portrait');
		
		// Render the HTML as PDF
		$dompdf->render();
		
		file_put_contents(dirname('__FILE__').'/facturas/cierreCaja_'.$apertura_id.'.pdf', $dompdf->output());
		
		// Output the generated PDF to Browser
		$dompdf->stream('cierreCaja_'.$apertura_id.'.pdf',array('Attachment'=>0));
		
		exit;	
	}