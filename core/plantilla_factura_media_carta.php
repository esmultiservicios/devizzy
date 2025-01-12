<?php
   require_once "mainModel.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/plantilla/css/style_factura_medica_carta.css">
    <link rel="shortcut icon" href="<?php echo SERVERURL; ?>vistas/plantilla/img/icono.png">
</head>

<body>
    <?php echo $anulada; ?>
    <?php
  if (SISTEMA_PRUEBA=="SI"){ //CAJA
?>
    <span class="container-fluid prueba-sistema">SISTEMA DE PRUEBA</span>
    <?php
  }
?>
    <div id="page_pdf">
        <table id="factura_head">
            <tr>
                <td class="logo_factura">
                    <div>
                        <img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logos/<?php 
                                if (SISTEMA_PRUEBA === "SI"){
                                    echo "logo_prueba.jpg"; 
                                }else{
                                    echo $logotipo; 
                                }                        
                        ?>" width="150px" height="95px">
                    </div>
                </td>
                <td class="info_empresa">
                    <div>
                        <span class="h2"><?php echo nl2br($consulta_registro['empresa']); ?></span>
                        <p><?php echo nl2br($consulta_registro['direccion_empresa']); ?></p>
                        <p>PBX: <?php echo $consulta_registro['empresa_telefono']; ?></p>
                        <p>WhatsApp: <?php echo $consulta_registro['empresa_celular']; ?></p>
                        <p><?php echo nl2br($consulta_registro['otra_informacion']); ?></p>
                        <p>Correo: <?php echo $consulta_registro['empresa_correo']; ?></p>
                    </div>
                </td>
                <td class="info_factura">
                    <div class="round">
                        <span class="h3"><?php echo $facturaTitle;?></span>
                        <?php
                            // Ahora puedes integrar tu código HTML dentro de PHP
                            echo '<p><b>N° Factura:</b> ' . $consulta_registro['prefijo'] . str_pad($consulta_registro['numero_factura'], $consulta_registro['relleno'], "0", STR_PAD_LEFT) . '</p>';
                            echo '<p><b>Fecha:</b> ' . $consulta_registro['fecha'] . ' ' . date('g:i a', strtotime($consulta_registro['hora'])) . '</p>';

                            if($proformaUso === 0){
                                echo '<p><b>CAI:</b> ' . $consulta_registro['cai'] . '</p>';
                            }
                            
                            echo '<p><b>RTN:</b> ' . $consulta_registro['rtn_empresa'] . '</p>';

                            if($proformaUso === 0){
                                echo '<p><b>Desde:</b> ' . $consulta_registro['prefijo'] . $consulta_registro['rango_inicial'] . ' <b>Hasta:</b> ' . $consulta_registro['prefijo'] . $consulta_registro['rango_final'] . '</p>';
                                echo '<p><b>Fecha de Activación:</b> ' . $consulta_registro['fecha_activacion'] . '</p>';
                                echo '<p><b>Fecha Limite de Emisión:</b> ' . $consulta_registro['fecha_limite'] . '</p>';
                                echo '<p><b>Factura:</b> ' . $consulta_registro['tipo_documento'] . '</p>';
                            }                            
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <table id="factura_cliente">
            <tr>
                <td class="info_cliente">
                    <div class="round">
                        <span class="h3">Cliente</span>
                        <table class="datos_cliente">
                            <tr>
                                <td><label>RTN:</label>
                                    <p><?php 
									if(strlen($consulta_registro['rtn_cliente'])<10){
										echo "";
									}else{
										echo $consulta_registro['rtn_cliente'];
									}
							
							?></p>
                                </td>
                                <td><label>Teléfono:</label>
                                    <p><?php echo $consulta_registro['telefono'] === "0" ? "" : $consulta_registro['telefono']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><label>Cliente:</label>
                                    <p><?php echo $consulta_registro['cliente']; ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

            </tr>
        </table>
        <table id="factura_detalle">
            <thead>
                <tr>
                    <th width="3%">N°</th>
                    <th width="40%">Nombre Producto</th>
                    <th width="6%" class="textleft">Cantidad</th>
                    <th width="6%" class="textleft">Medida</th>
                    <th width="15%" class="textright">Precio</th>
                    <th width="15%" class="textright">Descuento</th>
                    <th width="15%" class="textright">Importe</th>
                </tr>
            </thead>
            <tbody id="detalle_productos">
                <?php
					$total_despues_isv = 0;
					$importe_gravado = 0;
					$importe_excento = 0;
					$subtotal = 0;
					$isv_neto = 0;
					$descuentos_neto = 0;
					$total = 0;
					$i = 1;
					$totalHNL = 0;
					$tasaCambioHNL = 0;
					$descuentos = 0;
					$producto_name = '';
					
					while($registro_detalles = $result_factura_detalle->fetch_assoc()){																
						$total_ = 0;
						$importe = 0;

						$total += ($registro_detalles["precio"] * $registro_detalles["cantidad"]);
						$total_ = ($registro_detalles["precio"] * $registro_detalles["cantidad"]);
						$importe += ($registro_detalles["precio"] * $registro_detalles["cantidad"] - $registro_detalles["descuento"]);
						$subtotal += $importe;
						$descuentos += $registro_detalles["descuento"];
						$descuentos_neto += $registro_detalles["descuento"];
						$isv_neto += $registro_detalles["isv_valor"];
						
						if($registro_detalles["isv_valor"] > 0){
							$importe_gravado += ($registro_detalles["precio"] * $registro_detalles["cantidad"] - $registro_detalles["descuento"]);
						}else{
							$importe_excento += ($registro_detalles["precio"] * $registro_detalles["cantidad"] - $registro_detalles["descuento"]);
						}						
						
						/*if($registro_detalles["barCode"] != "" || $registro_detalles["barCode"] != null){
							$producto_name = '['.$registro_detalles["barCode"].'] '.$registro_detalles["producto"];
						}else{
							$producto_name = $registro_detalles["producto"];
						}*/

						echo '
						  <tr>
							<td>'.$i.'</td>
							<td>'.$registro_detalles["producto"].'</td>
							<td align="center">'.$registro_detalles["cantidad"].'</td>
							<td align="center">'.$registro_detalles["medida"].'</td>
							<td class="textright">L. '.number_format($registro_detalles["precio"],2).'</td>
							<td class="textright">L. '.number_format($registro_detalles["descuento"],2).'</td>
							<td class="textright">L. '.number_format($importe,2).'</td>
						  </tr>
						';
						$i++;
					}

					$total_despues_isv = ($total + $isv_neto) - $descuentos_neto;				
				?>
            </tbody>
            <tfoot id="detalle_totales">

                <tr>
                    <td colspan="2" style="text-align: left; vertical-align: top;">
                        <!-- Detalles del método de pago y factura -->
                        <table style="width: 100%; border-spacing: 0;">
                            <tbody>
                                <?php
                                    $total = 0;

                                    if ($result_metodos_pago->num_rows > 0) {
                                        echo '
                                            <tr>
                                                <td colspan="1"><center><b><span>Método de Pago</span></b></center></td>
                                            </tr>';
                                        while ($consulta_registro_metodo2 = $result_metodos_pago->fetch_assoc()) {
                                            echo '<tr><td><span>' . $consulta_registro_metodo2["tipo_pago_nombre"] . '</span></td>';
                                            echo '<td><span>L. ' . number_format($consulta_registro_metodo2["total_efectivo"], 2) . '</span></td></tr>';

                                            $total += $consulta_registro_metodo2["total_efectivo"];
                                        }
                                    }

                                    echo
                                        '
                                        <tr>
                                            <td><b>Total Recibido: </b></td>
                                            <td><b>L. '.number_format($total,2).'</b></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        <tr/>
                                        <tr>
                                            <td colspan="2"><span>La factura es beneficio de todos "Exíjala"</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span>N° correlativo de orden de compra excenta __________________</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span>N° correlativo constancia de registro Exonerado __________________</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span>N° identificativo del registro de la SAG __________________</span></td>
                                        </tr>
                                    ';
                                ?>
                            </tbody>
                        </table>
                    </td>

                    <!-- Nueva columna en el medio (centrada) -->
                    <td style="text-align: center; vertical-align: top; overflow: hidden; max-width: 300px;">
                        <?php
                            if($consulta_registro["MostrarFirma"] == 1) {
                                if($consulta_registro["estado"] == 2){
                                    if($firma_documento !== "") {
                        ?>
                        <p class="nota">
                            <center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logos/<?php echo $firma_documento; ?>" width="150px" height="130px"></center>
                        </p>
                        <?php
                                    }
                                }
                            }
                        ?>

                        <p class="nota textcenter"><b>Original:</b> Cliente</p>
                        <p class="nota textcenter"><b>Copia:</b> Emisor</p>
                        <h4 class="label_gracias"><?php echo nl2br($consulta_registro["eslogan"]); ?></h4>
                    </td>

                    <!-- Totales Generales a la derecha -->
                    <td colspan="4" style="text-align: right; vertical-align: top;">
                        <table style="width: 100%; border-spacing: 0;">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Importe</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format($total,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Descuentos y Rebajas Otorgados</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format($descuentos_neto,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Sub-Total</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format($subtotal,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Importe Exonerado</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format(0,2,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Importe Excento</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format($importe_excento,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Importe Gravado 15%</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format($importe_gravado,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Importe Gravado 18</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format(0,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>ISV 15%</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format($isv_neto,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>ISV 18%</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format(0,2);?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right;" class="textright"><span>&nbsp;</span></td>
                                    <td style="width: 50%; text-align: right;"><span>Total</span></td>
                                    <td style="width: 50%; text-align: right;"><span>L. <?php echo number_format($total_despues_isv,2);?></span></td>
                                </tr>                                                            
                            </tbody>
                        </table>
                    </td>
                </tr>

            </tfoot>
        </table>
        <div>
            <p class="nota"><?php 
			if($consulta_registro["notas"] != ""){
				echo "<p class='h2'>Nota:</b></p>";
				echo "<p class='h2'>".nl2br($consulta_registro["notas"])."</p>";				
			}		
		?></p>
            <p class="nota"><br /><br /></p>
            <p class="nota textcenter" style="text-align: center;">
                <?php                     
                    echo $insMainModel->convertir($total_despues_isv) . ' LEMPIRAS';
                ?>
                <br>
            <p class="nota textcenter">
                <?php 
				/*
				EVALUAR SI EL CLIENTE REQUIERE VER LOS DOLARES O NO
				include_once 'cambioDolar.php';
				if($consulta_registro['fecha_dolar'] != '0000-00-00' ){
					$new_fecha_dolar = $consulta_registro['fecha_dolar'];

					if($total_despues_isv != 0 || $total_despues_isv != ""){
						$dolar = cambioDolar($total_despues_isv,$new_fecha_dolar);
						if(isset($dolar->success)){
							echo "Tasa de Cambio L. ". number_format($total_despues_isv/$dolar->result,2)."<br/>";
							echo 'Total Dolares $ '.round($dolar->result,2);
						}
					}										
				}
				*/
			?>

            </p>

            <p class="nota textcenter"><?php 

		/*
                EVALUAR SI EL CLIENTE REQUIERE VER LOS DOLARES O NO

				if($consulta_registro['fecha_dolar'] != '0000-00-00') { 
					if($total_despues_isv != 0 || $total_despues_isv != ""){
						if(isset($dolar->success)){
							echo $insMainModel->convertir($dolar->result).' DOLARES';
						}
					}			
				}
				*/?>
            </p>                    
        </div>

    </div>
</body>

</html>