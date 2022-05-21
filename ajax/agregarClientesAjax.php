<?php	
	$peticionAjax = true;
	require_once "../core/configGenerales.php";
	
	if(isset($_POST['nombre_clientes']) && isset($_POST['identidad_clientes']) && isset($_POST['fecha_clientes']) && isset($_POST['departamento_cliente']) && isset($_POST['municipio_cliente'])){
		require_once "../controladores/clientesControlador.php";
		$insVarios = new clientesControlador();
		
		echo $insVarios->agregar_clientes_controlador();
	}else{
		echo "
			<script>
				swal({
					title: 'Error', 
					text: 'Los datos son incorrectos por favor corregir',
					type: 'error', 
					confirmButtonClass: 'btn-danger'
				});			
			</script>";
	}