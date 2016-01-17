<?php
require './clases/AutoCarga.php';
$sesion = new Session();
if(!$sesion->isLogged()){
    header("Location:login.php");
    exit();
}
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$usuario = $sesion->getUser();
$pkemail = Request::post("pkemail");
$newAlias = Request::post("alias");
$newClave = Request::post("clave");

if($newAlias != "") {
    $usuario->setAlias($newAlias);
}
if($newClave != "") {
    $usuario->setClave(sha1($newClave));
}
$r = $gestor->set($usuario, $pkemail);
$bd->close();
header("Location:index.php?op=editado&r=$r");