<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class pagoCompraModelo extends mainModel{
		protected function agregar_pago_compras_modelo($datos){
			$pagoscompras_id = mainModel::correlativo("pagoscompras_id", " pagoscompras");
			$insert = "INSERT INTO pagoscompras 
				VALUES('$pagoscompras_id','".$datos['compras_id']."','".$datos['tipo_pago']."','".$datos['fecha']."',
				'".$datos['importe']."','".$datos['efectivo']."','".$datos['cambio']."','".$datos['tarjeta']."',
				'".$datos['usuario']."','".$datos['estado']."','".$datos['empresa']."','".$datos['fecha_registro']."')";
				
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
		
			return $result;		
		}
		
		protected function agregar_pago_detalles_compras_modelo($datos){			
			$pagoscompras_detalles_id = mainModel::correlativo("pagoscompras_detalles_id", "pagoscompras_detalles");
			$insert = "INSERT INTO pagoscompras_detalles 
				VALUES('$pagoscompras_detalles_id','".$datos['pagoscompras_id']."','".$datos['tipo_pago_id']."','".$datos['banco_id']."','".$datos['efectivo']."','".$datos['descripcion1']."','".$datos['descripcion2']."','".$datos['descripcion3']."')";
				
			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function agregar_movimientos_contabilidad_modelo($datos){
			$movimientos_cuentas_id = mainModel::correlativo("movimientos_cuentas_id", "movimientos_cuentas");
			$insert = "INSERT INTO movimientos_cuentas VALUES('$movimientos_cuentas_id','".$datos['cuentas_id']."','".$datos['empresa_id']."','".$datos['fecha']."','".$datos['ingreso']."','".$datos['egreso']."','".$datos['saldo']."','".$datos['colaboradores_id']."','".$datos['fecha_registro']."')";
						
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		protected function agregar_egresos_contabilidad_modelo($datos){
			$egresos_id = mainModel::correlativo("egresos_id", "egresos");
			$insert = "INSERT INTO egresos VALUES('".$egresos_id ."','".$datos['cuentas_id']."','".$datos['proveedores_id']."','".$datos['empresa_id']."','".$datos['tipo_egreso']."','".$datos['fecha']."','".$datos['factura']."','".$datos['subtotal']."','".$datos['descuento']."','".$datos['nc']."','".$datos['isv']."','".$datos['total']."','".$datos['observacion']."','".$datos['estado']."','".$datos['colaboradores_id']."','".$datos['fecha_registro']."')";
	
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		protected function cancelar_pago_modelo($pagoscompras_id){
			$estado = 2;//FACTURA CANCELADA
			$update = "UPDATE pagoscompras
				SET
					estado = '$estado'
				WHERE pagoscompras_id = '$pagoscompras_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function consultar_codigo_pago_modelo($compras_id){
			$query = "SELECT pagoscompras_id
				FROM pagoscompras
				WHERE compras_id = '$compras_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function update_status_compras($compras_id){
			$estado = 2;//FACTURA PAGADA
			$update = "UPDATE compras
				SET
					estado = '$estado'
				WHERE compras_id = '$compras_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;					
		}
		
		protected function update_status_compras_cuentas_por_pagar($compras_id){
			$estado = 2;//PAGO REALIZADO
			$update = "UPDATE pagar_proveedores
				SET
					estado = '$estado'
				WHERE compras_id = '$compras_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;					
		}		
		
		protected function consultar_compra_cuentas_por_pagar($compras_id){
			$query = "SELECT compras_id
				FROM pagar_proveedores
				WHERE compras_id = '$compras_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}	

		protected function consultar_compra_fecha($compras_id){
			$query = "SELECT fecha
				FROM compras
				WHERE compras_id = '$compras_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}

		protected function valid_pagos_compras($compras_id){
			$query = "SELECT pagoscompras_id
				FROM pagoscompras
				WHERE compras_id = '$compras_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function valid_pagos_detalles_compras($pagos_id, $tipo_pago){
			$query = "SELECT pagoscompras_detalles_id
				FROM pagoscompras_detalles
				WHERE pagoscompras_id = '$pagos_id' AND tipo_pago_id = '$tipo_pago'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}	
		
		protected function valid_egresos_cuentas_modelo($datos){
			$query = "SELECT egresos_id FROM egresos WHERE factura = '".$datos['factura']."' AND proveedores_id = '".$datos['proveedores_id']."'";

			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		protected function consultar_cuenta_contabilidad_tipo_pago($tipo_pago_id){
			$query = "SELECT nombre, cuentas_id
				FROM tipo_pago
				WHERE tipo_pago_id = '$tipo_pago_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}	

		protected function consultar_proveedor_id_compra($compras_id){
			$query = "SELECT proveedores_id, number AS 'factura'
				FROM compras
				WHERE compras_id = '$compras_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}			

		protected function consultar_saldo_movimientos_cuentas_contabilidad($cuentas_id){
			$query = "SELECT ingreso, egreso, saldo
				FROM movimientos_cuentas
				WHERE cuentas_id = '$cuentas_id'
				ORDER BY movimientos_cuentas_id DESC LIMIT 1";
			
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;				
		}	
		
		protected function consulta_detalle_compras($compras_id){
			$result = mainModel::getMontoTipoPagoCompras($compras_id);
			
			return $result;			
		}		
	}