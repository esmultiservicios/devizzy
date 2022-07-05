<script>
$(document).ready(function() {
    listar_privilegio(); 
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
			{"defaultContent":"<button class='table_accesos btn btn-dark'><span class='fas fa-bars fa-lg'></span></button>"},
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
				text:      '<i class="fas fas fa-plus fa-lg"></i> Crear',
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

	accesos_privilegio_dataTable("#dataTablePrivilegio tbody", table_privilegio);
	editar_privilegio_dataTable("#dataTablePrivilegio tbody", table_privilegio);
	eliminar_privilegio_dataTable("#dataTablePrivilegio tbody", table_privilegio);
}

var accesos_privilegio_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_accesos");
	$(tbody).on("click", "button.table_accesos", function(){
		var data = table.row( $(this).parents("tr") ).data();
		getAccesoControl(data.privilegio_id, data.nombre);

		$('#modal_menus_accesos').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});	
	});
}

function getAccesoControl(privilegio_id, nombre){
	var url = '<?php echo SERVERURL;?>core/getMenuPrivilegios.php';	
	$('#formMenuAccesos #privilegio_id_accesos').val(privilegio_id);
	$('#formMenuAccesos #privilegio_nombre_accesos').val(nombre);

	//OCULTAR SUBMENUS
	$('#formMenuAccesos #subMenuVentas').hide();
	$('#formMenuAccesos #subMenuCompras').hide();
	$('#formMenuAccesos #subMenuAlmacen').hide();	
	$('#formMenuAccesos #submenuContabilidad').hide();
	$('#formMenuAccesos #submenuContabilidad1').hide();
	$('#formMenuAccesos #submenuReportesHistorial').hide();
	$('#formMenuAccesos #submenuReportesHistorial1').hide();
	$('#formMenuAccesos #submenuReportesVentas').hide();
	$('#formMenuAccesos #submenuReportesVentas1').hide();
	$('#formMenuAccesos #submenuReportesCompras').hide();
	$('#formMenuAccesos #submenuReportesCompras1').hide();	
	
	$('#formMenuAccesos #submenuConfiguracion').hide();	

	$('#formMenuAccesos #menu_dashboard').attr('checked', false);
	$('#formMenuAccesos #menu_ventas').attr('checked', false);
	$('#formMenuAccesos #menu_clientes').attr('checked', false);
	$('#formMenuAccesos #menu_facturas').attr('checked', false);
	$('#formMenuAccesos #menu_cotizacion').attr('checked', false);
	$('#formMenuAccesos #menu_cajas').attr('checked', false);				
	$('#formMenuAccesos #menu_compras').attr('checked', false);
	$('#formMenuAccesos #menu_proveedores').attr('checked', false);
	$('#formMenuAccesos #menu_factura_compras').attr('checked', false);
	$('#formMenuAccesos #menu_almacen').attr('checked', false);
	$('#formMenuAccesos #menu_productos').attr('checked', false);
	$('#formMenuAccesos #menu_inventario').attr('checked', false);
	$('#formMenuAccesos #menu_contabilidad').attr('checked', false);
	$('#formMenuAccesos #menu_cuentasContabilidad').attr('checked', false);
	$('#formMenuAccesos #menu_movimientosContabilidad').attr('checked', false);
	$('#formMenuAccesos #menu_ingresosContabilidad').attr('checked', false);
	$('#formMenuAccesos #menu_gastosContabilidad').attr('checked', false);
	$('#formMenuAccesos #menu_chequesContabilidad').attr('checked', false);		
	$('#formMenuAccesos #menu_reportes').attr('checked', false);
	$('#formMenuAccesos #menu_reporte_historial').attr('checked', false);
	$('#formMenuAccesos #menu_historialAccesos').attr('checked', false);
	$('#formMenuAccesos #menu_bitacora').attr('checked', false);
	$('#formMenuAccesos #menu_reporte_ventas').attr('checked', false);
	$('#formMenuAccesos #menu_reporteVentas').attr('checked', false);
	$('#formMenuAccesos #menu_reporteCotizacion').attr('checked', false);
	$('#formMenuAccesos #menu_cobrarClientes').attr('checked', false);
	$('#formMenuAccesos #menu_reporte_compras').attr('checked', false);
	$('#formMenuAccesos #menu_reporteCompras').attr('checked', false);
	$('#formMenuAccesos #menu_pagarProveedores').attr('checked', false);
	$('#formMenuAccesos #menu_configuracion').attr('checked', false);
	$('#formMenuAccesos #menu_colaboradores').attr('checked', false);
	$('#formMenuAccesos #menu_puestos').attr('checked', false);
	$('#formMenuAccesos #menu_users').attr('checked', false);
	$('#formMenuAccesos #menu_secuencia').attr('checked', false);
	$('#formMenuAccesos #menu_empresa').attr('checked', false);
	$('#formMenuAccesos #menu_confAlmacen').attr('checked', false);
	$('#formMenuAccesos #menu_confUbicacion').attr('checked', false);
	$('#formMenuAccesos #menu_confMedida').attr('checked', false);
	$('#formMenuAccesos #menu_confHost').attr('checked', false);
	$('#formMenuAccesos #menu_confPlanes').attr('checked', false);
	$('#formMenuAccesos #menu_cajas').attr('checked', false);	
	$('#formMenuAccesos #menu_privilegio').attr('checked', false);	
	$('#formMenuAccesos #menu_tipoUser').attr('checked', false);			
			
	//CONSULTAS MENU
	$.ajax({
		type:'POST',
		url:url,
		data:'privilegio_id='+privilegio_id,
		success: function(registro){
			valores_menu = JSON.parse(registro);
			$('#formMenuAccesos').attr({ 'data-form': 'save' });
			$('#formMenuAccesos').attr({ 'action': '<?php echo SERVERURL;?>ajax/addMenuAccesosAjax.php' });
			$('#formMenuAccesos')[0].reset();
			$('#formMenuAccesos #privilegio_id_accesos').val(privilegio_id);
			$('#formMenuAccesos #privilegio_nombre_accesos').val(nombre);				
			$('#formMenuAccesos #pro_accesos').val("Asignar Accesos Privilegio: " + nombre);
			$('#reg_accessos').show();				
			
			try{
				for(var i=0; i < valores_menu.length; i++){
					if(valores_menu[i].estado == 1){
						$('#formMenuAccesos #menu_' + valores_menu[i].menu).attr('checked', true);
						$('#formMenuAccesos #label_menu_' + valores_menu[i].menu).html("Mostrar");
						
						if(valores_menu[i].menu == "ventas"){
							$('#formMenuAccesos #subMenuVentas').show();
						}
						
						if(valores_menu[i].menu == "compras"){
							$('#formMenuAccesos #subMenuCompras').show();
						}

						if(valores_menu[i].menu == "almacen"){
							$('#formMenuAccesos #subMenuAlmacen').show();
						}	

						if(valores_menu[i].menu == "contabilidad"){
							$('#formMenuAccesos #submenuContabilidad').show();
							$('#formMenuAccesos #submenuContabilidad1').show();
						}	
						
						if(valores_menu[i].menu == "reportes"){
							$('#formMenuAccesos #submenuReportesHistorial').show();
							$('#formMenuAccesos #submenuReportesVentas').show();
							$('#formMenuAccesos #submenuReportesCompras').show();
						}						

						if(valores_menu[i].menu == "configuracion"){
							$('#formMenuAccesos #submenuConfiguracion').show();
						}							
					}else{
						$('#formMenuAccesos #' + valores_menu[i].menu).attr('checked', false);
						$('#formMenuAccesos #label_menu_' + valores_menu[i].menu).html("Ocultar");	

						if(valores_menu[i].menu == "ventas"){
							$('#formMenuAccesos #subMenuVentas').hide();
						}
						
						if(valores_menu[i].menu == "compras"){
							$('#formMenuAccesos #subMenuCompras').hide();
						}

						if(valores_menu[i].menu == "almacen"){
							$('#formMenuAccesos #subMenuAlmacen').hide();
						}	

						if(valores_menu[i].menu == "contabilidad"){
							$('#formMenuAccesos #submenuContabilidad').hide();
							$('#formMenuAccesos #submenuContabilidad1').hide();
						}	
						
						if(valores_menu[i].menu == "reportes"){
							$('#formMenuAccesos #submenuReportesHistorial').hide();
							$('#formMenuAccesos #submenuReportesVentas').hide();
							$('#formMenuAccesos #submenuReportesCompras').hide();
						}							

						if(valores_menu[i].menu == "configuracion"){
							$('#formMenuAccesos #submenuConfiguracion').hide();
						}								
					}					
				}
			}catch(e){
				
			}			
		}
	});	

	//CONSULTA SUBMENUS
	var url = '<?php echo SERVERURL;?>core/getSubMenuPrivilegios.php';	
	$.ajax({
		type:'POST',
		url:url,
		data:'privilegio_id='+privilegio_id,
		success: function(registro){
			valores_submenu = JSON.parse(registro);
			
			try{
				for(var i=0; i < valores_submenu.length; i++){
					if(valores_submenu[i].estado == 1){
						$('#formMenuAccesos #menu_' + valores_submenu[i].submenu).attr('checked', true);
						$('#formMenuAccesos #label_menu_' + valores_submenu[i].submenu).html("Mostrar");	

						if(valores_submenu[i].submenu == "reporte_historial"){
							$('#formMenuAccesos #submenuReportesHistorial1').show();
						}
						
						if(valores_submenu[i].submenu == "reporte_ventas"){
							$('#formMenuAccesos #submenuReportesVentas1').show();
						}

						if(valores_submenu[i].submenu == "reporte_compras"){
							$('#formMenuAccesos #submenuReportesCompras1').show();
						}							
					}else{
						$('#formMenuAccesos #' + valores_submenu[i].submenu).attr('checked', false);
						$('#formMenuAccesos #label_menu_' + valores_submenu[i].submenu).html("Ocultar");		

						if(valores_submenu[i].submenu == "reporte_historial"){
							$('#formMenuAccesos #submenuReportesHistorial1').hide();
						}
						
						if(valores_submenu[i].submenu == "reporte_ventas"){
							$('#formMenuAccesos #submenuReportesVentas1').hide();
						}

						if(valores_submenu[i].submenu == "reporte_compras"){
							$('#formMenuAccesos #submenuReportesCompras1').hide();
						}
					}					
				}
			}catch(e){
				
			}
		}
	});	

	//CONSULTAR SUBMENUS1
	var url = '<?php echo SERVERURL;?>core/getSubMenuPrivilegios1.php';	
	$.ajax({
		type:'POST',
		url:url,
		data:'privilegio_id='+privilegio_id,
		success: function(registro){
			valores_submenu1 = JSON.parse(registro);

			try{
				for(var i=0; i < valores_submenu1.length; i++){

					if(valores_submenu1[i].estado == 1){
						$('#formMenuAccesos #menu_' + valores_submenu1[i].submenu1).attr('checked', true);
						$('#formMenuAccesos #label_menu_' + valores_submenu1[i].submenu1).html("Mostrar");						
					}else{
						$('#formMenuAccesos #' + valores_submenu1[i].submenu1).attr('checked', false);
						$('#formMenuAccesos #label_menu_' + valores_submenu1[i].submenu1).html("Ocultar");						
					}					
				}
			}catch(e){
				
			}
		}
	});		
}

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
/*FIN FORMULARIO PRIVILEGIOS*/

