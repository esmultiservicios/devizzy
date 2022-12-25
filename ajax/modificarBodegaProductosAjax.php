<?php	
	$peticionAjax = true;
	require_once "../core/configGenerales.php";

	if(isset($_POST['productos_id']) && isset($_POST['id_bodega'])){
		require_once "../controladores/productosControlador.php";
		$insVarios = new productosControlador();
		
		echo $insVarios->edit_bodega_productos_controlador();
	}else{
		echo "
			<script>
				swal({
					title: 'Error Transferencia', 
					text: 'Los datos son incorrectos por favor corregir',
					type: 'error', 
					confirmButtonClass: 'btn-danger'
				});			
			</script>";
	}
?>	