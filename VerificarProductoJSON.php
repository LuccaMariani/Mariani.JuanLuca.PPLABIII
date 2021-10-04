<?php

echo ('Ejecutando Verificar Producto JSON...<br>');

try {

    require './clases/Producto.php';

    if (isset($_POST["nombre"])) {
        $nombre = $_POST["nombre"];
    }
    if (isset($_POST["origen"])) {
        $origen = $_POST["origen"];
    }

    if (isset($_POST["nombre"]) && isset($_POST["origen"])) {
        $producto = new Producto($nombre, $origen);

        $retornoJSN = new stdClass();

        $retornoJSN = json_decode(Producto::VerificarProductoJson($producto));

        if ($retornoJSN->exito) {
            $valorCookie = "{$producto->nombre}_{$producto->origen}";

            if (!isset($_COOKIE[$valorCookie])) 
            {
                $fechaActual = date("Y-m-d");

                setcookie($valorCookie, $fechaActual);

                $retornoJSN->exitoCokkie = true;
                $retornoJSN->mensajeCokkie = "La cookie fue agregada con exito";
            } 
            else 
            {
                $retornoJSN->exitoCokkie = false;
                $retornoJSN->mensajeCokkie = "La cookie no fue agregada.";
            }
        }

        echo json_encode($retornoJSN);
    } 
    else 
    {
        echo ("No hay nombre ni origen...<br>");
    }
} 
catch (Exception $exc) {
    echo ($exc->getMessage());
}
