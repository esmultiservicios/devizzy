<?php	
	$peticionAjax = true;
	require_once "../core/configGenerales.php";
	
	if(isset($_POST['usuarios_id']) && isset($_POST['correo_usuario']) && isset($_POST['tipo_user']) && isset($_POST['usuarios_activo']) && isset($_POST['privilegio_id'])){
		require_once "../controladores/usuarioControlador.php";
		$insVarios = new usuarioControlador();
		
		echo $insVarios->edit_user_controlador();
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