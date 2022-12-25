<script>
$(document).ready(function() {
    listar_correos_configuracion(); 
    getSMTPSecure();
    getTipoCorreo();
});

//INICIO CORREO
var listar_correos_configuracion = function(){
	var table_correos_configuracion = $("#dataTableConfCorreos").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>core/llenarDataTableConfCorreos.php"
		},
		"columns":[
			{"data":"tipo_correo"},
			{"data":"server"},	
			{"data":"correo"},
			{"data":"port"},	
			{"data":"smtp_secure"},											
			{"defaultContent":"<button class='table_editar btn btn-dark ocultar'><span class='fas fa-edit'></span></button>"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,//esta se encuenta en el archivo main.js
		"dom": dom,
		"columnDefs": [
		  { width: "22.66%", targets: 0 },
		  { width: "23.66%", targets: 1 },
		  { width: "23.66%", targets: 2 },
		  { width: "6.66%", targets: 3 },
		  { width: "6.66%", targets: 4 },
		  { width: "6.66%", targets: 5 }		  		  		  		  
		],		
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Correos',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_correos_configuracion();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Correos',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-success ocultar',
				exportOptions: {
						columns: [0,1,2,3,4]
				},				
			},
			{
				extend:    'pdf',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				title: 'Reporte Correos',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [0,1,2,3,4]
				},				
				customize: function ( doc ) {
					doc.content.splice( 1, 0, {
						margin: [ 0, 0, 0, 12 ],
						alignment: 'left',
						image: imagen,//esta se encuenta en el archivo main.js
						width:100,
                        height:45
					} );
				}
			}
		],
		"drawCallback": function( settings ) {
        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
    	}
	});
	table_correos_configuracion.search('').draw();
	$('#buscar').focus();

	edit_correos_configuracion_dataTable("#dataTableConfCorreos tbody", table_correos_configuracion);
}

var edit_correos_configuracion_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_editar");
	$(tbody).on("click", "button.table_editar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarCorreo.php';
		$('#formConfEmails #correo_id').val(data.correo_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formConfEmails').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formConfEmails').attr({ 'data-form': 'update' });
				$('#formConfEmails').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarCorreoAjax.php' });
				$('#formConfEmails')[0].reset();
				$('#test_confEmails').show();
				$('#edi_confEmails').show();
				$('#formConfEmails #pro_correos').val("Editar");
				$('#formConfEmails #tipo_correo_confEmail').val(valores[0]);
				$('#formConfEmails #tipo_correo_confEmail').selectpicker('refresh');	
				$('#formConfEmails #serverConfEmail').val(valores[1]);
				$('#formConfEmails #correoConfEmail').val(valores[2]);
				$('#formConfEmails #puertoConfEmail').val(valores[3]);
				$('#formConfEmails #smtpSecureConfEmail').val(valores[4]);
				$('#formConfEmails #smtpSecureConfEmail').selectpicker('refresh');	
				$('#formConfEmails #passConfEmail').val(valores[6]);

				//DESHABILITAR OBJETOS
				$('#formConfEmails #tipo_correo_confEmail').attr('disabled', true);

				$('#modalConfEmails').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}

$("#test_confEmails").on("click", function(e){
	e.preventDefault();
	var server = $('#formConfEmails #serverConfEmail').val();
	var correo = $('#formConfEmails #correoConfEmail').val();
	var password = $('#formConfEmails #passConfEmail').val();
	var port = $('#formConfEmails #puertoConfEmail').val();
	var smtpSecure = $('#formConfEmails #smtpSecureConfEmail').val();

	testEmail(server, correo, password, port, smtpSecure)
});

function testEmail(server, correo, password, port, smtpSecure){
    var url = '<?php echo SERVERURL;?>core/testEmail.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
		data:'server='+server+'&correo='+correo+'&password='+password+'&port='+port+'&smtpSecure='+smtpSecure,
        success: function(data){
			if(data == 1){
				swal({
					title: "Success",
					text: "Conexión realizada satisfactoriamente",
					type: "success",
				});
		  }else{
			swal({
					title: "Error",
					text: "Credenciales invalidas, por favor corregir, también recuerde en su servidor de correo: Activar Aplicaciones poco seguras (SmtpClientAuthentication)",
					type: "error",		  
		 	 });
		  }		
		}
     });	
}

function getSMTPSecure(){
    var url = '<?php echo SERVERURL;?>core/getSMTPSecure.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formConfEmails #smtpSecureConfEmail').html("");
			$('#formConfEmails #smtpSecureConfEmail').html(data);	
			$('#formConfEmails #smtpSecureConfEmail').selectpicker('refresh');	
		}
     });
}
//FIN CORREO

function getTipoCorreo(){
    var url = '<?php echo SERVERURL;?>core/getTipoCorreo.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formConfEmails #tipo_correo_confEmail').html("");
			$('#formConfEmails #tipo_correo_confEmail').html(data);
			$('#formConfEmails #tipo_correo_confEmail').selectpicker('refresh');			
		}
     });
}

</script>