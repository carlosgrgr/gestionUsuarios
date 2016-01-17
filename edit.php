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
$usuario = $sesion->getUser();
$email = $usuario->getEmail();
$alias = $usuario->getAlias();
$fecha = $usuario->getFechaalta();
$status = "usuario";
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
                <p>Status: <?= $status; ?></p>
            </aside>
            
            <section class="action">
                <h1>Editar datos de <?= $alias; ?></h1>
                <form class="change" action="phpedit.php" method="post">
                <div class="u-form-group">
                    <p>Alias: <input type="text" name="alias" value="<?php echo $usuario->getAlias(); ?>"  /></p>
                </div>
                <div class="u-form-group">
                    <p>Contraseña: <input type="password" name="clave" value="" /></p>
                </div>
                <p>Aviso: Dejar el campo vacío si no quiere cambiarlo</p>
                <input type="hidden" name="pkemail" value="<?php echo $usuario->getEmail(); ?>"/>
                <div class="u-form-group">
                    <input type="submit" value="Editar"/>
                    <a class="red" href="index.php">Cancelar</a>
                </div>
            </form>
            </section>
        </div>
    </body>
</html>
<?php
$bd->close();
