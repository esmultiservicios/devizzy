<?php
    /*
        Parametros de conexión a la DB
    */

    if(!isset($_SESSION['user_sd'])){ 
        session_start(['name'=>'SD']); 
    } 

    //DATOS DE CONEXION DEL CLIENTE
    const SERVER = "localhost";
    const USER = "clinicarehn_clinicare";
    const PASS = "Clin1c@r32022#";

    //DATOS DE CONEXION SERVIDOR PRINCIPAL
    const SERVER_MAIN = "localhost";    
    const DB_MAIN = "clinicarehn_clientes_clinicare";
    $GLOBALS['DB_MAIN'] = DB_MAIN; 
    const USER_MAIN = "clinicarehn_clinicare";
    const PASS_MAIN = "Clin1c@r32022#";  

    //cPanel
    const tokencPanel = 'cpsessJVTCORJSCU43CUXSS7DAOOPHECPRDMXT';
    const usernamecPanel = 'clinicarehn';
    const passwordcPanel = 'S0p0rt32025%Cl1n1c@r3';

    //BASE DE DATOS EXCEPTION LOGIN CONTROLADOR
    const DB_MAIN_LOGIN_CONTROLADOR = DB_MAIN;//LA BASE DE DATOS QUE ESTE AQUÍ SE EXCEPTÚA EN EL LOGIN CONTROLADOR

    /*
        Para encrptar y Desencriptar
        Nota: Estos valores no se deben cambiar, si hay datos en la DB    
    */
    const METHOD = "AES-256-CBC";
    const SECRET_KEY = '$DP_@2020';
    const SECRET_IV = '10172';
    const SISTEMA_PRUEBA = "NO"; //SI o NO

    initConfig(); // Llamar a la función para inicializar la configuración

    function initConfig() {
        // Verificar si la sesión está activa y no ha expirado
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Verificar si $_SESSION['db_cliente'] está definido y no está vacío
            if (isset($_SESSION['db_cliente']) && $_SESSION['db_cliente'] !== "") {
                $db_cliente = $_SESSION['db_cliente'];
            } else {
                $db_cliente = $GLOBALS['DB_MAIN']; // Valor predeterminado si $_SESSION['db_cliente'] no está definido o está vacío
            }
    
            // DATOS DE CONEXIÓN DEL CLIENTE
            $GLOBALS['db'] = $db_cliente;
        } else {
            // La sesión ha expirado, puedes manejar esto de alguna manera, por ejemplo, redirigiendo al usuario a una página de inicio de sesión.
            // Aquí puedes decidir qué hacer en caso de sesión expirada.
            // Por ejemplo, puedes redirigir al usuario a una página de inicio de sesión.
            header("Location: ".SERVERURL);
            exit;
        }
    } 