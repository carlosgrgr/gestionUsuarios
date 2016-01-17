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
$pkemail = $usuario->getEmail();
$usuario->setActivo("0");
$r = $gestor->set($usuario, $pkemail);
$bd->close();
$sesion->destroy();
header("Location:index.php?r=$r");