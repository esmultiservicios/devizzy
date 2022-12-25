<script>
$(document).ready(function() {
    getBancoPurchase();
    getColaboradorCompras();
	getMedida(0)

});

//INICIO PURCHARSE BILL

//INICIO BUSQUEDA PROVEEDORES EN COMPRAS

$('#purchase-form #buscar_proveedores_compras').on('click', function(e){
	e.preventDefault();

	listar_proveedores_compras_buscar();
	 $('#modal_buscar_proveedores_compras').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});
});

var listar_proveedores_compras_buscar = function(){

	var table_proveedores_compras_buscar = $("#DatatableProveedoresBusquedaProveedores").DataTable({

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

		"pageLength": 5,

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

					listar_proveedores_ingresos_contabilidad_buscar();

				}

			},

			{

				text:      '<i class="fas fas fa-plus fa-lg"></i> Crear',

				titleAttr: 'Agregar Proveedores',

				className: 'table_crear btn btn-primary ocultar',

				action: 	function(){

					modal_proveedores();

				}

			}

		],		

		"drawCallback": function( settings ) {

        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());

    	}

	});

	table_proveedores_compras_buscar.search('').draw();

	$('#buscar').focus();



	view_proveedores_busqueda_compras_dataTable("#DatatableProveedoresBusquedaProveedores tbody", table_proveedores_compras_buscar);

}



var view_proveedores_busqueda_compras_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_view");

	$(tbody).on("click", "button.table_view", function(e){

		e.preventDefault();

		var data = table.row( $(this).parents("tr") ).data();

		$('#purchase-form #proveedores_id').val(data.proveedores_id);

		$('#purchase-form #proveedor').val(data.proveedor);

		$('#modal_buscar_proveedores_compras').modal('hide');

	});

}

//FIN BUSQUEDA PROVEEDORES EN COMPRAS



//INICIO BUSQUEDA COLABORADORES EN COMPRAS

$('#purchase-form #buscar_colaboradores_compras').on('click', function(e){

	e.preventDefault();

	listar_colaboradores_buscar_compras();

	 $('#modal_buscar_colaboradores_facturacion').modal({

		show:true,

		keyboard: false,

		backdrop:'static'

	});

});


function getColaboradorCompras(){

	var url = '<?php echo SERVERURL;?>core/editarUsarioSistema.php';



	$.ajax({

		type:'POST',

		url:url,

		success: function(valores){

			var datos = eval(valores);

			$('#purchase-form #colaborador_id').val(datos[0]);

			$('#purchase-form #colaborador').val(datos[1]);

			$('#purchase-form #facturaPurchase').focus();

			return false;
		}
	});

}


var listar_colaboradores_buscar_compras = function(){

	var table_colaboradores_buscar_compras = $("#DatatableColaboradoresBusquedaFactura").DataTable({

		"destroy":true,

		"ajax":{

			"method":"POST",

			"url":"<?php echo SERVERURL;?>core/llenarDataTableColaboradores.php"

		},

		"columns":[

			{"defaultContent":"<button class='table_view btn btn-primary ocultar'><span class='fas fa-copy'></span></button>"},

			{"data":"colaborador"},

			{"data":"identidad"},

			{"data":"telefono"}

		],

		"pageLength": 5,

        "lengthMenu": lengthMenu,

		"stateSave": true,

		"bDestroy": true,

		"language": idioma_español,

		"dom": dom,

		"columnDefs": [

		  { width: "25%", targets: 0 },

		  { width: "25%", targets: 1 },

		  { width: "25%", targets: 2 },

		  { width: "25%", targets: 3 }		  

		],

		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Productos',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_colaboradores_buscar_factura();
				}
			},

			{

				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Crear',

				titleAttr: 'Agregar Productos',

				className: 'table_crear btn btn-primary ocultar',

				action: 	function(){

					modal_colaboradores();

				}

			}

		],		

		"drawCallback": function( settings ) {

        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());

    	}

	});

	table_colaboradores_buscar_compras.search('').draw();

	$('#buscar').focus();



	view_colaboradores_busqueda_compras_dataTable("#DatatableColaboradoresBusquedaFactura tbody", table_colaboradores_buscar_compras);

}