$(document).ready(function(){
    $("#modal_registrar_privilegios").on('shown.bs.modal', function(){
        $(this).find('#formPrivilegios #privilegios_nombre').focus();
    });
});

$('#formPrivilegios #label_privilegio_activo').html("Activo");
	
$('#formPrivilegios .switch').change(function(){    
    if($('input[name=privilegio_activo]').is(':checked')){
        $('#formPrivilegios #label_privilegio_activo').html("Activo");
        return true;
    }
    else{
        $('#formPrivilegios #label_privilegio_activo').html("Inactivo");
        return false;
    }
});	

//INICIO ACCESOS
//OCULTAR SUBMENUS
$('#formMenuAccesos #subMenuVentas').hide();
$('#formMenuAccesos #subMenuCompras').hide();
$('#formMenuAccesos #subMenuAlmacen').hide();	
$('#formMenuAccesos #submenuContabilidad').hide();
$('#formMenuAccesos #submenuReportesHistorial').hide();
$('#formMenuAccesos #submenuReportesHistorial1').hide();
$('#formMenuAccesos #submenuReportesVentas').hide();
$('#formMenuAccesos #submenuReportesVentas1').hide();
$('#formMenuAccesos #submenuReportesCompras').hide();
$('#formMenuAccesos #submenuReportesCompras1').hide();	

