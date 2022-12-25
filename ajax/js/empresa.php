<script>
$(document).ready(function() {
    listar_empresa();
});

//INICIO ACCIONES FROMULARIO EMPRESA
var listar_empresa = function(){
	var table_empresa  = $("#dataTableEmpresa").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableEmpresa.php"
		},
		"columns":[
			{"data":"razon_social"},
			{"data":"nombre"},
			{"data":"telefono"},
			{"data":"correo"},
			{"data":"rtn"},
			{"data":"ubicacion"},
			{"defaultContent":"<button class='table_editar btn btn-dark ocultar'><span class='fas fa-edit fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_eliminar btn btn-dark ocultar'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "21.5%", targets: 0 },
		  { width: "12.5%", targets: 1 },
		  { width: "12.5%", targets: 2 },
		  { width: "12.5%", targets: 3 },
		  { width: "10.5%", targets: 4 },
		  { width: "21.5%", targets: 5 },
		  { width: "4.5%", targets: 6 },
		  { width: "4.5%", targets: 6 }		  
		],
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Empresa',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_empresa();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg"></i> Ingresar',
				titleAttr: 'Agregar Empresa',
				className: 'table_crear btn btn-primary ocultar',
				action: 	function(){
					modal_empresa();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte de Empresa',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-success ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5]
				}				
			},
			{
				extend:    'pdf',
				orientation: 'landscape',
				pageSize: 'LEGAL',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				title: 'Reporte de Empresa',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5]
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
	table_empresa.search('').draw();
	$('#buscar').focus();

	editar_empresa_dataTable("#dataTableEmpresa tbody", table_empresa);
	eliminar_empresa_dataTable("#dataTableEmpresa tbody", table_empresa);
}

var editar_empresa_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_editar");
	$(tbody).on("click", "button.table_editar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarEmpresa.php';
		$('#formEmpresa #empresa_id').val(data.empresa_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formEmpresa').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formEmpresa').attr({ 'data-form': 'update' });
				$('#formEmpresa').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarEmpreasAjax.php' });
				$('#formEmpresa')[0].reset();
				$('#reg_empresa').hide();
				$('#edi_empresa').show();
				$('#delete_empresa').hide();
				$('#formEmpresa #empresa_empresa').val(valores[0]);
				$('#formEmpresa #telefono_empresa').val(valores[1]);
				$('#formEmpresa #correo_empresa').val(valores[2]);
				$('#formEmpresa #rtn_empresa').val(valores[3]);
				$('#formEmpresa #direccion_empresa').val(valores[4]);
				$('#formEmpresa #empresa_razon_social').val(valores[6]);
				$('#formEmpresa #empresa_otra_informacion').val(valores[7]);
				$('#formEmpresa #empresa_eslogan').val(valores[8]);
				$('#formEmpresa #empresa_celular').val(valores[9]);
				$('#formEmpresa #facebook_empresa').val(valores[10]);
				$('#formEmpresa #sitioweb_empresa').val(valores[11]);				
				$('#formEmpresa #horario_empresa').val(valores[12]);

				if(valores[5] == 1){
					$('#formEmpresa #empresa_activo').attr('checked', true);
				}else{
					$('#formEmpresa #empresa_activo').attr('checked', false);
				}

				//HABILITAR OBJETOS
				$('#formEmpresa #empresa_empresa').attr('readonly', false);
				$('#formEmpresa #rtn_empresa').attr('readonly', false);
				$('#formEmpresa #telefono_empresa').attr('readonly', false);
				$('#formEmpresa #correo_empresa').attr('readonly', false);
				$('#formEmpresa #direccion_empresa').attr('readonly', false);
				$('#formEmpresa #empresa_activo').attr('disabled', false);
				$('#formEmpresa #empresa_razon_social').attr('readonly', false);
				$('#formEmpresa #empresa_otra_informacion').attr('readonly', false);
				$('#formEmpresa #empresa_eslogan').attr('disabled', false);
				$('#formEmpresa #empresa_celular').attr('disabled', false);

				$('#formEmpresa #proceso_empresa').val("Editar");
				$('#modal_registrar_empresa').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}

