<?php
require './clases/AutoCarga.php';
$sesion = new Session();
if(!$sesion->isLogged()){
    header("Location:login.php");
    exit();
}
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
if($sesion->getUser()->getAdministrador() !== "1"){
    $sesion->destroy();
    header("Location:login.php");
}
$email = Request::get("email");
$r = $gestor->delete($email);



$bd->close();
//var_dump($bd->getError());

header("Location:indexAdmin.php?op=borrado&r=$r");