<?php
namespace Clases;
use Clases\Conexion;
use PDOException;
use PDO;

class PostsTemas extends Conexion{
    private $idTag;
    private $idPost;
    
    public function __construct()
    {
        parent::__construct();
    }
    

    /**
     * Get the value of idTag
     */ 
    public function getIdTag()
    {
        return $this->idTag;
    }
    //--------------------------- CRUD ----------------------------------------------------------
    public function create(){
        $c="insert into poststemas(idTag, idPost) values(:it, :ip)";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([':it'=>$this->idTag, ':ip'=>$this->idPost]);
        }catch(PDOException $ex){
            die("error al relacionar tags y posts: ".$ex->getMessage());
        }
    }
    //-------------------------------------------------------------------------------------------
    public function devolverIdTag(){
        $c="select distinct idTag from poststemas where idPost=:ip";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([':ip'=>$this->idPost]);
        }catch(PDOException $ex){
            die("error al relacionar tags de un posts: ".$ex->getMessage());
        }
        $tags=[];
        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
            $tags[]=$fila->idTag;
        }
        return $tags;
    }
    //-------------------------------------------------------------------------------------------
    public function resetearIdPost(){
        $c="delete from poststemas where idPost=:ip";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([':ip'=>$this->idPost]);
        }catch(PDOException $ex){
            die("error al relacionar tags de un posts: ".$ex->getMessage());
        }

    }
    //------------------------------------------------------------------------------------------
    /**
     * Set the value of idTag
     *
     * @return  self
     */ 
    public function setIdTag($idTag)
    {
        $this->idTag = $idTag;

        return $this;
    }

    /**
     * Get the value of idPost
     */ 
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Set the value of idPost
     *
     * @return  self
     */ 
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;

        return $this;
    }
}