<?php
    /*
        Parametros de conexión a la DB
    */

    //DATOS DE CONEXION DEL CLIENTE
    const SERVER = "localhost";
    const DB = "clinicarehn_clientes_clinicare";
    const USER = "root";
    const PASS = "Edwin82003%";

    //DATOS DE CONEXION SERVIDOR PRINCIPAL
    const SERVER_MAIN = "localhost";
    const DB_MAIN = "clinicarehn_clientes_clinicare";
    const USER_MAIN = "clinicarehn_clinicare";
    const PASS_MAIN = "Clin1c@r32022#";  

    //BASE DE DATOS EXCEPTION LOGIN CONTROLADOR
    const DB_MAIN_LOGIN_CONTROLADOR = "clinicarehn_clientes_clinicare";//LA BASE DE DATOS QUE ESTE AQUÍ SE EXCEPTÚA EN EL LOGIN CONTROLADOR

    /*
        Para encrptar y Desencriptar
        Nota: Estos valores no se deben cambiar, si hay datos en la DB    
    */
    const METHOD = "AES-256-CBC";
    const SECRET_KEY = '$DP_@2020';
    const SECRET_IV = '10172';
    const SISTEMA_PRUEBA = "SI"; //SI o NO