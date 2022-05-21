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
    }