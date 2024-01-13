<?php
   require_once "mainModel.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consolidado Nominas</title>
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
                        <img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logos/<?php echo $logotipo; ?>"
                            width="150px" height="95px">
                    </div>
                </td>
                <td class="info_empresa" colspan="3">
                    <div>
                        <span class="h3">Consolidado de Nómina
                            <?php echo $insMainModel->nombremes(date("m", strtotime($consulta_registro['fecha_registro_1']))).", ".$consulta_registro['ano_registro']; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="info_empresa">
                    <div>
                        <span class="h3">Número de Nómina</span>
                        <span class="h2"><?php echo $consulta_registro['nomina_id']; ?></span>
                    </div>
                </td>
                <td class="info_empresa">
                    <div>
                        <span class="h3">Empresa</span>
                        <span class="h2"><?php echo $consulta_registro['razon_social']; ?></span>
                    </div>
                </td>
                <td class="info_empresa">
                    <div>
                        <span class="h3">RTN</span>
                        <span class="h2"><?php echo $consulta_registro['rtn_empresa']; ?></span>
                    </div>
                </td>
                <td class="info_empresa">
                    <div>
                        <span class="h3">Fecha de Nómina</span>
                        <span class="h2"><?php echo $consulta_registro['fecha_registro']; ?></span>
                    </div>
                </td>
            </tr>
        </table>

        <table id="factura_detalle">
            <thead>
                <tr>
                    <th align="center" rowspan="2" width="5%">Puesto</th>
                    <th align="center" rowspan="2" width="10%">Empleado</th>
                    <th align="center" rowspan="2" width="5%">Salario Base</th>
                    <th align="center" rowspan="2" width="5%">Días Trabajados</th>
                    <th align="center" colspan="7" width="30%">Ingresos</th>
                    <th align="center" rowspan="2" width="5%">Total Ingresos</th>
                    <th align="center" colspan="7" width="30%">Egresos</th>
                    <th align="center" rowspan="2" width="5%">Total Egresos</th>
                    <th align="center" rowspan="2f" width="5%">Neto</th>
                </tr>
                <tr>
                    <th align="center" width="5%">Hrs 25%</th>
                    <th align="center" width="5%">Hrs 50%</th>
                    <th align="center" width="5%">Hrs 75%</th>
                    <th align="center" width="5%">Hrs 100%</th>
                    <th align="center" width="5%">Retroacivo</th>
                    <th align="center" width="5%">Bono</th>
                    <th align="center" width="5%">Otros Ingresos</th>
                    <th align="center" width="5%">Deducciones</th>
                    <th align="center" width="5%">Prestamos</th>
                    <th align="center" width="5%">IHSS</th>
                    <th align="center" width="5%">RAP</th>
                    <th align="center" width="5%">ISR</th>
                    <th align="center" width="5%">Vale</th>
                    <th align="center" width="5%">Incapcidad IHSS</th>
                </tr>
            </thead>
            <tbody id="info_empresa">
                <?php
						while($registro_detalles = $result_voucher_detalle->fetch_assoc()){
							echo '
								<tr>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["puesto"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["empleado"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["salario"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["dias_trabajados"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["horas_25"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["horas_50"].'</th>	
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["horas_75"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["horas_100"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["retroactivo"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["bono"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["otros_ingresos"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["neto_ingresos"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["deducciones"].'</th
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["prestamo"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["ihss"].'</th>									
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["rap"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["isr"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["vales"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["incapacidad_ihss"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["neto_egresos"].'</th>
									<th align="center" width="5%" style="font-weight: none;">'.$registro_detalles["neto"].'</th>
								</tr>							
							';
						}
					?>
            </tbody>
        </table>
    </div>
</body>

</html>