<nav class="sb-topnav navbar navbar-expand navbar-dark bg-color-navarlateral">
    <div class="sb-sidenav-footer link"> 
	    <a class="navbar-brand" href="<?php echo SERVERURL; ?>dashboard/"><center><img src="<?php echo SERVERURL; ?>vistas/plantilla/img/logo_main.png" width="100%" alt="We share" loading="lazy"></center></a>
    </div>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars fa-lg"></i></button>
    <!-- Navbar Search-->
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
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