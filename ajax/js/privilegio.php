<script>
$(document).ready(function() {
    listar_privilegio(); 
	getMenus();
	getSubMenus();
	getSubMenu1();
});

//INICIO ACCIONES FROMULARIO PRIVILEGIOS
var listar_privilegio = function(){
	var table_privilegio  = $("#dataTablePrivilegio").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTablePrivilegio.php"
		},
		"columns":[
			{"data":"nombre"},
			{"defaultContent":"<button class='table_accesos menu btn btn-dark'><span class='fas fa-bars fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_accesos submenu btn btn-dark'><span class='fas fa-bars fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_accesos submenu1 btn btn-dark'><span class='fas fa-bars fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_editar1 btn btn-dark'><span class='fas fa-edit fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_eliminar1 btn btn-dark'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "89.33%", targets: 0 },
		  { width: "5.33%", targets: 1 },
		  { width: "5.33%", targets: 2 }
		],		
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Privilegios',
				className: 'btn btn-secondary',
				action: 	function(){
					listar_privilegio();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg"></i> Ingresar',
				titleAttr: 'Agregar Privilegios',
				className: 'btn btn-primary',
				action: 	function(){
					modal_privilegios();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Privilegios',
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
				title: 'Reporte Privilegios',
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
	table_privilegio.search('').draw();
	$('#buscar').focus();

	accesos_privilegio_menu_dataTable("#dataTablePrivilegio tbody", table_privilegio);
	accesos_privilegio_submenu_dataTable("#dataTablePrivilegio tbody", table_privilegio);
	accesos_privilegio_submenu1_dataTable("#dataTablePrivilegio tbody", table_privilegio);
	editar_privilegio_dataTable("#dataTablePrivilegio tbody", table_privilegio);
	eliminar_privilegio_dataTable("#dataTablePrivilegio tbody", table_privilegio);
}

var accesos_privilegio_menu_dataTable = function(tbody, table){
	$(tbody).off("click", "button.menu");
	$(tbody).on("click", "button.menu", function(){
		var data = table.row( $(this).parents("tr") ).data();		
		getAccesoControlMenus(data.privilegio_id, data.nombre);
		listar_menuaccesos();
		$('#modal_registrar_menuaccesos').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});	
	});
}

var accesos_privilegio_submenu_dataTable = function(tbody, table){
	$(tbody).off("click", "button.submenu");
	$(tbody).on("click", "button.submenu", function(){
		var data = table.row( $(this).parents("tr") ).data();		
		getAccesoControlSubMenus(data.privilegio_id, data.nombre);	
		listar_submenuaccesos();
		$('#modal_registrar_submenuaccesos').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});	
	});
}

var accesos_privilegio_submenu1_dataTable = function(tbody, table){
	$(tbody).off("click", "button.submenu1");
	$(tbody).on("click", "button.submenu1", function(){
		var data = table.row( $(this).parents("tr") ).data();		
		getAccesoControlSubMenus1(data.privilegio_id, data.nombre);
		listar_submen1uaccesos();
		$('#modal_registrar_submenu1accesos').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});	
	});
}

/*INCIO MENU ACCESOS*/
var listar_menuaccesos = function(){
	var privilegio_id_accesos = $("#formMenuAccesos #privilegio_id_accesos").val();

	var table_menuaccesos  = $("#dataTableMenuAccesos").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableMenuAccesos.php",
			"data":{
				"privilegio_id_accesos":privilegio_id_accesos,
			}
		},
		"columns":[
			{"data":"privilegio"},
			{"data":"menu"},
			{"defaultContent":"<button class='table_accesos eliminar btn btn-dark'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu20,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "48.33%", targets: 0 },
		  { width: "49.33%", targets: 1 },
		  { width: "2.33%", targets: 2 }
		],		
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Acceso Menus',
				className: 'btn btn-secondary',
				action: 	function(){
					listar_menuaccesos();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Acceso Menus',
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
				title: 'Reporte Acceso Menus',
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
	table_menuaccesos.search('').draw();
	$('#buscar').focus();
}

$(document).ready(function(){
	$("#modal_registrar_menuaccesos").on('shown.bs.modal', function(){
		$(this).find('#formMenuAccesos #buscar').focus();
	});
});	

function getAccesoControlMenus(privilegio_id, nombre){
	var url = '<?php echo SERVERURL;?>core/getMenuPrivilegios.php';	
	$('#formMenuAccesos #proceso_privilegios').val("Registrar");
	$('#formMenuAccesos #privilegio_id_accesos').val(privilegio_id);
	$('#formMenuAccesos #privilegio').val(nombre);
}

function getMenus(){
    var url = '<?php echo SERVERURL;?>core/getMenus.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formMenuAccesos #menus').html("");
			$('#formMenuAccesos #menus').html(data);
			$('#formMenuAccesos #menus').selectpicker('refresh');
			
		    $('#formSubMenuAccesos #menus').html("");
			$('#formSubMenuAccesos #menus').html(data);
			$('#formSubMenuAccesos #menus').selectpicker('refresh');				
		}
     });
}
/*FIN MENU ACCESOS*/

