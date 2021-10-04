
<?php

class Producto
{
    public $nombre;
    public $origen;

    public function __construct($_nombre, $_origen)
    {
        $this->nombre = $_nombre;
        $this->origen = $_origen;
    }

    public function ToJSON()
    {
        $objeto_json = json_encode($this);

        return $objeto_json;
    }

    public function GuardarJSON($path)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Erro al guardar json.";

        $obj = array();

        $data = file_get_contents($path);

        if($data)
        {   
            $obj = json_decode($data,true);
        }

        array_push($obj, json_encode($this));

        if(file_put_contents($path, json_encode($obj)))
        {
            $retorno->exito = true;
            $retorno->mensaje = "Exito al guardar el json.";
        }

        return json_encode($retorno);
    }


    public static function TraerJSON($path)
    {   

        $productos = array();

        $string_archivo = file_get_contents($path);

        $decodeo = json_decode($string_archivo, true);

        if($decodeo != NULL)
        {
            foreach($decodeo as $item)
            {
                $obj = json_decode($item, true);
                $producto = new Producto($obj["nombre"], $obj["origen"]);
    
                array_push($productos, $producto);
            }
        }
        else
        {
            array_push($productos,array('El archivo productos.json esta vacio') );
        }

        return $productos;
    }

    public static function VerificarProductoJson($producto)
    {
        $cantidad = 0;
        $retorno = new stdClass();
        $retorno->exito = false;

        $array = Producto::TraerJSON('./archivos/productos.json');

        foreach ($array as $element) 
        {
            if ($producto->nombre == $element->nombre && $producto->origen == $element->origen) {

                $cantidad++;
                $retorno->exito = true;
            }
        }

        $retorno->mensaje = "La cantidad de productos registrados con el mismo origen es de: " . $cantidad;

        if ($retorno->exito == false) 
        {   
            try
            {
                $valores = array_count_values($array);
                asort($valores);
                $popular = array_slice(array_keys($valores), 0, 5, true);
                $retorno->mensaje = "El producto mas popular es: " . $popular[0];
            }
            catch(Exception)
            {
                $retorno->mensaje =('Ningun producto concide con ese origen y nombre');
            }
            
        }

        return json_encode($retorno);
    }

}

?>