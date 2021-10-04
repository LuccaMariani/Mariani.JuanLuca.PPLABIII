<?php
    require "./clases/ProductoEnvasado.php";

    try
    {
        if(isset($_POST['producto_json']) )
        {
            $producto_json = $_POST['producto_json'];

            $obj = json_decode($producto_json);
        
            $nuevo_producto = new ProductoEnvasado($obj->id,$obj->codigo_barra,$obj->precio,null,$obj->nombre,$obj->origen);
        
            $retornoJSN = new stdClass();
            $retornoJSN->exito = false;
            $retornoJSN->mensaje = "No se pudo modificar el producto.";
        
            if($nuevo_producto->Modificar())
            {
                $retornoJSN->exito = true;
                $retornoJSN->mensaje =  "El producto fue modificado correctamente.";
            }
        
            echo json_encode($retornoJSN);
        }
    }
    catch (Exception $exc)
    {
        echo ($exc->getMessage());
    }
    
?>