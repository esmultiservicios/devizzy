<?php
	$peticionAjax = true;
	require_once "configGenerales.php";
	require_once "mainModel.php";
    require_once "Database.php";

    $database = new Database();
	
	$insMainModel = new mainModel();

    if(!isset($_SESSION['user_sd'])){ 
        session_start(['name'=>'SD']); 
    }

    $empresa_id = $_SESSION['empresa_id_sd'];

    $tablaEmpresa = "empresa";
    $camposEpresa = ["logotipo"];
    $condiciones = ["empresa_id" => $empresa_id];
    $orderBy = "";
    $resultadoClientes = $database->consultarTabla($tablaEmpresa, $camposEpresa, $condiciones, $orderBy);

    if (!empty($resultadoClientes)) {
        $image = $resultadoClientes[0]['logotipo'];
    } else {
        $image = "logo.png";
    }
    
    $imageVersion = time(); // Generar un valor de tiempo único
    $imageNombre = $image ? $image . "?v=$imageVersion" : "logo.png?v=$imageVersion";
    
    // Devolver la URL completa de la imagen
    $imageUrl = SERVERURL."vistas/plantilla/img/logos/".$imageNombre;
    
    echo $imageUrl;
?>