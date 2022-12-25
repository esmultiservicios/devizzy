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
	var estado = 1;
	if($("#formMainGastosContabilidad #estado_egresos").val() == null || $("#formMainGastosContabilidad #estado_egresos").val() == ""){
		estado = 1;
	}else{
		estado = $("#formMainGastosContabilidad #estado_egresos").val();
	}
	
	var fechai = $("#formMainGastosContabilidad #fechai").val();
	var fechaf = $("#formMainGastosContabilidad #fechaf").val();

	var table_gastos_contabilidad  = $("#dataTableGastosContabilidad").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableEgresosContabilidad.php",
			"data":{
				"fechai":fechai,
				"fechaf":fechaf,
				"estado":estado,
			}	
		},

		"columns":[
			{"data":"fecha_registro"},
			{"data":"egresos_id"},
			{"data":"fecha"},
			{"data":"nombre"},
			{"data":"proveedor"},
			{"data":"factura"},
			{"data":"subtotal",
				render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);
 
                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        } 
 
                        return '<span style="color:' + color + '">' + number + '</span>';
                    }
 
                    return number;
                },			
			},
			{"data":"impuesto",
				render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);
 
                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        } 
 
                        return '<span style="color:' + color + '">' + number + '</span>';
                    }
 
                    return number;
                },			
			},
			{"data":"descuento",
				render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);
 
                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        } 
 
                        return '<span style="color:' + color + '">' + number + '</span>';
                    }
 
                    return number;
                },			
			},
			{"data":"nc",
				render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);
 
                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        } 
 
                        return '<span style="color:' + color + '">' + number + '</span>';
                    }
 
                    return number;
                },			
			},
			{"data":"total",
				render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);
 
                    if (type === 'display') {
                        let color = 'green';
                        if (data < 0) {
                            color = 'red';
                        } 
 
                        return '<span style="color:' + color + '">' + number + '</span>';
                    }
 
                    return number;
                },			
			},
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
				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Ingresar',
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
				$('#formEgresosContables #proveedor_egresos').selectpicker('refresh');
				$('#formEgresosContables #cuenta_egresos').val(valores[1]);
				$('#formEgresosContables #cuenta_egresos').selectpicker('refresh');
				$('#formEgresosContables #empresa_egresos').val(valores[2]);
				$('#formEgresosContables #empresa_egresos').selectpicker('refresh');
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
			$('#formEgresosContables #proveedor_egresos').selectpicker('refresh');
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
			$('#formEgresosContables #cuenta_egresos').selectpicker('refresh');
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
			$('#formEgresosContables #empresa_egresos').selectpicker('refresh');
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