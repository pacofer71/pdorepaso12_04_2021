<?php
    require '../vendor/autoload.php';
    use Clases\{Datos, Tags};

    $nu=new Datos('users', 15);
    echo "<h3>Datos Usuarios Creados</h3>";
    $nt=new Datos("tags", 12);
    echo "<h3>Tags Creados</h3>";