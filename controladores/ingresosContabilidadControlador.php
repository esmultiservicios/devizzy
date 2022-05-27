<?php

    if($peticionAjax){

        require_once "../modelos/ingresosContabilidadModelo.php";

    }else{

        require_once "./modelos/ingresosContabilidadModelo.php";

    }

	

	class ingresosContabilidadControlador extends ingresosContabilidadModelo{

		public function agregar_ingresos_contabilidad_controlador(){

			if(!isset($_SESSION['user_sd'])){ 

				session_start(['name'=>'SD']); 

			}



			$clientes_id = mainModel::cleanStringConverterCase($_POST['cliente_ingresos']);

			$cuentas_id = mainModel::cleanStringConverterCase($_POST['cuenta_ingresos']);

			$empresa_id = mainModel::cleanStringConverterCase($_POST['empresa_ingresos']);

			$fecha = $_POST['fecha_ingresos'];

			$factura = mainModel::cleanString($_POST['factura_ingresos']);

			$subtotal = mainModel::cleanStringConverterCase($_POST['subtotal_ingresos']);

			$isv = mainModel::cleanStringConverterCase($_POST['isv_ingresos']);

			$descuento = mainModel::cleanStringConverterCase($_POST['descuento_ingresos']);

			$nc = mainModel::cleanStringConverterCase($_POST['nc_ingresos']);

			$total = mainModel::cleanStringConverterCase($_POST['total_ingresos']);

			$observacion = mainModel::cleanString($_POST['observacion_ingresos']);

			$estado = 1;

			$tipo_ingreso = 2;//OTROS INGRESOS

			$colaboradores_id = $_SESSION['colaborador_id_sd'];

			$fecha_registro = date("Y-m-d H:i:s");

			$ingresos_id = mainModel::correlativo("ingresos_id", "ingresos");

			 

			$datos = [

				"ingresos_id" => $ingresos_id,

				"clientes_id" => $clientes_id,

				"cuentas_id" => $cuentas_id,

				"empresa_id" => $empresa_id,

				"fecha" => $fecha,

				"factura" => $factura,

				"subtotal" => $subtotal,

				"isv" => $isv,

				"descuento" => $descuento,

				"nc" => $nc,

				"total" => $total,

				"observacion" => $observacion,

				"estado" => $estado,

				"fecha_registro" => $fecha_registro,

				"colaboradores_id" => $colaboradores_id,

				"tipo_ingreso" => $tipo_ingreso								

			];

			

			$resultIngresos = ingresosContabilidadModelo::valid_ingreso_cuentas_modelo($datos);

			

			if($resultIngresos->num_rows==0){

					$query = ingresosContabilidadModelo::agregar_ingresos_contabilidad_modelo($datos);

					

					if($query){

					//CONSULTAMOS EL SALDO DISPONIBLE PARA LA CUENTA

					$consulta_ingresos_contabilidad = ingresosContabilidadModelo::consultar_saldo_movimientos_cuentas_contabilidad($cuentas_id)->fetch_assoc();

					$saldo_consulta = $consulta_ingresos_contabilidad['saldo'];	

					$ingreso = $total;

					$egreso = 0;

					$saldo = $saldo_consulta + $ingreso;

					

					//AGREGAMOS LOS MOVIMIENTOS DE LA CUENTA

					$datos_movimientos = [

						"cuentas_id" => $cuentas_id,

						"empresa_id" => $empresa_id,

						"fecha" => $fecha,

						"ingreso" => $ingreso,

						"egreso" => $egreso,

						"saldo" => $saldo,

						"colaboradores_id" => $colaboradores_id,

						"fecha_registro" => $fecha_registro,				

					];

					

					ingresosContabilidadModelo::agregar_movimientos_contabilidad_modelo($datos_movimientos);

				

					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formIngresosContables",
						"id" => "pro_ingresos_contabilidad",
						"valor" => "Registro",	
						"funcion" => "listar_ingresos_contabilidad();printIngresos(".$ingresos_id.");total_ingreso_footer();",
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



		public function edit_ingresos_contabilidad_controlador(){

			$ingresos_id = $_POST['ingresos_id'];

			$clientes_id = $_POST['cliente_ingresos'];

			$factura = mainModel::cleanString($_POST['factura_ingresos']);

			$fecha = $_POST['fecha_ingresos'];

			$observacion = mainModel::cleanString($_POST['observacion_ingresos']);



			$datos = [

				"ingresos_id" => $ingresos_id,

				"clientes_id" => $clientes_id,

				"factura" => $factura,

				"fecha" => $fecha,

				"observacion" => $observacion,							

			];		

			

			$query = ingresosContabilidadModelo::edit_ingresos_contabilidad_modelo($datos);



			if($query){

				$alert = [

					"alert" => "clear",

					"title" => "Registro editado",

					"text" => "Registro editado correctamente",

					"type" => "success",

					"btn-class" => "btn-primary",

					"btn-text" => "¡Bien Hecho!",

					"form" => "formIngresosContables",

					"id" => "pro_ingresos_contabilidad",

					"valor" => "Registro",	

					"funcion" => "listar_ingresos_contabilidad();printIngresos(".$ingresos_id.");total_ingreso_footer();",

					"modal" => "modalIngresosContables",

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



			return mainModel::sweetAlert($alert);

		}



		public function cancel_egresos_contabilidad_controlador(){

			if(!isset($_SESSION['user_sd'])){ 

				session_start(['name'=>'SD']); 

			}

			

			$ingresos_id = $_POST['ingresos_id'];

			$proveedores_id = mainModel::cleanStringConverterCase($_POST['proveedor_ingresos']);

			$cuentas_id = mainModel::cleanStringConverterCase($_POST['cuenta_ingresos']);

			$empresa_id = mainModel::cleanStringConverterCase($_POST['empresa_ingresos']);

			$fecha = mainModel::cleanStringConverterCase($_POST['fecha_ingresos']);

			$factura = mainModel::cleanStringConverterCase($_POST['factura_ingresos']);

			$subtotal = mainModel::cleanStringConverterCase($_POST['subtotal_ingresos']);

			$isv = mainModel::cleanStringConverterCase($_POST['isv_ingresos']);

			$descuento = mainModel::cleanStringConverterCase($_POST['descuento_ingresos']);

			$nc = mainModel::cleanStringConverterCase($_POST['nc_ingresos']);

			$total = mainModel::cleanStringConverterCase($_POST['total_ingresos']);

			$observacion = mainModel::cleanStringConverterCase($_POST['observacion_ingresos']);

			$estado = 2;

			$colaboradores_id = $_SESSION['colaborador_id_sd'];

			$fecha_registro = date("Y-m-d H:i:s");	

			

			$datos = [

				"ingresos_id" => $ingresos_id,

				"proveedores_id" => $proveedores_id,

				"cuentas_id" => $cuentas_id,

				"empresa_id" => $empresa_id,

				"fecha" => $fecha,

				"factura" => $factura,

				"subtotal" => $subtotal,

				"isv" => $isv,

				"descuento" => $descuento,

				"nc" => $nc,

				"total" => $total,

				"observacion" => $observacion,

				"estado" => $estado,

				"fecha_registro" => $fecha_registro,				

			];

			

			$result_valid_ingresos = ingresosContabilidadModelo::valid_ingreso_cuentas_modelo($puestos_id);

			

			if($result_valid_puestos_colaborador_modelo->num_rows>0 ){

				$query = ingresosContabilidadModelo::cancel_ingresos_contabilidad_modelo($puestos_id);

								

				if($query){

					//CONSULTAMOS EL SALDO DISPONIBLE PARA LA CUENTA

					$consulta_ingresos_contabilidad = ingresosContabilidadModelo::consultar_saldo_movimientos_cuentas_contabilidad($cuentas_id)->fetch_assoc();

					$saldo_consulta = $consulta_ingresos_contabilidad['saldo'];	

					$ingreso = 0;

					$egreso = $total;

					$saldo = $saldo_consulta - $egreso;

					

					//AGREGAMOS LOS MOVIMIENTOS DE LA CUENTA

					$datos_movimientos = [

						"cuentas_id" => $cuentas_id,

						"empresa_id" => $empresa_id,

						"fecha" => $fecha,

						"ingreso" => $ingreso,

						"egreso" => $egreso,

						"saldo" => $saldo,

						"colaboradores_id" => $colaboradores_id,

						"fecha_registro" => $fecha_registro,				

					];

					

					ingresosContabilidadModelo::agregar_movimientos_contabilidad_modelo($datos_movimientos);

					

					$alert = [

						"alert" => "clear",

						"title" => "Registro eliminado",

						"text" => "El registro se ha eliminado correctamente",

						"type" => "success",

						"btn-class" => "btn-primary",

						"btn-text" => "¡Bien Hecho!",

						"form" => "formIngresosContables",

						"id" => "pro_ingresos_contabilidad",

						"valor" => "Eliminar",

						"funcion" => "listar_ingresos_contabilidad();total_ingreso_footer();",

						"modal" => "modalIngresosContables",

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

					"title" => "Este registro cuenta con información almacenada",

					"text" => "No se puede eliminar este registro",

					"type" => "error",	

					"btn-class" => "btn-danger",						

				];				

			}

			

			return mainModel::sweetAlert($alert);			

		}

	}