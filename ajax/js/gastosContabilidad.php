<script>

$(document).ready(function() {

    listar_gastos_contabilidad();

    getEmpresaEgresos();

    getCuentaEgresos();

    getProveedorEgresos();

});



$('#formMainGastosContabilidad #search').on("click", function(e){

	e.preventDefault();

	listar_gastos_contabilidad();

});



//INICIO ACCIONES FORMULARIO EGRESOS
var total_gastos_footer = function(){	

var fechai = $("#formMainGastosContabilidad #fechai").val();

var fechaf = $("#formMainGastosContabilidad #fechaf").val();

$.ajax({
	url : '<?php echo SERVERURL;?>core/totalGastosFooter.php',
	type: "POST",
	data : {
		"fechai": fechai,
		"fechaf":fechaf
		}
	})
	.done(function(data) {
		data = JSON.parse(data)
		$("#total-footer-gastos").html("L. " + data.total);
		$("#subtotal-g").html("L. " + data.subtotal)
		$("#impuesto-g").html("L. " + data.impuesto)
		$("#descuento-g").html("L. " + data.descuento)
		$("#nc-g").html("L. " + data.nc)
		
	})
	.fail(function(data) {
		console.log( "total ingreso error" );
	
});


}

var listar_gastos_contabilidad = function(){	

	var fechai = $("#formMainGastosContabilidad #fechai").val();

	var fechaf = $("#formMainGastosContabilidad #fechaf").val();

	

	var table_gastos_contabilidad  = $("#dataTableGastosContabilidad").DataTable({

		"destroy":true,

		"ajax":{

			"method":"POST",

			"url":"<?php echo SERVERURL;?>core/llenarDataTableEgresosContabilidad.php",

			"data":{

				"fechai":fechai,

				"fechaf":fechaf

			}	

		},

		"columns":[
			{"data":"fecha_registro"},
			{"data":"egresos_id"},
			{"data":"fecha"},
			{"data":"nombre"},
			{"data":"proveedor"},
			{"data":"factura"},
			{"data":"subtotal"},
			{"data":"impuesto"},
			{"data":"descuento"},
			{"data":"nc"},
			{"data":"total"},
			{"defaultContent":"<button class='table_editar btn btn-dark ocultar'><span class='fas fa-edit'></span></button>"},
			{"defaultContent":"<button class='table_reportes print_gastos btn btn-dark ocultar'><span class='fas fa-file-download fa-lg'></span></button>"},			

		],	

        "lengthMenu": lengthMenu,

		"stateSave": true,

		"bDestroy": true,

		"language": idioma_español,

		"dom": dom,

		"columnDefs": [
		  { width: "8.33%", targets: 0 },
		  { width: "5.33%", targets: 1 }, 
		  { width: "8.33%", targets: 2 },
		  { width: "11.33%", targets: 3 },
		  { width: "8.33%", targets: 4 },
		  { width: "8.33%", targets: 5 },
		  { width: "8.33%", targets: 6 },
		  { width: "8.33%", targets: 7 },
		  { width: "8.33%", targets: 8 },
		  { width: "8.33%", targets: 9 },
		  { width: "8.33%", targets: 10 },
		  { width: "8.33%", targets: 11 },
		  { width: "8.33%", targets: 12 }
		],

		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Registro Gastos',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_gastos_contabilidad();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Crear',
				titleAttr: 'Agregar Egresos',
				className: 'table_crear btn btn-primary ocultar',
				action: 	function(){
					modal_egresos_contabilidad();
				}
			},			
			{
				extend:    'excelHtml5',footer:true,
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Registro Gastos',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8,9,10]
				},
				className: 'table_reportes btn btn-success ocultar'
			},
			{
				extend:    'pdfHtml5',footer:true,
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				orientation: 'landscape',
				pageSize: 'LEGAL',
				title: 'Reporte Registro Gastos',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8,9,10]
				},

				customize: function ( doc ) {

					doc.content.splice( 1, 0, {

						margin: [ 0, 0, 0, 2 ],

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

	table_gastos_contabilidad.search('').draw();

	$('#buscar').focus();



	edit_reporte_gastos_dataTable("#dataTableGastosContabilidad tbody", table_gastos_contabilidad);

	view_reporte_gastos_dataTable("#dataTableGastosContabilidad tbody", table_gastos_contabilidad);

	total_gastos_footer();

}

var edit_reporte_gastos_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_editar");

	$(tbody).on("click", "button.table_editar", function(){

		var data = table.row( $(this).parents("tr") ).data();

		var url = '<?php echo SERVERURL;?>core/editarGastos.php';

		$('#formEgresosContables #egresos_id').val(data.egresos_id);



		$.ajax({

			type:'POST',

			url:url,

			data:$('#formEgresosContables').serialize(),

			success: function(registro){

				var valores = eval(registro);

				$('#formEgresosContables').attr({ 'data-form': 'update' });

				$('#formEgresosContables').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarGastosAjax.php' });

				$('#formEgresosContables')[0].reset();

				$('#reg_egresosContabilidad').hide();

				$('#edi_egresosContabilidad').show();

				$('#delete_egresosContabilidad').hide();

				$('#formEgresosContables #pro_egresos_contabilidad').val("Editar");

				$('#formEgresosContables #proveedor_egresos').val(valores[0]);

				$('#formEgresosContables #cuenta_egresos').val(valores[1]);

				$('#formEgresosContables #empresa_egresos').val(valores[2]);

				$('#formEgresosContables #fecha_egresos').val(valores[3]);

				$('#formEgresosContables #factura_egresos').val(valores[4]);

				$('#formEgresosContables #subtotal_egresos').val(valores[5]);

				$('#formEgresosContables #isv_egresos').val(valores[6]);

				$('#formEgresosContables #descuento_egresos').val(valores[7]);

				$('#formEgresosContables #nc_egresos').val(valores[8]);

				$('#formEgresosContables #total_egresos').val(valores[9]);

				$('#formEgresosContables #observacion_egresos').val(valores[10]);



				//DESHABILITAR OBJETOS

				$('#formEgresosContables #cuenta_egresos').attr('disabled', true);

				$('#formEgresosContables #empresa_egresos').attr('disabled', true);

				$('#formEgresosContables #subtotal_egresos').attr('disabled', true);

				$('#formEgresosContables #isv_egresos').attr('disabled', true);

				$('#formEgresosContables #descuento_egresos').attr('disabled', true);

				$('#formEgresosContables #nc_egresos').attr('disabled', true);	

				$('#formEgresosContables #total_egresos').attr('disabled', true);

				$('#formEgresosContables #buscar_cuenta_egresos').hide();

				$('#formEgresosContables #buscar_empresa_egresos').hide();

			

				$('#modalEgresosContables').modal({

					show:true,

					keyboard: false,

					backdrop:'static'

				});

			}

		});

	});

}



var view_reporte_gastos_dataTable = function(tbody, table){

	$(tbody).off("click", "button.print_gastos");

	$(tbody).on("click", "button.print_gastos", function(e){

		e.preventDefault();

		var data = table.row( $(this).parents("tr") ).data();

		printGastos(data.egresos_id);

	});

}



function printGastos(egresos_id){

	var url = '<?php echo SERVERURL; ?>core/generaGastos.php?egresos_id='+egresos_id;

    window.open(url);

}



//INICIO BUSQUEDA PROVEEDORES EN GASTOS CONTABILIDAD

$('#formEgresosContables #buscar_proveedor_egresos').on('click', function(e){

	e.preventDefault();

	listar_proveedores_egresos_contabilidad_buscar();

	 $('#modal_buscar_proveedores_gastos_contabilidad').modal({

		show:true,

		keyboard: false,

		backdrop:'static'

	});

});



var listar_proveedores_egresos_contabilidad_buscar = function(){

	var table_proveedores_egresos_contabilidad_buscar = $("#DatatableProveedoresBusquedaProveedores").DataTable({

		"destroy":true,

		"ajax":{

			"method":"POST",

			"url":"<?php echo SERVERURL;?>core/llenarDataTableProveedores.php"

		},
		"columns":[
			{"defaultContent":"<button class='table_view btn btn-primary ocultar'><span class='fas fa-copy'></span></button>"},
			{"data":"proveedor"},
			{"data":"rtn"},
			{"data":"telefono"},
			{"data":"correo"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "5%", targets: 0 },
		  { width: "25%", targets: 1 },
		  { width: "25%", targets: 2 },
		  { width: "20%", targets: 3 },
		  { width: "25%", targets: 4 }
		],
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Proveedores',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_proveedores_egresos_contabilidad_buscar();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg"></i> Crear',
				titleAttr: 'Agregar Proveedores',
				className: 'table_crear btn btn-primary ocultar',
				action:	function(){
					modal_proveedores();
				}
			}
		],
		"drawCallback": function( settings ) {
        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
    	}	
	});
	table_proveedores_egresos_contabilidad_buscar.search('').draw();
	$('#buscar').focus();

	view_proveedores_busqueda_egresos_contabilidad_dataTable("#DatatableProveedoresBusquedaProveedores tbody", table_proveedores_egresos_contabilidad_buscar);
}

