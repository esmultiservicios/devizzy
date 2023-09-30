<nav class="sb-topnav navbar navbar-expand navbar-dark bg-color-navarlateral">
    <div class="navbar-brand">
        <span class="version" id="version"></span>
    </div>

    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars fa-lg"></i></button>

    <a class="nav-link link menu-item reporteVentas" href="<?php echo SERVERURL; ?>reporteVentas/" style="display:none">
        <div class="sb-nav-link-icon"></i></div>Reporte Ventas
    </a>
    <a class="nav-link link menu-item reporteCotizacion" href="<?php echo SERVERURL; ?>reporteCotizacion/"
        style="display:none">
        <div class="sb-nav-link-icon"></div>Reporte Cotización
    </a>
    <a class="nav-link link menu-item reporteCompras" href="<?php echo SERVERURL; ?>reporteCompras/"
        style="display:none"></i></div>Reporte Compras</a>

    <a class="nav-link link menu-item cobrarClientes" href="<?php echo SERVERURL; ?>cobrarClientes/"
        style="display:none">
        <div class="sb-nav-link-icon"></div>CXC Clientes
    </a>
    <a class="nav-link link menu-item pagarProveedores" href="<?php echo SERVERURL; ?>pagarProveedores/"
        style="display:none">
        <div class="sb-nav-link-icon"></div>CXP Proveedores
    </a>
    <a class="nav-link link menu-item inventario" href="<?php echo SERVERURL; ?>inventario/" style="display:none">
        <div class="sb-nav-link-icon"></div>Movimientos
    </a>
    <a class="nav-link link menu-item transferencia" href="<?php echo SERVERURL; ?>transferencia/" style="display:none">
        <div class="sb-nav-link-icon"></div>Inventario
    </a>
    <a class="nav-link link menu-item nomina" href="<?php echo SERVERURL; ?>nomina/" style="display:none">
        <div class="sb-nav-link-icon"></div>Nomina
    </a>
    <a class="nav-link link menu-item asistencia" href="#" id="marcarAsistencia">
        <div class="sb-nav-link-icon"></div>Asistencia
    </a>

    <div class="dropdown d-md-none">
        <button class="btn btn-secondary bg-color-navarlateral dropdown-toggle" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Menú Rápido
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

            <a class="dropdown-item menu-rapido reporteVentas" href="<?php echo SERVERURL; ?>reporteVentas/"
                style="display:none">
                <div class="sb-nav-link-icon"></i></div>Reporte Ventas
            </a>
            <a class="dropdown-item menu-rapido reporteCotizacion" href="<?php echo SERVERURL; ?>reporteCotizacion/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Reporte Cotización
            </a>
            <a class="dropdown-item menu-rapido reporteCompras" href="<?php echo SERVERURL; ?>reporteCompras/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Reporte Compras
            </a>
            <a class="dropdown-item menu-rapido cobrarClientes" href="<?php echo SERVERURL; ?>cobrarClientes/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>CXC Clientes
            </a>
            <a class="dropdown-item menu-rapido pagarProveedores" href="<?php echo SERVERURL; ?>pagarProveedores/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>CXP Proveedores
            </a>
            <a class="dropdown-item menu-rapido inventario" href="<?php echo SERVERURL; ?>inventario/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Movimientos
            </a>
            <a class="dropdown-item menu-rapido transferencia" href="<?php echo SERVERURL; ?>transferencia/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Inventario
            </a>
            <a class="dropdown-item menu-rapido nomina" href="<?php echo SERVERURL; ?>nomina/" style="display:none">
                <div class="sb-nav-link-icon"></div>Nomina
            </a>
            <a class="dropdown-item menu-rapido asistencia" href="#" id="marcarAsistencia">
                <div class="sb-nav-link-icon"></div>Aistencia
            </a>
        </div>
    </div>


    <!-- Navbar-->
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-lg"></i> <span
                    id="user_session"></span></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" id="cambiar_contraseña_usuarios_sistema">Modificar Contraseña</a>
                <a class="dropdown-item" href="#" id="modificar_perfil_usuario_sistema">Modificar Perfil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item btn-exit-system"
                    href="<?php echo $lc->encryption($_SESSION['token_sd']);?>">Salir</a>
            </div>
        </li>
    </ul>
</nav>