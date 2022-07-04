<nav class="sb-sidenav accordion bg-color-navarlateral" id="sidenavAccordion">
	<!--sb-sidenav-menu-heading-->
    <!--<div class="sb-sidenav-footer link"> 
        <center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo.png" width="100%" alt="We share" loading="lazy"></center>
    </div>-->
	<br/>
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link link" href="<?php echo SERVERURL; ?>dashboard/" id="dashboard" style="display:none">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#collapseVentas" aria-expanded="false" aria-controls="collapseVentas" id="ventas" style="display:none">
                <div class="sb-nav-link-icon"><i class="fab fa-sellsy"></i></div>
                Ventas
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseVentas" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>clientes/" id="clientes" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>Clientes</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>facturas/" id="facturas" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>Facturas</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>cotizacion/" id="cotizacion" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>Cotización</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>cajas/" id="cajas" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>Cajas</a>
                </nav>
            </div>
            <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#collapseCompras" aria-expanded="false" aria-controls="collapseCompras" id="compras" style="display:none">
                <div class="sb-nav-link-icon"><i class="fas fa-store-alt"></i></div>
                Compras
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseCompras" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>proveedores/" id="proveedores" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>Proveedores</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>facturaCompras/" id="facturaCompras" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>Compras</a>
                </nav>
            </div>  
            <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#collapseAlmacen" aria-expanded="false" aria-controls="collapseAlmacen" id="almacen" style="display:none">
                <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                Almacen
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseAlmacen" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>productos/" id="productos" style="display:none"><div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>Productos</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>inventario/" id="inventario" style="display:none"><div class="sb-nav-link-icon"><i class="fab fa-servicestack"></i></div>Movimientos</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>transferencia/" id="transferencia" style="display:none"><div class="sb-nav-link-icon"><i class="fab fa-servicestack"></i></div>Inventario</a>
                </nav>
            </div> 
			
            <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#collapseContabilidad" aria-expanded="false" aria-controls="collapseVentas" id="contabilidad" style="display:none">
                <div class="sb-nav-link-icon"><i class="fas fa-calculator"></i></div>
                Contabilidad
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseContabilidad" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>cuentasContabilidad/" id="cuentasContabilidad" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>Cuentas</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>movimientosContabilidad/" id="movimientosContabilidad" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>Movimientos</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>ingresosContabilidad/" id="ingresosContabilidad" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>Ingresos</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>gastosContabilidad/" id="gastosContabilidad" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>Gastos</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>chequesContabilidad/" id="chequesContabilidad"style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-money-check"></i></div>Cheques</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confCtaContabilidad/" id="confCtaContabilidad"style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>Conf Cuentas</a> 
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confTipoPago/" id="confTipoPago"style="display:none"><div class="sb-nav-link-icon"><i class="fab fa-bitcoin"></i></div>Tipo de Pago</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confBancos/" id="confBancos"style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-university"></i></div>Bancos</a>  
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confImpuestos/" id="confImpuestos"style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-percentage"></i></div>Impuestos</a>                                                                                
                </nav>
            </div>			
			
            <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes" id="reportes" style="display:none">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                Reportes
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>           
            <div class="collapse" id="collapseReportes" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    </a>									
                    <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#historialCollapse" aria-expanded="false" aria-controls="historialCollapse" id="reporte_historial" style="display:none">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Historial
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="historialCollapse" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
							<a class="nav-link link" href="<?php echo SERVERURL; ?>historialAccesos/" id="historialAccesos" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>Accesos</a>
							<a class="nav-link link" href="<?php echo SERVERURL; ?>bitacora/" id="bitacora" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>Bitacora</a>							
                        </nav>
                    </div>
                    <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#facturasCollapse" aria-expanded="false" aria-controls="facturasCollapse" id="reporte_ventas" style="display:none">
                        <div class="sb-nav-link-icon"><i class="fab fa-sellsy"></i></div>
                        Ventas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="facturasCollapse" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
							<a class="nav-link link" href="<?php echo SERVERURL; ?>reporteVentas/" id="reporteVentas" style="display:none"><div class="sb-nav-link-icon"><i class="fab fa-sellsy"></i></div>Ventas</a>
							<a class="nav-link link" href="<?php echo SERVERURL; ?>reporteCotizacion/" id="reporteCotizacion" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>Cotización</a>                            
							<a class="nav-link link" href="<?php echo SERVERURL; ?>cobrarClientes/" id="cobrarClientes" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>CXC Clientes</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#comprasCollapse" aria-expanded="false" aria-controls="comprasCollapse" id="reporte_compras" style="display:none">
                        <div class="sb-nav-link-icon"><i class="fas fa-store-alt"></i></i></div>
                        Compras
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="comprasCollapse" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
							<a class="nav-link link" href="<?php echo SERVERURL; ?>reporteCompras/" id="reporteCompras" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>Compras</a>
							<a class="nav-link link" href="<?php echo SERVERURL; ?>pagarProveedores/" id="pagarProveedores" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>CXP Proveedores</a>						
                        </nav>
                    </div>
                </nav>
            </div>

            <a class="nav-link collapsed link" href="#" data-toggle="collapse" data-target="#configuracion" aria-expanded="false" aria-controls="configuracion" id="configuracion" style="display:none">
                <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></i></div>
                Configuración
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="configuracion" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>colaboradores/" id="colaboradores" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>Colaboradores</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>puestos/" id="puestos" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>Puestos</a>					
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>users/" id="users" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>Usuarios</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>secuencia/" id="secuencia" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-sliders-h"></i></div>Secuencia</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>empresa/" id="empresa" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>Empresa</a>	
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confAlmacen/" id="confAlmacen" style="display:none"><div class="sb-nav-link-icon"><i class="fab fas fa-warehouse"></i></div>Almacén</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confImpresora/" id="confImpresora" style="display:none"><div class="sb-nav-link-icon"><i class="fab fas fa-print"></i></div>Impresora</a>	
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confUbicacion/" id="confUbicacion" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-search-location"></i></div>Ubicación</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confCategoria/" id="confCategoria" style="display:none"><div class="sb-nav-link-icon"><i class="fas fas fa-layer-group"></i></div>Categoría</a>					
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confMedida/" id="confMedida" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-balance-scale-left"></i></div>Medidas</a>
                    <a class="nav-link link" href="<?php echo SERVERURL; ?>confPlanes/" id="confPlanes" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>Planes</a>                    
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confHost/" id="confHost" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-network-wired"></i></div>Hosts</a> 
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confHostProductos/" id="confHostProductos" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-network-wired"></i></div>Productos Hosts</a>                     
					<a class="nav-link link" href="<?php echo SERVERURL; ?>confEmail/" id="confEmail" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>Correo</a>                    
					<a class="nav-link link" href="<?php echo SERVERURL; ?>privilegio/" id="privilegio" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>Privilegios</a>
					<a class="nav-link link" href="<?php echo SERVERURL; ?>tipoUser/" id="tipoUser" style="display:none"><div class="sb-nav-link-icon"><i class="fas fa-user-lock"></i></div>Tipo Usuario</a>				
                </nav>
            </div>		
			
        </div>
    </div>
    <!--<div class="sb-sidenav-footer link">
        <center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo_firma_white.png" width="98%" alt="We share" loading="lazy"></center>
    </div>-->
</nav>