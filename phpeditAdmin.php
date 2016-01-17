<?php
require './clases/AutoCarga.php';
$sesion = new Session();
if(!$sesion->isLogged()){
    header("Location:login.php");
    exit();
}
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$usuario = $sesion->get("usuario");
$pkemail = Request::post("pkemail");
$newAlias = Request::post("alias");
if(Request::post("clave") != null) {
    $newClave = Request::post("clave");
    $usuario->setClave(sha1($newClave));
}else{
    $newClave = $usuario->getClave();
    $usuario->setClave($newClave);
}
$usuario->setAlias($newAlias);
$usuario->setActivo(Request::post("activo"));
$usuario->setPersonal(Request::post("personal"));
$usuario->setAdministrador(Request::post("administrador"));
$usuario->setEmail(Request::post("email"));
$r = $gestor->set($usuario, $pkemail);
$bd->close();
header("Location:indexAdmin.php?editado=$r");