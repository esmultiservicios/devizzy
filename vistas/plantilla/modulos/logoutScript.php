<script>	
$('.btn-exit-system').on('click', (e) => {
    e.preventDefault();
    const token = e.currentTarget.getAttribute('href');

    swal({
        title: "¿Está seguro?",
        text: "Salir del sistema",
        icon: "warning",
        buttons: true,
        dangerMode: false,
    }).then((willExit) => {
        if (willExit) {
            swal("¡Has salido del sistema!", "Salió con éxito", {
                icon: "success",
            }).then(() => {
                salir(token);
            });
        } else {
            swal({
				title: 'Tu sesión sigue activa.',
				text: 'Sesión Inactiva',				
				icon: 'warning'
			});
        }
    });
});

function salir(token){
	$.ajax({
		url: '<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8');?>ajax/loginAjax.php?token='+token,
		success: function(data){
			if(data==1){
				window.location.href = "<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8');?>login/";
			}else{
				swal({
					title: 'Ocurrio un error inesperado', 
					text: 'Por favor intenta de nuevo', 
					icon: 'error', 
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
				icon: 'error', 
				confirmButtonClass: 'btn-danger',
				allowEscapeKey: false,
				allowOutsideClick: false
			});			
		}
	});	
}
</script>