$('#formMenuAccesos #submenuConfiguracion').hide();		
	
$('#formMenuAccesos #label_menu_dashboard').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_dashboard]').is(':checked')){
		$('#formMenuAccesos #label_menu_dashboard').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_dashboard').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_ventas').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_ventas]').is(':checked')){
		$('#formMenuAccesos #label_menu_ventas').html("Mostrar");
		$('#formMenuAccesos #subMenuVentas').show();			
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_ventas').html("Ocultar");
		$('#formMenuAccesos #subMenuVentas').hide();
		$('#formMenuAccesos #menu_clientes').attr('checked', false);
		$('#formMenuAccesos #menu_facturas').attr('checked', false);
		return false;
	}
});		

$('#formMenuAccesos #label_menu_clientes').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_clientes]').is(':checked')){
		$('#formMenuAccesos #label_menu_clientes').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_clientes').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_facturas').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_facturas]').is(':checked')){
		$('#formMenuAccesos #label_menu_facturas').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_facturas').html("Ocultar");
		return false;
	}
});		

$('#formMenuAccesos #label_menu_compras').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_compras]').is(':checked')){
		$('#formMenuAccesos #label_menu_compras').html("Mostrar");
		$('#formMenuAccesos #subMenuCompras').show();			
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_compras').html("Ocultar");
		$('#formMenuAccesos #subMenuCompras').hide();
		$('#formMenuAccesos #menu_proveedores').attr('checked', false);
		$('#formMenuAccesos #menu_proveedores').attr('checked', false);			
		return false;
	}
});	

