<?php
namespace Clases;
class Navegar{
    public $usuario;
    public static $inicio = <<< CADENA
        <nav class="navbar navbar-expand-lg navbar-light bg-light m-3">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Posts</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Gestionar Sitio
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        CADENA;   
    public static $medio = <<< CADENA
        </ul>
        </li>
        </ul>
        <form class="d-flex" method="POST" action="kill.php">
        CADENA;
       
        public static $final = <<< CADENA
        <button class="btn btn-outline-success" type="submit">Salir</button>
        </form>
        </div>
        </div>
        </nav>
        CADENA;  
    public function __construct($u)
    {
        $this->usuario=$u;
    }   

    public function pintarNav($dir){
        switch($dir){
            case "public":
                $this->pintar1() ;
                break;
            case "posts": 
                $this->pintar2();
                break;
            case "tags": 
                $this->pintar3();
                break;
                
        }
    }
    public function pintar1(){
        echo self::$inicio;
        echo <<< CADENA
        <li><a class="dropdown-item" href="./posts/posts.php">Posts</a></li>
        <li><a class="dropdown-item" href="./tags/tags.php">Tags</a></li>
        <li><a class="dropdown-item" href="#">Usuarios</a></li>
        CADENA; 
        echo self::$medio;
      
        echo  "<input class='form-control me-2 col-xs-2' type='text' value='{$this->usuario}' placeholder='Search' aria-label='Search' disabled>";
        echo self::$final;
       

    }
    public function pintar2(){
        echo self::$inicio;
        echo <<< CADENA
        <li><a class="dropdown-item" href="posts.php">Posts</a></li>
        <li><a class="dropdown-item" href="../tags/tags.php">Tags</a></li>
        <li><a class="dropdown-item" href="#">Usuarios</a></li>
        CADENA; 
        echo self::$medio;
       
        echo  "<input class='form-control me-2 col-xs-2' type='text' value='{$this->usuario}' placeholder='Search' aria-label='Search' disabled>";
        echo self::$final;
    }  
    public function pintar3(){
        echo self::$inicio;
        echo <<< CADENA
        <li><a class="dropdown-item" href="../posts/posts.php">Posts</a></li>
        <li><a class="dropdown-item" href="tags.php">Tags</a></li>
        <li><a class="dropdown-item" href="#">Usuarios</a></li>
        CADENA; 
        echo self::$medio;
       
        echo  "<input class='form-control me-2 col-xs-2' type='text' value='{$this->usuario}' placeholder='Search' aria-label='Search' disabled>";
        echo self::$final;

    }
    
}