
<?php

echo ('Ejecutando Alta Producto JSON...<br>');
require './clases/Producto.php';

try {

    if(isset($_POST["nombre"]) && isset($_POST["origen"]))
    {
        $origen = $_POST["origen"];
        $nombre = $_POST["nombre"];

        $producto = new Producto($nombre, $origen);

        $array = $producto->GuardarJSON('./archivos/productos.json');
    
        echo json_encode($array);
    }
    else
    {
        echo("No hay nombre ni origen...<br>");
    }

} catch (Exception $exc) {
    echo ($exc->getMessage());
}



?>