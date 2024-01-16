<?php

class ApiClient {

    private $base_url;

    public function __construct($base_url) {
        $this->base_url = $base_url;
    }

    public function sendSmsClaro($msisdn, $message, $id, $api_key) {
        $url = "{$this->base_url}/send_to_contact";
        $params = [
            'msisdn' => $msisdn,
            'message' => $message,
            'id' => $id,
            'api_key' => $api_key,
        ];

        $url .= '?' . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL: ' . curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }

    public function sendSmsUp($to, $mensaje, $api_key, $from) {
        date_default_timezone_set('America/Tegucigalpa');

        $send_at = date("Y-m-d H:i:s");

        $request = '{
            "api_key":"'.$api_key.'",
            "concat":1,
            "messages":[
                {
                    "from":"'.$from.'",
                    "to":"'.$to.'",
                    "text":"'.$mensaje.'",
                    "send_at":"'.$send_at.'"
                }
            ]
        }';

        $url = $this->base_url; // Usar la URL base de la instancia actual

        $headers = array('Content-Type: application/json');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        $result = curl_exec($ch);

        if (curl_errno($ch) != 0 ){
            die("curl error: ".curl_errno($ch));
        }

        return $result;
    }
}

// Uso de la clase
$apiClientClaro = new ApiClient("http://url_api_http");
$responseClaro = $apiClientClaro->sendSmsClaro("SMSNUMBER", "SMSTEXT", "ID", "API_KEY");
echo $responseClaro;

$apiClientSmsUp = new ApiClient("https://api.gateway360.com/api/3.0/sms/send"); // URL específica para SMSUP
$responseSmsUp = $apiClientSmsUp->sendSmsUp("TO_NUMBER", "SMS_MESSAGE", "SMSUP_API_KEY", "SMSUP_FROM");
echo $responseSmsUp;