<?php
    if($peticionAjax){
        require_once "../modelos/loginModel.php";
    }else{
        require_once "./modelos/loginModel.php";
    }
    
    class loginControlador extends loginModel{
		
        public function iniciar_sesion_controlador(){
            $username = mainModel::cleanString($_POST['inputEmail']);
            $password = $_POST['inputPassword'];
            $password = mainModel::encryption($password);
			 
            $datosLogin = [
                "username" => $username,
                "password" => $password
            ];

            $result = loginModel::iniciar_sesion_modelo($datosLogin);
			
            if($result->num_rows != 0){
				$row = $result->fetch_assoc();
				$fechaActual = date("Y-m-d");
				$añoActual = date("Y");
				$horaActual = date("H:m:s");
				
				$query = "SELECT bitacora_id FROM bitacora";
				$result1 = mainModel::ejecutar_consulta_simple($query);
				
				$numero = ($result1->num_rows)+1;
				$codigoB = mainModel::getRandom("CB", 7, $numero);
				
				$datosBitacora=[
					"bitacoraCodigo"=>$codigoB,
					"bitacoraFecha"=>$fechaActual,
					"bitacoraHoraInicio"=>$horaActual,
					"bitacoraHoraFinal"=> "Sin Registro",
					"bitacoraTipo"=> $row['tipo_user_id'],
					"bitacoraYear"=>$añoActual,
					"user_id"=> $row['users_id']					
				];
				
				$insertarBitacora = mainModel::guardar_bitacora($datosBitacora);

				if($insertarBitacora){
					if(!isset($_SESSION['user_sd'])){ 
						session_start(['name'=>'SD']); 
					}

					$_SESSION['users_id_sd'] = $row['users_id'];
					$_SESSION['user_sd'] = $row['username'];
					$_SESSION['tipo_sd'] = $row['cuentaTipo'];	
					$_SESSION['privilegio_sd'] = $row['privilegio_id'];
					$_SESSION['tipo_user_id_sd'] = $row['tipo_user_id'];
					$_SESSION['token_sd'] = md5(uniqid(mt_rand(),true));	
					$_SESSION['colaborador_id_sd'] = $row['colaboradores_id'];
					$_SESSION['empresa_id_sd'] = $row['empresa_id'];					
					$_SESSION['codigo_bitacora_sd'] = $codigoB;
					
					//CONSULTAMOS UN MENU AL QUE TENGA ACCESO EL USUARIO Y LO REDIRECCIONAMOS A ESA PAGINA
					$result_consultaMenu = loginModel::getMenuAccesoLogin($row['privilegio_id']);
					
					if($result_consultaMenu->num_rows>0){
						$result_MenuAcceso = loginModel::getMenuAccesoLogin($row['privilegio_id'])->fetch_assoc();					
						$consultaMenu = $result_MenuAcceso['name'];
						
						$url = SERVERURL.$consultaMenu."/";
					}else{
						$result_consultaSubMenu = loginModel::getSubMenuAccesoLogin($row['privilegio_id']);
						
						if($result_consultaSubMenu->num_rows>0){
							$result_SubMenuAcceso = loginModel::getSubMenuAccesoLogin($row['privilegio_id'])->fetch_assoc();					
							$consultaSubMenu = $result_SubMenuAcceso['name'];
							
							$url = SERVERURL.$consultaSubMenu."/";							
						}else{
							$result_consultaSubMenu1 = loginModel::getSubMenu1AccesoLogin($row['privilegio_id']);
							
							if($result_consultaSubMenu1->num_rows>0){
								$result_SubMenu1Acceso = loginModel::getSubMenu1AccesoLogin($row['privilegio_id'])->fetch_assoc();					
								$consultaSubMenu1 = $result_SubMenu1Acceso['name'];
								
								$url = SERVERURL.$consultaSubMenu1."/";								
							}else{
								$url = SERVERURL."dashboard/";
							}							
						}						
					}
					
					$datos = array(
						0 => $url,
						1 => "",
					);
					
				}else{
					$datos = array(
						0 => "",
						1 => "Error",
					);				
				}
            }else{
				$datos = array(
					0 => "",
					1 => "ErrorS",
				);					
            }
			return json_encode($datos);
        }
		
		public function cerrar_sesion_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}

			$token = mainModel::decryption($_GET['token']);
			$hora = date("H:m:s");		
			
			$datos = [
				"usuario" => $_SESSION['user_sd'],
				"token_s" => $_SESSION['token_sd'],
				"token" => $token,
				"codigo" => $_SESSION['codigo_bitacora_sd'],
				"hora" => $hora,				
			];
			
			mainModel::guardar_historial_accesos("Cierre de Sesion");
			
			return loginModel::cerrar_sesion_modelo($datos);
			
		}
		
		public function forzar_cierre_sesion_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
			
			mainModel::guardar_historial_accesos("Cierre de Sesion Forzado");
			session_destroy();
			return header("Location: ".SERVERURL."login/");
		}	
		
		public function validar_pago_pendiente_main_server_controlador(){
			$result = loginModel::validar_pago_pendiente_main_server_modelo();
			$result_validar_cliente = loginModel::validar_cliente_server_modelo();
			
			$date = date("Y-m-d");
			$año = date("Y");
			$mes = date("m");
	
			$fecha_inicial = date("Y-m-d", strtotime($año."-".$mes."-01"));
			$fecha_final = date("Y-m-d", strtotime($año."-".$mes."-10"));
	
			//SI NOS ESTAMOS CONECTANDO AL SISTEMA PRINCIPAL, SIMPLEMENTE ENTRAMOS SIN PROBLEMA
			if(DB == "kireds_clientes_dipronor"){
				$datos = 1;
			}else{			
				$result_pagoVencido = loginModel::validar_cliente_pagos_vencidos_main_server_modelo();//METODO QUE VALIDA LOS PAGOS VENCIDOS DE LOS CLIENTES

				$row = $result_validar_cliente->fetch_assoc();

				//EVALUAMOS QUE LA VARIABLE VALIDAR NO VENGA VACIA O NULA
				if($row['validar'] == "" || $row['validar'] == null){
					$validar = 0;
				}else{
					$validar = $row['validar'];
				}

				//CONSULTAMOS SI ES NECESARIO VALIDAR EL CLIENTE, SI NO LO ES, LO DEJAMOS INICIAR SESION CORRECTAMENTE
				if($validar==0){
					$datos = 1;
				}else{
					//VALIDAMOS SI EL CLIENTE TIENE PAGOS VENCIDOS
					if($result_pagoVencido->num_rows >= 1){
						$datos = array(
							0 => "",
							1 => "ErrorP",
						);	
					}else{//SI EL CLIENTE NO TIENE PAGOS VENCIDOS SOLO EVALUAMOS LOS PAGOS PENDIENTES DEL MES  EN CURSO	
						//CONSULTAMOS SI HAY PENDIENTES DE PAGO POR EL CLIENTE
						if($result->num_rows == 1){//SI ENCUENTRA UN REGISTRO PENDIENTE DE PAGO
							if($date >= $fecha_inicial && $date <= $fecha_final){//EVALUAMOS SI ESTA DENTRO DE LA FECHA PERMITIDA PARA INICIAR SESION CON O SIN PAGO EFECUTADO
								$datos = 1;
							}else{//SI SE HA PASADO DE LA FECHA PERMITIDA DE PAGO, NO DEJAMOS INICIAR SESION AL CLIENTE
								$datos = array(
									0 => "",
									1 => "ErrorP",
								);	
							}
						}else if($result->num_rows > 1){//SI ENCONTRAMOS MAS DE UN REGISTRO DE PAGO PENDIENTE, NO DEJAMOS INICIAR SESION AL CLIENTE
							$datos = array(
								0 => "",
								1 => "ErrorP",
							);	
						}else{//SI NO ENCONTRAMOS NINGUN REGISTO PENDIENTE DE PAGO, DEJAMOS INICIAR SESION AL CLIENTE
							$datos = 1;
						}
					}					
				}				
			}

			return json_encode($datos);
		}
    }
?>	