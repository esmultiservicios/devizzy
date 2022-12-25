	<div class="container-fluid">
    <ol class="breadcrumb mt-2 mb-4">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Egresos</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
			<form class="form-inline" id="formMainGastosContabilidad" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
				<div class="form-group mx-sm-3 mb-1">
					<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Estado</span>
						</div>
						<select id="estado_egresos" name="estado_egresos" class="custom-select" data-toggle="tooltip" data-placement="top" title="Tipo de Factura">
							<option value="1">Activas</option>
							<option value="2">Anuladas</option>
					  </select>
					</div>
				</div>					
				<div class="form-group mx-sm-3 mb-1">
					<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Inicio</span>
						</div>
						<input type="date" class="form-control" id="fechai" name="fechai" value="<?php 
							$fecha = date ("Y-m-d");
							
							$año = date("Y", strtotime($fecha));
							$mes = date("m", strtotime($fecha));
							$dia = date("d", mktime(0,0,0, $mes+1, 0, $año));

							$dia1 = date('d', mktime(0,0,0, $mes, 1, $año)); //PRIMER DIA DEL MES
							$dia2 = date('d', mktime(0,0,0, $mes, $dia, $año)); // ULTIMO DIA DEL MES

							$fecha_inicial = date("Y-m-d", strtotime($año."-".$mes."-".$dia1));
							$fecha_final = date("Y-m-d", strtotime($año."-".$mes."-".$dia2));						
							
							
							echo $fecha_inicial;
						?>">
					</div>
				</div>	
				<div class="form-group mx-sm-3 mb-1">
					<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Fin</span>
						</div>
						<input type="date" class="form-control" id="fechaf" name="fechaf" value="<?php echo date('Y-m-d');?>" >
					</div>
				</div>
			  	<div class="form-group mx-sm-2 mb-1">
               	 	<button class="consultar btn btn-secondary" type="submit" id="search"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i> Buscar</button>
			  	</div> 			  
			</form>	           
        </div>
    </div>		
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-invoice-dollar mr-1"></i>
            Egresos
        </div>
        <div class="card-body"> 
            <div class="table-responsive">
                <table id="dataTableGastosContabilidad" class="table table-striped table-condensed table-hover" style="width:100%">
                    <thead>
                        <tr>
						    <th>Fecha Registro</th>
							<th>Numero de Gasto</th>
						    <th>Fecha Factura</th>
						    <th>Forma de Pago</th>							
							<th>Proveedor</th>
							<th>Numero Factura</th>
                            <th>Subtotal</th>
                            <th>Impuesto</th>
                            <th>Descuento</th>
                            <th>NC</th>									
                            <th>Total</th>
							<th>Editar</th>
							<th>Imprimir</th>						
                        </tr>
                    </thead>
					<tfoot class="bg-info text-white font-weight-bold">
						<tr>
						<td colspan='1'>Total</td>
						<td colspan="5"></td>
						<td id="subtotal-g"></td>
						<td id="impuesto-g"></td>
						<td id="descuento-g"></td>
						<td id="nc-g"></td>
						 <td colspan='1' id='total-footer-gastos'></td>
						<td colspan="2"></td>

						</tr>
					</tfoot>
                </table>  
            </div>                   
            </div>
        <div class="card-footer small text-muted">
			<div class="row">
				<div class="col-md-6">
					<?php
						require_once "./core/mainModel.php";
						
						$insMainModel = new mainModel();
						$entidad = "egresos";
						
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
    </div>
</div>
<?php
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Gastos Contabilidad");
?>