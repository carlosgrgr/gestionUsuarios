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
$status = "Personal";
if($usuario->getPersonal() == 0) {
    $sesion->sendRedirect("index.php");
}
if($usuario->getAdministrador() == 1) {
    $sesion->sendRedirect("indexAdmin.php");
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
                    <a href="viewinsert.php">Nuevo usuario</a>
                    <!--<a href="uploadFile.php">Subir imagen</a>-->
                    <a class="red" href="phplogout.php">Log Out</a>
                    <a class="red" href="phpdeleteaccount.php">Delete Account</a>
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
                <th>Acciones</th>
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
                    <td>
                        <span>Total: <?= $bd->count("usuario") ?></span>
                    </td>
                </tr>
            </tfoot>
            <?php
            foreach ($usuarios as $indice => $usuario) {
                if($usuario->getAdministrador() !== "1") {
                ?>
            <tr>
                <td><?php echo $usuario->getEmail(); ?></td>
                <td><?php echo $usuario->getAlias(); ?></td>
                <td><?php echo $usuario->getFechaalta(); ?></td>
                <td><?php echo $usuario->getActivo(); ?></td>
                <td><?php echo $usuario->getAdministrador(); ?></td>
                <td><?php echo $usuario->getPersonal(); ?></td>
                <td class="accion"><?php echo "<a class='editar' href='vieweditAdmin.php?email={$usuario->getEmail()}'><img src='../images/edit.png'/></a>"; ?></td>
                <?php
                }
            }
                ?>
            </tr>
        </table>
    </body>
</html>