var eliminar_empresa_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_eliminar");
	$(tbody).on("click", "button.table_eliminar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarEmpresa.php';
		$('#formEmpresa #empresa_id').val(data.empresa_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formEmpresa').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formEmpresa').attr({ 'data-form': 'delete' });
				$('#formEmpresa').attr({ 'action': '<?php echo SERVERURL;?>ajax/eliminarEmpresaAjax.php' });
				$('#formEmpresa')[0].reset();
				$('#reg_empresa').hide();
				$('#edi_empresa').hide();
				$('#delete_empresa').show();
				$('#formEmpresa #empresa_empresa').val(valores[0]);
				$('#formEmpresa #rtn_empresa').val(valores[1]);
				$('#formEmpresa #telefono_empresa').val(valores[2]);
				$('#formEmpresa #correo_empresa').val(valores[3]);
				$('#formEmpresa #direccion_empresa').val(valores[4]);
				$('#formEmpresa #empresa_razon_social').val(valores[6]);
				$('#formEmpresa #empresa_otra_informacion').val(valores[7]);
				$('#formEmpresa #empresa_eslogan').val(valores[8]);
				$('#formEmpresa #empresa_celular').val(valores[9]);

				if(valores[5] == 1){
					$('#formEmpresa #empresa_activo').attr('checked', true);
				}else{
					$('#formEmpresa #empresa_activo').attr('checked', false);
				}

				//DESHABILITAR OBJETOS
				$('#formEmpresa #empresa_empresa').attr('readonly', true);
				$('#formEmpresa #rtn_empresa').attr('readonly', true);
				$('#formEmpresa #telefono_empresa').attr('readonly', true);
				$('#formEmpresa #correo_empresa').attr('readonly', true);
				$('#formEmpresa #direccion_empresa').attr('readonly', true);
				$('#formEmpresa #empresa_activo').attr('disabled', true);
				$('#formEmpresa #empresa_razon_social').attr('readonly', true);
				$('#formEmpresa #empresa_otra_informacion').attr('readonly', true);
				$('#formEmpresa #empresa_eslogan').attr('disabled', true);
				$('#formEmpresa #empresa_celular').attr('disabled', true);

				$('#formEmpresa #proceso_empresa').val("Eliminar");
				$('#modal_registrar_empresa').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});

			}
		});
	});
}
//FIN ACCIONES FROMULARIO EMPRESA

/*INICIO FORMULARIO EMPRESA*/
function modal_empresa(){
	$('#formEmpresa').attr({ 'data-form': 'save' });
	$('#formEmpresa').attr({ 'action': '<?php echo SERVERURL;?>ajax/agregarEmpresaAjax.php' });
	$('#formEmpresa')[0].reset();
	$('#reg_empresa').show();
	$('#edi_empresa').hide();
	$('#delete_empresa').hide();

	//HABILITAR OBJETOS
	$('#formEmpresa #empresa_empresa').attr('readonly', false);
	$('#formEmpresa #rtn_empresa').attr('readonly', false);
	$('#formEmpresa #telefono_empresa').attr('readonly', false);
	$('#formEmpresa #correo_empresa').attr('readonly', false);
	$('#formEmpresa #direccion_empresa').attr('readonly', false);
	$('#formEmpresa #empresa_activo').attr('disabled', false);
	$('#formEmpresa #empresa_razon_social').attr('readonly', false);
	$('#formEmpresa #empresa_otra_informacion').attr('readonly', false);
	$('#formEmpresa #empresa_eslogan').attr('disabled', false);
	$('#formEmpresa #empresa_celular').attr('disabled', false);

	$('#formEmpresa #proceso_empresa').val("Registro");
	$('#modal_registrar_empresa').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
}
/*FIN FORMULARIO EMPRESA*/

$(document).ready(function(){
    $("#modal_registrar_empresa").on('shown.bs.modal', function(){
        $(this).find('#formEmpresa #empresa_razon_social').focus();
    });
});

$('#formEmpresa #label_empresa_activo').html("Activo");
	
$('#formEmpresa .switch').change(function(){    
    if($('input[name=empresa_activo]').is(':checked')){
        $('#formEmpresa #label_empresa_activo').html("Activo");
        return true;
    }
    else{
        $('#formEmpresa #label_empresa_activo').html("Inactivo");
        return false;
    }
});	

</script>