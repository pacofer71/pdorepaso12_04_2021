<?php

namespace Clases;

//require_once './../vendor/autoload.php';

use Clases\Conexion;
use PDOException;

class Posts extends Conexion
{
        private $id;
        private $titulo;
        private $cuerpo;
        private $idUser;
        private $fecha;
        public function __construct()
        {
                parent::__construct();
        }
        //------------------------------ CRUD ----------------------------------------------------------
        public function create()
        {
                $c = "insert into posts(titulo, cuerpo, idUser, fecha) values (:t, :c, :iu, now())";
                //$c="insert into posts(titulo, cuerpo, idUser, fecha) values (\"$this->titulo\", \"$this->cuerpo\", $this->idUser, now())";
                $stmt = parent::$conexion->prepare($c);
                try {
                        $stmt->execute([
                                ':t' => $this->titulo,
                                ':c' => $this->cuerpo,
                                ':iu' => $this->idUser,
                        ]);
                        //$stmt->execute();
                } catch (PDOException $ex) {
                        die("Error al insertar el post: " . $ex->getMessage());
                }
        }
        public function read()
        {
                $c="select distinct posts.*, tags.*, users.* from posts, users, tags, poststemas  where posts.id=:ip AND posts.idUser=users.id AND posts.id=poststemas.idPost AND tags.id=poststemas.idTag";
                $stmt = parent::$conexion->prepare($c);
                try {
                        $stmt->execute([
                               ':ip'=>$this->id
                        ]);
                        //$stmt->execute();
                } catch (PDOException $ex) {
                        die("Error detalles post: " . $ex->getMessage());
                }
                return $stmt;
        }
        public function update()
        {
                $u="update posts set titulo=:t, cuerpo=:c where id=:i";
                $stmt = parent::$conexion->prepare($u);
                try {
                        $stmt->execute([
                               ':t'=>$this->titulo,
                               ':c'=>$this->cuerpo,
                               ':i'=>$this->id
                        ]);
                        //$stmt->execute();
                } catch (PDOException $ex) {
                        die("Error update posts " . $ex->getMessage());
                }
        }
        public function delete()
        {
                $del="delete from posts where id=:i";
                $stmt = parent::$conexion->prepare($del);
                try {
                        $stmt->execute([':i'=>$this->id]);
                } catch (PDOException $ex) {
                        die("Error al borrar posts: " . $ex->getMessage());
                }
        }
        public function deleteAll()
        {
                $del = "delete from posts";
                $stmt = parent::$conexion->prepare($del);
                try {
                        $stmt->execute();
                } catch (PDOException $ex) {
                        die("Error al borrar todos los posts: " . $ex->getMessage());
                }
        }
        public function readAll()
        {
                $i = "select posts.*, username from posts, users where posts.idUser=users.id";
                $stmt = parent::$conexion->prepare($i);
                try {
                        $stmt->execute();
                } catch (PDOException $ex) {
                        die("Error al crear Tag: " . $ex->getMessage());
                }
                return $stmt;
        }
        public function postsPorTag($n){
                $i = "select distinct posts.*, username from posts, users, tags, poststemas where posts.idUser=users.id AND categoria=:c and idPost=posts.id AND idTag=tags.id";
                $stmt = parent::$conexion->prepare($i);
                try {
                        $stmt->execute([':c'=>$n]);
                } catch (PDOException $ex) {
                        die("Error al recuperar posts categorias: " . $ex->getMessage());
                }
                return $stmt;
        }
        public function postsPorUsuario($u){
                $i = "select distinct posts.*, categoria from posts, users, tags, poststemas where posts.idUser=users.id AND username=:u and idPost=posts.id AND idTag=tags.id";
                $stmt = parent::$conexion->prepare($i);
                try {
                        $stmt->execute([':u'=>$u]);
                } catch (PDOException $ex) {
                        die("Error al recuperar posts usuarios: " . $ex->getMessage());
                }
                return $stmt;
        }
       

        //--------------------------------------------------------------------------------------------
        /**
         * Get the value of id
         */
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of titulo
         */
        public function getTitulo()
        {
                return $this->titulo;
        }

        /**
         * Set the value of titulo
         *
         * @return  self
         */
        public function setTitulo($titulo)
        {
                $this->titulo = $titulo;

                return $this;
        }

        /**
         * Get the value of idUser
         */
        public function getIdUser()
        {
                return $this->idUser;
        }

        /**
         * Set the value of idUser
         *
         * @return  self
         */
        public function setIdUser($idUser)
        {
                $this->idUser = $idUser;

                return $this;
        }

        /**
         * Get the value of fecha
         */
        public function getFecha()
        {
                return $this->fecha;
        }

        /**
         * Set the value of fecha
         *
         * @return  self
         */
        public function setFecha($fecha)
        {
                $this->fecha = $fecha;

                return $this;
        }

        /**
         * Get the value of cuerpo
         */
        public function getCuerpo()
        {
                return $this->cuerpo;
        }

        /**
         * Set the value of cuerpo
         *
         * @return  self
         */
        public function setCuerpo($cuerpo)
        {
                $this->cuerpo = $cuerpo;

                return $this;
        }
}
