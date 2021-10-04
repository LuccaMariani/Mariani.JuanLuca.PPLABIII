<?php

require_once( "./clases/AccesoDB.php");
require ('./clases/Producto.php');

echo ('Ejecutando Mostrar Cookie...<br>');
try
{

    if(isset($_POST["nombre"]) && isset($_POST["origen"]))
    {
        $origen = $_POST["origen"];
        $nombre = $_POST["nombre"];
        
        
        $producto = new Producto($nombre, $origen);
    
        $retornoJSON = json_decode(Producto::VerificarProductoJSON($producto));
    
        $retornoCookie = new stdClass();
    
        if($retornoJSON->exito == true)
        {
            $valorCookie = "{$producto->nombre}_{$producto->origen}";
            
            if(isset($_COOKIE[$valorCookie]))
            {
                $retornoCookie->exito = true;
                $retornoCookie->mensaje = $_COOKIE[$valorCookie];
            }
            else
            {
                $retornoCookie->exito = true;
                $retornoCookie->mensaje = "Existe el producto, pero no una cookie de este.";
            }
        }
        else
        {
            $retornoCookie->exito = true;
            $retornoCookie->mensaje = "No existe ni la cookie ni el producto";
        }

        echo json_encode($retornoCookie);
    }
    else 
    {
        echo ("No hay nombre ni origen...<br>");
    }    

} 
catch (Exception $exc) {
    echo ($exc->getMessage());
}
?>