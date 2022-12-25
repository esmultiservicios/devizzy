<?php
   require_once "mainModel.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Voucher</title>
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/plantilla/css/style_factura.css">
	<link rel="shortcut icon" href="<?php echo SERVERURL; ?>vistas/plantilla/img/icono.png">
</head>
<body>
<?php echo $anulada; ?>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo.png" width="150px" height="95px">
				</div>
			</td>
			<td class="info_empresa">
				<div>
					<span class="h3">Compañia</span>
					<span class="h2"><?php echo $consulta_registro['empresa']; ?></span>									
				</div>												
			</td>
			<td class="info_empresa">
				<div>
					<span class="h3">RTN</span>
					<span class="h2"><?php echo $consulta_registro['rtn_empresa']; ?></span>				
				</div>				
			</td>			
		</tr>
	</table>

	<?php
	$datos = "";
	while($registro_detalles = $result_voucher_detalle->fetch_assoc()){
		$datos .= '
			<table id="factura_detalle">
				<thead>
					<tr>
						<th width="2.66%">NUMERO</th>
						<th width="28.66%">EMPLEADO</th>
						<th width="16.66%">RTN</th>
						<th width="16.66%">FECHA INGRESO</th>
						<th width="16.66%">SUELDO DIARIO</th>
						<th width="18.66%">PERIODO DE PAGO</th>					
					</tr>						
				</thead>
				<tbody id="detalle_productos">
					<tr>
						<th width="16.66%">4500329</th>
						<th width="16.66%">Edwin Javier Velasquez Cortes</th>
						<th width="16.66%">1804199104339</th>
						<th width="16.66%">03/28/2022</th>
						<th width="16.66%">863.02</th>
						<th width="16.66%">01/12/2022 - 15/12/2022</th>					
					</tr>	
				</tbody>
			</table>
			<table id="factura_detalle">
				<thead>
					<tr>
						<th width="2.66%" colspan="2">PERCEPCIONES</th>
						<th width="16.66%">HORAS / DIAS</th>
						<th width="16.66%">IMPORTE</th>
						<th width="16.66%">DEDUCCIONES</th>
						<th width="18.66%">IMPORTE</th>					
					</tr>						
				</thead>
		';

		$datos .= '<tbody id="detalle_productos">';
		/*while($registro_detalles = $result_voucher_detalle->fetch_assoc()){	
			$datos.='
				<tr>
					<td colspan="2">'.$registro_detalles['salario'].'</td>
					<td>IMPORTE</td>
					<td>IMPORTE</td>
					<td>DEDUCCIONES</td>
					<td>IMPORTE</td>					
				</tr>
			';
		}*/

		$datos .= '
			</tbody>
			</table>
			
		';
	}
	echo $datos;
	?>
</div>
</body>
</html>