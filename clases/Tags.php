<?php

namespace Clases;

use Clases\Conexion;
use PDOException;
use PDO;

class Tags extends Conexion
{
    private $id;
    private $categoria;

    public function __construct()
    {
        parent::__construct();
    }
    public function setId(int $i)
    {
        $this->id = $i;
    }
    public function setCategoria(string $n)
    {
        $this->categoria = $n;
    }
    //------------------CRUD-----------------------------
    public function create()
    {
        $i = "insert into tags(categoria) values(:c)";
        $stmt = parent::$conexion->prepare($i);
        try {
            $stmt->execute([':c' => $this->categoria]);
        } catch (PDOException $ex) {
            die("Error al crear Tag: " . $ex->getMessage());
        }
    }
    public function read()
    {
    }
    public function update()
    {
    }
    public function delete()
    {
        $del = "delete from tags where id=:id";
        $stmt = parent::$conexion->prepare($del);
        try {
            $stmt->execute([':id'=>$this->id]);
        } catch (PDOException $ex) {
            die("Error al borrar el Tag: " . $ex->getMessage());
        }
    }
    public function borrarTodo()
    {
        $del = "delete from tags";
        $stmt = parent::$conexion->prepare($del);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al borrar todos los tags: " . $ex->getMessage());
        }
    }
    public function readAll()
    {

        $i = "select * from tags";
        $stmt = parent::$conexion->prepare($i);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al crear Tag: " . $ex->getMessage());
        }
        return $stmt;
    }
    //----------------------------------------------------------------------------------
    public function arrayIds()
    {
        $c = "select id from tags";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
        }
        $todosId = [];
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $todosId[] = $fila->id;
        }
        return $todosId;
    }
}