var view_colaboradores_busqueda_compras_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_view");

	$(tbody).on("click", "button.table_view", function(e){

		e.preventDefault();

		var data = table.row( $(this).parents("tr") ).data();

		$('#purchase-form #colaborador_id').val(data.colaborador_id);

		$('#purchase-form #colaborador').val(data.colaborador);

		$('#modal_buscar_colaboradores_facturacion').modal('hide');

	});

}

//FIN BUSQUEDA COLABORADORES EN COMPRAS


$(document).ready(function(){
	$("#modal_buscar_productos_facturacion").on('shown.bs.modal', function(){
		$(this).find('#formulario_busqueda_productos_facturacion #buscar').focus();
	});
});	

//INICIO BUSQUEDA PRODUCTOS COMPRAS
$(document).ready(function(){
    $("#purchase-form #purchaseItem").on('click', '.buscar_productos_purchase', function(e) {
		  e.preventDefault();
		  listar_productos_compras_buscar();
		  var row_index = $(this).closest("tr").index();
		  var col_index = $(this).closest("td").index();


		  $('#formulario_busqueda_productos_facturacion #row').val(row_index);
		  $('#formulario_busqueda_productos_facturacion #col').val(col_index);
		  $('#modal_buscar_productos_facturacion').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		  });
	});

});

$('#formulario_busqueda_productos_facturacion #almacen').on('change',function(){
	listar_productos_compras_buscar();
});

var listar_productos_compras_buscar = function(){
	var bodega = $("#formulario_busqueda_productos_facturacion #almacen").val();

	var table_productos_compras_buscar = $("#DatatableProductosBusquedaFactura").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableProductosFacturas.php",
			"data":{
                "bodega":bodega
            }			
		},
		"columns":[
			{"defaultContent":"<button class='table_view btn btn-primary ocultar'><span class='fas fa-cart-plus'></span></button>"},
			{"data":"barCode"},			
			{"data":"nombre"},
			{"data":"cantidad",
				render: function (data, type) {
					if(data == null){
						data = 0;
					}

                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, '')
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
			{"data":"medida"},
			{"data":"tipo_producto_nombre"},
			{"data":"precio_venta",
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
			{"data":"almacen"},
			{"data":"almacen_id"},
			{"data":"isv_compra"}
		],	
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"responsive": true,
		"language": idioma_español,
		"dom": dom,
		"columnDefs": [
		  { width: "2%", targets: 0 },
		  { width: "17%", targets: 1 },
		  { width: "17%", targets: 2 },
		  { width: "10%", targets: 3 },
		  { width: "10%", targets: 4 },
		  { width: "10%", targets: 5 },
		  { width: "12%", targets: 6 },
		  { width: "12%", targets: 7 },
		  { width: "0%", targets: 8, visible: false },
		  { width: "10%", targets: 9 }
		],
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Productos',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){

					listar_productos_compras_buscar();
				}
			},

			{
				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Crear',
				titleAttr: 'Agregar Productos',
				className: 'table_crear btn btn-primary ocultar',
				action: 	function(){
					modal_productos();
				}
			}
		],		
		"drawCallback": function( settings ) {
        	getPermisosTipoUsuarioAccesosTable(getPrivilegioTipoUsuario());
    	}
	});

	table_productos_compras_buscar.search('').draw();

	$('#buscar').focus();



	view_productos_busqueda_compras_dataTable("#DatatableProductosBusquedaFactura tbody", table_productos_compras_buscar);

}


