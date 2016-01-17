<?php
require './clases/AutoCarga.php';
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$email = Request::get("email");
$sha1 = Request::get("sha1");

if(sha1($email . Constants::SEMILLA) === $sha1) {
    echo sha1($email . Constants::SEMILLA);
    $usuario = new Usuario();
    $usuario = $gestor->get($email);
    $usuario -> setActivo(1);
    $r = $gestor -> set($usuario, $email);
    echo $r;
    header("Location:login.php?aviso=activada");
} else {
    header("Location:login.php?error=noactivada");
}
