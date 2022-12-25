<!--INICIO MODAL PARA EL FORMULARIO DE INGRESOS CONTABLES-->
<div class="modal fade" id="modalIngresosContables">
	<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ingresos</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
        </div><div class="container"></div>
        <div class="modal-body">		
			<form class="form-horizontal FormularioAjax" id="formIngresosContables" action="" method="POST" data-form="" enctype="multipart/form-data">				
				<div class="form-row">
					<div class="col-md-12 mb-3">
					    <input type="hidden" required="required" readonly id="ingresos_id" name="ingresos_id"/>
						<div class="input-group mb-3">
							<input type="text" required readonly id="pro_ingresos_contabilidad" name="pro_ingresos_contabilidad" class="form-control"/>
							<div class="input-group-append">				
								<span class="input-group-text"><div class="sb-nav-link-icon"></div><i class="fa fa-plus-square fa-lg"></i></span>
							</div>
						</div>	 
					</div>							
				</div>
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label for="cliente_ingresos">Proveedor <span class="priority">*<span/></label>
					    <div class="input-group mb-3">
						  <select id="cliente_ingresos" name="cliente_ingresos" class="selectpicker" data-live-search="true" title="Proveedor">
							<option value="">Seleccione</option>
						  </select>
					    </div>
					</div>
					<div class="col-md-3 mb-3">
						<label for="cuenta_ingresos">Cuenta <span class="priority">*<span/></label>
					    <div class="input-group mb-3">
						  <select id="cuenta_ingresos" name="cuenta_ingresos" class="selectpicker" data-live-search="true" title="Cuenta">
							<option value="">Seleccione</option>
						  </select>
					    </div>
					</div>	
					<div class="col-md-3 mb-3">
						<label for="empresa_ingresos">Empresa <span class="priority">*<span/></label>
					    <div class="input-group mb-3">
						  <select id="empresa_ingresos" name="empresa_ingresos" class="selectpicker" data-live-search="true" title="Empresa">
							<option value="">Seleccione</option>
						  </select>
					    </div>
					</div>				
					<div class="col-md-3 mb-3">
					  <label for="fecha_ingresos">Fecha Factura <span class="priority">*<span/></label>
					  <input type="date" required id="fecha_ingresos" name="fecha_ingresos" value="<?php echo date ("Y-m-d");?>" class="form-control" />
					</div>					
				</div>				
				<div class="form-row">
					<div class="col-md-6 mb-3">
					  <label for="factura_ingresos">Factura <span class="priority">*<span/></label>
					  <input type="text" required id="factura_ingresos" name="factura_ingresos" placeholder="Factura" class="form-control"  maxlength="19" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
					</div>				
					<div class="col-md-3 mb-3">
					  <label for="subtotal_ingresos">Subtotal <span class="priority">*<span/></label>
					  <input type="number" required id="subtotal_ingresos" name="subtotal_ingresos" placeholder="Subtotal" class="form-control" step="0.01" />
					</div>				
					<div class="col-md-3 mb-3">
					  <label for="isv_ingresos">ISV <span class="priority">*<span/></label>
					  <input type="number" required id="isv_ingresos" name="isv_ingresos" placeholder="ISV" class="form-control" step="0.01" value = "0"/>
					</div>						
				</div>	
				<div class="form-row">
					<div class="col-md-4 mb-3">
					  <label for="descuento_ingresos">Descuento</label>
					  <input type="number" id="descuento_ingresos" name="descuento_ingresos" placeholder="Descuento" class="form-control" step="0.01" value = "0"/>
					</div>				
					<div class="col-md-4 mb-4">
					  <label for="nc_ingresos">NC </label>
					  <input type="number" id="nc_ingresos" name="nc_ingresos" placeholder="NC" class="form-control" step="0.01" value = "0"/>
					</div>				
					<div class="col-md-4 mb-4">
					  <label for="total_ingresos">Total </label>
					  <input type="number" readonly id="total_ingresos" name="total_ingresos" placeholder="Total" class="form-control" step="0.01" value = "0"/>
					</div>						
				</div>	
				<div class="form-row">					
				</div>	
				<div class="form-row">
					<div class="col-md-12 mb-4">
					  <label for="observacion_ingresos">Observación </label>
					  <input type="text" id="observacion_ingresos" name="observacion_ingresos" placeholder="Observacion" class="form-control" step="0.01" maxlength="150" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
					</div>						
				</div>					
				<div class="RespuestaAjax"></div> 
			</form>
        </div>	
		<div class="modal-footer">
			<button class="guardar btn btn-primary ml-2" style="display: none;" type="submit" id="reg_ingresosContabilidad" form="formIngresosContables"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
			<button class="editar btn btn-warning ml-2" style="display: none;" type="submit" id="edi_ingresosContabilidad" form="formIngresosContables"><div class="sb-nav-link-icon"></div><i class="fas fa-edit fa-lg"></i> Editar</button>
			<button class="eliminar btn btn-danger ml-2" style="display: none;" type="submit" id="delete_ingresosContabilidad" form="formIngresosContables"><div class="sb-nav-link-icon"></div><i class="fa fa-trash fa-lg"></i> Eliminar</button>				
		</div>			
      </div>
    </div>
</div>
<!--FIN MODAL PARA EL FORMULARI DE INGRESOS CONTABLES-->