<?php
    if($peticionAjax){
        require_once "../core/configAPP.php";
		require_once "../core/phpmailer/class.phpmailer.php";
		require_once "../core/phpmailer/class.smtp.php";
    }else{
        require_once "./core/configAPP.php";
		require_once "./core/phpmailer/class.phpmailer.php";
		require_once "./core/phpmailer/class.smtp.php";
    }

    class mainModel{
         /*FUNCTION QUE PERMITE REALIZAR LA CONEXIÓN A LA DB*/
        protected function connection(){
            $mysqli = new mysqli(SERVER, USER, PASS, DB);

            if ($mysqli->connect_errno) {
                echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                exit;
            }

			$mysqli->set_charset("utf8");

            return $mysqli;
        }
		
		public function consulta_total_ingreso($query){
			$result = self::connection()->query($query);
	
			return $result;
		}

		//FUNCION CORRELATIVO

		protected function correlativo($campo_id, $tabla){
			$query = "SELECT MAX(".$campo_id.") AS max, COUNT(".$campo_id.") AS count FROM ".$tabla;
			$result = self::connection()->query($query);
			$correlativo2 = $result->fetch_assoc();
			$numero = $correlativo2['max'];
			$cantidad = $correlativo2['count'];

			if ( $cantidad == 0 )

			   $numero = 1;

			else

			   $numero = $numero + 1;



			return $numero;

		}



		protected function guardar_bitacora($datos){

			$bitacora_id = self::correlativo("bitacora_id", "bitacora");



			$bitacoraCodigo = $datos['bitacoraCodigo'];

			$bitacoraFecha = $datos['bitacoraFecha'];

			$bitacoraHoraInicio = $datos['bitacoraHoraInicio'];

			$bitacoraHoraFinal = $datos['bitacoraHoraFinal'];

			$bitacoraTipo = $datos['bitacoraTipo'];

			$bitacoraYear = $datos['bitacoraYear'];

			$user_id = $datos['user_id'];
			$fecha_registro = date("Y-m-d H:i:s");

			$insert = "INSERT INTO bitacora

				VALUES('$bitacora_id','$bitacoraCodigo','$bitacoraFecha','$bitacoraHoraInicio','$bitacoraHoraFinal','$bitacoraTipo','$bitacoraYear','$user_id','$fecha_registro')";

			$result = self::connection()->query($insert) or die(self::connection()->error);



			return $result;

		}



		protected function actualizar_bitacora($bitacoraCodigo, $hora){

			$update = "UPDATE bitacora

				SET

					bitacoraHoraFinal = '$hora'

				WHERE bitacoraCodigo = '$bitacoraCodigo'";

			$result = self::connection()->query($update);



			return $result;

		}



		protected function eliminar_bitacora($user_id){

			$delte = "DELETE FROM bitacora WHERE user_id = '$user_id'";

			$result = self::connection()->query($update);



			return $result;

		}



		protected function getRealIP(){

			if (isset($_SERVER["HTTP_CLIENT_IP"])){

				return $_SERVER["HTTP_CLIENT_IP"];

			}elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){

				return $_SERVER["HTTP_X_FORWARDED_FOR"];

			}elseif (isset($_SERVER["HTTP_X_FORWARDED"])){

				return $_SERVER["HTTP_X_FORWARDED"];

			}elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){

				return $_SERVER["HTTP_FORWARDED_FOR"];

			}elseif (isset($_SERVER["HTTP_FORWARDED"])){

				return $_SERVER["HTTP_FORWARDED"];

			}else{

				return $_SERVER["REMOTE_ADDR"];

			}

		}



		function eliminar_acentos($cadena){

			//Reemplazamos la A y a

			$cadena = str_replace(

			array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),

			array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),

			$cadena

			);



			//Reemplazamos la E y e

			$cadena = str_replace(

			array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),

			array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),

			$cadena );



			//Reemplazamos la I y i

			$cadena = str_replace(

			array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),

			array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),

			$cadena );



			//Reemplazamos la O y o

			$cadena = str_replace(

			array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),

			array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),

			$cadena );



			//Reemplazamos la U y u

			$cadena = str_replace(

			array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),

			array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),

			$cadena );



			//Reemplazamos la N, n, C y c

			$cadena = str_replace(

			array('Ñ', 'ñ', 'Ç', 'ç'),

			array('N', 'n', 'C', 'c'),

			$cadena

			);



			return $cadena;

		}



		public function guardar_historial_accesos($comentario_){

			$nombre_host = self::getRealIP();

			$fecha = date("Y-m-d H:i:s");

			$comentario = mb_convert_case($comentario_, MB_CASE_TITLE, "UTF-8");

			$usuario = $_SESSION['colaborador_id_sd'];



			$historial_acceso_id  = self::correlativo("historial_acceso_id ", "historial_acceso");

			$insert = "INSERT INTO historial_acceso VALUES('$historial_acceso_id','$fecha','$usuario','$nombre_host','$comentario')";



			$result = self::connection()->query($insert);



			return $result;

		}



		public function anular_cotizacion($cotizacion_id){
			$update = "UPDATE cotizacion
			SET
				estado = 2
			WHERE cotizacion_id = '$cotizacion_id'";

			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);

			return $sql;
		}

		public function anular_factura($facturas_id){
			$update = "UPDATE facturas
			SET
				estado = 4
			WHERE facturas_id = '$facturas_id'";

			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);

			return $sql;
		}


		public function delete_bill_draft($facturas_id){
			$delete = "DELETE FROM facturas WHERE facturas_id = '$facturas_id' AND estado = 1";

			$sql = mainModel::connection()->query($delete) or die(mainModel::connection()->error);

			return $sql;			
		}

		public function anular_compra($compras_id){
			$update = "UPDATE compras
			SET
				estado = 4

			WHERE compras_id = '$compras_id'";

			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);

			return $sql;
		}

		public function anular_pago_factura($facturas_id){
			$update = "UPDATE pagos
			SET
				estado = 2
			WHERE facturas_id = '$facturas_id'";

			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);

			return $sql;
		}

		public function anular_pago_compras($compras_id){
			$update = "UPDATE pagoscompras
			SET
				estado = 2
			WHERE compras_id = '$compras_id'";

			$sql = mainModel::connection()->query($update) or die(mainModel::connection()->error);

			return $sql;
		}

		public function valid_pago_factura($facturas_id){
			$query = "SELECT pagos_id
				FROM pagos
				WHERE facturas_id = '$facturas_id'";

			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);

			return $sql;
		}

		public function abonos_cxc_cliente($facturas_id){
			$query = "SELECT
			pagos.facturas_id,
			pagos.fecha,
			pagos.importe as abono,
			pagos_detalles.descripcion1,
			facturas.importe,
			clientes.nombre as cliente,
            tipo_pago.nombre as tipo_pago,
			sf.prefijo AS 'prefijo', 
			sf.siguiente AS 'numero', 
			sf.relleno AS 'relleno',
			sf.prefijo AS 'prefijo',
			CONCAT(colaboradores.nombre, ' ', colaboradores.apellido) AS 'usuario'
			FROM pagos
			LEFT JOIN pagos_detalles ON pagos.pagos_id = pagos_detalles.pagos_id
			INNER JOIN facturas ON facturas.facturas_id = pagos.facturas_id
			INNER JOIN clientes ON facturas.clientes_id = clientes.clientes_id
            INNER JOIN tipo_pago ON pagos_detalles.tipo_pago_id = tipo_pago.tipo_pago_id
			INNER JOIN secuencia_facturacion AS sf ON facturas.secuencia_facturacion_id = sf.secuencia_facturacion_id
			INNER JOIN colaboradores ON pagos.usuario = colaboradores.colaboradores_id
			WHERE pagos.facturas_id = '$facturas_id'";
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);

			return $sql;
		}

		public function abonos_cxp_proveedor($facturas_id){
			$query = "SELECT
			pagoscompras.importe AS total,
			pagoscompras.pagoscompras_id,
			pagoscompras.compras_id,
			pagoscompras.tipo_pago,
			pagoscompras.fecha,
			pagoscompras.efectivo,
			pagoscompras.cambio,
			pagoscompras.tarjeta,
			pagoscompras.usuario,
			pagoscompras.estado,
			pagoscompras.empresa_id,
			pagoscompras.fecha_registro,
			proveedores.nombre,
			compras.importe,
			tipo_pago.nombre as tipoPago,
			pagoscompras_detalles.descripcion1,
			compras.number AS factura,
			CONCAT(colaboradores.nombre, ' ', colaboradores.apellido) AS 'usuario'
			FROM compras
			INNER JOIN pagoscompras ON compras.compras_id = pagoscompras.compras_id
			INNER JOIN pagoscompras_detalles ON pagoscompras_detalles.pagoscompras_id = pagoscompras.pagoscompras_id
			INNER JOIN tipo_pago ON pagoscompras_detalles.tipo_pago_id = tipo_pago.tipo_pago_id
			INNER JOIN proveedores ON proveedores.proveedores_id = compras.proveedores_id
			INNER JOIN colaboradores ON pagoscompras.usuario = colaboradores.colaboradores_id
			WHERE
				compras.compras_id ='$facturas_id'";

			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);

			return $sql;
		}


		public function valid_pago_compras($compras_id){
			$query = "SELECT pagoscompras_id
				FROM pagoscompras
				WHERE compras_id = '$compras_id'";

			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);

			return $sql;
		}

		//FUNCION PARA ENVIAR CORREO ELECTRONICO
		protected function sendEmail($server, $port, $SMTPSecure, $password, $from, $para, $asunto, $mensaje){

			$cabeceras = "MIME-Version: 1.0\r\n";

			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";

			$cabeceras .= "From: $from \r\n";



			$mail = new PHPMailer(); //creo un objeto de tipo PHPMailer

			$mail->SMTPDebug = 1;

			$mail->IsSMTP(); //protocolo SMTP

			$mail->IsHTML(true);

			$mail->CharSet = $CharSet;

			$mail->SMTPAuth = true;//autenticación en el SMTP

			$mail->SMTPSecure = $SMTPSecure;

			$mail->SMTPOptions = array(

				'ssl' => array(

					'verify_peer' => false,

					'verify_peer_name' => false,

					'allow_self_signed' => true

				)

			);

			$mail->Host = $server;//servidor de SMTP de gmail

			$mail->Port = $port;//puerto seguro del servidor SMTP de gmail

			$mail->From = $de; //Remitente del correo

			$mail->FromName = $from; //Remitente del correo

			$mail->AddAddress($para);// Destinatario

			$mail->AddCC($email_profesional);// Copia Destinatario

			$mail->Username = $de;//Aqui pon tu correo de gmail

			$mail->Password = $password;//Aqui pon tu contraseña de gmail

			$mail->Subject = $asunto; //Asunto del correo

			$mail->Body = $mensaje; //Contenido del correo

			$mail->WordWrap = 50; //No. de columnas

			$mail->MsgHTML($mensaje);//Se indica que el cuerpo del correo tendrá formato html



			if($para != ""){

			   if($mail->Send()){ //enviamos el correo por PHPMailer

				  $respuesta = "El mensaje ha sido enviado con la clase PHPMailer y tu cuenta de gmail =)";

				   $alert = [

						"alert" => "simple",

						"title" => "Correo enviado correctamente",

						"text" => "El correo se ha enviado de forma satisfactoria",

						"type" => "error",

						"btn-class" => "btn-primary",

					];

			   }else{

				   $alert = [

						"alert" => "simple",

						"title" => "Ocurrio un error inesperado",

						"text" => "El mensaje no se pudo enviar, verifique su conexión a Internet: Error: ".$mail->ErrorInfo."",

						"type" => "error",

						"btn-class" => "btn-danger",

					];

			   }

			}else{

			   $alert = [

					"alert" => "simple",

					"title" => "Ocurrio un error inesperado",

					"text" => "Lo sentimos no existe un destinatario al cual enviar el correo, por favor corregir: Error: ".$mail->ErrorInfo."",

					"type" => "error",

					"btn-class" => "btn-danger",

				];

			}



			return self::sweetAlert($alert);

		}



		protected function generar_password_complejo(){

		   $largo = 12;

		   $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		   $cadena_base .= '0123456789' ;

		   $cadena_base .= '!@#%^&()_,./<>?;:[]{}\|=+|*-';



		   $password = '';

		   $limite = strlen($cadena_base) - 1;



		   for ($i=0; $i < $largo; $i++)

			   $password .= $cadena_base[rand(0, $limite)];



		   return $password;

		}



         /*Funcion que permite encriptar string */

        public function encryption($string){

            $ouput = FALSE;

            $key=hash('sha256', SECRET_KEY);

            $iv = substr(hash('sha256', SECRET_IV), 0, 16);

            $output = openssl_encrypt($string, METHOD, $key, 0, $iv);

            $output = base64_encode($output);



            return $output;

        }



        /*Funcion que permite desencriptar string*/

        public function decryption($string){

            $key = hash('sha256', SECRET_KEY);

            $iv = substr(hash('sha256', SECRET_IV), 0, 16);

            $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);



            return $output;

        }



        /*Funcion que permite generar codigos aleatorios*/

        public function getRandom($word, $length, $number){

            for($i=1; $i<$length; $i++){

                $number = rand(0,9);

                $word .= $number;

            }



            return $word.$number;

        }



         /*Funcion que permite limpiar valores de los string (Inyección SQL)*/

        protected function cleanString($string){

            //Limpia espacios al inicio y al final

			$string =  trim($string);



            //Quita las barras de un string con comillas escapadas

            $string = stripslashes($string);



            //Limpiar etiquetas de JavaScript o Instrucciones SQL entre otros

            $string = str_ireplace("<script>", "", $string);

            $string = str_ireplace("</script>", "", $string);

            $string = str_ireplace("<script src>", "", $string);

            $string = str_ireplace("<script type>", "", $string);

            $string = str_ireplace("SELECT * FROM", "", $string);

            $string = str_ireplace("DELETE FROM", "", $string);

            $string = str_ireplace("INSERT INTO", "", $string);

            $string = str_ireplace("UPDATE", "", $string);

            $string = str_ireplace("--", "", $string);

            $string = str_ireplace("^", "", $string);

            $string = str_ireplace("]", "", $string);

            $string = str_ireplace("[", "", $string);

            $string = str_ireplace("{", "", $string);

            $string = str_ireplace("}", "", $string);

            $string = str_ireplace("==", "", $string);

			$string = str_ireplace("'", "", $string);



            return $string;

        }



        protected function cleanStringStrtolower($string){

            //Limpia espacios al inicio y al final

			$string =  strtolower(trim($string));



            //Quita las barras de un string con comillas escapadas

            $string = stripslashes($string);



            //Limpiar etiquetas de JavaScript o Instrucciones SQL entre otros

            $string = str_ireplace("<script>", "", $string);

            $string = str_ireplace("</script>", "", $string);

            $string = str_ireplace("<script src>", "", $string);

            $string = str_ireplace("<script type>", "", $string);

            $string = str_ireplace("SELECT * FROM", "", $string);

            $string = str_ireplace("DELETE FROM", "", $string);

            $string = str_ireplace("INSERT INTO", "", $string);

            $string = str_ireplace("UPDATE", "", $string);

            $string = str_ireplace("--", "", $string);

            $string = str_ireplace("^", "", $string);

            $string = str_ireplace("]", "", $string);

            $string = str_ireplace("[", "", $string);

            $string = str_ireplace("{", "", $string);

            $string = str_ireplace("}", "", $string);

            $string = str_ireplace("==", "", $string);

			$string = str_ireplace("'", "", $string);



            return $string;

        }



        protected function cleanStringStrtoupper($string){

            //Limpia espacios al inicio y al final

			$string =  strtoupper(trim($string));



            //Quita las barras de un string con comillas escapadas

            $string = stripslashes($string);



            //Limpiar etiquetas de JavaScript o Instrucciones SQL entre otros

            $string = str_ireplace("<script>", "", $string);

            $string = str_ireplace("</script>", "", $string);

            $string = str_ireplace("<script src>", "", $string);

            $string = str_ireplace("<script type>", "", $string);

            $string = str_ireplace("SELECT * FROM", "", $string);

            $string = str_ireplace("DELETE FROM", "", $string);

            $string = str_ireplace("INSERT INTO", "", $string);

            $string = str_ireplace("UPDATE", "", $string);

            $string = str_ireplace("--", "", $string);

            $string = str_ireplace("^", "", $string);

            $string = str_ireplace("]", "", $string);

            $string = str_ireplace("[", "", $string);

            $string = str_ireplace("{", "", $string);

            $string = str_ireplace("}", "", $string);

            $string = str_ireplace("==", "", $string);

			$string = str_ireplace("'", "", $string);



            return $string;

        }



        protected function cleanStringConverterCase($string){

            //Limpia espacios al inicio y al final

			$string =  mb_convert_case(trim($string), MB_CASE_TITLE, "UTF-8");



            //Quita las barras de un string con comillas escapadas

            $string = stripslashes($string);



            //Limpiar etiquetas de JavaScript o Instrucciones SQL entre otros

            $string = str_ireplace("<script>", "", $string);

            $string = str_ireplace("</script>", "", $string);

            $string = str_ireplace("<script src>", "", $string);

            $string = str_ireplace("<script type>", "", $string);

            $string = str_ireplace("SELECT * FROM", "", $string);

            $string = str_ireplace("DELETE FROM", "", $string);

            $string = str_ireplace("INSERT INTO", "", $string);

            $string = str_ireplace("UPDATE", "", $string);

            $string = str_ireplace("--", "", $string);

            $string = str_ireplace("^", "", $string);

            $string = str_ireplace("]", "", $string);

            $string = str_ireplace("[", "", $string);

            $string = str_ireplace("{", "", $string);

            $string = str_ireplace("}", "", $string);

            $string = str_ireplace("==", "", $string);

			$string = str_ireplace("'", "", $string);



            return $string;

        }

        protected function sweetAlert($datos){
            if($datos['alert'] == "simple"){
                $alerta = "
                    <script>
                        swal({
                            title: '".$datos['title']."',
                            text: '".$datos['text']."',
                            type: '".$datos['type']."',
                            confirmButtonClass: '".$datos['btn-class']."',
							allowEscapeKey: false,
							allowOutsideClick: false
                        });
                    </script>
                ";
            }elseif($datos['alert'] == "reload"){
                $alerta = "
                    <script>
                        swal({
                            title: '".$datos['title']."',
                            text: '".$datos['text']."',
                            type: '".$datos['type']."',
                            showCancelButton: true,
							timer: 3000,
                            confirmButtonClass: '".$datos['btn-class']."',
                            confirmButtonText: '".$datos['btn-text']."',
                            closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
                        },
                        function(){
                            location.reload();
                        });
                    </script>
                ";
            }elseif($datos['alert'] == "cerrar"){
                $alerta = "
                    <script>
                        swal({
                            title: '".$datos['title']."',
                            text: '".$datos['text']."',
                            type: '".$datos['type']."',
                            showCancelButton: true,
							timer: 3000,
                            confirmButtonClass: '".$datos['btn-class']."',
                            confirmButtonText: '".$datos['btn-text']."',
                            closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
                        },
                        function(dismiss){
                            redireccionar();
							if(dismiss == 'cancel'){
								redireccionar();
							}
                        });
                    </script>
                ";
				self::cerrar_sesion();
            }elseif($datos['alert'] == "clear"){
                $alerta = "
                    <script>
						swal({
							title: '".$datos['title']."',
							text: '".$datos['text']."',
							type: '".$datos['type']."',
							showCancelButton: false,
							timer: 3000,
							confirmButtonClass: '".$datos['btn-class']."',
							confirmButtonText: '".$datos['btn-text']."',
							closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
						});

						$('#".$datos['form']."')[0].reset();
						$('#".$datos['form']." #".$datos['id']."').val('".$datos['valor']."');
						".$datos['funcion'].";
						$('#".$datos['modal']."').modal('hide');
                    </script>
                ";
            }elseif($datos['alert'] == "clear_pay"){
                $alerta = "
                    <script>
						swal({
							title: '".$datos['title']."',
							text: '".$datos['text']."',
							type: '".$datos['type']."',
							showCancelButton: false,
							confirmButtonClass: '".$datos['btn-class']."',
							confirmButtonText: '".$datos['btn-text']."',
							closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
						});
						location.reload();
						$('#".$datos['form']."')[0].reset();
						$('#".$datos['form']." #".$datos['id']."').val('".$datos['valor']."');
						".$datos['funcion'].";
						$('#".$datos['modal']."').modal('hide');
                    </script>
                ";
            }elseif($datos['alert'] == "save_simple"){
                $alerta = "
                    <script>
						swal({
							title: '".$datos['title']."',
							text: '".$datos['text']."',
							type: '".$datos['type']."',
							showCancelButton: false,
							timer: 3000,
							confirmButtonClass: '".$datos['btn-class']."',
							confirmButtonText: '".$datos['btn-text']."',
							closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
						});

						$('#".$datos['form']."')[0].reset();
						$('#".$datos['form']." #".$datos['id']."').val('".$datos['valor']."');
						".$datos['funcion'].";
						$('#".$datos['modal']."').modal('hide');
                    </script>
                ";
            }elseif($datos['alert'] == "save"){
                $alerta = "
                    <script>
						swal({
							title: '".$datos['title']."',
							text: '".$datos['text']."',
							type: '".$datos['type']."',
							showCancelButton: false,
							timer: 3000,
							confirmButtonClass: '".$datos['btn-class']."',
							confirmButtonText: '".$datos['btn-text']."',
							closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
						});

					    $('#".$datos['form']."')[0].reset();
					    $('#".$datos['form']." #".$datos['id']."').val('".$datos['valor']."');
					    ".$datos['funcion'].";
                    </script>

                ";

            }elseif($datos['alert'] == "delete"){
                $alerta = "
                    <script>
						swal({
							title: '".$datos['title']."',
							text: '".$datos['text']."',
							type: '".$datos['type']."',
							showCancelButton: false,
							timer: 3000,
							confirmButtonClass: '".$datos['btn-class']."',
							confirmButtonText: '".$datos['btn-text']."',
							closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
						});

					    $('#".$datos['form']."')[0].reset();
					    $('#".$datos['form']." #".$datos['id']."').val('".$datos['valor']."');
					    ".$datos['funcion'].";
					    $('#".$datos['modal']."').modal('hide');
                    </script>
                ";
            }elseif($datos['alert'] == "edit"){
                $alerta = "
                    <script>
						swal({
							title: '".$datos['title']."',
							text: '".$datos['text']."',
							type: '".$datos['type']."',
							showCancelButton: false,
							timer: 3000,
							confirmButtonClass: '".$datos['btn-class']."',
							confirmButtonText: '".$datos['btn-text']."',
							closeOnConfirm: false,
							allowEscapeKey: false,
							allowOutsideClick: false
						});

					    $('#".$datos['form']." #".$datos['id']."').val('".$datos['valor']."');
					    ".$datos['funcion'].";
					    $('#".$datos['modal']."').modal('hide');
                    </script>
                ";
            }

			return $alerta;
        }

		function cerrar_sesion(){
			if(!isset($_SESSION['user_sd'])){
				session_start(['name'=>'SD']);

			}

			$token = self::decryption($_SESSION['token_sd']);
			$hora = date("H:m:s");
			$usuario = $_SESSION['user_sd'];
			$token_s = $_SESSION['token_sd'];
			$token = $token;
			$codigo = $_SESSION['codigo_bitacora_sd'];
			self::guardar_historial_accesos("Cierre de Sesion");
			session_unset();//VACIAR LA SESION
			session_destroy();//DESTRUIR LA SESION

			window.location(SERVERURL."login/");
		}

		public function getProductoBarCodeBill($barCode){

			$query = "SELECT productos_id, nombre, precio_venta, isv_venta, precio_mayoreo, cantidad_mayoreo

				FROM productos

				WHERE estado = 1 AND barCode = '$barCode'

				ORDER BY descripcion";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getCategoriaProductos(){

			$query = "SELECT categoria_id, nombre

				FROM categoria

				WHERE estado = 1";

			$result = self::connection()->query($query);



			return $result;

		}



		/*INICIO CONVERTIR COTIZACION A FACTURA*/

		public function correlativoEntidades($campo_id, $tabla){

			$query = "SELECT MAX(".$campo_id.") AS max, COUNT(".$campo_id.") AS count FROM ".$tabla;

			$result = self::connection()->query($query);



			$correlativo2 = $result->fetch_assoc();



			$numero = $correlativo2['max'];

			$cantidad = $correlativo2['count'];



			if ( $cantidad == 0 )

			   $numero = 1;

			else

			   $numero = $numero + 1;



			return $numero;

		}



		public function actualizarCotizacionFactura($cotizacion_id){

			$query = "UPDATE cotizacion

				SET

					estado = '3'

				WHERE cotizacion_id = '$cotizacion_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getCotizacionFactura($cotizacion_id){

			$query = "SELECT clientes_id, colaboradores_id, importe, notas

				FROM cotizacion

				WHERE cotizacion_id = '$cotizacion_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getCotizacionDetallesFactura($cotizacion_id){

			$query = "SELECT productos_id, cantidad, precio, isv_valor, descuento

				FROM cotizacion_detalles

				WHERE cotizacion_id = '$cotizacion_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function secuencia_facturacion($empresa_id){

			$query = "SELECT secuencia_facturacion_id, prefijo, siguiente AS 'numero', rango_final, fecha_limite, incremento, relleno

			   FROM secuencia_facturacion

			   WHERE activo = '1' AND empresa_id = '$empresa_id'";

			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);



			return $result;

		}



		public function agregar_facturas($datos){

			$insert = "INSERT INTO facturas

				VALUES('".$datos['facturas_id']."','".$datos['clientes_id']."','".$datos['secuencia_facturacion_id']."','".$datos['apertura_id']."','".$datos['numero']."','".$datos['tipo_factura']."','".$datos['colaboradores_id']."','".$datos['importe']."','".$datos['notas']."','".$datos['fecha']."','".$datos['estado']."','".$datos['usuario']."','".$datos['empresa']."','".$datos['fecha_registro']."')";



			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);



			return $result;

		}



		public function agregar_detalle_facturas($datos){

			$facturas_detalle_id = mainModel::correlativo("facturas_detalle_id", "facturas_detalles");

			$insert = "INSERT INTO facturas_detalles

				VALUES('$facturas_detalle_id','".$datos['facturas_id']."','".$datos['productos_id']."','".$datos['cantidad']."','".$datos['precio']."','".$datos['isv_valor']."','".$datos['descuento']."')";

			$result = mainModel::connection()->query($insert) or die(mainModel::connection()->error);



			return $result;

		}



		public function getAperturaID($datos){

			$query = "SELECT apertura_id

				FROM apertura

				WHERE colaboradores_id = '".$datos['colaboradores_id']."' AND fecha = '".$datos['fecha']."' AND estado = '".$datos['estado']."'";



			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);



			return $result;

		}

		/*FIN CONVERTIR COTIZACION A FACTURA*/

		public function getEmpresa(){
			$query = "SELECT *
				FROM empresa
				WHERE estado = 1
				ORDER BY nombre";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getDocumento(){
			$query = "SELECT *
				FROM documento
				WHERE estado = 1
				ORDER BY nombre";

			$result = self::connection()->query($query);

			return $result;
		}		

		public function getCuenta(){
			$query = "SELECT *
				FROM cuentas
				WHERE estado = 1
				ORDER BY nombre";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getTipoCuenta(){
			$query = "SELECT *
				FROM tipo_cuenta
				WHERE estado = 1
				ORDER BY nombre";
			echo $query."***";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getProveedoresConsulta(){
			$query = "SELECT *
				FROM proveedores
				WHERE estado = 1
				ORDER BY nombre";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getClientesConsulta(){
			$query = "SELECT *
				FROM clientes
				WHERE estado = 1
				ORDER BY nombre";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getColaboradoresConsulta(){
			$query = "SELECT colaboradores_id, CONCAT(nombre, ' ', apellido) AS 'nombre'
				FROM colaboradores
				WHERE estado = 1 AND colaboradores_id NOT IN(1)
				ORDER BY nombre";
			$result = self::connection()->query($query);

			return $result;
		}		

		public function getDepartamentos(){
			$query = "SELECT *
				FROM departamentos";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getMunicipios($departamentos_id){
			$query = "SELECT *
				FROM municipios WHERE departamentos_id  = '$departamentos_id'";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getFacturador(){
			$query = "SELECT c.colaboradores_id AS 'colaboradores_id', CONCAT(c.nombre, ' ', c.apellido) AS 'nombre', c.identidad AS 'identidad'
			FROM facturas AS f
			INNER JOIN colaboradores AS c
			ON f.usuario = c.colaboradores_id
			GROUP BY f.usuario";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getClientesCXC(){
			$query = "SELECT c.clientes_id AS 'clientes_id', c.nombre AS 'nombre'
			FROM cobrar_clientes AS cc
			INNER JOIN clientes AS c
			ON cc.clientes_id = c.clientes_id
			GROUP BY c.nombre";
			$result = self::connection()->query($query);

			return $result;
		}

		public function saldo_factura_cuentas_por_cobrar($facturas_id){
			$query = "SELECT *
				FROM cobrar_clientes
				WHERE facturas_id = '$facturas_id'";
			$result = mainModel::connection()->query($query) or die(mainModel::connection()->error);
		
			return $result;				
		}	
		
		public function getProveedoresCXP(){
			$query = "SELECT p.proveedores_id AS 'proveedores_id', p.nombre AS 'nombre'
			FROM pagar_proveedores AS pp
			INNER JOIN proveedores AS p
			ON pp.proveedores_id = p.proveedores_id
			GROUP BY p.nombre;";
			$result = self::connection()->query($query);

			return $result;
		}		

		public function getTipoUsuario($datos){

			if($datos['privilegio_id'] == 1){

				$where = "WHERE estado = 1";

			}else{

				$where = "WHERE estado = 1 AND tipo_user_id NOT IN(1)";

			}



			$query = "SELECT *

				FROM tipo_user

				".$where;

			$result = self::connection()->query($query);



			return $result;

		}



		public function getPrivilegio($datos){
			if($datos['privilegio_id'] == 1){
				$where = "WHERE estado = 1";
			}else{
				$where = "WHERE estado = 1 AND privilegio_id NOT IN(1)";
			}

			$query = "SELECT *
				FROM privilegio
				".$where."";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getCajas($datos){
			$fecha = date("Y-m-d");

			if($datos['fechai'] == $fecha){
				$where = "WHERE a.estado = '".$datos['estado']."'";
			}else{
				if($datos['privilegio_id'] == 1 || $datos['privilegio_id'] == 2){
					$where = "WHERE a.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND a.estado = '".$datos['estado']."'";
				}else{
					$where = "WHERE a.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND a.colaboradores_id = '".$datos['colaborador_id']."' AND a.estado = '".$datos['estado']."'";
				}
			}

			$query = "SELECT a.fecha AS 'fecha', a.factura_inicial AS 'factura_inicial', a.factura_final AS 'factura_final', a.apertura AS 'monto_apertura', (CASE WHEN a.estado = '1' THEN 'Activa' ELSE 'Inactiva' END) AS 'caja', CONCAT(c.nombre, ' ', c.apellido) AS 'usuario', a.colaboradores_id AS 'colaboradores_id', a.apertura_id AS 'apertura_id'
				FROM apertura AS a
				INNER JOIN colaboradores AS c
				ON a.colaboradores_id = c.colaboradores_id
				".$where;

			$result = self::connection()->query($query);

			return $result;
		}

		public function getFacturaInicial($apertura_id){

			$query = "SELECT f.number AS 'numero', sf.prefijo AS 'prefijo', sf.relleno As 'relleno'

				FROM facturas AS f

				INNER JOIN secuencia_facturacion AS sf

				ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id

				WHERE apertura_id = '$apertura_id' AND estado = 2

				ORDER BY f.number ASC LIMIT 1";

			$result = self::connection()->query($query);


			return $result;

		}

		public function getSaldoMovimientosCuentasSaldoAnterior($cuentas_id, $año, $mes){
			$query = "SELECT saldo
				FROM movimientos_cuentas
				WHERE YEAR(fecha_registro) = '$año' AND MONTH(fecha_registro) = '$mes' AND cuentas_id = '$cuentas_id'
				ORDER BY movimientos_cuentas_id DESC LIMIT 1";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getSaldoMovimientosCuentasUltimoSaldo($cuentas_id){
			$query = "SELECT saldo, fecha_registro
				FROM movimientos_cuentas
				WHERE cuentas_id = '$cuentas_id'
				ORDER BY movimientos_cuentas_id DESC LIMIT 1";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getSaldoMovimientosCuentasUltimaFecha($cuentas_id, $fecha_registro){
			$query = "SELECT saldo, fecha_registro
				FROM movimientos_cuentas
				WHERE cuentas_id = '$cuentas_id' AND MONTH(fecha_registro) = MONTH('$fecha_registro')
				ORDER BY movimientos_cuentas_id DESC LIMIT 1";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getFacturaFinal($apertura_id){
			$query = "SELECT f.number AS 'numero', sf.prefijo AS 'prefijo', sf.relleno As 'relleno'
				FROM facturas AS f
				INNER JOIN secuencia_facturacion AS sf
				ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id
				WHERE apertura_id = '$apertura_id' AND estado = 2
				ORDER BY f.number DESC LIMIT 1";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getImporteVentaporUsuario($apertura_id){

			$query = "SELECT SUM(importe) AS 'importe'

				FROM facturas AS f

				WHERE apertura_id = '$apertura_id' AND estado = 2";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getPuestoColaboradores(){

			$query = "SELECT *

				FROM puestos

				WHERE estado = 1";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getUserSession($colaboradores_id){

			$query = "SELECT nombre, apellido

				FROM colaboradores

				WHERE colaboradores_id = '$colaboradores_id'";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getBitacora($fechai, $fechaf){

			$query = "SELECT b.bitacoraCodigo AS 'bitacoraCodigo', DATE_FORMAT(b.bitacoraFecha, '%d/%m/%Y') AS 'bitacoraFecha', b.bitacoraHoraInicio As 'bitacoraHoraInicio', b.bitacoraHoraFinal AS 'bitacoraHoraFinal', tu.nombre AS 'bitacoraTipo', b.bitacoraYear AS 'bitacoraYear', CONCAT(c.nombre,' ',c.apellido) AS 'colaborador'

				FROM bitacora AS b

				INNER JOIN tipo_user AS tu

				ON b.bitacoraTipo = tu.tipo_user_id

				INNER JOIN colaboradores AS c

				ON b.colaboradores_id = c.colaboradores_id

				WHERE b.bitacoraFecha BETWEEN '$fechai' AND '$fechaf'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getHistorialAccesos($fechai, $fechaf){

			$query = "SELECT ha.historial_acceso_id AS 'historial_acceso_id', DATE_FORMAT(ha.fecha, '%d/%m/%Y %H:%i:%s') AS 'fecha', CONCAT(c.nombre, ' ', c.apellido) As 'colaborador', ha.ip AS 'ip', ha.acceso AS 'acceso'

				FROM historial_acceso AS ha

				INNER JOIN colaboradores AS c

				ON ha.colaboradores_id = c.colaboradores_id

				WHERE CAST(ha.fecha AS DATE) BETWEEN '$fechai' AND '$fechaf'

				ORDER BY ha.fecha DESC";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getClientes(){

			$query = "SELECT c.clientes_id AS 'clientes_id', c.nombre AS 'cliente', c.rtn AS 'rtn' , c.localidad AS 'localidad', c.telefono AS 'telefono', c.correo AS 'correo', d.nombre AS 'departamento', m.nombre AS 'municipio', c.rtn AS 'rtn'

				FROM clientes AS c

				INNER JOIN departamentos AS d

				ON c.departamentos_id = d.departamentos_id

				INNER JOIN municipios AS m

				ON c.municipios_id = m.municipios_id

				WHERE c.estado = 1";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getProveedores(){

			$query = "SELECT p.proveedores_id AS 'proveedores_id', p.nombre AS 'proveedor', p.rtn AS 'rtn' , p.localidad AS 'localidad', p.telefono AS 'telefono', p.correo AS 'correo', d.nombre AS 'departamento', m.nombre AS 'municipio'

				FROM proveedores AS p

				INNER JOIN departamentos AS d

				ON p.departamentos_id = d.departamentos_id

				INNER JOIN municipios AS m

				ON p.municipios_id = m.municipios_id

				WHERE p.estado = 1

				ORDER BY p.nombre";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getColaboradores(){
			$query = "SELECT c.colaboradores_id AS 'colaborador_id', CONCAT(c.nombre, ' ', c.apellido) AS 'colaborador', c.identidad AS 'identidad',
				CASE WHEN c.estado = 1 THEN 'Activo' ELSE 'Inactivo' END AS 'estado', c.telefono AS 'telefono', e.nombre AS 'empresa'
				FROM colaboradores AS c
				INNER JOIN empresa AS e
				ON c.empresa_id = e.empresa_id
				WHERE c.estado = 1 AND c.colaboradores_id NOT IN(1)
				ORDER BY CONCAT(c.nombre, ' ', c.apellido)";
			$result = self::connection()->query($query);
			return $result;
		}

		public function getPuestos(){
			$query = "SELECT *
				FROM puestos
				WHERE estado = 1
				ORDER BY nombre";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getTipoContrato(){
			$query = "SELECT *
				FROM tipo_contrato
				ORDER BY nombre";

			$result = self::connection()->query($query);

			return $result;
		}	

		public function getTipoNomina(){
			$query = "SELECT *
				FROM tipo_nomina
				ORDER BY nombre";

			$result = self::connection()->query($query);

			return $result;
		}			
		
		public function getPagoPlanificado(){
			$query = "SELECT *
				FROM pago_planificado
				ORDER BY nombre";

			$result = self::connection()->query($query);

			return $result;
		}
		
		public function getTipoEmpleado(){
			$query = "SELECT *
				FROM tipo_empleado
				ORDER BY nombre DESC";

			$result = self::connection()->query($query);

			return $result;
		}		

		public function getEmpleadoContrato(){
			$query = "SELECT colaboradores_id aS 'colaborador_id', CONCAT(nombre, ' ', apellido) AS 'nombre', c.identidad AS 'identidad'
				FROM colaboradores AS c 
				WHERE estado = 1 AND colaboradores_id NOT IN(1)
				ORDER BY Nombre";
				
			$result = self::connection()->query($query);

			return $result;
		}	

		public function getEmpleadoContratoEdit($colaboradores_id){
			$query = "SELECT c.colaborador_id AS colaborador_id, CONCAT(co.nombre, ' ', co.apellido) AS 'nombre', co.identidad AS 'identidad', p.nombre AS 'puesto', c.contrato_id AS 'contrato_id', c.salario AS 'salario', co.fecha_ingreso AS 'fecha_ingreso', c.tipo_empleado_id AS 'tipo_empleado_id', c.pago_planificado_id AS 'pago_planificado_id'
				FROM contrato AS c
				INNER JOIN colaboradores AS co ON c.colaborador_id = co.colaboradores_id
				INNER JOIN puestos AS p ON co.puestos_id = p.puestos_id
				WHERE c.colaborador_id = '".$colaboradores_id."'
				ORDER BY co.nombre";

			$result = self::connection()->query($query);

			return $result;
		}
		
		public function getTotalesNominaDetalle($nomina_id){
			$query = "SELECT SUM(nd.neto_ingresos) AS 'neto_ingresos', SUM(nd.neto_egresos) AS 'neto_egresos', SUM(nd.neto) AS 'neto'
				FROM nomina_detalles AS nd
				INNER JOIN nomina AS n ON nd.nomina_id = n.nomina_id
				WHERE nd.nomina_id = ".$nomina_id;

			$result = self::connection()->query($query);

			return $result;
		}		

		public function actualizarNomina($nomina_id, $importe){
			$update = "UPDATE nomina
				SET
					estado = 1,
					importe = ".$importe."
				WHERE nomina_id = '".$nomina_id."'";

			$result = self::connection()->query($update);

			return $result;					
		}

		public function actualizarNominaDetalles($nomina_id){
			$update = "UPDATE nomina_detalles
			SET
				estado = 1
			WHERE nomina_id = '".$nomina_id."'";

			$result = self::connection()->query($update);

			return $result;	
		}		
		
		public function getEmpleado(){
			$query = "SELECT co.colaborador_id AS 'colaboradores_id', CONCAT(nombre, ' ', apellido) AS 'nombre'
			FROM contrato AS co
			INNER JOIN colaboradores AS c ON co.colaborador_id = c.colaboradores_id
			WHERE c.estado = 1";
				
			$result = self::connection()->query($query);
		
			return $result;
		}
		
		public function getCuentaNomina($nombre){
			$query = "SELECT cuentas_id
			FROM diarios
			WHERE nombre = '".$nombre."'";

			$result = self::connection()->query($query);
		
			return $result;
		}		

		public function agregarEgresosMainModel($datos){
			$egresos_id = mainModel::correlativo("egresos_id", "egresos");
			$insert = "INSERT INTO egresos VALUES('".$egresos_id."','".$datos['cuentas_id']."','".$datos['proveedores_id']."','".$datos['empresa_id']."','".$datos['tipo_egreso']."','".$datos['fecha']."','".$datos['factura']."','".$datos['subtotal']."','".$datos['descuento']."','".$datos['nc']."','".$datos['isv']."','".$datos['total']."','".$datos['observacion']."','".$datos['estado']."','".$datos['colaboradores_id']."','".$datos['fecha_registro']."')";

			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}
		
		public function agregarMovimientosMainModel($datos){
			$movimientos_cuentas_id = mainModel::correlativo("movimientos_cuentas_id", "movimientos_cuentas");
			$insert = "INSERT INTO movimientos_cuentas VALUES('$movimientos_cuentas_id','".$datos['cuentas_id']."','".$datos['empresa_id']."','".$datos['fecha']."','".$datos['ingreso']."','".$datos['egreso']."','".$datos['saldo']."','".$datos['colaboradores_id']."','".$datos['fecha_registro']."')";
			
			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}	
		
		public function consultaSaldoMovimientosMainModel($cuentas_id){
			$query = "SELECT ingreso, egreso, saldo
				FROM movimientos_cuentas
				WHERE cuentas_id = '$cuentas_id'
				ORDER BY movimientos_cuentas_id DESC LIMIT 1";
			
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;				
		}		

		public function validEgresosCuentasMainModel($datos){
			$query = "SELECT egresos_id FROM egresos WHERE factura = '".$datos['factura']."' AND proveedores_id = '".$datos['proveedores_id']."'";
			
			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		public function getContratoEdit($datos){
			$query = "SELECT *
			FROM contrato";
				
			$result = self::connection()->query($query);
		
			return $result;
		}

		public function getContrato($datos){
			$estado = '';			
			$tipo_contrato = '';
			$pago_planificado_id = '';
			$tipo_empleado = '';


			if($datos['tipo_contrato'] != "" || $datos['tipo_contrato'] != 0){
				$tipo_contrato = "AND c.tipo_contrato_id = '".$datos['tipo_contrato']."'";
			}	
			
			if($datos['pago_planificado'] != "" || $datos['pago_planificado'] != 0){
				$pago_planificado_id = "AND c.pago_planificado_id = '".$datos['pago_planificado']."'";
			}

			if($datos['tipo_empleado'] != "" || $datos['tipo_empleado'] != 0){
				$tipo_empleado = "AND c.tipo_empleado_id = '".$datos['tipo_empleado']."'";
			}			

			$query = "SELECT c.contrato_id AS contrato_id, CONCAT(co.nombre, ' ', co.apellido) AS 'empleado', tc.nombre AS 'tipo_contrato', pp.nombre AS 'pago_planificado', te.nombre AS 'tipo_empleado', c.fecha_inicio AS 'fecha_inicio', c.estado AS 'estado', (CASE WHEN c.estado = '1' THEN 'Activo' ELSE 'Inactivo' END) AS 'estado_nombre', c.salario AS 'salario', c.tipo_contrato_id AS 'tipo_contrato_id', c.pago_planificado_id AS 'pago_planificado_id', c.tipo_empleado_id AS 'tipo_empleado_id', (CASE WHEN c.fecha_fin = '' THEN 'Sin Registro' ELSE c.fecha_fin END) AS 'fecha_fin', c.notas AS 'notas'
				FROM contrato AS c
				INNER JOIN colaboradores AS co ON c.colaborador_id = co.colaboradores_id
				INNER JOIN tipo_contrato AS tc ON c.tipo_contrato_id = tc.tipo_contrato_id
				INNER JOIN pago_planificado AS pp ON c.pago_planificado_id = pp.pago_planificado_id
				INNER JOIN tipo_empleado AS te ON c.tipo_empleado_id = te.tipo_empleado_id
				WHERE c.estado = '".$datos['estado']."'
				$tipo_contrato
				$pago_planificado_id
				$tipo_empleado
				ORDER BY co.nombre ASC";
				
			$result = self::connection()->query($query);

			return $result;
		}		

		public function getNomina($datos){
			$estado = '';			
			$pago_planificado_id = '';
			
			if($datos['pago_planificado'] != "" || $datos['pago_planificado'] != 0){
				$pago_planificado_id = "AND c.pago_planificado_id = '".$datos['pago_planificado']."'";
			}

			$query = "SELECT n.nomina_id AS 'nomina_id', e.nombre AS 'empresa', n.fecha_inicio AS 'fecha_inicio', n.fecha_fin AS 'fecha_fin', n.importe AS 'importe', n.notas AS 'notas', (CASE WHEN n.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) AS 'estado_nombre', n.estado AS 'estado', n.empresa_id AS 'empresa_id', n.detalle AS 'detalle', n.pago_planificado_id AS 'pago_planificado_id', n.pago_planificado_id AS 'pago_planificado_id'
			FROM nomina AS n
			INNER JOIN empresa AS e ON n.empresa_id = e.empresa_id
			WHERE n.estado = '".$datos['estado']."'	
			$pago_planificado_id	
			ORDER BY n.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;
		}	

		public function getNominaEdit($nomina_id){
			$query = "SELECT n.nomina_id AS 'nomina_id', e.nombre AS 'empresa', n.fecha_inicio AS 'fecha_inicio', n.fecha_fin AS 'fecha_fin', n.importe AS 'importe', n.notas AS 'notas', (CASE WHEN n.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) AS 'estado_nombre', n.estado AS 'estado', n.empresa_id AS 'empresa_id', n.detalle AS 'detalle', n.pago_planificado_id AS 'pago_planificado_id', e.empresa_id AS 'empresa_id', n.estado AS 'estado', tipo_nomina_id AS 'tipo_nomina_id'
			FROM nomina AS n
			INNER JOIN empresa AS e ON n.empresa_id = e.empresa_id
			WHERE n.nomina_id = '".$nomina_id."'	
			ORDER BY n.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;
		}			
		
		public function getNominaDetalles($datos){
			$estado = '';			
			$empleado = '';

			if($datos['empleado'] != "" || $datos['empleado'] != 0){
				$empleado = "AND c.colaboradores_id = '".$datos['empleado']."'";
			}	
			
			$query = "SELECT n.nomina_id AS 'nomina_id', nd.nomina_id AS 'nomina_detalles_id', CONCAT(c.nombre,' ' ,c.apellido) AS 'empleado', nd.salario AS 'salario', nd.hrse25 AS 'horas_25', nd.hrse50 As 'horas_50', nd.hrse75 AS 'horas_75', nd.hrse100 As 'horas_100', nd.retroactivo AS 'retroactivo', nd.bono AS 'bono', nd.deducciones AS 'deducciones', nd.prestamo AS 'prestamo', nd.ihss AS 'ihss', nd.rap AS 'rap', nd.estado AS 'estado', nd.estado AS 'estado', nd.nomina_detalles_id AS 'nomina_detalles_id', (CASE WHEN nd.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) AS 'estado_nombre', nd.colaboradores_id AS 'colaboradores_id', nd.neto_ingresos As 'neto_ingresos', nd.neto_egresos AS 'neto_egresos', nd.neto AS 'neto', nd.notas AS 'notas', tp.nombre AS 'contrato', e.nombre AS 'empresa'
				FROM nomina_detalles AS nd
				INNER JOIN nomina AS n ON nd.nomina_id = n.nomina_id
				INNER JOIN colaboradores AS c ON nd.colaboradores_id = c.colaboradores_id
				INNER JOIN contrato AS co ON nd.colaboradores_id = co.colaborador_id
				INNER JOIN tipo_contrato AS tp ON co.tipo_contrato_id = tp.tipo_contrato_id
				INNER JOIN empresa AS e ON n.empresa_id = e.empresa_id
				WHERE nd.estado = '".$datos['estado']."'
				$empleado
				ORDER BY nd.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getNominaComprobante($nomina_id){
			$query = "SELECT n.nomina_id AS 'nomina_id', e.nombre AS 'empresa', n.fecha_inicio AS 'fecha_inicio', n.fecha_fin AS 'fecha_fin', n.importe AS 'importe', n.notas AS 'notas', (CASE WHEN n.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) AS 'estado_nombre', n.estado AS 'estado', n.empresa_id AS 'empresa_id', n.detalle AS 'detalle', n.pago_planificado_id AS 'pago_planificado_id', n.pago_planificado_id AS 'pago_planificado_id', e.rtn AS 'rtn_empresa', DATE_FORMAT(n.fecha_registro, '%d/%m/%Y') AS fecha_registro, YEAR(n.fecha_registro) AS 'ano_registro', MONTHNAME(n.fecha_registro) AS 'mes_registro'
			FROM nomina AS n
			INNER JOIN empresa AS e ON n.empresa_id = e.empresa_id
			WHERE n.nomina_id = '".$nomina_id."' AND n.estado = 1
			ORDER BY n.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;
		}		

		public function getNominaComprobanteDetalles($nomina_id){					
			$query = "SELECT n.nomina_id AS 'nomina_id', nd.nomina_id AS 'nomina_detalles_id', CONCAT(c.nombre,' ' ,c.apellido) AS 'empleado', nd.salario AS 'salario', nd.hrse25 AS 'horas_25', nd.hrse50 As 'horas_50', nd.hrse75 AS 'horas_75', nd.hrse100 As 'horas_100', nd.retroactivo AS 'retroactivo', nd.bono AS 'bono', nd.deducciones AS 'deducciones', nd.prestamo AS 'prestamo', nd.ihss AS 'ihss', nd.rap AS 'rap', nd.estado AS 'estado', nd.estado AS 'estado', nd.nomina_detalles_id AS 'nomina_detalles_id', (CASE WHEN nd.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) AS 'estado_nombre', nd.colaboradores_id AS 'colaboradores_id', nd.neto_ingresos As 'neto_ingresos', nd.neto_egresos AS 'neto_egresos', nd.neto AS 'neto', nd.notas AS 'notas', tp.nombre AS 'contrato', e.nombre AS 'empresa', c.identidad AS 'identidad', c.fecha_ingreso AS 'fecha_ingreso', c.colaboradores_id AS 'colaboradores_id', pc.nombre AS 'puesto', nd.dias_trabajados AS 'dias_trabajados', nd.otros_ingresos AS 'otros_ingresos', nd.incapacidad_ihss AS 'incapacidad_ihss', nd.isr AS 'isr'
				FROM nomina_detalles AS nd
				INNER JOIN nomina AS n ON nd.nomina_id = n.nomina_id
				INNER JOIN colaboradores AS c ON nd.colaboradores_id = c.colaboradores_id
				INNER JOIN puestos AS pc ON c.puestos_id = pc.puestos_id
				INNER JOIN contrato AS co ON nd.colaboradores_id = co.colaborador_id
				INNER JOIN tipo_contrato AS tp ON co.tipo_contrato_id = tp.tipo_contrato_id
				INNER JOIN empresa AS e ON n.empresa_id = e.empresa_id
				WHERE n.nomina_id = '".$nomina_id."'
				ORDER BY nd.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;
		}		
		
		public function getNominaDetallesEdit($nomina_detalles_id){			
			$query = "SELECT n.nomina_id AS 'nomina_id', nd.nomina_detalles_id AS 'nomina_detalles_id', CONCAT(c.nombre,' ' ,c.apellido) AS 'empleado', nd.salario AS 'salario', nd.hrse25 AS 'horas_25', nd.hrse50 As 'horas_50', nd.hrse75 AS 'horas_75', nd.hrse100 As 'horas_100', nd.retroactivo AS 'retroactivo', nd.bono AS 'bono', nd.deducciones AS 'deducciones', nd.prestamo AS 'prestamo', nd.ihss AS 'ihss', nd.rap AS 'rap', nd.estado AS 'estado', nd.estado AS 'estado', nd.nomina_detalles_id AS 'nomina_detalles_id', (CASE WHEN nd.estado = 1 THEN 'Activo' ELSE 'Inactivo' END) AS 'estado_nombre', nd.colaboradores_id AS 'colaboradores_id', nd.neto_ingresos As 'neto_ingresos', nd.neto_egresos AS 'neto_egresos', nd.neto AS 'neto', nd.notas AS 'notas', tp.nombre AS 'contrato', e.nombre AS 'empresa', n.pago_planificado_id AS 'pago_planificado_id', n.notas AS 'notas', c.identidad AS 'identidad', p.nombre AS 'puesto', co.contrato_id AS 'contrato_id', c.fecha_ingreso AS 'fecha_ingreso', nd.dias_trabajados AS 'dias_trabajados', nd.otros_ingresos AS 'otros_ingresos', nd.isr AS 'isr', nd.incapacidad_ihss AS 'incapacidad_ihss', nd.notas AS 'nota_detalles'
				FROM nomina_detalles AS nd 
				INNER JOIN nomina AS n ON nd.nomina_id = n.nomina_id 
				INNER JOIN colaboradores AS c ON nd.colaboradores_id = c.colaboradores_id 
				INNER JOIN contrato AS co ON nd.colaboradores_id = co.colaborador_id 
				INNER JOIN tipo_contrato AS tp ON co.tipo_contrato_id = tp.tipo_contrato_id 
				INNER JOIN empresa AS e ON n.empresa_id = e.empresa_id 
				INNER JOIN puestos AS p ON c.puestos_id = p.puestos_id 
				WHERE nd.nomina_detalles_id = '".$nomina_detalles_id."'
				ORDER BY nd.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;
		}			

		public function getCantidadUsuariosPlan(){
			$query = "SELECT *
				FROM plan";

			$result = self::connection()->query($query);


			return $result;
		}

		public function getUsuarios($datos){
			if($datos['privilegio_id'] == 1){
				$where = "WHERE u.estado = 1";
			}else{
				$where = "WHERE u.estado = 1 AND u.privilegio_id NOT IN(1)";
			}

			$query = "SELECT u.users_id AS 'users_id', CONCAT(c.nombre, ' ', c.apellido) AS 'colaborador', u.username AS 'username', u.email AS 'correo', tp.nombre AS 'tipo_usuario',
				CASE WHEN u.estado = 1 THEN 'Activo' ELSE 'Inactivo' END AS 'estado',
				e.nombre AS 'empresa'
				FROM users AS u
				INNER JOIN colaboradores AS c
				ON u.colaboradores_id = c.colaboradores_id
				INNER JOIN tipo_user AS tp
				ON u.tipo_user_id = tp.tipo_user_id
				INNER JOIN empresa AS e
				ON u.empresa_id = e.empresa_id
				".$where."
				ORDER BY CONCAT(c.nombre, ' ', c.apellido)";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getSecuenciaFacturacion(){
			$query = "SELECT sf.secuencia_facturacion_id AS 'secuencia_facturacion_id', sf.cai AS 'cai', sf.prefijo AS 'prefijo', sf.relleno AS 'relleno', sf.incremento AS 'incremento', sf.siguiente AS 'siguiente', sf.rango_inicial AS 'rango_inicial', sf.rango_final AS 'rango_final', DATE_FORMAT(sf.fecha_activacion, '%d/%m/%Y') AS 'fecha_activacion', DATE_FORMAT(sf.fecha_registro, '%d/%m/%Y') AS 'fecha_registro', e.nombre AS 'empresa', DATE_FORMAT(sf.fecha_limite, '%d/%m/%Y') AS 'fecha_limite', d.nombre AS 'documento'
				FROM secuencia_facturacion AS sf
				INNER JOIN empresa AS e
				ON sf.empresa_id = e.empresa_id
				INNER JOIN documento as d
				ON sf.documento_id = d.documento_id
				WHERE sf.activo = 1
				ORDER BY sf.fecha_registro";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getISV($documento){

			$query = "SELECT i.isv_id AS 'isv_id', i.isv_tipo_id AS 'isv_tipo_id', i.valor AS 'valor', it.nombre AS 'tipo_isv'

				FROM isv AS i

				INNER JOIN isv_tipo As it

				ON i.isv_tipo_id = it.isv_tipo_id

				WHERE it.nombre = '$documento'";



			$result = self::connection()->query($query);



			return $result;
		}

		public function getISVEstadoProducto($productos_id){
			$query = "SELECT isv_venta
				FROM productos
				WHERE productos_id = '$productos_id'";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getTipoProducto($productos_id){
			$query = "SELECT tp.nombre AS 'tipo_producto'
				FROM productos AS p
				INNER JOIN tipo_producto AS tp
				ON p.tipo_producto_id = tp.tipo_producto_id
				WHERE p.productos_id = '$productos_id'
				GROUP BY p.productos_id";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getCantidadProductos($productos_id){
			$query = "SELECT id_producto_superior
				FROM productos
				WHERE productos_id = '$productos_id'";
			
			$result = self::connection()->query($query);

			return $result;
		}

		public function getTotalHijosporPadre($productos_id){
			$query = "SELECT productos_id
				FROM productos
				WHERE id_producto_superior = '$productos_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function generarCodigoBarra(){
			return date("Ymdhhmmss")."K";
		}

		public function getProductoHijo($producto_id){
			$query = "SELECT
			productos.productos_id,
			productos.id_producto_superior,
			productos.nombre,
			medida.nombre as medida
			FROM
			productos
			INNER JOIN medida ON productos.medida_id = medida.medida_id
			WHERE productos.id_producto_superior = '$producto_id'";
			
			$result = self::connection()->query($query);

			return $result;
		}

		public function getMedidaProductoPadre($productos_id){
			$query = "SELECT m.nombre AS 'medida'
				FROM productos AS p
				INNER JOIN medida AS m
				ON p.medida_id = m.medida_id
				WHERE p.productos_id = '$productos_id'";
				
			$result = self::connection()->query($query);

			return $result;
		}

		public function getSaldoProductosMovimientos($productos_id){
			$query = "SELECT saldo
				FROM movimientos
				WHERE productos_id = '$productos_id'
				ORDER BY movimientos_id DESC LIMIT 1";
				
			$result = self::connection()->query($query);

			return $result;
		}

		public function getSaldoProductosMovimientosBodega($productos_id, $almacen_id){
			$query = "SELECT saldo
				FROM movimientos
				WHERE productos_id = '$productos_id' AND almacen_id = '$almacen_id'
				ORDER BY movimientos_id DESC LIMIT 1";
				
			$result = self::connection()->query($query);

			return $result;
		}		

		protected function agregar_movimiento_productos_modelo($datos){
			$movimientos_id = mainModel::correlativo("movimientos_id", "movimientos");
			$documento = "Entrada Movimientos ".$movimientos_id;
			isset($datos['almacen_id']) ? $bodega = $datos['almacen_id'] : $bodega = '';
			$insert = "INSERT INTO movimientos 
				VALUES('$movimientos_id','".$datos['productos_id']."','$documento','".$datos['cantidad_entrada']."',
				'".$datos['cantidad_salida']."','".$datos['saldo']."','".$datos['empresa']."','".$datos['fecha_registro']."',
				'".$datos['clientes_id']."','".$datos['comentario']."', '$bodega'
				)";

			$sql = mainModel::connection()->query($insert) or die(mainModel::connection()->error);
			
			return $sql;			
		}

		public function getProductos(){
			$query = "SELECT p.barCode AS 'barCode', p.productos_id AS 'productos_id', p.nombre AS 'nombre', p.descripcion AS 'descripcion', p.precio_compra AS 'precio_compra', p.precio_venta AS 'precio_venta',m.nombre AS 'medida', a.nombre AS 'almacen', u.nombre AS 'ubicacion', e.nombre AS 'empresa',
			(CASE WHEN p.estado = '1' THEN 'Activo' ELSE 'Inactivo' END) AS 'estado', (CASE WHEN p.isv_venta = '1' THEN 'Sí' ELSE 'No' END) AS 'isv',
			tp.tipo_producto_id AS 'tipo_producto_id', tp.nombre AS 'categoria', (CASE WHEN p.isv_venta = '1' THEN 'Si' ELSE 'No' END) AS 'isv_venta', (CASE WHEN p.isv_compra = '1' THEN 'Si' ELSE 'No' END) AS 'isv_compra', p.file_name AS 'image'
				FROM productos AS p
				INNER JOIN medida AS m
				ON p.medida_id = m.medida_id
				INNER JOIN almacen AS a
				ON p.almacen_id = a.almacen_id
				INNER JOIN ubicacion AS u
				ON a.ubicacion_id = u.ubicacion_id
				INNER JOIN empresa AS e
				ON u.empresa_id = e.empresa_id
				INNER JOIN tipo_producto AS tp
				ON p.tipo_producto_id = tp.tipo_producto_id
				WHERE p.estado = 1";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getProductosCantidad($datos){
			$bodega = '';
			$barCode = '';

			if($datos['bodega'] != ''){
				$bodega = "AND m.almacen_id = '".$datos['bodega']."'";
			}
			if($datos['bodega'] == '0'){$bodega = '';}

			if($datos['barcode'] != ''){
				$barCode = "AND p.barCode  = '".$datos['barcode']."'";
			}

			$query = "SELECT
			m.almacen_id,
			m.movimientos_id AS 'movimientos_id',
			p.barCode AS 'barCode',
			p.nombre AS 'nombre',
			me.nombre AS 'medida',
			SUM(m.cantidad_entrada) AS 'entrada',
			SUM(m.cantidad_salida) AS 'salida',
			(
				SUM(m.cantidad_entrada) - SUM(m.cantidad_salida)
			) AS 'cantidad',
			bo.nombre AS 'almacen',
			DATE_FORMAT(
				m.fecha_registro,
				'%d/%m/%Y %H:%i:%s'
			) AS 'fecha_registro',
			p.productos_id AS 'productos_id',
			p.id_producto_superior,
			p.precio_compra AS 'precio_compra',
			p.precio_venta,
			p.precio_mayoreo,
			p.cantidad_mayoreo,
			p.isv_venta AS 'impuesto_venta',
			p.isv_compra AS 'isv_compra',
			p.file_name AS 'image',
			tp.tipo_producto_id AS 'tipo_producto_id',
			tp.nombre AS 'tipo_producto',
			(
				CASE
				WHEN p.estado = '1' THEN
					'Activo'
				ELSE
					'Inactivo'
				END
			) AS 'estado',
			(
				CASE
				WHEN p.isv_venta = '1' THEN
					'Sí'
				ELSE
					'No'
				END
			) AS 'isv', tp.nombre AS 'tipo_producto_nombre',
			(CASE WHEN p.isv_venta = '1' THEN 'Si' ELSE 'No' END) AS 'isv_venta',
			(CASE WHEN p.isv_compra = '1' THEN 'Si' ELSE 'No' END) AS 'isv_compra'
		
		FROM
			movimientos AS m
		RIGHT JOIN productos AS p ON m.productos_id = p.productos_id
		LEFT JOIN medida AS me ON p.medida_id = me.medida_id
		LEFT JOIN almacen AS bo ON m.almacen_id = bo.almacen_id
		INNER JOIN tipo_producto AS tp ON p.tipo_producto_id = tp.tipo_producto_id
		WHERE
			p.estado = 1
		AND tp.nombre NOT IN ('Insumos')
		$bodega
		$barCode
		GROUP BY
			p.productos_id, m.almacen_id
		ORDER BY
			p.fecha_registro ASC";
			
			$result = self::connection()->query($query);

			return $result;
		}

		public function getProductosCantidadCompras($datos){
			$bodega = '';
			$barCode = '';

			if($datos['bodega'] != ''){
				$bodega = "AND m.almacen_id = '".$datos['bodega']."'";
			}
			if($datos['bodega'] == '0'){$bodega = '';}

			if($datos['barcode'] != ''){
				$barCode = "AND p.barCode  = '".$datos['barcode']."'";
			}

			$query = "SELECT
			m.almacen_id,
			m.movimientos_id AS 'movimientos_id',
			p.barCode AS 'barCode',
			p.nombre AS 'nombre',
			me.nombre AS 'medida',
			SUM(m.cantidad_entrada) AS 'entrada',
			SUM(m.cantidad_salida) AS 'salida',
			(
				SUM(m.cantidad_entrada) - SUM(m.cantidad_salida)
			) AS 'cantidad',
			bo.nombre AS 'almacen',
			DATE_FORMAT(
				m.fecha_registro,
				'%d/%m/%Y %H:%i:%s'
			) AS 'fecha_registro',
			p.productos_id AS 'productos_id',
			p.id_producto_superior,
			p.precio_compra AS 'precio_compra',
			p.precio_venta,
			p.precio_mayoreo,
			p.cantidad_mayoreo,
			p.isv_venta AS 'impuesto_venta',
			p.isv_compra AS 'isv_compra',
			p.file_name AS 'image',
			tp.tipo_producto_id AS 'tipo_producto_id',
			tp.nombre AS 'tipo_producto',
			(
				CASE
				WHEN p.estado = '1' THEN
					'Activo'
				ELSE
					'Inactivo'
				END
			) AS 'estado',
			(
				CASE
				WHEN p.isv_venta = '1' THEN
					'Sí'
				ELSE
					'No'
				END
			) AS 'isv', tp.nombre AS 'tipo_producto_nombre',
			(CASE WHEN p.isv_venta = '1' THEN 'Si' ELSE 'No' END) AS 'isv_venta',
			(CASE WHEN p.isv_compra = '1' THEN 'Si' ELSE 'No' END) AS 'isv_compra'
		
		FROM
			movimientos AS m
		RIGHT JOIN productos AS p ON m.productos_id = p.productos_id
		LEFT JOIN medida AS me ON p.medida_id = me.medida_id
		LEFT JOIN almacen AS bo ON m.almacen_id = bo.almacen_id
		INNER JOIN tipo_producto AS tp ON p.tipo_producto_id = tp.tipo_producto_id
		WHERE
			p.estado = 1
		$bodega
		$barCode
		GROUP BY
			p.productos_id, m.almacen_id
		ORDER BY
			p.fecha_registro ASC";
			
			$result = self::connection()->query($query);

			return $result;
		}

		public function getProductosFacturas($datos){
			$bodega = '';
			$barCode = '';

			if($datos['bodega'] != ''){
				$bodega = "AND a.almacen_id = '".$datos['bodega']."'";
			}
			if($datos['bodega'] == '0'){$bodega = '';}

			if($datos['barcode'] != ''){
				$barCode = "AND p.barCode  = '".$datos['barcode']."'";
			}
		
			$query = "
			SELECT
				p.productos_id AS 'productos_id',
				p.barCode AS 'barCode',
				p.productos_id AS 'productos_id',
				p.nombre AS 'nombre',
				p.descripcion AS 'descripcion',
				p.cantidad AS 'cantidad',
				p.precio_compra AS 'precio_compra',
				p.precio_venta AS 'precio_venta',
				m.nombre AS 'medida',
				a.nombre AS 'almacen',
				a.almacen_id,
				u.nombre AS 'ubicacion',
				e.nombre AS 'empresa',
				(
					CASE
					WHEN p.estado = '1' THEN
						'Activo'
					ELSE
						'Inactivo'
					END
				) AS 'estado',
				(
					CASE
					WHEN p.isv_venta = '1' THEN
						'Sí'
					ELSE
						'No'
					END
				) AS 'isv',
				tp.tipo_producto_id AS 'tipo_producto_id',
				tp.nombre AS 'tipo_producto',
				p.isv_venta AS 'impuesto_venta',
				p.isv_compra AS 'isv_compra',
				p.file_name AS 'image',
				p.cantidad_mayoreo AS 'cantidad_mayoreo',
				p.precio_mayoreo AS 'precio_mayoreo'
			FROM
				productos AS p
			INNER JOIN medida AS m ON p.medida_id = m.medida_id
			INNER JOIN almacen AS a ON p.almacen_id = a.almacen_id
			INNER JOIN ubicacion AS u ON a.ubicacion_id = u.ubicacion_id
			INNER JOIN empresa AS e ON u.empresa_id = e.empresa_id
			INNER JOIN tipo_producto AS tp ON p.tipo_producto_id = tp.tipo_producto_id
			WHERE
				p.estado = 1
			AND tp.nombre NOT IN ('Insumos')
			$bodega
			$barCode
			";

			$result = self::connection()->query($query);
			return $result;
		}

		public function getProductosMovimientos($tipo_producto_id){
			$query = "SELECT p.productos_id AS 'productos_id', p.barCode AS 'barCode', p.productos_id AS 'productos_id', p.nombre AS 'nombre', p.descripcion AS 'descripcion', p.cantidad AS 'cantidad', p.precio_compra AS 'precio_compra', p.precio_venta AS 'precio_venta',m.nombre AS 'medida', a.nombre AS 'almacen', u.nombre AS 'ubicacion', e.nombre AS 'empresa',
			(CASE WHEN p.estado = '1' THEN 'Activo' ELSE 'Inactivo' END) AS 'estado', (CASE WHEN p.isv_venta = '1' THEN 'Sí' ELSE 'No' END) AS 'isv',
			tp.tipo_producto_id AS 'tipo_producto_id', tp.nombre AS 'tipo_producto', p.isv_venta AS 'impuesto_venta', p.isv_compra AS 'isv_compra', p.colaborador_id AS 'colaborador_id'
				FROM productos AS p
				INNER JOIN medida AS m
				ON p.medida_id = m.medida_id
				INNER JOIN almacen AS a
				ON p.almacen_id = a.almacen_id
				INNER JOIN ubicacion AS u
				ON a.ubicacion_id = u.ubicacion_id
				INNER JOIN empresa AS e
				ON u.empresa_id = e.empresa_id
				INNER JOIN tipo_producto AS tp
				ON p.tipo_producto_id = tp.tipo_producto_id
				WHERE p.estado = 1 AND p.tipo_producto_id = '$tipo_producto_id'";

			$result = self::connection()->query($query);

			return $result;

		}

		function getProductoTipoProducto($tipo_producto_id){

			$query = "SELECT *

				FROM productos

				WHERE tipo_producto_id = '$tipo_producto_id'";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getMedida(){

			$query = "
			SELECT
			*
			FROM
			medida
			WHERE estado = 1
			ORDER BY medida_id ASC
			";
			$result = self::connection()->query($query);
			return $result;
		}



		public function getCorreo(){

			$query = "SELECT c.correo_id AS 'correo_id', c.server AS 'server', c.correo AS 'correo', c.port AS 'port', c.smtp_secure AS 'smtp_secure', c.estado AS 'estado', ct.nombre AS 'tipo_correo'

				FROM correo AS c

				INNER JOIN correo_tipo AS ct

				ON c.correo_tipo_id = ct.correo_tipo_id

				WHERE c.estado = 1

				ORDER BY c.correo_id";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getDiarios(){

			$query = "SELECT d.diarios_id AS 'diarios_id', d.nombre AS 'diario', d.cuentas_id AS 'cuentas_id', c.nombre AS 'cuenta', d.estado AS 'estado'

				FROM diarios AS d

				INNER JOIN cuentas AS c

				ON d.cuentas_id = c.cuentas_id";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getDiariosEdit($diarios_id){

			$query = "SELECT d.diarios_id AS 'diarios_id', d.nombre AS 'diario', d.cuentas_id AS 'cuentas_id', c.nombre AS 'cuenta', d.estado AS 'estado'

				FROM diarios AS d

				INNER JOIN cuentas AS c

				ON d.cuentas_id = c.cuentas_id

				WHERE diarios_id = '$diarios_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getAlmacen(){

			$query = "SELECT a.almacen_id AS 'almacen_id', a.nombre AS 'almacen', u.nombre AS 'ubicacion', e.nombre AS 'empresa',
				a.facturar_cero

				FROM almacen AS a
				INNER JOIN ubicacion AS u
				ON a.ubicacion_id = u.ubicacion_id
				INNER JOIN empresa AS e
				ON a.empresa_id = e.empresa_id
				WHERE a.estado = 1
				ORDER BY a.nombre ASC";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getTipoPagoContabilidad(){
			$query = "SELECT tp.nombre AS 'nombre', c.codigo AS 'codigo', c.nombre AS 'cuenta', tp.tipo_pago_id AS 'tipo_pago_id'
				FROM tipo_pago AS tp
				INNER JOIN cuentas As c
				ON tp.cuentas_id = c.cuentas_id
				WHERE tp.estado = 1";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getUbicacion(){
			$query = "SELECT u.ubicacion_id AS 'ubicacion_id', u.nombre AS 'ubicacion', e.nombre AS 'empresa'
				FROM ubicacion AS u
				INNER JOIN empresa AS e
				ON u.empresa_id = e.empresa_id
				WHERE u.estado = 1
				ORDER BY u.nombre ASC";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getTipoProductos(){

			$query = "SELECT *

				FROM tipo_producto";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTipoCorreo(){

			$query = "SELECT *

				FROM correo_tipo";



			$result = self::connection()->query($query);



			return $result;

		}

		public function getTipoProductosMovimientos(){
			$query = "SELECT *
				FROM tipo_producto
				WHERE nombre NOT IN ('Servicio')";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getCuentasContabilidad(){
			$query = "SELECT *
				FROM cuentas
				WHERE estado = 1";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getCuentasIngresos($datos){
			$query = "SELECT sum(total) AS 'ingresos'
				FROM ingresos
				WHERE cuentas_id = '".$datos['cuentas_id']."' AND CAST(fecha_registro AS DATE) BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getCuentaEgresos($datos){
			$query = "SELECT sum(total) AS 'egresos'
				FROM egresos
				WHERE cuentas_id = '".$datos['cuentas_id']."' AND CAST(fecha_registro AS DATE) BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getMovimientosCuentasContables($datos){
			$query = "SELECT mc.movimientos_cuentas_id AS 'movimientos_cuentas_id', mc.fecha_registro AS 'fecha', c.codigo as 'codigo', c.nombre AS 'nombre', mc.ingreso As 'ingreso', mc.egreso AS 'egreso', mc.saldo AS 'saldo'
				FROM movimientos_cuentas AS mc
				INNER JOIN cuentas AS c

				ON mc.cuentas_id = c.cuentas_id

				AND fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'

				ORDER BY mc.fecha_registro DESC";



			$result = self::connection()->query($query);



			return $result;

		}


		public function getIngresosContables($datos){
			$query = "SELECT i.ingresos_id AS 'ingresos_id', i.fecha AS 'fecha', c.codigo as 'codigo', c.nombre AS 'nombre', cli.nombre AS 'cliente', i.factura AS 'factura', i.subtotal as 'subtotal', i.impuesto AS 'impuesto', i.descuento AS 'descuento', i.nc AS 'nc', i.total AS 'total', i.fecha_registro As 'fecha_registro'
				FROM ingresos AS i
				INNER JOIN cuentas AS c
				ON i.cuentas_id = c.cuentas_id
				INNER JOIN clientes AS cli
				ON i.clientes_id = cli.clientes_id
				WHERE CAST(i.fecha_registro AS DATE) BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND i.estado = '".$datos['estado']."'
				ORDER BY i.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;

		}

		public function ejecutar_consulta_simple($query){
			$result = self::connection()->query($query);

			return $result;
		}


		public function consulta_total_gastos($query){
			$result = self::connection()->query($query);
	
			return $result;
		}


		public function getEgresosContables($datos){
			$query = "SELECT e.egresos_id AS 'egresos_id', e.fecha AS 'fecha', c.codigo as 'codigo', c.nombre AS 'nombre', p.nombre AS 'proveedor', e.factura AS 'factura', e.subtotal as 'subtotal', e.impuesto AS 'impuesto', e.descuento AS 'descuento', e.nc AS 'nc', e.total AS 'total', e.fecha_registro As 'fecha_registro'
				FROM egresos AS e
				INNER JOIN cuentas AS c
				ON e.cuentas_id = c.cuentas_id
				INNER JOIN proveedores AS p
				ON e.proveedores_id = p.proveedores_id
				WHERE CAST(e.fecha_registro AS DATE) BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND e.tipo_egreso = 2 AND e.estado = '".$datos['estado']."'
				ORDER BY e.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;

		}

		public function getEgresosContablesReporte($egresos_id){
			$query = "SELECT e.egresos_id AS 'egresos_id', e.fecha AS 'fecha', c.codigo as 'codigo', c.nombre AS 'nombre', p.nombre AS 'proveedor', p.rtn AS 'rtn_proveedor', p.localidad AS 'localidad', p.telefono AS 'telefono', e.factura AS 'factura', e.fecha_registro As 'fecha_registro', emp.nombre AS 'empresa', emp.ubicacion AS 'direccion_empresa', emp.telefono AS 'empresa_telefono', emp.celular AS 'empresa_celular', emp.correo AS 'empresa_correo', emp.otra_informacion As 'otra_informacion', emp.eslogan AS 'eslogan', DATE_FORMAT(e.fecha, '%d/%m/%Y') AS 'fecha', time(e.fecha_registro) AS 'hora', e.observacion AS 'observacion', co.nombre AS 'colaborador_nombre' , co.apellido AS 'colaborador_apellido', e.estado AS 'estado', emp.rtn AS 'rtn_empresa', e.subtotal AS 'subtotal', e.descuento AS 'descuento', e.nc AS 'nc', e.impuesto AS 'impuesto', e.total AS 'total', DATE_FORMAT(e.fecha_registro, '%d/%m/%Y') AS 'fecha_registro_consulta'
				FROM egresos AS e
				INNER JOIN cuentas AS c
				ON e.cuentas_id = c.cuentas_id
				INNER JOIN proveedores AS p
				ON e.proveedores_id = p.proveedores_id
				INNER JOIN empresa AS emp
				ON e.empresa_id = emp.empresa_id
				INNER JOIN colaboradores AS co
				ON e.colaboradores_id = co.colaboradores_id
				WHERE e.egresos_id = '$egresos_id'
				ORDER BY e.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;

		}


		public function getIngresosContablesReporte($ingresos_id){
			$query = "SELECT i.ingresos_id AS 'ingresos_id', i.fecha AS 'fecha', c.codigo as 'codigo', c.nombre AS 'nombre', cl.nombre AS 'cliente', cl.rtn AS 'rtn_cliente', cl.localidad AS 'localidad', cl.telefono AS 'telefono', i.factura AS 'factura', i.fecha_registro As 'fecha_registro', emp.nombre AS 'empresa', emp.ubicacion AS 'direccion_empresa', emp.telefono AS 'empresa_telefono', emp.celular AS 'empresa_celular', emp.correo AS 'empresa_correo', emp.otra_informacion As 'otra_informacion', emp.eslogan AS 'eslogan', DATE_FORMAT(i.fecha, '%d/%m/%Y') AS 'fecha', time(i.fecha_registro) AS 'hora', i.observacion AS 'observacion', co.nombre AS 'colaborador_nombre', co.apellido AS 'colaborador_apellido', i.estado AS 'estado', emp.rtn AS 'rtn_empresa', i.subtotal AS 'subtotal', i.descuento AS 'descuento', i.nc AS 'nc', i.impuesto AS 'impuesto', i.total AS 'total', DATE_FORMAT(i.fecha_registro, '%d/%m/%Y') AS 'fecha_registro_consulta'
				FROM ingresos AS i
				INNER JOIN cuentas AS c
				ON i.cuentas_id = c.cuentas_id
				INNER JOIN clientes AS cl
				ON i.clientes_id = cl.clientes_id
				INNER JOIN empresa AS emp
				ON i.empresa_id = emp.empresa_id
				INNER JOIN colaboradores AS co
				ON i.colaboradores_id = co.colaboradores_id
				WHERE i.ingresos_id = '$ingresos_id'
				ORDER BY i.fecha_registro DESC";

			$result = self::connection()->query($query);

			return $result;

		}

		public function getChequesContables($datos){

			$query = "SELECT ck.fecha AS 'fecha', ck.factura AS 'factura', ck.importe AS 'importe', c.codigo AS 'codigo', c.nombre AS 'nombre', ck.observacion AS 'observacion', p.nombre AS 'proveedor'

				FROM cheque AS ck

				INNER JOIN cuentas AS c

				ON ck.cuentas_id = c.cuentas_id

				INNER JOIN proveedores AS p

				ON ck.proveedores_id = p.proveedores_id

				WHERE ck.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'

				ORDER BY ck.fecha_registro DESC";



			$result = self::connection()->query($query);



			return $result;

		}



		/*INICIO FUNCIONES ACCIONES CONSULTAS EDITAR FORMULARIOS*/

		public function getCuentasContabilidadEdit($cuentas_id){

			$query = "SELECT *

				FROM cuentas

				WHERE cuentas_id = '$cuentas_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getClientesEdit($clientes_id){

			$query = "SELECT *

				FROM clientes

				WHERE clientes_id = '$clientes_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getProveedoresEdit($proveedores_id){

			$query = "SELECT *

				FROM proveedores

				WHERE proveedores_id = '$proveedores_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getColaboradoresEdit($colaboradores_id){

			$query = "SELECT *

				FROM colaboradores

				WHERE colaboradores_id = '$colaboradores_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getPuestosEdit($puestos_id){

			$query = "SELECT *

				FROM puestos

				WHERE puestos_id = '$puestos_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getUsersEdit($users_id){

			$query = "SELECT u.users_id AS 'users_id', c.colaboradores_id AS 'colaborador_id', CONCAT(c.nombre, ' ', c.apellido) AS 'colaborador', u.username AS 'username', u.email AS 'correo', u.tipo_user_id AS 'tipo_user_id', u.estado AS 'estado', u.empresa_id AS 'empresa_id', u.privilegio_id AS 'privilegio_id'

				FROM users AS u

				INNER JOIN colaboradores AS c

				ON u.colaboradores_id = c.colaboradores_id

				WHERE u.users_id = '$users_id'

				ORDER BY CONCAT(c.nombre, ' ', c.apellido)";



			$result = self::connection()->query($query);



			return $result;

		}

		public function getSecuenciaFacturacionEdit($secuencia_facturacion_id){
			$query = "SELECT *
				FROM secuencia_facturacion
				WHERE secuencia_facturacion_id = '$secuencia_facturacion_id'";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getFactura($noFactura){
			$query = "SELECT c.clientes_id As 'clientes_id', c.nombre AS 'cliente', c.rtn AS 'rtn_cliente', c.telefono AS 'telefono', c.localidad AS 'localidad', e.nombre AS 'empresa', e.ubicacion AS 'direccion_empresa', e.telefono AS 'empresa_telefono', e.celular AS 'empresa_celular', e.correo AS 'empresa_correo', co.nombre AS 'colaborador_nombre', co.apellido AS 'colaborador_apellido', sf.prefijo AS 'prefijo', sf.siguiente AS 'numero', sf.relleno AS 'relleno', DATE_FORMAT(f.fecha, '%d/%m/%Y') AS 'fecha', time(f.fecha_registro) AS 'hora', sf.cai AS 'cai', e.rtn AS 'rtn_empresa', sf.fecha_activacion AS 'fecha_activacion', sf.fecha_limite AS 'fecha_limite', f.estado AS 'estado', sf.rango_inicial AS 'rango_inicial', sf.rango_final AS 'rango_final', f.number AS 'numero_factura', f.notas AS 'notas', e.otra_informacion As 'otra_informacion', e.eslogan AS 'eslogan', e.celular As 'celular', (CASE WHEN f.tipo_factura = 1 THEN 'Contado' ELSE 'Crédito' END) AS 'tipo_documento', e.rtn AS 'rtn', f.fecha_dolar AS 'fecha_dolar'
				FROM facturas AS f
				INNER JOIN clientes AS c
				ON f.clientes_id = c.clientes_id
				INNER JOIN secuencia_facturacion AS sf
				ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id
				INNER JOIN empresa AS e
				ON sf.empresa_id = e.empresa_id
				INNER JOIN colaboradores AS co
				ON f.colaboradores_id = co.colaboradores_id
				WHERE f.facturas_id = '$noFactura'";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getCotizacion($noCotizacion){
			$query = "SELECT cl.nombre AS 'cliente', cl.rtn AS 'rtn_cliente', cl.telefono AS 'telefono', cl.localidad AS 'localidad',
			 e.nombre AS 'empresa', e.ubicacion AS 'direccion_empresa', e.telefono AS 'empresa_telefono', e.celular AS 'empresa_celular',
			  e.correo AS 'empresa_correo', co.nombre AS 'colaborador_nombre' , co.apellido AS 'colaborador_apellido',
			   DATE_FORMAT(c.fecha, '%d/%m/%Y') AS 'fecha', c.fecha_dolar,
			    time(c.fecha_registro) AS 'hora',  c.estado AS 'estado', c.number AS 'numero_factura', c.notas AS 'notas', e.otra_informacion As 'otra_informacion', e.eslogan AS 'eslogan', e.celular As 'celular', (CASE WHEN c.tipo_factura = 1 THEN 'Contado' ELSE 'Crédito'END) AS 'tipo_documento', vg.valor AS 'vigencia_cotizacion', e.rtn AS 'rtn_empresa'
				FROM cotizacion AS c
				INNER JOIN clientes AS cl
				ON c.clientes_id = cl.clientes_id
				INNER JOIN colaboradores AS co
				ON c.colaboradores_id = co.colaboradores_id
				INNER JOIN empresa AS e
				ON co.empresa_id = e.empresa_id
				INNER JOIN vigencia_cotizacion AS vg
				ON c.vigencia_cotizacion_id = vg.vigencia_cotizacion_id
				WHERE c.cotizacion_id = '$noCotizacion'";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getCompra($noCotizacion){

			$query = "SELECT p.nombre AS 'proveedor', p.rtn AS 'rtn_proveedor', p.telefono AS 'telefono', p.localidad AS 'localidad', e.nombre AS 'empresa', e.ubicacion AS 'direccion_empresa', e.telefono AS 'empresa_telefono', e.celular AS 'empresa_celular', e.correo AS 'empresa_correo', co.nombre AS 'colaborador_nombre', co.apellido AS 'colaborador_apellido', DATE_FORMAT(c.fecha, '%d/%m/%Y') AS 'fecha', time(c.fecha_registro) AS 'hora',  c.estado AS 'estado', c.number AS 'numero_factura', c.notas AS 'notas', e.otra_informacion As 'otra_informacion', e.eslogan AS 'eslogan', e.celular As 'celular', (CASE WHEN c.tipo_compra = 1 THEN 'Contado' ELSE 'Crédito' END) AS 'tipo_documento', e.rtn AS 'rtn_empresa'

				FROM compras AS c

				INNER JOIN proveedores AS p

				ON c.proveedores_id = p.proveedores_id
				INNER JOIN colaboradores AS co
				ON c.colaboradores_id = co.colaboradores_id
				INNER JOIN empresa AS e
				ON co.empresa_id = e.empresa_id
				WHERE c.compras_id = '$noCotizacion'";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getDetalleFactura($noFactura){
			$query = "SELECT
			p.barCode AS 'barCode',
			p.nombre AS 'producto',
			p.precio_compra AS costo,
			fd.cantidad AS 'cantidad',
			fd.precio AS 'precio',
			fd.descuento AS 'descuento',
			fd.productos_id AS 'productos_id',
			fd.isv_valor AS 'isv_valor',
			med.nombre As 'medida'
				FROM
			facturas_detalles AS fd
				INNER JOIN productos AS p ON fd.productos_id = p.productos_id
				INNER JOIN medida as med ON p.medida_id = med.medida_id
				WHERE fd.facturas_id = '$noFactura'
				";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getEmpresaFacturaCorreo($usuario){
			$query = "SELECT e.telefono AS 'telefono', e.celular AS 'celular', e.correo AS 'correo', e.horario AS 'horario', e.eslogan AS 'eslogan', e.facebook AS 'facebook', e.sitioweb AS 'sitioweb'
			FROM users AS u
			INNER JOIN empresa AS e
			ON u.empresa_id = e.empresa_id
			WHERE u.colaboradores_id = '$usuario'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getEmpresaFacturaCorreoUsuario($users_id){

			$query = "SELECT e.telefono AS 'telefono', e.celular AS 'celular', e.correo AS 'correo', e.horario AS 'horario', e.eslogan AS 'eslogan', e.facebook AS 'facebook', e.sitioweb AS 'sitioweb'

			FROM users AS u

			INNER JOIN empresa AS e

			ON u.empresa_id = e.empresa_id

			WHERE u.users_id = '$users_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function geFacturaCorreo($facturas_id){

			$query = "SELECT c.nombre AS 'cliente', c.correo AS 'correo', f.number AS 'numero', sf.prefijo AS 'prefijo', sf.relleno AS 'relleno'

			FROM facturas AS f

			INNER JOIN clientes AS c

			ON f.clientes_id = c.clientes_id

			INNER JOIN secuencia_facturacion AS sf

			ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id

			WHERE f.facturas_id = '$facturas_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getCotizacionCorreo($cotizacion_id){

			$query = "SELECT cl.nombre AS 'cliente', cl.correo AS 'correo', c.number AS 'numero'

			FROM cotizacion AS c

			INNER JOIN clientes AS cl

			ON c.clientes_id = cl.clientes_id

			WHERE c.cotizacion_id = '$cotizacion_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getCorreoServer($correo_tipo_id){

			$query = "SELECT c.correo_id AS 'correo_id', c.correo_tipo_id AS 'correo_tipo_id', ct.nombre AS 'tipo_correo', c.server AS 'server', c.correo AS 'correo', c.port AS 'port', c.smtp_secure AS 'smtp_secure', c.estado AS 'estado', c.password AS 'password'

			FROM correo AS c

			INNER JOIN correo_tipo AS ct

			ON c.correo_tipo_id = ct.correo_tipo_id

			WHERE ct.nombre = '$correo_tipo_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getNumeroFactura($facturas_id){
			$query = "SELECT f.number AS 'numero', sf.prefijo AS 'prefijo', sf.relleno AS 'relleno'
				FROM facturas AS f
				INNER JOIN clientes AS c
				ON f.clientes_id = c.clientes_id
				INNER JOIN secuencia_facturacion AS sf
				ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id
				WHERE f.facturas_id = '$facturas_id'";

			$result = self::connection()->query($query);


			return $result;
		}


		public function getNumeroCompra($compras_id){
			$query = "SELECT c.number AS 'numero'
				FROM compras AS c
				INNER JOIN proveedores AS p
				ON c.proveedores_id = p.proveedores_id
				WHERE c.compras_id = '$compras_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getNombreCliente($clientes_id){
			$query = "SELECT nombre
			FROM clientes
			WHERE clientes_id = '$clientes_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getNombreClienteFactura($factura_id){
			$query = "SELECT c.nombre 'nombre'
			FROM facturas AS f
			INNER JOIN clientes AS c
			ON f.clientes_id = c.clientes_id
			WHERE f.facturas_id = '$factura_id'";

			$result = self::connection()->query($query);

			return $result;
		}	
		
		public function getNombreClienteFacturaCompras($compras_id){
			$query = "SELECT p.nombre AS 'nombre'
			FROM compras AS c
			INNER JOIN proveedores AS p
			ON c.proveedores_id = p.proveedores_id
			WHERE c.compras_id = '$compras_id'";

			$result = self::connection()->query($query);

			return $result;
		}	
		
		public function getImporteCompras($compras_id){
			$query = "SELECT importe
			FROM compras 
			WHERE compras_id = '$compras_id'";

			$result = self::connection()->query($query);

			return $result;
		}			
		
		public function getImporteFacturas($facturas_id){
			$query = "SELECT importe
			FROM facturas 
			WHERE facturas_id = '$facturas_id'";

			$result = self::connection()->query($query);

			return $result;
		}			

		public function getRTNCliente($clientes_id, $rtn){
			$query = "SELECT rtn
			FROM clientes
			WHERE rtn = '$rtn'";
			$result = self::connection()->query($query);

			return $result;
		}

		public function actualizarRTNCliente($clientes_id, $rtn){
			$update = " UPDATE clientes
				SET rtn = '$rtn'
				WHERE clientes_id = '$clientes_id'";

			$result = self::connection()->query($update);
			return $result;
		}

		public function getBarCode($productos_id, $barcode){
			$query = "SELECT productos_id
			FROM productos
			WHERE barCode = '$barcode'";
			$result = self::connection()->query($query);

			return $result;
		}		

		public function actualizarBarCode($productos_id, $barcode){
			$update = " UPDATE productos
				SET barCode = '$barcode'
				WHERE productos_id = '$productos_id'";

			$result = self::connection()->query($update);
			return $result;
		}

		public function getNombreProveedor($proveedores_id){
			$query = "SELECT nombre
			FROM proveedores
			WHERE proveedores_id = '$proveedores_id'";

			$result = self::connection()->query($query);

			return $result;
		}		

		public function getRTNProveedor($proveedores_id, $rtn){
			$query = "SELECT rtn
			FROM proveedores
			WHERE rtn = '$rtn'";

			$result = self::connection()->query($query);

			return $result;
		}				

		public function actualizarRTNProveedor($proveedores_id, $rtn){
			$update = " UPDATE proveedores
				SET rtn = '$rtn'
				WHERE proveedores_id = '$proveedores_id'";

			$result = self::connection()->query($update);
			return $result;
		}

		public function getNumeroCotizacion($cotizacion_id){
			$query = "SELECT c.number AS 'numero', cl.nombre AS 'cliente'
			FROM cotizacion AS c
			INNER JOIN clientes AS cl
			ON c.clientes_id = cl.clientes_id
			WHERE c.cotizacion_id = '$cotizacion_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		function rellenarDigitos($valor, $long){
			$numero = str_pad($valor, $long, '0', STR_PAD_LEFT);

			return $numero;
		}

		function getMontoTipoPago($apertura_id){
			$query = "SELECT tp.cuentas_id AS 'cuentas_id', tp.nombre AS 'tipo_pago', SUM(pd.efectivo) AS 'monto'
				FROM facturas AS f
				INNER JOIN pagos AS p
				ON f.facturas_id = p.facturas_id
				INNER JOIN pagos_detalles AS pd
				ON p.pagos_id = pd.pagos_id
				INNER JOIN tipo_pago AS tp
				ON pd.tipo_pago_id = tp.tipo_pago_id
				WHERE f.apertura_id = '$apertura_id'
				GROUP BY tp.cuentas_id";

			$result = self::connection()->query($query);
			
			return $result;

		}



		function getMontoTipoPagoCompras($compras_id){

			$query = "SELECT tp.tipo_pago_id As 'tipo_pago_id', SUM(cd.isv_valor) AS 'isv_valor', SUM(cd.descuento) AS 'descuento', SUM(pd.efectivo) AS 'monto', tp.cuentas_id As 'cuentas_id'

				FROM compras AS c

				INNER JOIN compras_detalles AS cd

				ON c.compras_id = cd.compras_detalles_id

				INNER JOIN pagoscompras AS p

				ON c.compras_id = p.compras_id

				INNER JOIN pagoscompras_detalles AS pd

				ON p.pagoscompras_id = pd.pagoscompras_id

				INNER JOIN tipo_pago As tp

				ON pd.tipo_pago_id = tp.tipo_pago_id

				WHERE c.compras_id = '$compras_id'

				GROUP BY tp.cuentas_id";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getDetalleCompra($noFactura){

			$query = "SELECT p.nombre AS 'producto', cd.cantidad As 'cantidad', cd.precio AS 'precio', cd.descuento AS 'descuento', cd.productos_id  AS 'productos_id', cd.isv_valor AS 'isv_valor'
				FROM compras_detalles AS cd
				INNER JOIN productos AS p
				ON cd.productos_id = p.productos_id
				WHERE cd.compras_id = '$noFactura'
				GROUP BY cd.productos_id";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getDetalleCotizaciones($noCotizacion){
			$query = "SELECT p.barCode AS 'barCode', p.nombre AS 'producto',
				 cd.cantidad As 'cantidad', cd.precio AS 'precio', cd.descuento AS 'descuento',
				  cd.productos_id  AS 'productos_id', cd.isv_valor AS 'isv_valor',med.nombre AS 'medida'
				FROM cotizacion_detalles AS cd
				INNER JOIN productos AS p
				ON cd.productos_id = p.productos_id
				INNER JOIN medida as med ON p.medida_id = med.medida_id
				WHERE cd.cotizacion_id = '$noCotizacion'
				";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getDetalleCompras($compras_id){

			$query = "SELECT
			p.nombre AS 'producto',
			cd.cantidad AS 'cantidad',
			cd.precio AS 'precio',
			cd.descuento AS 'descuento',
			cd.productos_id AS 'productos_id',
			cd.isv_valor AS 'isv_valor',
			med.nombre AS 'medida'
			FROM
				compras_detalles AS cd
			INNER JOIN productos AS p ON cd.productos_id = p.productos_id
			INNER JOIN medida as med ON p.medida_id = med.medida_id
			WHERE cd.compras_id = '$compras_id'";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getEmpresasEdit($empresa_id){
			$query = "SELECT *
				FROM empresa
				WHERE empresa_id = '$empresa_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getPrivilegiosEdit($privilegio_id){

			$query = "SELECT *

				FROM privilegio

				WHERE privilegio_id = '$privilegio_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTipoUsuariosAcceso($privilegio_id){

			$query = "SELECT *

				FROM permisos

				WHERE tipo_user_id = '$privilegio_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getPrivilegiosAccesoMenu($privilegio_id){

			$query = "SELECT am.acceso_menu_id AS 'acceso_menu_id ', m.name AS 'menu', am.estado AS 'estado'

				FROM acceso_menu am

				INNER JOIN menu AS m

				ON am.menu_id = m.menu_id

				WHERE am.privilegio_id = '$privilegio_id'";

			$result = self::connection()->query($query);



			return $result;

		}



		public function getPrivilegiosAccesoSubMenu($privilegio_id){

			$query = "SELECT asm.acceso_submenu_id AS 'acceso_menu_id ', sm.name AS 'submenu', asm.estado AS 'estado'

				FROM acceso_submenu asm

				INNER JOIN submenu AS sm

				ON asm.submenu_id = sm.submenu_id

				WHERE asm.privilegio_id = '$privilegio_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getPrivilegiosAccesoSubMenu1($privilegio_id){

			$query = "SELECT asm.acceso_submenu1_id AS 'acceso_menu_id ', sm.name AS 'submenu1', asm.estado AS 'estado', asm.privilegio_id

				FROM acceso_submenu1 asm

				INNER JOIN submenu1 AS sm

				ON asm.submenu1_id = sm.submenu1_id

				WHERE asm.privilegio_id = '$privilegio_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function consultar_usuario($colaborador_id, $contraseña_anterior){

			$query = "SELECT *

			FROM users

			WHERE colaboradores_id = '$colaborador_id' AND password = '$contraseña_anterior'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getCajasEdit($apertura_id){
				$query = "SELECT a.fecha AS 'fecha', a.factura_inicial AS 'factura_inicial', a.factura_final AS 'factura_final', a.apertura AS 'monto_apertura', (CASE WHEN a.estado = '1' THEN 'Activa' ELSE 'Inactiva' END) AS 'caja', CONCAT(c.nombre, ' ', c.apellido) AS 'usuario', a.colaboradores_id AS 'colaboradores_id', a.apertura_id AS 'apertura_id'

				FROM apertura AS a

				INNER JOIN colaboradores AS c

				ON a.colaboradores_id = c.colaboradores_id

				WHERE a.apertura_id = '$apertura_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTipoUsuarioEdit($tipo_user_id){

			$query = "SELECT *

				FROM tipo_user

				WHERE tipo_user_id = '$tipo_user_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTipoProductosEdit($productos_id){

			$query = "SELECT p.*, tp.nombre AS 'tipo_producto'

				FROM productos AS p

				INNER JOIN tipo_producto AS tp

				ON p.tipo_producto_id = tp.tipo_producto_id

				WHERE productos_id = '$productos_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getUbicacionEdit($ubicacion_id){

			$query = "SELECT *

				FROM ubicacion

				WHERE ubicacion_id = '$ubicacion_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getMedidaEdit($medida_id){

			$query = "SELECT *

				FROM medida

				WHERE medida_id = '$medida_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getCategoriaProductoEdit($categoria_id){

			$query = "SELECT *

				FROM categoria

				WHERE categoria_id = '$categoria_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getAlmacenEdit($almacen_id){

			$query = "SELECT *

				FROM almacen

				WHERE almacen_id = '$almacen_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTotalFacturasDisponiblesDB($empresa_id){

			$query = "SELECT siguiente AS 'numero'

				FROM secuencia_facturacion

				WHERE activo = 1 AND empresa_id = '$empresa_id'

				ORDER BY siguiente DESC LIMIT 1";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getNumeroMaximoPermitido($empresa_id){

			$query = "SELECT rango_final AS 'numero'

				FROM secuencia_facturacion

				WHERE activo = 1 AND empresa_id = '$empresa_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getFechaLimiteFactura($empresa_id){

			$query = "SELECT DATEDIFF(fecha_limite, NOW()) AS 'dias_transcurridos', fecha_limite AS 'fecha_limite'

				FROM secuencia_facturacion

				WHERE activo = 1 AND empresa_id = '$empresa_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getCorreoEdit($correo_id){

			$query = "SELECT c.correo_id AS 'correo_id', c.correo_tipo_id AS 'correo_tipo_id', ct.nombre AS 'tipo_correo', c.server AS 'server', c.correo AS 'correo', c.port AS 'port', c.smtp_secure AS 'smtp_secure', c.estado AS 'estado', c.password AS 'password'

				FROM correo AS c

				INNER JOIN correo_tipo AS ct

				ON c.correo_tipo_id = ct.correo_tipo_id

				WHERE c.correo_id = '$correo_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTipoPagoEdit($tipo_pago_id){

			$query = "SELECT *

				FROM tipo_pago

				WHERE tipo_pago_id = '$tipo_pago_id'";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getBancosEdit($banco_id){
			$query = "SELECT *
				FROM banco
				WHERE banco_id = '$banco_id'";

			$result = self::connection()->query($query);

			return $result;
		}



		public function getEgresosEdit($egresos_id){

			$query = "SELECT *

				FROM egresos

				WHERE egresos_id = '$egresos_id'";



			$result = self::connection()->query($query);

			return $result;
		}


		public function getIngresosEdit($ingresos_id){
			$query = "SELECT *
				FROM ingresos
				WHERE ingresos_id = '$ingresos_id'";

			$result = self::connection()->query($query);


			return $result;
		}


		public function getVigenciaCotizacion(){
			$query = "SELECT *
				FROM vigencia_cotizacion";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getMovimientosProductos($datos){
			$producto = '';
			$cliente = '';
			$tipo = '';
			$fecha = '';

			$fecha_actual = date("Y-m-d");

			if($datos['fechai'] != $fecha_actual){
				$fecha = "AND CAST(m.fecha_registro AS DATE) BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'";
			}

			if($datos['bodega'] != ''){
				$bodega = "AND bo.almacen_id = '".$datos['bodega']."'";
			}else{ $bodega = '';}

			if($datos['bodega'] == '0'){
				$bodega = '';
			}

			if($datos['producto'] != ''){
				$producto =  "AND p.productos_id = '".$datos['producto']."'";
			}

			if($datos['cliente'] != ''){
				$cliente =  "AND m.clientes_id = '".$datos['cliente']."'";
			}
			
			if($datos['tipo_producto_id'] != ''){
				$tipo = "AND p.tipo_producto_id = '".$datos['tipo_producto_id']."'";
			}

			$query = "
					SELECT
					cl.nombre as cliente,
					m.comentario,
					m.movimientos_id AS 'movimientos_id',
					p.barCode AS 'barCode',
					p.nombre AS 'producto',
					me.nombre AS 'medida',
					m.cantidad_entrada AS 'entrada',
					m.cantidad_salida AS 'salida',
					m.saldo AS 'saldo',
					bo.nombre AS 'bodega',
					bo.almacen_id,
					DATE_FORMAT(
						m.fecha_registro,
						'%d/%m/%Y %H:%i:%s'
					) AS 'fecha_registro',
					m.documento AS 'documento',
					p.productos_id AS 'productos_id'
				FROM
					movimientos AS m
				INNER JOIN productos AS p
				ON
					m.productos_id = p.productos_id
				INNER JOIN medida AS me
				ON
					p.medida_id = me.medida_id
				INNER JOIN almacen AS bo
				on p.almacen_id = bo.almacen_id
				LEFT JOIN clientes AS cl ON cl.clientes_id = m.clientes_id
				WHERE p.estado = 1
				$fecha
				$bodega
				$producto
				$cliente
				$tipo
				ORDER BY m.fecha_registro DESC";

			$result = self::connection()->query($query);
		
			return $result;
		}

		public function getTranferenciaProductos($datos){
			$bodega = '';
			$tipo_product = '';
			$id_producto = '';

			if($datos['bodega'] != ''){
				$bodega = "AND bo.almacen_id = '".$datos['bodega']."'";
			}

			if($datos['bodega'] == '0'){
				$bodega = '';
			}

			if($datos['tipo_producto_id'] != ''){
				$tipo_product = "AND p.tipo_producto_id = '".$datos['tipo_producto_id']."'";
			}

			if($datos['productos_id'] != '' || is_null($datos['productos_id'])){
				$id_producto = "AND p.productos_id = '".$datos['productos_id']."'";
			}

			$query = "
			SELECT
			m.almacen_id AS 'almacen_id',
			m.movimientos_id AS 'movimientos_id',
			p.barCode AS 'barCode',
			p.nombre AS 'producto',
			me.nombre AS 'medida',
			SUM(m.cantidad_entrada) AS 'entrada',
			SUM(m.cantidad_salida) AS 'salida',
			(
				SUM(m.cantidad_entrada) - SUM(m.cantidad_salida)
			) AS 'saldo',
			bo.nombre AS 'bodega',
			DATE_FORMAT(
				p.fecha_registro,
				'%d/%m/%Y %H:%i:%s'
			) AS 'fecha_registro',
			p.productos_id AS 'productos_id',
			p.id_producto_superior
		FROM
			movimientos AS m
		INNER JOIN productos AS p ON m.productos_id = p.productos_id
		INNER JOIN medida AS me ON p.medida_id = me.medida_id
		INNER JOIN almacen AS bo ON m.almacen_id = bo.almacen_id
					WHERE p.estado = 1
					$tipo_product
				    $bodega
					$id_producto
					GROUP BY p.productos_id, m.almacen_id
				    ORDER BY p.fecha_registro ASC";
	
			$result = self::connection()->query($query);
			//echo 'quersdfasd  '.$query;
			return $result;
		}

		public function consultaVentas($datos){
			$tipo_factura_reporte = '';
			$facturador = '';
			$fecha = '';
			$vendedor = '';

			if($datos['tipo_factura_reporte'] == 1){
				$tipo_factura_reporte = "AND f.estado IN(2,3)";
			}

			if($datos['tipo_factura_reporte'] == 2){
				$tipo_factura_reporte = "AND f.estado = 4";
			}	
			
			if($datos['facturador'] != ""){
				$facturador = "AND f.usuario = '".$datos['facturador']."'";
			}				

			if($datos['vendedor'] != ""){
				$vendedor = "AND f.colaboradores_id = '".$datos['vendedor']."'";
			}

			$query = "SELECT 
				f.facturas_id AS 'facturas_id', DATE_FORMAT(f.fecha, '%d/%m/%Y') AS 'fecha', c.nombre AS 'cliente', 
				CONCAT(sf.prefijo,'',LPAD(f.number, sf.relleno, 0)) AS 'numero', FORMAT(f.importe,2) As 'total', 
				(CASE WHEN f.tipo_factura = 1 THEN 'Contado' ELSE 'Crédito' END) AS 'tipo_documento', CONCAT(co.nombre, ' ', co.apellido) AS 'vendedor', CONCAT(co1.nombre, ' ', co1.apellido) AS 'facturador'
				FROM facturas AS f
				INNER JOIN clientes AS c
				ON f.clientes_id = c.clientes_id
				INNER JOIN colaboradores AS co
				ON f.colaboradores_id = co.colaboradores_id
				INNER JOIN colaboradores AS co1
				ON f.usuario = co1.colaboradores_id
				INNER JOIN secuencia_facturacion AS sf
				ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id
				WHERE f.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'
				$tipo_factura_reporte
				$facturador
				$vendedor
				ORDER BY f.number ASC";

			$result = self::connection()->query($query);
			return $result;
		}

		public function consultaCXPagoFactura($facturas_id){
			$query = "SELECT cobrar_clientes_id  FROM cobrar_clientes WHERE facturas_id = '".$facturas_id."' AND estado = 2";
	
			$result = self::connection()->query($query);
			return $result;
		}		

		public function consultaCXPagoFacturaCompras($compras_id){
			$query = "SELECT pagar_proveedores_id  FROM pagar_proveedores WHERE compras_id = '".$compras_id."' AND estado = 2";
	
			$result = self::connection()->query($query);
			return $result;
		}		


		public function consultaImpresora(){		
			$query = "
				SELECT
				*
				FROM `impresora`
				";

			$result = self::connection()->query($query);
			return $result;
		}

		public function updateImpresora($id,$estado){
			$fecha_registro = date("Y-m-d H:i:s");	

			$update = " UPDATE impresora
				SET 
					estado = '$estado',
					fecha_registro = '$fecha_registro'
				WHERE impresora_id = '$id'";

			$result = self::connection()->query($update);
			return $result;
		}

		public function consultaBillDraft($datos){
			$query = "SELECT f.facturas_id AS 'facturas_id', DATE_FORMAT(f.fecha, '%d/%m/%Y') AS 'fecha', c.nombre AS 'cliente', CONCAT(sf.prefijo,'',LPAD(f.number, sf.relleno, 0)) AS 'numero', FORMAT(f.importe,2) As 'total', (CASE WHEN f.tipo_factura = 1 THEN 'Contado' ELSE 'Crédito' END) AS 'tipo_documento', f.number AS 'numero_factura'
				FROM facturas AS f
				INNER JOIN clientes AS c
				ON f.clientes_id = c.clientes_id
				INNER JOIN secuencia_facturacion AS sf
				ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id
				WHERE f.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND f.estado = 1";

			$result = self::connection()->query($query);

			return $result;
		}	

		public function consultaCompras($datos){
			if($datos['tipo_compra_reporte'] == 1){
				$where = "WHERE c.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND c.estado IN(2,3)";
			}else{
				$where = "WHERE c.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND c.estado = 4";
			}

			$query = "SELECT c.compras_id AS 'compras_id', DATE_FORMAT(c.fecha, '%d/%m/%Y') AS 'fecha', p.nombre AS 'proveedor', c.number AS 'numero', FORMAT(c.importe,2) As 'total', (CASE WHEN c.tipo_compra = 1 THEN 'Contado' ELSE 'Crédito' END) AS 'tipo_documento'
				FROM compras AS c
				INNER JOIN proveedores AS p
				ON c.proveedores_id = p.proveedores_id
				".$where;

			$result = self::connection()->query($query);

			return $result;
		}

		public function consultaCotizaciones($datos){
			if($datos['tipo_cotizacion_reporte'] == 1){
				$where = "WHERE c.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND c.estado = 1";
			}else{
				$where = "WHERE c.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."' AND c.estado = 2";
			}

			$query = "SELECT c.cotizacion_id AS 'cotizacion_id', DATE_FORMAT(c.fecha, '%d/%m/%Y') AS 'fecha', cl.nombre AS 'cliente', c.number AS 'numero', FORMAT(c.importe,2) As 'total', (CASE WHEN c.tipo_factura = 1 THEN 'Contado' ELSE 'Crédito' END) AS 'tipo_documento'
				FROM cotizacion AS c
				INNER JOIN clientes AS cl
				ON c.clientes_id = cl.clientes_id
				".$where;

			$result = self::connection()->query($query);

			return $result;
		}


		public function getBanco(){
			$query = "SELECT * FROM banco";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getImpuestos(){
			$query = "SELECT isv_id, valor, (CASE WHEN isv_tipo_id = 1 THEN 'Factura' ELSE 'Compra' END) AS 'tipo_isv_nombre'
				FROM isv";

			$result = self::connection()->query($query);

			return $result;
		}


		public function getImpuestosEdit($isv_id){

			$query = "SELECT isv_id, valor, (CASE WHEN isv_tipo_id = 1 THEN 'Factura' ELSE 'Compra' END) AS 'tipo_isv_nombre', isv_tipo_id

				FROM isv

				WHERE isv_id = '$isv_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTipoPago(){

			$query = "SELECT * FROM tipo_pago";



			$result = self::connection()->query($query);



			return $result;

		}

		public function getDatosFactura($facturas_id){
			$query = "SELECT
			f.facturas_id AS facturas_id,
			DATE_FORMAT(f.fecha, '%d/%m/%Y') AS fecha,
			c.clientes_id AS clientes_id,
			c.nombre AS cliente,
			c.rtn AS rtn,
			CONCAT(
					ven.nombre,
					' ',
					ven.apellido
				) AS profesional,
			f.colaboradores_id AS colaborador_id,
			f.estado AS estado,
			f.fecha AS fecha_factura,
			f.notas AS notas,
			f.tipo_factura AS credito,
			cobrar_clientes.saldo
			FROM
			facturas AS f
			INNER JOIN clientes AS c ON f.clientes_id = c.clientes_id
			INNER JOIN colaboradores AS ven ON f.colaboradores_id = ven.colaboradores_id
			INNER JOIN cobrar_clientes ON f.facturas_id = cobrar_clientes.facturas_id
			WHERE
				f.facturas_id = '$facturas_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getDetalleProductosFactura($facturas_id){

			$query = "SELECT fd.productos_id AS 'productos_id', p.nombre AS 'producto', fd.cantidad AS 'cantidad', fd.precio AS 'precio', fd.isv_valor AS 'isv_valor', fd.descuento AS 'descuento'

				FROM facturas_detalles AS fd

				INNER JOIN facturas As f

				ON fd.facturas_id = f.facturas_id

				INNER JOIN productos AS p

				ON fd.productos_id = p.productos_id

				WHERE fd.facturas_id = '$facturas_id'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getDatosCompras($compras_id){
			$query = "SELECT c.compras_id AS compras_id, DATE_FORMAT(c.fecha, '%d/%m/%Y') AS 'fecha',
			 c.proveedores_id AS 'proveedores_id', p.nombre AS 'proveedor', p.rtn AS 'rtn',
			  c.estado AS 'estado', c.fecha AS 'fecha_compra', c.notas AS 'notas',tipo_compra
				FROM compras AS c
				INNER JOIN proveedores AS p
				ON c.proveedores_id = p.proveedores_id
				WHERE c.compras_id = '$compras_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getDetalleProductosCompras($compras_id){
			$query = "SELECT cd.productos_id AS 'productos_id', p.nombre AS 'producto', cd.cantidad AS 'cantidad', cd.precio AS 'precio', cd.isv_valor AS 'isv_valor', cd.descuento AS 'descuento'
				FROM compras_detalles AS cd
				INNER JOIN compras As c
				ON cd.compras_id = c.compras_id
				INNER JOIN productos AS p
				ON cd.productos_id = p.productos_id
				WHERE cd.compras_id = '$compras_id'";
			$result = self::connection()->query($query);

			return $result;
		}

		public function getCuentasporCobrarClientes($datos){
			$clientes_id = "";
			$fecha_actual = date("Y-m-d");
			$fecha = "";

			if($datos['fechai'] != $fecha_actual){
				$fecha = "AND cc.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'";
			}

			if($datos['clientes_id'] != 0){
				$clientes_id = "AND cc.clientes_id = '".$datos['clientes_id']."'";
			}

			$query = "SELECT cc.cobrar_clientes_id AS 'cobrar_clientes_id', f.facturas_id AS 'facturas_id', c.nombre AS 'cliente',
				 f.fecha AS 'fecha', cc.saldo AS 'saldo', CONCAT(sf.prefijo,'',LPAD(f.number, sf.relleno, 0)) AS 'numero', cc.estado,
				 f.importe, CONCAT(co.nombre, ' ', co.apellido) AS 'vendedor'
				FROM cobrar_clientes AS cc
				INNER JOIN clientes AS c
				ON cc.clientes_id = c.clientes_id
				INNER JOIN facturas AS f
				ON cc.facturas_id = f.facturas_id
				INNER JOIN secuencia_facturacion AS sf
				ON f.secuencia_facturacion_id = sf.secuencia_facturacion_id
				INNER JOIN colaboradores AS co
				ON f.colaboradores_id = co.colaboradores_id				
				WHERE cc.estado = '".$datos['estado']."'
				$fecha
				$clientes_id
				ORDER BY cc.fecha ASC";				

			$result = self::connection()->query($query);

			return $result;
		}

		public function getAbonosCobrarClientes($facturas_id){
			$query = "SELECT SUM(importe) As 'total'
			FROM pagos
			WHERE facturas_id = '$facturas_id'";
			$result = self::connection()->query($query);

			return $result;
		}
		
		public function getCuentasporPagarProveedores($datos){
			$proveedores_id = "";
			$fecha_actual = date("Y-m-d");
			$fecha = "";

			if($datos['fechai'] != $fecha_actual){
				$fecha = "AND proveedores.fecha BETWEEN '".$datos['fechai']."' AND '".$datos['fechaf']."'";
			}

			if($datos['proveedores_id'] != 0){
				$proveedores_id = "AND proveedores.proveedores_id = '".$datos['proveedores_id']."'";
			}

			$query = "SELECT
			proveedores.nombre AS 'proveedores',
			compras.compras_id,
			compras.number AS 'factura',
			compras.importe,
			compras.estado,
			compras.fecha
			FROM
			proveedores
			INNER JOIN compras ON proveedores.proveedores_id = compras.proveedores_id
			WHERE proveedores.estado = '".$datos['estado']."'
			$fecha
			$proveedores_id
			ORDER BY proveedores.fecha ASC";	

			$result = self::connection()->query($query);

			return $result;
		}


		public function getAbonosPagarProveedores($compras_id){
			$query = "SELECT SUM(importe) As 'total'
			FROM pagoscompras
			WHERE compras_id = '$compras_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		public function getCuentasporPagarClientes(){

			$query = "";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getlastUpdate($entidad){

			$query = "SELECT * FROM ".$entidad."

				ORDER BY ".$entidad."_id DESC LIMIT 1";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getlastUpdateHistorialAccessos(){

			$query = "SELECT * FROM historial_acceso

				ORDER BY historial_acceso_id  DESC LIMIT 1";



			$result = self::connection()->query($query);



			return $result;

		}



		protected function getMenuAccesoLoginConsulta($privilegio_id, $menu){

			$query = "SELECT am.acceso_menu_id AS 'acceso_menu_id', m.name AS 'name'

				FROM acceso_menu AS am

				INNER JOIN menu AS m

				ON am.menu_id = m.menu_id

				WHERE am.privilegio_id = '$privilegio_id' AND m.name = '$menu' AND am.estado = 1";

			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);



			return $sql;

		}



		function getSubMenuAccesoLoginConsulta($privilegio_id, $menu){

			$query = "SELECT asm.acceso_submenu_id AS 'acceso_menu_id', sm.name AS 'name'

				FROM acceso_submenu AS asm

				INNER JOIN submenu AS sm

				ON asm.submenu_id = sm.submenu_id

				WHERE asm.privilegio_id = '$privilegio_id' AND sm.name = '$menu' AND asm.estado = 1";



			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);



			return $sql;

		}



		function getSubMenu1AccesoLoginConsulta($privilegio_id, $menu){

			$query = "SELECT asm.acceso_submenu1_id AS 'acceso_menu_id', sm.name AS 'name'

				FROM acceso_submenu1 AS asm

				INNER JOIN submenu1 AS sm

				ON asm.submenu1_id = sm.submenu1_id

				WHERE asm.privilegio_id = '$privilegio_id' AND sm.name = '$menu' AND asm.estado = 1";

			$sql = mainModel::connection()->query($query) or die(mainModel::connection()->error);



			return $sql;

		}



		public function getTotalBills(){

			$fecha = date("Y-m-d");

			$año = date("Y", strtotime($fecha));

			$mes = date("m", strtotime($fecha));

			$dia = date("d", mktime(0,0,0, $mes+1, 0, $año));



			$dia1 = date('d', mktime(0,0,0, $mes, 1, $año)); //PRIMER DIA DEL MES

			$dia2 = date('d', mktime(0,0,0, $mes, $dia, $año)); // ULTIMO DIA DEL MES



			$fecha_inicial = date("Y-m-d", strtotime($año."-".$mes."-".$dia1));

			$fecha_final = date("Y-m-d", strtotime($año."-".$mes."-".$dia2));



			$query = "SELECT SUM(importe) AS 'total'

				FROM facturas

				WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function nombremes($mes){

			setlocale(LC_TIME, 'spanish');

			$nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000));

			return $nombre;

		}



		public function getTotalPurchases(){

			$fecha = date("Y-m-d");

			$año = date("Y", strtotime($fecha));

			$mes = date("m", strtotime($fecha));

			$dia = date("d", mktime(0,0,0, $mes+1, 0, $año));



			$dia1 = date('d', mktime(0,0,0, $mes, 1, $año)); //PRIMER DIA DEL MES

			$dia2 = date('d', mktime(0,0,0, $mes, $dia, $año)); // ULTIMO DIA DEL MES



			$fecha_inicial = date("Y-m-d", strtotime($año."-".$mes."-".$dia1));

			$fecha_final = date("Y-m-d", strtotime($año."-".$mes."-".$dia2));



			$query = "SELECT sum(importe) AS 'total'

				FROM compras

				WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTotalCustomers(){

			$query = "SELECT COUNT(clientes_id) AS 'total'

				FROM clientes

				WHERE estado = 1";



			$result = self::connection()->query($query);



			return $result;

		}



		public function getTotalSuppliers(){

			$query = "SELECT COUNT(proveedores_id) AS 'total'

				FROM proveedores

				WHERE estado = 1";



			$result = self::connection()->query($query);



			return $result;

		}



		function getTheDay($date, $hora){

			if($date !=""){

				$curr_date=strtotime(date("Y-m-d H:i:s"));

				$the_date=strtotime($date);

				$diff=floor(($curr_date-$the_date)/(60*60*24));



				switch($diff){

					case 0:

						return "Hoy ".$hora;

						break;

					case 1:

						return "Ayer ".$hora;

						break;

					default:

						return " Hace ".$diff." Días";

				}

			}else{

				return "No se encontraron actualizaciones";

			}

		}



		function getUserSistema($colaboradores_id){

			$query = "SELECT colaboradores_id, CONCAT(nombre, ' ', apellido) AS 'colaborador'

				FROM colaboradores

				WHERE colaboradores_id = '$colaboradores_id'";



			$result = self::connection()->query($query);



			return $result;

		}





		function getConsumidorVenta(){

			$query = "SELECT clientes_id, nombre AS 'cliente', rtn

				FROM clientes

				ORDER BY clientes_id ASC LIMIT 1";



			$result = self::connection()->query($query);



			return $result;

		}



		function getCajero($colaborador_id_sd){
			$query = "SELECT colaboradores_id AS 'colaboradores_id', CONCAT(nombre, ' ', apellido) AS 'colaborador'
				FROM colaboradores
				WHERE colaboradores_id = '$colaborador_id_sd'";

			$result = self::connection()->query($query);

			return $result;
		}


		function getNombreUsuario($users_id){
			$query = "SELECT CONCAT(c.nombre, ' ', c.apellido) AS 'usuario', c.identidad AS 'identidad'
				FROM users AS u
				INNER JOIN colaboradores AS c
				ON u.colaboradores_id = c.colaboradores_id
				WHERE u.users_id = '$users_id'";

			$result = self::connection()->query($query);

			return $result;
		}

		function getAperturaCajaUsuario($colaborador_id_sd, $fecha){

			$query = "SELECT apertura_id, estado

				FROM apertura

				WHERE fecha = '$fecha' AND colaboradores_id = '$colaborador_id_sd'

				ORDER BY apertura_id DESC LIMIT 1";



			$result = self::connection()->query($query);



			return $result;

		}

		function getAlmacenId($almacen_id){

			$query = "
			SELECT
				almacen.almacen_id,
				almacen.ubicacion_id,
				almacen.nombre,
				almacen.estado,
				almacen.empresa_id,
				almacen.facturar_cero,
				almacen.fecha_registro
				FROM
				almacen
			
				WHERE almacen_id = '$almacen_id' ";



			$result = self::connection()->query($query);



			return $result;

		}



		function getFacturasAnual($año){

			$query = "SELECT fecha as 'fecha', SUM(importe) as 'total'

				FROM facturas

				WHERE YEAR(fecha) = '$año'

				GROUP BY MONTH(fecha)

				ORDER BY MONTH(fecha) ASC";



			$result = self::connection()->query($query);



			return $result;

		}



		function getComprasAnual($año){

			$query = "SELECT fecha as 'fecha', SUM(importe) as 'total'

				FROM compras

				WHERE YEAR(fecha) = '$año'

				GROUP BY MONTH(fecha)

				ORDER BY MONTH(fecha) ASC";



			$result = self::connection()->query($query);



			return $result;

		}



		function sendMail($servidor, $puerto, $contraseña, $CharSet, $SMTPSecure, $de, $para, $from, $asunto, $mensaje, $URL){

			$cabeceras = "MIME-Version: 1.0\r\n";

			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";

			$cabeceras .= "From: $de \r\n";



			//incluyo la clase phpmailer

			include_once("phpmailer/class.phpmailer.php");

			include_once("phpmailer/class.smtp.php");



			$mail = new PHPMailer(); //creo un objeto de tipo PHPMailer

			$mail->SMTPDebug = 1;

			$mail->IsSMTP(); //protocolo SMTP

			$mail->IsHTML(true);

			$mail->CharSet = $CharSet;

			$mail->SMTPAuth = true;//autenticación en el SMTP

			$mail->SMTPSecure = $SMTPSecure;

			$mail->SMTPOptions = array(

				'ssl' => array(

					'verify_peer' => false,

					'verify_peer_name' => false,

					'allow_self_signed' => true

				)

			);

			$mail->Host = $servidor;//servidor de SMTP de gmail

			$mail->Port = $puerto;//puerto seguro del servidor SMTP de gmail

			$mail->From = $de; //Remitente del correo

			$mail->FromName = $from; //Remitente del correo

			$mail->AddAddress($para);// Destinatario

			$mail->Username = $de;//Aqui pon tu correo

			$mail->Password = $contraseña;//Aqui pon tu contraseña de gmail

			$mail->Subject = $asunto; //Asunto del correo

			$mail->Body = $mensaje; //Contenido del correo



			if($URL !=""){

				$mail->AddAttachment($URL, $asunto.'.pdf');

			}



			$mail->WordWrap = 50; //No. de columnas

			$mail->MsgHTML($mensaje);//Se indica que el cuerpo del correo tendrá formato html



			if($para != ""){

				if($mail->Send()){ //enviamos el correo por PHPMailer



				}else{



				}

			}else{



			}

		}



		function sendMailOpciones($servidor, $puerto, $contraseña, $CharSet, $SMTPSecure, $de, $para, $from, $asunto, $mensaje, $URL){

			$cabeceras = "MIME-Version: 1.0\r\n";

			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";

			$cabeceras .= "From: $de \r\n";



			//incluyo la clase phpmailer

			include_once("phpmailer/class.phpmailer.php");

			include_once("phpmailer/class.smtp.php");



			$mail = new PHPMailer(); //creo un objeto de tipo PHPMailer

			$mail->SMTPDebug = 1;

			$mail->IsSMTP(); //protocolo SMTP

			$mail->IsHTML(true);

			$mail->CharSet = $CharSet;

			$mail->SMTPAuth = true;//autenticación en el SMTP

			$mail->SMTPSecure = $SMTPSecure;

			$mail->SMTPOptions = array(

				'ssl' => array(

					'verify_peer' => false,

					'verify_peer_name' => false,

					'allow_self_signed' => true

				)

			);

			$mail->Host = $servidor;//servidor de SMTP de gmail

			$mail->Port = $puerto;//puerto seguro del servidor SMTP de gmail

			$mail->From = $de; //Remitente del correo

			$mail->FromName = $from; //Remitente del correo

			$mail->AddAddress($para);// Destinatario

			$mail->Username = $de;//Aqui pon tu correo

			$mail->Password = $contraseña;//Aqui pon tu contraseña de gmail

			$mail->Subject = $asunto; //Asunto del correo

			$mail->Body = $mensaje; //Contenido del correo



			if($URL !=""){

				$mail->AddAttachment($URL, $asunto.'.pdf');

			}



			$mail->WordWrap = 50; //No. de columnas

			$mail->MsgHTML($mensaje);//Se indica que el cuerpo del correo tendrá formato html



			if($para != ""){

				if($mail->Send()){ //enviamos el correo por PHPMailer

					echo 1;

				}else{

					echo 2;

				}

			}else{

				echo 3;

			}

		}



		function sendMailAjax($servidor, $puerto, $contraseña, $CharSet, $SMTPSecure, $de, $para, $from, $asunto, $mensaje, $URL){

			$cabeceras = "MIME-Version: 1.0\r\n";

			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";

			$cabeceras .= "From: $de \r\n";



			//incluyo la clase phpmailer

			include_once("phpmailer/class.phpmailer.php");

			include_once("phpmailer/class.smtp.php");



			$mail = new PHPMailer(); //creo un objeto de tipo PHPMailer

			$mail->SMTPDebug = 1;

			$mail->IsSMTP(); //protocolo SMTP

			$mail->IsHTML(true);

			$mail->CharSet = $CharSet;

			$mail->SMTPAuth = true;//autenticación en el SMTP

			$mail->SMTPSecure = $SMTPSecure;

			$mail->SMTPOptions = array(

				'ssl' => array(

					'verify_peer' => false,

					'verify_peer_name' => false,

					'allow_self_signed' => true

				)

			);

			$mail->Host = $servidor;//servidor de SMTP de gmail

			$mail->Port = $puerto;//puerto seguro del servidor SMTP de gmail

			$mail->From = $de; //Remitente del correo

			$mail->FromName = $from; //Remitente del correo

			$mail->AddAddress($para);// Destinatario

			$mail->Username = $de;//Aqui pon tu correo

			$mail->Password = $contraseña;//Aqui pon tu contraseña de gmail

			$mail->Subject = $asunto; //Asunto del correo

			$mail->Body = $mensaje; //Contenido del correo



			if($URL !=""){

				$mail->AddAttachment($URL, $asunto.'.pdf');

			}



			$mail->WordWrap = 50; //No. de columnas

			$mail->MsgHTML($mensaje);//Se indica que el cuerpo del correo tendrá formato html



			if($para != ""){

				if($mail->Send()){ //enviamos el correo por PHPMailer



				}else{



				}

			}else{



			}

		}

		function testingMail($servidor, $correo, $contraseña, $puerto, $SMTPSecure, $CharSet){

			$cabeceras = "MIME-Version: 1.0\r\n";

			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";

			$cabeceras .= "From: $correo \r\n";



			//incluyo la clase phpmailer

			include_once("phpmailer/class.phpmailer.php");

			include_once("phpmailer/class.smtp.php");



			$mail = new PHPMailer(); //creo un objeto de tipo PHPMailer

			$mail->SMTPDebug = 1;

			$mail->IsSMTP(); //protocolo SMTP

			$mail->IsHTML(true);

			$mail->CharSet = $CharSet;

			$mail->SMTPAuth = true;//autenticación en el SMTP

			$mail->SMTPSecure = $SMTPSecure;

			$mail->SMTPOptions = array(

				'ssl' => array(

					'verify_peer' => false,

					'verify_peer_name' => false,

					'allow_self_signed' => true

				)

			);

			$mail->Host = $servidor;//servidor de SMTP de gmail

			$mail->Port = $puerto;//puerto seguro del servidor SMTP de gmail

			$mail->From = $correo; //Remitente del correo

			$mail->FromName = $correo; //Remitente del correo

			$mail->AddAddress($correo);// Destinatario

			$mail->Username = $correo;//Aqui pon tu correo

			$mail->Password = $contraseña;//Aqui pon tu contraseña de gmail





			$mail->WordWrap = 50; //No. de columnas



			if($mail->SmtpConnect()){ //enviamos el correo por PHPMailer

				echo 1;//MENSAJE ENVIADO

			}else{

				echo 2;//MENSAJE NO ENVIADO

			}



		}

		/*FIN FUNCIONES ACCIONES EDITAR CONSULTAS FORMULARIOS*/



		/*INICIO CONVERTIR NUMEROS A LETRAS*/

		function unidad($numuero){

			switch ($numuero){

				case 9:{

					$numu = "NUEVE";

					break;

				}

				case 8:{

					$numu = "OCHO";

					break;

				}

				case 7:{

					$numu = "SIETE";

					break;

				}

				case 6:{

					$numu = "SEIS";

					break;

				}

				case 5:{

					$numu = "CINCO";

					break;

				}

				case 4:{

					$numu = "CUATRO";

					break;

				}

				case 3:{

					$numu = "TRES";

					break;

				}

				case 2:{

					$numu = "DOS";

					break;

				}

				case 1:{

					$numu = "UNO";

					break;

				}

				case 0:{

					$numu = "";

					break;

				}

			}

			return $numu;

		}



		function decena($numdero){

			if ($numdero >= 90 && $numdero <= 99){

				$numd = "NOVENTA ";

				if ($numdero > 90)

					$numd = $numd."Y ".(self::unidad($numdero - 90));

			}

			else if ($numdero >= 80 && $numdero <= 89){

				$numd = "OCHENTA ";

				if ($numdero > 80)

					$numd = $numd."Y ".(self::unidad($numdero - 80));

			}

			else if ($numdero >= 70 && $numdero <= 79){

				$numd = "SETENTA ";

				if ($numdero > 70)

				$numd = $numd."Y ".(self::unidad($numdero - 70));

			}

			else if ($numdero >= 60 && $numdero <= 69){

				$numd = "SESENTA ";

				if ($numdero > 60)

				$numd = $numd."Y ".(self::unidad($numdero - 60));

			}

			else if ($numdero >= 50 && $numdero <= 59){

				$numd = "CINCUENTA ";

				if ($numdero > 50)

				$numd = $numd."Y ".(self::unidad($numdero - 50));

			}

			else if ($numdero >= 40 && $numdero <= 49){

				$numd = "CUARENTA ";

				if ($numdero > 40)

				$numd = $numd."Y ".(self::unidad($numdero - 40));

			}

			else if ($numdero >= 30 && $numdero <= 39){

				$numd = "TREINTA ";

				if ($numdero > 30)

				$numd = $numd."Y ".(self::unidad($numdero - 30));

			}

			else if ($numdero >= 20 && $numdero <= 29){

				if ($numdero == 20)

				$numd = "VEINTE ";

				else

				$numd = "VEINTI".(self::unidad($numdero - 20));

			}

			else if ($numdero >= 10 && $numdero <= 19)

			{

				switch ($numdero){

					case 10:{

						$numd = "DIEZ ";

						break;

					}

					case 11:{

						$numd = "ONCE ";

						break;

					}

					case 12:{

						$numd = "DOCE ";

						break;

					}

					case 13:{

						$numd = "TRECE ";

						break;

					}

					case 14:{

						$numd = "CATORCE ";

						break;

					}

					case 15:{

						$numd = "QUINCE ";

						break;

					}

					case 16:{

						$numd = "DIECISEIS ";

						break;

					}

					case 17:{

						$numd = "DIECISIETE ";

						break;

					}

					case 18:{

						$numd = "DIECIOCHO ";

						break;

					}

					case 19:{

						$numd = "DIECINUEVE ";

						break;

					}

				}

			}

			else

				$numd = self::unidad($numdero);

			return $numd;

		}



		function centena($numc){

			if ($numc >= 100){

				if ($numc >= 900 && $numc <= 999){

					$numce = "NOVECIENTOS ";

				if ($numc > 900)

					$numce = $numce.(self::decena($numc - 900));

				}

				else if ($numc >= 800 && $numc <= 899){

					$numce = "OCHOCIENTOS ";

					if ($numc > 800)

						$numce = $numce.(self::decena($numc - 800));

				}

				else if ($numc >= 700 && $numc <= 799){

					$numce = "SETECIENTOS ";

					if ($numc > 700)

						$numce = $numce.(self::decena($numc - 700));

				}

				else if ($numc >= 600 && $numc <= 699){

					$numce = "SEISCIENTOS ";

					if ($numc > 600)

						$numce = $numce.(self::decena($numc - 600));

				}

				else if ($numc >= 500 && $numc <= 599){

					$numce = "QUINIENTOS ";

					if ($numc > 500)

						$numce = $numce.(self::decena($numc - 500));

				}

				else if ($numc >= 400 && $numc <= 499){

					$numce = "CUATROCIENTOS ";

					if ($numc > 400)

						$numce = $numce.(self::decena($numc - 400));

				}

				else if ($numc >= 300 && $numc <= 399){

					$numce = "TRESCIENTOS ";

					if ($numc > 300)

						$numce = $numce.(self::decena($numc - 300));

				}

				else if ($numc >= 200 && $numc <= 299){

					$numce = "DOSCIENTOS ";

					if ($numc > 200)

						$numce = $numce.(self::decena($numc - 200));

				}

				else if ($numc >= 100 && $numc <= 199){

					if ($numc == 100)

					$numce = "CIEN ";

					else

						$numce = "CIENTO ".(self::decena($numc - 100));

				}

			}

			else

				$numce = self::decena($numc);

				return $numce;

		}



		function miles($nummero){

			if ($nummero >= 1000 && $nummero < 2000){

				$numm = "MIL ".(self::centena($nummero%1000));

			}

			if ($nummero >= 2000 && $nummero <10000){

				$numm = self::unidad(Floor($nummero/1000))." MIL ".(self::centena($nummero%1000));

			}

			if ($nummero < 1000)

				$numm = self::centena($nummero);



			return $numm;

		}



		function decmiles($numdmero){

			if ($numdmero == 10000)

				$numde = "DIEZ MIL";

			if ($numdmero > 10000 && $numdmero <20000){

				$numde = self::decena(Floor($numdmero/1000))."MIL ".(self::centena($numdmero%1000));

			}

			if ($numdmero >= 20000 && $numdmero <100000){

				$numde = self::decena(Floor($numdmero/1000))." MIL ".(self::miles($numdmero%1000));

			}

			if ($numdmero < 10000)

				$numde = self::miles($numdmero);



			return $numde;

		}



		function cienmiles($numcmero){

			if ($numcmero == 100000)

				$num_letracm = "CIEN MIL";

			if ($numcmero >= 100000 && $numcmero <1000000){

				$num_letracm = self::centena(Floor($numcmero/1000))." MIL ".(self::centena($numcmero%1000));

			}

			if ($numcmero < 100000)

				$num_letracm = self::decmiles($numcmero);

			return $num_letracm;

		}



		function millon($nummiero){

			if ($nummiero >= 1000000 && $nummiero <2000000){

				$num_letramm = "UN MILLON ".(self::cienmiles($nummiero%1000000));

			}

			if ($nummiero >= 2000000 && $nummiero <10000000){

				$num_letramm = self::unidad(Floor($nummiero/1000000))." MILLONES ".(self::cienmiles($nummiero%1000000));

			}

			if ($nummiero < 1000000)

				$num_letramm = self::cienmiles($nummiero);



			return $num_letramm;

		}



		function decmillon($numerodm){

			if ($numerodm == 10000000)

				$num_letradmm = "DIEZ MILLONES";

			if ($numerodm > 10000000 && $numerodm <20000000){

				$num_letradmm = self::decena(Floor($numerodm/1000000))."MILLONES ".(self::cienmiles($numerodm%1000000));

			}

			if ($numerodm >= 20000000 && $numerodm <100000000){

				$num_letradmm = self::decena(Floor($numerodm/1000000))." MILLONES ".(self::millon($numerodm%1000000));

			}

			if ($numerodm < 10000000)

				$num_letradmm = self::millon($numerodm);



			return $num_letradmm;

		}



		function cienmillon($numcmeros){

			if ($numcmeros == 100000000)

				$num_letracms = "CIEN MILLONES";

			if ($numcmeros >= 100000000 && $numcmeros <1000000000){

				$num_letracms = self::centena(Floor($numcmeros/1000000))." MILLONES ".(self::millon($numcmeros%1000000));

			}

			if ($numcmeros < 100000000)

				$num_letracms = self::decmillon($numcmeros);

			return $num_letracms;

		}



		function milmillon($nummierod){

			if ($nummierod >= 1000000000 && $nummierod <2000000000){

				$num_letrammd = "MIL ".(self::cienmillon($nummierod%1000000000));

			}

			if ($nummierod >= 2000000000 && $nummierod <10000000000){

				$num_letrammd = self::unidad(Floor($nummierod/1000000000))." MIL ".(self::cienmillon($nummierod%1000000000));

			}

			if ($nummierod < 1000000000)

				$num_letrammd = self::cienmillon($nummierod);



			return $num_letrammd;

		}



		function convertir($numero){

			$num = str_replace(",","",$numero);

			$num = number_format($num,2,'.','');

			$cents = substr($num,strlen($num)-2,strlen($num)-1);

			$num = (int)$num;

			$numf = self::milmillon($num);


			return $numf." CON ".$cents."/100";
		}

		/*FIN CONVERTIR NUMEROS A LETRAS*/

		//CONSULTA EN EL SERVIDOR DE KIREDS PARA VALIDAR QUE EL CLIENTE EXISTA
		function connect_mysqli_main_server(){
			$mysqli_main =mysqli_connect(SERVER_MAIN,USER_MAIN,PASS_MAIN,DB_MAIN);
		
			$mysqli_main->set_charset("utf8");
		
			if ($mysqli_main->connect_errno) {
			   echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
			   exit;
			}
		
			return $mysqli_main;
		}		
    }
