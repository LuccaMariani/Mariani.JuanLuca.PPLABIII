<?php
    require "./clases/ProductoEnvasado.php";

    try
    {
        if(isset($_POST['producto_json']) )
        {
  
            $producto_json = $_POST['producto_json'];

            $obj = json_decode($producto_json);
    
            $retornoJSN = new stdClass();
            $retornoJSN->exito = false;
            $retornoJSN->mensaje = "No se pudo eliminar el producto.";
    
            $path = './archivos/productos_eliminados.json';
    
            if(ProductoEnvasado::Eliminar($obj->id))
            {
                $new_producto = new Producto($obj->nombre,$obj->origen);
                $new_producto->GuardarJSON($path);
                $retornoJSN->exito = true;
                $retornoJSN->mensaje = "El producto fue eliminado correctamente.";
            }
    
            echo json_encode($retornoJSN);
        }

    }
    catch (Exception $exc) {
        echo ($exc->getMessage());
    }
?>