$('#formMenuAccesos #label_menu_proveedores').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_proveedores]').is(':checked')){
		$('#formMenuAccesos #label_menu_proveedores').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_proveedores').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_factura_compras').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_factura_compras]').is(':checked')){
		$('#formMenuAccesos #label_menu_factura_compras').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_factura_compras').html("Ocultar");
		return false;
	}
});		

$('#formMenuAccesos #label_menu_almacen').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_almacen]').is(':checked')){
		$('#formMenuAccesos #label_menu_almacen').html("Mostrar");
		$('#formMenuAccesos #subMenuAlmacen').show();				
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_almacen').html("Ocultar");
		$('#formMenuAccesos #subMenuAlmacen').hide();
		$('#formMenuAccesos #menu_productos').attr('checked', false);
		$('#formMenuAccesos #menu_inventario').attr('checked', false);				
		return false;
	}
});	

$('#formMenuAccesos #label_menu_productos').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_productos]').is(':checked')){
		$('#formMenuAccesos #label_menu_productos').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_productos').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_inventario').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_inventario]').is(':checked')){
		$('#formMenuAccesos #label_menu_inventario').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_inventario').html("Ocultar");
		return false;
	}
});		

//MENU CONTABILIDAD
$('#formMenuAccesos #label_menu_contabilidad').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_contabilidad]').is(':checked')){
		$('#formMenuAccesos #label_menu_contabilidad').html("Mostrar");
		$('#formMenuAccesos #submenuContabilidad').show();
		$('#formMenuAccesos #submenuContabilidad1').show();
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_contabilidad').html("Ocultar");
		$('#formMenuAccesos #submenuContabilidad').hide();
		$('#formMenuAccesos #submenuContabilidad1').hide();
		$('#formMenuAccesos #menu_cuentasContabilidad').attr('checked', false);
		$('#formMenuAccesos #menu_movimientosContabilidad').attr('checked', false);
		$('#formMenuAccesos #menu_ingresosContabilidad').attr('checked', false);
		$('#formMenuAccesos #menu_gastosContabilidad').attr('checked', false);
		$('#formMenuAccesos #menu_chequesContabilidad').attr('checked', false);
		$('#formMenuAccesos #menu_confCtaContabilidad').attr('checked', false);
		$('#formMenuAccesos #menu_confBancos').attr('checked', false);
		$('#formMenuAccesos #menu_confImpuestos').attr('checked', false);		
		return false;
	}
});	

$('#formMenuAccesos #label_menu_reportes').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_reportes]').is(':checked')){
		$('#formMenuAccesos #label_menu_reportes').html("Mostrar");
		$('#formMenuAccesos #submenuReportesHistorial').show();
		$('#formMenuAccesos #submenuReportesVentas').show();
		$('#formMenuAccesos #submenuReportesCompras').show();
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_reportes').html("Ocultar");
		$('#formMenuAccesos #submenuReportesHistorial').hide();
		$('#formMenuAccesos #submenuReportesVentas').hide();
		$('#formMenuAccesos #submenuReportesCompras').hide();
		$('#formMenuAccesos #menu_reporte_historial').attr('checked', false);
		$('#formMenuAccesos #menu_reporteVentas').attr('checked', false);
		$('#formMenuAccesos #menu_reporteCompras').attr('checked', false);		
		return false;
	}
});		

