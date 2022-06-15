<div class="container-fluid">
    <ol class="breadcrumb mt-2 mb-4">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Almacén</li>
    </ol>
    <div class="card mb-4">
		<div class="card mb-4">
			<div class="card-header">
				<i class="fab fas fa-warehouse mr-1"></i>
				Almacén
			</div>
			<div class="card-body"> 
				<div class="table-responsive">
					<table id="dataTableConfAlmacen" class="table table-striped table-condensed table-hover" style="width:100%">
						<thead>
							<tr>
								<th>Empresa</th>
								<th>Almacén</th>
								<th>Facturar en Cero</th>
								<th>Ubicación</th>
								<th>Editar</th>
								<th>Eliminar</th>
							</tr>
						</thead>
					</table>  
				</div>                   
				</div>
			<div class="card-footer small text-muted">
 			<?php
				require_once "./core/mainModel.php";
				
				$insMainModel = new mainModel();
				$entidad = "almacen";
				
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
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Configurar Almacén");
?>