<div class="container-fluid">
	<ol class="breadcrumb mt-2 mb-4">
		<li class="breadcrumb-item active">Dashboard</li>
	</ol>
	<div class="row">
		<div class="col-md-4 col-xl-3">
			<a href="<?php echo SERVERURL; ?>clientes/">
				<div class="stati card bg-c-blue order-card">
					<div class="card-block">
						<h6 class="m-b-20">Total Clientes</h6>
						<h2 class="text-right"><i class="fas fa-user-tie f-left"></i><span id="main_clientes"></span></h2>
						<p class="m-b-0"> <span class="f-right">Nuestros Clientes</span></p>
					</div>
				</div>
			</a>
		</div>
		
		<div class="col-md-4 col-xl-3">
			<a href="<?php echo SERVERURL; ?>proveedores/">
				<div class="stati card bg-c-green order-card">
					<div class="card-block">
						<h6 class="m-b-20">Total Proveedores</h6>
						<h2 class="text-right"><i class="fas fa-user-alt f-left"></i><span id="main_proveedores"></span></h2>
						<p class="m-b-0"><span class="f-right">Nuestros Proveedores</span></p>
					</div>
				</div>
			</a>
		</div>
		
        <div class="col-md-4 col-xl-3">
			<a href="<?php echo SERVERURL; ?>reporteVentas/">
				<div class="stati card bg-c-yellow order-card">
					<div class="card-block">
						<h6 class="m-b-20">Total Facturas</h6>
						<h2 class="text-right"><i class="fas fa-file-invoice f-left"></i><span id="main_facturas"></span></h2>
						<p class="m-b-0"><span class="f-right" id="mes_factura"</span></p>
					</div>
				</div>
			</a>
        </div>
        
        <div class="col-md-4 col-xl-3">
			<a href="<?php echo SERVERURL; ?>reporteCompras/">
				<div class="stati card bg-c-pink order-card">
					<div class="card-block">
						<h6 class="m-b-20">Total Compras</h6>
						<h2 class="text-right"><i class="fas fa-shopping-cart f-left"></i><span id="main_compras"></span></h2>
						<p class="m-b-0"><span class="f-right" id="mes_compra"></span></p>
					</div>
				</div>
			</a>
        </div>
		
	</div>

	<div class="row">
		<div class="col-xl-6">
			<a href="<?php echo SERVERURL; ?>reporteVentas/" style="color: #3366BB;">
				<div class="stati card mb-3">
					<div class="card-header">
						<i class="fas fa-chart-bar mr-1"></i>
						Reporte Ventas: <?php echo date("Y"); ?>
					</div>
					<canvas id="graphVentas" width="100%"></canvas>
				</div>
			</a>
		</div>
			
		<div class="col-xl-6">
			<a href="<?php echo SERVERURL; ?>reporteCompras/" style="color: #3366BB;">
				<div class="stati card mb-4">
					<div class="card-header">
						<i class="fas fa-chart-bar mr-1"></i>
						Reporte de Compras: <?php echo date("Y"); ?>
					</div>
					<div class="card-body"><canvas id="graphCompras" width="100%"></canvas></div>
				</div>
			</a>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12">
			<a href="<?php echo SERVERURL; ?>secuencia/" style="color: #3366BB;">
				<div class="card-header">
					<i class="fas fa-sliders-h mr-1"></i>
					Documentos Fiscales
				</div>
				<div class="card-body"> 
					<div class="table-responsive">
						<table id="dataTableSecuenciaDashboard" class="table table-striped table-condensed table-hover" style="width:100%">
							<thead>
								<tr>
									<th>Empresa</th>
									<th>Documento</th>
									<th>Rango Inicio</th>
									<th>Rango Fin</th>	
									<th>Actual</th>										
									<th>Fecha Expiración</th>					
								</tr>
							</thead>
						</table>  
					</div>                   
				</div>
				<div class="card-footer small text-muted">
				<?php
					require_once "./core/mainModel.php";
					
					$insMainModel = new mainModel();
					$entidad = "secuencia_facturacion";
					
					if($insMainModel->getlastUpdate($entidad)->num_rows > 0){
						$consulta_last_update = $insMainModel->getlastUpdate($entidad)->fetch_assoc();
						
						$fecha_registro = $consulta_last_update['fecha_registro'];
						$hora = date('g:i:s a',strtotime($fecha_registro));
										
						echo "Última Actualización ".$insMainModel->getTheDay($fecha_registro, $hora);						
					}else{
						echo "No se encontraron registros ";
					}			
				?>
				</div>				
			</a>
		</div>
			
	</div>	
</div>
<?php
	require_once "./core/mainModel.php";
	
	$insMainModel = new mainModel();	
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Dashboard");
?>