//INICIO SUB MENU REPORTES
$('#formMenuAccesos #label_menu_reporte_historial').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_reporte_historial]').is(':checked')){
		$('#formMenuAccesos #label_menu_reporte_historial').html("Mostrar");
		$('#formMenuAccesos #submenuReportesHistorial1').show();		
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_reporte_historial').html("Ocultar");
		$('#formMenuAccesos #submenuReportesHistorial1').hide();
		$('#formMenuAccesos #menu_historialAccesos').attr('checked', false);
		$('#formMenuAccesos #menu_bitacora').attr('checked', false);			
		return false;
	}
});	

$('#formMenuAccesos #label_menu_historialAccesos').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_historialAccesos]').is(':checked')){
		$('#formMenuAccesos #label_menu_historialAccesos').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_historialAccesos').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_bitacora').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_bitacora]').is(':checked')){
		$('#formMenuAccesos #label_menu_bitacora').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_bitacora').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_reporte_ventas').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_reporte_ventas]').is(':checked')){
		$('#formMenuAccesos #label_menu_reporte_ventas').html("Mostrar");
		$('#formMenuAccesos #submenuReportesVentas1').show();
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_reporte_ventas').html("Ocultar");
		$('#formMenuAccesos #submenuReportesVentas1').hide();
		$('#formMenuAccesos #menu_reporteVentas').attr('checked', false);
		$('#formMenuAccesos #menu_cobrarClientes').attr('checked', false);			
		return false;
	}
});	

$('#formMenuAccesos #label_menu_reporteVentas').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_reporteVentas]').is(':checked')){
		$('#formMenuAccesos #label_menu_reporteVentas').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_reporteVentas').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_cobrarClientes').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_cobrarClientes]').is(':checked')){
		$('#formMenuAccesos #label_menu_cobrarClientes').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_cobrarClientes').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_reporte_compras').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_reporte_compras]').is(':checked')){
		$('#formMenuAccesos #label_menu_reporte_compras').html("Mostrar");
		$('#formMenuAccesos #submenuReportesCompras1').show();		
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_reporteCompras').html("Ocultar");
		$('#formMenuAccesos #submenuReportesCompras1').hide();	
		$('#formMenuAccesos #label_menu_reporte_compras').attr('checked', false);
		$('#formMenuAccesos #menu_pagarProveedores').attr('checked', false);			
		return false;
	}
});	

$('#formMenuAccesos #label_menu_reporteCompras').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_reporteCompras]').is(':checked')){
		$('#formMenuAccesos #label_menu_reporteCompras').html("Mostrar");	
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_reporteCompras').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_pagarProveedores').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_pagarProveedores]').is(':checked')){
		$('#formMenuAccesos #label_menu_pagarProveedores').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_pagarProveedores').html("Ocultar");
		return false;
	}
});		
//FIN SUB MENU REPORTES

$('#formMenuAccesos #label_menu_configuracion').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_configuracion]').is(':checked')){
		$('#formMenuAccesos #label_menu_configuracion').html("Mostrar");
		$('#formMenuAccesos #submenuConfiguracion').show();			
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_configuracion').html("Ocultar");
		$('#formMenuAccesos #submenuConfiguracion').hide();
		$('#formMenuAccesos #menu_colaboradores').attr('checked', false);
		$('#formMenuAccesos #menu_puestos').attr('checked', false);
		$('#formMenuAccesos #menu_users').attr('checked', false);
		$('#formMenuAccesos #menu_secuencia').attr('checked', false);
		$('#formMenuAccesos #menu_empresa').attr('checked', false);
		$('#formMenuAccesos #menu_confAlmacen').attr('checked', false);
		$('#formMenuAccesos #menu_confUbicacion').attr('checked', false);
		$('#formMenuAccesos #menu_confMedida').attr('checked', false);		
		$('#formMenuAccesos #menu_cajas').attr('checked', false);		
		$('#formMenuAccesos #menu_privilegio').attr('checked', false);		
		$('#formMenuAccesos #menu_tipoUser').attr('checked', false);					
		return false;
	}
});	

$('#formMenuAccesos #label_menu_colaboradores').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_colaboradores]').is(':checked')){
		$('#formMenuAccesos #label_menu_colaboradores').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_colaboradores').html("Ocultar");
		return false;
	}
});		

