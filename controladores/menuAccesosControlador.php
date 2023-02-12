<?php
    if($peticionAjax){
        require_once "../modelos/menuAccesosModelo.php";
    }else{
        require_once "./modelos/menuAccesosModelo.php";
    }
	
	class menuAccesosControlador extends menuAccesosModelo{
		public function agregar_MenuAccesos_controlador(){
			$privilegio_id = $_POST['privilegio_id_accesos'];
			$privilegio_nombre = $_POST['privilegio'];
			$menu_id = $_POST['menus'];
			$estado = 1;
			$fecha_registro = date("Y-m-d H:i:s");		
			
			$datos = [
				"menu_id" => $menu_id,
				"privilegio_id" => $privilegio_id,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,				
			];
			
			$resultVarios = menuAccesosModelo::valid_menuAccesos_modelo($datos);
			
			if($resultVarios->num_rows == 0){			
				$query = menuAccesosModelo::agregar_menuAccesos_modelo($datos);

				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formMenuAccesos",
						"id" => "proceso_privilegios",
						"valor" => "",
						"funcion" => "listar_menuaccesos();getAccesoControlMenus(".$privilegio_id.",'".$privilegio_nombre."');getMenusPrivilegios();",
						"modal" => "",	
					];
				}else{
					$alert = [
						"alert" => "simple",
						"title" => "Ocurrio un error inesperado",
						"text" => "No hemos podido procesar su solicitud",
						"type" => "error",
						"btn-class" => "btn-danger",					
					];	
				}
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Resgistro ya existe",
					"text" => "Lo sentimos este registro ya existe",
					"type" => "error",	
					"btn-class" => "btn-danger",						
				];					
			}	
			
			return mainModel::sweetAlert($alert);			
		}	

		public function agregar_SubMenuAccesos_controlador(){
			$privilegio_id = $_POST['privilegio_id_accesos'];
			$privilegio_nombre = $_POST['privilegio'];
			$submenu_id = $_POST['submenus'];
			$estado = 1;
			$fecha_registro = date("Y-m-d H:i:s");		
			
			$datos = [
				"submenu_id" => $submenu_id,
				"privilegio_id" => $privilegio_id,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,				
			];
			
			$resultVarios = menuAccesosModelo::valid_subMenuAccesos_modelo($datos);
			
			if($resultVarios->num_rows == 0){			
				$query = menuAccesosModelo::agregar_subMenuAccesos_modelo($datos);

				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formMenuAccesos",
						"id" => "proceso_privilegios",
						"valor" => "",
						"funcion" => "listar_submenuaccesos();getAccesoControlSubMenus(".$privilegio_id.",'".$privilegio_nombre."');getSubMenusPrivilegios();getMenusparaSubmenuPrivilegios(".$privilegio_id.");",
						"modal" => "",	
					];
				}else{
					$alert = [
						"alert" => "simple",
						"title" => "Ocurrio un error inesperado",
						"text" => "No hemos podido procesar su solicitud",
						"type" => "error",
						"btn-class" => "btn-danger",					
					];	
				}
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Resgistro ya existe",
					"text" => "Lo sentimos este registro ya existe",
					"type" => "error",	
					"btn-class" => "btn-danger",						
				];					
			}	
			
			return mainModel::sweetAlert($alert);			
		}	
		
		public function agregar_SubMenu1Accesos_controlador(){
			$privilegio_id = $_POST['privilegio_id_accesos'];
			$privilegio_nombre = $_POST['privilegio'];
			$submenus = $_POST['submenus'];
			$estado = 1;
			$fecha_registro = date("Y-m-d H:i:s");		
			
			$datos = [
				"submenus_id" => $submenus,
				"privilegio_id" => $privilegio_id,
				"estado" => $estado,
				"fecha_registro" => $fecha_registro,				
			];
			
			$resultVarios = menuAccesosModelo::valid_sub1MenuAccesos_modelo($datos);
			
			if($resultVarios->num_rows == 0){			
				$query = menuAccesosModelo::agregar_subMenu1Accesos_modelo($datos);

				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formMenuAccesos",
						"id" => "proceso_privilegios",
						"valor" => "",
						"funcion" => "listar_submenu1accesos();getAccesoControlSubMenus1(".$privilegio_id.",'".$privilegio_nombre."');getSubMenu1Privilegios(".$privilegio_id.");",
						"modal" => "",	
					];
				}else{
					$alert = [
						"alert" => "simple",
						"title" => "Ocurrio un error inesperado",
						"text" => "No hemos podido procesar su solicitud",
						"type" => "error",
						"btn-class" => "btn-danger",					
					];	
				}
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Resgistro ya existe",
					"text" => "Lo sentimos este registro ya existe",
					"type" => "error",	
					"btn-class" => "btn-danger",						
				];					
			}	
			
			return mainModel::sweetAlert($alert);			
		}			
	}
?>	