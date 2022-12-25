<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

	class loginModel extends mainModel{
		protected function iniciar_sesion_modelo($datos){
			$username = $datos['username'];
			$password = $datos['password'];
			$estatus = 1;//USUARIO ACTIVO

			$mysqli = mainModel::connection();
			$query = "SELECT u.*, tu.nombre AS 'cuentaTipo' 
				FROM users AS u
				INNER JOIN tipo_user AS tu
				ON u.tipo_user_id = tu.tipo_user_id 
				WHERE BINARY (u.username LIKE '$username%' OR u.email LIKE '$username%') AND u.password = '$password' AND u.estado = '$estatus'
				GROUP by u.tipo_user_id";

			$result = $mysqli->query($query) or die($mysqli->error);
			
			return $result;
		}
		
		protected function getMenuAccesoLogin($privilegio_id){
			$query = "SELECT am.acceso_menu_id AS 'acceso_menu_id', m.name AS 'name'
				FROM acceso_menu AS am
				INNER JOIN menu AS m
				ON am.menu_id = m.menu_id
				WHERE am.privilegio_id = '$privilegio_id' AND m.name = 'dashboard' AND am.estado = 1
				ORDER BY am.menu_id ASC
				LIMIT 1";
				
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
		
			return $sql;			
		}
		
		protected function getSubMenuAccesoLogin($privilegio_id){
			$query = "SELECT asm.acceso_submenu_id AS 'acceso_menu_id', sm.name AS 'name'
				FROM acceso_submenu AS asm
				INNER JOIN submenu AS sm
				ON asm.submenu_id = sm.submenu_id
				WHERE asm.privilegio_id = '$privilegio_id' AND asm.estado = 1 AND sm.submenu_id NOT IN(7,8,9)
				ORDER BY asm.submenu_id ASC
				LIMIT 1";
				
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
		
			return $sql;			
		}

		protected function getSubMenu1AccesoLogin($privilegio_id){
			$query = "SELECT asm.acceso_submenu1_id AS 'acceso_menu_id', sm.name AS 'name'
				FROM acceso_submenu1 AS asm
				INNER JOIN submenu1 AS sm
				ON asm.submenu1_id = sm.submenu1_id
				WHERE asm.privilegio_id = '$privilegio_id' AND asm.estado = 1
				ORDER BY asm.submenu1_id ASC";
				
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
		
			return $sql;			
		}		
		
		protected function cerrar_sesion_modelo($datos){
			if($datos['usuario'] != "" && $datos['token_s'] == $datos['token']){
				$abitacora = mainModel::actualizar_bitacora($datos['codigo'], $datos['hora']);
				
				if($abitacora){
					session_unset();//VACIAR LA SESION
					session_destroy();//DESTRUIR LA SESION
					$respuesta = 1;
				}else{
					$respuesta = 2;
				}
				
			}else{
				$respuesta = 2;
			}
			
			return $respuesta;
		}

		protected function validar_pago_pendiente_main_server_modelo(){
			$mysqli_main = mainModel::connect_mysqli_main_server();
			$validar = 1;//SE VALIDARA EL CLIENTE PARA PODER INICIAR SESION

			$query = "SELECT sc.clientes_id AS 'clientes_id'
				FROM server_customers AS sc
				INNER JOIN clientes AS c
				ON sc.clientes_id = c.clientes_id
				LEFT JOIN cobrar_clientes AS cc
				on cc.clientes_id = sc.clientes_id
				WHERE cc.estado = 1 AND sc.db = '".DB."'";			

			$sql = $mysqli_main->query($query) or die($mysqli_main->error);
					
			return $sql;		
		}

		//CONSULTAMOS SI ES NECESARIO VALIDAR AL CLIENTE PARA SU INICIO DE SESION
		protected function validar_cliente_server_modelo(){
			$mysqli_main = mainModel::connect_mysqli_main_server();

			$query = "SELECT sc.validar AS 'validar'
				FROM server_customers AS sc
				INNER JOIN clientes AS c
				ON sc.clientes_id = c.clientes_id
				WHERE sc.db = '".DB."'";			

			$sql = $mysqli_main->query($query) or die($mysqli_main->error);
					
			return $sql;		
		}	
		
		//CONSULTAMOS SI EL CLIENTE TIENE PAGO PENDIENTE DE MESES ANTERIORES
		protected function validar_cliente_pagos_vencidos_main_server_modelo(){
			$mysqli_main = mainModel::connect_mysqli_main_server();

			$query = "SELECT sc.clientes_id AS 'clientes_id'
				FROM server_customers AS sc
				INNER JOIN clientes AS c
				ON sc.clientes_id = c.clientes_id
				LEFT JOIN cobrar_clientes AS cc
				on cc.clientes_id = sc.clientes_id
				WHERE cc.estado = 1 AND sc.db = '".DB."' AND MONTH(cc.fecha) <= MONTH(CURDATE())";			

			$sql = $mysqli_main->query($query) or die($mysqli_main->error);
					
			return $sql;		
		}			
	}
?>