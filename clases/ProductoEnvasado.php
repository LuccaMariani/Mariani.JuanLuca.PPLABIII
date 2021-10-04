<?php

require './clases/AccesoDB.php';
require "./clases/Producto.php";
require "./clases/IParte1.php";
require "./clases/IParte2.php";

class ProductoEnvasado extends Producto implements IParte1, IParte2
{
    
    public $id;
    public $codigo_barra;
    public $precio;
    public $path_foto;

    public function __construct($id = 0, $codigo_barra = 0,$precio = 0,$path_foto = null,$nombre,$origen)
    {
        parent::__construct($nombre,$origen);

        $this->id = $id;
        $this->codigo_barra = $codigo_barra;
        $this->precio = $precio;
        $this->path_foto = $path_foto;
    }

    public function ToJSON()
    {
        $obj = new stdClass();

        $obj->nombre = $this->nombre;
        $obj->origen = $this->origen;
        $obj->id = $this->id;
        $obj->codigo_barra = $this->codigo_barra;
        $obj->precio = $this->precio;
        $obj->path_foto = $this->path_foto;
        
        return json_encode($obj);
    }

    
    public function Agregar()
    {   
        $AccesoDB = AccesoDB::ObjetoAccesoDB();
        
        $sql = "INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) VALUES (:codigo_barra, :nombre, :origen, :precio, :foto)";

        $query = $AccesoDB->RetornarConsulta($sql);
        $query->bindValue(':codigo_barra', $this->codigo_barra, PDO::PARAM_INT);
        $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $query->bindValue(':origen', $this->origen, PDO::PARAM_STR);
        $query->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $query->bindValue(':foto', $this->path_foto, PDO::PARAM_STR);
                
        try{
            $query->execute();
            if($query->rowCount() > 0)
            {
                return true;
            }else{
                return false;
            }
        }catch(Exception $exc){
            echo "Error en el agregar: ".$exc->getMessage();
            return false;
        }
    }

    public static function Traer()
    {
        $AccesoDB = AccesoDB::ObjetoAccesoDB();

        $query = $AccesoDB->RetornarConsulta("SELECT productos.id, productos.codigo_barra, productos.nombre,productos.origen,productos.precio, productos.foto AS path_foto FROM productos");
        
        try{

            $query->execute();
            $datos = $query->fetchAll(PDO::FETCH_OBJ);

            $datosProductos = array();

            foreach ($datos as $item) 
            {   
                $producto = new ProductoEnvasado($item->id,$item->codigo_barra,$item->precio,$item->path_foto,$item->nombre,$item->origen);
                
                array_push($datosProductos,$producto);
            }
            return $datosProductos;            
        }
        catch(Exception $exc){
            echo "Error en el traer: ".$exc->getMessage();
        }
    }


    
    public static function Eliminar($id)
    {
        try
        {   
            $AccesoDB = AccesoDB::ObjetoAccesoDB();

            $query = $AccesoDB->RetornarConsulta("DELETE FROM productos WHERE id = :id");
            $query->bindValue(":id", $id,PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount() > 0)
            {
                return true;
            }else
            {
                return false;
            }

        }catch(Exception $exc)
        {
            echo "Error en el eliminar: ".$exc->getMessage();
            return false;
        }
    }

    public function Modificar()
    {      
        try
        {
            $AccesoDB = AccesoDB::ObjetoAccesoDB();

            $query = $AccesoDB->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigo_barra,  precio = :precio, foto = :foto WHERE id = :id");
        
            $query->bindValue(":id", $this->id, PDO::PARAM_INT);
            $query->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $query->bindValue(":origen", $this->origen, PDO::PARAM_STR);
            $query->bindValue(":codigo_barra", $this->codigo_barra, PDO::PARAM_INT);
            $query->bindValue(":precio", $this->precio, PDO::PARAM_INT);
            $query->bindValue(":foto", $this->path_foto, PDO::PARAM_STR);
  
            $query->execute();

            if($query->rowCount() > 0)
            {
                return true;
            }else{
                return false;
            }

        }
        catch(Exception $exc)
        {
            echo "Error en el modificar: ".$exc->getMessage();
            return false;
        }
    }


}