/*INCIO SUBMENU ACCESOS*/
var listar_submenuaccesos = function(){
	var privilegio_id_accesos = $("#formSubMenuAccesos #privilegio_id_accesos").val();

	var table_submenuaccesos  = $("#dataTableSubMenuAccesos").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableSubMenuAccesos.php",
			"data":{
				"privilegio_id_accesos":privilegio_id_accesos,
			}
		},
		"columns":[
			{"data":"privilegio"},
			{"data":"menu"},
			{"data":"submenu"},
			{"defaultContent":"<button class='table_accesos eliminar btn btn-dark'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu20,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "31%", targets: 0 },
		  { width: "31%", targets: 1 },
		  { width: "36%", targets: 2 },
		  { width: "2%", targets: 3 }
		],		
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Sub Acceso Menus',
				className: 'btn btn-secondary',
				action: 	function(){
					listar_menuaccesos();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Acceso Sub Menus',
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
				title: 'Reporte Acceso Sub Menus',
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
	table_submenuaccesos.search('').draw();
	$('#buscar').focus();
}

$(document).ready(function(){
	$("#modal_registrar_submenuaccesos").on('shown.bs.modal', function(){
		$(this).find('#formSubMenuAccesos #buscar').focus();
	});
});	

function getAccesoControlSubMenus(privilegio_id, nombre){
	var url = '<?php echo SERVERURL;?>core/getMenuPrivilegios.php';	
	$('#formSubMenuAccesos #proceso_privilegios').val("Registrar");
	$('#formSubMenuAccesos #privilegio_id_accesos').val(privilegio_id);
	$('#formSubMenuAccesos #privilegio').val(nombre);
}

function getSubMenus(){
    var url = '<?php echo SERVERURL;?>core/getSubMenus.php';
	var menu_id = $('#formSubMenuAccesos #menus').val();

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
		data:'menu_id='+menu_id,
        success: function(data){
		    $('#formSubMenuAccesos #submenus').html("");
			$('#formSubMenuAccesos #submenus').html(data);
			$('#formSubMenuAccesos #submenus').selectpicker('refresh');				
		}
     });
}

$("#formSubMenuAccesos #menus").on("change", function(){
	getSubMenus();
});
/*FIN SUBMENU ACCESOS*/

/*INCIO SUBMENU1 ACCESOS*/
var listar_submen1uaccesos = function(){
	var privilegio_id_accesos = $("#formSubMenu1Accesos #privilegio_id_accesos").val();

	var table_submenu1accesos  = $("#dataTableSubMenu1Accesos").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableSubMenu1Accesos.php",
			"data":{
				"privilegio_id_accesos":privilegio_id_accesos,
			}
		},
		"columns":[
			{"data":"privilegio"},
			{"data":"submenu"},
			{"data":"submenu1"},
			{"defaultContent":"<button class='table_accesos eliminar btn btn-dark'><span class='fa fa-trash fa-lg'></span></button>"}
		],
        "lengthMenu": lengthMenu20,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "31%", targets: 0 },
		  { width: "31%", targets: 1 },
		  { width: "36%", targets: 2 },
		  { width: "2%", targets: 3 }
		],		
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Acceso Sub Menus',
				className: 'btn btn-secondary',
				action: 	function(){
					listar_menuaccesos();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Acceso Sub Menus',
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
				title: 'Reporte Acceso Sub Menus',
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
	table_submenu1accesos.search('').draw();
	$('#buscar').focus();
}

$(document).ready(function(){
	$("#modal_registrar_submenu1accesos").on('shown.bs.modal', function(){
		$(this).find('#formSubMenu1Accesos #buscar').focus();
	});
});	

function getAccesoControlSubMenus1(privilegio_id, nombre){
	var url = '<?php echo SERVERURL;?>core/getMenuPrivilegios.php';	
	$('#formSubMenu1Accesos #proceso_privilegios').val("Registrar");
	$('#formSubMenu1Accesos #privilegio_id_accesos').val(privilegio_id);
	$('#formSubMenu1Accesos #privilegio').val(nombre);
}

