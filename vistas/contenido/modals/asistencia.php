<!--INICIO MODAL PUESTO-->
<div class="modal fade" id="modal_registrar_asistencia">
	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Asistencia</h4>    
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
        </div><div class="container"></div>
        <div class="modal-body">
			<form class="FormularioAjax FormularioAjax" id="formAsistencia" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<div class="input-group mb-3">
							<input type="hidden" id="asistencia_id" name="asistencia_id" class="form-control">						
							<input type="text" id="proceso_asistencia" class="form-control" readonly>
							<div class="input-group-append">				
								<span class="input-group-text"><div class="sb-nav-link-icon"></div><i class="fa fa-plus-square fa-lg"></i></span>
							</div>
						</div>	 
					</div>							
				</div>					
				<div class="form-row">
					<div class="col-md-4 mb-4">
						<label for="asistencia_empleado">Empleado <span class="priority">*<span/></label>
						<div class="input-group">
							<div class="input-group-append">
								<select id="asistencia_empleado" name="asistencia_empleado" class="selectpicker" title="Empleado" data-size="5" data-live-search="true" required>
								</select>
							</div>	
						</div>
					</div>					
					<div class="col-md-3 mb-3">
					  <label for="fecha">Fecha <span class="priority">*<span/></label>
					  <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date ("Y-m-d");?>" placeholder="Fecha" required>		  
					</div>	
					<div class="col-md-3 mb-3">
					  <label for="fecha">Hora <span class="priority">*<span/></label>
					  <input type="time" class="form-control" id="hora" name="hora">		  
					</div>							
				</div>	
				<div class="form-row">
					<br/>
					<br/>
					<br/>
				</div>							
				<div class="RespuestaAjax"></div>  
			</form>
        </div>
		<div class="modal-footer">
			<button class="guardar btn btn-primary ml-2" type="submit" style="display: none;" id="reg_asistencia" form="formAsistencia"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>	
		</div>			
      </div>
    </div>
</div>
<!--FIN MODAL PUESTO-->
