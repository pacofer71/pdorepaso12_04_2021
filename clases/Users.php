<?php
namespace Clases;
use Clases\Conexion;
use PDOException;
use PDO;

class Users extends Conexion{
    private $id;
    private $nombre;
    private $apellidos;
    private $mail;
    private $username;
    private $pass;

    public function __construct(){
        parent::__construct();
    }
    //CRUD ----------------------------------------------------
    public function create(){
        $in="insert into users(nombre, apellidos, username, mail,  pass) values(:n, :a, :u, :m, :p)";
        $pass=hash('sha256', $this->pass);
        $stmt=parent::$conexion->prepare($in);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':u'=>$this->username,
                ':m'=>$this->mail,
                ':p'=>$pass
            ]);
        }catch(PDOException $ex){
            die("Error al insertar usuarios !!!! ".$ex->getMessage());
        }

    }
    public function read(){

    }
    public function update(){

    }
    public function delete(){

    }
    public function deleteAll(){
        $del = "delete from users";
        $stmt=parent::$conexion->prepare($del);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al borrar todos los usuarios: ". $ex->getMessage());
        }
    }
    //---------------------------------------------------------------------------------------------
    public function validar($u, $pss): bool{
        $p=hash('sha256', $pss);
        $con="select * from users where username=:u AND pass=:p";
        $stmt=parent::$conexion->prepare($con);
        try{
            $stmt->execute([':u'=>$u, ':p'=>$p]);
        }catch(PDOException $ex){
            die("Error al comprobar username y pass: ".$ex->getMessage());
        }
        $fila=$stmt->fetch(PDO::FETCH_OBJ);
        return ($fila!=null) ? true : false;
    }
    //---------------------------------------------------------------------------------------------
    public function devolverIdUser($n){
        $c="select id from users where username=:un";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([':un'=>$n]);
        }catch(PDOException $ex){
            die("Error al comprobar username y pass: ".$ex->getMessage());
        }
        return ($stmt->fetch(PDO::FETCH_OBJ))->id;
        

    }
    //-----------------------------------------------------------------------------------------------
    public function setId(int $id){
        $this->id=$id;
    }
    public function setNombre(string $n){
        $this->nombre=$n;
    }

    public function setApellidos(string $a){
        $this->apellidos=$a;
        
    }
    public function setUsername(string $un){
        $this->username=$un;
    }
    public function setPass(string $pass){
        $this->pass=$pass;
    }
    public function setMail($m){

        $this->mail=$m;
    }
    public function arrayIds(){
        $c = "select id from users";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute();
        }catch(PDOException $ex){

        }
        $todosId=[];
        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
            $todosId[]=$fila->id;
        }
        return $todosId;

    }
    //-------------------------------------------------------------------------------------------------------------------------

}