<nav class="sb-topnav navbar navbar-expand navbar-dark bg-color-navarlateral">
	<a class="navbar-brand" href="<?php echo SERVERURL; ?>dashboard/"><center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo1.png" width="90%" alt="We share" loading="lazy"></center></a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars fa-lg"></i></button>
    <!-- Navbar Search-->

        <a class="nav-link link d-none d-sm-none d-md-block reporteVentas" href="<?php echo SERVERURL; ?>reporteVentas/" style="display:none"><div class="sb-nav-link-icon"></i></div>Reporte Ventas</a>
        <a class="nav-link link d-none d-sm-none d-md-block reporteCotizacion" href="<?php echo SERVERURL; ?>reporteCotizacion/" id="" style="display:none"><div class="sb-nav-link-icon"></div>Reporte Cotización</a>
        <a class="nav-link link d-none d-sm-none d-md-block reporteCompras" href="<?php echo SERVERURL; ?>reporteCompras/" style="display:none"></i></div>Reporte Compras</a>
        <a class="nav-link link d-none d-sm-none d-md-block cobrarClientes" href="<?php echo SERVERURL; ?>cobrarClientes/" style="display:none"><div class="sb-nav-link-icon"></div>CXC Clientes</a>
        <a class="nav-link link d-none d-sm-none d-md-block pagarProveedores" href="<?php echo SERVERURL; ?>pagarProveedores/" style="display:none"><div class="sb-nav-link-icon"></div>CXP Proveedores</a>						
        <a class="nav-link link d-none d-sm-none d-md-block inventario" href="<?php echo SERVERURL; ?>inventario/" style="display:none"><div class="sb-nav-link-icon"></div>Movimientos</a>
        <a class="nav-link link d-none d-sm-none d-md-block transferencia" href="<?php echo SERVERURL; ?>transferencia/" style="display:none"><div class="sb-nav-link-icon"></div>Inventario</a>
        <a class="nav-link link d-none d-sm-none d-md-block nomina" href="<?php echo SERVERURL; ?>nomina/" style="display:none"><div class="sb-nav-link-icon"></div>Nomina</a>
        <a class="nav-link link d-none d-sm-none d-md-block asistencia" href="<?php echo SERVERURL; ?>asistencia/" style="display:none"><div class="sb-nav-link-icon"></div>Asistencia</a>
  
        <div class="dropdown d-block d-sm-block d-md-none">
            <button class="btn btn-secondary bg-color-navarlateral dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menú Rápido
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                
                 <a class="dropdown-item reporteVentas" href="<?php echo SERVERURL; ?>reporteVentas/"><div class="sb-nav-link-icon"></i></div>Reporte Ventas</a>
                 <a class="dropdown-item reporteCotizacion" href="<?php echo SERVERURL; ?>reporteCotizacion/"><div class="sb-nav-link-icon"></div>Reporte Cotización</a>
                 <a class="dropdown-item reporteCompras" href="<?php echo SERVERURL; ?>reporteCompras/"><div class="sb-nav-link-icon"></div>Reporte Compras</a>
                <a class="dropdown-item cobrarClientes" href="<?php echo SERVERURL; ?>cobrarClientes/"><div class="sb-nav-link-icon"></div>CXC Clientes</a>
                <a class="dropdown-item pagarProveedores" href="<?php echo SERVERURL; ?>pagarProveedores/"><div class="sb-nav-link-icon"></div>CXP Proveedores</a>						
                <a class="dropdown-item inventario" href="<?php echo SERVERURL; ?>inventario/"><div class="sb-nav-link-icon"></div>Movimientos</a>
                <a class="dropdown-item transferencia" href="<?php echo SERVERURL; ?>transferencia/"><div class="sb-nav-link-icon"></div>Inventario</a>
                <a class="dropdown-item nomina" href="<?php echo SERVERURL; ?>nomina/"><div class="sb-nav-link-icon"></div>Nomina</a>
                <a class="dropdown-item asistencia" href="<?php echo SERVERURL; ?>asistencia/"><div class="sb-nav-link-icon"></div>Aistencia</a>
            </div>
        </div>  
        

    <!-- Navbar-->      
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">  
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-lg"></i> <span id="user_session"></span></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" id="cambiar_contraseña_usuarios_sistema">Modificar Contraseña</a>
                <a class="dropdown-item" href="#" id="modificar_perfil_usuario_sistema">Modificar Perfil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item btn-exit-system" href="<?php echo $lc->encryption($_SESSION['token_sd']);?>">Salir</a>
            </div>
        </li>
    </ul>
</nav>