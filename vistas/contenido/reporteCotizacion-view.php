<div class="container-fluid">
    <ol class="breadcrumb mt-2 mb-4">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Reporte de Cotizaciones</li>
    </ol>
   <div class="card mb-4">
        <div class="card-body">
			<form class="form-inline" id="form_main_cotizaciones">
				<div class="form-group mx-sm-3 mb-1">
					<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Tipo Factura</span>
						</div>
						<select id="tipo_cotizacion_reporte" name="tipo_cotizacion_reporte" class="custom-select" data-toggle="tooltip" data-placement="top" title="Categoría de Productos">
					  </select>
					</div>
				</div>				
				<div class="form-group mx-sm-3 mb-1">
					<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Inicio</span>
						</div>
						<input type="date" required id="fechai" name="fechai" value="<?php 
						$fecha = date ("Y-m-d");
						
						$año = date("Y", strtotime($fecha));
						$mes = date("m", strtotime($fecha));
						$dia = date("d", mktime(0,0,0, $mes+1, 0, $año));

						$dia1 = date('d', mktime(0,0,0, $mes, 1, $año)); //PRIMER DIA DEL MES
						$dia2 = date('d', mktime(0,0,0, $mes, $dia, $año)); // ULTIMO DIA DEL MES

						$fecha_inicial = date("Y-m-d", strtotime($año."-".$mes."-".$dia1));
						$fecha_final = date("Y-m-d", strtotime($año."-".$mes."-".$dia2));						
						
						
						echo $fecha_inicial;
					?>" class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha Inicio">
					</div>
				  </div>	
				  <div class="form-group mx-sm-3 mb-1">
				 	<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Fin</span>
						</div>
						<input type="date" required id="fechaf" name="fechaf" value="<?php echo date ("Y-m-d");?>" class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha Fin">
					</div>
				  </div>
				  <div class="form-group mx-sm-2 mb-1">
               		 <button class="consultar btn btn-secondary ml-2" type="submit" id="search"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i> Buscar</button>
			 	 </div>   				  
			</form>          
        </div>
    </div>	
    <div class="card mb-4">
		<div class="card mb-4">
			<div class="card-header">
				<i class="fas fa-file-invoice-dollar mr-1"></i>
				Reporte de Cotizaciones
			</div>
			<div class="card-body"> 
				<div class="table-responsive">
					<table id="dataTablaReporteCotizaciones" class="table table-striped table-condensed table-hover" style="width:100%">
						<thead>
							<tr>						
							<th>Fecha</th>
							<th>Tipo</th>
							<th>Proveedor</th>
							<th>Factura</th>
							<th>SubTotal</th>
							<th>ISV</th>
							<th>Descuento</th>								
							<th>Total</th>
							<th>Imprimir</th>
							<th>Enviar</th>							
							<th>Anular</th>
							</tr>
						</thead>
						<tfoot class="bg-info text-white font-weight-bold">
							<tr>
								<td colspan='1'>Total</td>
								<td colspan="3"></td>
								<td id="subtotal-i"></td>
								<td id="impuesto-i"></td>
								<td id="descuento-i"></td>
								<td colspan='1' id='total-footer-ingreso'></td>
								<td colspan="3"></td>
							</tr>
						</tfoot>							
					</table>  
				</div>                   
				</div>
			<div class="card-footer small text-muted">
 			<?php
				require_once "./core/mainModel.php";
				
				$insMainModel = new mainModel();
				$entidad = "compras";
				
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
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Reporte de Compras");
?>