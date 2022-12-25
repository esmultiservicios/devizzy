<!--INICIO MODAL PRIVILEGIOS-->
<div class="modal fade" id="modal_registrar_privilegios">
	<div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Privilegios</h4>    
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
        </div><div class="container"></div>
        <div class="modal-body">
			<form class="FormularioAjax" id="formPrivilegios" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<div class="input-group mb-3">
							<input type="hidden" id="privilegio_id_" name="privilegio_id_" class="form-control">
							<input type="text" id="proceso_privilegios" class="form-control" readonly>
							<div class="input-group-append">				
								<span class="input-group-text"><div class="sb-nav-link-icon"></div><i class="fa fa-plus-square fa-lg"></i></span>
							</div>
						</div>	 
					</div>							
				</div>					
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<label for="prefijo">Nombre <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<input type="text" name="privilegios_nombre" id="privilegios_nombre" class="form-control" placeholder="Nombre" maxlength="20" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
							<div class="input-group-append">				
								<span class="input-group-text"><div class="sb-nav-link-icon"></div><i class="fas fa-id-card-alt"></i></span>
							</div>
						</div>	 
					</div>						
				</div>	
				<div class="form-group" id="estado_privilegios">				  
				  <div class="col-md-12">			
						<label class="switch">
							<input type="checkbox" id="privilegio_activo" name="privilegio_activo" value="1" checked>
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_privilegio_activo"></span>				
				  </div>				  
				</div>					
				<div class="RespuestaAjax"></div>	  
			</form>
        </div>
		<div class="modal-footer">
			<button class="guardar btn btn-primary ml-2" type="submit" style="display: none;" id="reg_privilegios" form="formPrivilegios"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
			<button class="editar btn btn-warning ml-2" type="submit" style="display: none;" id="edi_privilegios" form="formPrivilegios"><div class="sb-nav-link-icon"></div><i class="fas fa-edit fa-lg"></i> Editar</button>
			<button class="eliminar btn btn-danger ml-2" type="submit" style="display: none;" id="delete_privilegios" form="formPrivilegios"><div class="sb-nav-link-icon"></div><i class="fa fa-trash fa-lg"></i> Eliminar</button>
		</div>		
      </div>
    </div>
