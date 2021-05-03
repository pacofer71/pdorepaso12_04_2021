<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
    header("Location:../login.php");
    die();
}
if(!isset($_GET['cat'])){
    header("Location:posts.php");
    die();
}
require dirname(__DIR__, 2)."/vendor/autoload.php";

use Clases\Posts;
$cat=$_GET['cat'];

$posts = new Posts();
$todos = $posts->postsPorTag($cat);
$posts = null;
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
    <h3 class="text-center mt-3">Posts de <?php echo $cat ?></h3>

    <div class="container mt-3 mb-4">
     <?php require '../resources/mensajes.php'; ?>
     <a href="javascript:history.back(-1);" class="btn btn-success my-3"><i class="fas fa-backward"></i> Volver</a>
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th scope="col">Detalles</th>
                    <th scope="col" class='text-center'>Titulo</th>
                    <th scope="col" class='text-center'>Contenido</th>
                    <th scope="col" class='text-center'>Usuario</th>
                    <th scope="col" class='text-center' colspan=2>Acciones</th>


                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $todos->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr class='align-middle'>";
                    echo "<th scope='row'> <a href='detallePost.php?id={$fila->id}' class='btn btn-primary'>Detalles</a></th>";
                    echo "<td class='text-center'>$fila->titulo</td>";
                    echo "<td class='text-justify'>$fila->cuerpo</td>";
                    echo "<td class='text-center'>$fila->username</td>";
                    echo "<td>";
                    echo "<a href='editarPost.php?id={$fila->id}' class='btn btn-warning'><i class='far fa-edit'></i> Editar</a>";
                    echo "<td class='text-center'>";
                    echo <<< CADENA
                    <form name="a" method="POST" action="borrarPost.php" class="inline">
                    <input type="hidden" name="id" value="{$fila->id}" />
                    <button type="submit" class="btn btn-danger" onsubmit="return confirm('Borrar Tag')"><i class="fas fa-trash-alt"></i> Borrar</button>
                    </form>
                    CADENA;
                    echo "</td>";
                    echo "</tr>" . PHP_EOL;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>