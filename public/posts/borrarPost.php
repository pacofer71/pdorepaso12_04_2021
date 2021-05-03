<?php
//die("Location:../login.php");
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin" || !isset($_POST['id'])) {
    header("Location:../login.php");
    die();
}
require_once dirname(__DIR__, 2)."/vendor/autoload.php";

use Clases\Posts;
$post = new Posts();
$post->setId($_POST['id']);
$post->delete();
$post=null;
$_SESSION['mensaje']="Post Borrado !!!";
header("Location:posts.php");
