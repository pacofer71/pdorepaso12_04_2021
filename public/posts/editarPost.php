<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
}
if (!isset($_GET['id'])) {
    header('Location:posts.php');
    die();
}
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use Clases\{Conexion, Posts, Tags, PostsTemas, Users, Navegar};

function mostrarError($txt)
{
    $_SESSION['mensaje'] = $txt;
    header("Location:{$_SERVER['PHP_SELF']}?id={$_GET['id']}");
    die();
}

//Datos para recuperar de este post y rellenar los campos
$idPost = $_GET['id'];
$estePost = new Posts();
$estePost->setId($idPost);
$datos = $estePost->read()->fetch(PDO::FETCH_OBJ);

//datos para marcar sus categorias y pintar las mismas
$cat = new Tags();
$todosTags = $cat->readAll();
$catMarcadas = new PostsTemas();
$catMarcadas->setIdPost($idPost);
$datosCat = $catMarcadas->devolverIdTag(); //es un array



if (isset($_POST['editar'])) {
    //procesamos el form
    $tit = trim($_POST['titulo']);
    $cuerpo = trim($_POST['cuerpo']);
    if (strlen($tit) == 0 || strlen($cuerpo) == 0) {
        MostrarError("Rellene título y cuerpo del post");
    }
    if (!is_array($_POST['categorias'])) {
        MostrarError("Elija al menos una categoría");
    }
    //el campo está bien vamos a guardarlo

    $estePost->setTitulo(ucwords($tit));
    $estePost->setCuerpo(ucfirst($cuerpo));
    $idUser = (new Users())->devolverIdUser($_SESSION['username']);
    //die($idUser);
    $estePost->setIdUser($idUser);
    $estePost->update();
    //vacios todas las categorias del post para volver a ponerlas
    $catMarcadas->resetearIdPost();
    //guardamos cada una de las categorías
    for ($i = 0; $i < count($_POST['categorias']); $i++) {
        $catMarcadas->setIdTag($_POST['categorias'][$i]);
        $catMarcadas->create();
    }
    $dato = null;
    $estePost = null;
    $catMarcadas = null;
    $_SESSION['mensaje'] = "Post Modificado.";
    header("Location:posts.php");
} else {
    //pintamos el form
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Post</title>
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
        <h3 class="text-center mt-3">Editar Post</h3>
        <div class="container mt-3">
            <?php
            require '../resources/mensajes.php';
            ?>
            <form name="nt" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$idPost"; ?>" method="POST">
                <div class="mt-2">
                    <input type="text" name="titulo" value='<?php echo $datos->titulo; ?>' required class="form-control" />
                </div>
                <div class="mt-2">
                    <textarea placeholder="Escribe tu Post" required class="form-control" name="cuerpo"><?php echo $datos->cuerpo; ?></textarea>
                </div>

                <?php
                $cont = 1;
                $abierto = false;
                while ($fila = $todosTags->fetch(PDO::FETCH_OBJ)) {
                    if ($cont % 4 == 0 || $cont == 1) {
                        echo "<div class='mt-2 row'>\n";
                        $abierto = true;
                    }
                    if (in_array($fila->id, $datosCat)) {
                        echo <<< CADENA
                <div class='col-sm'> <input type='checkbox' name='categorias[]' class='form-check-input' value='{$fila->id}' checked> {$fila->categoria}</div>\n
              CADENA;
                    } else {
                        echo <<< CADENA
                <div class='col-sm'> <input type='checkbox' name='categorias[]' class='form-check-input' value='{$fila->id}'> {$fila->categoria}</div>\n
              CADENA;
                    }
                    if ($cont % 3 == 0) {
                        echo "</div>\n";
                        $cont = 0;
                        $abierto = false;
                    }
                    $cont++;
                }
                if ($abierto) echo "</div>";
                ?>

                <div class="mt-3">
                    <input type="submit" name="editar" value="Editar" class="btn btn-success mr-2">
                    <input type="reset" value="Limpiar" class="btn btn-warning mr-2">
                    <a href="posts.php" class="btn btn-primary">Volver</a>
                </div>


            </form>
        </div>
    </body>

    </html>
<?php } ?>