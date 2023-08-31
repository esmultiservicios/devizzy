<?php
	header("Content-Type: text/html;charset=utf-8");
	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	require_once "Database.php";
	require_once "sendEmail.php";
	
	if(!isset($_SESSION['user_sd'])){ 
		session_start(['name'=>'SD']); 
	}

	$insMainModel = new mainModel();

	$database = new Database();
	$sendEmail = new sendEmail();
		
	date_default_timezone_set('America/Tegucigalpa');
	$cotizacion_id = $_POST['cotizacion_id'];

	//CONSULTAR DATOS DE FACTURA
	$result_factura = $insMainModel->getCotizacionCorreo($cotizacion_id);	

	$no_factura = "";
	$nombre = "";
	$para = "";	
	 
	if($result_factura->num_rows>=0){
		$factura = $result_factura->fetch_assoc();
		$no_factura = $factura['numero'];
		$nombre = $factura['cliente'];	
		$para = $factura['correo'];
		
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

	$tipo_correo = "Notificaciones";
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
	$from = "Cotización";		   
	$asunto = "Cotización N° ".$no_factura;
	$CharSet = "UTF-8";
	$factura_documento = "cotizacion_".$no_factura;
	$URL = dirname('__FILE__').'/cotizaciones/'.$factura_documento.'.pdf';
	$url_logo = SERVERURL."vistas/plantilla/img/logo.png";
	$url_sistema = SERVERURL;
	$url_footer = SERVERURL."vistas/plantilla/img/logo.png";
	$url_facebook = $facebook;
	$url_sitio_web = $sitioweb;

	$mensaje1="
	<table class='table table-striped table-responsive-md btn-table'>
		<tr>
			<td colspan='2'><center><img width='25%' heigh='20%' src='".$url_logo."'></center></td>
		</tr>
		<tr>
			<td colspan='2'><center><b><h4>Cotización</h4></b></center></td>
		</tr>
		<tr>
			<td colspan='2'><b>Estimado(a) $nombre, se le notifica que se le esta haciendo llegar su cotrización # ".$no_factura."</b></td>
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


	$mensaje = '
	<!doctype html>
	<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	   <head>
		  <title>
		  </title>
		  <!--[if !mso]-->
		  <meta http-equiv="X-UA-Compatible" content="IE=edge">
		  <!--[endif]-->
		  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <style type="text/css">
			 #outlook a { padding:0; }
			 body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
			 table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
			 img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
			 p { display:block;margin:13px 0; }
		  </style>
		  <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
		  <link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet" type="text/css">
		  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet" type="text/css">
		  <style type="text/css">
			 @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
			 @import url(https://fonts.googleapis.com/css?family=Cabin:400,700);
			 @import url(https://fonts.googleapis.com/css?family=Poppins:400,700);
		  </style>
		  <style type="text/css">
			 @media only screen and (max-width:480px) {
			 .mj-column-per-100 { width:100% !important; max-width: 100%; }
			 }
		  </style>
		  <style type="text/css">
			 @media only screen and (max-width:480px) {
			 table.full-width-mobile { width: 100% !important; }
			 td.full-width-mobile { width: auto !important; }
			 }
		  </style>
		  <style type="text/css">.hide_on_mobile { display: none !important;}
			 @media only screen and (min-width: 480px) { .hide_on_mobile { display: block !important;} }
			 .hide_section_on_mobile { display: none !important;}
			 @media only screen and (min-width: 480px) {
			 .hide_section_on_mobile {
			 display: table !important;
			 }
			 div.hide_section_on_mobile {
			 display: block !important;
			 }
			 }
			 .hide_on_desktop { display: block !important;}
			 @media only screen and (min-width: 480px) { .hide_on_desktop { display: none !important;} }
			 .hide_section_on_desktop {
			 display: table !important;
			 width: 100%;
			 }
			 @media only screen and (min-width: 480px) { .hide_section_on_desktop { display: none !important;} }
			 p, h1, h2, h3 {
			 margin: 0px;
			 }
			 a {
			 text-decoration: none;
			 color: inherit;
			 }
			 @media only screen and (max-width:480px) {
			 .mj-column-per-100 { width:100%!important; max-width:100%!important; }
			 .mj-column-per-100 > .mj-column-per-75 { width:75%!important; max-width:75%!important; }
			 .mj-column-per-100 > .mj-column-per-60 { width:60%!important; max-width:60%!important; }
			 .mj-column-per-100 > .mj-column-per-50 { width:50%!important; max-width:50%!important; }
			 .mj-column-per-100 > .mj-column-per-40 { width:40%!important; max-width:40%!important; }
			 .mj-column-per-100 > .mj-column-per-33 { width:33.333333%!important; max-width:33.333333%!important; }
			 .mj-column-per-100 > .mj-column-per-25 { width:25%!important; max-width:25%!important; }
			 .mj-column-per-100 { width:100%!important; max-width:100%!important; }
			 .mj-column-per-75 { width:100%!important; max-width:100%!important; }
			 .mj-column-per-60 { width:100%!important; max-width:100%!important; }
			 .mj-column-per-50 { width:100%!important; max-width:100%!important; }
			 .mj-column-per-40 { width:100%!important; max-width:100%!important; }
			 .mj-column-per-33 { width:100%!important; max-width:100%!important; }
			 .mj-column-per-25 { width:100%!important; max-width:100%!important; }
			 }
		  </style>
		  <!--style footer-->
		  <style>
			@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,500,300,700);
	
	* {
	  font-family: Open Sans;
	}
	
	section {
	  width: 100%;
	  display: inline-block;
	  background: #333;
	  height: 50vh;
	  text-align: center;
	  font-size: 22px;
	  font-weight: 700;
	  text-decoration: underline;
	}
	
	.footer-distributed{
		background: #666;
		box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.12);
		box-sizing: border-box;
		width: 100%;
		text-align: left;
		font: bold 16px sans-serif;
		padding: 55px 50px;
	}
	
	.footer-distributed .footer-left,
	.footer-distributed .footer-center,
	.footer-distributed .footer-right{
		display: inline-block;
		vertical-align: top;
	}
	
	/* Footer left */
	
	.footer-distributed .footer-left{
		width: 40%;
	}
	
	/* The company logo */
	
	.footer-distributed h3{
		color:  #ffffff;
		font: normal 36px Open Sans, cursive;
		margin: 0;
	}
	
	.footer-distributed h3 span{
		color:  lightseagreen;
	}
	
	/* Footer links */
	
	.footer-distributed .footer-links{
		color:  #ffffff;
		margin: 20px 0 12px;
		padding: 0;
	}
	
	.footer-distributed .footer-links a{
		display:inline-block;
		line-height: 1.8;
	  font-weight:400;
		text-decoration: none;
		color:  inherit;
	}
	
	.footer-distributed .footer-company-name{
		color:  white;
		font-size: 14px;
		font-weight: normal;
		margin: 0;
	}
	
	/* Footer Center */
	
	.footer-distributed .footer-center{
		width: 35%;
	}
	
	.footer-distributed .footer-center i{
		background-color:  #33383b;
		color: #ffffff;
		font-size: 25px;
		width: 38px;
		height: 38px;
		border-radius: 50%;
		text-align: center;
		line-height: 42px;
		margin: 10px 15px;
		vertical-align: middle;
	}
	
	.footer-distributed .footer-center i.fa-envelope{
		font-size: 17px;
		line-height: 38px;
	}
	
	.footer-distributed .footer-center p{
		display: inline-block;
		color: #ffffff;
	  font-weight:400;
		vertical-align: middle;
		margin:0;
	}
	
	.footer-distributed .footer-center p span{
		display:block;
		font-weight: normal;
		font-size:14px;
		line-height:2;
	}
	
	.footer-distributed .footer-center p a{
		color:  lightseagreen;
		text-decoration: none;;
	}
	
	.footer-distributed .footer-links a:before {
	  content: "|";
	  font-weight:300;
	  font-size: 20px;
	  left: 0;
	  color: #fff;
	  display: inline-block;
	  padding-right: 5px;
	}
	
	.footer-distributed .footer-links .link-1:before {
	  content: none;
	}
	
	/* Footer Right */
	
	.footer-distributed .footer-right{
		width: 20%;
	}
	
	.footer-distributed .footer-company-about{
		line-height: 20px;
		color:  white;
		font-size: 13px;
		font-weight: normal;
		margin: 0;
	}
	
	.footer-distributed .footer-company-about span{
		display: block;
		color:  #ffffff;
		font-size: 14px;
		font-weight: bold;
		margin-bottom: 20px;
	}
	
	.footer-distributed .footer-icons{
		margin-top: 25px;
	}
	
	.footer-distributed .footer-icons a{
		display: inline-block;
		width: 35px;
		height: 35px;
		cursor: pointer;
		
		border-radius: 2px;
	
		font-size: 20px;
		color: #ffffff;
		text-align: center;
		line-height: 35px;
	
		margin-right: 3px;
		margin-bottom: 5px;
	}
	
	
	@media (max-width: 880px) {
	
		.footer-distributed{
			font: bold 14px sans-serif;
		}
	
		.footer-distributed .footer-left,
		.footer-distributed .footer-center,
		.footer-distributed .footer-right{
			display: block;
			width: 100%;
			margin-bottom: 40px;
			text-align: center;
		}
	
		.footer-distributed .footer-center i{
			margin-left: 0;
		}
	
	}
	
		  </style>
	   </head>
	   <body style="background-color:#FCFCFC;">
		  <div style="background-color:#FCFCFC;">
			 <div class="footer-distributed">
				<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" >
				   <tbody>
					  <tr>
						 <td style="border:none;direction:ltr;font-size:0px;padding:9px 0px 9px 0px;text-align:center;">
							<div class="mj-column-per-100 outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
							   <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
								  <tr>
									 <td align="right" style="font-size:0px;padding:0px 0px 0px 0px;word-break:break-word;">
										<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
										   <tbody>
											  <tr>
												 <td style="width:144px;">
													<a href="" target="_blank">
													<img alt="" height="auto" src=""
													style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;"
													width="144">
													</a>
												 </td>
											  </tr>
										   </tbody>
										</table>
									 </td>
								  </tr>
							   </table>
							</div>
						 </td>
					  </tr>
				   </tbody>
				</table>
			 </div>
			 <div style="margin:0px auto;max-width:600px;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
				   <tbody>
					  <tr>
						<td style="padding: 20px;">
	
						</td>
					  </tr>
					  <tr>
						<td colspan="2"><center><b><h4>Cotización</h4></b></center></td>
					  </tr>
					  <tr>
						<td colspan="2">Estimado(a) <b>'.$nombre.'</b>, se le notifica que se le esta haciendo llegar su cotrización <b># '.$no_factura.'</b></td>
					  </tr>
				   </tbody>
				</table>
			 </div>
			 <!--footer-->
			 <footer class="footer-distributed">
	
			  <div class="footer-left">
	
				<img src="'.$url_logo.'" alt="" style="width: 80px;">
	
				<p class="footer-company-name"></p>
			  </div>
	
			  <div class="footer-center">
	
				<div>
				  <i class="fa fa-map-marker"></i>
				  <p>Horarios: '.$horario.'</p>
				</div>
	
				<div>
				  <i class="fa fa-phone"></i>
				  <p>Teléfono: '.$telefono.'</p>
				</div>
	
				<div>
				  <i class="fa fa-envelope"></i>
				  <p><a href="mailto:'.$correo.'">Soporte: '.$correo.'</a></p>
				</div>
	
			  </div>
	
			  <div class="footer-right">
	
				<p class="footer-company-about">
					Este correo fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante.<br> Por favor no respondas a este mensaje.
				</p>
	
				<div class="footer-icons">
					 <a href="'.$facebook.'">
				  
						  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
				  </a>
				  <a href="https://wa.me/'.$celular.'">
				  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
				  </a>              
	
				</div>
	
			  </div>
	
			</footer>
		   <!--fin footer-->
		  </div>
	   </body>
	</html>
  
	';
	   
	$insMainModel->sendMailOpciones($servidor, $puerto, $contraseña, $CharSet, $SMTPSecure , $de, $para, $from, $asunto, $mensaje, $URL);
	
?>