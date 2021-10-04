<?php
    class AccesoDB
    {
        private static $accesoDB;
        private $objetoPDO;

        public function __construct()
        {
            try
            {
                $user = 'root';
                $pass = '';

                $this->objetoPDO = new PDO("mysql:host=localhost; dbname=productos_bd",$user,$pass);
            }
            catch(Exception $exc)
            {
                echo $exc->getMessage();
            }
        }

        public function RetornarConsulta($sql)
        {
            return $this->objetoPDO->prepare($sql);
        }

        public static function ObjetoAccesoDB()
        {

            if(!isset(self::$accesoDB))
            {
                return self::$accesoDB = new AccesoDB();
            }

            return self::$accesoDB;
        }

        public function __clone()
        {
            trigger_error('La clonacion de este objeto no esta permitida.',E_USER_ERROR);
        }
    }
?>