var row = 0;
var view_productos_busqueda_compras_dataTable = function(tbody, table){

	$(tbody).off("click", "button.table_view");

	$(tbody).on("click", "button.table_view", function(e){

		e.preventDefault();

		if($("#purchase-form #facturaPurchase").val() != "" && $("#purchase-form #proveedores_id").val() != "" && $("#purchase-form #proveedor").val() != "" && $("#purchase-form #colaborador_id").val() != "" && $("#purchase-form #colaborador").val() != ""){

			var data = table.row( $(this).parents("tr") ).data();

			//var row = $('#formulario_busqueda_productos_facturacion #row').val();



			$('#purchase-form #purchaseItem #productos_idPurchase_'+ row).val(data.productos_id);

			$('#purchase-form #purchaseItem #productNamePurchase_'+ row).val(data.nombre);

			$('#purchase-form #purchaseItem #quantityPurchase_'+ row).val(1);

			$('#purchase-form #purchaseItem #quantityPurchase_'+ row).focus();

			$('#purchase-form #purchaseItem #pricePurchase_'+ row).val(data.precio_compra);
			$('#purchase-form #purchaseItem #medidaPurchase_'+ row).val(data.medida);
			$('#purchase-form #purchaseItem #bodegaPurchase_'+ row).val(data.almacen_id);

			$('#purchase-form #purchaseItem #discountPurchase_'+ row).val(0);

			$('#purchase-form #purchaseItem #isvPurchase_'+ row).val(data.isv_compra);



			var isv = 0;

			var isv_total = 0;

			var porcentaje_isv = 0;

			var porcentaje_calculo = 0;

			var isv_neto = 0;



			if(data.isv_compra == 1){

				porcentaje_isv = parseFloat(getPorcentajeISV("Compras") / 100);

				if($('#purchase-form #taxAmountPurchase').val() == "" || $('#purchase-form #taxAmountPurchase').val() == 0){

					porcentaje_calculo = (parseFloat(data.precio_compra) * porcentaje_isv).toFixed(2);

					isv_neto = porcentaje_calculo;

					$('#purchase-form #taxAmountPurchase').val(porcentaje_calculo);

					$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row).val(porcentaje_calculo);

				}else{

					isv_total = parseFloat($('#purchase-form #taxAmountPurchase').val());

					porcentaje_calculo = (parseFloat(data.precio_compra) * porcentaje_isv).toFixed(2);

					isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);

					$('#purchase-form #taxAmountPurchase').val(isv_neto);

					$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row).val(porcentaje_calculo);

				}

			}



			calculateTotalCompras();

			addRowCompras();

			$('#modal_buscar_productos_facturacion').modal('hide');

			row++;

		}else{

			swal({

				title: "Error",

				text: "Lo sentimos no se puede seleccionar un producto, por favor antes de continuar, verifique que los siguientes campos: proveedores, usuario y número de factura no se encuentren vacíos",

				type: "error",

				confirmButtonClass: "btn-danger"

			});

		}

	});

}

//FIN BUSQUEDA PRODUCTOS COMPRAS



$(document).ready(function(){

    $("#purchase-form #purchaseItem").on('blur', '.buscar_cantidad_purchase', function() {

		var row_index = $(this).closest("tr").index();

		var col_index = $(this).closest("td").index();



		var impuesto_compra = parseFloat($('#purchase-form #purchaseItem #isvPurchase_'+ row_index).val());

		var cantidad = parseFloat($('#purchase-form #purchaseItem #quantityPurchase_'+ row_index).val());

		var precio = parseFloat($('#purchase-form #purchaseItem #pricePurchase_'+ row_index).val());

		var total = parseFloat($('#purchase-form #purchaseItem #totalPurchase_'+ row_index).val());



		var isv = 0;

		var isv_total = 0;

		var porcentaje_isv = 0;

		var porcentaje_calculo = 0;

		var isv_neto = 0;



		if(impuesto_compra == 1){

			porcentaje_isv = parseFloat(getPorcentajeISV("Compras") / 100);

			if(total == "" || total == 0){

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(porcentaje_calculo).toFixed(2);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}else{

				isv_total = parseFloat($('#purchase-form #taxAmountPurchase').val());

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}

		}



		calculateTotalCompras();

	});

});



