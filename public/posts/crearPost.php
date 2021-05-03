<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
}
require_once dirname(__DIR__, 2)."/vendor/autoload.php";

use Clases\{Conexion, Posts, Tags, PostsTemas, Users, Navegar};
function mostrarError($txt){
    $_SESSION['mensaje']=$txt;
    header("Location:{$_SERVER['PHP_SELF']}");
    die();
}

$esteTag=new Tags();
$todosTags=$esteTag->readAll();
$esteTag=null;

if(isset($_POST['crear'])){
    //procesamos el form
    $tit=trim($_POST['titulo']);
    $cuerpo=trim($_POST['cuerpo']);
    if(strlen($tit)==0 || strlen($cuerpo)==0){
        MostrarError("Rellene título y cuerpo del post");
    }
    if(!is_array($_POST['categorias'])){
        MostrarError("Elija al menos una categoría");
    }
    //el campo está bien vamos a guardarlo
    $post=new Posts();
    $post->setTitulo(ucwords($tit));
    $post->setCuerpo(ucfirst($cuerpo));
    $idUser=(new Users())->devolverIdUser($_SESSION['username']);
    //die($idUser);
    $post->setIdUser($idUser);
    $post->create();
    //Guardo el id del nuevo post
    $id=Conexion::getConexion()->lastInsertId();
    //guardamos cada una de las categorías
    $dato = new PostsTemas();
    for($i=0; $i<count($_POST['categorias']); $i++){
        $dato->setIdPost($id);
        $dato->setIdTag($_POST['categorias'][$i]);
        $dato->create();
    }
    $dato=null;
    $post=null;
    $_SESSION['mensaje']="Post Creado.";
    header("Location:posts.php");


    
    

}
else{
    //pintamos el form
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo tag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
</head>

<body style="background-color: bisque;">
    <?php
      $nav=new Navegar($_SESSION['username']);
      $nav->pintarNav("posts");
    ?>
    <h3 class="text-center mt-3">Post Nuevo</h3>
    <div class="container mt-3">
    <?php
        require dirname(__DIR__).'/resources/mensajes.php';
    ?>
    <form name="nt" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="mt-2">
        <input type="text" name="titulo" placeholder="Título" required class="form-control" />
    </div>
    <div class="mt-2">
        <textarea placeholder="Escribe tu Post" required class="form-control" name="cuerpo"></textarea>
    </div>
    
    <?php
       $cont=1;
       $abierto=false;
        while($fila=$todosTags->fetch(PDO::FETCH_OBJ)){
            if($cont%4==0 || $cont==1){
                echo "<div class='mt-2 row'>\n";
                $abierto=true;
            }
            echo <<< CADENA
              <div class='col-sm'> <input type='checkbox' name='categorias[]' class='form-check-input' value='{$fila->id}'> {$fila->categoria}</div>\n
            CADENA;
            
            if($cont%3==0) {
                echo "</div>\n";
                $cont=0;
                $abierto=false;
            }
            $cont++;
        }
        if($abierto) echo "</div>";
    ?>
    
    <div class="mt-3">
        <input type="submit" name="crear" value="Crear" class="btn btn-success mr-2">
        <input type="reset" value="Limpiar" class="btn btn-warning mr-2">
        <a href="posts.php" class="btn btn-primary">Volver</a>
    </div>
    
    </div>
    </form>
    </div>
</body>
</html>
<?php } ?>