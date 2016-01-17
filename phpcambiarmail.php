<?php
require './clases/AutoCarga.php';
require_once './clases/Google/autoload.php';
require_once './clases/class.phpmailer.php';
$sesion = new Session();
if(!$sesion->isLogged()){
    header("Location:login.php");
    exit();
}
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$usuario = $sesion->getUser();
$newMail = Request::post("newMail");
$pkemail = Request::post("pkemail");
$clave = Request::post("clave");
if($usuario->getClave() != sha1($clave)){
    $sesion->sendRedirect("cambiarmail.php?error=clave");
}
if($gestor->get($newMail)->getEmail() != null){
    $sesion->sendRedirect("cambiarmail.php?error=mail");
}

$r = Mail::sendMail($newMail);
if($r === "SENT") {
    $usuario->setEmail($newMail);
    $usuario->setActivo(0);
    $gestor->set($usuario, $pkemail);
    $sesion->destroy();
    header("Location:altausuario.php?aviso=enviado");
}else{
    header("Location:altausuario.php?error=noenviado");
}