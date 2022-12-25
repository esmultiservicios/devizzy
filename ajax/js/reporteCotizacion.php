<script>
$(document).ready(function() {
	getReporteCotizacion();
    listar_reporte_cotizaciones();
});

$('#form_main_cotizaciones #tipo_cotizacion_reporte').on("change", function(e){
	listar_reporte_cotizaciones();
});

$('#form_main_cotizaciones #fechai').on("change", function(e){
	listar_reporte_cotizaciones();
});

$('#form_main_cotizaciones #fechaf').on("change", function(e){
	listar_reporte_cotizaciones();
});

//INICIO REPORTE DE COTIZACIONES
var listar_reporte_cotizaciones = function(){
	var tipo_cotizacion_reporte = 1;
	if($("#form_main_cotizaciones #tipo_cotizacion_reporte").val() == null || $("#form_main_cotizaciones #tipo_cotizacion_reporte").val() == ""){
		tipo_cotizacion_reporte = 1;
	}else{
		tipo_cotizacion_reporte = $("#form_main_cotizaciones #tipo_cotizacion_reporte").val();
	}

	var fechai = $("#form_main_cotizaciones #fechai").val();
	var fechaf = $("#form_main_cotizaciones #fechaf").val();

	var table_reporteCotizaciones = $("#dataTablaReporteCotizaciones").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL;?>core/llenarDataTableReporteCotizaciones.php",
			"data":{
				"tipo_cotizacion_reporte":tipo_cotizacion_reporte,
				"fechai":fechai,
				"fechaf":fechaf
			}
		},
		"columns":[
			{"data":"fecha"},
			{"data":"tipo_documento"},
			{"data":"cliente"},
			{"data":"numero"},
			{"data":"subtotal",
				render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 2, 'L ')
                        .display(data);
 
                    if (type === 'display') {
                        let color = 'black';
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
                        let color = 'black';
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
                        let color = 'black';
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
                        let color = 'black';
                        if (data < 0) {
                            color = 'red';
                        } 
 
                        return '<span style="color:' + color + '">' + number + '</span>';
                    }
 
                    return number;
                },
			},
		    {"defaultContent":"<button class='table_reportes print_cotizaciones btn btn-dark ocultar'><span class='fas fa-file-download fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_reportes email_cotizacion btn btn-dark ocultar'><span class='fas fa-paper-plane fa-lg'></span></button>"},
			{"defaultContent":"<button class='table_cancelar cancelar_cotizaciones btn btn-dark ocultar'><span class='fas fa-ban fa-lg'></span></button>"}			
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
		  { width: "17.09%", targets: 3 },
		  { width: "9.09%", targets: 4 },
		  { width: "9.09%", targets: 5 },
		  { width: "9.09%", targets: 6 },
		  { width: "9.09%", targets: 7 },
		  { width: "3.09%", targets: 8 },
		  { width: "3.09%", targets: 9 },	
		  { width: "3.09%", targets: 10 },		  	  
		],
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Reporte de Cotizaciones',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_reporte_cotizaciones();
				}
			},
			{
				extend:    'excelHtml5',
				footer: true,
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				title: 'Reporte de Cotizaciones',
				messageTop: 'Fecha desde: ' + convertDateFormat(fechai) + ' Fecha hasta: ' + convertDateFormat(fechaf),
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
				},
				className: 'table_reportes btn btn-success ocultar'
			},
			{
				extend:    'pdf',
				footer: true,
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				orientation: 'landscape',
				pageSize: 'LETTER',				
				title: 'Reporte de Cotizaciones',
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
	table_reporteCotizaciones.search('').draw();
	$('#buscar').focus();

	view_reporteCotizaciones_dataTable("#dataTablaReporteCotizaciones tbody", table_reporteCotizaciones);
	view_enviarCotizaciones_dataTable("#dataTablaReporteCotizaciones tbody", table_reporteCotizaciones);	
	view_anularCotizaciones_dataTable("#dataTablaReporteCotizaciones tbody", table_reporteCotizaciones);
	
	total_ingreso_footer();
}

var view_anularCotizaciones_dataTable = function(tbody, table){
	$(tbody).off("click", "button.cancelar_cotizaciones");
	$(tbody).on("click", "button.cancelar_cotizaciones", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		anularCotizacion(data.cotizacion_id);
	});
}

var view_enviarCotizaciones_dataTable = function(tbody, table){
	$(tbody).off("click", "button.email_cotizacion");
	$(tbody).on("click", "button.email_cotizacion", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		mailQuote(data.cotizacion_id);
	});
}

var view_reporteCotizaciones_dataTable = function(tbody, table){
	$(tbody).off("click", "button.print_cotizaciones");
	$(tbody).on("click", "button.print_cotizaciones", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		printQuote(data.cotizacion_id);
	});
}

function anularCotizacion(cotizacion_id){
	swal({
	  title: "¿Estas seguro?",
	  text: "¿Desea anular la cotización: # " + getNumeroCotizacion(cotizacion_id) + "?",
	  type: "info",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: "¡Sí, enviar anularla!",
	  cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		anular(cotizacion_id);
	});
}

function anular(cotizacion_id){
	var url = '<?php echo SERVERURL; ?>core/anularCotizacion.php';

	$.ajax({
	   type:'POST',
	   url:url,
	   async: false,
	   data:'cotizacion_id='+cotizacion_id,
	   success:function(data){
	      if(data == 1){
			swal({
				title: "Success",
				text: "La cotización ha sido anulada con éxito",
				type: "success",
			});
			listar_reporte_cotizaciones();
		  }else{
			swal({
				title: "Error",
				text: "La cotización no se pudo anular",
				type: "error",
				confirmButtonClass: "btn-danger",
			});			  
		  }
	  }
	});
}

function getReporteCotizacion(){
    var url = '<?php echo SERVERURL;?>core/getTipoFacturaReporte.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#form_main_cotizaciones #tipo_cotizacion_reporte').html("");
			$('#form_main_cotizaciones #tipo_cotizacion_reporte').html(data);
			$('#form_main_cotizaciones #tipo_cotizacion_reporte').selectpicker('refresh');	
		}
     });
}
//FIN REPORTE DE COTIZACIONES

var total_ingreso_footer = function(){	
	var fechai = $("#form_main_cotizaciones #fechai").val();
	var fechaf = $("#form_main_cotizaciones #fechaf").val();
	$.ajax({
		url : '<?php echo SERVERURL;?>core/totalCotizacionFooter.php',
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