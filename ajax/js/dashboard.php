<script>
//DASHBOARD

function setTotalCustomers(){
    var url = '<?php echo SERVERURL;?>core/getTotalCustomers.php';

	var isv;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
		  $('#main_clientes').html(data);
		}
	});
	return isv;
}

function setTotalSuppliers(){
    var url = '<?php echo SERVERURL;?>core/getTotalSuppliers.php';

	var isv;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
		  $('#main_proveedores').html(data);
		}
	});
	return isv;
}

function setTotalBills(){
    var url = '<?php echo SERVERURL;?>core/getTotalBills.php';

	var isv;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
		  $('#main_facturas').html("L. " + data);
		}
	});
	return isv;
}

function setTotalPurchases(){
    var url = '<?php echo SERVERURL;?>core/getTotalPurchases.php';

	var isv;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
		  $('#main_compras').html("L. " + data);
		}
	});
	return isv;
}

$(document).ready(function () {
	//DASHBOARD
	setTotalCustomers();
	setTotalSuppliers()
	setTotalBills();
	setTotalPurchases();
    getMesFacturaCompra();
	listar_secuencia_fiscales_dashboard();
	$(window).scrollTop(0);

	setInterval('setTotalCustomers()',120000);
	setInterval('setTotalSuppliers()',120000);
	setInterval('setTotalBills()',120000);
	setInterval('setTotalPurchases()',120000);
	
	//GRAPHICS
	showVentasAnuales();
	showComprasAnuales();

	setInterval('showVentasAnuales()',120000);
	setInterval('showComprasAnuales()',120000);
});

//GRAFICAS
function showVentasAnuales(){
	var url = '<?php echo SERVERURL;?>core/getFacturaporAno.php';

	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
			var datos = eval(data);
			var mes = [];
			var total = [];
			
			for(var fila=0; fila < datos.length; fila++){
				mes.push(datos[fila]["mes"]);
				total.push(datos[fila]["total"]);
			}
			
			var ctx = document.getElementById('graphVentas').getContext('2d');	
			
			var chart = new Chart(ctx, {
				// The type of chart we want to create
				type: 'bar',

				// The data for our dataset
				data: {
					labels: mes,
					datasets: [{
						label: 'Reporte de Ventas Año <?php echo date("Y"); ?>',
						backgroundColor: '#4099ff',
						borderColor: '#4099ff',
						hoverBackgroundColor: '#73b4ff',
						hoverBorderColor: '#FAFAFA',
						borderWidth: 1,
						data: total,
						datalabels: {
							color: '#4099ff',
							anchor: 'end',
							align: 'top',
							labels: {
								title: {
									font: {
										weight: 'bold'
									}
								}
							}							
						}
					}]
				},

				// Configuration options go here
				plugins: [ChartDataLabels],
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					},
					plugins: {
						legend: {
							labels: {
								// This more specific font property overrides the global property
								font: {
									size: 12,
									weight: 'bold'
								}
							}
						}
					}
				}		
			});	
			return false;
		}
	});
}

function showComprasAnuales(){
    var url = '<?php echo SERVERURL;?>core/getCompraporAno.php';

	var isv;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
			var datos = eval(data);
			var mes = [];
			var total = [];
			
			for(var fila=0; fila < datos.length; fila++){
				mes.push(datos[fila]["mes"]);
				total.push(datos[fila]["total"]);
			}

			var ctx = document.getElementById('graphCompras').getContext('2d');		
			var chart = new Chart(ctx, {
				// The type of chart we want to create
				type: 'bar',

				// The data for our dataset
				data: {
					labels: mes,
					datasets: [{
						label: 'Reporte de Compras Año <?php echo date("Y"); ?>',
						backgroundColor: '#2ed8b6',
						borderColor: '#2ed8b6',
						hoverBackgroundColor: '#59e0c5',
						hoverBorderColor: '#FAFAFA',
						borderWidth: 1,
						data: total,
						datalabels: {
							color: '#2ed8b6',
							anchor: 'end',
							align: 'top',
							labels: {
								title: {
									font: {
										weight: 'bold'
									}
								}
							}							
						}
					}]
				},

				// Configuration options go here
				plugins: [ChartDataLabels],
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					},
					plugins: {
						legend: {
							labels: {
								// This more specific font property overrides the global property
								font: {
									size: 12,
									weight: 'bold'
								}
							}
						}
					}
				}		
			});	
			return false;
		}
	});
}	

var listar_secuencia_fiscales_dashboard = function(){
	var table_categoria_productos  = $("#dataTableSecuenciaDashboard").DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>core/llenarDataTableDocumentosFiscalesDashboard.php"
		},
		"columns":[
			{"data":"empresa"},
			{"data":"documento"},
			{"data":"inicio"},
			{"data":"fin"},
			{"data":"siguiente"},
			{"data":"fecha"}
		],
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,//esta se encuenta en el archivo main.js
		"dom": dom,
		"columnDefs": [
			{ width: "40.66%", targets: 0 },
			{ width: "12.66%", targets: 1 },
			{ width: "12.66%", targets: 2 },
			{ width: "12.66%", targets: 3 },
			{ width: "8.66%", targets: 4 },
			{ width: "12.66%", targets: 5 }
		],		
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Documentos Fiscales',
				className: 'table_actualizar btn btn-secondary ocultar',
				action: 	function(){
					listar_secuencia_fiscales_dashboard();
				}
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel fa-lg"></i> Excel',
				titleAttr: 'Excel',
				orientation: 'landscape',
				pageSize: 'LETTER',				
				title: 'Reporte Documentos Fiscales',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-success ocultar',
				exportOptions: {
					columns: [0,1,2,3,4,5]
				},				
			},
			{
				extend:    'pdf',
				text:      '<i class="fas fa-file-pdf fa-lg"></i> PDF',
				titleAttr: 'PDF',
				orientation: 'landscape',
				pageSize: 'LETTER',				
				title: 'Reporte Documentos Fiscales',
				messageBottom: 'Fecha de Reporte: ' + convertDateFormat(today()),
				className: 'table_reportes btn btn-danger ocultar',
				exportOptions: {
					columns: [0,1,2,3,4,5]
				},				
				customize: function ( doc ) {
					doc.content.splice( 1, 0, {
						margin: [ 0, 0, 0, 12 ],
						alignment: 'left',
						image: imagen,//esta se encuenta en el archivo main.js
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
	table_categoria_productos.search('').draw();
	$('#buscar').focus();

}
//DASHBOARD

function getMesFacturaCompra(){
    var url = '<?php echo SERVERURL;?>core/getMes.php';

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
			$('#mes_factura').html(data);
			$('#mes_compra').html(data);			
		}
     });
}


</script>