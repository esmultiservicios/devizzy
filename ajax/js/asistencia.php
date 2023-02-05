<script>
$(document).ready(function() {
	listar_asistencia();
	getColaboradores();
	$('#form_main_asistencia #estado').val(0);
	$('#form_main_asistencia #estado').selectpicker('refresh');	
});

//INICIO ACCIONES FROMULARIO PRIVILEGIOS
var listar_asistencia = function(){
	var estado = $('#form_main_asistencia #estado').val();
	var colaboradores_id = $('#form_main_asistencia #colaborador').val();
	var fechai = $('#form_main_asistencia #fechai').val();
	var fechaf = $('#form_main_asistencia #fechaf').val();

	var table_asistencia  = $("#dataTableAsistencia").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableAsistencia.php",
			"data":{
				"fechai":fechai,
				"fechaf":fechaf,
				"colaborador":colaboradores_id,
				"estado":estado
			}			
		},
		"columns":[
			{"data":"fecha"},
			{"data":"colaborador"},
			{"data":"estado"},
			{"defaultContent":"<button class='table_eliminar1 btn btn-dark'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "36%", targets: 0 },
		  { width: "37%", targets: 1 },
		  { width: "25%", targets: 2 },
		  { width: "2%", targets: 3 }
		],		
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Asistencia',
				className: 'btn btn-secondary',
				action: 	function(){
					listar_asistencia();
				}
			},		
			{
				text:      '<i class="fas fas fa-plus fa-lg"></i> Ingresar Asistencia',
				titleAttr: 'Agregar Asistencia',
				className: 'btn btn-primary',
				action: 	function(){
					modal_asistencia();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Asistencia',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'btn btn-success',
				exportOptions: {
						columns: [0]
				},
			},
			{
				extend:    'pdf',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				title: 'Reporte Asistencia',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'btn btn-danger',
				exportOptions: {
						columns: [0]
				},
				customize: function ( doc ) {
					doc.content.splice( 1, 0, {
						margin: [ 0, 0, 0, 12 ],
						alignment: 'left',
						image: imagen,
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
	table_asistencia.search('').draw();
	$('#buscar').focus();
}

function getColaboradores(){
    var url = '<?php echo SERVERURL;?>core/getColaboradores.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#form_main_asistencia #colaborador').html("");
			$('#form_main_asistencia #colaborador').html(data);
			$('#form_main_asistencia #colaborador').selectpicker('refresh');	
			
		    $('#formAsistencia #asistencia_empleado').html("");
			$('#formAsistencia #asistencia_empleado').html(data);
			$('#formAsistencia #asistencia_empleado').selectpicker('refresh');				
		}
     });
}

function modal_asistencia(){
	  $('#formAsistencia').attr({ 'data-form': 'save' });
	  $('#formAsistencia').attr({ 'action': '<?php echo SERVERURL;?>ajax/addAsistenciaAjax.php' });
	  $('#formAsistencia')[0].reset();
	  $('#reg_asistencia').show();	
	  $('#formAsistencia #proceso_asistencia').val("Registro");

	  $('#modal_registrar_asistencia').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	  });
}

setTimeout("showTime();", 1000);

$(document).ready(function(){	
	showTime();
});

function showTime(){
	myDate = new Date();
	hours = myDate.getHours();
	minutes = myDate.getMinutes();
	seconds = myDate.getSeconds();
	if (hours < 10) hours = 0 + hours;
	if (minutes < 10) minutes = "0" + minutes;
	if (seconds < 10) seconds = "0" + seconds;
	$('#formAsistencia #hora').val(hours+ ":" + minutes+ ":" + seconds);
}
</script>