function getSubMenu1(){
    var url = '<?php echo SERVERURL;?>core/getSubMenus1.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formSubMenu1Accesos #menus').html("");
			$('#formSubMenu1Accesos #menus').html(data);
			$('#formSubMenu1Accesos #menus').selectpicker('refresh');				
		}
     });
}

function getSubMenusConsulta(){
    var url = '<?php echo SERVERURL;?>core/getSubMenusConsulta.php';
	var menu_id = $('#formSubMenu1Accesos #menus').val();

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
		data:'menu_id='+menu_id,
        success: function(data){
		    $('#formSubMenu1Accesos #submenus').html("");
			$('#formSubMenu1Accesos #submenus').html(data);
			$('#formSubMenu1Accesos #submenus').selectpicker('refresh');				
		}
     });
}

$("#formSubMenu1Accesos #menus").on("change", function(){
	getSubMenusConsulta();
});
/*FIN SUBMENU1 ACCESOS*/

var editar_privilegio_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_editar1");
	$(tbody).on("click", "button.table_editar1", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarPrivilegios.php';
		$('#formPrivilegios #privilegio_id_').val(data.privilegio_id);
		$('#formPrivilegios #privilegio_nombre').val(data.nombre);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formPrivilegios').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formPrivilegios').attr({ 'data-form': 'update' });
				$('#formPrivilegios').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarPrivilegioAjax.php' });
				$('#formPrivilegios')[0].reset();
				$('#reg_privilegios').hide();
				$('#edi_privilegios').show();
				$('#delete_privilegios').hide();
				$('#formPrivilegios #privilegios_nombre').val(valores[0]);

				if(valores[1] == 1){
					$('#formPrivilegios #privilegio_activo').attr('checked', true);
				}else{
					$('#formPrivilegios #privilegio_activo').attr('checked', false);
				}

				//HABILITAR OBJETOS
				$('#formPrivilegios #privilegios_nombre').attr('readonly', false);
				$('#formPrivilegios #privilegio_activo').attr('disabled', false);
				$('#formPrivilegios #estado_privilegios').show();

				$('#formPrivilegios #proceso_privilegios').val("Editar");
				$('#modal_registrar_privilegios').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}

var eliminar_privilegio_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_eliminar1");
	$(tbody).on("click", "button.table_eliminar1", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarPrivilegios.php';
		$('#formPrivilegios #privilegio_id_').val(data.privilegio_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formPrivilegios').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formPrivilegios').attr({ 'data-form': 'delete' });
				$('#formPrivilegios').attr({ 'action': '<?php echo SERVERURL;?>ajax/eliminarPrivilegioAjax.php' });
				$('#formPrivilegios')[0].reset();
				$('#reg_privilegios').hide();
				$('#edi_privilegios').hide();
				$('#delete_privilegios').show();
				$('#formPrivilegios #privilegios_nombre').val(valores[0]);

				if(valores[1] == 1){
					$('#formPrivilegios #privilegio_activo').attr('checked', true);
				}else{
					$('#formPrivilegios #privilegio_activo').attr('checked', false);
				}

				//DESHABIITAR OBJETOS
				$('#formPrivilegios #privilegios_nombre').attr('readonly', true);
				$('#formPrivilegios #privilegio_activo').attr('disabled', true);				
				$('#formPrivilegios #estado_privilegios').hide();

				$('#formPrivilegios #proceso_privilegios').val("Eliminar");
				$('#modal_registrar_privilegios').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}
//FIN ACCIONES FROMULARIO PRIVILEGIOS

/*INICIO FORMULARIO PRIVILEGIOS*/
function modal_privilegios(){
	$('#formPrivilegios').attr({ 'data-form': 'save' });
	$('#formPrivilegios').attr({ 'action': '<?php echo SERVERURL;?>ajax/agregarPrivilegiosAjax.php' });
	$('#formPrivilegios')[0].reset();
	$('#reg_privilegios').show();
	$('#edi_privilegios').hide();
	$('#delete_privilegios').hide();

	//HABILITAR OBJETOS
	$('#formPrivilegios #privilegios_nombre').attr('readonly', false);
	$('#formPrivilegios #privilegio_activo').attr('disabled', false);
	$('#formPrivilegios #estado_privilegios').hide();

	$('#formPrivilegios #proceso_privilegios').val("Registro");
	$('#modal_registrar_privilegios').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
}

$(document).ready(function(){
	$("#modal_registrar_privilegios").on('shown.bs.modal', function(){
		$(this).find('#formPrivilegios #privilegios_nombre').focus();
	});
});	
/*FIN FORMULARIO PRIVILEGIOS*/

</script>