<?php
$peticionAjax = true;
require_once "../core/configGenerales.php";

if (isset($_POST['colaborador_id']) && isset($_POST['puesto_colaborador']) && isset($_POST['nombre_colaborador']) && isset($_POST['apellido_colaborador']) && isset($_POST['telefono_colaborador'])) {
    require_once "../controladores/colaboradorControlador.php";
    $insVarios = new colaboradorControlador();
    
    echo $insVarios->editar_colaborador_controlador();
} else {
    $missingFields = [];

    if (!isset($_POST['colaborador_id'])) {
        $missingFields[] = "ID del colaborador";
    }
    if (!isset($_POST['puesto_colaborador'])) {
        $missingFields[] = "puesto del colaborador";
    }
    if (!isset($_POST['nombre_colaborador'])) {
        $missingFields[] = "nombre del colaborador";
    }
    if (!isset($_POST['apellido_colaborador'])) {
        $missingFields[] = "apellido del colaborador";
    }
    if (!isset($_POST['telefono_colaborador'])) {
        $missingFields[] = "teléfono del colaborador";
    }

    $missingFieldsText = implode(", ", $missingFields);

    echo "
    <script>
        swal({
            title: 'Error 🚨', 
            content: {
                element: 'span',
                attributes: {
                    innerHTML: 'Faltan los siguientes campos: <b>$missingFieldsText</b>. Por favor, corrígelos.'
                }
            },
            icon: 'error', 
            buttons: {
                confirm: {
                    text: 'Entendido',
                    className: 'btn-danger'
                }
            },
            closeOnEsc: false,
            closeOnClickOutside: false
        });
    </script>";
}