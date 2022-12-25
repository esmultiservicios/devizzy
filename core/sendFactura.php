<?php
	header("Content-Type: text/html;charset=utf-8");
	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	if(!isset($_SESSION['user_sd'])){ 
		session_start(['name'=>'SD']); 
	}

	$insMainModel = new mainModel();

	date_default_timezone_set('America/Tegucigalpa');
	$facturas_id = $_POST['facturas_id'];

	//CONSULTAR DATOS DE FACTURA
	$result_factura = $insMainModel->geFacturaCorreo($facturas_id);	

	$nombre = "";
	$para = "";
	$no_factura = "";
	$prefijo = "";
	 
	if($result_factura->num_rows>=0){
		$factura = $result_factura->fetch_assoc();
		$nombre = $factura['cliente'];
		$para = $factura['correo'];
		$no_factura = str_pad($factura['numero'], $factura['relleno'], "0", STR_PAD_LEFT);
		$prefijo = $factura['prefijo'];
	}

	//OBTENER NOMBRE DE EMPRESA
	$usuario = $_SESSION['colaborador_id_sd'];	

	$result_empresa = $insMainModel->getEmpresaFacturaCorreo($usuario);	

	$telefono = '';
	$celular = '';
	$telefono = '';
	$horario = '';
	$eslogan = '';
	$facebook = '';
	$sitioweb = '';	
	$correo = '';

	if($result_empresa->num_rows>=0){
		$consulta_empresa = $result_empresa->fetch_assoc();
		$telefono = $consulta_empresa['telefono'];
		$celular = $consulta_empresa['celular'];
		$correo = $consulta_empresa['correo'];   
		$horario = $consulta_empresa['horario'];
		$eslogan = $consulta_empresa['eslogan'];
		$facebook = $consulta_empresa['facebook'];
		$sitioweb = $consulta_empresa['sitioweb'];				
	}

	$tipo_correo = "Facturas";
	$result_correo = $insMainModel->getCorreoServer($tipo_correo);

	$de = "";
	$contraseña = "";
	$server = "";
	$port = "";
	$smtp_secure = "";

	if($result_correo->num_rows>=0){
		$consulta_correo = $result_correo->fetch_assoc();
		$de = $consulta_correo['correo'];
		$contraseña = $insMainModel->decryption($consulta_correo['password']);
		$server = $consulta_correo['server'];   
		$port = $consulta_correo['port'];
		$smtp_secure = $consulta_correo['smtp_secure'];		
	}

	$de = $de;
	$contraseña = $contraseña;   
	$servidor = $server;
	$puerto = $port;
	$SMTPSecure = $smtp_secure; 
	$from = "Factura";		   
	$asunto = "Factura N° ".$prefijo." ".$no_factura;
	$CharSet = "UTF-8";
	$factura_documento = "factura_".$no_factura;
	$URL = dirname('__FILE__').'/Facturas/'.$factura_documento.'.pdf';
	$url_logo = SERVERURL."vistas/plantilla/img/logo.png";
	$url_sistema = SERVERURL;
	$url_footer = SERVERURL."vistas/plantilla/img/logo.png";
	$url_facebook = $facebook;
	$url_sitio_web = $sitioweb;

	$mensaje="
	<table class='table table-striped table-responsive-md btn-table'>
		<tr>
			<td colspan='2'><center><img width='25%' heigh='20%' src='".$url_logo."'></center></td>
		</tr>
		<tr>
			<td colspan='2'><center><b><h4>Factura</h4></b></center></td>
		</tr>
		<tr>
			<td colspan='2'><b>Estimado(a) $nombre, se le notifica que se le esta haciendo llegar su factura # ".$prefijo."$no_factura.</b></td>
		</tr>	   
		<tr>
			<td colspan='2'>
				<p style='text-align: justify; font-size:12px;'><b>
				Este mensaje ha sido enviado de forma automática, por favor no responder este correo. Cualquier duda o consulta puede contactarnos a las siguientes direcciones de correo: 
				<u>
					<li style='text-align: justify; font-size:12px;'>".$correo."</li>
				</u>
				<ul>
					<li><b style='text-align: justify; font-size:12px;'>Tambien puede llamarnos a nuestra Teléfono: ".$telefono."</b></li>
					<li><b style='text-align: justify; font-size:12px;'>Tambien puede llamarnos a nuestra WhatsApp: ".$celular."</b></li>
					<li><b style='text-align: justify; font-size:12px;'>En los siguientes horarios: ".$horario."</b></li>
				</ul>
				<ul>
					<li> <a style='text-align: justify; font-size:12px;' href='".$url_sitio_web."'>Presione este enlace, para acceder a Nuestro Sitio WEB</a></li>
					<li><a style='text-align: justify; font-size:12px;' href='".$url_facebook."'>Presione este enlace, para acceder a Nuestro Facebook</a></li>
				</ul>
				<p style='text-align: justify; font-size:12px;'><b>".$eslogan."</b></p>
				<br/>
				<br/>
				<p style='text-align: justify; font-size:12px;'>
					<b>
						Este correo fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje..
					</b>
				</p>
			</td>
		</tr>	
		<tr>
			<td colspan='2'>
				<p><img width='25%' heigh='20%' src='".$url_footer."'></p>
			</td>
		</tr>		   
	</table>	   
	";
	   
	$insMainModel->sendMailOpciones($servidor, $puerto, $contraseña, $CharSet, $SMTPSecure , $de, $para, $from, $asunto, $mensaje, $URL);
	
?>