$('#formMenuAccesos #label_menu_puestos').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_puestos]').is(':checked')){
		$('#formMenuAccesos #label_menu_puestos').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_puestos').html("Ocultar");
		return false;
	}
});		

$('#formMenuAccesos #label_menu_users').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_users]').is(':checked')){
		$('#formMenuAccesos #label_menu_users').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_users').html("Ocultar");
		return false;
	}
});		

$('#formMenuAccesos #label_menu_secuencia').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_secuencia]').is(':checked')){
		$('#formMenuAccesos #label_menu_secuencia').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_secuencia').html("Ocultar");
		return false;
	}
});			

$('#formMenuAccesos #label_menu_empresa').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_empresa]').is(':checked')){
		$('#formMenuAccesos #label_menu_empresa').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_empresa').html("Ocultar");
		return false;
	}
});			

$('#formMenuAccesos #label_menu_confAlmacen').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confAlmacen]').is(':checked')){
		$('#formMenuAccesos #label_menu_confAlmacen').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confAlmacen').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_confAlmacen').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confUbicacion]').is(':checked')){
		$('#formMenuAccesos #label_menu_confAlmacen').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confAlmacen').html("Ocultar");
		return false;
	}
});		

$('#formMenuAccesos #label_menu_confUbicacion').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confUbicacion]').is(':checked')){
		$('#formMenuAccesos #label_menu_confUbicacion').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confUbicacion').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_confMedida').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confMedida]').is(':checked')){
		$('#formMenuAccesos #label_menu_confMedida').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confMedida').html("Ocultar");
		return false;
	}
});			

$('#formMenuAccesos #label_menu_cajas').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_cajas]').is(':checked')){
		$('#formMenuAccesos #label_menu_cajas').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_cajas').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_privilegio').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_privilegio]').is(':checked')){
		$('#formMenuAccesos #label_menu_privilegio').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_privilegio').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_tipoUser').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_tipoUser]').is(':checked')){
		$('#formMenuAccesos #label_menu_tipoUser').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_tipoUser').html("Ocultar");
		return false;
	}
});	

//SUBMENU CONTABILIDAD
$('#formMenuAccesos #label_menu_cuentasContabilidad').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_cuentasContabilidad]').is(':checked')){
		$('#formMenuAccesos #label_menu_cuentasContabilidad').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_cuentasContabilidad').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_movimientosContabilidad').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_movimientosContabilidad]').is(':checked')){
		$('#formMenuAccesos #label_menu_movimientosContabilidad').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_movimientosContabilidad').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_ingresosContabilidad').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_ingresosContabilidad]').is(':checked')){
		$('#formMenuAccesos #label_menu_ingresosContabilidad').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_ingresosContabilidad').html("Ocultar");
		return false;
	}
});

$('#formMenuAccesos #label_menu_gastosContabilidad').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_gastosContabilidad]').is(':checked')){
		$('#formMenuAccesos #label_menu_gastosContabilidad').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_gastosContabilidad').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_chequesContabilidad').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_chequesContabilidad]').is(':checked')){
		$('#formMenuAccesos #label_menu_chequesContabilidad').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_chequesContabilidad').html("Ocultar");
		return false;
	}
});

$('#formMenuAccesos #label_menu_confCtaContabilidad').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confCtaContabilidad]').is(':checked')){
		$('#formMenuAccesos #label_menu_confCtaContabilidad').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confCtaContabilidad').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_confTipoPago').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confTipoPago]').is(':checked')){
		$('#formMenuAccesos #label_menu_confTipoPago').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confTipoPago').html("Ocultar");
		return false;
	}
});	

$('#formMenuAccesos #label_menu_confBancos').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confBancos]').is(':checked')){
		$('#formMenuAccesos #label_menu_confBancos').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confBancos').html("Ocultar");
		return false;
	}
});

$('#formMenuAccesos #label_menu_confImpuestos').html("Ocultar");

$('#formMenuAccesos .switch').change(function(){    
	if($('input[name=menu_confImpuestos]').is(':checked')){
		$('#formMenuAccesos #label_menu_confImpuestos').html("Mostrar");
		return true;
	}
	else{
		$('#formMenuAccesos #label_menu_confImpuestos').html("Ocultar");
		return false;
	}
});		
//FIN ACCESOS
</script>