<script>
$(document).ready(function() {
    listar_ingresos_contabilidad();
    getClientesIngresos();
    getCuentaIngresos();
    getEmpresaIngresos();    
});

$('#formMainIngresosContabilidad #search').on("click", function(e){
	e.preventDefault();
	listar_ingresos_contabilidad();
});

//INICIO ACCIONES FORMULARIO INGRESOS
var total_ingreso_footer = function(){	
	var fechai = $("#formMainIngresosContabilidad #fechai").val();
	var fechaf = $("#formMainIngresosContabilidad #fechaf").val();
	$.ajax({
		url : '<?php echo SERVERURL;?>core/totalIngresoFooter.php',
		type: "POST",
		data : {
			"fechai": fechai,
			"fechaf":fechaf
			}
		})
		.done(function(data) {
			data = JSON.parse(data)
			$("#total-footer-ingreso").html("L. " + data.total);
			$("#subtotal-i").html("L. " + data.subtotal);
			$("#impuesto-i").html("L. " + data.impuesto);
			$("#descuento-i").html("L. " + data.descuento);
			$("#nc-i").html("L. " + data.nc);
			
		})
		.fail(function(data) {
			console.log( "total ingreso error" );
	});
}

var listar_ingresos_contabilidad = function(){	
	var fechai = $("#formMainIngresosContabilidad #fechai").val();
	var fechaf = $("#formMainIngresosContabilidad #fechaf").val();	

	var table_ingresos_contabilidad = $("#dataTableIngresosContabilidad").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableIngresosContabilidad.php",
			"data":{
				"fechai":fechai,
				"fechaf":fechaf
			}	
		},
		"columns":[
			{"data":"fecha_registro"},
			{"data":"ingresos_id"},
			{"data":"fecha"},
			{"data":"nombre"},			
			{"data":"cliente"},
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
				titleAttr: 'Actualizar Registro Ingresos',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: function(){
					listar_ingresos_contabilidad();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Crear',
				titleAttr: 'Agregar Ingresos',
				className: 'table_crear btn btn-primary ocultar',
				action:	function(){
					modal_ingresos_contabilidad();
				}
			},			
			{
				extend:    'excelHtml5',
				footer:true,
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte Registro Ingresos',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8,9,10]
				},
				className: 'table_reportes btn btn-success ocultar'
			},

			{
				extend:    'pdf',
				footer: true,
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				orientation: 'landscape',
				pageSize: 'LEGAL',
				title: 'Reporte Registro Ingresos',
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

	table_ingresos_contabilidad.search('').draw();
	$('#buscar').focus();

	edit_reporte_ingresos_dataTable("#dataTableIngresosContabilidad tbody", table_ingresos_contabilidad);
	view_reporte_ingresos_dataTable("#dataTableIngresosContabilidad tbody", table_ingresos_contabilidad);
	total_ingreso_footer();
}


var edit_reporte_ingresos_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_editar");
	$(tbody).on("click", "button.table_editar", function(){
		var data = table.row( $(this).parents("tr") ).data();
		var url = '<?php echo SERVERURL;?>core/editarIngresos.php';
		$('#formIngresosContables #ingresos_id').val(data.ingresos_id);

		$.ajax({
			type:'POST',
			url:url,
			data:$('#formIngresosContables').serialize(),
			success: function(registro){
				var valores = eval(registro);
				$('#formIngresosContables').attr({ 'data-form': 'update' });
				$('#formIngresosContables').attr({ 'action': '<?php echo SERVERURL;?>ajax/modificarIngresosAjax.php' });
				$('#formIngresosContables')[0].reset();
				$('#reg_ingresosContabilidad').hide();
				$('#edi_ingresosContabilidad').show();
				$('#delete_ingresosContabilidad').hide();
				$('#formIngresosContables #pro_ingresos_contabilidad').val("Editar");
				$('#formIngresosContables #cliente_ingresos').val(valores[0]);
				$('#formIngresosContables #cuenta_ingresos').val(valores[1]);
				$('#formIngresosContables #empresa_ingresos').val(valores[2]);
				$('#formIngresosContables #fecha_ingresos').val(valores[3]);
				$('#formIngresosContables #factura_ingresos').val(valores[4]);
				$('#formIngresosContables #subtotal_ingresos').val(valores[5]);
				$('#formIngresosContables #isv_ingresos').val(valores[6]);
				$('#formIngresosContables #descuento_ingresos').val(valores[7]);
				$('#formIngresosContables #nc_ingresos').val(valores[8]);
				$('#formIngresosContables #total_ingresos').val(valores[9]);
				$('#formIngresosContables #observacion_ingresos').val(valores[10]);
				
				//DESHABILITAR OBJETOS
				$('#formIngresosContables #cuenta_ingresos').attr('disabled', true);
				$('#formIngresosContables #empresa_ingresos').attr('disabled', true);
				$('#formIngresosContables #subtotal_ingresos').attr('disabled', true);
				$('#formIngresosContables #isv_ingresos').attr('disabled', true);
				$('#formIngresosContables #descuento_ingresos').attr('disabled', true);
				$('#formIngresosContables #nc_ingresos').attr('disabled', true);	
				$('#formIngresosContables #total_ingresos').attr('disabled', true);
				$('#formIngresosContables #buscar_cuenta_ingresos').hide();
				$('#formIngresosContables #buscar_empresa_ingresos').hide();
		
				$('#modalIngresosContables').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			}
		});
	});
}

