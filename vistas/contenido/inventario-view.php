<div class="container-fluid">
    <ol class="breadcrumb mt-2 mb-4">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Movimientos de Inventario</li>
    </ol>
   <div class="card mb-4">
        <div class="card-body">
			<form class="" id="form_main_movimientos">
				<div class="row">
					<div class="form-group mx-sm-3 mb-1">			
						<div class="input-group">
							<div class="input-group-append">
								<span class="input-group-text"><div class="sb-nav-link-icon"></div>Categoría</span>
								  <select id="inventario_tipo_productos_id" name="inventario_tipo_productos_id" class="selectpicker" data-live-search="true" title="Categoría de Productos">
								 </select>
							</div>	
						</div>					
					</div>														
					<div class="form-group mx-sm-3 mb-1">
					  <div class="input-group">				
						  <div class="input-group-append">				
							  <span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Inicio</span>
						  </div>
						  <input type="date" required id="fechai" name="fechai" value="<?php echo date ("Y-m-d");?>" style="width:165px;" class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha Inicio">
					  </div>
					</div>	
					<div class="form-group mx-sm-3 mb-1">
					   <div class="input-group">				
						  <div class="input-group-append">				
							  <span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Fin</span>
						  </div>
						  <input type="date" required id="fechaf" name="fechaf" value="<?php echo date ("Y-m-d");?>" style="width:165px;" class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha Fin">
					  </div>
					</div>
					<div class="form-group mx-sm-3 mb-1">			
						<div class="input-group">
							<div class="input-group-append">
								<span class="input-group-text"><div class="sb-nav-link-icon"></div>Bodega</span>
								  <select id="almacen" name="almacen" class="selectpicker" data-live-search="true" title="Bodega">
								 </select>
							</div>	
						</div>					
					</div>
					<div class="form-group mx-sm-3 mb-1">			
						<div class="input-group">
							<div class="input-group-append">
								<span class="input-group-text"><div class="sb-nav-link-icon"></div>Producto</span>
								  <select id="producto_movimiento_filtro" name="producto_movimiento_filtro" class="selectpicker" data-live-search="true" title="Producto">
								 </select>
							</div>	
						</div>					
					</div>
				</div>
				<div class="row">
					<div class="form-group mx-sm-3 mb-1">			
						<div class="input-group">
							<div class="input-group-append">
								<span class="input-group-text"><div class="sb-nav-link-icon"></div>Producto</span>
								  <select id="cliente_movimiento_filtro" name="cliente_movimiento_filtro" class="selectpicker" data-live-search="true" title="Cliente">
								 </select>
							</div>	
						</div>					
					</div>
				</div>				  
			</form>          
        </div>
    </div>	
    <div class="card mb-4">
		<div class="card mb-4">
			<div class="card-header">
				<i class="fab fa-servicestack mr-1"></i>
				Inventario
			</div>
			<div class="card-body"> 
				<div class="table-responsive">
					<table id="dataTablaMovimientos" class="table table-striped table-condensed table-hover" style="width:100%">
						<thead>
							<tr>
							<th>Fecha</th>	
						    <th>Bar Code</th>
							<th>Cliente</th>
							<th>Producto</th>
							<th>Medida</th>
							<th>Documento</th>
							<th>Entrada</th>
							<th>Salida</th>
							<th>Comentario</th>
							<th>Bodega</th>
							</tr>
						</thead>
						<tfoot class="bg-info text-white font-weight-bold">
							<tr>
								<td colspan='1' class="text-center">Total</td>
								<td colspan="4"></td>
								<td></td>
								<td id="entrada-footer-movimiento"></td>
								<td id='salida-footer-movimiento'></td>
								<td id='total-footer-movimiento'></td>
								<td></td>
							</tr>
						</tfoot>
					</table>  
				</div>                   
			</div>
			<div class="card-footer small text-muted">
 			<?php
				require_once "./core/mainModel.php";
				
				$insMainModel = new mainModel();
				$entidad = "movimientos";
				
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
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Inventario");
?>