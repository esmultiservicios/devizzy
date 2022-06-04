	<div class="container-fluid">
    <ol class="breadcrumb mt-2 mb-4">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Cuentas por Cobrar Clientes</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
			<form class="form-inline" id="form_main_cobrar_clientes">
				<div class="form-group mx-sm-3 mb-1">
					<div class="input-group">				
						<div class="input-group-append">				
							<span class="input-group-text"><div class="sb-nav-link-icon"></div>Buscar por </span>
						</div>
						<select id="tipo_busqueda" name="tipo_busqueda" class="custom-select" data-toggle="tooltip" data-placement="top" title="Tipo Busqueda">
							<option value="1">Registro</option>
							<option value="2">Fecha</option>
					  </select>
					</div>
				</div>					
				  <div class="form-group mx-sm-3 mb-2">
					<label>Fecha Inicio</label>
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
					?>" class="form-control ml-1" data-toggle="tooltip" data-placement="top" title="Fecha Inicio">
				  </div>	
				  <div class="form-group mx-sm-3 mb-2">
					<label>Fecha Fin</label>
					<input type="date" required id="fechaf" name="fechaf" value="<?php echo date ("Y-m-d");?>" class="form-control ml-1" data-toggle="tooltip" data-placement="top" title="Fecha Fin">
				  </div>
				  <div class="form-group mx-sm-2 mb-3">
               		 <button class="consultar btn btn-secondary ml-2" type="submit" id="search"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i> Buscar</button>
			 	 </div>  				  
			</form>          
        </div>
    </div>    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-sliders-h mr-1"></i>
            Cuentas por Cobrar Clientes
        </div>
        <div class="card-body"> 
            <div class="table-responsive">
                <table id="dataTableCuentasPorCobrarClientes" class="table table-striped table-condensed table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cobrar</th>
                            <th>Abonar</th>
							<th>Fecha</th>
                            <th>Cliente</th>
                            <th>Factura</th>
                            <th>Crédito</th>
                            <th>Abonos</th>
                            <th>Saldo</th>							
                        </tr>
                    </thead>
                </table>  
            </div>                   
            </div>
        <div class="card-footer small text-muted">
 			<?php
				require_once "./core/mainModel.php";
				
				$insMainModel = new mainModel();
				$entidad = "cobrar_clientes";
				
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
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Cuentas por Cobrar Clientes");
?>