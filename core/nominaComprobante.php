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
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .float-right {
        margin-left: auto;
    }

    .two-columns {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .column {
        width: 48%;
    }

    .table-title {
        width: 100%;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        background-color: #f2f2f2;
        margin-bottom: 5px;
    }

    /* Estilo para ajustar la posición de la tabla "Neto" */
    .table-neto {
        position: relative;
        top: -15%;
        /* Ajusta este valor según tus necesidades */
    }

    /* Agrega este bloque de estilos al head de tu documento o al CSS externo */
    .firma-empleado {
        text-align: center;
        margin-top: -18%;
    }

    .firma-empleado hr {
        border: 1px solid #ddd;
        width: 50%;
        margin: 0 auto;
        /* Centra la línea horizontalmente */
        margin-top: 5px;
    }

    .firma-texto {
        margin-top: 10px;
    }
    </style>

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
                <td class="info_empresa">
                    <div>
                        <span class="h3">Empresa</span>
                        <span class="h2"><?php echo $consulta_registro['razon_social']; ?></span>
                    </div>
                    <!-- Agregar fecha de nómina y número de nómina -->
                    <div>
                        <span class="h3">Fecha de Nómina</span>
                        <span class="h2"><?php echo $consulta_registro['fecha_registro']; ?></span>
                    </div>
                    <div>
                        <span class="h3">Número de Nómina</span>
                        <span class="h2"><?php echo $consulta_registro['nomina_id']; ?></span>
                    </div>
                </td>
            </tr>
        </table>

        <?php
        $datos = "";
        while ($registro_detalles = $result_voucher_detalle->fetch_assoc()) {
            // Mostrar Detalles del Colaborador
            $datos .= '<table>';
            $datos .= '<tr>';
            $datos .= '<th width="20%">NUMERO</th>';
            $datos .= '<th width="20%">EMPLEADO</th>';
            $datos .= '<th width="20%">RTN</th>';
            $datos .= '<th width="20%">FECHA INGRESO</th>';
            $datos .= '<th width="20%">SUELDO MENSUAL</th>';
            $datos .= '</tr>';
            $datos .= '<tr>';
            $datos .= '<td>' . $registro_detalles['colaboradores_id'] . '</td>';
            $datos .= '<td>' . $registro_detalles['empleado'] . '</td>';
            $datos .= '<td>' . $registro_detalles['identidad'] . '</td>';
            $datos .= '<td>' . $registro_detalles['fecha_ingreso'] . '</td>';
            $datos .= '<td>L. ' . number_format($registro_detalles['salario'], 2, '.', ',') . '</td>';
            $datos .= '</tr>';
            $datos .= '</table>';

            // Mostrar Percepciones y Deducciones en dos columnas
            $datos .= '<div class="two-columns">';
            
            // Mostrar Percepciones
            $datos .= '<div class="column">';
            $datos .= '<div class="table-title">Percepciones</div>';
            $datos .= '<table>';
            $datos .= '<tr>';
            $datos .= '<th width="33.33%">Concepto</th>';
            $datos .= '<th width="33.33%">Descripción</th>';
            $datos .= '<th width="33.33%">Cantidad</th>';
            $datos .= '</tr>';

            $percepciones = array(
                'Salario' => 'salario',
                'Días Trabajados' => 'dias_trabajados',
                'Hrs Extra 25%' => 'hrse25',
                'Hrs Extra 50%' => 'hrse50',
                'Hrs Extra 75%' => 'hrse75',
                'Hrs Extra 100%' => 'hrse100',
                'Retroactivo' => 'retroactivo',
                'Bono' => 'bono',
                'Otros Ingresos' => 'otros_ingresos'
            );

            foreach ($percepciones as $concepto => $campo) {
                if (!empty($registro_detalles[$campo]) && floatval($registro_detalles[$campo]) > 0) {
                    $datos .= '<tr>';
                    $datos .= '<td>' . $concepto . '</td>';
                    $datos .= '<td>' . $campo . '</td>';
                    
                    // Verificar si el concepto es 'Días Trabajados'
                    if ($campo === 'dias_trabajados') {
                        // Mostrar la cantidad sin formato de moneda
                        $datos .= '<td>' . number_format($registro_detalles[$campo], 2, '.', ',') . '</td>';
                    } else {
                        // Mostrar la cantidad con formato de moneda
                        $datos .= '<td>L. ' . number_format($registro_detalles[$campo], 2, '.', ',') . '</td>';
                    }
                    
                    $datos .= '</tr>';
                }
            }

            // Mostrar neto_ingresos
            $datos .= '<tr>';
            $datos .= '<td colspan="2">Neto Ingresos</td>';
            $datos .= '<td>L. ' . number_format($registro_detalles['neto_ingresos'], 2, '.', ',') . '</td>';
            $datos .= '</tr>';
            $datos .= '</table>';
            $datos .= '</div>'; // Fin de la columna de percepciones

            // Mostrar Deducciones
            $datos .= '<div class="column float-right">';
            $datos .= '<div class="table-title">Deducciones</div>';
            $datos .= '<table>';
            $datos .= '<tr>';
            $datos .= '<th width="33.33%">Concepto</th>';
            $datos .= '<th width="33.33%">Descripción</th>';
            $datos .= '<th width="33.33%">Cantidad</th>';
            $datos .= '</tr>';

            $deducciones = array(
                'Deducciones' => 'deducciones',
                'Préstamo' => 'prestamo',
                'IHSS' => 'ihss',
                'RAP' => 'rap',
                'ISR' => 'isr',
                'Vales' => 'vales'
            );

            foreach ($deducciones as $concepto => $campo) {
                if (!empty($registro_detalles[$campo]) && floatval($registro_detalles[$campo]) > 0) {
                    $datos .= '<tr>';
                    $datos .= '<td>' . $concepto . '</td>';
                    $datos .= '<td>' . $campo . '</td>';
                    $datos .= '<td>L. ' . number_format($registro_detalles[$campo], 2, '.', ',') . '</td>';
                    $datos .= '</tr>';
                }
            }

            // Mostrar neto_egresos
            $datos .= '<tr>';
            $datos .= '<td colspan="2">Neto Egresos</td>';
            $datos .= '<td>L. ' . number_format($registro_detalles['neto_egresos'], 2, '.', ',') . '</td>';
            $datos .= '</tr>';
            $datos .= '</table>';
            $datos .= '</div>'; // Fin de la columna de deducciones
            $datos .= '</div>'; // Fin de las dos columnas
            // Fin de mostrar Percepciones y Deducciones

            // Mostrar Neto
			$datos .= '<table class="table-neto">';
			$datos .= '<tr>';
			$datos .= '<th width="60%" colspan="2">Concepto</th>';
			$datos .= '<th width="40%">Cantidad</th>';
			$datos .= '</tr>';
			$datos .= '<tr>';
			$datos .= '<td colspan="2">Neto</td>';
			$datos .= '<td>L. ' . number_format($registro_detalles['neto'], 2, '.', ',') . '</td>';
			$datos .= '</tr>';
			$datos .= '</table>';
			
        }
        echo $datos;
        ?>

        <!-- Agregar esta sección al final de tu código, justo antes de cerrar el body -->
        <!-- Agregar esta sección al final de tu código, justo antes de cerrar el body -->
        <div class="firma-empleado">
            <hr>
            <p class="firma-texto">Firma del Empleado</p>
        </div>
    </div>
</body>

</html>