var view_proveedores_busqueda_egresos_contabilidad_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_view");
	$(tbody).on("click", "button.table_view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		$('#formEgresosContables #proveedor_egresos').val(data.proveedores_id);				
		$('#modal_buscar_proveedores_gastos_contabilidad').modal('hide');
	});
}

//FIN BUSQUEDA PROVEEDORES EN GASTOS CONTABILIDAD



//INICIO BUSQUEDA CUENTAS EN INGRESOS CONTABILIDAD

$('#formEgresosContables #buscar_cuenta_egresos').on('click', function(e){

	e.preventDefault();

	listar_cuentas_contabilidad_egresos_buscar();

	 $('#modal_buscar_cuentas_contables').modal({

		show:true,

		keyboard: false,

		backdrop:'static'

	});

});



var listar_cuentas_contabilidad_egresos_buscar = function(){

	var table_cuentas_contabilidad_egresos_buscar = $("#DatatableBusquedaCuentasContables").DataTable({

		"destroy":true,

		"ajax":{

			"method":"POST",

			"url":"<?php echo SERVERURL;?>core/llenarDataTableCuentasContables.php"

		},

		"columns":[

			{"defaultContent":"<button class='table_view btn btn-primary ocultar'><span class='fas fa-copy'></span></button>"},

			{"data":"codigo"},

			{"data":"nombre"}

		],

        "lengthMenu": lengthMenu,

		"stateSave": true,

		"bDestroy": true,

		"language": idioma_español,

		"dom": dom,

		"columnDefs": [

		  { width: "5.28%", targets: 0 },

		  { width: "29.28%", targets: 1 },

		  { width: "18.28%", targets: 2 }		  

		],

		"buttons":[

			{

				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',

				titleAttr: 'Actualizar Registro de Cuentas',

				className: 'table_actualizar btn btn-secondary ocultar',

				action: 	function(){

					listar_cuentas_contabilidad_egresos_buscar();

				}

			},

			{

				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Crear',

				titleAttr: 'Agregar Cuentas',

				className: 'table_crear btn btn-primary ocultar',

				action: 	function(){

					modal_cuentas_contables();

				}

			}			

		],

		"drawCallback": function( settings ) {

        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());

    	}

	});

	table_cuentas_contabilidad_egresos_buscar.search('').draw();

	$('#buscar').focus();



	view_busqueda_cuentas_contabilidad_egresos_dataTable("#DatatableBusquedaCuentasContables tbody", table_cuentas_contabilidad_egresos_buscar);

}