$(document).ready(function(){

    $("#purchase-form #purchaseItem").on('keyup', '.buscar_cantidad_purchase', function() {

		var row_index = $(this).closest("tr").index();

		var col_index = $(this).closest("td").index();



		var impuesto_compra = parseFloat($('#purchase-form #purchaseItem #isvPurchase_'+ row_index).val());

		var cantidad = parseFloat($('#purchase-form #purchaseItem #quantityPurchase_'+ row_index).val());

		var precio = parseFloat($('#purchase-form #purchaseItem #pricePurchase_'+ row_index).val());

		var total = parseFloat($('#purchase-form #purchaseItem #totalPurchase_'+ row_index).val());



		var isv = 0;

		var isv_total = 0;

		var porcentaje_isv = 0;

		var porcentaje_calculo = 0;

		var isv_neto = 0;



		if(impuesto_compra == 1){

			porcentaje_isv = parseFloat(getPorcentajeISV("Compras") / 100);

			if(total == "" || total == 0){

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(porcentaje_calculo).toFixed(2);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}else{

				isv_total = parseFloat($('#purchase-form #taxAmountPurchase').val());

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}

		}



		calculateTotalCompras();

	});

});



$(document).ready(function(){

    $("#purchase-form #purchaseItem").on('blur', '.buscar_price_purchase', function() {

		var row_index = $(this).closest("tr").index();

		var col_index = $(this).closest("td").index();



		var impuesto_compra = parseFloat($('#purchase-form #purchaseItem #isvPurchase_'+ row_index).val());

		var cantidad = parseFloat($('#purchase-form #purchaseItem #quantityPurchase_'+ row_index).val());

		var precio = parseFloat($('#purchase-form #purchaseItem #pricePurchase_'+ row_index).val());

		var total = parseFloat($('#purchase-form #purchaseItem #totalPurchase_'+ row_index).val());



		var isv = 0;

		var isv_total = 0;

		var porcentaje_isv = 0;

		var porcentaje_calculo = 0;

		var isv_neto = 0;



		if(impuesto_compra == 1){

			porcentaje_isv = parseFloat(getPorcentajeISV("Compras") / 100);

			if(total == "" || total == 0){

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(porcentaje_calculo).toFixed(2);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}else{

				isv_total = parseFloat($('#purchase-form #taxAmountPurchase').val());

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}

		}



		calculateTotalCompras();

	});

});



$(document).ready(function(){

    $("#purchase-form #purchaseItem").on('keyup', '.buscar_price_purchase', function() {

		var row_index = $(this).closest("tr").index();

		var col_index = $(this).closest("td").index();



		var impuesto_compra = parseFloat($('#purchase-form #purchaseItem #isvPurchase_'+ row_index).val());

		var cantidad = parseFloat($('#purchase-form #purchaseItem #quantityPurchase_'+ row_index).val());

		var precio = parseFloat($('#purchase-form #purchaseItem #pricePurchase_'+ row_index).val());

		var total = parseFloat($('#purchase-form #purchaseItem #totalPurchase_'+ row_index).val());



		var isv = 0;

		var isv_total = 0;

		var porcentaje_isv = 0;

		var porcentaje_calculo = 0;

		var isv_neto = 0;



		if(impuesto_compra == 1){

			porcentaje_isv = parseFloat(getPorcentajeISV("Compras") / 100);

			if(total == "" || total == 0){

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(porcentaje_calculo).toFixed(2);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}else{

				isv_total = parseFloat($('#purchase-form #taxAmountPurchase').val());

				porcentaje_calculo = (parseFloat(precio) * parseFloat(cantidad) * porcentaje_isv).toFixed(2);

				isv_neto = parseFloat(isv_total) + parseFloat(porcentaje_calculo);

				$('#purchase-form #purchaseItem #valor_isvPurchase_'+ row_index).val(porcentaje_calculo);

			}

		}



		calculateTotalCompras();

	});

});



