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
$email = $usuario->getEmail();
$alias = $usuario->getAlias();
$fecha = $usuario->getFechaalta();
$status = "usuario";
if($usuario->getPersonal() == 1 && $usuario->getAdministrador() == 0){
    $sesion->sendRedirect("indexPersonal.php");
}
if($usuario->getAdministrador() == 1) {
    $sesion->sendRedirect("indexAdmin.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!--
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="144315405047-hu44apt2g5q2akupkjalbk66ctmm0irb.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        -->
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <script type="text/javascript" src="js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="js/javascript.js"></script>
        <title>Iniciar Sesión</title>
    </head>
    <body>
        <div class="wrap">
            <aside class="profile">
                <img src="images/user.jpg" />
                <p>Email: <?= $email; ?></p>
                <p>Alias: <?= $alias; ?></p>
                <p>Fecha de alta: <?= $fecha; ?></p>
                <p>Estatus: <?= $status; ?></p>
            </aside>
            
            <section class="action">
                <h1>Bienvenido <?= $alias; ?></h1>
                <section class="enlaces">
                    <a href="edit.php">Editar datos</a>
                    <a href="cambiarmail.php">Cambiar email</a>
                    <!--<a href="uploadFile.php">Subir imagen</a>-->
                    <a class="red" href="phplogout.php">Log Out</a>
                    <a class="red" href="phpdeleteaccount.php">Delete Account</a>
                </section>
            </section>
        </div>
    </body>
</html>

