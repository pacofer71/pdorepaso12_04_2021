<?php
    namespace Clases;
    require '../vendor/autoload.php';
    use Faker\Factory;
    
    class Datos{
        public $faker;
        public function __construct(string $tabla, int $cant)
        {
            
            $this->faker=Factory::create('es_ES');
            switch($tabla){
                case "users": 
                    $this->crearUsers($cant);
                    break;
                case "tags": 
                    $this->crearTags($cant);
                    break;    
                default: 
                    die("Error la tabla NO existe !!!!");

            }
        }
        public function crearUsers(int $n){
            $usuario=new Users();
            $usuario->deleteAll();
            $this->crearAdmin($usuario);
            for($i=0; $i<$n; $i++){
                $usuario->setNombre($this->faker->firstName());
                $usuario->setApellidos($this->faker->lastName()." ".$this->faker->lastName());
                $usuario->setPass($this->faker->word());
                $usuario->setUsername($this->faker->unique()->userName());
                $usuario->setMail($this->faker->unique()->freeEmail());
                $usuario->create();
            }
            
            $usuario=null;
        }
        public function crearAdmin(Users $usuario){
            $usuario->setNombre("Francisco");
            $usuario->setApellidos("Fernandez Collado");
            $usuario->setUsername("admin");
            $usuario->setMail("pacofer71@gmail.com");
            $usuario->setPass("secret0");
            $usuario->create();
        }
        // ---------------------------------------------
        public function crearTags($n){
            $cat=["Informática", "Anime", "Terror", "Música", "Juegos", "Programación", "SmartPhones", "Matemáticas", "Física"];
            $tag=new Tags();
            $tag->borrarTodo();
            for($i=0; $i<count($cat); $i++){
                $tag->setCategoria($cat[$i]);
                $tag->create();
            }
            $tag=null;
        }


    }
    
