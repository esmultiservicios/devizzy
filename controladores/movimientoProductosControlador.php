<?php
    if($peticionAjax){
        require_once "../modelos/movimientoProductosModelo.php";
    }else{
        require_once "./modelos/movimientoProductosModelo.php";
    }
	
	class movimientoProductosControlador extends movimientoProductosModelo{
		public function agregar_movimiento_productos_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
			
			$movimiento_categoria = $_POST['movimientos_tipo_producto_id'];
			$movimiento_producto = $_POST['movimiento_producto'];
			$movimiento_operacion = $_POST['movimiento_operacion'];
			$movimiento_cantidad = $_POST['movimiento_cantidad'];
			$movimiento_comentario = $_POST['movimiento_comentario'];
			$cliente_movimientos = $_POST['cliente_movimientos'];
			$almacen = $_POST['almacen_modal'];


			$empresa_id = $_SESSION['empresa_id_sd'];
			$fecha_registro = $_POST['movimiento_fecha'];
			$cantidad = 0;
			$saldo = 0;
			
			//SI LA OPERACION ES INGRESO
			if($movimiento_operacion == 1){//INGRESO DE INVENTARIO			
				//INGRESAMOS EL NUEVO REGISTRO EN LA ENTIDAD MOVIMIENTOS
				$datos = [
					"productos_id" => $movimiento_producto,
					"cantidad_entrada" => $movimiento_cantidad,				
					"cantidad_salida" => 0,
					"saldo" => 0,
					"fecha_registro" => $fecha_registro,
					"empresa" => $empresa_id,
					"clientes_id" => $cliente_movimientos,
					"comentario"  => $movimiento_comentario,
					"almacen_id" => $almacen
				];	
				
				$query = movimientoProductosModelo::agregar_movimiento_productos_modelo($datos);
				
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formMovimientos",	
						"id" => "proceso_movimientos",
						"valor" => "Registro",
						"funcion" => "listar_movimientos();",
						"modal" => "modal_movimientos",
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
				//SALIDA DE PRODUCTO
				//INGRESAMOS EL NUEVO REGISTRO EN LA ENTIDAD MOVIMIENTOS				
				$datos = [
					"productos_id" => $movimiento_producto,
					"cantidad_entrada" => 0,				
					"cantidad_salida" => $movimiento_cantidad,
					"saldo" => 0,
					"fecha_registro" => $fecha_registro,
					"empresa" => $empresa_id,
					"clientes_id" => $cliente_movimientos,
					"comentario"  => $movimiento_comentario,
					"almacen_id" => $almacen
				];
				
				$query = movimientoProductosModelo::agregar_movimiento_productos_modelo($datos);
				
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro almacenado",
						"text" => "El registro se ha almacenado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formMovimientos",
						"id" => "proceso_movimientos",
						"valor" => "Registro",	
						"funcion" => "listar_movimientos();",
						"modal" => "modal_movimientos",
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
			}
			
			return mainModel::sweetAlert($alert);
		}
	}
?>	