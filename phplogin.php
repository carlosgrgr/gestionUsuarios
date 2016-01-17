<?php
require './clases/AutoCarga.php';
$bd = new DataBase();
$sesion = new Session();
$gestor = new ManageUsuario($bd);
$email = Request::post("email");
$clave = Request::post("clave");
$usuario = $gestor->get($email);
$email = $usuario->getEmail();



//si el usuario no existe
if($email === null){
    header("Location:login.php?error=exist");
}else if(sha1($clave) !== $usuario->getClave()){
    header("Location:login.php?error=clave");
}else if($usuario->getActivo() === "0"){
    header("Location:login.php?error=activo");
}else{
    $sesion->setUser($usuario);
    if($usuario->getAdministrador() === "1"){
        $sesion->sendRedirect("indexAdmin.php");
    }
    if($usuario->getPersonal() === "1") {
        $sesion->sendRedirect("indexPersonal.php");
    }
    $sesion->sendRedirect("index.php");
}