function limpiarTablaCompras(){

	$("#purchase-form #purchaseItem > tbody").empty();//limpia solo los registros del body

	var count = 0;

	var htmlRows = '';

	htmlRows += '<tr>';

	htmlRows += '<td><input class="itemRowPurchase" type="checkbox"></td>';

	htmlRows += '<td><div class="input-group mb-3"><input type="hidden" name="isvPurchase[]" id="isvPurchase_'+count+'" class="form-control" placeholder="Producto ISV" autocomplete="off"><input type="hidden" name="valor_isvPurchase[]" id="valor_isvPurchase_'+count+'" class="form-control" placeholder="Valor ISV" autocomplete="off"><input type="hidden" name="productos_idPurchase[]" id="productos_idPurchase_'+count+'" class="form-control" autocomplete="off"><input type="text" name="productNamePurchase[]" id="productNamePurchase_'+count+'" class="form-control" autocomplete="off"><div class="input-group-append"><span data-toggle="tooltip" data-placement="top" title="Búsqueda de Productos"><a data-toggle="modal" href="#" class="btn btn-outline-success form-control buscar_productos_purchase"><div class="sb-nav-link-icon"></div><i class="fas fa-search-plus fa-lg"></i></a></span></div></div></td>';

	htmlRows += '<td><input type="number" name="quantityPurchase[]" id="quantityPurchase_'+count+'" class="buscar_cantidad_purchase form-control" autocomplete="off" step="0.01"></td>';

	htmlRows += '<td><input type="number" name="medidaPurchase[]" id="medidaPurchase_'+count+'" placeholder="medida" class="buscar_medida_purchase form-control" autocomplete="off" step="0.01"></td>';
	
	htmlRows += '<td><input type="hidden" name="bodegaPurchase[]" id="bodegaPurchase_'+count+'"  class="buscar_bodega_purchase form-control" ></td>';

	htmlRows += '<td><input type="number" name="pricePurchase[]" id="pricePurchase_'+count+'" placeholder="Precio" class="buscar_price_purchase form-control" autocomplete="off" step="0.01"></td>';

	htmlRows += '<td><input type="number" name="discountPurchase[]" id="discountPurchase_'+count+'" class="form-control" autocomplete="off" step="0.01"></td>';

	htmlRows += '<td><input type="number" name="totalPurchase[]" id="totalPurchase_'+count+'" class="form-control total" readonly autocomplete="off" step="0.01"></td>';

	htmlRows += '</tr>';

	$('#purchaseItem').append(htmlRows);

}



function addRowCompras(){

	var count = row +1;

	var htmlRows = '';

	htmlRows += '<tr>';

	htmlRows += '<td><input class="itemRowPurchase" type="checkbox"></td>';

	htmlRows += '<td><div class="input-group mb-3"><input type="hidden" name="isvPurchase[]" id="isvPurchase_'+count+'" class="form-control" placeholder="Producto ISV" autocomplete="off"><input type="hidden" name="valor_isvPurchase[]" id="valor_isvPurchase_'+count+'" class="form-control" placeholder="Valor ISV" autocomplete="off"><input type="hidden" name="productos_idPurchase[]" id="productos_idPurchase_'+count+'" class="form-control" autocomplete="off"><input type="text" name="productNamePurchase[]" id="productNamePurchase_'+count+'" class="form-control" autocomplete="off"><div class="input-group-append"><span data-toggle="tooltip" data-placement="top" title="Búsqueda de Productos"><a data-toggle="modal" href="#" class="btn btn-outline-success form-control buscar_productos_purchase"><div class="sb-nav-link-icon"></div><i class="fas fa-search-plus fa-lg"></i></a></span></div></div></td>';

	htmlRows += '<td><input type="number" name="quantityPurchase[]" id="quantityPurchase_'+count+'" class="buscar_cantidad_purchase form-control" autocomplete="off" step="0.01"></td>';

	htmlRows += '<td><input type="text" name="medidaPurchase[]" id="medidaPurchase_'+count+'" placeholder="medida" class="buscar_medida_purchase form-control" autocomplete="off" step="0.01"><input type="hidden" name="bodegaPurchase[]" id="bodegaPurchase_'+count+'"  class="buscar_bodega_purchase form-control" ></td>';

	htmlRows +='<td><input type="number" name="pricePurchase[]" id="pricePurchase_'+count+'" placeholder="Precio" class="buscar_price_purchase form-control" autocomplete="off" step="0.01"></td>';
	
	htmlRows += '<td><input type="number" name="discountPurchase[]" id="discountPurchase_'+count+'" class="form-control" autocomplete="off" step="0.01"></td>';

	htmlRows += '<td><input type="number" name="totalPurchase[]" id="totalPurchase_'+count+'" class="form-control total" readonly autocomplete="off" step="0.01"></td>';

	htmlRows += '</tr>';

	$('#purchaseItem').append(htmlRows);
	getMedida(count)

}



