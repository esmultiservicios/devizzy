<?php
class cPanelAPI {
    private $token;
    private $url;
    private $username;
    private $password;
    
    public function __construct($token, $username, $password) {
        $this->token = $token;
        $this->url = "https://cpanel.clinicarehn.com:2083/cpsess$token/execute/Mysql/";
        $this->username = $username;
        $this->password = $password;
    }

    public function execute($instruction) {
        // Construir la URL completa con la instrucción
        $fullUrl = $this->url . $instruction;

        // Inicializar la sesión cURL
        $ch = curl_init($fullUrl);

        // Configurar opciones de cURL para autenticación
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        // Verificar si hubo errores en la solicitud
        if (curl_errno($ch)) {
            return 'Error en la solicitud cURL: ' . curl_error($ch);
        } else {
            // Decodificar la respuesta JSON en un array asociativo
            $responseData = json_decode($response, true);

            // Verificar si el campo "status" es igual a 1 (éxito)
            if (isset($responseData['status']) && $responseData['status'] == 1) {
                return '';//'La acción se completó con éxito.';
            } else {
                // Si el campo "status" no es igual a 1, verificar si hay mensajes de error
                if (isset($responseData['errors'])) {
                    $errorMessages = [];

                    // Mostrar los mensajes de error
                    foreach ($responseData['errors'] as $error) {
                        // Personalizar el mensaje de error si ya existe la base de datos
                        if (strpos($error, 'already exists') !== false) {
                            $errorMessages[] = 'Error DB: Lo sentimos, la base de datos ya existe. '.$error;

                            exit(); // Esta línea detendrá la ejecución del código
                        } else {
                            $errorMessages[] = '- ' . $error;
                        }
                    }

                    return implode('<br>', $errorMessages);
                } else {
                    // En caso de que no haya mensajes de error, mostrar un mensaje genérico de fallo
                    return 'La acción falló o no se pudo determinar el motivo.';
                }
            }
        }

        // Cerrar la sesión cURL
        curl_close($ch);
    }
}