<?php	

	$peticionAjax = true;

	require_once "configGenerales.php";

	require_once "mainModel.php";

	

	$insMainModel = new mainModel();

	

	$datos = [

		"fechai" => $_POST['fechai'],

		"fechaf" => $_POST['fechaf'],		

	];		

	
	$query = "SELECT  sum(e.subtotal) as 'subtotal', sum(e.impuesto) AS 'impuesto', sum(e.descuento) AS 'descuento',
     sum(e.nc) AS 'nc', sum(e.total) AS 'total'

     FROM egresos AS e

        INNER JOIN cuentas AS c

        ON e.cuentas_id = c.cuentas_id

        INNER JOIN proveedores AS p

        ON e.proveedores_id = p.proveedores_id

        WHERE CAST(e.fecha_registro AS DATE) BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND e.tipo_egreso = 2

        ORDER BY e.fecha_registro DESC";

    $result = $insMainModel->consulta_total_ingreso($query);

    $row = $result->fetch_assoc();

    echo json_encode($row);
   