<?php
namespace Clases;
use PDO;
use PDOException;

class Conexion{
    protected static $conexion;

    public function __construct()
    {
        if(self::$conexion==null){
            self::crearConexion();
        }    
    }
    private static function crearConexion(){
       
        $opciones=parse_ini_file(dirname(__DIR__)."/.config");
        $base=$opciones["base"];
        $pass=$opciones["pass"];
        $user=$opciones["usuario"];
        $host=$opciones["host"];
        //Creamos el dsn con los paramtetros adecuados
        $dsn="mysql:host=$host;dbname=$base;charset=utf8mb4";
        try{
            self::$conexion=new PDO($dsn, $user, $pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            die("Error al conectar a la bbdd, ".$ex->getMessage());
        }

    }
    public static function getConexion(){
        return self::$conexion;
    }
}