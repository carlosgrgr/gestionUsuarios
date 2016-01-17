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
    if($admin->getAdministrador() !== "1") {
        $sesion->sendRedirect("login.php");
    }
}

//paginación
$page = Request::get("page");
if ($page === null || $page === "") {
    $page = 1;
}

$order = Request::get("order");
$sort = Request::get("sort");
$orden = "$order $sort";
$nrpp = Request::get("nrpp");

$registros = $gestor->count();
$pages = ceil($registros / Constants::NRPP);

if ($nrpp === "" || $nrpp === null) {
    $nrpp = Constants::NRPP;
}
$queryString = "";
if (trim($page) != "") {
    $queryString = "&nrpp=$nrpp";
}
$usuarios = $gestor->getList($page, trim($orden), $nrpp);


//Gestionando errores
if(Request::get("editado") == "-1"){
    $error = "No ha podido editarse el usuario";
}
if(Request::get("editado") == "0"){
    $aviso = "Usuario editado";
}
if(Request::get("creado") == "-1"){
    $error = "No ha podido crear el usuario";
}
if(Request::get("creado") == "0"){
    $aviso = "Usuario creado";
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
            <section class="profile">
                <img src="images/user.jpg" />
                <p>Email: <?= $email; ?></p>
                <p>Alias: <?= $admin->getAlias(); ?></p>
                <p>Fecha de alta: <?= $admin->getFechaalta(); ?></p>
                <p>Estatus: <?= $status; ?></p>
            </section>
            <section class="action">
                <h1>Bienvenido <?= $admin->getAlias(); ?></h1>
                <article class="enlaces">
                    <a href="editAdmin.php">Editar mis datos</a>
                    <!--<a href="uploadFile.php">Subir imagen</a>-->
                    <a href="viewinsert.php">Nuevo usuario</a>
                    <a class="red" href="phplogout.php">Log Out</a>
                </article>
                <section class="info">
                    <p class="error"><?= $error ?></p>
                    <p class="aviso"><?= $aviso ?></p> 
                </section>
            </section>
            
        </div>
        <table class="table-fill">
            <tr>
                <th>Email</th>
                <th>Alias</th>
                <th>Fecha de alta</th>
                <th>Activo</th>
                <th>Administrador</th>
                <th>Personal</th>
                <th colspan="2">Acciones</th>
            </tr>
            <tfoot>
                <tr>
                    <td>
                        <span id="page"><?= "Página $page de ".  ceil($registros/$nrpp) ?></span>
                    </td>
                    <td class="paginacion" colspan="5">
                        <a href="?<?= $queryString ?>">Primero</a>
                        <a href="?page=<?= max(1, $page - 1) . $queryString ?>">Anterior</a>
                        <a href="?page=<?= min($page + 1, $pages) . $queryString; ?>">Siguiente</a>
                        <a href="?page=<?= ceil($registros/$nrpp) . $queryString; ?>">Última</a>
                    </td>
                    <td colspan="2">
                        <span>Total: <?= $bd->count("usuario") ?></span>
                    </td>
                </tr>
            </tfoot>
            <?php
            foreach ($usuarios as $indice => $usuario) {
                ?>
            <tr>
                <td><?php echo $usuario->getEmail(); ?></td>
                <td><?php echo $usuario->getAlias(); ?></td>
                <td><?php echo $usuario->getFechaalta(); ?></td>
                <td><?php echo $usuario->getActivo(); ?></td>
                <td><?php echo $usuario->getAdministrador(); ?></td>
                <td><?php echo $usuario->getPersonal(); ?></td>
                <td class="accion"><?php echo "<a class='editar' href='vieweditAdmin.php?email={$usuario->getEmail()}'><img src='../images/edit.png'/></a>"; ?></td>
                <td class="accion"><?php echo "<a class='borrar' href='phpdelete.php?email={$usuario->getEmail()}'><img src='../images/deleteN.png'/></a> "; ?></td>
                <?php
                }
                ?>
            </tr>
        </table>
        <script src="js/scripts.js"></script>
    </body>
</html>
