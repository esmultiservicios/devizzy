<?php
$peticionAjax = true;
require_once 'configGenerales.php';
require_once 'mainModel.php';

$insMainModel = new mainModel();

$ano_actual = date('Y'); // Año actual
$mes_actual = date('n'); // Mes actual

// Calcular los tres meses anteriores, excluyendo el mes actual
$meses_anterior = [];

for ($i = 1; $i <= 3; $i++) {
    $mes_calculado = $mes_actual - $i;
    
    if ($mes_calculado < 1) {
        $mes_calculado += 12;
        $ano_calculado = $ano_actual - 1;
    } else {
        $ano_calculado = $ano_actual;
    }

    $meses_anterior[] = ['mes' => $mes_calculado, 'ano' => $ano_calculado];
}

// Crear el filtro de meses para la consulta
$meses_in = implode(",", array_map(function($mes_ano) {
    return "'" . $mes_ano['ano'] . '-' . str_pad($mes_ano['mes'], 2, '0', STR_PAD_LEFT) . "'"; // Formato 'YYYY-MM'
}, $meses_anterior));

// Modificar la consulta SQL
$sql = "
SELECT 
    sub.mes,
    sub.producto,
    sub.total_vendido,
    sub.ano
FROM (
    SELECT 
        DATE_FORMAT(m.fecha_registro, '%Y-%m') AS mes,
        YEAR(m.fecha_registro) AS ano,
        CASE
            WHEN p.nombre LIKE '%dama%' THEN 'Dama'
            WHEN p.nombre LIKE '%caballero%' OR p.nombre LIKE '%hombre%' THEN 'Caballero'
            WHEN p.nombre LIKE '%NIÑO%' THEN 'NIÑO'
            WHEN p.nombre LIKE '%ROPA%' THEN 'ROPA'
            ELSE p.nombre
        END AS producto,
        SUM(m.cantidad_salida) AS total_vendido,
        RANK() OVER (
            PARTITION BY DATE_FORMAT(m.fecha_registro, '%Y-%m') 
            ORDER BY SUM(m.cantidad_salida) DESC
        ) AS ranking
    FROM 
        movimientos m
    JOIN 
        productos p ON m.productos_id = p.productos_id
    WHERE 
        m.cantidad_salida > 0
        AND CONCAT(YEAR(m.fecha_registro), '-', LPAD(MONTH(m.fecha_registro), 2, '0')) IN ($meses_in)
    GROUP BY 
        mes, ano, producto
) AS sub
WHERE 
    sub.ranking <= 6
ORDER BY 
    sub.ano DESC, sub.mes DESC;
";

$result = $insMainModel->ejecutarConsultaSimple($sql);

$arreglo = array();

while ($row = $result->fetch_assoc()) {
    // Si el total vendido es mayor a 0, lo agregamos al arreglo
    $total_vendido = (int)$row['total_vendido'];
    if ($total_vendido > 0) {
        $mes = (int) date('n', strtotime($row['mes']));
        $año = (int) date('Y', strtotime($row['mes']));

        $arreglo[] = array(
            'mes' => $insMainModel->nombremes($mes, $año),
            'producto' => $row['producto'],
            'total_vendido' => $total_vendido,
            'ano' => $row['ano']
        );
    }
}

echo json_encode($arreglo);