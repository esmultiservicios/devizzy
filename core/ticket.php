<?php
   require_once "mainModel.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/plantilla/css/style_factura.css">
    <link rel="shortcut icon" href="<?php echo SERVERURL; ?>vistas/plantilla/img/icono.png">

    <style>
    .bordertr th {
        border: 1px solid #000;
        /* Establece un borde de 1 píxel de ancho con color negro para las celdas th */
        padding: 8px;
        /* Añade un espacio interno alrededor del contenido */
        text-align: left;
        /* Alinea el texto a la izquierda */
    }

    body {
        margin: 0;
        padding: 0;
        border: 0;
    }

    p {
        margin: 0;
    }

    .nota {
        margin: 0;
    }

    div {
        margin: 0;
    }

    .datos-cliente p {
        overflow-wrap: break-word;
        word-wrap: break-word;
        white-space: pre-line;
        /* Esta propiedad puede ayudar a mantener los saltos de línea */
    }

    .header-line {
        border-bottom: 1px solid black;
        /* Agrega un borde inferior a la fila del encabezado */
    }
    </style>
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
                <td class="textcenter">
                    <span class="h1"><?php echo nl2br($consulta_registro['empresa']); ?></span>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><?php echo nl2br($consulta_registro['direccion_empresa']); ?></p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><?php echo nl2br($consulta_registro['otra_informacion']); ?></p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p>PBX: <?php echo $consulta_registro['empresa_telefono']; ?></p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p>WhatsApp: <?php echo $consulta_registro['empresa_celular']; ?></p>
                </td>
            </tr>

            <tr>
                <td class="textcenter">
                    <p>Correo: <?php echo $consulta_registro['empresa_correo']; ?></p>
                </td>
            </tr>
            <tr>
                <td colspan="4"><span>&nbsp;&nbsp;&nbsp;</span></td>
                <td colspan="3"><span>&nbsp;&nbsp;&nbsp;</span></td>
            </tr>
            <tr class="">
                <td class="textcenter">
                    <span>
                        <h2>Factura</h2>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>N° Factura:</b>
                        <?php echo $consulta_registro['prefijo'].''.str_pad($consulta_registro['numero_factura'], $consulta_registro['relleno'], "0", STR_PAD_LEFT); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>Fecha:</b>
                        <b><?php echo $consulta_registro['fecha'].' '.date('g:i a',strtotime($consulta_registro['hora'])); ?></b>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>CAI:</b> <?php echo $consulta_registro['cai']; ?></p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>RTN:</b> <?php echo $consulta_registro['rtn_empresa']; ?></p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>Desde:</b>
                        </b><?php echo $consulta_registro['prefijo'].''.$consulta_registro['rango_inicial']; ?>
                        <b>Hasta:</b> <?php echo $consulta_registro['prefijo'].''.$consulta_registro['rango_final']; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>Fecha de Activación:</b> <?php echo $consulta_registro['fecha_activacion']; ?></p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>Fecha Limite de Emisión:</b> <?php echo $consulta_registro['fecha_limite']; ?></p>
                </td>
            </tr>
            <tr>
                <td class="textcenter">
                    <p><b>Factura:</b> <?php echo $consulta_registro['tipo_documento']; ?></p>
                </td>
            </tr>
        </table>
        <table id="factura_cliente">
            <tr>
                <td class="info_cliente">
                    <div class="">
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
                            </tr>
                            <tr>
                                <td colspan="2"><label>Teléfono:</label>
                                    <p><?php echo $consulta_registro['telefono']; ?></p>
                                </td>
                            </tr>
                            <tr class="datos-cliente">
                                <td colspan="2"><label>Cliente:</label>
                                    <p><?php echo $consulta_registro['cliente']; ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th width="" class="textright">Precio</th>
                    <th class="textright" colspan="2"><span>&nbsp;&nbsp;</span></th>
                    <th width="" class="textright">Descuento</th>
                    <th class="textright"><span>&nbsp;&nbsp;</span></th>
                    <th width="" class="textright">Importe</th>
                </tr>
                <tr>
                    <th colspan="6" class="header-line"></th>
                </tr>
            </thead>
            <tbody>
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
						$descuentos_neto += $descuentos;
						$isv_neto += $registro_detalles["isv_valor"];
						
						if($registro_detalles["isv_valor"] > 0){
							$importe_gravado += ($registro_detalles["precio"] * $registro_detalles["cantidad"] - $registro_detalles["descuento"]);
						}else{
							$importe_excento += ($registro_detalles["precio"] * $registro_detalles["cantidad"] - $registro_detalles["descuento"]);
						}						
						
                        $producto_name = $registro_detalles["producto"];

						echo
                        '<tr>
                        <td colspan="5" class="nombre-producto">'.$producto_name.'</td>
                        </tr>
                        <tr>
                        <td class="textright">L. '.number_format($registro_detalles["precio"],2).'</td>
                        <th class="textright" colspan="2"><span>&nbsp;&nbsp;</span></th>
                        <td class="textright">L. '.number_format($descuentos,2).'</td>
                        <th><span>&nbsp;</span></th>
                        <td class="textright">L. '.number_format($importe,2).'</td>
                        </tr>
                        <tr>
                        <td colspan="6" class="nombre-producto">Qty: '.$registro_detalles["cantidad"].'</td>
                        </tr>';
						$i++;
					}

					$total_despues_isv = ($total + $isv_neto) - $descuentos_neto;                                        
				?>
            </tbody>
            <tfoot id=" detalle_totales">
                <tr>
                    <th colspan="6" class="header-line"></th>
                </tr>
                <tr>
                    <td colspan="3"><span>&nbsp;&nbsp;&nbsp;</span></td>
                    <td><span>&nbsp;&nbsp;&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Importe</span></td>
                    <td<span>L. <?php echo number_format($total,2);?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Descuentos y Reb:</span></td>
                    <td><span>L. <?php echo number_format($descuentos_neto,2);?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Sub-Total</span></td>
                    <td><span>L. <?php echo number_format($subtotal,2);?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Importe Exonerado</span></td>
                    <td><span>L. <?php echo number_format(0,2);?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Importe Excento</span></td>
                    <td><span>L. <?php echo number_format($importe_excento,2);?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Importe Gravado 15%</span></td>
                    <td><span>L. <?php echo number_format($importe_gravado,2); ?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Importe Gravado 18%</span></td>
                    <td><span>L. <?php echo number_format(0,2);?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>ISV 15%</span></td>
                    <td><span>L. <?php echo number_format($isv_neto,2); ?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>ISV 18%</span></td>
                    <td><span>L. <?php echo number_format(0,2);?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span>Total</span></td>
                    <td><span>L. <?php echo number_format($total_despues_isv,2); ?></span></td>
                </tr>
                <tr>
                    <th colspan="6" class="header-line"></th>
                </tr>
            </tfoot>
        </table>
        <div>
            <p class="nota" style="word-wrap: break-word;"><?php 
			if($consulta_registro["notas"] != ""){
				echo "<p class='h2'><b>Nota:</b> ".nl2br($consulta_registro["notas"])."</p>";
			}		
		?></p>
            <p class="nota" style="word-wrap: break-word;"><br /><br /></p>

            <p class="nota">
                <center><?php echo nl2br($insMainModel->convertir($total_despues_isv).' <br>LEMPIRAS');?></center>
            </p>

            <p class="nota">
                <center>
                    <?php 
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
			?>
                </center>
            </p>
            <p class="nota" style="word-wrap: break-word;">
                <center><?php 
				if($consulta_registro['fecha_dolar'] != '0000-00-00') { 
					if($total_despues_isv != 0 || $total_despues_isv != ""){
						if(isset($dolar->success)){
							echo $insMainModel->convertir($dolar->result).' DOLARES';
						}
					}			
				}?>
                </center>
            </p>

            <table>
                <tbody>
                    <?php
                        $total = 0;
                    
                        if ($result_metodos_pago->num_rows > 0) {
                            echo '                
                                <tr>
                                    <td colspan="2"><span>&nbsp;&nbsp;&nbsp;</span></td>
                                    <td><span>&nbsp;&nbsp;&nbsp;</span></td>
                                </tr>
                                <tr><td colspan="2"><center><b><span>Método de Pago</span></b></center></td></tr>';
                            while ($consulta_registro_metodo2 = $result_metodos_pago->fetch_assoc()) {
                                echo '<tr><td><span>' . $consulta_registro_metodo2["tipo_pago_nombre"]. '</span></td>';
                                echo '<td><span>L. ' . number_format($consulta_registro_metodo2["total_efectivo"], 2) . '</span></td></tr>';

                                $total += $consulta_registro_metodo2["total_efectivo"];
                            }
                        }

                        echo                      
                        '                   
                            <tr>
                                <td><b>Total: </b></td>
                                <td><b>L. '.number_format($total,2).'</b></td>
                            </tr>
                        ';
                    ?>
                </tbody>
            </table>

            <p class="nota"><br /><br /></p>
            <p class="nota">La factura es beneficio de todos "Exíjala"</p>
            <p class="nota">N° correlativo de orden de compra excenta _____________</p>
            <p class="nota">N° correlativo constancia de registro Exonerado _________</p>
            <p class="nota">N° identificativo del registro de la SAG ________________</p>

            <p class="nota" style="word-wrap: break-word;"><br /><br /></p>
            <p class="nota">
                <center><b>Original:</b> Cliente</center>
            </p>
            <p class="nota">
                <center><b>Copia:</b> Emisor</center>
            </p>
            <h4 class="label_gracias" style="word-wrap: break-word;">
                <?php  echo nl2br($consulta_registro["eslogan"]); ?></h4>
        </div>
    </div>
</body>

</html>