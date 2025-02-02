<?php
if ($peticionAjax) {
    require_once "../modelos/movimientoProductosModelo.php";
} else {
    require_once "./modelos/movimientoProductosModelo.php";
}

class movimientoProductosControlador extends movimientoProductosModelo
{
    public function agregar_movimiento_productos_controlador()
    {
        if (!isset($_SESSION['user_sd'])) {
            session_start(['name' => 'SD']);
        }

        $movimiento_producto = $_POST['movimiento_producto'];
        $movimiento_operacion = $_POST['movimiento_operacion'];
        $movimiento_cantidad = $_POST['movimiento_cantidad'];
        $movimiento_comentario = $_POST['movimiento_comentario'];
        $cliente_movimientos = $_POST['cliente_movimientos'] ?? 0;
        $almacen = $_POST['almacen_modal'];
        $empresa_id = $_SESSION['empresa_id_sd'];
        $fecha_vencimiento = !empty($_POST['movimiento_fecha_vencimiento']) ? $_POST['movimiento_fecha_vencimiento'] : null;

        // Validar empresa
        if (!$this->verificar_empresa($empresa_id)) {
            return mainModel::sweetAlert([
                "alert" => "simple",
                "title" => "Error",
                "text" => "El ID de empresa no es válido.",
                "type" => "error",
                "btn-class" => "btn-danger",
            ]);
        }

        // Calcular nuevo saldo según operación
        if ($movimiento_operacion == "entrada") { // ENTRADA
            $datos = [
                "productos_id" => $movimiento_producto,
                "clientes_id" => $cliente_movimientos ?: 0,
                "comentario" => $movimiento_comentario,
                "almacen_id" => $almacen ?: 0,
                "fecha_vencimiento" => $fecha_vencimiento,
                "cantidad" => $movimiento_cantidad,
                "empresa_id" => $empresa_id,
            ];

            $resultado = movimientoProductosModelo::registrar_entrada_lote_modelo($datos);

            if ($resultado['success']) {
                return mainModel::sweetAlert([
                    "alert" => "clear",
                    "title" => "Registro almacenado",
                    "text" => $resultado['message'],
                    "type" => "success",
                    "btn-class" => "btn-primary",
                    "btn-text" => "¡Bien Hecho!",
                    "form" => "formMovimientos",
                    "id" => "proceso_movimientos",
                    "valor" => "Registro",
                    "funcion" => "listar_movimientos();funciones();",
                    "modal" => "modal_movimientos", 
                ]);
            } else {
                return mainModel::sweetAlert([
                    "alert" => "simple",
                    "title" => "Error",
                    "text" => $resultado['message'],
                    "type" => "error",
                    "btn-class" => "btn-danger",
                ]);
            }
        }

        if ($movimiento_operacion == "salida") { // SALIDA
            $datos = [
                "productos_id" => $movimiento_producto,
                "clientes_id" => $cliente_movimientos ?: 0,
                "comentario" => $movimiento_comentario,
                "almacen_id" => $almacen ?: 0,
                "cantidad" => $movimiento_cantidad,
                "empresa_id" => $empresa_id
            ];

            $resultado = movimientoProductosModelo::registrar_salida_lote_modelo($datos);

            if ($resultado['status'] == "success") {
                return mainModel::sweetAlert([
                    "alert" => "clear",
                    "title" => "Registro almacenado",
                    "text" => $resultado['message'],
                    "type" => "success",
                    "btn-class" => "btn-primary",
                    "btn-text" => "¡Bien Hecho!",
                    "form" => "formMovimientos",
                    "id" => "proceso_movimientos",
                    "valor" => "Registro",
                    "funcion" => "listar_movimientos();",
                    "modal" => "modal_movimientos",
                ]);
            } else {
                return mainModel::sweetAlert([
                    "alert" => "simple",
                    "title" => "Error",
                    "text" => $resultado['message'],
                    "type" => "error",
                    "btn-class" => "btn-danger",
                ]);
            }
        }
    }

    /*public function agregar_movimiento_productos_controlador()
    {
        if (!isset($_SESSION['user_sd'])) {
            session_start(['name' => 'SD']);
        }

        $movimiento_producto = $_POST['movimiento_producto'];
        $movimiento_operacion = $_POST['movimiento_operacion'];
        $movimiento_cantidad = $_POST['movimiento_cantidad'];
        $movimiento_comentario = $_POST['movimiento_comentario'];
        $cliente_movimientos = $_POST['cliente_movimientos'];
        $almacen = $_POST['almacen_modal'];
        $empresa_id = $_SESSION['empresa_id_sd'];
        $fecha_vencimiento = $_POST['movimiento_fecha_vencimiento'] ?? null;
        $lote_id = 0;

        // Validar empresa
        if (!$this->verificar_empresa($empresa_id)) {
            return mainModel::sweetAlert([
                "alert" => "simple",
                "title" => "Error",
                "text" => "El ID de empresa no es válido.",
                "type" => "error",
                "btn-class" => "btn-danger",
            ]);
        }

        // Registrar lote si hay fecha de vencimiento
        if (!empty($fecha_vencimiento)) {
            $datos_lote = [
                "productos_id" => $movimiento_producto,
                "fecha_vencimiento" => $fecha_vencimiento,
                "cantidad" => $movimiento_cantidad,
                "empresa_id" => $empresa_id,
				"almacen_id" => $almacen ?: 0,
            ];
            $lote_id = movimientoProductosModelo::registrar_lote_modelo($datos_lote);
        }

        // Obtener saldo actual
        if ($lote_id > 0) {
            $saldo_actual = $this->getSaldoPorLote($movimiento_producto, $lote_id);
        } else {
            $saldo_actual = $this->getSaldoProductosMovimientos($movimiento_producto);
        }

        // Calcular nuevo saldo
        $cantidad_entrada = ($movimiento_operacion == "entrada") ? $movimiento_cantidad : 0;
        $cantidad_salida = ($movimiento_operacion == "salida") ? $movimiento_cantidad : 0;
        $saldo_nuevo = max(0, $saldo_actual + $cantidad_entrada - $cantidad_salida);

        $datos_movimiento = [
            "productos_id" => $movimiento_producto,
            "cantidad_entrada" => $cantidad_entrada,
            "cantidad_salida" => $cantidad_salida,
            "saldo" => $saldo_nuevo,
            "empresa" => $empresa_id,
            "clientes_id" => $cliente_movimientos ?: 0,
            "comentario" => $movimiento_comentario,
            "almacen_id" => $almacen ?: 0,
            "lote_id" => $lote_id
        ];

        $query = movimientoProductosModelo::agregar_movimiento_productos_modelo($datos_movimiento);

        return mainModel::sweetAlert([
			"alert" => "clear",
			"title" => "Registro almacenado",
			"text" => "Caja cerrada correctamente",
			"type" => "success",
			"btn-class" => "btn-primary",
			"btn-text" => "¡Bien Hecho!",
			"form" => "formMovimientos",
			"id" => "proceso_aperturaCaja",
			"valor" => "Registro",
			"funcion" => "listar_movimientos();",
			"modal" => "modal_movimientos",	
        ]);
    }*/
}