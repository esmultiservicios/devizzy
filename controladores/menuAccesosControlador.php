<?php
    if($peticionAjax){
        require_once "../modelos/menuAccesosModelo.php";
    }else{
        require_once "./modelos/menuAccesosModelo.php";
    }
	
	class menuAccesosControlador extends menuAccesosModelo{
		public function agregar_menuAccesos_controlador(){
			$privilegio_id = $_POST['privilegio_id_accesos'];
			$privilegio_nombre_accesos = $_POST['privilegio_nombre_accesos'];
			$fecha_registro = date("Y-m-d H:i:s");	
			
			//######################INICIO REGISTRO DE MENUS######################
			//INICIO MENU DASBOARD
			if (isset($_POST['menu_dashboard'])){
				$menu_dashboard = $_POST['menu_dashboard'];
			}else{
				$menu_dashboard = 2;
			}
			
			$consultaMenudashboard = menuAccesosModelo::consultarMenu("dashboard")->fetch_assoc();
			$menu_id = $consultaMenudashboard['menu_id'];		
			
			$datos_dashboard = [
				"menu_id" => $menu_id,
				"estado" => $menu_dashboard,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menudashboard = menuAccesosModelo::valid_menuAccesos_modelo($datos_dashboard);
			
			if($result_Menudashboard->num_rows>0){
				menuAccesosModelo::edit_menuAccesos_modelo($datos_dashboard);
			}else{
				menuAccesosModelo::agregar_menuAccesos_modelo($datos_dashboard);
			}			
			//INICIO MENU DASBOARD
			
			//INICIO MENU VENTAS
			if (isset($_POST['menu_ventas'])){
				$menu_ventas = $_POST['menu_ventas'];
			}else{
				$menu_ventas = 2;
			}	
			
			$consultaMenuventas = menuAccesosModelo::consultarMenu("ventas")->fetch_assoc();
			$menu_id = $consultaMenuventas['menu_id'];		
			
			$datos_ventas = [
				"menu_id" => $menu_id,
				"estado" => $menu_ventas,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];	

			$result_Menuventas = menuAccesosModelo::valid_menuAccesos_modelo($datos_ventas);
			
			if($result_Menuventas->num_rows>0){
				menuAccesosModelo::edit_menuAccesos_modelo($datos_ventas);
			}else{
				menuAccesosModelo::agregar_menuAccesos_modelo($datos_ventas);
			}
			
			//FIN MENU VENTAS
			
			//INICIO MENU COMPRAS
			if (isset($_POST['menu_compras'])){
				$menu_compras = $_POST['menu_compras'];
			}else{
				$menu_compras = 2;
			}	
			
			$consultaMenucompras = menuAccesosModelo::consultarMenu("compras")->fetch_assoc();
			$menu_id = $consultaMenucompras['menu_id'];		
			
			$datos_compras = [
				"menu_id" => $menu_id,
				"estado" => $menu_compras,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];				

			$result_Menucompras = menuAccesosModelo::valid_menuAccesos_modelo($datos_compras);
			
			if($result_Menucompras->num_rows>0){
				menuAccesosModelo::edit_menuAccesos_modelo($datos_compras);
			}else{
				menuAccesosModelo::agregar_menuAccesos_modelo($datos_compras);
			}	
			//FIN MENU COMPRAS
			
			//INICIO MENU ALMACEN
			if (isset($_POST['menu_almacen'])){
				$menu_almacen = $_POST['menu_almacen'];
			}else{
				$menu_almacen = 2;
			}	
			
			$consultaMenualmacen = menuAccesosModelo::consultarMenu("almacen")->fetch_assoc();
			$menu_id = $consultaMenualmacen['menu_id'];		
			
			$datos_almacen = [
				"menu_id" => $menu_id,
				"estado" => $menu_compras,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];				

			$result_Menualmacen = menuAccesosModelo::valid_menuAccesos_modelo($datos_almacen);
			
			if($result_Menualmacen->num_rows>0){
				menuAccesosModelo::edit_menuAccesos_modelo($datos_almacen);
			}else{
				menuAccesosModelo::agregar_menuAccesos_modelo($datos_almacen);
			}
			//INICIO MENU ALMACEN
			
			//INICIO MENU CONTABILIDAD
			if (isset($_POST['menu_contabilidad'])){
				$menu_contabilidad = $_POST['menu_contabilidad'];
			}else{
				$menu_contabilidad = 2;
			}	
			
			$consultaMenucontabilidad = menuAccesosModelo::consultarMenu("contabilidad")->fetch_assoc();
			$menu_id = $consultaMenucontabilidad['menu_id'];		
			
			$datos_contabilidad = [
				"menu_id" => $menu_id,
				"estado" => $menu_contabilidad,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];				

			$result_Menucontabilidad = menuAccesosModelo::valid_menuAccesos_modelo($datos_contabilidad);
			
			if($result_Menucontabilidad->num_rows>0){
				menuAccesosModelo::edit_menuAccesos_modelo($datos_contabilidad);
			}else{
				menuAccesosModelo::agregar_menuAccesos_modelo($datos_contabilidad);
			}
			//FIN MENU CONTABILIDAD
			
			//INICIO MENU REPORTES
			if (isset($_POST['menu_reportes'])){
				$menu_reportes = $_POST['menu_reportes'];
			}else{
				$menu_reportes = 2;
			}

			$consultaMenureportes = menuAccesosModelo::consultarMenu("reportes")->fetch_assoc();
			$menu_id = $consultaMenureportes['menu_id'];		
			
			$datos_reportes = [
				"menu_id" => $menu_id,
				"estado" => $menu_reportes,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];				

			$result_Menureportes = menuAccesosModelo::valid_menuAccesos_modelo($datos_reportes);
			
			if($result_Menureportes->num_rows>0){
				menuAccesosModelo::edit_menuAccesos_modelo($datos_reportes);
			}else{
				menuAccesosModelo::agregar_menuAccesos_modelo($datos_reportes);
			}
			//FIN MENU REPORTES
			
			//INICIO MENU CONFIGURACION
			if (isset($_POST['menu_configuracion'])){
				$menu_configuracion = $_POST['menu_configuracion'];
			}else{
				$menu_configuracion = 2;
			}							
			
			$consultaMenuconfiguracion = menuAccesosModelo::consultarMenu("configuracion")->fetch_assoc();
			$menu_id = $consultaMenuconfiguracion['menu_id'];
			
			$datos_configuracion = [
				"menu_id" => $menu_id,
				"estado" => $menu_configuracion,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_configuracion = menuAccesosModelo::valid_menuAccesos_modelo($datos_configuracion);
			
			if($result_configuracion->num_rows>0){
				menuAccesosModelo::edit_menuAccesos_modelo($datos_configuracion);
			}else{
				menuAccesosModelo::agregar_menuAccesos_modelo($datos_configuracion);
			}
			//FIN MENU CONFIGURACION
			//FIN REGISTRO DE MENUS
								
			//######################INICIO REGISTRO DE SUBMENUS######################
			//INICIO SUBMENU PARA EL MENU VENTAS
			//SUBMENU CLIENTES
			if (isset($_POST['menu_clientes'])){
				$menu_clientes = $_POST['menu_clientes'];
			}else{
				$menu_clientes = 2;
			}

			$consultaMenuclientes = menuAccesosModelo::consultarSubMenu("clientes")->fetch_assoc();
			$submenu_id = $consultaMenuclientes['submenu_id'];		
			
			$datos_clientes = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_clientes,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menuclientes  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_clientes);
			
			if($result_Menuclientes->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_clientes);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_clientes);
			}
			
			//SUBMENU FACTURAS
			if (isset($_POST['menu_facturas'])){
				$menu_facturas = $_POST['menu_facturas'];
			}else{
				$menu_facturas = 2;
			}
			
			$consultafacturas = menuAccesosModelo::consultarSubMenu("facturas")->fetch_assoc();
			$submenu_id = $consultafacturas['submenu_id'];		
			
			$datos_facturas = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_facturas,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menufacturas = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_facturas);
			
			if($result_Menufacturas->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_facturas);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_facturas);
			}	
			//FIN SUBMENU PARA EL MENU VENTAS
			
			//INICIO SUBMENU COTIZACION
			if (isset($_POST['menu_cotizacion'])){
				$menu_cotizacion = $_POST['menu_cotizacion'];
			}else{
				$menu_cotizacion = 2;
			}
			
			$consultaCotizacion = menuAccesosModelo::consultarSubMenu("cotizacion")->fetch_assoc();
			$submenu_id = $consultaCotizacion['submenu_id'];		
			
			$datos_cotizacion = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_cotizacion,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuCotizacion = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_cotizacion);
			
			if($result_MenuCotizacion->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_cotizacion);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_cotizacion);
			}	
			//FIN SUBMENU PARA EL MENU COTIZACION

			//INICIO SUBMENU CAJAS
			if (isset($_POST['menu_cajas'])){
				$menu_cajas = $_POST['menu_cajas'];
			}else{
				$menu_cajas = 2;
			}
			
			$consultaCajas = menuAccesosModelo::consultarSubMenu("cajas")->fetch_assoc();
			$submenu_id = $consultaCajas['submenu_id'];		
			
			$datos_cajas = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_cajas,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menufacturas = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_cajas);
			
			if($result_Menufacturas->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_cajas);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_cajas);
			}	
			//FIN SUBMENU PARA EL MENU CAJAS			
			
			//INICIO SUBMENU PARA EL MENU COMPRAS
			//SUBMENU PROVEDORES
			if (isset($_POST['menu_proveedores'])){
				$menu_proveedores = $_POST['menu_proveedores'];
			}else{
				$menu_proveedores = 2;
			}
			
			$consultaMenuproveedores = menuAccesosModelo::consultarSubMenu("proveedores")->fetch_assoc();
			$submenu_id = $consultaMenuproveedores['submenu_id'];		
			
			$datos_proveedores = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_proveedores,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menuclientes  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_proveedores);
			
			if($result_Menuclientes->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_proveedores);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_proveedores);
			}
			
			//SUBMENU FACTURAS DE COMPRAS
			if (isset($_POST['menu_facturaCompras'])){
				$menu_factura_compras = $_POST['menu_facturaCompras'];
			}else{
				$menu_factura_compras = 2;
			}
			
			$consultafactura_compras = menuAccesosModelo::consultarSubMenu("facturaCompras")->fetch_assoc();
			$submenu_id = $consultafactura_compras['submenu_id'];		
			
			$datos_factura_compras = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_factura_compras,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menufacturas = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_factura_compras);
			
			if($result_Menufacturas->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_factura_compras);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_factura_compras);
			}	
			//FIN SUBMENU PARA EL MENU COMPRAS		

			//INICIO SUBMENU PARA EL MENU ALMACEN
			//SUBMENU PRODUCTOS
			if (isset($_POST['menu_productos'])){
				$menu_productos = $_POST['menu_productos'];
			}else{
				$menu_productos = 2;
			}
			
			$consultaMenuproductos = menuAccesosModelo::consultarSubMenu("productos")->fetch_assoc();
			$submenu_id = $consultaMenuproductos['submenu_id'];		
			
			$datos_productos = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_productos,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menuclientes  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_productos);
			
			if($result_Menuclientes->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_productos);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_productos);
			}
			
			//SUBMENU INVENTARIOS
			if (isset($_POST['menu_inventario'])){
				$menu_inventario = $_POST['menu_inventario'];
			}else{
				$menu_inventario = 2;
			}
			
			$consultainventario = menuAccesosModelo::consultarSubMenu("inventario")->fetch_assoc();
			$submenu_id = $consultainventario['submenu_id'];		
			
			$datos_inventario = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_inventario,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menufacturas = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_inventario);
			
			if($result_Menufacturas->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_inventario);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_inventario);
			}	

			//SUBMENU transferencia
			if (isset($_POST['menu_transferencia'])){
				$menu_transferencia = $_POST['menu_transferencia'];
			}else{
				$menu_transferencia = 2;
			}
			
			$consultatransferencia = menuAccesosModelo::consultarSubMenu("transferencia")->fetch_assoc();
			$submenu_id = $consultatransferencia['submenu_id'];		
			
			$datos_transferencia = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_transferencia,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menufacturas = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_transferencia);
			
			if($result_Menufacturas->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_transferencia);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_transferencia);
			}	
		

			//FIN SUBMENU PARA EL MENU ALMACEN	

			

			//INICIO SUBMENU PARA EL MENU CONTABILIDAD
			//SUBMENU CUENTAS
			if (isset($_POST['menu_cuentasContabilidad'])){
				$menu_cuentasContabilidad = $_POST['menu_cuentasContabilidad'];
			}else{
				$menu_cuentasContabilidad = 2;
			}
			
			$consultacuentasContabilidad = menuAccesosModelo::consultarSubMenu("cuentasContabilidad")->fetch_assoc();
			$submenu_id = $consultacuentasContabilidad['submenu_id'];		
			
			$datos_cuentasContabilidad = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_cuentasContabilidad,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_cuentasContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_cuentasContabilidad);
			
			if($result_cuentasContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_cuentasContabilidad);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_cuentasContabilidad);
			}		

			//SUBMENU MOVIMIENTOS CONTABILIDAD
			if (isset($_POST['menu_movimientosContabilidad'])){
				$menu_movimientosContabilidad = $_POST['menu_movimientosContabilidad'];
			}else{
				$menu_movimientosContabilidad = 2;
			}
			
			$consultamovimientosContabilidad = menuAccesosModelo::consultarSubMenu("movimientosContabilidad")->fetch_assoc();
			$submenu_id = $consultamovimientosContabilidad['submenu_id'];		
			
			$datos_movimientosContabilidad = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_movimientosContabilidad,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_movimientosContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_movimientosContabilidad);
			
			if($result_movimientosContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_movimientosContabilidad);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_movimientosContabilidad);
			}

			//SUBMENU INGRESOS CONTABILIDAD
			if (isset($_POST['menu_ingresosContabilidad'])){
				$menu_ingresosContabilidad = $_POST['menu_ingresosContabilidad'];
			}else{
				$menu_ingresosContabilidad = 2;
			}
			
			$consultaingresosContabilidad = menuAccesosModelo::consultarSubMenu("ingresosContabilidad")->fetch_assoc();
			$submenu_id = $consultaingresosContabilidad['submenu_id'];		
			
			$datos_ingresosContabilidad = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_ingresosContabilidad,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_ingresosContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_ingresosContabilidad);
			
			if($result_ingresosContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_ingresosContabilidad);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_ingresosContabilidad);
			}			
			
			//SUBMENU EGRESOS CONTABILIDAD
			if (isset($_POST['menu_gastosContabilidad'])){
				$menu_gastosContabilidad = $_POST['menu_gastosContabilidad'];
			}else{
				$menu_gastosContabilidad = 2;
			}
			
			$consultagastosContabilidad = menuAccesosModelo::consultarSubMenu("gastosContabilidad")->fetch_assoc();
			$submenu_id = $consultagastosContabilidad['submenu_id'];		
			
			$datos_ingresosContabilidad = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_gastosContabilidad,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_gastosContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_ingresosContabilidad);
			
			if($result_gastosContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_ingresosContabilidad);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_ingresosContabilidad);
			}	

			//SUBMENU CHEQUES CONTABILIDAD
			if (isset($_POST['menu_chequesContabilidad'])){
				$menu_chequesContabilidad = $_POST['menu_chequesContabilidad'];
			}else{
				$menu_chequesContabilidad = 2;
			}
			
			$consultachequesContabilidad = menuAccesosModelo::consultarSubMenu("chequesContabilidad")->fetch_assoc();
			$submenu_id = $consultachequesContabilidad['submenu_id'];		
			
			$datos_consultachequesContabilidad = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_chequesContabilidad,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_chequesContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_consultachequesContabilidad);
			
			if($result_chequesContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_consultachequesContabilidad);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_consultachequesContabilidad);
			}	
			
			//SUBMENU CONFIGURACION CUENTAS CONTABILIDAD
			if (isset($_POST['menu_confCtaContabilidad'])){
				$menu_confCtaContabilidad = $_POST['menu_confCtaContabilidad'];
			}else{
				$menu_confCtaContabilidad = 2;
			}
			
			$consultaconfCtaContabilidad = menuAccesosModelo::consultarSubMenu("confCtaContabilidad")->fetch_assoc();
			$submenu_id = $consultaconfCtaContabilidad['submenu_id'];		
			
			$datos_consultaconfCtaContabilidad = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confCtaContabilidad,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_confCtaContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_consultaconfCtaContabilidad);
			
			if($result_confCtaContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_consultaconfCtaContabilidad);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_consultaconfCtaContabilidad);
			}	
			
			//SUBMENU CONFIGURACION TIPO DE PAGOS
			if (isset($_POST['menu_confTipoPago'])){
				$menu_confTipoPago = $_POST['menu_confTipoPago'];
			}else{
				$menu_confTipoPago = 2;
			}
			
			$consultaconfTipoPago = menuAccesosModelo::consultarSubMenu("confTipoPago")->fetch_assoc();
			$submenu_id = $consultaconfTipoPago['submenu_id'];		
			
			$datos_consultaconfTipoPago = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confTipoPago,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_confCtaContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_consultaconfTipoPago);
			
			if($result_confCtaContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_consultaconfTipoPago);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_consultaconfTipoPago);
			}	
			
			//SUBMENU CONFIGURACION BANCOS
			if (isset($_POST['menu_confBancos'])){
				$menu_confBancos = $_POST['menu_confBancos'];
			}else{
				$menu_confBancos = 2;
			}
			
			$consultaconfBancos = menuAccesosModelo::consultarSubMenu("confBancos")->fetch_assoc();
			$submenu_id = $consultaconfBancos['submenu_id'];		
			
			$datos_consultaconfBancos = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confBancos,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_confCtaContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_consultaconfBancos);
			
			if($result_confCtaContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_consultaconfBancos);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_consultaconfBancos);
			}	
			
			//SUBMENU CONFIGURACION IMPUESTOS
			if (isset($_POST['menu_confImpuestos'])){
				$menu_confImpuestos = $_POST['menu_confImpuestos'];
			}else{
				$menu_confImpuestos = 2;
			}
			
			$consultaconfImpuestos = menuAccesosModelo::consultarSubMenu("confImpuestos")->fetch_assoc();
			$submenu_id = $consultaconfImpuestos['submenu_id'];		
			
			$datos_consultaconfImpuestos = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confImpuestos,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_confCtaContabilidad  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_consultaconfImpuestos);
			
			if($result_confCtaContabilidad->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_consultaconfImpuestos);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_consultaconfImpuestos);
			}				
			//INICIO SUBMENU PARA EL MENU CONTABILIDAD
			
			//INICIO SUBMENU PARA EL MENU REPORTES
			//SUBMENU REPORTE HISTORIAL
			if (isset($_POST['menu_reporte_historial'])){
				$menu_reporte_historial = $_POST['menu_reporte_historial'];
			}else{
				$menu_reporte_historial = 2;
			}
			
			$consultareporte_historial = menuAccesosModelo::consultarSubMenu("reporte_historial")->fetch_assoc();
			$submenu_id = $consultareporte_historial['submenu_id'];		
			
			$datos_reporte_historial = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_reporte_historial,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menuclientes  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_reporte_historial);
			
			if($result_Menuclientes->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_reporte_historial);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_reporte_historial);
			}
			
			//SUBMENU REPORTE DE VENTAS
			if (isset($_POST['menu_reporte_ventas'])){
				$menu_reporte_ventas = $_POST['menu_reporte_ventas'];
			}else{
				$menu_reporte_ventas = 2;
			}
			
			$consultareporte_ventas = menuAccesosModelo::consultarSubMenu("reporte_ventas")->fetch_assoc();
			$submenu_id = $consultareporte_ventas['submenu_id'];		
			
			$datos_reporte_ventas = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_reporte_ventas,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menufacturas = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_reporte_ventas);
			
			if($result_Menufacturas->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_reporte_ventas);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_reporte_ventas);
			}	
			
			//SUBMENU REPORTE DE COMPRAS
			if (isset($_POST['menu_reporte_compras'])){
				$menu_reporte_compras = $_POST['menu_reporte_compras'];
			}else{
				$menu_reporte_compras = 2;
			}
			
			$consultareporte_compras = menuAccesosModelo::consultarSubMenu("reporte_compras")->fetch_assoc();
			$submenu_id = $consultareporte_compras['submenu_id'];		
			
			$datos_reporte_compras = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_reporte_compras,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menufacturas = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_reporte_compras);
			
			if($result_Menufacturas->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_reporte_compras);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_reporte_compras);
			}					
			//FIN SUBMENU PARA EL MENU REPORTES	

			//INICIO SUBMENU PARA EL MENU CONFIGURACION
			//SUBMENU COLABORADORES
			if (isset($_POST['menu_colaboradores'])){
				$menu_colaboradores = $_POST['menu_colaboradores'];
			}else{
				$menu_colaboradores = 2;
			}
			
			$consultaMenucolaboradores = menuAccesosModelo::consultarSubMenu("colaboradores")->fetch_assoc();
			$submenu_id = $consultaMenucolaboradores['submenu_id'];		
			
			$datos_colaboradores = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_colaboradores,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menucolaboradores  = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_colaboradores);
			
			if($result_Menucolaboradores->num_rows>0){					
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_colaboradores);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_colaboradores);
			}
			
			//SUBMENU PUESTOS
			if (isset($_POST['menu_puestos'])){
				$menu_puestos = $_POST['menu_puestos'];
			}else{
				$menu_puestos = 2;
			}
			
			$consultapuestos = menuAccesosModelo::consultarSubMenu("puestos")->fetch_assoc();
			$submenu_id = $consultapuestos['submenu_id'];		
			
			$datos_puestos = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_puestos,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menupuestos = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_puestos);
			
			if($result_Menupuestos->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_puestos);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_puestos);
			}	
			
			//SUBMENU USERS
			if (isset($_POST['menu_users'])){
				$menu_users = $_POST['menu_users'];
			}else{
				$menu_users = 2;
			}
			
			$consultausers = menuAccesosModelo::consultarSubMenu("users")->fetch_assoc();
			$submenu_id = $consultausers['submenu_id'];		
			
			$datos_users = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_users,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menuusers = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_users);
			
			if($result_Menuusers->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_users);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_users);
			}	

			//SUBMENU SECUENCIA DE FACTURACIÓN SAR
			if (isset($_POST['menu_secuencia'])){
				$menu_secuencia = $_POST['menu_secuencia'];
			}else{
				$menu_secuencia = 2;
			}
			
			$consultasecuencia = menuAccesosModelo::consultarSubMenu("secuencia")->fetch_assoc();
			$submenu_id = $consultasecuencia['submenu_id'];		
			
			$datos_secuencia = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_secuencia,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menusecuencia = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_secuencia);
			
			if($result_Menusecuencia->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_secuencia);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_secuencia);
			}

			//SUBMENU EMPRESA
			if (isset($_POST['menu_empresa'])){
				$menu_empresa = $_POST['menu_empresa'];
			}else{
				$menu_empresa = 2;
			}
			
			$consultaempresa = menuAccesosModelo::consultarSubMenu("empresa")->fetch_assoc();
			$submenu_id = $consultaempresa['submenu_id'];		
			
			$datos_empresa = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_empresa,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menuempresa = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_empresa);
			
			if($result_Menuempresa->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_empresa);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_empresa);
			}	

			//SUBMENU CONFIGURACION ALMACEN
			if (isset($_POST['menu_confAlmacen'])){
				$menu_confAlmacen = $_POST['menu_confAlmacen'];
			}else{
				$menu_confAlmacen = 2;
			}
			
			$consultaconfAlmacen = menuAccesosModelo::consultarSubMenu("confAlmacen")->fetch_assoc();
			$submenu_id = $consultaconfAlmacen['submenu_id'];		
			
			$datos_confAlmacen = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confAlmacen,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuconfAlmacen = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_confAlmacen);
			
			if($result_MenuconfAlmacen->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_confAlmacen);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_confAlmacen);
			}	

			//SUBMENU CONFIGURACION UBICACION
			if (isset($_POST['menu_confUbicacion'])){
				$menu_confUbicacion = $_POST['menu_confUbicacion'];
			}else{
				$menu_confUbicacion = 2;
			}
			
			$consultaconfUbicacion = menuAccesosModelo::consultarSubMenu("confUbicacion")->fetch_assoc();
			$submenu_id = $consultaconfUbicacion['submenu_id'];		
			
			$datos_confUbicacion = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confUbicacion,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuconfUbicacion = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_confUbicacion);
			
			if($result_MenuconfUbicacion->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_confUbicacion);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_confUbicacion);
			}

			//SUBMENU CONFIGURACION MEDIDAS
			if (isset($_POST['menu_confMedida'])){
				$menu_confMedida = $_POST['menu_confMedida'];
			}else{
				$menu_confMedida = 2;
			}
			
			$consultaconfMedida = menuAccesosModelo::consultarSubMenu("confMedida")->fetch_assoc();
			$submenu_id = $consultaconfMedida['submenu_id'];		
			
			$datos_confMedida = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confMedida,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuconfMedida = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_confMedida);
			
			if($result_MenuconfMedida->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_confMedida);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_confMedida);
			}
			
			//SUBMENU CONFIGURACION CATEGORIA DE PRODUCTOS
			if (isset($_POST['menu_confCategoria'])){
				$menu_confCategoria = $_POST['menu_confCategoria'];
			}else{
				$menu_confCategoria = 2;
			}
			
			$consultaconfCategoria = menuAccesosModelo::consultarSubMenu("confCategoria")->fetch_assoc();
			$submenu_id = $consultaconfCategoria['submenu_id'];		
			
			$datos_confCategoria = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confCategoria,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuconfMedida = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_confCategoria);
			
			if($result_MenuconfMedida->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_confCategoria);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_confCategoria);
			}			

			//SUBMENU CONFIGURACION DE CORREO
			if (isset($_POST['menu_confEmail'])){
				$menu_confEmail = $_POST['menu_confEmail'];
			}else{
				$menu_confEmail = 2;
			}
			
			$consultaconfEmail = menuAccesosModelo::consultarSubMenu("confEmail")->fetch_assoc();
			$submenu_id = $consultaconfEmail['submenu_id'];		
			
			$datos_confEmail = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confEmail,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuconsultaconfEmail = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_confEmail);
			
			if($result_MenuconsultaconfEmail->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_confEmail);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_confEmail);
			}

			//SUBMENU PRIVILEGIO
			if (isset($_POST['menu_privilegio'])){
				$menu_privilegio = $_POST['menu_privilegio'];
			}else{
				$menu_privilegio = 2;
			}
			
			$consultaPrivilegio = menuAccesosModelo::consultarSubMenu("privilegio")->fetch_assoc();
			$submenu_id = $consultaPrivilegio['submenu_id'];		
			
			$datos_Privilegio = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_privilegio,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuPrivilegio = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_Privilegio);
			
			if($result_MenuPrivilegio->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_Privilegio);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_Privilegio);
			}	

			//SUBMENU TIPO DE USUARIO PARA PERMISOS
			if (isset($_POST['menu_tipoUser'])){
				$menu_tipoUser = $_POST['menu_tipoUser'];
			}else{
				$menu_tipoUser = 2;
			}
			
			$consultatipoUser = menuAccesosModelo::consultarSubMenu("tipoUser")->fetch_assoc();
			$submenu_id = $consultatipoUser['submenu_id'];		
			
			$datos_tipoUser = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_tipoUser,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenutipoUser = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_tipoUser);
			
			if($result_MenutipoUser->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_tipoUser);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_tipoUser);
			}
			
			//SUBMENU TIPO DE PLANES
			if (isset($_POST['menu_confPlanes'])){
				$menu_confPlanes = $_POST['menu_confPlanes'];
			}else{
				$menu_confPlanes = 2;
			}
			
			$consultaconfPlanes = menuAccesosModelo::consultarSubMenu("confPlanes")->fetch_assoc();
			$submenu_id = $consultaconfPlanes['submenu_id'];		
			
			$datos_confPlanes = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confPlanes,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_confPlanes = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_confPlanes);
			
			if($result_confPlanes->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_confPlanes);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_confPlanes);
			}	
			
			//SUBMENU HOSTS
			if (isset($_POST['menu_confPlanes'])){
				$menu_confHost = $_POST['menu_confHost'];
			}else{
				$menu_confHost = 2;
			}
			
			$consultamenu_confHost = menuAccesosModelo::consultarSubMenu("confHost")->fetch_assoc();
			$submenu_id = $consultamenu_confHost['submenu_id'];		
			
			$datos_menuconfHost = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confHost,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_confHost = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_menuconfHost);
			
			if($result_confHost->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_menuconfHost);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_menuconfHost);
			}	
			
			//SUBMENU HOSTS PRODUCTOS
			if (isset($_POST['menu_confHostProductos'])){
				$menu_confHostProductos = $_POST['menu_confHostProductos'];
			}else{
				$menu_confHostProductos = 2;
			}
			
			$consultamenu_confHostProductos = menuAccesosModelo::consultarSubMenu("confHostProductos")->fetch_assoc();
			$submenu_id = $consultamenu_confHostProductos['submenu_id'];		
			
			$datos_menu_confHostProductos = [
				"submenu_id" => $submenu_id,
				"estado" => $menu_confHostProductos,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_menu_confHostProductos = menuAccesosModelo::valid_subMenuAccesos_modelo($datos_menu_confHostProductos);
			
			if($result_menu_confHostProductos->num_rows>0){
				menuAccesosModelo::edit_subMenuAccesos_modelo($datos_menu_confHostProductos);
			}else{
				menuAccesosModelo::agregar_subMenuAccesos_modelo($datos_menu_confHostProductos);
			}				
			//FIN SUBMENU PARA EL MENU CONFIGURACION				
			//FIN REGISTRO DE SUBMENUS

			//######################INICIO REGISTRO DE SUBMENUS1######################
			//SUBMENU HISTORIAL DEL MENU REPORTES
			//SUBMENU BITACORA
			if (isset($_POST['menu_historialAccesos'])){
				$menu_historialAccesos = $_POST['menu_historialAccesos'];
			}else{
				$menu_historialAccesos = 2;
			}
			
			$consultaMenureporte_historial = menuAccesosModelo::consultarSubMenu1("historialAccesos")->fetch_assoc();
			$submenu1_id = $consultaMenureporte_historial['submenu1_id'];		
			
			$datos_historialAccesos = [
				"submenu1_id" => $submenu1_id,
				"estado" => $menu_historialAccesos,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_Menureporte_historial  = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos_historialAccesos);
			
			if($result_Menureporte_historial->num_rows>0){					
				menuAccesosModelo::edit_subMenu1Accesos_modelo($datos_historialAccesos);
			}else{
				menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos_historialAccesos);
			}	

			//SUBMENU HISTORIAL DE ACCESOS
			if (isset($_POST['menu_bitacora'])){
				$menu_bitacora = $_POST['menu_bitacora'];
			}else{
				$menu_bitacora = 2;
			}
			
			$consultamenu_bitacora = menuAccesosModelo::consultarSubMenu1("bitacora")->fetch_assoc();
			$submenu1_id = $consultamenu_bitacora['submenu1_id'];		
			
			$datos_menu_bitacora = [
				"submenu1_id" => $submenu1_id,
				"estado" => $menu_bitacora,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenuhistorialAccesos  = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos_menu_bitacora);
			
			if($result_MenuhistorialAccesos->num_rows>0){					
				menuAccesosModelo::edit_subMenu1Accesos_modelo($datos_menu_bitacora);
			}else{
				menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos_menu_bitacora);
			}	

			//SUBMENU VENTAS DEL MENU REPORTES
			//SUBMENU REPORTE DE VENTAS
			if (isset($_POST['menu_reporteVentas'])){
				$menu_reporteVentas = $_POST['menu_reporteVentas'];
			}else{
				$menu_reporteVentas = 2;
			}
			
			$consultaMenureporteVentas = menuAccesosModelo::consultarSubMenu1("reporteVentas")->fetch_assoc();
			$submenu1_id = $consultaMenureporteVentas['submenu1_id'];		
			
			$datos_reporteVentas = [
				"submenu1_id" => $submenu1_id,
				"estado" => $menu_reporteVentas,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenureporteVentas  = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos_reporteVentas);
			
			if($result_MenureporteVentas->num_rows>0){					
				menuAccesosModelo::edit_subMenu1Accesos_modelo($datos_reporteVentas);
			}else{
				menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos_reporteVentas);
			}	

			//SUBMENU REPORTE DE COTIZACIONES
			if (isset($_POST['menu_reporteCotizacion'])){
				$menu_reporteCotizacion = $_POST['menu_reporteCotizacion'];
			}else{
				$menu_reporteCotizacion = 2;
			}
			
			$consultaMenureporteCotizacion = menuAccesosModelo::consultarSubMenu1("reporteCotizacion")->fetch_assoc();
			$submenu1_id = $consultaMenureporteCotizacion['submenu1_id'];		
			
			$datos_reporteCotizacion = [
				"submenu1_id" => $submenu1_id,
				"estado" => $menu_reporteCotizacion,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenureporteCotizacion  = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos_reporteCotizacion);
			
			if($result_MenureporteCotizacion->num_rows>0){					
				menuAccesosModelo::edit_subMenu1Accesos_modelo($datos_reporteCotizacion);
			}else{
				menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos_reporteCotizacion);
			}	

			//SUBMENU CUENTAS POR COBRAR CLIENTES
			if (isset($_POST['menu_cobrarClientes'])){
				$menu_cobrarClientes = $_POST['menu_cobrarClientes'];
			}else{
				$menu_cobrarClientes = 2;
			}
			
			$consultaMenucobrarClientes = menuAccesosModelo::consultarSubMenu1("cobrarClientes")->fetch_assoc();
			$submenu1_id = $consultaMenucobrarClientes['submenu1_id'];		
			
			$datos_cobrarClientes = [
				"submenu1_id" => $submenu1_id,
				"estado" => $menu_cobrarClientes,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenucobrarClientes  = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos_cobrarClientes);
			
			if($result_MenucobrarClientes->num_rows>0){					
				menuAccesosModelo::edit_subMenu1Accesos_modelo($datos_cobrarClientes);
			}else{
				menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos_cobrarClientes);
			}

			//SUBMENU COMPRAS DEL MENU REPORTES
			//SUBMENU REPORTE DE COMPRAS
			if (isset($_POST['menu_reporteCompras'])){
				$menu_reporteCompras = $_POST['menu_reporteCompras'];
			}else{
				$menu_reporteCompras = 2;
			}
			
			$consultaMenureporteCompras = menuAccesosModelo::consultarSubMenu1("reporteCompras")->fetch_assoc();
			$submenu1_id = $consultaMenureporteCompras['submenu1_id'];		
			
			$datos_reporteCompras = [
				"submenu1_id" => $submenu1_id,
				"estado" => $menu_reporteCompras,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenureporteCompras  = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos_reporteCompras);
			
			if($result_MenureporteCompras->num_rows>0){					
				menuAccesosModelo::edit_subMenu1Accesos_modelo($datos_reporteCompras);
			}else{
				menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos_reporteCompras);
			}	

			//SUBMENU CUENTAS POR PAGAR PROVEEDORES
			if (isset($_POST['menu_pagarProveedores'])){
				$menu_pagarProveedores = $_POST['menu_pagarProveedores'];
			}else{
				$menu_pagarProveedores = 2;
			}
			
			$consultaMenupagarProveedores = menuAccesosModelo::consultarSubMenu1("pagarProveedores")->fetch_assoc();
			$submenu1_id = $consultaMenupagarProveedores['submenu1_id'];		
			
			$datos_pagarProveedores = [
				"submenu1_id" => $submenu1_id,
				"estado" => $menu_pagarProveedores,
				"privilegio_id" => $privilegio_id,
				"fecha_registro" => $fecha_registro,				
			];
			
			$result_MenupagarProveedores  = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos_pagarProveedores);
			
			if($result_MenupagarProveedores->num_rows>0){					
				menuAccesosModelo::edit_subMenu1Accesos_modelo($datos_pagarProveedores);
			}else{
				menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos_pagarProveedores);
			}			
			
			$alert = [
				"alert" => "clear",
				"title" => "Registro almacenado",
				"text" => "El registro se ha almacenado correctamente",
				"type" => "success",
				"btn-class" => "btn-primary",
				"btn-text" => "¡Bien Hecho!",
				"form" => "formMenuAccesos",
				"id" => "pro_accesos",
				"valor" => "Asignar Accesos Privilegio: ".$privilegio_nombre_accesos,
				"funcion" => "listar_privilegio();getAccesoControl(".$privilegio_id.",'".$privilegio_nombre_accesos."');",
				"modal" => "",	
			];
			
			return mainModel::sweetAlert($alert);			
		}	
	}