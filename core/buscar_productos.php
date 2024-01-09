<?php
if (isset($_POST["searchText"])) {
    $peticionAjax = true;
    require_once "configGenerales.php";
    require_once "mainModel.php";

    $insMainModel = new mainModel();
    
    $searchText = $_POST["searchText"];

    // Función para buscar clientes por nombre
    function buscarProductos($nombre) {
        global $insMainModel;

        // Realizar la consulta usando el método de mainModel
        $resultados = $insMainModel->getProductosLike($nombre);

        return $resultados;
    }

    // Realizar la búsqueda y enviar los resultados como HTML
    $productos = buscarProductos($searchText);

    if($clientes->num_rows>0){
        foreach ($productos as $producto) {
            echo "<li>" . $producto["nombre"] . "</li>";
        }
    }else{
        echo "<li style='color: red;'>No se encontraron resultados</li>";
    }
}
?>