var view_reporte_ingresos_dataTable = function(tbody, table){
	$(tbody).off("click", "button.print_gastos");
	$(tbody).on("click", "button.print_gastos", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		printIngresos(data.ingresos_id);
	});
}

function printIngresos(ingresos_id){
	var url = '<?php echo SERVERURL; ?>core/generaIngresos.php?ingresos_id='+ingresos_id;
    window.open(url);
}

//INICIO BUSQUEDA CLIENTES EN INGRESOS CONTABILIDAD

$('#formIngresosContables #buscar_cliente_ingresos').on('click', function(e){
	e.preventDefault();

	listar_clientes_ingresos_contabilidad_buscar();
	 $('#modal_buscar_clientes_facturacion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
});


var listar_clientes_ingresos_contabilidad_buscar = function(){
	var table_clientes_ingresos_contabilidad_buscar = $("#DatatableClientesBusquedaFactura").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableClientes.php"
		},
		"columns":[
			{"defaultContent":"<button class='table_view btn btn-primary ocultar'><span class='fas fa-copy'></span></button>"},
			{"data":"cliente"},
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
				titleAttr: 'Actualizar Clientes',
				className: 'table_actualizar btn btn-secondary ocultar',
				action:	function(){
					listar_clientes_ingresos_contabilidad_buscar();

				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg"></i> Crear',
				titleAttr: 'Agregar Proveedores',
				className: 'table_crear btn btn-primary ocultar',
				action: function(){
					modal_clientes();
				}
			}
		],
		"drawCallback": function( settings ) {
        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
    	}		
	});

	table_clientes_ingresos_contabilidad_buscar.search('').draw();
	$('#buscar').focus();

	view_clientes_busqueda_ingresos_contabilidad_dataTable("#DatatableClientesBusquedaFactura tbody", table_clientes_ingresos_contabilidad_buscar);
}

var view_clientes_busqueda_ingresos_contabilidad_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_view");
	$(tbody).on("click", "button.table_view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		
		$('#formIngresosContables #cliente_ingresos').val(data.clientes_id);	
		$('#modal_buscar_clientes_facturacion').modal('hide');
	});
}
//FIN BUSQUEDA CLIENTES EN INGRESOS CONTABILIDAD

//INICIO BUSQUEDA CUENTAS EN INGRESOS CONTABILIDAD
$('#formIngresosContables #buscar_cuenta_ingresos').on('click', function(e){
	e.preventDefault();
	listar_cuentas_contabilidad_ingresos_buscar();
	 $('#modal_buscar_cuentas_contables').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});

});



var listar_cuentas_contabilidad_ingresos_buscar = function(){

	var table_cuentas_contabilidad_ingresos_buscar = $("#DatatableBusquedaCuentasContables").DataTable({

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

					listar_cuentas_contabilidad_ingresos_buscar();

				}

			}			

		],

		"drawCallback": function( settings ) {

        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());

    	}

	});

	table_cuentas_contabilidad_ingresos_buscar.search('').draw();

	$('#buscar').focus();



	view_busqueda_cuentas_contabilidad_ingresos_dataTable("#DatatableBusquedaCuentasContables tbody", table_cuentas_contabilidad_ingresos_buscar);

}



