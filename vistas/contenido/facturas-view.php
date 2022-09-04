<body id="view_bill">
	<div class="container-fluid">
		<!--<ol class="breadcrumb mt-2 mb-4">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>dashboard/">Dashboard</a></li>
			<li class="breadcrumb-item active">Facturas</li>
		</ol>-->	
		<div class="card mb-4">
			<div class="card-header">
				<i class="fas fa-file-invoice mr-1"></i>
				Facturas
			</div>
			<div class="card-body"> 
				<form class="FormularioAjax" id="invoice-form" action="<?php echo SERVERURL;?>ajax/addFacturaAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
					<div class="form-group row customer-bill-box-left">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<span id="rtn-customers-bill"></span> <span id="client-customers-bill"></span>
						</div>	
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							</span> <span id="vendedor-customers-bill"></span>
						</div>				
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<span id="comentario-customers-bill"></span>
						</div>	
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						</div>				
					</div>
					<div class="form-group row customer-bill-box-right">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<span id="fecha-customers-bill"></span>
						</div>			
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<span id="hora-customers-bill"></span>
						</div>		
					</div>				
					<div class="bill">
						<div class="form-group row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<button class="btn btn-secondary" type="submit" id="help_factura" form="invoice-form" data-toggle="tooltip" data-placement="top" title="Cobrar"><div class="sb-nav-link-icon"></div><i class="fas fa-question-circle fa-lg"></i> [F1] Ayuda</button>
								<button class="btn btn-secondary" type="submit" id="reg_factura" form="invoice-form" data-toggle="tooltip" data-placement="top" title="Cobrar"><div class="sb-nav-link-icon"></div><i class="fas fa-hand-holding-usd fa-lg"></i> [F6] Cobrar</button>
								<button class="btn btn-secondary" type="submit" id="add_cliente" form="invoice-form" data-toggle="tooltip" data-placement="top" title="Agregar Cliente"><div class="sb-nav-link-icon"></div><i class="fas fa-user-plus fa-lg"></i> [F7] Cliente</button>	
								<button class="btn btn-secondary" type="submit" id="add_vendedor" form="invoice-form" data-toggle="tooltip" data-placement="top" title="Agregar Vendeor o Empleado"><div class="sb-nav-link-icon"></div><i class="fas fa-plus-circle fa-lg"></i> [F8] Vendedor</button>						
								<button class="btn btn-secondary" type="submit" id="btn_apertura" form="invoice-form" data-toggle="tooltip" data-placement="top" title="Aperturar Caja"><div class="sb-nav-link-icon"></div><i class="fas fa-cash-register fa-lg"></i> [F9] Aperturar</button>					
								<button class="btn btn-secondary" type="submit" id="btn_cierre" form="invoice-form" data-toggle="tooltip" data-placement="top" title="Cerrar Caja" style="display:none;"><div class="sb-nav-link-icon"></div><i class="fas fa-cash-register fa-lg"></i> [F10] Cerrar</button>
									<label class="switch mb-2" data-toggle="tooltip" data-placement="top" title="Tipo de Factura, Contado o Crédito">
										<input type="checkbox" id="facturas_activo" name="facturas_activo" value="1" checked>
										<div class="slider round"></div>
									</label>
									<span class="question mb-2" id="label_facturas_activo"></span>
							</div>
						</div>
						<div class="form-group row" style="display:none">
							<label for="inputCliente" class="col-sm-1 col-form-label-md">Cliente <span class="priority">*<span/></label>
							<div class="col-sm-5">
								<div class="input-group mb-3">
								  <input type="hidden" class="form-control" placeholder="Proceso" id="proceso_factura" name="proceso_factura" readonly>
								  <input type="hidden" class="form-control" placeholder="Factura" id="facturas_id" name="facturas_id" readonly>
								  <input type="hidden" class="form-control" placeholder="Cliente" id="cliente_id" name="cliente_id" readonly required>
								  <input type="text" class="form-control" placeholder="Cliente" id="cliente" name="cliente" required readonly data-toggle="tooltip" data-placement="top" title="Cliente">
								  <div class="input-group-append" id="grupo_buscar_colaboradores">
									<span data-toggle="tooltip" data-placement="top" title="Búsqueda de Empleados"><a data-toggle="modal" href="#" class="btn btn-outline-success" id="buscar_clientes"><div class="sb-nav-link-icon"></div><i class="fas fa-search-plus fa-lg"></i></a></span>
								  </div>
								</div>
							</div>
							<label for="inputFecha" class="col-sm-1 col-form-label-md">Fecha <span class="priority">*<span/></label>
							<div class="col-sm-3">
							  <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" required id="fecha" name="fecha" data-toggle="tooltip" data-placement="top" title="Fecha de Facturación" style="width:165px">
							</div>
						</div>
						<div class="form-group row" style="display:none">
							<label for="inputCliente" class="col-sm-1 col-form-label-md">Vendedor <span class="priority">*<span/></label>
							<div class="col-sm-5">
								<div class="input-group mb-3">
								  <input type="hidden" class="form-control" placeholder="Vendedor" id="colaborador_id" name="colaborador_id" aria-label="Colaborador" aria-describedby="basic-addon2" readonly required>
								  <input type="text" class="form-control" placeholder="Vendedor" id="colaborador" name="colaborador" aria-label="Colaborador" aria-describedby="basic-addon2" required readonly data-toggle="tooltip" data-placement="top" title="Vendedor">
								  <div class="input-group-append" id="grupo_buscar_colaboradores">
									<span data-toggle="tooltip" data-placement="top" title="Búsqueda de Colaboradores"><a data-toggle="modal" href="#" class="btn btn-outline-success" id="buscar_colaboradores"><div class="sb-nav-link-icon"></div><i class="fas fa-search-plus fa-lg"></i></a><span>
								  </div>
								</div>
							</div>				
						</div>
						<div class="form-group row table-responsive-xl tableFixHead table table-hover">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<table id="invoiceItem">
									<thead align="center" class="table-success">
										<tr>
											<th width="2%" scope="col"><input id="checkAll" class="formcontrol" type="checkbox"></th>
											<th width="17.28%">Código</th>
											<th width="24.28%">Descripción del Producto</th>
											<th width="10.28%">Cantidad</th>
											<th width="10.28%">Medida</th>
											<th width="11.28%">Precio</th>
											<th width="11.28%">Descuento</th>
											<th width="11.28%">Total</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input class="itemRow" type="checkbox"></td>
											<td>
												<input type="hidden" name="referenciaProducto[]" id="referenciaProducto_0" class="form-control inputfield-details1" placeholder="Referencia Producto Precio" autocomplete="off">
												<input type="hidden" name="isv[]" id="isv_0" class="form-control inputfield-details1" placeholder="Producto ISV" autocomplete="off">
												<input type="hidden" name="valor_isv[]" id="valor_isv_0" class="form-control inputfield-details1" placeholder="Valor ISV" autocomplete="off">
												<input type="hidden" name="productos_id[]" id="productos_id_0" class="form-control inputfield-details1" placeholder="Código del Producto" autocomplete="off">
												<div class="input-group mb-3">
													 <div class="input-group-append">				
														<span data-toggle="tooltip" data-placement="top" title="Búsqueda de Productos" id="icon-search-bar_0"><a data-toggle="modal" href="#" class="btn btn-link form-control buscar_productos"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg icon-color"></i></a></span>
														<input type="text" name="bar-code-id[]" id="bar-code-id_0" class="form-control product-bar-code inputfield-details1" placeholder="Código del Producto" autocomplete="off">
													 </div>
												</div>								
											</td>
											<td>
												<input type="text" name="productName[]" id="productName_0" placeholder="Descripción del Producto" readonly class="form-control inputfield-details1" autocomplete="off">								
											</td>
											<td>
												<input type="number" name="quantity[]" id="quantity_0" placeholder="Cantidad" class="buscar_cantidad form-control inputfield-details" autocomplete="off" step="0.01">
												<input type="hidden" name="cantidad_mayoreo[]" id="cantidad_mayoreo_0" placeholder="Cantidad Mayoreo" class="buscar_cantidad form-control inputfield-details" autocomplete="off" step="0.01">
											</td>
											<td>
												<input type="text" name="medida[]" id="medida_0" readonly class="form-control buscar_medida" autocomplete="off" placeholder="Medida">
											</td>
											<td>
												<input type="hidden" name="precio_real[]" id="precio_real_0" placeholder="Precio Real" class="form-control inputfield-details" step="0.01" readonly autocomplete="off">
												<input type="number" name="price[]" id="price_0" placeholder="Precio" class="form-control inputfield-details" step="0.01" readonly autocomplete="off">
												<input type="hidden" name="precio_mayoreo[]" id="precio_mayoreo_0" placeholder="Precio mayoreo" step="0.01" class="form-control inputfield-details" readonly autocomplete="off">
											</td>
											<td><input type="number" name="discount[]" id="discount_0" placeholder="Descuento" value="0.00" step="0.01" class="form-control inputfield-details" readonly autocomplete="off" step="0.01"></td>
											<td><input type="number" name="total[]" id="total_0" placeholder="Total" class="form-control total inputfield-details" step="0.01" readonly autocomplete="off"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<hr class="line_table" />
						<div class="form-group row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<button class="btn btn-secondary ml-3 bill-bottom-add" id="addRows" type="button" data-toggle="tooltip" data-placement="top" title="Agregar filas en la factura"><div class="sb-nav-link-icon"></div><i class="fas fa-plus"></i> Agregar</button>
								<button class="btn btn-secondary delete bill-bottom-remove" id="removeRows" type="button" data-toggle="tooltip" data-placement="top" title="Remover filas en la factura"><div class="sb-nav-link-icon"></div><i class="fas fa-minus"></i> Quitar</button>	
								<button class="btn btn-secondary bill-bottom-remove" id="addQuotetoBill" type="button" data-toggle="tooltip" data-placement="top" title="Convertir Cotizacion en Factura"><div class="sb-nav-link-icon"></div><i class="fas fa-file-invoice-dollar fa-lg"></i> Convertir</button>	
								<button class="btn btn-secondary bill-bottom-remove" id="addPayCustomers" type="button" data-toggle="tooltip" data-placement="top" title="Cobrar Cuentas por Pagar Clientes"><div class="sb-nav-link-icon"></div><i class="fas fa-hand-holding-usd fa-lg"></i> CxC</button>					
								<button class="btn btn-secondary bill-bottom-remove" id="addDraft" type="button" data-toggle="tooltip" data-placement="top" title="Facturas Guardadas en Borrador"><div class="sb-nav-link-icon"></div><i class="fas fa-file-invoice"></i> Borrador</button>	
								<button class="btn btn-secondary bill-bottom-remove" id="BillReports" type="button" data-toggle="tooltip" data-placement="top" title="Facturas Guardadas"><div class="sb-nav-link-icon"></div><i class="fas fa-file-invoice"></i> Facturas</button>																
							</div>
						</div>
						<div class="form-group row">
						  <div class="form-row col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-sm-12 col-md-12">
								<h3>Notas: </h3>
								<div class="form-group">
									<textarea class="form-control txt" rows="6" name="notesBill" id="notesBill" placeholder="Notas" maxlength="2000"></textarea>
									<p id="charNum_notasQuote">2000 Caracteres</p>
								</div>				
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group row">
									<div class="card-body">
										<div class="form-group mx-sm-3 mb-1">
												<div class="input-group">				
													<div class="input-group-append">				
														<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Cambio Dolar</span>
													</div>
													<input type="date" class="form-control" id="fecha_dolar" name="fecha_dolar" value="<?php echo date('Y-m-d');?>">
												</div>
										</div>			  
													
									</div>
								</div>
							</div>	
															
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4" style="display: none;">
							  <div class="row">					  
								<div class="col-sm-3 form-inline">
								  <label>Importe:</label>
								</div>
								<div class="col-sm-9">	
									<div class="input-group">
										<div class="input-group-append mb-1">				
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>L</i></span>
										</div>												
										<input value="" type="number" class="form-control" name="subTotalImporte" id="subTotalImporte" readonly placeholder="Importe">
									</div>
								</div>
							  </div>
							  <div class="row">					  
								<div class="col-sm-3 form-inline">
								  <label>Descuento:</label>
								</div>
								<div class="col-sm-9">	
									<div class="input-group">
										<div class="input-group-append mb-1">				
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>L</i></span>
										</div>												
										<input value="" type="number" class="form-control" name="taxDescuento" id="taxDescuento" readonly placeholder="Descuento">
									</div>
								</div>
							  </div>				  
							  <div class="row">					  
								<div class="col-sm-3 form-inline">
								  <label>Subtotal:</label>
								</div>
								<div class="col-sm-9">	
									<div class="input-group">
										<div class="input-group-append mb-1">				
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>L</i></span>
										</div>												
										<input value="" type="number" class="form-control" name="subTotal" id="subTotal" readonly placeholder="Subtotal">
									</div>
								</div>
							  </div>
							  <div class="row">
								<div class="col-sm-3 form-inline">
								  <label>ISV:</label>
								</div>
								<div class="col-sm-9">
									<div class="input-group mb-1">											
										<div class="input-group-append">				
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>L</i></span>
										</div>	
										<input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" readonly placeholder="Impuesto">
									</div>
								</div>
							  </div>					  
							  <div class="row">
								<div class="col-sm-3 form-inline">
									<label>Total:</label>
								</div>
								<div class="col-sm-9">
									<div class="input-group mb-1">
										<div class="input-group-append">				
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>L</i></span>
										</div>	
										<input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" readonly placeholder="Total">
									</div>
								</div>
							  </div>
							</div>
						  </div>
						</div>	

						
					</div>
					<div class="RespuestaAjax"></div> 
				</form>			
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
</body>

<?php
	require_once "./core/mainModel.php";
	
	$insMainModel = new mainModel();				
	$insMainModel->guardar_historial_accesos("Ingreso al modulo Facturas");
?>