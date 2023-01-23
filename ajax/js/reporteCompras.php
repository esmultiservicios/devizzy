<script>
$(document).ready(function() {
	getReporteCompras();
    listar_reporte_compras();
	$('#form_main_compras #tipo_compras_reporte').val(1);	
	$('#form_main_compras #tipo_compras_reporte').selectpicker('refresh');		
});

$('#form_main_compras #tipo_compras_reporte').on("change", function(e){
	listar_reporte_compras();
});

$('#form_main_compras #fechai').on("change", function(e){
	listar_reporte_compras();
});

$('#form_main_compras #fechaf').on("change", function(e){
	listar_reporte_compras();
});

//INICIO REPORTE DE COMPRAS
var listar_reporte_compras = function(){
	var tipo_compra_reporte = 1;
	if($("#form_main_compras #tipo_compras_reporte").val() == null || $("#form_main_compras #tipo_compras_reporte").val() == ""){
		tipo_compra_reporte = 1;
	}else{
		tipo_compra_reporte = $("#form_main_compras #tipo_compras_reporte").val();
	}

	var fechai = $("#form_main_compras #fechai").val();
	var fechaf = $("#form_main_compras #fechaf").val();

	var table_reporteCompras  = $("#dataTablaReporteCompras").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableReporteCompras.php",
			"data":{
				"tipo_compra_reporte":tipo_compra_reporte,
				"fechai":fechai,
				"fechaf":fechaf
			}
		},
		"columns":[
			{"data":"fecha"},
			{"data":"tipo_documento"},
			{"data":"proveedor"},
			{"data":"numero"},
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
			{"data":"isv",
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
		    {"defaultContent":"<button class='table_reportes print_compras btn btn-dark ocultar'><span class='fas fa-file-download fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_cancelar cancelar_compras btn btn-dark ocultar'><span class='fas fa-ban fa-lg'></span></button>"}			
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,//esta se encuenta en el archivo main.js
		"dom": dom,
		"columnDefs": [
		  { width: "10%", targets: 0 },
		  { width: "10%", targets: 1 },
		  { width: "22%", targets: 2 },
		  { width: "12%", targets: 3 },
		  { width: "10%", targets: 4 },
		  { width: "10%", targets: 5 },
		  { width: "10%", targets: 6 },
		  { width: "10%", targets: 7 },
		  { width: "3%", targets: 8 },
		  { width: "3%", targets: 9 }		  
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {         
        	$('td', nRow).addClass(aData['color']);		
		},
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Reporte de Compras',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_reporte_compras();
				}
			},
			{
				extend:    'excelHtml5',
				footer: true,
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte de Compras',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-success ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
				},
			},
			{
				extend:    'pdf',
				footer: true,
				orientation: 'landscape',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				orientation: 'landscape',
				pageSize: 'LETTER',				
				title: 'Reporte de Compras',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
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
	table_reporteCompras.search('').draw();
	$('#buscar').focus();

	view_reporteCompras_dataTable("#dataTablaReporteCompras tbody", table_reporteCompras);
	view_anularCompras_dataTable("#dataTablaReporteCompras tbody", table_reporteCompras);
	
	total_ingreso_footer();
}

var view_anularCompras_dataTable = function(tbody, table){
	$(tbody).off("click", "button.cancelar_compras");
	$(tbody).on("click", "button.cancelar_compras", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		anularCompra(data.compras_id)
	});
}

var view_reporteCompras_dataTable = function(tbody, table){
	$(tbody).off("click", "button.print_compras");
	$(tbody).on("click", "button.print_compras", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		printPurchase(data.compras_id);
	});
}

function anularCompra(compras_id){
	swal({
	  title: "¿Estas seguro?",
	  text: "¿Desea anular la factura de compra: # " + getNumeroCompra(compras_id) + "?",
	  type: "info",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: "¡Sí, enviar anularla!",
	  cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		anular(compras_id);
	});
}

function anular(compras_id){
	var url = '<?php echo SERVERURL; ?>core/anularCompra.php';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'compras_id='+compras_id,
	   success:function(data){
	      if(data == 1){
			swal({
				title: "Success",
				text: "La factura de compra ha sido anulada con éxito",
				type: "success",
			});
			listar_reporte_compras();
		  }else{
			swal({
				title: "Error",
				text: "La factura de compra no se pudo anular",
				type: "error",
				confirmButtonClass: "btn-danger",
			});			  
		  }
	  }
	});
}

function getReporteCompras(){
    var url = '<?php echo SERVERURL;?>core/getTipoFacturaReporte.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#form_main_compras #tipo_compras_reporte').html("");
			$('#form_main_compras #tipo_compras_reporte').html(data);
			$('#form_main_compras #tipo_compras_reporte').selectpicker('refresh');	
		}
     });
}
//FIN REPORTE DE COMPRAS

var total_ingreso_footer = function(){	
	var fechai = $("#form_main_compras #fechai").val();
	var fechaf = $("#form_main_compras #fechaf").val();
	$.ajax({
		url : '<?php echo SERVERURL;?>core/totalCompraFooter.php',
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
		})
		.fail(function(data) {
			console.log( "total ingreso error" );
	});
}

</script>