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