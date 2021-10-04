<?php

require './clases/Producto.php';

echo ('Ejecutando Listado Producto JSON...<br>');

echo json_encode(Producto::TraerJSON('./archivos/productos.json'));

?>