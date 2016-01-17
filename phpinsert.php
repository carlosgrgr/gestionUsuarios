<?php
require './clases/AutoCarga.php';
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$sesion = new Session();
if(!$sesion->isLogged()){
    header("Location:login.php");
    exit();
}else{
    $admin = $sesion->getUser();
    $email = $admin->getEmail();
    $status = "SuperUser";
    if($admin->getAdministrador() !== "1" && $admin->getPersonal() !== "1") {
        $sesion->sendRedirect("login.php");
    }
}
$usuario = new Usuario();
$usuario->read();

//comprobar que no exista ya
if($gestor->get($usuario->getEmail())->getEmail() !== null){
    $sesion->sendRedirect("viewinsert.php?error=exist");
}

$usuario->setClave(sha1(Request::post("clave")));
$usuario->setFechaalta(date('Y-m-d'));
if(Request::post("activo") === "1") {
    $usuario->setActivo("1");
}else{
    $usuario->setActivo("0");
}
if(Request::post("personal") === "1") {
    $usuario->setPersonal("1");
}else{
    $usuario->setPersonal("0");
}
if(Request::post("administrador") === "1") {
    $usuario->setAdministrador("1");
}else{
    $usuario->setAdministrador("0");
}
$r = $gestor->insert($usuario);
$bd->close();
if($admin->getAdministrador() == "1"){
    header("Location:indexAdmin.php?creado=$r");
}
if($admin->getPersonal() == "1"){
    header("Location:indexPersonal.php?creado=$r");
}