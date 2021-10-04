<?php

try {

    
    require "./clases/ProductoEnvasado.php";

    if(isset($_POST["producto_json"]))
    {
    
        $producto_json = $_POST["producto_json"];

        $obj = json_decode($producto_json);

        $new_producto = new ProductoEnvasado(0,$obj->codigoBarra,$obj->precio,null,$obj->nombre,$obj->origen);

        $retornoJSN = new stdClass();
        $retornoJSN->exito = false;
        $retornoJSN->mensaje = "Error al agregar el Producto Envasado.";

        if($new_producto->Agregar())
        {
            $retornoJSN->exito = true;
            $retornoJSN->mensaje = "Se agrego el Producto Envasado correctamente.";
        }

        echo json_encode($retornoJSN);

    }
    else
    {
        echo("No hay un 'producto_json' ...<br>");
    }

} catch (Exception $exc) {
    $exc->getMessage();
}

?>