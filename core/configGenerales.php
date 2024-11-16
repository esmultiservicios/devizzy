<?php
    // Detecta la URL base automáticamente
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $path = '/devizzy/';
    define("SERVERURL", $protocol . "://" . $host . $path);

    // PATH IMAGES
    define("PRODUCT_PATH", "/devizzy/vistas/plantilla/img/products/");
    define("COMPANY", "IZZY :: CLINICARE");

    date_default_timezone_set("America/Tegucigalpa");