$(document).ready(function(){

	$(document).on('click', '#checkAllPurchase', function() {

		$(".itemRowPurchase").attr("checked", this.checked);

	});

	$(document).on('click', '.itemRowPurchase', function() {

		if ($('.itemRowPurchase:checked').length == $('.Purchase').length) {

			$('#checkAllPurchase').attr('checked', true);

		} else {

			$('#checkAllPurchase').attr('checked', false);

		}

	});

	var count = $(".itemRowPurchase").length;

	$(document).on('click', '#addRowsPurchase', function() {

		if($("#purchase-form #proveedor").val() != ""){

			addRowCompras();

		}else{

			swal({

				title: "Error",

				text: "Lo sentimos no puede agregar más filas, debe seleccionar un usuario antes de poder continuar",

				type: "error",

				confirmButtonClass: "btn-danger"

			});

		}

	});

	$(document).on('click', '#removeRowsPurchase', function(){

		if ($('.itemRowPurchase ').is(':checked') ){

			$(".itemRowPurchase:checked").each(function() {

				$(this).closest('tr').remove();

				count--;

			});

			$('#checkAllPurchase').attr('checked', false);

			calculateTotalCompras();

		}else{

			swal({

				title: "Error",

				text: "Lo sentimos debe seleccionar un fila antes de intentar eliminarla",

				type: "error",

				confirmButtonClass: "btn-danger"

			});

		}

	});

	$(document).on('blur', "[id^=quantityPurchase_]", function(){

		calculateTotalCompras();

	});

	$(document).on('keyup', "[id^=quantityPurchase_]", function(){

		calculateTotalCompras();

	});

	$(document).on('blur', "[id^=pricePurchase_]", function(){

		calculateTotalCompras();

	});

	$(document).on('keyup', "[id^=pricePurchase_]", function(){

		calculateTotalCompras();

	});

	$(document).on('blur', "[id^=discountPurchase_]", function(){

		calculateTotalCompras();

	});

	$(document).on('keyup', "[id^=discountPurchase_]", function(){

		calculateTotalCompras();

	});

	$(document).on('blur', "#taxRatePurchase", function(){

		calculateTotalCompras();

	});

	$(document).on('blur', "#amountPaidPurchase", function(){

		var amountPaid = $(this).val();

		var totalAftertax = $('#totalAftertaxPurchase').val();

		if(amountPaid && totalAftertax) {

			totalAftertax = totalAftertax-amountPaid;

			$('#amountDuePurchase').val(totalAftertax);

		} else {

			$('#amountDuePurchase').val(totalAftertax);

		}

	});

	$(document).on('click', '.deleteInvoicePurchase', function(){

		var id = $(this).attr("id");

		if(confirm("Are you sure you want to remove this?")){

			$.ajax({

				url:"action.php",

				method:"POST",

				dataType: "json",

				data:{id:id, action:'delete_invoice'},

				success:function(response) {

					if(response.status == 1) {

						$('#'+id).closest("tr").remove();

					}

				}

			});

		} else {

			return false;

		}

	});

});



