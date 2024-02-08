<nav class="sb-topnav navbar navbar-expand navbar-dark bg-color-navarlateral">
    <div class="navbar-brand">
        <a href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>dashboard/">
            <center><img src="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>vistas/plantilla/img/logos/logo.svg" width="100%" alt="CLINICARE"
                    loading="CLINICARE" class="logo"></center>
        </a>
    </div>

    <!-- Botón de alternar menú para pantallas pequeñas -->
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars fa-lg"></i>
    </button>

    <!-- Menú principal -->
    <ul class="navbar-nav">
        <!-- Elementos del menú principal -->
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item reporteVentas" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>reporteVentas/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Reporte Ventas
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item reporteCotizacion" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>reporteCotizacion/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Reporte Cotización
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item reporteCompras" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>reporteCompras/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Reporte Compras
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item cobrarClientes" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>cobrarClientes/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>CXC Clientes
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item pagarProveedores" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>pagarProveedores/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>CXP Proveedores
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item inventario" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>inventario/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Movimientos
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item transferencia" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>transferencia/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Inventario
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item nomina" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>nomina/" style="display:none">
                <div class="sb-nav-link-icon"></div>Nomina
            </a>
        </li>
        <li class="nav-item d-none d-md-block d-sm-block">
            <a class="nav-link link menu-item asistencia" href="#" id="marcarAsistencia">
                <div class="sb-nav-link-icon"></div>Asistencia
            </a>
        </li>
    </ul>

    <!-- Menú rápido -->
    <div class="dropdown d-md-none">
        <button class="btn btn-secondary bg-color-navarlateral dropdown-toggle" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Menú Rápido
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

            <a class="dropdown-item menu-rapido reporteVentas" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>reporteVentas/"
                style="display:none">
                <div class="sb-nav-link-icon"></i></div>Reporte Ventas
            </a>
            <a class="dropdown-item menu-rapido reporteCotizacion" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>reporteCotizacion/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Reporte Cotización
            </a>
            <a class="dropdown-item menu-rapido reporteCompras" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>reporteCompras/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Reporte Compras
            </a>
            <a class="dropdown-item menu-rapido cobrarClientes" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>cobrarClientes/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>CXC Clientes
            </a>
            <a class="dropdown-item menu-rapido pagarProveedores" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>pagarProveedores/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>CXP Proveedores
            </a>
            <a class="dropdown-item menu-rapido inventario" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>inventario/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Movimientos
            </a>
            <a class="dropdown-item menu-rapido transferencia" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>transferencia/"
                style="display:none">
                <div class="sb-nav-link-icon"></div>Inventario
            </a>
            <a class="dropdown-item menu-rapido nomina" href="<?php echo htmlspecialchars(SERVERURL, ENT_QUOTES, 'UTF-8'); ?>nomina/" style="display:none">
                <div class="sb-nav-link-icon"></div>Nomina
            </a>
            <a class="dropdown-item menu-rapido asistencia" href="#" id="marcarAsistencia">
                <div class="sb-nav-link-icon"></div>Aistencia
            </a>
        </div>
    </div>

    <!-- Navbar usuario -->
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0 navbar-nav-user">
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user fa-lg"></i> <span id="user_session"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" id="cambiar_contraseña_usuarios_sistema">Modificar Contraseña</a>
                <a class="dropdown-item" href="#" id="modificar_perfil_usuario_sistema">Mi Perfil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item btn-exit-system"
                    href="<?php echo $lc->encryption($_SESSION['token_sd']);?>">Salir</a>
            </div>
        </li>
    </ul>

</nav>