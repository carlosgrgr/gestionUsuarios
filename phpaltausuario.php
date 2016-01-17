<?php
session_start();
require './clases/AutoCarga.php';
require_once './clases/Google/autoload.php';
require_once './clases/class.phpmailer.php';  //las últimas versiones también vienen con autoload
$sesion = new Session();
$bd = new DataBase();
$gestor = new ManageUsuario($bd);

//Datos para crear el nuevo usuario
$email = Request::post("email");
$clave = Request::post("clave");
$clave2 = Request::post("clave2");
$alias = $email;
$fechaalta = date('Y-m-d');
$usuario = new Usuario($email, sha1($clave), $alias, $fechaalta);

//Si el email es un email y las claves son iguales, creamos el usuario y le 
//mandamos el correo de validación
if(Filter::isEmail($email) && $clave === $clave2){
    //Se comprueba que no exista en la base de datos el nuevo usuario
    if($gestor->get($email)->getEmail() != null){
        header("Location:altausuario.php?error=exist");
    }else{
        $r = Mail::sendMail($email);//Mandamos el email
        if($r === "SENT") {
            $gestor->insert($usuario); //Se inserta el usuario en la tabla
            $sesion->destroy();
            header("Location:altausuario.php?aviso=enviado");
        }else{
            header("Location:altausuario.php?error=noenviado");
        }
    }
}else{
    header("Location:altausuario.php?error=claves");
}
