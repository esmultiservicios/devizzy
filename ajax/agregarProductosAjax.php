<?php
	$peticionAjax = true;
	require_once "../core/configGenerales.php";
	
	if(isset($_POST['almacen']) && isset($_POST['medida']) && isset($_POST['producto']) && isset($_POST['descripcion']) && isset($_POST['precio_compra']) && isset($_POST['precio_venta']) && isset($_POST['precio_mayoreo'])){
		require_once "../controladores/productosControlador.php";
		$insVarios = new ProductosControlador();

		echo $insVarios->agregar_productos_controlador();
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
?>	