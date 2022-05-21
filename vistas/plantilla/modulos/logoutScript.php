<script>	
$(document).ready(function() {
	$('.btn-exit-system').on('click', function(e){
		e.preventDefault();
		var token = $(this).attr('href');

		swal({
			title: "¿Esta seguro?",
			text: "Salir del sistema",
			type: "info",
			showCancelButton: true,
			confirmButtonText: "¡Si, deseo salir del sistema!",
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
			allowEscapeKey: false,
			allowOutsideClick: false
		}, function () {
		setTimeout(function () {
			salir(token);
		}, 2000);
		});
	
	});
});	

function salir(token){
	$.ajax({
		url: '<?php echo SERVERURL;?>ajax/loginAjax.php?token='+token,
		success: function(data){
			if(data==1){
				window.location.href = "<?php echo SERVERURL;?>login/";
			}else{
				swal({
					title: 'Ocurrio un error inesperado', 
					text: 'Por favor intenta de nuevo', 
					type: 'error', 
					confirmButtonClass: 'btn-danger',
					allowEscapeKey: false,
					allowOutsideClick: false
				});
			}
		},
		error: function(){
			swal({
				title: 'Ocurrio un error inesperado', 
				text: 'Por favor intenta de nuevo', 
				type: 'error', 
				confirmButtonClass: 'btn-danger',
				allowEscapeKey: false,
				allowOutsideClick: false
			});			
		}
	});	
}
</script>