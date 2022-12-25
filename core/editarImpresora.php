<?php
	header("Content-Type: text/html;charset=utf-8");
	
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
	
	if(!isset($_SESSION['user_sd'])){ 
		session_start(['name'=>'SD']); 
	}

	$insMainModel = new mainModel();

	date_default_timezone_set('America/Tegucigalpa');
	$id = $_POST['id'];
    $estado = $_POST['estado'];

	
	$query = $insMainModel->updateImpresora($id,$estado);

	if($query){
		echo true;
	}else{
		echo false;
	}