var view_busqueda_cuentas_contabilidad_ingresos_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_view");

	$(tbody).on("click", "button.table_view", function(e){

		e.preventDefault();

		var data = table.row( $(this).parents("tr") ).data();

		$('#formIngresosContables #cuenta_ingresos').val(data.cuentas_id);

		$('#modal_buscar_cuentas_contables').modal('hide');

	});

}

//FIN BUSQUEDA CUENTAS EN INGRESOS CONTABILIDAD



//INICIO BUSQUEDA EMPRESAS EN INGRESOS CONTABILIDAD

$('#formIngresosContables #buscar_empresa_ingresos').on('click', function(e){
	e.preventDefault();
	listar_empresas_ingresos_contabilidad_buscar();
	 $('#modal_buscar_empresa').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});

});



var listar_empresas_ingresos_contabilidad_buscar = function(){
	var table_empresas_ingresos_contabilidad_buscar = $("#DatatableBusquedaEmpresas").DataTable({
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
	table_empresas_ingresos_contabilidad_buscar.search('').draw();
	$('#buscar').focus();

	view_empresas_busqueda_ingresos_contabilidad_dataTable("#DatatableBusquedaEmpresas tbody", table_empresas_ingresos_contabilidad_buscar);
}



var view_empresas_busqueda_ingresos_contabilidad_dataTable = function(tbody, table){
	$(tbody).off("click", "button.table_view");
	$(tbody).on("click", "button.table_view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		$('#formIngresosContables #empresa_ingresos').val(data.empresa_id);						
		$('#modal_buscar_empresa').modal('hide');
	});
}

//FIN BUSQUEDA EMPRESAS EN INGRESOS CONTABILIDAD


/*INICIO FORMULARIO INGRESOS CONTABLES*/
function modal_ingresos_contabilidad(){
	$('#formIngresosContables').attr({ 'data-form': 'save' });
	$('#formIngresosContables').attr({ 'action': '<?php echo SERVERURL;?>ajax/addIngresoContabilidadAjax.php' });
	$('#formIngresosContables')[0].reset();
	$('#reg_ingresosContabilidad').show();
	$('#edi_ingresosContabilidad').hide();
	$('#delete_ingresosContabilidad').hide();

	//HABILITAR OBJETOS
	$('#formIngresosContables #cuenta_codigo').attr("readonly", false);
	$('#formIngresosContables #cuenta_nombre').attr("readonly", false);
	$('#formIngresosContables #cuentas_activo').attr("disabled", false);
	$('#formIngresosContables #cuenta_ingresos').attr('disabled', false);

	$('#formIngresosContables #empresa_ingresos').attr('disabled', false);

	$('#formIngresosContables #subtotal_ingresos').attr('disabled', false);

	$('#formIngresosContables #isv_ingresos').attr('disabled', false);

	$('#formIngresosContables #descuento_ingresos').attr('disabled', false);

	$('#formIngresosContables #nc_ingresos').attr('disabled', false);	

	$('#formIngresosContables #total_ingresos').attr('disabled', false);

	$('#formIngresosContables #buscar_cuenta_ingresos').show();

	$('#formIngresosContables #buscar_empresa_ingresos').show();	



	$('#formIngresosContables #pro_ingresos_contabilidad').val("Registro");

	

	$('#modalIngresosContables').modal({

		show:true,

		keyboard: false,

		backdrop:'static'

	});

}

/*FIN FORMULARIO INGRESOS CONTABLES*/



function getEmpresaIngresos(){

    var url = '<?php echo SERVERURL;?>core/getEmpresa.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formIngresosContables #empresa_ingresos').html("");
			$('#formIngresosContables #empresa_ingresos').html(data);			
		}
     });
}


function getCuentaIngresos(){

    var url = '<?php echo SERVERURL;?>core/getCuenta.php';


	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formIngresosContables #cuenta_ingresos').html("");
			$('#formIngresosContables #cuenta_ingresos').html(data);			
		}
     });
}

function getClientesIngresos(){
    var url = '<?php echo SERVERURL;?>core/getClientes.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formIngresosContables #cliente_ingresos').html("");
			$('#formIngresosContables #cliente_ingresos').html(data);			
		}
     });
}

//INICIO CALCULAR VALORES INGRESADOS EN INGRESOS

