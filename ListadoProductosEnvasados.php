<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 
<?php

    require "./clases/ProductoEnvasado.php";

    if(isset($_GET['tabla']))
    {
        $tabla = $_GET['tabla'];
    }

    if($tabla == "mostrar")
    {
        $datos_array = ProductoEnvasado::Traer();

        echo "<table border='2px black;''>                
                <tr>
                    <td>
                       ID
                    </td>
                    <td>
                        Nombre
                    </td>
                    <td>
                        Codigo Barra
                    </td>
                    <td>
                        Nombre Origen
                    </td>
                    <td>
                        Precio
                    </td>
                    <td>
                        Foto
                    </td>

                </tr>";

        foreach($datos_array as $item)
        {
            $item->path_foto = './'.$item->path_foto;

            echo "<tr>
                    <td>
                        $item->id
                    </td>
                    <td>
                        $item->nombre
                    </td>
                    <td>
                        $item->codigo_barra
                    </td>
                    <td>
                        $item->origen
                    </td>
                    <td>
                        $item->precio
                    </td>
                    <td>
                        <img src=./".$item->path_foto." width='50' height='50'>
                    </td>
                  </tr>";
        }
    }else{
        echo json_encode(ProductoEnvasado::Traer());
    }

?>

</body>
</html>
