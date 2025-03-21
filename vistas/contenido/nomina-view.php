<div id="nomina_principal">
    <div class="container-fluid">
        <ol class="breadcrumb mt-2 mb-4">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>dashboard/">Dashboard</a></li>
            <li class="breadcrumb-item active">Nomina</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <form class="form-inline" id="form_main_nominas">
                    <div class="form-group mx-sm-3 mb-1">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="sb-nav-link-icon"></div>Estado
                                </span>
                                <select id="estado_nomina" class="selectpicker" name="estado_nomina" data-live-search="true" title="Estado">
                                    <option value="0">Sin Generar</option>
                                    <option value="1">Generada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mx-sm-3 mb-1">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="sb-nav-link-icon"></div>Tipo Contrato
                                </span>
                                <select id="tipo_contrato_nomina" name="tipo_contrato_nomina" class="selectpicker"
                                    title="Tipo Contrato" data-live-search="true">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mx-sm-3 mb-1">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="sb-nav-link-icon"></div>Pago Planificado
                                </span>
                                <select id="pago_planificado_nomina" name="pago_planificado_nomina" class="selectpicker"
                                    data-live-search="true" title="Pago Planificado">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mx-sm-3 mb-1">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="sb-nav-link-icon"></div>Inicio
                                </span>
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
						?>" class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha Inicio" style="width:165px;">
                        </div>
                    </div>
                    <div class="form-group mx-sm-3 mb-1">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="sb-nav-link-icon"></div>Fin
                                </span>
                            </div>
                            <input type="date" required id="fechaf" name="fechaf" value="<?php 
							$fecha = date ("Y-m-d");
							
							$año = date("Y", strtotime($fecha));
							$mes = date("m", strtotime($fecha));
							$dia = date("d", mktime(0,0,0, $mes+1, 0, $año));

							$dia1 = date('d', mktime(0,0,0, $mes, 1, $año)); //PRIMER DIA DEL MES
							$dia2 = date('d', mktime(0,0,0, $mes, $dia, $año)); // ULTIMO DIA DEL MES

							$fecha_inicial = date("Y-m-d", strtotime($año."-".$mes."-".$dia1));
							$fecha_final = date("Y-m-d", strtotime($año."-".$mes."-".$dia2));						
							
							
							echo $fecha_final;
						?>" class="form-control" data-toggle="tooltip" data-placement="top" title="Fecha Fin" style="width:165px;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-hand-holding-usd mr-1"></i>
                    Nomina
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableNomina" class="table table-striped table-condensed table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Detalle</th>
                                    <th>Empresa</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Importe</th>
                                    <th>Notas</th>
                                    <th>Acciones</th>
                                    <th>Crear</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tfoot class="bg-info text-white font-weight-bold">
                                <tr>
                                    <td colspan='1'>Total</td>
                                    <td colspan="4"></td>
                                    <td id="neto_importe"></td>
                                    <td colspan="5"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">
                    <?php
					require_once "./core/mainModel.php";
					
					$insMainModel = new mainModel();
					$entidad = "nomina";
					
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
    <?php
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Nomnas");
?>
</div>
<div id="nomina_detalles" style="display: none;">
    <div class="container-fluid">
        <ol class="breadcrumb mt-2 mb-4">
            <li class="breadcrumb-item"><a class="breadcrumb-link"
                    href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
            <li class="breadcrumb-item active"><a class="breadcrumb-link" id="volver_nomina"
                    href="<?php echo SERVERURL; ?>dashboard/">Nomina</a></li>
            <li class="breadcrumb-item active" id="volver_nomina_empleados">Empleados</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <form class="form-inline" id="form_main_nominas_detalles">
                    <input type="hidden" class="form-control" id="nomina_id" name="nomina_id">
                    <input type="hidden" id="fecha_inicio" name="fecha_inicio" class="form-control">
                    <input type="hidden" id="fecha_fin" name="fecha_fin" class="form-control">
                    <div class="form-group mx-sm-3 mb-1">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="sb-nav-link-icon"></div>Estado
                                </span>
                                <select id="estado_nomina_detalles" class="selectpicker" data-live-search="true">
                                    <option value="0">Sin Generar</option>
                                    <option value="1">Generada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mx-sm-3 mb-1">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="sb-nav-link-icon"></div>Empleado
                                </span>
                                <select id="detalle_nomina_empleado" name="detalle_nomina_empleado" class="selectpicker"
                                    title="Empleado" data-live-search="true">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-hand-holding-usd mr-1"></i>
                    Nomina
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableNominaDetalles" class="table table-striped table-condensed table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nomina</th>
                                    <th>Contrato</th>
                                    <th>Empresa</th>
                                    <th>Empleado</th>
                                    <th>Neto Ingresos</th>
                                    <th>Neto Egresos</th>
                                    <th>Neto</th>
                                    <th>Notas</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tfoot class="bg-info text-white font-weight-bold">
                                <tr>
                                    <td colspan='1'>Total</td>
                                    <td colspan="3"></td>
                                    <td id="neto_ingreso"></td>
                                    <td id="neto_egreso"></td>
                                    <td id="neto"></td>
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
					$entidad = "nomina_detalles";
					
					if($insMainModel->getlastUpdate($entidad)->num_rows > 0){
						$consulta_last_update = $insMainModel->getlastUpdate($entidad)->fetch_assoc();
						$fecha_registro = htmlspecialchars($consulta_last_update['fecha_registro'], ENT_QUOTES, 'UTF-8');
						$hora = htmlspecialchars(date('g:i:s a', strtotime($fecha_registro)), ENT_QUOTES, 'UTF-8');
						echo "Última Actualización ".htmlspecialchars($insMainModel->getTheDay($fecha_registro, $hora), ENT_QUOTES, 'UTF-8');
					} else {
						echo "No se encontraron registros ";
					}					
				?>
                </div>
            </div>
        </div>
    </div>
    <?php
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Nomna de Empleados");
?>

</div>