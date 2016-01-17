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
    $status;
    if($admin->getAdministrador() === "1") {
        $status = "SuperUser";
    }else{
        if($admin->getPersonal() === "1") {
            $status = "Personal";
        }
    }
    $status = "SuperUser";
    if($admin->getAdministrador() !== "1" && $admin->getPersonal() !== "1") {
        $sesion->sendRedirect("login.php");
    }
}
$usuario = $gestor->get(Request::get("email"));
$sesion->set("usuario", $usuario);

//Gestionando errores
switch(Request::get("error")){
    case "exist":
        $error = "Ese email ya está asociado a una cuenta";
        if(session_status() == 2){
            $sesion->destroy();
        }
        break;
}
//Gestionando avisos
switch(Request::get("aviso")){
    case "creada":
        $aviso = "La cuenta se ha creado con éxito";
        if(session_status() == 2) {
            $sesion->destroy();
        }
        break;
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
                <p>Alias: <?= $admin->getAlias(); ?></p>
                <p>Fecha de alta: <?= $admin->getFechaalta(); ?></p>
                <p>Status: <?= $status; ?></p>
            </aside>
            
            <section class="action">
                <h1>Nuevo Usuario</h1>
                <form class="email-login" action="phpeditAdmin.php" method="POST">
                    <div class="u-form-group">
                        Email: <input type="email" value="<?= $usuario->getEmail() ?>" name="email" require />
                        <input type="hidden" name="pkemail" value="<?= $usuario->getEmail() ?>" />
                    </div>
                    <div class="u-form-group">
                        Contraseña: <input type="password" name="clave" value=""/>
                    </div>
                    <div class="u-form-group">
                        Alias: <input type="text" value="<?= $usuario->getAlias() ?>" name="alias" value="" require />
                    </div>
                    <div class="u-form-group">
                        <input type="checkbox" name="activo" value="1" <?php if($usuario->getActivo()==1){echo 'checked';} ?> />Activo
                    </div>
                <?php
                if($status === "Administrador"){
                ?>
                    <div class="u-form-group">
                        <input type="checkbox" name="personal" value="1" <?php if($usuario->getPersonal()==1){echo 'checked';} ?> />Personal
                    </div>
                    <div class="u-form-group">
                        <input type="checkbox" name="administrador" value="1" <?php if($usuario->getAdministrador()==1){echo 'checked';} ?> />Administrador
                    </div>
                <?php } ?>
                    <div class="u-form-group">
                        <p>Si no desea modificar la contraseña, deje el campo vacío</p>
                    </div>
                    <div class="u-form-group">
                        <input type="submit" value="Insertar" />
                        <a class="red" href="indexPersonal.php">Cancelar</a>
                    </div>
                    <div class="u-form-group">
                        <p class="error"><?= $error ?></p>
                        <p class="aviso"><?= $aviso ?></p>
                    </div>
                </form>
            </section>
    </body>
</html>

<?php
$bd->close();
