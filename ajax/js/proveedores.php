<script>
$(document).ready(function() {
    listar_proveedores();
});	

//INICIO ACCIONES FROMULARIO PROVEEDORES
var listar_proveedores = function(){
	var table_proveedores  = $("#dataTableProveedores").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableProveedores.php"
		},
		"columns":[
			{"data":"proveedor"},
			{"data":"rtn"},
			{"data":"localidad"},
			{"data":"telefono"},
			{"data":"correo"},
			{"data":"departamento"},
			{"data":"municipio"},
			{"defaultContent":"<button class='table_editar btn btn-dark ocultar'><span class='fas fa-edit fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_eliminar btn btn-dark ocultar'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "21.11%", targets: 0 },
		  { width: "11.11%", targets: 1 },
		  { width: "19.11%", targets: 2 },
		  { width: "11.11%", targets: 3 },
		  { width: "11.11%", targets: 4 },
		  { width: "11.11%", targets: 5 },
		  { width: "11.11%", targets: 6 },
		  { width: "2.11%", targets: 7 },
		  { width: "2.11%", targets: 8 }
		],
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Proveedores',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_proveedores();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg"></i> Crear',
				titleAttr: 'Agregar Proveedores',
				className: 'table_crear btn btn-primary ocultar',
				action: 	function(){
					modal_proveedores();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte de Proveedores',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				exportOptions: {
						columns: [0,1,2,3,4,5,6]
				},
				className: 'table_reportes btn btn-success ocultar'
			},
			{
				extend:    'pdf',
				orientation: 'landscape',
				pageSize: 'LEGAL',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				title: 'Reporte de Proveedores',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5,6]
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
	table_proveedores.search('').draw();
	$('#buscar').focus();

	editar_proveedores_dataTable("#dataTableProveedores tbody", table_proveedores);
	eliminar_proveedores_dataTable("#dataTableProveedores tbody", table_proveedores);
}

var editar_proveedores_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_editar");
	$(tbody).on("click", "button.table_editar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarProveedores.php';
		$('#formProveedores #proveedores_id').val(data.proveedores_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formProveedores').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formProveedores').attr({ 'data-form': 'update' });
				$('#formProveedores').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarProveedoresAjax.php' });
				$('#formProveedores')[0].reset();
				$('#reg_proveedor').hide();
				$('#edi_proveedor').show();
				$('#delete_proveedor').hide();
				$('#formProveedores #nombre_proveedores').val(valores[0]);
				$('#formProveedores #rtn_proveedores').val(valores[1]);
				$('#formProveedores #fecha_proveedores').attr('disabled', true);
				$('#formProveedores #fecha_proveedores').val(valores[2]);
				$('#formProveedores #departamento_proveedores').val(valores[3]);
				getMunicipiosProveedores(valores[3], valores[4]);
				$('#formProveedores #dirección_proveedores').val(valores[5]);
				$('#formProveedores #telefono_proveedores').val(valores[6]);
				$('#formProveedores #correo_proveedores').val(valores[7]);

				if(valores[8] == 1){
					$('#formProveedores #proveedores_activo').attr('checked', true);
				}else{
					$('#formProveedores #proveedores_activo').attr('checked', false);
				}

				//HABILITAR OBJETOS
				$('#formProveedores #nombre_proveedores').attr("readonly", false);
				$('#formProveedores #apellido_proveedores').attr("readonly", false);
				$('#formProveedores #departamento_proveedores').attr("disabled", false);
				$('#formProveedores #municipio_proveedores').attr("disabled", false);
				$('#formProveedores #dirección_proveedores').attr("disabled", false);
				$('#formProveedores #telefono_proveedores').attr("readonly", false);
				$('#formProveedores #correo_proveedores').attr("readonly", false);
				$('#formProveedores #proveedores_activo').attr("disabled", false);
				$('#formProveedores #estado_proveedores').show();

				//DESHABILITAR OBJETOS
				$('#formProveedores #rtn_proveedores').attr("readonly", true);

				$('#formProveedores #proceso_proveedores').val("Editar");
				$('#modal_registrar_proveedores').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}

var eliminar_proveedores_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_eliminar");
	$(tbody).on("click", "button.table_eliminar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarProveedores.php';
		$('#formProveedores #proveedores_id').val(data.proveedores_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formProveedores').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formProveedores').attr({ 'data-form': 'delete' });
				$('#formProveedores').attr({ 'action': '<?php echo SERVERURL;?>ajax/eliminarProveedoresAjax.php' });
				$('#formProveedores')[0].reset();
				$('#reg_proveedor').hide();
				$('#edi_proveedor').hide();
				$('#delete_proveedor').show();
				$('#formProveedores #nombre_proveedores').val(valores[0]);
				$('#formProveedores #rtn_proveedores').val(valores[1]);
				$('#formProveedores #fecha_proveedores').attr('disabled', true);
				$('#formProveedores #fecha_proveedores').val(valores[2]);
				$('#formProveedores #departamento_proveedores').val(valores[3]);
				getMunicipiosProveedores(valores[3], valores[4]);
				$('#formProveedores #dirección_proveedores').val(valores[5]);
				$('#formProveedores #telefono_proveedores').val(valores[6]);
				$('#formProveedores #correo_proveedores').val(valores[7]);

				if(valores[8] == 1){
					$('#formProveedores #proveedores_activo').attr('checked', true);
				}else{
					$('#formProveedores #proveedores_activo').attr('checked', false);
				}

				//DESHABILITAR OBJETOS
				$('#formProveedores #nombre_proveedores').attr("readonly", true);
				$('#formProveedores #apellido_proveedores').attr("readonly", true);
				$('#formProveedores #rtn_proveedores').attr("readonly", true);
				$('#formProveedores #fecha_proveedores').attr("readonly", true);
				$('#formProveedores #departamento_proveedores').attr("disabled", true);
				$('#formProveedores #municipio_proveedores').attr("disabled", true);
				$('#formProveedores #dirección_proveedores').attr("disabled", true);
				$('#formProveedores #telefono_proveedores').attr("readonly", true);
				$('#formProveedores #correo_proveedores').attr("readonly", true);
				$('#formProveedores #proveedores_activo').attr("disabled", true);
				$('#formProveedores #estado_proveedores').hide();

				$('#formProveedores #proceso_proveedores').val("Eliminar");
				$('#modal_registrar_proveedores').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}
//FIN ACCIONES FROMULARIO PROVEEDORES
/*FIN FORMULARIO PROVEEDORES*/

$(document).ready(function(){
    $("#modal_registrar_proveedores").on('shown.bs.modal', function(){
        $(this).find('#formProveedores #nombre_proveedores').focus();
    });
});

$('#formProveedores #label_proveedores_activo').html("Activo");

$('#formProveedores .switch').change(function(){    
    if($('input[name=proveedores_activo]').is(':checked')){
        $('#formProveedores #label_proveedores_activo').html("Activo");
        return true;
    }
    else{
        $('#formProveedores #label_proveedores_activo').html("Inactivo");
        return false;
    }
});
</script>