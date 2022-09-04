<script>
$(document).ready(function() {
	getReporteFactura();	
    listar_reporte_ventas();
});

$('#form_main_ventas #search').on("click", function(e){
	e.preventDefault();
	listar_reporte_ventas();
});

//INICIO REPORTE DE VENTAS
var listar_reporte_ventas = function(){
	var tipo_factura_reporte = 1;
	if($("#form_main_ventas #tipo_factura_reporte").val() == null || $("#form_main_ventas #tipo_factura_reporte").val() == ""){
		tipo_factura_reporte = 1;
	}else{
		tipo_factura_reporte = $("#form_main_ventas #tipo_factura_reporte").val();
	}

	var fechai = $("#form_main_ventas #fechai").val();
	var fechaf = $("#form_main_ventas #fechaf").val();

	var table_reporteVentas  = $("#dataTablaReporteVentas").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableReporteVentas.php",
			"data":{
				"tipo_factura_reporte":tipo_factura_reporte,
				"fechai":fechai,
				"fechaf":fechaf
			}
		},
		"columns":[		
			{"data":"fecha"},
			{"data":"tipo_documento"},
			{"data":"cliente"},
			{"data":"numero"},
			{"data":"subtotal"},
			{"data":"isv"},
			{"data":"descuento"},			
			{"data":"total"},
			{"data":"ganancia"},
		    {"defaultContent":"<button class='table_reportes print_factura btn btn-dark ocultar'><span class='fas fa-file-download fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_reportes print_comprobante btn btn-dark ocultar'><span class='far fa-file-pdf fa-lg'></span></button>"},
		    {"defaultContent":"<button class='table_reportes email_factura btn btn-dark ocultar'><span class='fas fa-paper-plane fa-lg'></span></button>"},
		    {"defaultContent":"<button class='table_cancelar cancelar_factura btn btn-dark ocultar'><span class='fas fa-ban fa-lg'></span></button>"}						
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,//esta se encuenta en el archivo main.js
		"dom": dom,
		"columnDefs": [
		  { width: "9.09%", targets: 0 },
		  { width: "9.09%", targets: 1 },
		  { width: "19.09%", targets: 2 },
		  { width: "18.09%", targets: 3 },
		  { width: "9.09%", targets: 4 },
		  { width: "9.09%", targets: 5 },
		  { width: "9.09%", targets: 6 },
		  { width: "9.09%", targets: 7 },
		  { width: "3.09%", targets: 8 },
		  { width: "3.09%", targets: 9 },
		  { width: "2.09%", targets: 10 },
		  { width: "2.09%", targets: 11 }		  		  		  

		],
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Reporte de Ventas',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_reporte_ventas();
				}
			},
			{
				extend:    'excelHtml5',
				footer: true,
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte de Ventas',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8]
				},
				className: 'table_reportes btn btn-success ocultar'				
			},
			{
				extend:    'pdf',
				footer: true,
				orientation: 'landscape',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				orientation: 'landscape',
				pageSize: 'LETTER',				
				title: 'Reporte de Ventas',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8]
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
	table_reporteVentas.search('').draw();
	$('#buscar').focus();

	view_correo_facturas_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);
	view_reporte_facturas_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);
	view_reporte_comprobante_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);
	view_anular_facturas_dataTable("#dataTablaReporteVentas tbody", table_reporteVentas);	

	total_ingreso_footer();
}

var view_anular_facturas_dataTable = function(tbody, table){
	$(tbody).off("click", "button.cancelar_factura");
	$(tbody).on("click", "button.cancelar_factura", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		anularFacturas(data.facturas_id);
	});
}

var view_correo_facturas_dataTable = function(tbody, table){
	$(tbody).off("click", "button.email_factura");
	$(tbody).on("click", "button.email_factura", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		mailBill(data.facturas_id);
	});
}

var view_reporte_facturas_dataTable = function(tbody, table){
	$(tbody).off("click", "button.print_factura");
	$(tbody).on("click", "button.print_factura", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		printBillReporteVentas(data.facturas_id);
	});
}

var view_reporte_comprobante_dataTable = function(tbody, table){
	$(tbody).off("click", "button.print_comprobante");
	$(tbody).on("click", "button.print_comprobante", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		printBillComprobanteReporteVentas(data.facturas_id);
	});
}

function anularFacturas(facturas_id){
	swal({
	  title: "¿Estas seguro?",
	  text: "¿Desea anular la factura: # " + getNumeroFactura(facturas_id) + "?",
	  type: "info",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: "¡Sí, enviar anularla!",
	  cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		anular(facturas_id);
	});
}

function anular(facturas_id){
	var url = '<?php echo SERVERURL; ?>core/anularFactura.php';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'facturas_id='+facturas_id,
	   success:function(data){
	      if(data == 1){
			swal({
				title: "Success",
				text: "La factura ha sido anulada con éxito",
				type: "success",
			});
			listar_reporte_ventas();
		  }else{
			swal({
				title: "Error",
				text: "La factura no se puede anular",
				type: "error",
				confirmButtonClass: "btn-danger",
			});			  
		  }
	  }
	});
}

function getReporteFactura(){
    var url = '<?php echo SERVERURL;?>core/getTipoFacturaReporte.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#form_main_ventas #tipo_factura_reporte').html("");
			$('#form_main_ventas #tipo_factura_reporte').html(data);		
		}
     });
}
//FIN REPORTE DE VENTAS

var total_ingreso_footer = function(){	
	var fechai = $("#form_main_ventas #fechai").val();
	var fechaf = $("#form_main_ventas #fechaf").val();
	$.ajax({
		url : '<?php echo SERVERURL;?>core/totalVentasFooter.php',
		type: "POST",
		data : {
			"fechai": fechai,
			"fechaf":fechaf
			}
		})
		.done(function(data) {
			data = JSON.parse(data)
			$("#ganancia").html("L. " + data.ganancia);
			$("#total-footer-ingreso").html("L. " + data.total);
			$("#subtotal-i").html("L. " + data.subtotal);
			$("#impuesto-i").html("L. " + data.impuesto);
			$("#descuento-i").html("L. " + data.descuento);			
		})
		.fail(function(data) {
			console.log( "total ingreso error" );
	});
}
</script>