function calculateTotalCompras(){

	var totalAmount = 0;

	var totalDiscount = 0;

	var totalISV = 0;

	var totalGeneral = 0;



	$("[id^='pricePurchase_']").each(function() {

		var id = $(this).attr('id');

		id = id.replace("pricePurchase_",'');

		var price = $('#pricePurchase_'+id).val();

		var isv_calculo = $('#valor_isvPurchase_'+id).val();

		var discount = $('#discountPurchase_'+id).val();

		var quantity  = $('#quantityPurchase_'+id).val();

		if(!discount){

			discount = 0;

		}

		if(!quantity) {

			quantity = 1;

		}



		if(!isv_calculo){

			isv_calculo = 0;

		}



		var total = price*quantity;

		$('#totalPurchase_'+id).val(parseFloat(total));

		totalAmount += total;

		totalGeneral += (price*quantity);

		totalISV += parseFloat(isv_calculo);

		totalDiscount += parseFloat(discount);

	});

	$('#subTotalPurchase').val(parseFloat(totalAmount).toFixed(2));

	$('#subTotalFooterPurchase').val(parseFloat(totalAmount).toFixed(2));

	$('#taxDescuentoPurchase').val(parseFloat(totalDiscount).toFixed(2));

	$('#taxDescuentoFooterPurchase').val(parseFloat(totalDiscount).toFixed(2));

	var taxRate = $("#taxRatePurchase").val();

	var subTotal = $('#subTotalPurchase').val();

	if(subTotal) {

		$('#subTotalImportePurchase').val(parseFloat(totalGeneral).toFixed(2));

		$('#taxAmountPurchase').val(parseFloat(totalISV).toFixed(2));

		$('#taxAmountFooterPurchase').val(parseFloat(totalISV).toFixed(2));

		subTotal = (parseFloat(subTotal)+parseFloat($('#taxAmountPurchase').val()))-parseFloat(totalDiscount);

		$('#totalAftertaxPurchase').val(parseFloat(subTotal).toFixed(2));

		$('#totalAftertaxFooterPurchase').val(parseFloat(subTotal).toFixed(2));

		var amountPaid = $('#amountPaidPurchase').val();

		var totalAftertax = $('#totalAftertaxPurchase').val();

		if(amountPaid && totalAftertax) {

			totalAftertax = totalAftertax-amountPaid;

			$('#amountDuePurchase').val(totalAftertax);

		} else {

			$('#amountDuePurchase').val(subTotal);

		}

	}

}



function cleanFooterValuePurchase(){

	$('#subTotalFooterPurchase').val("");

	$('#taxDescuentoFooterPurchase').val("");

	$('#taxAmountFooterPurchase').val("");

	$('#totalAftertaxFooterPurchase').val("");

}



$('#purchase-form #notesPurchase').keyup(function() {

	    var max_chars = 2000;

        var chars = $(this).val().length;

        var diff = max_chars - chars;

		

		$('#purchase-form #charNum_notasPurchase').html(diff + ' Caracteres'); 

		

		if(diff == 0){

			return false;

		}

});



function caracteresNotasCompras(){

	var max_chars = 2000;

	var chars = $('#purchase-form #notesPurchase').val().length;

	var diff = max_chars - chars;

	

	$('#purchase-form #charNum_notasPurchase').html(diff + ' Caracteres'); 

	

	if(diff == 0){

		return false;

	}

}



$('#purchase-form #label_tipoPurchase').html("Contado");

	

$('#purchase-form .switch').change(function(){    

    if($('input[name=tipoPurchase]').is(':checked')){

        $('#purchase-form #label_tipoPurchase').html("Contado");

        return true;

    }

    else{

        $('#purchase-form #label_tipoPurchase').html("Crédito");

        return false;

    }

});	



$(document).ready(function(){

    $("#modal_buscar_proveedores_compras").on('shown.bs.modal', function(){

        $(this).find('#formulario_busqueda_proveedores_compras #buscar').focus();

    });

});

</script>