<?php
    if($peticionAjax){
        require_once "../modelos/productosModelo.php";
    }else{
        require_once "./modelos/productosModelo.php";
    }
	
	class productosControlador extends productosModelo{
		public function agregar_productos_controlador(){
			if(!isset($_SESSION['user_sd'])){ 
				session_start(['name'=>'SD']); 
			}
			
			$bar_code_product = mainModel::cleanStringStrtoupper($_POST['bar_code_product']);
			$almacen_id = mainModel::cleanStringConverterCase($_POST['almacen']);
			$medida_id = mainModel::cleanStringConverterCase($_POST['medida']);
			$categoria_id = mainModel::cleanStringConverterCase($_POST['producto_categoria']);
			$tipo_producto = mainModel::cleanStringConverterCase($_POST['tipo_producto']);			
			$nombre = mainModel::cleanString($_POST['producto']);
			$descripcion = mainModel::cleanString($_POST['descripcion']);			
			$cantidad = mainModel::cleanString($_POST['cantidad']);
			$precio_compra = mainModel::cleanString($_POST['precio_compra']);
			$porcentaje_venta = mainModel::cleanString($_POST['porcentaje_venta']);
			$precio_venta = mainModel::cleanString($_POST['precio_venta']);
			$cantidad_mayoreo = mainModel::cleanString($_POST['cantidad_mayoreo']);
			$precio_mayoreo = mainModel::cleanString($_POST['precio_mayoreo']);
			$cantidad_minima = mainModel::cleanString($_POST['cantidad_minima']);
			$cantidad_maxima = mainModel::cleanString($_POST['cantidad_maxima']);

			if($cantidad == ""){
				$cantidad = 0;
			}
			
			if($precio_compra == ""){
				$precio_compra = 0;
			}

			if($porcentaje_venta == ""){
				$porcentaje_venta = 0;
			}

			if($porcentaje_venta == ""){
				$porcentaje_venta = 0;
			}

			if($cantidad_minima == ""){
				$cantidad_minima = 0;
			}

			if($cantidad_maxima == ""){
				$cantidad_maxima = 0;
			}
			
			if($precio_mayoreo == ""){
				$precio_mayoreo = 0;
			}

			if (isset($_POST['almacen_empresa_id'])){
				$empresa = $_POST['almacen_empresa_id'];
			}else{
				$empresa = 1;
			}
			
			$colaborador_id = $_SESSION['colaborador_id_sd'];
			$fecha_registro = date("Y-m-d H:i:s");
			$file = "image_preview.png";
			$file_exist = 0;
			
			//FILE IMAGE
			if($_FILES['file']['name']!=""){
				//MOVEMOS LA IMAGEN EN LA CARPETA DE IMAGENES
				$file = $_FILES['file']['name'];
				$path = $_SERVER["DOCUMENT_ROOT"].PRODUCT_PATH.$file;
				if (file_exists($path)) {
					$file_exist = 1;
				}else{
					move_uploaded_file($_FILES['file']['tmp_name'],$path);
				}				
			}

			$estado = 1;

			if (isset($_POST['producto_isv_factura'])){
				$isv_venta = $_POST['producto_isv_factura'];
			}else{
				$isv_venta = 2;
			}	

			if (isset($_POST['producto_isv_compra'])){
				$isv_compra = $_POST['producto_isv_compra'];
			}else{
				$isv_compra = 2;
			}				

			$datos = [
				"bar_code_product" => $bar_code_product,
				"almacen_id" => $almacen_id,
				"medida_id" => $medida_id,
				"categoria_id" => $categoria_id,
				"tipo_producto" => $tipo_producto,				
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"cantidad" => $cantidad,
				"precio_compra" => $precio_compra,
				"porcentaje_venta" => $porcentaje_venta,
				"precio_venta" => $precio_venta,
				"cantidad_mayoreo" => $cantidad_mayoreo,
				"precio_mayoreo" => $precio_mayoreo,				
				"cantidad_minima" => $cantidad_minima,
				"cantidad_maxima" => $cantidad_maxima,				
				"colaborador_id" => $colaborador_id,
				"fecha_registro" => $fecha_registro,
				"estado" => $estado,
				"isv_venta" => $isv_venta,
				"isv_compra" => $isv_compra,				
				"file" => $file,
				"empresa" => $empresa,
			];
			
			//EVALUAMOS QUE LA VARIABLE DEL ARCHIVO ESTE EN FALSE PARA ALMACENAR EL REGISTRO
			if($file_exist == 0){
				$result = productosModelo::valid_productos_modelo($nombre);
				
				if($result->num_rows==0){
					$query = productosModelo::agregar_productos_modelo($datos);							
			
					if($query){
						$consulta_factura = productosModelo::consultar_codigo_producto($nombre)->fetch_assoc();
						$productos_id = $consulta_factura['productos_id'];					
						
						//CONSULTAMOS LA CATEGORIA DEL PRODUCTOS
						$tipo_productos = "";
						
						$result_tipo_producto = productosModelo::tipo_producto_modelo($productos_id);
						
						if($result_tipo_producto->num_rows > 0){
							$valores2 = $result_tipo_producto->fetch_assoc();

							$tipo_productos = $valores2['tipo_producto'];			
						}		

						$salida = 0;
						$datos_movimientos_productos = [
							"productos_id" => $productos_id,
							"cantidad_entrada" => $cantidad,				
							"cantidad_salida" => $salida,
							"saldo" => $cantidad,
							"fecha_registro" => $fecha_registro,
							"empresa" => $empresa,							
						];		
							
						if($cantidad > 0){
							if ($tipo_productos == "Producto" || $tipo_productos == "Insumos"){
								productosModelo::agregar_movimientos_productos_modelo($datos_movimientos_productos);
							}
						}
						
						$alert = [
							"alert" => "clear",
							"title" => "Registro almacenado",
							"text" => "El registro se ha almacenado correctamente",
							"type" => "success",
							"btn-class" => "btn-primary",
							"btn-text" => "¡Bien Hecho!",
							"form" => "formProductos",	
							"id" => "proceso_productos",
							"valor" => "Registro",
							"funcion" => "listar_productos();",
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
			}else{
				$alert = [
					"alert" => "simple",
					"title" => "Resgistro ya existe",
					"text" => "Lo sentimos el nombre de la imagen ya existe, por favor corregir",
					"type" => "error",	
					"btn-class" => "btn-danger",						
				];					
			}
			
			return mainModel::sweetAlert($alert);			
		}
		
		public function edit_productos_controlador(){;
			$productos_id = mainModel::cleanString($_POST['productos_id']);		
			$nombre = mainModel::cleanString($_POST['producto']);
			$descripcion = mainModel::cleanString($_POST['descripcion']);
			$precio_compra = mainModel::cleanString($_POST['precio_compra']);
			$porcentaje_venta = mainModel::cleanString($_POST['porcentaje_venta']);
			$precio_venta = mainModel::cleanString($_POST['precio_venta']);
			$precio_mayoreo = mainModel::cleanString($_POST['precio_mayoreo']);
			$cantidad_minima = mainModel::cleanString($_POST['cantidad_minima']);
			$cantidad_maxima = mainModel::cleanString($_POST['cantidad_maxima']);							
			$file = "image_preview.png";
			$file_exist = false;
			
			if($precio_mayoreo == ""){
				$precio_mayoreo = 0;
			}
						
			//FILE IMAGE
			if($_FILES['file']['name']!=""){
				//MOVEMOS LA IMAGEN EN LA CARPETA DE IMAGENES
				$file = $_FILES['file']['name'];
				$path = $_SERVER["DOCUMENT_ROOT"].PRODUCT_PATH.$file;
				
				if (file_exists($path)) {
					$file_exist = true;
				}else{
					move_uploaded_file($_FILES['file']['tmp_name'],$path);
				}				
			}
			
			if(isset($_POST['producto_activo'])){
				$estado = $_POST['producto_activo'];
			}else{
				$estado = 2;
			}

			if (isset($_POST['producto_isv_factura'])){
				$isv_venta = $_POST['producto_isv_factura'];
			}else{
				$isv_venta = 2;
			}	

			if (isset($_POST['producto_isv_compra'])){
				$isv_compra = $_POST['producto_isv_compra'];
			}else{
				$isv_compra = 2;
			}				

			$datos = [
				"productos_id" => $productos_id,
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"precio_compra" => $precio_compra,
				"porcentaje_venta" => $porcentaje_venta,
				"precio_venta" => $precio_venta,
				"precio_mayoreo" => $precio_mayoreo,
				"cantidad_minima" => $cantidad_minima,
				"cantidad_maxima" => $cantidad_maxima,				
				"estado" => $estado,
				"isv_venta" => $isv_venta,
				"isv_compra" => $isv_compra,
				"file" => $file				
			];
					
			$query = productosModelo::edit_productos_modelo($datos);
			
			if($query){				
				$alert = [
					"alert" => "edit",
					"title" => "Registro modificado",
					"text" => "El registro se ha modificado correctamente",
					"type" => "success",
					"btn-class" => "btn-primary",
					"btn-text" => "¡Bien Hecho!",
					"form" => "formProductos",	
					"id" => "proceso_productos",
					"valor" => "Editar",
					"funcion" => "listar_productos();",
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
			
			return mainModel::sweetAlert($alert);
		}
		
		public function edit_bodega_productos_controlador(){
			$productos_id = mainModel::cleanString($_POST['productos_id']);		
			$bodega = mainModel::cleanString($_POST['id_bodega']);
					
			$datos = [
				"productos_id" => $productos_id,
				"bodega" => $bodega						
			];
					
			$query = productosModelo::edit_bodega_productos_modelo($datos);
			
			if($query){
				$alert = [
					"alert" => "edit",
					"title" => "Registro modificado",
					"text" => "El registro se ha modificado correctamente",
					"type" => "success",
					"btn-class" => "btn-primary",
					"btn-text" => "¡Bien Hecho!",
					"form" => "formTransferencia",	
					"id" => "proceso_productos",
					"valor" => "Editar",
					"funcion" => "inventario_transferencia();",
					"modal" => "modal_transferencia_producto",
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

		public function delete_productos_controlador(){
			$productos_id = $_POST['productos_id'];
			
			$result_valid_productos_facturas = productosModelo::valid_productos_factura($productos_id);
			$result_valid_productos_compras = productosModelo::valid_productos_compras($productos_id);
			
			if($result_valid_productos_facturas->num_rows==0 || $result_valid_productos_compras->num_rows==0 ){
				$query = productosModelo::delete_productos_modelo($productos_id);
								
				if($query){
					$alert = [
						"alert" => "clear",
						"title" => "Registro eliminado",
						"text" => "El registro se ha eliminado correctamente",
						"type" => "success",
						"btn-class" => "btn-primary",
						"btn-text" => "¡Bien Hecho!",
						"form" => "formProductos",	
						"id" => "proceso_productos",
						"valor" => "Eliminar",
						"funcion" => "listar_productos();",
						"modal" => "modal_registrar_productos",
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