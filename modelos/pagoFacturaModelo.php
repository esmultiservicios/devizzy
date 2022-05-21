<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";	
    }
	
	class pagoFacturaModelo extends mainModel{
		protected function agregar_pago_factura_modelo($datos){
			$pagos_id = mainModel::correlativo("pagos_id", "pagos");
			$insert = "INSERT INTO pagos 
				VALUES('$pagos_id','".$datos['facturas_id']."','".$datos['tipo_pago']."','".$datos['fecha']."','".$datos['importe']."','".$datos['cambio']."','".$datos['usuario']."','".$datos['estado']."','".$datos['empresa']."','".$datos['fecha_registro']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $result;		
		}
		
		protected function agregar_pago_detalles_factura_modelo($datos){			
			$pagos_detalles_id = mainModel::correlativo("pagos_detalles_id", "pagos_detalles");
			$insert = "INSERT INTO pagos_detalles 
				VALUES('$pagos_detalles_id','".$datos['pagos_id']."','".$datos['tipo_pago_id']."','".$datos['banco_id']."','".$datos['efectivo']."','".$datos['descripcion1']."','".$datos['descripcion2']."','".$datos['descripcion3']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function cancelar_pago_modelo($pagos_id){
			$estado = 2;//FACTURA CANCELADA
			$update = "UPDATE pagos
				SET
					estado = '$estado'
				WHERE pagos_id = '$pagos_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function consultar_codigo_pago_modelo($facturas_id){
			$query = "SELECT pagos_id
				FROM pagos
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;			
		}
		
		protected function update_status_factura($facturas_id){
			$estado = 2;//FACTURA PAGADA
			$update = "UPDATE facturas
				SET
					estado = '$estado'
				WHERE facturas_id = '$facturas_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;					
		}	

		protected function update_status_factura_cuentas_por_cobrar($facturas_id){
			$estado = 2;//PAGO REALIZADO
			$update = "UPDATE cobrar_clientes
				SET
					estado = '$estado'
				WHERE facturas_id = '$facturas_id'";
			
			$result = mainModel::connection()->query($update) or die(mainModel::connection()->error);
			
			return $result;					
		}		
		
		protected function consultar_factura_cuentas_por_cobrar($facturas_id){
			$query = "SELECT facturas_id
				FROM cobrar_clientes
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}	

		protected function consultar_factura_fecha($facturas_id){
			$query = "SELECT fecha
				FROM facturas
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function valid_pagos_factura($facturas_id){
			$query = "SELECT pagos_id
				FROM pagos
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}
		
		protected function valid_pagos_detalles_facturas($pagos_id, $tipo_pago){
			$query = "SELECT pagos_detalles_id
					FROM pagos_detalles
					WHERE pagos_id = '$pagos_id' AND tipo_pago_id = '$tipo_pago'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $result;				
		}
	}