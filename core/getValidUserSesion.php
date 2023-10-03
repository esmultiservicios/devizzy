<?php	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	$insMainModel = new mainModel();

	$username = $_POST['email'];
	$password = $insMainModel->encryption($_POST['pass']);
	$estatus = 1;	

	$mysqli = $insMainModel->connection();

	$query = "SELECT u.*, tu.nombre AS 'cuentaTipo', c.identidad
		FROM users AS u
		INNER JOIN tipo_user AS tu
		ON u.tipo_user_id = tu.tipo_user_id 
		INNER JOIN colaboradores AS c
		ON u.colaboradores_id = c.colaboradores_id
		WHERE BINARY u.email = '$username' AND u.password = '$password' AND u.estado = '$estatus'
		GROUP by u.tipo_user_id";
	
	$result = $mysqli->query($query) or die($mysqli->error);
	
	if($result->num_rows>0){
		echo 1;
	}else{
		echo 0;
	}
?>