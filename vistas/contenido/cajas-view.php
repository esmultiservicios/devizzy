<div class="container-fluid">
    <ol class="breadcrumb mt-2 mb-4">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Cajas</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
			<form class="form-inline" id="formMainCajas" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
			  <div class="form-group mx-sm-3 mb-1">
					<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha</span>
						</div>
						<input type="date" class="form-control" id="fecha_cajas" name="fecha_cajas" value="<?php echo date('Y-m-d');?>">
					</div>
				</div>			  
				<div class="form-group mx-sm-2">
					<button class="consultar btn btn-secondary" type="submit" id="search"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i> Buscar</button>
				</div> 			  
			</form>	           
        </div>
    </div>	
	<div class="card mb-4">
		<div class="card-header">
				<i class="fas fa-cash-register mr-1"></i>
				Cajas
		</div>
		<div class="card-body"> 
				<div class="table-responsive">
					<table id="dataTableCajas" class="table table-striped table-condensed table-hover" style="width:100%">
						<thead>
							<tr>
								<th>Acción</th>									
								<th>Fecha</th>	
								<th>Usuario</th>
								<th>Factura Inicial</th>
								<th>Factura Final</th>
								<th>Monto Apertura</th>
								<th>Venta del Día</th>
								<th>Neto</th>
								<th>Estado</th>															
							</tr>
						</thead>
					</table>  
				</div>                   
				</div>
			<div class="card-footer small text-muted">
 			<?php
				require_once "./core/mainModel.php";
				
				$insMainModel = new mainModel();
				$entidad = "facturas";
				
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
		</div>
	</div>	

<?php
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Cajas");
?>