</div>
<!--FIN MODAL PRIVILEGIOS-->
<!--INICIO MODAL PARA EL EL REGISTRO DE MENUS SEGUN EL PRIVILEGIO-->
<div class="modal fade" id="modal_menus_accesos">
	<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Accesos</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
        </div><div class="container"></div>
        <div class="modal-body">		
			<form class="form-horizontal FormularioAjax" id="formMenuAccesos" action="" method="POST" data-form="" enctype="multipart/form-data">				
				<div class="form-row">
					<div class="col-md-12 mb-3">
					    <input type="hidden" required="required" readonly id="privilegio_id_accesos" name="privilegio_id_accesos"/>
						<input type="hidden" required="required" readonly id="privilegio_nombre_accesos" name="privilegio_nombre_accesos"/>
						<div class="input-group mb-3">
							<input type="text" required readonly id="pro_accesos" name="pro_accesos" class="form-control"/>
							<div class="input-group-append">				
								<span class="input-group-text"><div class="sb-nav-link-icon"></div><i class="fa fa-plus-square fa-lg"></i></span>
							</div>
						</div>	 
					</div>							
				</div>
				
				<div class="form-group">				  
				  <div class="col-md-12">	
						<label for="menu_dashboard"><b>Dashboard</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_dashboard" name="menu_dashboard" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_dashboard"></span>				
				  </div>					  
				</div>
				
				<div class="form-group">				  
				  <div class="col-md-12">	
						<label for="menu_ventas"><b>Ventas</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_ventas" name="menu_ventas" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_ventas"></span>				
				  </div>					  
				</div>	
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="subMenuVentas">				  
				  <div class="col-md-4">	
						<label for="menu_clientes">Clientes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_clientes" name="menu_clientes" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_clientes"></span>				
				  </div>	
				  <div class="col-md-3">	
						<label for="menu_facturas">Facturas</label>
						<label class="switch">
							<input type="checkbox" id="menu_facturas" name="menu_facturas" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_facturas"></span>				
				  </div>
				  <div class="col-md-4">	
						<label for="menu_cotizacion">Cotización</label>
						<label class="switch">
							<input type="checkbox" id="menu_cotizacion" name="menu_cotizacion" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_cotizacion"></span>				
				  </div>				  
				  <div class="col-md-3">	
						<label for="menu_cajas">Cajas</label>
						<label class="switch">
							<input type="checkbox" id="menu_cajas" name="menu_cajas" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_cajas"></span>				
				  </div>				  
				</div>					

				<div class="form-group">				  
				  <div class="col-md-12">	
						<label for="menu_compras"><b>Compras</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_compras" name="menu_compras" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_compras"></span>				
				  </div>					  
				</div>	
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="subMenuCompras">				  
				  <div class="col-md-7">	
						<label for="menu_proveedores">Proveedores&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_proveedores" name="menu_proveedores" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_proveedores"></span>				
				  </div>	
				  <div class="col-md-8">	
						<label for="menu_facturaCompras">Compras&nbsp;&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Factura de Compra">
							<input type="checkbox" id="menu_facturaCompras" name="menu_facturaCompras" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_facturaCompras"></span>				
				  </div>					  
				</div>					

				<div class="form-group">				  
				  <div class="col-md-12">	
						<label for="menu_almacen"><b>Almacén</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_almacen" name="menu_almacen" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_almacen"></span>				
				  </div>					  
				</div>	
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="subMenuAlmacen">				  
				  <div class="col-md-4">	
						<label for="menu_productos">Productos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_productos" name="menu_productos" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_productos"></span>				
				  </div>	
				  <div class="col-md-4">	
						<label for="menu_inventario">Movimientos</label>
						<label class="switch">
							<input type="checkbox" id="menu_inventario" name="menu_inventario" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_inventario"></span>				
				  </div>
				  <div class="col-md-4">	
						<label for="menu_transferencia">Inventario</label>
						<label class="switch">
							<input type="checkbox" id="menu_transferencia" name="menu_transferencia" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_transferencia"></span>				
				  </div>					  
				</div>					

				<div class="form-group">				  
				  <div class="col-md-12">	
						<label for="menu_contabilidad"><b>Contabilidad</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_contabilidad" name="menu_contabilidad" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_contabilidad"></span>				
				  </div>					  
				</div>	

				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuContabilidad">				  
				  <div class="col-md-4">	
						<label for="menu_cuentasContabilidad">Cuentas&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_cuentasContabilidad" name="menu_cuentasContabilidad" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_cuentasContabilidad"></span>				
				  </div>	
				  <div class="col-md-4">	
						<label for="menu_movimientosContabilidad">Movimientos</label>
						<label class="switch">
							<input type="checkbox" id="menu_movimientosContabilidad" name="menu_movimientosContabilidad" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_movimientosContabilidad"></span>				
				  </div>	
				  <div class="col-md-3">	
						<label for="menu_ingresosContabilidad">Ingresos</label>
						<label class="switch">
							<input type="checkbox" id="menu_ingresosContabilidad" name="menu_ingresosContabilidad" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_ingresosContabilidad"></span>				
				  </div>	
				  <div class="col-md-4">	
						<label for="menu_gastosContabilidad">Gastos&nbsp;</label>
						<label class="switch" data-toggle="tooltip">
							<input type="checkbox" id="menu_gastosContabilidad" name="menu_gastosContabilidad" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_gastosContabilidad"></span>				
				  </div>						  
				</div>	
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuContabilidad1">				  	
				  <div class="col-md-5">	
						<label for="menu_chequesContabilidad">Cheques&nbsp;&nbsp;&nbsp;</label>
						<label class="switch" data-toggle="tooltip">
							<input type="checkbox" id="menu_chequesContabilidad" name="menu_chequesContabilidad" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_chequesContabilidad"></span>				
				  </div>
				  <div class="col-md-5">	
						<label for="menu_confCtaContabilidad">Configurar Cuentas</label>
						<label class="switch" data-toggle="tooltip">
							<input type="checkbox" id="menu_confCtaContabilidad" name="menu_confCtaContabilidad" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confCtaContabilidad"></span>				
				  </div>	
				  <div class="col-md-5">	
						<label for="menu_confTipoPago">Tipo Pagos</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Configurar Formas de pago">
							<input type="checkbox" id="menu_confTipoPago" name="menu_confTipoPago" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confTipoPago"></span>				
				  </div>					  			  					  
				</div>
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuContabilidad1">				  	
				  <div class="col-md-7">	
						<label for="menu_confBancos">Bancos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Agregar Bancos">
							<input type="checkbox" id="menu_confBancos" name="menu_confBancos" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confBancos"></span>				
				  </div>
				  <div class="col-md-10">	
						<label for="menu_confImpuestos">Impuestos</label>
						<label class="switch" data-toggle="tooltip">
							<input type="checkbox" id="menu_confImpuestos" name="menu_confImpuestos" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confImpuestos"></span>				
				  </div>						  			  					  
				</div>				

				<div class="form-group">				  
				  <div class="col-md-12">	
						<label for="menu_reportes"><b>Reportes</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_reportes" name="menu_reportes" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_reportes"></span>				
				  </div>					  
				</div>	

				<div class="form-group" id="submenuReportesHistorial">				  
				  <div class="col-md-12">	
						<label for="menu_reporte_historial"><b>&nbsp;&nbsp;&nbsp;&nbsp;Historial</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_reporte_historial" name="menu_reporte_historial" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="menu_reporte_historial"></span>				
				  </div>					  
				</div>
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuReportesHistorial1">				  
				  <div class="col-md-8">	
						<label for="menu_historialAccesos">Accesos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_historialAccesos" name="menu_historialAccesos" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_historialAccesos"></span>				
				  </div>	
				  <div class="col-md-8">	
						<label for="menu_bitacora">Bitacora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_bitacora" name="menu_bitacora" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_bitacora"></span>				
				  </div>					  
				</div>	
				
				<div class="form-group" id="submenuReportesVentas">				  
				  <div class="col-md-12">	
						<label for="menu_reporte_ventas"><b>&nbsp;&nbsp;&nbsp;&nbsp;Ventas</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_reporte_ventas" name="menu_reporte_ventas" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_reporte_ventas"></span>				
				  </div>					  
				</div>	
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuReportesVentas1">				  
				  <div class="col-md-4">	
						<label for="menu_reporteVentas">Reporte Ventas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_reporteVentas" name="menu_reporteVentas" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_reporteVentas"></span>				
				  </div>
				  <div class="col-md-5">	
						<label for="menu_reporteCotizacion">Reporte Cotización&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_reporteCotizacion" name="menu_reporteCotizacion" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_reporteCotizacion"></span>				
				  </div>				  	
				  <div class="col-md-4">	
						<label for="menu_cobrarClientes">CxC Clientes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_cobrarClientes" name="menu_cobrarClientes" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_cobrarClientes"></span>				
				  </div>					  
				</div>					

				<div class="form-group" id="submenuReportesCompras">				  
				  <div class="col-md-12">	
						<label for="menu_reporte_compras"><b>&nbsp;&nbsp;&nbsp;&nbsp;Compras</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_reporte_compras" name="menu_reporte_compras" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_reporte_compras"></span>				
				  </div>					  
				</div>	
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuReportesCompras1">				  
				  <div class="col-md-7">	
						<label for="menu_reporteCompras">Reporte Compras&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_reporteCompras" name="menu_reporteCompras" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_reporteCompras"></span>				
				  </div>	
				  <div class="col-md-8">	
						<label for="menu_pagarProveedores">CxP Proveedores&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_pagarProveedores" name="menu_pagarProveedores" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_pagarProveedores"></span>				
				  </div>					  
				</div>	
				
				<div class="form-group">				  
				  <div class="col-md-12">	
						<label for="menu_configuracion"><b>Configuración</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_configuracion" name="menu_configuracion" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_configuracion"></span>				
				  </div>					  
				</div>	

				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuConfiguracion">				  
				  <div class="col-md-4">	
						<label for="menu_colaboradores">Colaboradores&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_colaboradores" name="menu_colaboradores" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_colaboradores"></span>				
				  </div>	
				  <div class="col-md-3">	
						<label for="menu_puestos">Puestos&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_puestos" name="menu_puestos" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_puestos"></span>				
				  </div>	
				  <div class="col-md-3">	
						<label for="menu_users">&nbsp;&nbsp;&nbsp;Usuarios&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_users" name="menu_users" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_users"></span>				
				  </div>	
				  <div class="col-md-3">	
						<label for="menu_secuencia">Secuencia&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Secuencia de Facturación SAR">
							<input type="checkbox" id="menu_secuencia" name="menu_secuencia" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_secuencia"></span>				
				  </div>					  
				</div>	

				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuConfiguracion">				  
				  <div class="col-md-4">	
						<label for="menu_empresa">Empresa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_empresa" name="menu_empresa" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_empresa"></span>				
				  </div>	
				  <div class="col-md-3">	
						<label for="menu_confAlmacen">Almacen</label>
						<label class="switch">
							<input type="checkbox" id="menu_confAlmacen" name="menu_confAlmacen" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confAlmacen"></span>				
				  </div>	
				  <div class="col-md-3">	
						<label for="menu_confUbicacion">&nbsp;&nbsp;&nbsp;Ubicación</label>
						<label class="switch">
							<input type="checkbox" id="menu_confUbicacion" name="menu_confUbicacion" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confUbicacion"></span>				
				  </div>	
				  <div class="col-md-4">	
						<label for="menu_confMedida">&nbsp;Medida&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_confMedida" name="menu_confMedida" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confMedida"></span>				
				  </div>					  
				</div>	

				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuConfiguracion">				  	
				  <div class="col-md-5">	
						<label for="menu_privilegio">Privilegio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch">
							<input type="checkbox" id="menu_privilegio" name="menu_privilegio" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_privilegio"></span>				
				  </div>	
				  <div class="col-md-4">	
						<label for="menu_tipoUser">&nbsp;&nbsp;Permisos&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Tipo de Usuario">
							<input type="checkbox" id="menu_tipoUser" name="menu_tipoUser" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_tipoUser"></span>				
				  </div>
				  <div class="col-md-5">	
						<label for="menu_confCategoria">&nbsp;&nbsp;Categoría&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Categoría de Productos">
							<input type="checkbox" id="menu_confCategoria" name="menu_confCategoria" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confCategoria"></span>				
				  </div>			  				  
				</div>	

				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuConfiguracion">				  	
				  <div class="col-md-12">	
						<label for="menu_confEmail">&nbsp;Correo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Tipo de Usuario">
							<input type="checkbox" id="menu_confEmail" name="menu_confEmail" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confEmail"></span>				
				  </div>			  				  
				</div>	
				
				<div class="form-group custom-control custom-checkbox custom-control-inline" id="submenuConfiguracion">				  	
				  <div class="col-md-5">	
						<label for="menu_confHost">&nbsp;Hosts&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Configurar los Host de los clientes">
							<input type="checkbox" id="menu_confHost" name="menu_confHost" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confHost"></span>				
				  </div>
				  <div class="col-md-6">	
						<label for="menu_confHostProductos">Hosts Productos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Agregar Productos a los Host">
							<input type="checkbox" id="menu_confHostProductos" name="menu_confHostProductos" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confHostProductos"></span>				
				  </div>				  
				  <div class="col-md-4">	
						<label for="menu_confPlanes">&nbsp;Planes&nbsp;&nbsp;</label>
						<label class="switch" data-toggle="tooltip" data-placement="top" title="Configurar los planes">
							<input type="checkbox" id="menu_confPlanes" name="menu_confPlanes" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_menu_confPlanes"></span>				
				  </div>				  			  				  
				</div>					
			  				
				<div class="RespuestaAjax"></div> 
			</form>
        </div>	
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" type="submit" id="reg_accessos" form="formMenuAccesos"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>			
		</div>			
      </div>
    </div>
</div>
<!--FIN MODAL PARA EL EL REGISTRO DE MENUS SEGUN EL PRIVILEGIO-->