var view_busqueda_cuentas_contabilidad_egresos_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_view");

	$(tbody).on("click", "button.table_view", function(e){

		e.preventDefault();

		var data = table.row( $(this).parents("tr") ).data();

		$('#formEgresosContables #cuenta_egresos').val(data.cuentas_id);		

		$('#modal_buscar_cuentas_contables').modal('hide');

	});

}

//FIN BUSQUEDA CUENTAS EN INGRESOS CONTABILIDAD



//INICIO BUSQUEDA EMPRESAS EN GASTOS CONTABILIDAD

$('#formEgresosContables #buscar_empresa_egresos').on('click', function(e){

	e.preventDefault();

	listar_empresas_egresos_contabilidad_buscar();

	 $('#modal_buscar_empresa').modal({

		show:true,

		keyboard: false,

		backdrop:'static'

	});

});



var listar_empresas_egresos_contabilidad_buscar = function(){

	var table_empresas_egresos_contabilidad_buscar = $("#DatatableBusquedaEmpresas").DataTable({

		"destroy":true,

		"ajax":{

			"method":"POST",

			"url":"<?php echo SERVERURL;?>core/llenarDataTableEmpresa.php"

		},

		"columns":[

			{"defaultContent":"<button class='table_view btn btn-primary ocultar'><span class='fas fa-copy'></span></button>"},

			{"data":"razon_social"},

			{"data":"nombre"},

			{"data":"correo"},

			{"data":"rtn"}

		],

		"pageLength": 5,

        "lengthMenu": lengthMenu,

		"stateSave": true,

		"bDestroy": true,

		"language": idioma_español,

		"drawCallback": function( settings ) {

        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());

    	}

	});

	table_empresas_egresos_contabilidad_buscar.search('').draw();

	$('#buscar').focus();



	view_empresas_busqueda_egresos_contabilidad_dataTable("#DatatableBusquedaEmpresas tbody", table_empresas_egresos_contabilidad_buscar);

}



