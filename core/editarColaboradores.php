<?php	
$peticionAjax = true;
require_once "configGenerales.php";
require_once "mainModel.php";

$insMainModel = new mainModel();

$colaborador_id = $_POST['colaborador_id'];
$result = $insMainModel->getColaboradoresEdit($colaborador_id);

if($result && $result->num_rows > 0) {
    $valores2 = $result->fetch_assoc();
    
    $data = array(
        "nombre" => $valores2['nombre'],
        "identidad" => $valores2['identidad'],
        "telefono" => $valores2['telefono'],						
        "puestos_id" => $valores2['puestos_id'],
        "empresa_id" => $valores2['empresa_id'],		
        "estado" => $valores2['estado'],
        "colaboradores_id" => $valores2['colaboradores_id'],	
        "fecha_ingreso" => $valores2['fecha_ingreso'],
        "fecha_egreso" => $valores2['fecha_egreso'],
        "nombre_completo" => $valores2['nombre']
    );

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se encontró el colaborador"
    ]);
}