$(document).ready(function() {
	$("#formIngresosContables #subtotal_ingresos").on("keyup", function(){
		var subtotal;
		var isv;
		var descuento;
		var nc;
		if($("#formIngresosContables #subtotal_ingresos").val() != ""){
			 subtotal = parseFloat($("#formIngresosContables #subtotal_ingresos").val());
		}else{
			subtotal = 0;
		}

		if($("#formIngresosContables #isv_ingresos").val() != ""){

			isv = parseFloat($("#formIngresosContables #isv_ingresos").val());

		}else{

			isv = 0;

		}		

		if($("#formIngresosContables #descuento_ingresos").val() != ""){
			descuento = parseFloat($("#formIngresosContables #descuento_ingresos").val());
		}else{
			descuento = 0;
		}		

		if($("#formIngresosContables #nc_ingresos").val() != ""){
			nc = parseFloat($("#formIngresosContables #nc_ingresos").val());
		}else{
			nc = 0;
		}

		var total = subtotal + isv - descuento - nc;		

		$("#formIngresosContables #total_ingresos").val(parseFloat(total).toFixed(2));
	});
	
	$("#formIngresosContables #isv_ingresos").on("keyup", function(){	
		var subtotal;
		var isv;
		var descuento;
		var nc;	

		if($("#formIngresosContables #subtotal_ingresos").val() != ""){
			 subtotal = parseFloat($("#formIngresosContables #subtotal_ingresos").val());
		}else{
			subtotal = 0;
		}		

		if($("#formIngresosContables #isv_ingresos").val() != ""){
			isv = parseFloat($("#formIngresosContables #isv_ingresos").val());
		}else{
			isv = 0;
		}		

		if($("#formIngresosContables #descuento_ingresos").val() != ""){
			descuento = parseFloat($("#formIngresosContables #descuento_ingresos").val());
		}else{
			descuento = 0;
		}		

		if($("#formIngresosContables #nc_ingresos").val() != ""){
			nc = parseFloat($("#formIngresosContables #nc_ingresos").val());
		}else{
			nc = 0;
		}

		var total = subtotal + isv - descuento - nc;

		$("#formIngresosContables #total_ingresos").val(parseFloat(total).toFixed(2));
	});	
	
	$("#formIngresosContables #descuento_ingresos").on("keyup", function(){		
		var subtotal;
		var isv;
		var descuento;
		var nc;		

		if($("#formIngresosContables #subtotal_ingresos").val() != ""){
			 subtotal = parseFloat($("#formIngresosContables #subtotal_ingresos").val());
		}else{
			subtotal = 0;
		}		

		if($("#formIngresosContables #isv_ingresos").val() != ""){
			isv = parseFloat($("#formIngresosContables #isv_ingresos").val());
		}else{
			isv = 0;
		}		

		if($("#formIngresosContables #descuento_ingresos").val() != ""){
			descuento = parseFloat($("#formIngresosContables #descuento_ingresos").val());
		}else{
			descuento = 0;
		}		

		if($("#formIngresosContables #nc_ingresos").val() != ""){
			nc = parseFloat($("#formIngresosContables #nc_ingresos").val());
		}else{
			nc = 0;
		}

		var total = subtotal + isv - descuento - nc;		

		$("#formIngresosContables #total_ingresos").val(parseFloat(total).toFixed(2));
	});	

	$("#formIngresosContables #nc_ingresos").on("keyup", function(){
		var subtotal;
		var isv;
		var descuento;
		var nc;		

		if($("#formIngresosContables #subtotal_ingresos").val() != ""){
			 subtotal = parseFloat($("#formIngresosContables #subtotal_ingresos").val());
		}else{
			subtotal = 0;
		}
		
		if($("#formIngresosContables #isv_ingresos").val() != ""){
			isv = parseFloat($("#formIngresosContables #isv_ingresos").val());
		}else{
			isv = 0;
		}
	
		if($("#formIngresosContables #descuento_ingresos").val() != ""){
			descuento = parseFloat($("#formIngresosContables #descuento_ingresos").val());
		}else{
			descuento = 0;
		}

		if($("#formIngresosContables #nc_ingresos").val() != ""){
			nc = parseFloat($("#formIngresosContables #nc_ingresos").val());
		}else{
			nc = 0;
		}

		var total = subtotal + isv - descuento - nc;

		$("#formIngresosContables #total_ingresos").val(parseFloat(total).toFixed(2));

	});		

});
//FIN CALCULAR VALORES INGRESADOS EN INGRESOS

$(document).ready(function(){
    $("#modal_buscar_clientes_facturacion").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_clientes_facturacion #buscar').focus();
    });
});
</script>