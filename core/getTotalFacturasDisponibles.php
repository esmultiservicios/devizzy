<?php
$peticionAjax = true;
require_once 'configGenerales.php';
require_once 'mainModel.php';

if (!isset($_SESSION['user_sd'])) {
	session_start(['name' => 'SD']);
}

$empresa_id = $_SESSION['empresa_id_sd'];
$insMainModel = new mainModel();

// Inicializar variables
$ultimoNumeroUsado = 0;
$rango_inicial = 0;
$rango_final = 0;
$contador = 0;
$fecha_limite = 'Sin definir';

// Obtener último número usado
$resultNumero = $insMainModel->getTotalFacturasDisponiblesDB($empresa_id);
if ($resultNumero->num_rows > 0) {
    $row = $resultNumero->fetch_assoc();
    $ultimoNumeroUsado = (int)$row['numero'];
}

// Obtener rango de facturación
$resultRango = $insMainModel->getNumeroMaximoPermitido($empresa_id);
if ($resultRango->num_rows > 0) {
    $row = $resultRango->fetch_assoc();
    $rango_final = (int)$row['rango_final'];
    $rango_inicial = (int)$row['rango_inicial'];
}

// Calcular facturas pendientes
if ($ultimoNumeroUsado === 0 || $ultimoNumeroUsado === $rango_inicial) {
    $facturasPendientes = $rango_final - $rango_inicial + 1;
} else {
    $facturasPendientes = max(0, $rango_final - $ultimoNumeroUsado);
}

// Obtener fecha límite
$resultFecha = $insMainModel->getFechaLimiteFactura($empresa_id);
if ($resultFecha->num_rows > 0) {
    $row = $resultFecha->fetch_assoc();
    $contador = (int)$row['dias_transcurridos'];
    $fecha_limite = $row['fecha_limite'];
}

// Preparar respuesta
$datos = [
    'facturasPendientes' => $facturasPendientes,
    'contador' => $contador,
    'fechaLimite' => $fecha_limite,
    'error' => false
];

echo json_encode($datos);
exit;