var view_empresas_busqueda_egresos_contabilidad_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_view");

	$(tbody).on("click", "button.table_view", function(e){

		e.preventDefault();

		var data = table.row( $(this).parents("tr") ).data();

		$('#formEgresosContables #empresa_egresos').val(data.empresa_id);

		$('#modal_buscar_empresa').modal('hide');

	});

}

//FIN BUSQUEDA EMPRESAS EN GASTOS CONTABILIDAD



//FIN ACCIONES FORMULARIO EGRESOS



/*INICIO FORMULARIO EGRESOS CONTABLES*/

function modal_egresos_contabilidad(){

	$('#formEgresosContables').attr({ 'data-form': 'save' });

	$('#formEgresosContables').attr({ 'action': '<?php echo SERVERURL;?>ajax/addEgresoContabilidadAjax.php' });

	$('#formEgresosContables')[0].reset();

	$('#reg_egresosContabilidad').show();

	$('#edi_egresosContabilidad').hide();

	$('#delete_egresosContabilidad').hide();



	//HABILITAR OBJETOS

	$('#formEgresosContables #cuenta_codigo').attr("readonly", false);

	$('#formEgresosContables #cuenta_nombre').attr("readonly", false);

	$('#formEgresosContables #cuentas_activo').attr("disabled", false);

	$('#formEgresosContables #buscar_cuenta_egresos').show();

	$('#formEgresosContables #buscar_empresa_egresos').show();

	$('#formEgresosContables #cuenta_egresos').attr('disabled', false);

	$('#formEgresosContables #empresa_egresos').attr('disabled', false);

	$('#formEgresosContables #subtotal_egresos').attr('disabled', false);

	$('#formEgresosContables #isv_egresos').attr('disabled', false);

	$('#formEgresosContables #descuento_egresos').attr('disabled', false);

	$('#formEgresosContables #nc_egresos').attr('disabled', false);	

	$('#formEgresosContables #total_egresos').attr('disabled', false);	



	$('#formEgresosContables #pro_egresos_contabilidad').val("Registro");

	

	$('#modalEgresosContables').modal({

		show:true,

		keyboard: false,

		backdrop:'static'

	});

}

/*FIN FORMULARIO EGRESOS CONTABLES*/



function getProveedorEgresos(){

    var url = '<?php echo SERVERURL;?>core/getProveedores.php';



	$.ajax({

        type: "POST",

        url: url,

	    async: true,

        success: function(data){

		    $('#formEgresosContables #proveedor_egresos').html("");

			$('#formEgresosContables #proveedor_egresos').html(data);			

		}

     });

}



function getCuentaEgresos(){

    var url = '<?php echo SERVERURL;?>core/getCuenta.php';



	$.ajax({

        type: "POST",

        url: url,

	    async: true,

        success: function(data){

		    $('#formEgresosContables #cuenta_egresos').html("");

			$('#formEgresosContables #cuenta_egresos').html(data);			

		}

     });

}



function getEmpresaEgresos(){

    var url = '<?php echo SERVERURL;?>core/getEmpresa.php';



	$.ajax({

        type: "POST",

        url: url,

	    async: true,

        success: function(data){

		    $('#formEgresosContables #empresa_egresos').html("");

			$('#formEgresosContables #empresa_egresos').html(data);			

		}

     });

}



//INICIO CALCULAR VALORES INGRESADOS EN EGRESOS

