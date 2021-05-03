<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin" || !isset($_POST['id'])) {
    header("Location:../login.php");
    die();
}
require_once dirname(__DIR__, 2)."/vendor/autoload.php";

use Clases\Tags;

$temas = new Tags();
$temas->setId($_POST['id']);
$temas->delete();
$temas=null;
$_SESSION['mensaje']="Tag Borrado !!!";
header("Location:tags.php");
