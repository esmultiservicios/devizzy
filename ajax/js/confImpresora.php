<script>
$(document).ready(function() {
	getImpresora();
});
//CONFIGURACION DE IMPRESORA    
var getImpresora = function(){
	var impresora_id;
	var activo;
	var descripcion;

	var table_impresora  = $("#dataTableConfImpresora").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableImpresora.php",
			"data":{
				"impresora_id":impresora_id,
				"descripcion":descripcion,
				"activo":activo
			}
		},
	"columns":[
		{"data":"descripcion"},
		{"data":"activo"},
		{ "defaultContent":"<button class='table_impresora btn btn-dark'><span class='fas fa-edit'></span></button>"}

	],
	"lengthMenu": lengthMenu,
	"stateSave": true,
	"bDestroy": true,
	"language": idioma_español,//esta se encuenta en el archivo main.js
	"dom": dom,
	"columnDefs": [
		{ width: "13.5%", targets: 0 ,className: "text-center"},
		{ width: "10.5%", targets: 1 ,className: "text-center"},
		{ width: "10.5%", targets: 2 ,className: "text-center" }

	],
	"buttons":[
		{
			text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
			titleAttr: 'Actualizar',
			className: 'table_actualizar btn btn-secondary ocultar',
			action: 	function(){
				getImpresora();
			}
		},
		{
			extend:    'excelHtml5',
			text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
			titleAttr: 'Excel',
			title: 'Reporte',
			messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
			className: 'table_reportes btn btn-success ocultar',
			exportOptions: {
					columns: [0,1]
			},
		},
		{
			extend:    'pdf',
			text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
			titleAttr: 'PDF',
			orientation: 'landscape',
			title: 'Reporte',
			messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
			className: 'table_reportes btn btn-danger ocultar',
			exportOptions: {
					columns: [0,1]
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
table_impresora.search('').draw();
$('#buscar').focus();

updateStatus("#dataTableConfImpresora tbody",table_impresora);
}
//FIN 

//CAMBIAR EL ESTATUS DE CONFIGURACION
var updateStatus = function(tbody, table){
	$(tbody).off("click", "button.table_impresora");
	$(tbody).on("click", "button.table_impresora", function(){
		var data = table.row( $(this).parents("tr") ).data();	
		swal({
			title: "Desea Cambiar el estado?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Activado!",
			cancelButtonText: "Desactivado!",
			closeOnConfirm: false,
			closeOnCancel: false
			},
			function(isConfirm){
				if (isConfirm) {
					swal("Estado de Impreso","Activado", "success");
					editarImpresora(data.impresora_id,1)
				} else {
					swal("Estado de Impreso","Desactivado", "success");
					editarImpresora(data.impresora_id,0)
				}
		});
	})
};

function editarImpresora (id,estado){
	var url = '<?php echo SERVERURL; ?>core/editarImpresora.php';

	$.ajax({
		type:'POST',
		url:url,
		data:{
			id: id,
			estado:estado
		},
			success: function(data){
				if(data){
					getImpresora();
				}else{
					swal({
						title: "Error",
						text: "No se realizo la operacion, comunicarse con el administrador",
						type: "error",
						confirmButtonClass: "btn-danger",
					});	
				}
			}
	});	
}
</script>
