<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
    die();
}
if (!isset($_GET['id'])) {
    header('Location:posts.php');
    die();
}
$id = $_GET['id'];
require_once dirname(__DIR__, 2)."/vendor/autoload.php";

use Clases\Posts;

$post = new Posts();
$post->setId($id);
$aux=$post->read();
$datos=$aux->fetch(PDO::FETCH_OBJ);
$post = null;
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <title>Tags</title>
</head>

<body style="background-color: bisque;">
    <?php
    require "../resources/nav.php";
    ?>
    <h3 class="text-center mt-3">Detalle Post</h3>

    <div class="container mt-3 mb-4">
        <?php require '../resources/mensajes.php'; ?>
        <div class="card m-auto" style="width: 32rem">
            <div class="card-body">
                <h5 class="card-title text-center"><?php echo $datos->titulo; ?></h5>
                <h6 class="card-subtitle my-2 text-muted"><?php
                echo "Autor: {$datos->apellidos}, {$datos->nombre} <a href='postsporusuario.php?username={$datos->username}'>(#{$datos->username})</a>";
                ?></h6>
                <p class="card-text">
                   <p class="font-weight-bold"><strong>Contenido</strong></p>
                   <?php echo $datos->cuerpo; ?>
                   
                <p><strong>Tags</strong></p>
                <a href="postsporcategoria.php?cat=<?php echo $datos->categoria; ?>" class="card-link"><?php echo "#".$datos->categoria; ?></a>
                <?php
                while($fila=$aux->fetch(PDO::FETCH_OBJ)){
                    echo "<a href='postsporcategoria.php?cat={$fila->categoria}' class='card-link'>#{$fila->categoria}</a>";
                }
                ?>
            </div>
        </div>
        <div class="mt-2 text-center"> <a href="javascript:history.back(-1);" class="btn btn-success my-3"><i class="fas fa-backward"></i> Volver</a></div>
    </div>
</body>

</html>