$(document).ready(function() {

	$("#formEgresosContables #subtotal_egresos").on("keyup", function(){

		var subtotal;

		var isv;

		var descuento;

		var nc;

		

		if($("#formEgresosContables #subtotal_egresos").val() != ""){

			 subtotal = parseFloat($("#formEgresosContables #subtotal_egresos").val());

		}else{

			subtotal = 0;

		}

		

		if($("#formEgresosContables #isv_egresos").val() != ""){

			isv = parseFloat($("#formEgresosContables #isv_egresos").val());

		}else{

			isv = 0;

		}

		

		if($("#formEgresosContables #descuento_egresos").val() != ""){

			descuento = parseFloat($("#formEgresosContables #descuento_egresos").val());

		}else{

			descuento = 0;

		}

		

		if($("#formEgresosContables #nc_egresos").val() != ""){

			nc = parseFloat($("#formEgresosContables #nc_egresos").val());

		}else{

			nc = 0;

		}



		var total = subtotal + isv - descuento - nc;

		

		$("#formEgresosContables #total_egresos").val(parseFloat(total).toFixed(2));

	});

	

	$("#formEgresosContables #isv_egresos").on("keyup", function(){	

		var subtotal;

		var isv;

		var descuento;

		var nc;

		

		if($("#formEgresosContables #subtotal_egresos").val() != ""){

			 subtotal = parseFloat($("#formEgresosContables #subtotal_egresos").val());

		}else{

			subtotal = 0;

		}

		

		if($("#formEgresosContables #isv_egresos").val() != ""){

			isv = parseFloat($("#formEgresosContables #isv_egresos").val());

		}else{

			isv = 0;

		}

		

		if($("#formEgresosContables #descuento_egresos").val() != ""){

			descuento = parseFloat($("#formEgresosContables #descuento_egresos").val());

		}else{

			descuento = 0;

		}

		

		if($("#formEgresosContables #nc_egresos").val() != ""){

			nc = parseFloat($("#formEgresosContables #nc_egresos").val());

		}else{

			nc = 0;

		}



		var total = subtotal + isv - descuento - nc;

		

		$("#formEgresosContables #total_egresos").val(parseFloat(total).toFixed(2));

	});	

	

	$("#formEgresosContables #descuento_egresos").on("keyup", function(){		

		var subtotal;

		var isv;

		var descuento;

		var nc;

		

		if($("#formEgresosContables #subtotal_egresos").val() != ""){

			 subtotal = parseFloat($("#formEgresosContables #subtotal_egresos").val());

		}else{

			subtotal = 0;

		}

		

		if($("#formEgresosContables #isv_egresos").val() != ""){

			isv = parseFloat($("#formEgresosContables #isv_egresos").val());

		}else{

			isv = 0;

		}

		

		if($("#formEgresosContables #descuento_egresos").val() != ""){

			descuento = parseFloat($("#formEgresosContables #descuento_egresos").val());

		}else{

			descuento = 0;

		}

		

		if($("#formEgresosContables #nc_egresos").val() != ""){

			nc = parseFloat($("#formEgresosContables #nc_egresos").val());

		}else{

			nc = 0;

		}



		var total = subtotal + isv - descuento - nc;

		

		$("#formEgresosContables #total_egresos").val(parseFloat(total).toFixed(2));

	});	



	$("#formEgresosContables #nc_egresos").on("keyup", function(){

		var subtotal;

		var isv;

		var descuento;

		var nc;

		

		if($("#formEgresosContables #subtotal_egresos").val() != ""){

			 subtotal = parseFloat($("#formEgresosContables #subtotal_egresos").val());

		}else{

			subtotal = 0;

		}

		

		if($("#formEgresosContables #isv_egresos").val() != ""){

			isv = parseFloat($("#formEgresosContables #isv_egresos").val());

		}else{

			isv = 0;

		}

		

		if($("#formEgresosContables #descuento_egresos").val() != ""){

			descuento = parseFloat($("#formEgresosContables #descuento_egresos").val());

		}else{

			descuento = 0;

		}

		

		if($("#formEgresosContables #nc_egresos").val() != ""){

			nc = parseFloat($("#formEgresosContables #nc_egresos").val());

		}else{

			nc = 0;

		}



		var total = subtotal + isv - descuento - nc;

		

		$("#formEgresosContables #total_egresos").val(parseFloat(total).toFixed(2));

	});		

});

//FIN CALCULAR VALORES INGRESADOS EN EGRESOS

$(document).ready(function(){
    $("#modal_buscar_proveedores_gastos_contabilidad").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_proveedores_gastos_contabilidad #buscar').focus();
    });
});
</script>